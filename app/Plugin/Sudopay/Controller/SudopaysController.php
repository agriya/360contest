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
class SudopaysController extends AppController
{
    public function beforeFilter()
    {
        if (in_array($this->request->action, array(
            'success_payment',
            'cancel_payment',
            'process_payment',
            'process_ipn',
            'update_account',
        ))) {
            $this->Security->validatePost = false;
        }
        parent::beforeFilter();
    }
    public function process_payment($foreign_id, $transaction_type)
    {
        $return = $this->Sudopay->processPayment($foreign_id, $transaction_type);
        if (!empty($return)) {
            return $return;
        }
        $this->autoRender = false;
    }
    public function process_ipn($foreign_id, $transaction_type)
    {
        $this->Sudopay->_saveIPNLog();
        $s = $this->Sudopay->getSudoPayObject();
        if ($s->isValidIPNPost($_POST)) {
            $this->_processPayment($foreign_id, $transaction_type, $_POST);
        }
        $this->autoRender = false;
    }
    private function _processPayment($foreign_id, $transaction_type, $post)
    {
        $redirect = '';
        $s = $this->Sudopay->getSudoPayObject();
        switch ($transaction_type) {
            case ConstPaymentType::ContestPrize:
                App::import('Model', 'Contests.Contest');
                $this->Contest = new Contest();
                $_data = array();
                $_data['Contest']['id'] = $foreign_id;
                $_data['Contest']['sudopay_payment_id'] = $post['id'];
                $_data['Contest']['sudopay_pay_key'] = $post['paykey'];
                $this->Contest->save($_data);
                $Contest = $this->Contest->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $foreign_id
                    ) ,
                    'contain' => array(
                        'ContestType'
                    ) ,
                    'recursive' => 0
                ));
                if (!empty($post['status']) && $post['status'] == 'Captured') {
                    $this->Contest->processPayment($foreign_id, $Contest['Contest']['creation_cost'], ConstPaymentGateways::SudoPay, $transaction_type);
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'index',
                        'type' => 'mycontest',
                        'filter_id' => ConstContestStatus::Open
                    ) , true);
                    $this->Sudopay->_savePaidLog($foreign_id, $post, 'Contest');
                }
                if (empty($redirect)) {
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                }
                break;

            case ConstPaymentType::ContestUpgradeFee:
                App::import('Model', 'Contests.Contest');
                $this->Contest = new Contest();
                $_data = array();
                $_data['Contest']['id'] = $foreign_id;
                $_data['Contest']['sudopay_payment_id'] = $post['id'];
                $_data['Contest']['sudopay_pay_key'] = $post['paykey'];
                $this->Contest->save($_data);
                $Contest = $this->Contest->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $foreign_id
                    ) ,
                    'contain' => array(
                        'ContestType'
                    ) ,
                    'recursive' => 0
                ));
                if (!empty($post['status']) && $post['status'] == 'Captured') {
                    $upgrade = unserialize($Contest['Contest']['upgrade']);
                    $this->Contest->processPayment($foreign_id, $upgrade['fee'], ConstPaymentGateways::SudoPay, $transaction_type);
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                    $this->Sudopay->_savePaidLog($foreign_id, $post, 'Contest');
                }
                if (empty($redirect)) {
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                }
                break;

            case ConstPaymentType::ContestExtendTimeFee:
                App::import('Model', 'Contests.Contest');
                $this->Contest = new Contest();
                $_data = array();
                $_data['Contest']['id'] = $foreign_id;
                $_data['Contest']['sudopay_payment_id'] = $post['id'];
                $_data['Contest']['sudopay_pay_key'] = $post['paykey'];
                $this->Contest->save($_data);
                $Contest = $this->Contest->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $foreign_id
                    ) ,
                    'contain' => array(
                        'ContestType'
                    ) ,
                    'recursive' => 0
                ));
                if (!empty($post['status']) && $post['status'] == 'Captured') {
                    $upgrade = unserialize($Contest['Contest']['upgrade']);
                    $this->Contest->processPayment($foreign_id, $upgrade['fee'], ConstPaymentGateways::SudoPay, $transaction_type);
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'index',
                        'type' => 'mycontest',
                        'filter_id' => ConstContestStatus::Open
                    ) , true);
                    $this->Sudopay->_savePaidLog($foreign_id, $post, 'Contest');
                }
                if (empty($redirect)) {
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                }
                break;

            case ConstPaymentType::Wallet:
                if (isPluginEnabled('Wallet')) {
                    $this->loadModel('Wallet.Wallet');
                    $this->loadModel('User');
                    $_data = array();
                    $_data['UserAddWalletAmount']['id'] = $foreign_id;
                    $_data['UserAddWalletAmount']['sudopay_payment_id'] = $post['id'];
                    $_data['UserAddWalletAmount']['sudopay_pay_key'] = $post['paykey'];
                    $this->User->UserAddWalletAmount->save($_data);
                    $userAddWalletAmount = $this->User->UserAddWalletAmount->find('first', array(
                        'conditions' => array(
                            'UserAddWalletAmount.id' => $foreign_id
                        ) ,
                        'contain' => array(
                            'User'
                        ) ,
                        'recursive' => 1,
                    ));
                    if (empty($userAddWalletAmount)) {
                        throw new NotFoundException(__l('Invalid request'));
                    }
                    if (!empty($post['status']) && $post['status'] == 'Captured') {
                        if ($this->Wallet->processAddtoWallet($foreign_id, ConstPaymentGateways::SudoPay)) {
                            $this->Session->setFlash(__l('Amount added to wallet') , 'default', null, 'success');
                            $this->Sudopay->_savePaidLog($foreign_id, $post, 'UserAddWalletAmount');
                        } else {
                            $this->Session->setFlash(__l('Amount could not be added to wallet') , 'default', null, 'error');
                        }
                    } else {
                        $this->Session->setFlash(__l('Amount could not be added to wallet') , 'default', null, 'error');
                    }
                }
                $redirect = Router::url(array(
                    'controller' => 'users',
                    'action' => 'dashboard',
                    'admin' => false,
                ) , true);
                break;

            case ConstPaymentType::SignupFee:
                $this->loadModel('Payment');
                $this->loadModel('User');
                $_data = array();
                $_data['User']['id'] = $foreign_id;
                $_data['User']['sudopay_payment_id'] = $post['id'];
                $_data['User']['sudopay_pay_key'] = $post['paykey'];
                $this->User->save($_data);
                $user = $this->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $foreign_id,
                    ) ,
                    'recursive' => -1,
                ));
                if (!empty($post['status']) && $post['status'] == 'Captured') {
                    App::import('Model', 'Payment');
                    $this->Payment = new Payment();
                    if ($this->Payment->processUserSignupPayment($foreign_id, ConstPaymentGateways::SudoPay)) {
                        if (empty($user['User']['is_openid_register']) && empty($user['User']['is_linkedin_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_googleplus_register']) && empty($user['User']['is_angellist_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register'])) {
                            if (empty($user['User']['is_email_confirmed']) && Configure::read('user.is_admin_activate_after_register') && Configure::read('user.is_email_verification_for_register')) {
                                $this->Session->setFlash(__l('You have paid membership fee successfully. Once you verified your email and administrator approved your account will be activated.') , 'default', null, 'success');
                            } else if (Configure::read('user.is_admin_activate_after_register')) {
                                $this->Session->setFlash(__l('You have paid membership fee successfully, will be activated once administrator approved') , 'default', null, 'success');
                            } else if (empty($user['User']['is_email_confirmed']) && Configure::read('user.is_email_verification_for_register')) {
                                $this->Session->setFlash(sprintf(__l('You have paid membership fee successfully. Now you can login with your %s after verified your email') , Configure::read('user.using_to_login')) , 'default', null, 'success');
                            } else {
                                $this->Session->setFlash(sprintf(__l('You have paid membership fee successfully. Now you can login with your %s') , Configure::read('user.using_to_login')) , 'default', null, 'success');
                            }
                            $this->Auth->logout();
                        } else {
                            if (Configure::read('user.is_admin_activate_after_register')) {
                                $this->Session->setFlash(__l('You have paid membership fee successfully, will be activated once administrator approved') , 'default', null, 'success');
                            } else {
                                $this->Session->setFlash(__l('You have paid membership fee successfully.') , 'default', null, 'success');
                            }
                        }
                        $this->Sudopay->_savePaidLog($foreign_id, $post, 'User');
                    }
                }
                $redirect = Router::url(array(
                    'controller' => 'users',
                    'action' => 'login',
                    'admin' => false
                ) , true);
                break;
            }
            return $redirect;
        }
        public function success_payment($foreign_id, $transaction_type)
        {
            $this->Session->setFlash(__l('Payment successfully completed') , 'default', null, 'success');
            $redirect = $this->_getRedirectUrl($foreign_id, $transaction_type);
            $this->redirect($redirect);
        }
        public function cancel_payment($foreign_id, $transaction_type)
        {
            $this->Session->setFlash(__l('Payment Failed. Please, try again') , 'default', null, 'error');
            $redirect = $this->_getRedirectUrl($foreign_id, $transaction_type);
            $this->redirect($redirect);
        }
        private function _getRedirectUrl($foreign_id, $transaction_type)
        {
            switch ($transaction_type) {
                case ConstPaymentType::ContestPrize:
                    App::import('Model', 'Contests.Contest');
                    $this->Contest = new Contest();
                    $contest = $this->Contest->find('first', array(
                        'conditions' => array(
                            'Contest.id' => $foreign_id
                        ) ,
                        'recursive' => 0
                    ));
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                    break;

                case ConstPaymentType::Wallet:
                    $redirect = Router::url(array(
                        'controller' => 'wallets',
                        'action' => 'add_to_wallet'
                    ) , true);
                    break;

                case ConstPaymentType::SignupFee:
                    $redirect = Router::url(array(
                        'controller' => 'users',
                        'action' => 'register',
                    ) , true);
                    break;

                case ConstPaymentType::ContestUpgradeFee:
                    App::import('Model', 'Contests.Contest');
                    $this->Contest = new Contest();
                    $contest = $this->Contest->find('first', array(
                        'conditions' => array(
                            'Contest.id' => $foreign_id
                        ) ,
                        'recursive' => 0
                    ));
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                    break;

                case ConstPaymentType::ContestExtendTimeFee:
                    App::import('Model', 'Contests.Contest');
                    $this->Contest = new Contest();
                    $contest = $this->Contest->find('first', array(
                        'conditions' => array(
                            'Contest.id' => $foreign_id
                        ) ,
                        'recursive' => 0
                    ));
                    $redirect = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug']
                    ) , true);
                    break;

                default:
                    $redirect = Router::url('/');
                    break;
            }
            return $redirect;
        }
        public function admin_sudopay_admin_info()
        {
            $this->loadModel('Sudopay.SudopayPaymentGateway');
            $this->loadModel('Sudopay.Sudopay');
            $response = $this->Sudopay->GetSudoPayGatewaySettings();
            $this->set('gateway_settings', $response);
            $supported_gateways = $this->SudopayPaymentGateway->find('all', array(
                'recursive' => -1,
            ));
            $used_gateway_actions = array(
                'Marketplace-Auth',
                'Marketplace-Auth-Capture',
                'Marketplace-Void',
                'Marketplace-Capture',
                'Capture'
            );
            $this->set(compact('supported_gateways', 'used_gateway_actions'));
        }
        public function confirmation($foreign_id, $transaction_type)
        {
            if ($transaction_type == ConstPaymentType::ContestPrize) {
                App::uses('Contests.Contest', 'Model');
                $obj = new Contest();
                $Data = $obj->find('first', array(
                    'contain' => array(
                        'Contest',
                        'User',
                    ) ,
                    'conditions' => array(
                        'Contest.id' => $foreign_id
                    ) ,
                    'recursive' => 0
                ));
                $sudopay_token = $Data['Contest']['sudopay_token'];
                $sudopay_revised_amount = $Data['Contest']['sudopay_revised_amount'];
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $Data['User']['email']);
                $amount = $receiver_data['amount']['0'];
            } elseif ($transaction_type == ConstPaymentType::ContestUpgradeFee) {
                App::uses('Contests.Contest', 'Model');
                $obj = new Contest();
                $Data = $obj->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $sudopay_token = $Data['Contest']['sudopay_token'];
                $sudopay_revised_amount = $Data['Contest']['sudopay_revised_amount'];
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $Data['User']['email']);
                $amount = $receiver_data['amount']['0'];
            } elseif ($transaction_type == ConstPaymentType::ContestExtendTimeFee) {
                App::uses('Contests.Contest', 'Model');
                $obj = new Contest();
                $Data = $obj->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $sudopay_token = $Data['Contest']['sudopay_token'];
                $sudopay_revised_amount = $Data['Contest']['sudopay_revised_amount'];
                $receiver_data = $obj->getReceiverdata($foreign_id, $transaction_type, $Data['User']['email']);
                $amount = $receiver_data['amount']['0'];
            } elseif ($transaction_type == ConstPaymentType::SignupFee) {
                App::uses('User', 'Model');
                $obj = new User();
                $Data = $obj->find('first', array(
                    'conditions' => array(
                        'User.id' => $foreign_id,
                    ) ,
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    ) ,
                    'recursive' => -1
                ));
                $sudopay_token = $Data['User']['sudopay_token'];
                $sudopay_revised_amount = $Data['User']['sudopay_revised_amount'];
                $amount = Configure::read('User.signup_fee');
            } elseif ($transaction_type == ConstPaymentType::Wallet) {
                App::import('Model', 'Wallet.UserAddWalletAmount');
                $obj = new UserAddWalletAmount();
                $Data = $obj->find('first', array(
                    'conditions' => array(
                        'UserAddWalletAmount.id' => $foreign_id,
                    ) ,
                    'contain' => array(
                        'User',
                    ) ,
                    'recursive' => 0
                ));
                $sudopay_token = $Data['UserAddWalletAmount']['sudopay_token'];
                $sudopay_revised_amount = $Data['UserAddWalletAmount']['sudopay_revised_amount'];
                $amount = $Data['UserAddWalletAmount']['amount'];
            }
            if (!empty($this->request->data) && !empty($this->request->data['Sudopay']['confirm'])) {
                $s = $this->Sudopay->GetSudoPayObject();
                $post_data = array();
                $post_data['confirmation_token'] = $sudopay_token;
                $response = $s->callCaptureConfirm($post_data);
                if (empty($response['error']['code'])) {
                    if (!empty($response['status']) && $response['status'] == 'Pending') {
                        $return['pending'] = 1;
                    } elseif (!empty($response['status']) && $response['status'] == 'Captured') {
                        $return['success'] = 1;
                    } elseif (!empty($response['gateway_callback_url'])) {
                        header('location: ' . $response['gateway_callback_url']);
                        exit;
                    }
                } else {
                    $return['error'] = 1;
                    $return['error_message'] = $response['error']['message'];
                }
            }
            $redirect = $this->_getRedirectUrl($foreign_id, $transaction_type);
            if (!empty($return['success'])) {
                if ($transaction_type == ConstPaymentType::ContestPrize) {
                    $obj->processPayment($foreign_id, $amount, ConstPaymentGateways::SudoPay);
                    $this->Session->setFlash(__l('You have paid listing fee successfully.') , 'default', null, 'success');
                } elseif ($transaction_type == ConstPaymentType::SignupFee) {
                    App::import('Model', 'Payment');
                    $obj = new Payment();
                    $obj->processUserSignupPayment($foreign_id, ConstPaymentGateways::SudoPay);
                    $this->Session->setFlash(__l('You have paid signup fee successfully') , 'default', null, 'success');
                } elseif ($transaction_type == ConstPaymentType::Wallet) {
                    $obj->processAddtoWallet($foreign_id, ConstPaymentGateways::SudoPay);
                    $this->Session->setFlash(__l('Amount added to wallet') , 'default', null, 'success');
                }
                $this->redirect($redirect);
            } elseif (!empty($return['error'])) {
                $return['error_message'].= '. ';
                $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
            } elseif (!empty($return['pending'])) {
                $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
            }
            $this->pageTitle = __l("Payment Confirmation");
            $this->set(compact('amount', 'foreign_id', 'transaction_type', 'redirect', 'sudopay_revised_amount'));
        }
        public function admin_synchronize()
        {
            $s = $this->Sudopay->GetSudoPayObject();
            $currentPlan = $s->callPlan();
            if (!empty($currentPlan['error']['message'])) {
                $this->Session->setFlash($currentPlan['error']['message'], 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'payment_gateways',
                    'action' => 'edit',
                    ConstPaymentGateways::SudoPay,
                    'admin' => true
                ));
            }
            if ($currentPlan['brand'] == 'Transparent Branding') {
                $plan = ConstBrandType::TransparentBranding;
            } elseif ($currentPlan['brand'] == 'SudoPay Branding') {
                $plan = ConstBrandType::VisibleBranding;
            } elseif ($currentPlan['brand'] == 'Any Branding') {
                $plan = ConstBrandType::AnyBranding;
            }
            $this->loadModel('PaymentGateway');
            $paymentGateway = $this->PaymentGateway->find('first', array(
                'fields' => array(
                    'PaymentGateway.is_test_mode',
                ) ,
                'conditions' => array(
                    'PaymentGateway.id' => ConstPaymentGateways::SudoPay
                ) ,
                'recursive' => -1
            ));
            if ($paymentGateway['PaymentGateway']['is_test_mode']) {
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $plan,
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                    'PaymentGatewaySetting.name' => 'is_payment_via_api'
                ));
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => "'" . $currentPlan['name'] . "'",
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                    'PaymentGatewaySetting.name' => 'sudopay_subscription_plan'
                ));
            } else {
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.live_mode_value' => $plan,
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                    'PaymentGatewaySetting.name' => 'is_payment_via_api'
                ));
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.live_mode_value' => "'" . $currentPlan['name'] . "'",
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => ConstPaymentGateways::SudoPay,
                    'PaymentGatewaySetting.name' => 'sudopay_subscription_plan'
                ));
            }
            $gateway_response = $s->callGateways();
            if (!empty($gateway_response['error']['message'])) {
                $this->Session->setFlash($gateway_response['error']['message'], 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'payment_gateways',
                    'action' => 'edit',
                    ConstPaymentGateways::SudoPay,
                    'admin' => true
                ));
            }
            $this->loadModel('Sudopay.SudopayPaymentGateway');
            $this->loadModel('Sudopay.SudopayPaymentGroup');
            $this->SudopayPaymentGroup->deleteAll(array(
                '1 = 1'
            ));
            $this->SudopayPaymentGateway->deleteAll(array(
                '1 = 1'
            ));
            foreach($gateway_response['gateways'] as $gateway_group) {
                $group_data = array();
                $group_data['sudopay_group_id'] = $gateway_group['id'];
                $group_data['name'] = $gateway_group['name'];
                $group_data['thumb_url'] = $gateway_group['thumb_url'];
                $this->SudopayPaymentGroup->create();
                $this->SudopayPaymentGroup->save($group_data);
                $group_id = $this->SudopayPaymentGroup->id;
                foreach($gateway_group['gateways'] as $gateway) {
                    $_data = array();
                    $supported_actions = $gateway['supported_features'][0]['actions'];
                    $_data['is_marketplace_supported'] = 0;
                    if (in_array('Marketplace-Auth-Capture', $supported_actions)) {
                        $_data['is_marketplace_supported'] = 1;
                    }
                    $_data['sudopay_gateway_id'] = $gateway['id'];
                    $_data['sudopay_gateway_details'] = serialize($gateway);
                    $_data['sudopay_gateway_name'] = $gateway['display_name'];
                    $_data['sudopay_payment_group_id'] = $group_id;
                    $this->SudopayPaymentGateway->create();
                    $this->SudopayPaymentGateway->save($_data);
                }
            }
            $this->Session->setFlash(sprintf(__l('%s have been synchronized') , __l('ZazPay Payment Gateways')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'payment_gateways',
                'action' => 'edit',
                ConstPaymentGateways::SudoPay,
                'admin' => true
            ));
        }
}
?>