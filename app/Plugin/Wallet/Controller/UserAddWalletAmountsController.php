<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class UserAddWalletAmountsController extends AppController
{
    public $name = 'UserAddWalletAmounts';
    public function admin_index()
    {
        $this->pageTitle = __l('User Add Wallet Amounts');
        $this->UserAddWalletAmount->recursive = 0;
        $this->set('userAddWalletAmounts', $this->paginate());
    }
    public function admin_add_fund($id = null)
    {
        $this->pageTitle = __l('Add Fund');
        if (!empty($this->request->data['Transaction']['user_id'])) {
            $id = $this->request->data['Transaction']['user_id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserAddWalletAmount->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            ) ,
            'recursive' => 0
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $user['User']['username'];
        if (!empty($this->request->data)) {
            $this->request->data['Transaction']['foreign_id'] = ConstUserIds::Admin;
            $this->request->data['Transaction']['class'] = 'SecondUser';
            $this->request->data['Transaction']['transaction_type_id'] = ConstTransactionTypes::AddFundToWallet;
            if ($this->UserAddWalletAmount->User->Transaction->save($this->request->data['Transaction'])) {
                $this->UserAddWalletAmount->User->updateAll(array(
                    'User.available_wallet_amount' => 'User.available_wallet_amount +' . $this->request->data['Transaction']['amount'],
                ) , array(
                    'User.id' => $this->request->data['Transaction']['user_id']
                ));
                $user_add_wallet = $this->UserAddWalletAmount->find('first', array(
                    'conditions' => array(
                        'UserAddWalletAmount.user_id' => $this->request->data['Transaction']['user_id']
                    ) ,
                    'recursive' => 1
                ));
                $this->request->data['UserAddWalletAmount']['is_success'] = 1;
                if (!empty($this->request->data['UserAddWalletAmount']['description'])) {
                    $this->request->data['UserAddWalletAmount']['description'] = $this->request->data['Transaction']['description'];
                } else {
                    $this->request->data['UserAddWalletAmount']['description'] = $user_add_wallet['UserAddWalletAmount']['description'];
                }
                if (!empty($user_add_wallet['UserAddWalletAmount']['user_id'])) {
                    $this->request->data['UserAddWalletAmount']['id'] = $user_add_wallet['UserAddWalletAmount']['id'];
                    $this->request->data['UserAddWalletAmount']['user_id'] = $user_add_wallet['UserAddWalletAmount']['user_id'];
                    $this->request->data['UserAddWalletAmount']['amount'] = $user_add_wallet['UserAddWalletAmount']['amount']+$this->request->data['Transaction']['amount'];
                } else {
                    $this->request->data['UserAddWalletAmount']['user_id'] = $this->request->data['Transaction']['user_id'];
                    $this->request->data['UserAddWalletAmount']['amount'] = $this->request->data['Transaction']['amount'];
                }
                $this->UserAddWalletAmount->save($this->request->data);
                $this->Session->setFlash(__l('Fund has been added successfully') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Fund')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['Transaction']['user_id'] = $id;
        }
        $this->set('user', $user);
    }
    public function admin_deduct_fund($id = null)
    {
        $this->pageTitle = __l('Deduct Fund');
        if (!empty($this->request->data['Transaction']['user_id'])) {
            $id = $this->request->data['Transaction']['user_id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->UserAddWalletAmount->User->find('first', array(
            'conditions' => array(
                'User.id' => $id
            ) ,
            'recursive' => 0
        ));
        if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle.= ' - ' . $user['User']['username'];
        if (!empty($this->request->data)) {
            $user = $this->UserAddWalletAmount->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['Transaction']['user_id']
                ),
				'recursive' => -1
            ));
            $this->UserAddWalletAmount->User->Transaction->set($this->request->data);
            $this->UserAddWalletAmount->User->Transaction->validates();
            if ($user['User']['available_wallet_amount'] < $this->request->data['Transaction']['amount']) {
                $this->Session->setFlash(__l('Deduct amount should be less than the available wallet amount') , 'default', null, 'error');
            } else {
                $this->request->data['Transaction']['foreign_id'] = ConstUserIds::Admin;
                $this->request->data['Transaction']['class'] = 'SecondUser';
                $this->request->data['Transaction']['transaction_type_id'] = ConstTransactionTypes::DeductFundFromWallet;
                if ($this->UserAddWalletAmount->User->Transaction->save($this->request->data['Transaction'])) {
                    $this->UserAddWalletAmount->User->updateAll(array(
                        'User.available_wallet_amount' => 'User.available_wallet_amount -' . $this->request->data['Transaction']['amount'],
                    ) , array(
                        'User.id' => $this->request->data['Transaction']['user_id']
                    ));
                    $user_add_wallet = $this->UserAddWalletAmount->find('first', array(
                        'conditions' => array(
                            'UserAddWalletAmount.user_id' => $this->request->data['Transaction']['user_id']
                        ) ,
                        'recursive' => 1
                    ));
                    $this->request->data['UserAddWalletAmount']['is_success'] = 1;
                    if (!empty($this->request->data['UserAddWalletAmount']['description'])) {
                        $this->request->data['UserAddWalletAmount']['description'] = $this->request->data['Transaction']['description'];
                    } else {
                        $this->request->data['UserAddWalletAmount']['description'] = $user_add_wallet['UserAddWalletAmount']['description'];
                    }
                    if (!empty($user_add_wallet['UserAddWalletAmount']['user_id'])) {
                        $this->request->data['UserAddWalletAmount']['id'] = $user_add_wallet['UserAddWalletAmount']['id'];
                        $this->request->data['UserAddWalletAmount']['user_id'] = $user_add_wallet['UserAddWalletAmount']['user_id'];
                        $this->request->data['UserAddWalletAmount']['amount'] = $user_add_wallet['UserAddWalletAmount']['amount']-$this->request->data['Transaction']['amount'];
                    } else {
                        $this->request->data['UserAddWalletAmount']['user_id'] = $this->request->data['Transaction']['user_id'];
                        $this->request->data['UserAddWalletAmount']['amount'] = $this->request->data['Transaction']['amount'];
                    }
                    $this->UserAddWalletAmount->save($this->request->data);
                    $this->Session->setFlash(__l('Fund has been deducted successfully') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'index'
                    ));
                } else {
                    $this->Session->setFlash(__l('Fund could not be deducted. Please, try again.') , 'default', null, 'error');
                }
            }
        } else {
            $this->request->data['Transaction']['user_id'] = $id;
        }
        $this->set('user', $user);
    }
}
?>