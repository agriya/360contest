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
class PaymentGatewaysController extends AppController
{
    public $name = 'PaymentGateways';
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'PaymentGateway.makeActive',
            'PaymentGateway.makeInactive',
            'PaymentGateway.makeTest',
            'PaymentGateway.makeLive',
            'PaymentGateway.makeDelete',
        );
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Payment Gateways');
        $this->_redirectGET2Named(array(
            'filter',
            'keywords'
        ));
        $conditions = array();
        if (!empty($this->request->params['named'])) {
            $this->request->data['PaymentGateway'] = array(
                'filter' => (isset($this->request->params['named']['filter'])) ? $this->request->params['named']['filter'] : '',
                'keywords' => (isset($this->request->params['named']['keywords'])) ? $this->request->params['named']['keywords'] : ''
            );
        }
        if (!empty($this->request->data['PaymentGateway']['filter'])) {
            if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::Active) {
                $conditions['PaymentGateway.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::Inactive) {
                $conditions['PaymentGateway.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::TestMode) {
                $conditions['PaymentGateway.is_test_mode'] = 1;
                $this->pageTitle.= __l(' - Test Mode ');
            } else if ($this->request->data['PaymentGateway']['filter'] == ConstPaymentGatewayFilterOptions::LiveMode) {
                $conditions['PaymentGateway.is_test_mode'] = 0;
                $this->pageTitle.= __l(' - Live Mode ');
            }
        }
        if (!empty($this->request->data['PaymentGateway']['keywords'])) {
            $conditions = array(
                'OR' => array(
                    'PaymentGateway.name LIKE ' => '%' . $this->request->data['PaymentGateway']['keywords'] . '%',
                    'PaymentGateway.description LIKE ' => '%' . $this->request->data['PaymentGateway']['keywords'] . '%',
                )
            );
        }
		if (!isPluginEnabled('Sudopay')) {
			$conditions['PaymentGateway.id != '] = ConstPaymentGateways::SudoPay;
		}
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'PaymentGateway.id' => 'desc'
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'fields' => array(
                        'PaymentGatewaySetting.name',
                        'PaymentGatewaySetting.test_mode_value',
                    ) ,
                    'order' => array(
                        'PaymentGatewaySetting.id'
                    )
                ) ,
            ) ,
            'recursive' => 1
        );
        $this->set('paymentGateways', $this->paginate());
        $isFilterOptions = $this->PaymentGateway->isFilterOptions;
        $this->set(compact('isFilterOptions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Payment Gateway');
        if (!empty($this->request->data)) {
            $this->PaymentGateway->create();
            if ($this->PaymentGateway->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Payment Gateway')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Payment Gateway')) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Payment Gateway');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }		
        if ($id == ConstPaymentGateways::SudoPay) {
            $this->loadModel('Sudopay.Sudopay');
            $this->loadModel('Sudopay.SudopayPaymentGateway');
            $SudoPayGatewaySettings = $this->Sudopay->GetSudoPayGatewaySettings();
			$sudopayPaymentGateways = $this->SudopayPaymentGateway->find('all');
            $this->set(compact('SudoPayGatewaySettings', 'id', 'sudopayPaymentGateways'));
        }
        if (!empty($this->request->data)) {
			$this->request->data['PaymentGateway']['is_test_mode'] = empty($this->request->data['PaymentGateway']['is_live_mode']) ? 1 : 0;
            if ($this->PaymentGateway->save($this->request->data)) {
                if (!empty($this->request->data['PaymentGatewaySetting'])) {
                    foreach($this->request->data['PaymentGatewaySetting'] as $key => $value) {
                        $value['test_mode_value'] = !empty($value['test_mode_value']) ? trim($value['test_mode_value']) : '';
                        $value['live_mode_value'] = !empty($value['live_mode_value']) ? trim($value['live_mode_value']) : '';
                        $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                            'PaymentGatewaySetting.test_mode_value' => '\'' . trim($value['test_mode_value']) . '\'',
                            'PaymentGatewaySetting.live_mode_value' => '\'' . trim($value['live_mode_value']) . '\''
                        ) , array(
                            'PaymentGatewaySetting.id' => $key
                        ));
                    }
                }
				if ($this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay) {                    
					if(!empty($this->request->data['SudopayPaymentGateway'])) {
						$ids = array();
						foreach($this->request->data['SudopayPaymentGateway'] as $id => $is_checked) {
								$Data['id'] = $id;
								$Data['days_after_amount_paid'] = $this->request->data['SudopayPaymentGateway'][$id]['days_after_amount_paid'];
								if(!empty($Data['id']) && !empty($Data['days_after_amount_paid'])) {
									$this->SudopayPaymentGateway->save($Data,false);	
								}
						}
					} else {
						$this->redirect(array(
							'controller' => 'sudopays',
							'action' => 'synchronize',
							'admin' => true
						));
					}
                }
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Payment Gateway')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Payment Gateway')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PaymentGateway->read(null, $id);
			$this->request->data['PaymentGateway']['is_live_mode'] = empty($this->request->data['PaymentGateway']['is_test_mode']) ? 1 : 0;
            unset($this->request->data['PaymentGatewaySetting']);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $paymentGatewaySettings = $this->PaymentGateway->PaymentGatewaySetting->find('all', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id' => $id
            ) ,
            'order' => array(
                'PaymentGatewaySetting.id' => 'asc'
            ),
			'recursive' => -1
        ));
        if (!empty($this->request->data['PaymentGatewaySetting']) && !empty($paymentGatewaySettings)) {
            foreach($paymentGatewaySettings as $key => $paymentGatewaySetting) {
                $paymentGatewaySettings[$key]['PaymentGatewaySetting']['value'] = $this->request->data['PaymentGatewaySetting'][$paymentGatewaySetting['PaymentGatewaySetting']['id']]['value'];
            }
        }
        $this->set(compact('paymentGatewaySettings'));
        $this->pageTitle.= ' - ' . $this->request->data['PaymentGateway']['display_name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PaymentGateway->del($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Payment Gateway')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update_status($id = null, $actionId = null, $toggle = null)
    {
        if (is_null($id) || is_null($actionId)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $toggle = empty($toggle) ? 0 : 1;
        switch ($actionId) {
            case ConstMoreAction::Active:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_active' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                $PaymentGateway = $this->PaymentGateway->find('first', array(
                    'conditions' => array(
                        'PaymentGateway.id' => $id
                    ) ,
                    'recursive' => -1
                ));
                $plugin = Inflector::camelize(strtolower($PaymentGateway['PaymentGateway']['name']));
                if ($this->Cms->pluginIsActive($plugin)) {
                    $this->Cms->removePluginBootstrap($plugin);
                    $this->Session->setFlash(__l('Payment Gateway deactivated successfully.') , 'default', null, 'success');
                } else {
                    $this->Cms->addPluginBootstrap($plugin);
                    $this->Session->setFlash(__l('Payment Gateway activated successfully.') , 'default', null, 'success');
                }
                break;

            case ConstMoreAction::TestMode:
                $newToggle = empty($toggle) ? 1 : 0;
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_test_mode' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstMoreAction::MassPay:
                $this->PaymentGateway->updateAll(array(
                    'PaymentGateway.is_mass_pay_enabled' => $toggle
                ) , array(
                    'PaymentGateway.id' => $id
                ));
                break;

            case ConstMoreAction::ContestListing:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_contest_listing'
                ));
                break;

            case ConstMoreAction::Signup:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_signup'
                ));
                break;

            case ConstMoreAction::Wallet:
                $this->PaymentGateway->PaymentGatewaySetting->updateAll(array(
                    'PaymentGatewaySetting.test_mode_value' => $toggle
                ) , array(
                    'PaymentGatewaySetting.payment_gateway_id' => $id,
                    'PaymentGatewaySetting.name' => 'is_enable_for_add_to_wallet'
                ));
                break;
        }
        if (!$this->request->params['isAjax']) {
            $this->redirect(array(
                'controller' => 'payment_gateways',
                'action' => 'index'
            ));
        } else {
            $toggle_status = empty($toggle) ? 1 : 0;
            echo Router::url(array(
                'controller' => 'payment_gateways',
                'action' => 'update_status',
                $id,
                $actionId,
                $toggle_status,
                'admin' => true,
            ) , true);
            $this->autoRender = false;
        }
    }
    public function admin_move_to()
    {
        if (!empty($this->request->data['PaymentGateway']['Id'])) {
            foreach($this->request->data['PaymentGateway']['Id'] as $payment_gateway_id => $is_checked) {
                if ($is_checked['Check']) {
                    if (!empty($this->request->data['PaymentGateway']['makeActive'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_active'] = 1;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to active') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeInactive'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_active'] = 0;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to inactive') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeTest'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_test_mode'] = 1;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to test mode') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeLive'])) {
                        $payment_gateway['PaymentGateway']['id'] = $payment_gateway_id;
                        $payment_gateway['PaymentGateway']['is_test_mode'] = 0;
                        $this->PaymentGateway->save($payment_gateway, false);
                        $this->Session->setFlash(__l('Checked payment gateways has been changed to live mode') , 'default', null, 'success');
                    }
                    if (!empty($this->request->data['PaymentGateway']['makeDelete'])) {
                        $this->PaymentGateway->del($payment_gateway_id);
                        $this->Session->setFlash(__l('Checked payment gateways has been deleted') , 'default', null, 'success');
                    }
                }
            }
        }
        $this->redirect(array(
            'controller' => 'payment_gateways',
            'action' => 'index'
        ));
    }
}
?>