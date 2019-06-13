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
class Transaction extends AppModel
{
    var $name = 'Transaction';
    var $actsAs = array(
        'Polymorphic' => array(
            'classField' => 'class',
            'foreignKey' => 'foreign_id',
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    var $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'TransactionType' => array(
            'className' => 'TransactionType',
            'foreignKey' => 'transaction_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        )
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'user_id' => array(
                'rule' => 'numeric',
                'allowEmpty' => false,
                'message' => __l('Required')
            ) ,
            'amount' => array(
                'rule3' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required valid amount')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            ) ,
            'deduct_amount' => array(
                'rule3' => array(
                    'rule' => array(
                        'comparison',
                        '>',
                        0
                    ) ,
                    'allowEmpty' => false,
                    'message' => __l('Should be greater than 0')
                ) ,
                'rule2' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required valid amount')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required')
                ) ,
            )
        );
    }
    function log($foreign_id = null, $class = '', $payment_gateway_id = null, $transaction_type_id = null)
    {
		if (!empty($foreign_id) && !empty($class)) {
            $model_class = explode('.', $class);
            if (!empty($model_class[1])) {
                $class = $model_class[1];
            }
            App::import($class, 'Model');
            $obj = new $class();
            $data = $obj->find('first', array(
                'conditions' => array(
                    $class . '.id' => $foreign_id
                ) ,
                'recursive' => -1
            ));
            $amount = 0;
            if ($transaction_type_id == ConstTransactionTypes::NewContestAdded) {
                $amount = $data[$class]['creation_cost'];
            } elseif ($transaction_type_id == ConstTransactionTypes::AmountAddedToWallet) {
                $amount = $data[$class]['amount'];
            } elseif ($transaction_type_id == ConstTransactionTypes::PrizeAmountForCompletedContest) {
                $amount = $data[$class]['prize']-$data[$class]['site_commision'];
            } elseif ($transaction_type_id == ConstTransactionTypes::SignupFee) {
                $amount = Configure::read('user.signup_fee');
			} elseif ($transaction_type_id == ConstTransactionTypes::SiteCommisionDeductUsingMarketplace) {
				$amount = $data[$class]['creation_cost']-$data[$class]['prize'];
			} elseif ($transaction_type_id == ConstTransactionTypes::ParticipantCommisionDeductUsingMarketplace) {
				$amount = $data[$class]['site_commision'];
			} elseif ($transaction_type_id == ConstTransactionTypes::ContestFeaturesUpdated) {
  				$upgrade = unserialize($data[$class]['upgrade']);
				$amount = $upgrade['fee'];
  			} elseif ($transaction_type_id == ConstTransactionTypes::ContestTimeExtended) {
  				$upgrade = unserialize($data[$class]['upgrade']);
				$amount = $upgrade['fee'];
            } else {
                $amount = (!empty($data[$class]['prize']))?$data[$class]['prize']:'';
            }
            if ($transaction_type_id == ConstTransactionTypes::SignupFee) {
                $user_id = $foreign_id;
            } elseif ($transaction_type_id == ConstTransactionTypes::PrizeAmountForCompletedContest) {
                $user_id = $data[$class]['winner_user_id'];
			} elseif ($transaction_type_id == ConstTransactionTypes::ParticipantCommisionDeductUsingMarketplace) {
				$user_id = ConstUserIds::Admin;
            } else {
                $user_id = $data[$class]['user_id'];
            }
            $update_transaction = array();
            $update_transaction['Transaction']['user_id'] = $user_id;
            $update_transaction['Transaction']['foreign_id'] = $foreign_id;
            $update_transaction['Transaction']['class'] = $class;
            $update_transaction['Transaction']['amount'] = $amount;
            $update_transaction['Transaction']['payment_gateway_id'] = $payment_gateway_id;
            $update_transaction['Transaction']['description'] = 'Payment Success';
            $update_transaction['Transaction']['transaction_type_id'] = $transaction_type_id;
            if (!empty($update_transaction)) {
                $this->create();
                $this->save($update_transaction);
                return $this->getLastInsertId();
            }
        }
        return false;
    }
}
?>