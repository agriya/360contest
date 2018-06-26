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
class PaymentGatewaySettingsController extends AppController
{
    public $name = 'PaymentGatewaySettings';
    public function admin_add($payment_gateway_id = null)
    {
        $this->pageTitle = __l('Add Payment Gateway Setting');
        if (!empty($this->request->data)) {
            $this->PaymentGatewaySetting->create();
            if ($this->PaymentGatewaySetting->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Payment Gateway Setting')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'edit',
                    $this->request->data['PaymentGatewaySetting']['payment_gateway_id']
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Payment Gateway Setting')) , 'default', null, 'error');
            }
        } else {
            if (!is_null($payment_gateway_id)) {
                $this->request->data['PaymentGatewaySetting']['payment_gateway_id'] = $payment_gateway_id;
            }
        }
        $paymentGateways = $this->PaymentGatewaySetting->PaymentGateway->find('list');
        $this->set(compact('paymentGateways'));
    }
    public function admin_edit($payment_gateway_id = null)
    {
        $this->pageTitle = __l('Edit Payment Gateway Setting');
        if (is_null($payment_gateway_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paymentGateway = $this->PaymentGatewaySetting->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => $payment_gateway_id
            ) ,
            'recursive' => -1
        ));
        $this->set('payment_gateway_id', $payment_gateway_id);
        if (empty($paymentGateway)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $paymentGatewaySettings = $this->PaymentGatewaySetting->find('all', array(
            'conditions' => array(
                'PaymentGatewaySetting.payment_gateway_id = ' => $payment_gateway_id
            ) ,
            'order' => array(
                'PaymentGatewaySetting.id' => 'ASC'
            ) ,
            'recursive' => 0
        ));
        $this->set(compact('paymentGatewaySettings', 'paymentGateway'));
    }
    /**
     * @TODO: Add some validation
     *
     */
    public function admin_update()
    {
        // Save settings
        foreach($this->request->data['PaymentGatewaySetting'] as $id => $value) {
            if ($id != 'payment_gateway_id') {
                $this->PaymentGatewaySetting->create(array(
                    'id' => $id,
                    'value' => $value['name']
                ));
                $this->PaymentGatewaySetting->save(null, array(
                    'validate' => false
                ));
            }
        }
        $this->Session->setFlash(__l('Payment gateway settings updated.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'payment_gateway_settings',
            'action' => 'edit',
            $this->request->data['PaymentGatewaySetting']['payment_gateway_id']
        ));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PaymentGatewaySetting->del($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Payment Gateway Setting')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>