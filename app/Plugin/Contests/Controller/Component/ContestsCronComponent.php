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
class ContestsCronComponent extends Component
{
    public function main()
    {
        App::import('Model', 'Contests.Contest');
        $this->Contest = new Contest();
        $conditions = array();
        if (isPluginEnabled('Sudopay')) {
			// Change contest status to paid to participant
			$contests = $this->Contest->find('all', array(
				'conditions' => array(
					'Contest.contest_status_id' => ConstContestStatus::Completed
				) ,
				'contain' => array(
					'ContestUser' => array(
						'conditions' => array(
							'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
						)
					)
				) ,
				'recursive' => 2
			));
			App::import('Model', 'Sudopay.SudopayPaymentGateway');
			$this->SudopayPaymentGateway = new SudopayPaymentGateway();
			$sudopayPaymentGateway = $this->SudopayPaymentGateway->find('list', array(
				'fields' => array(
					'SudopayPaymentGateway.sudopay_gateway_id',
					'SudopayPaymentGateway.days_after_amount_paid'
				) ,
				'recursive' => -1
			));
			$completedContests = array();
			foreach($contests as $contest) {
				$days = 0;
				if(!empty($contest['Contest']['sudopay_gateway_id'])) {
					$days = $sudopayPaymentGateway[$contest['Contest']['sudopay_gateway_id']];
				}
				if(time() > strtotime($contest['Contest']['completed_date'] ." +$days day")) {
					$completedContests[] = $contest;
				}
			}
			if (!empty($completedContests)) {
				foreach($completedContests as $contest) {
					$this->Contest->updateStatus(ConstContestStatus::PaidToParticipant, $contest['Contest']['id']);
				}
			}
		}
        $contests = array();
        // Change the contest status to judging
        $conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
		$conditions['Contest.end_date <= '] = date('Y-m-d 23:55:59');
        $contests = $this->Contest->find('all', array(
            'conditions' => $conditions,
            'fields' => array(
                'Contest.id',
                'Contest.contest_status_id',
                'Contest.user_id',
                'Contest.contest_user_count',
				'Contest.end_date'
            ) ,
            'recursive' => -1
        ));
        foreach($contests as $contest) {
				$this->Contest->updateStatus(ConstContestStatus::Judging, $contest['Contest']['id']);
        }
        // Change the contest status to Pending Action to Admin
        $conditions = array();
        $contests = array();
        $conditions['Contest.contest_status_id'] = ConstContestStatus::Judging;
        $contests = $this->Contest->find('all', array(
            'conditions' => array(
                'Contest.contest_status_id' => array(
                    ConstContestStatus::Judging,
                    ConstContestStatus::WinnerSelected,
                    ConstContestStatus::ChangeCompleted
                )
            ) ,
            'fields' => array(
                'Contest.id',
                'Contest.contest_status_id',
                'Contest.user_id',
                'Contest.contest_user_count',
				'Contest.end_date',
				'Contest.winner_selected_date',
				'Contest.change_completed_date'
            ) ,
            'recursive' => -1
        ));
        foreach($contests as $contest) {
            if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging) {
                $_Data = array();
                if (strtotime($contest['Contest']['end_date'] . ' 23:55:59' . '+' . Configure::read('contest.judging_to_winner_selected_days'). 'days') < strtotime(date('Y-m-d 23:55:59'))) {
					$_Data['Contest']['id'] = $contest['Contest']['id'];
					$_Data['Contest']['is_pending_action_to_admin'] = 1;
					$this->Contest->save($_Data);
                }
            } else if ($contest['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelected) {
                $_Data = array();
                if (strtotime($contest['Contest']['winner_selected_date'] . ' 23:55:59' . '+' . Configure::read('contest.winner_selected_to_completed_days'). 'days') < strtotime(date('Y-m-d 23:55:59'))) {
					$_Data['Contest']['id'] = $contest['Contest']['id'];
					$_Data['Contest']['is_pending_action_to_admin'] = 1;
					$this->Contest->save($_Data);
                }
            } else if ($contest['Contest']['contest_status_id'] == ConstContestStatus::ChangeCompleted) {
                $_Data = array();
                if (strtotime($contest['Contest']['change_completed_date'] . ' 23:55:59' . '+' . Configure::read('contest.change_completed_to_completed_days'). 'days') < strtotime(date('Y-m-d 23:55:59'))) {
					$_Data['Contest']['id'] = $contest['Contest']['id'];
					$_Data['Contest']['is_pending_action_to_admin'] = 1;
					$this->Contest->save($_Data);
                }
            }
        }
    }
    public function daily()
    {
        App::import('Model', 'Contests.Contest');
        $this->Contest = new Contest();
        $conditions = array();
        $conditions['Contest.contest_status_id'] = ConstContestStatus::PaymentPending;
		$conditions['Contest.created <= '] = date('Y-m-d H:i:s', strtotime('now -1 days'));
        $conditions['Contest.is_send_payment_notification'] = 0;
        $contests = $this->Contest->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (!empty($contests)) {
            foreach($contests as $contest) {
                $emailFindReplace = array(
                    '##CONTEST_NAME##' => $contest['Contest']['name'],
                    '##USERNAME##' => $contest['User']['username'],
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug'],
                        'admin' => false
                    ) , true) ,
                    '##PENDING_PAYMENT_DAYS##' => Configure::read('contest.contest_payment_pending_days_limit') ,
                    '##PENDING_PAYMENT_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'prizing_selection',
                        $contest['Contest']['id'],
                        'admin' => false
                    ) , true) ,
                );
                if ($this->Contest->_checkUserNotifications($contest['User']['id'], 'is_payment_pending_alert_to_participant')) {
                    App::import('Model', 'EmailTemplate');
					$this->EmailTemplate = new EmailTemplate();
					$template = $this->EmailTemplate->selectTemplate('Payment pending alert mail to Contest holder');
					$this->Contest->_sendEmail($template, $emailFindReplace, $contest['User']['email']);
                }
                $_data = array();
                $_data['Contest']['id'] = $contest['Contest']['id'];
                $_data['Contest']['is_send_payment_notification'] = 1;
                $this->Contest->save($_data);
            }
        }
        //if the contest is in payment pending status, the contest leads to auto delete
        $conditiondel = array();
        $conditiondel['Contest.contest_status_id'] = ConstContestStatus::PaymentPending;
		$conditiondel['Contest.created <= '] = date('Y-m-d H:i:s', strtotime('now'));
		$conditiondel['Contest.created >= '] = date('Y-m-d 00:00:00', strtotime('now -'. Configure::read('contest.contest_payment_pending_days_limit') .' days'));
        $conditiondel['Contest.is_send_payment_notification'] = 1;
        $contests = array();
        $contests = $this->Contest->find('all', array(
            'conditions' => $conditiondel,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (!empty($contests)) {
            foreach($contests as $contest) {
                if ($this->Contest->delete($contest['Contest']['id'])) {
                    $this->Contest->updateCountInUser($contest['Contest']['user_id'], $contest['Contest']['contest_status_id']);
                }
            }
        }
    }
}
