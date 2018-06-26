<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360Contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class TransactionsController extends AppController
{
    public $name = 'Transactions';
    public $uses = array(
        'Transaction',
    );
    public $helpers = array(
        'Csv'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
        )
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'Transaction.user_id',
        );
        parent::beforeFilter();
    }
    public function index()
    {
		$this->_redirectPOST2Named(array(
            'Transaction.from_date',
            'Transaction.to_date'
        ));
        $this->pageTitle = __l('My Transactions');
        $conditions['Transaction.user_id'] = $this->Auth->user('id');
        $blocked_conditions['UserCashWithdrawal.user_id'] = $this->Auth->user('id');
        if (!empty($this->request->data['Transaction']['from_date']['year']) && !empty($this->request->data['Transaction']['from_date']['month']) && !empty($this->request->data['Transaction']['from_date']['day'])) {
            $this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
        }
        if (!empty($this->request->data['Transaction']['to_date']['year']) && !empty($this->request->data['Transaction']['to_date']['month']) && !empty($this->request->data['Transaction']['to_date']['day'])) {
            $this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
        }
        if (isset($this->request->data['Transaction']['from_date']) and isset($this->request->data['Transaction']['to_date'])) {
            $from_date = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
            $to_date = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->request->data)) {
            if ($from_date < $to_date) {
                $blocked_conditions['UserCashWithdrawal.created >='] = $conditions['Transaction.created >='] = $from_date;
                $blocked_conditions['UserCashWithdrawal.created <='] = $conditions['Transaction.created <='] = $to_date;
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'all') {
            $this->request->data['Transaction']['filter'] = 'all';
        }
		if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $credit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $debit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now')) . ' 00:00:00';
            $this->pageTitle.= __l(' - today');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $credit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $debit_conditions['Transaction.created >= '] = date('Y-m-d', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - in this week');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = date("Y-01-01");
            $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = date("Y-12-31");
            $conditions['Transaction.created >='] = $credit_conditions['Transaction.created >='] = $debit_conditions['Transaction.created >='] = date("Y-m-01");
            $conditions['Transaction.created <='] = $credit_conditions['Transaction.created <='] = $debit_conditions['Transaction.created <='] = date("Y-m-t");
            $this->pageTitle.= __l(' - in this month');
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'TransactionType',
                'User',
				'Contest' => array(
					'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username'
                        )
                    ) ,
				),
            ) ,
            'order' => array(
                'Transaction.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        $transactions = $this->paginate();
		$credit_conditions['OR'][] = array('Transaction.user_id' => $this->Auth->user('id'), 'TransactionType.is_credit' => 1);		
		
		$debit_conditions['OR'][] = array('Transaction.user_id' => $this->Auth->user('id'), 'TransactionType.is_credit' => 0);		
		unset($conditions['OR']);
        $this->set('transactions', $transactions);
        // To get commission percentage
		$credit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
				$credit_conditions,
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'group' => array(
                'Transaction.user_id'
            ) ,
            'recursive' => 0
        ));
		$credit1 = !empty($credit[0]['total_amount']) ? $credit[0]['total_amount'] : 0;
		$debit = $this->Transaction->find('first', array(
            'conditions' => array(
                $conditions,
                $debit_conditions
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_amount'
            ) ,
            'group' => array(
                'Transaction.user_id'
            ) ,
            'recursive' => 0
        ));
		$debit1 = !empty($debit[0]['total_amount']) ? $debit[0]['total_amount'] : 0;
		$debit2 = $credit2 = 0;
		if (isPluginEnabled('Withdrawals')) {
			$withdrawalTransactions = $this->Transaction->find('all', array(
				'conditions' => array(
					$conditions,
					'Transaction.transaction_type_id' => array(
						ConstTransactionTypes::UserWithdrawalRequest,
						ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest,
						ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest,
						ConstTransactionTypes::FailedWithdrawalRequestRefundToUser,
						ConstTransactionTypes::AcceptCashWithdrawRequest,
					)
				) ,
				'fields' => array(
					'DISTINCT(Transaction.foreign_id)'
				) ,
				'recursive' => 0
			));
			if (!empty($withdrawalTransactions)) {
				$userCashWithdrawalIds = array();
				foreach($withdrawalTransactions as $withdrawalTransaction) {
					$userCashWithdrawalIds[] = $withdrawalTransaction['Transaction']['foreign_id'];
				}
				$this->loadModel('Withdrawal.UserCashWithdrawal');
				$userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
					'conditions' => array(
						'UserCashWithdrawal.id' => $userCashWithdrawalIds
					) ,
					'fields' => array(
						'UserCashWithdrawal.amount',
						'UserCashWithdrawal.withdrawal_status_id',
					) ,
					'recursive' => -1
				));
				foreach($userCashWithdrawals as $userCashWithdrawal) {
					if (in_array($userCashWithdrawal['UserCashWithdrawal']['withdrawal_status_id'], array(ConstWithdrawalStatus::Rejected, ConstWithdrawalStatus::Failed))) {
						$credit2 += $userCashWithdrawal['UserCashWithdrawal']['amount'];
					} else {
						$debit2 += $userCashWithdrawal['UserCashWithdrawal']['amount'];
					}
				}
			}
		}
        $from = $this->Transaction->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Transaction.created'
            ) ,
            'limit' => 1,
            'recursive' => -1
        ));
        $to = $this->Transaction->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Transaction.created'
            ) ,
            'limit' => 1,
            'order' => array(
                'Transaction.id desc'
            ) ,
            'recursive' => -1
        ));
        $this->set('duration_from', $from['Transaction']['created']);
        $this->set('duration_to', $to['Transaction']['created']);
        $this->set('total_credit_amount', $credit1 + $credit2);
        $this->set('total_debit_amount', $debit1 + $debit2);
        if (isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')) {
            $this->loadModel('Withdrawals.UserCashWithdrawal');
            $blocked_amount = $this->UserCashWithdrawal->find('first', array(
                'conditions' => $blocked_conditions,
                'fields' => array(
                    'SUM(UserCashWithdrawal.amount) as total_amount'
                ) ,
                'group' => array(
                    'UserCashWithdrawal.user_id'
                ) ,
                'recursive' => -1
            ));
            $this->set('blocked_amount', !empty($blocked_amount[0]['total_amount']) ? $blocked_amount[0]['total_amount'] : 0);
            $user = $this->Transaction->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            $this->set('user', $user);
        }
        $filter = array(
            'all' => __l('All') ,
            'day' => __l('Today') ,
            'week' => __l('This Week') ,
            'month' => __l('This Month') ,
            'custom' => __l('Custom') ,
        );
        if ($this->RequestHandler->isAjax()) {
            $this->set('isAjax', true);
        } else {
            $this->set('isAjax', false);
        }
        $this->set('filter', $filter);
    }
    public function admin_index()
    {
		$this->_redirectGET2Named(array(
            'user_id',
            'username',
            'contest_id',
            'name',
			'filter'
        ));
        $this->pageTitle = __l('Transactions');
        $conditions = array();
        $post = 1;
        if (!empty($this->request->data['Transaction']['user_id'])) {
            $this->request->params['named']['user_id'] = $this->request->data['Transaction']['user_id'];
			$user = $this->Transaction->User->find('first', array(
				'conditions' => array(
					'User.id' =>  $this->request->data['Transaction']['user_id']
				),
				'recursive' => -1
			));
			$this->request->data['User']['username'] = $user['User']['username'];
        }
        if (!empty($this->request->data['Transaction']['from_date']['year']) && !empty($this->request->data['Transaction']['from_date']['month']) && !empty($this->request->data['Transaction']['from_date']['day'])) {
            $this->request->params['named']['from_date'] = $this->request->data['Transaction']['from_date']['year'] . '-' . $this->request->data['Transaction']['from_date']['month'] . '-' . $this->request->data['Transaction']['from_date']['day'] . ' 00:00:00';
        }
        if (!empty($this->request->data['Transaction']['to_date']['year']) && !empty($this->request->data['Transaction']['to_date']['month']) && !empty($this->request->data['Transaction']['to_date']['day'])) {
            $this->request->params['named']['to_date'] = $this->request->data['Transaction']['to_date']['year'] . '-' . $this->request->data['Transaction']['to_date']['month'] . '-' . $this->request->data['Transaction']['to_date']['day'] . ' 23:59:59';
        }
        $this->set('credit_type', 'is_credit');
        $is_credit = 'is_credit';
        if (empty($this->request->params['named']['filter'])) {
			$is_credit = 'is_credit_to_admin';
            $this->set('credit_type', 'is_credit_to_admin');
			$conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
			$conditions['OR'][]['Transaction.transaction_type_id'] = array(
				ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest,
				ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest,
				ConstTransactionTypes::FailedWithdrawalRequestRefundToUser,
				ConstTransactionTypes::AcceptCashWithdrawRequest,
				ConstTransactionTypes::AddFundToWallet,
				ConstTransactionTypes::DeductFundFromWallet,
				ConstTransactionTypes::SiteCommisionDeductUsingMarketplace,
				ConstTransactionTypes::ParticipantCommisionDeductUsingMarketplace,
				ConstTransactionTypes::ContestFeaturesUpdated,
				ConstTransactionTypes::ContestTimeExtended,
				ConstTransactionTypes::SignupFee,
				ConstTransactionTypes::NewContestAdded,
				ConstTransactionTypes::AmountAddedToWallet,
			);
			$debit_conditions['OR'][]['Transaction.user_id'] = ConstUserIds::Admin;
        } 
		$credit_conditions['TransactionType.'. $is_credit] = 1;
		$debit_conditions['TransactionType.'. $is_credit] = 0;
        $param_string = '';
        $param_string.= !empty($this->request->params['named']['user_id']) ? '/user_id:' . $this->request->params['named']['user_id'] : $param_string;
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['Transaction.user_id'] = $this->request->params['named']['user_id'];
            $this->request->data['Transaction']['user_id'] = $this->request->params['named']['user_id'];
            $user = $this->Transaction->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user_id'],
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username',
                ) ,
                'recursive' => -1
            ));
            if (!empty($user)) {
                $this->set('username', $user['User']['username']);
            }
        }
        if (!empty($this->request->data['User']['username'])) {
            $get_user_id = $this->Transaction->User->find('list', array(
                'conditions' => array(
                    'User.username' => $this->request->data['User']['username'],
                ) ,
                'fields' => array(
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_user_id)) {
                $conditions['Transaction.user_id'] = $get_user_id;
				$credit_conditions['Transaction.user_id'] = $get_user_id;
				$debit_conditions['Transaction.user_id'] = $get_user_id;
            }
        }
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['Transaction.user_id'] = array(
                $this->request->params['named']['user_id']
            );
        }
        if (!empty($this->request->params['named']['type'])) {
            $conditions['Transaction.transaction_type_id'] = $this->request->params['named']['type'];
        }
        if (!empty($this->request->params['named']['stat'])) {
            if (!empty($this->request->params['named']['stat'])) {
                if ($this->request->params['named']['stat'] == 'day') {
					$conditions['Transaction.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
					$conditions['Transaction.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
                    $this->pageTitle = __l('Transactions - Today');
                    $this->set('transaction_filter', __l('- Today'));
                    $days = 0;
                } else if ($this->request->params['named']['stat'] == 'week') {
					$conditions['Transaction.created <= '] = date('Y-m-d H:is', strtotime('now'));
					$conditions['Transaction.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
                    $this->pageTitle = __l('Transactions - This Week');
                    $this->set('transaction_filter', __l('- This Week'));
                    $days = 7;
                } else if ($this->request->params['named']['stat'] == 'month') {
					$conditions['Transaction.created <= '] = date('Y-m-d H:is', strtotime('now'));
					$conditions['Transaction.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
                    $this->pageTitle = __l('Transactions - This Month');
                    $this->set('transaction_filter', __l('- This Month'));
                    $days = 30;
                } else {
                    $this->pageTitle = __l('Transactions - Total');
                    $this->set('transaction_filter', __l('- Total'));
                }
            }
        }
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            if ($this->request->params['named']['from_date'] < $this->request->params['named']['to_date']) {
                $conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                $conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
				$credit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                $credit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
				$debit_conditions['Transaction.created >='] = $this->request->params['named']['from_date'];
                $debit_conditions['Transaction.created <='] = $this->request->params['named']['to_date'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        if ($this->RequestHandler->prefers('csv')) {
            Configure::write('debug', 0);
            $this->set('transactions', $this);
            $this->set('conditions', $conditions);
        } else {
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'TransactionType',
                    'User',
					'Contest' => array(
						'User' => array(
							'fields' => array(
								'User.id',
								'User.username'
							)
						) ,
					),
                ) ,
                'order' => array(
                    'Transaction.id' => 'desc'
                ) ,
                'recursive' => 3
            );
            $this->set('transactions', $this->paginate());
            $users = $this->Transaction->User->find('list', array(
                'conditions' => array(
                    'User.role_id !=' => ConstUserTypes::Admin
                ) ,
                'order' => array(
                    'User.username' => 'asc'
                ) ,
				'recursive' => -1
            ));
            $this->set('users', $users);
            $this->Transaction->validate = array();
            $this->Transaction->User->validate = array();
            $this->set('param_string', $param_string);
			// To get commission percentage
			$credit1 = $this->Transaction->find('first', array(
				'conditions' => $credit_conditions ,
				'fields' => array(
					'SUM(Transaction.amount) as total_amount'
				) ,
				'recursive' => 0
			));
			$credit1 = !empty($credit1[0]['total_amount']) ? $credit1[0]['total_amount'] : 0;
			$debit1 = $this->Transaction->find('first', array(
				'conditions' => $debit_conditions ,
				'fields' => array(
					'SUM(Transaction.amount) as total_amount'
				) ,
				'recursive' => 0
			));
			$debit1 = !empty($debit1[0]['total_amount']) ? $debit1[0]['total_amount'] : 0;
			$debit2 = $credit2 = 0;
			if (isPluginEnabled('Withdrawals')) {
				$withdrawalTransactions = $this->Transaction->find('all', array(
					'conditions' => array(
						$conditions,
						'Transaction.transaction_type_id' => array(
							ConstTransactionTypes::UserWithdrawalRequest,
							ConstTransactionTypes::AmountApprovedForUserCashWithdrawalRequest,
							ConstTransactionTypes::AmountRefundedForRejectedWithdrawalRequest,
							ConstTransactionTypes::FailedWithdrawalRequestRefundToUser,
							ConstTransactionTypes::AcceptCashWithdrawRequest,
						)
					) ,
					'fields' => array(
						'DISTINCT(Transaction.foreign_id)'
					) ,
					'recursive' => 0
				));
				if (!empty($withdrawalTransactions)) {
					$userCashWithdrawalIds = array();
					foreach($withdrawalTransactions as $withdrawalTransaction) {
						$userCashWithdrawalIds[] = $withdrawalTransaction['Transaction']['foreign_id'];
					}
					$this->loadModel('Withdrawals.UserCashWithdrawal');
					$userCashWithdrawals = $this->UserCashWithdrawal->find('all', array(
						'conditions' => array(
							'UserCashWithdrawal.id' => $userCashWithdrawalIds
						) ,
						'fields' => array(
							'UserCashWithdrawal.amount',
							'UserCashWithdrawal.withdrawal_status_id',
						) ,
						'recursive' => -1
					));
					foreach($userCashWithdrawals as $userCashWithdrawal) {
						if (in_array($userCashWithdrawal['UserCashWithdrawal']['withdrawal_status_id'], array(ConstWithdrawalStatus::Rejected, ConstWithdrawalStatus::Failed))) {
							$credit2 += $userCashWithdrawal['UserCashWithdrawal']['amount'];
						} else {
							$debit2 += $userCashWithdrawal['UserCashWithdrawal']['amount'];
						}
					}
				}
			}
			$this->set('total_credit_amount', $credit1 + $credit2);
			$this->set('total_debit_amount', $debit1 + $debit2);
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Transaction->del($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Transaction')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>