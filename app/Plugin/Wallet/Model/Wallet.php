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
class Wallet extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
    function refund($foreign_id, $model, $amount, $user_id, $transaction_type)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $this->User->updateAll(array(
            'User.available_wallet_amount' => 'User.available_wallet_amount + ' . $amount
        ) , array(
            'User.id' => $user_id
        ));
        $this->User->Transaction->log($foreign_id, $model, ConstPaymentGateways::Wallet, $transaction_type);
        if ($transaction_type == ConstTransactionTypes::PrizeAmountForCompletedContest) {
            $this->User->Transaction->log($foreign_id, $model, ConstPaymentGateways::Wallet, ConstTransactionTypes::AmountDeductedForCompletedContest);
        }
    }
    public function processAddtoWallet($user_add_wallet_amount_id, $payment_gateway_id = null)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $userAddWalletAmount = $this->User->UserAddWalletAmount->find('first', array(
            'conditions' => array(
                'UserAddWalletAmount.id = ' => $user_add_wallet_amount_id,
            ) ,
            'contain' => array(
                'User'
            ) ,
            'recursive' => 0
        ));
        if (empty($userAddWalletAmount)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
            $this->User->Transaction->log($user_add_wallet_amount_id, 'UserAddWalletAmount', $payment_gateway_id, ConstTransactionTypes::AmountAddedToWallet);
            $_Data['UserAddWalletAmount']['id'] = $user_add_wallet_amount_id;
            $_Data['UserAddWalletAmount']['is_success'] = 1;
            $this->User->UserAddWalletAmount->save($_Data);
            $User['id'] = $userAddWalletAmount['UserAddWalletAmount']['user_id'];
            $User['available_wallet_amount'] = $userAddWalletAmount['User']['available_wallet_amount']+$userAddWalletAmount['UserAddWalletAmount']['amount'];
            $User['total_amount_deposited'] = $userAddWalletAmount['User']['total_amount_deposited']+$userAddWalletAmount['UserAddWalletAmount']['amount'];
            $this->User->save($User);
			Cms::dispatchEvent('Model.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                '_addTrans' => array(
                    'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'name' => 'Wallet',
                    'total' => $userAddWalletAmount['UserAddWalletAmount']['amount']
                ) ,
                '_addItem' => array(
                    'order_id' => 'Wallet-' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'sku' => 'W' . $userAddWalletAmount['UserAddWalletAmount']['id'],
                    'name' => 'Wallet',
                    'category' => $userAddWalletAmount['User']['username'],
                    'unit_price' => $userAddWalletAmount['UserAddWalletAmount']['amount']
                ) ,
                '_setCustomVar' => array(
                    'ud' => $_SESSION['Auth']['User']['id'],
                    'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
                )
            ));
            return true;
        } elseif (!empty($userAddWalletAmount['UserAddWalletAmount']['is_success'])) {
            return true;
        }
        return false;
    }
}
?>