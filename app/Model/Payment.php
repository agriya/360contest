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
class Payment extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
    }
    public function processUserSignupPayment($user_id, $payment_gateway_id = null)
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id = ' => $user_id,
            ) ,
            'recursive' => -1,
        ));
        if (empty($user['User']['is_paid'])) {
            $_Data['User']['id'] = $user['User']['id'];
            $_Data['User']['is_paid'] = 1;
            $_Data['User']['is_active'] = 1;
            if (Configure::read('user.is_email_verification_for_register') && empty($user['User']['is_openid_register']) && empty($user['User']['is_facebook_register']) && empty($user['User']['is_twitter_register']) && empty($user['User']['is_google_register']) && empty($user['User']['is_yahoo_register']) && empty($user['User']['is_linkedin_register'])) {
                $_Data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;

                if (!Configure::read('user.is_email_verification_for_register') and !Configure::read('user.is_admin_activate_after_register') and Configure::read('user.is_welcome_mail_after_register')) {
                    $this->User->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
                }
            }
            $this->User->save($_Data);
            App::import('Model', 'Transaction');
            $this->Transaction = new Transaction();
            $this->Transaction->log($user_id, 'User', $payment_gateway_id, ConstTransactionTypes::SignupFee);
            return true;
        }
        return false;
    }
}
?>