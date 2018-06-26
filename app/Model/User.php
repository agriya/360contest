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
class User extends AppModel
{
    public $name = 'User';
    public $displayField = 'username';
    public $belongsTo = array(
        'Role' => array(
            'className' => 'Acl.Role',
            'foreignKey' => 'role_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'signup_ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'LastLoginIp' => array(
            'className' => 'Ip',
            'foreignKey' => 'last_login_ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'UserOpenid' => array(
            'className' => 'UserOpenid',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'UserLogin' => array(
            'className' => 'UserLogin',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'UserView' => array(
            'className' => 'UserView',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'CkSession' => array(
            'className' => 'CkSession',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Transaction' => array(
            'className' => 'Transaction',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    public $hasOne = array(
        'UserNotification' => array(
            'className' => 'UserNotification',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserProfile' => array(
            'className' => 'UserProfile',
            'foreignKey' => 'user_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UserAvatar' => array(
            'className' => 'UserAvatar',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'UserAvatar.class' => 'UserAvatar',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_memcacheModels = array(
			'Contest',
			'ContestUser',
			'Image'
		);
        $this->_permanentCacheAssociations = array(
            'Chart',
			'Contest',
			'UserProfile',
			'Transaction',
			'Wallet',
			'SocialMarketing'
        );
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required')
                )
            ) ,
            'username' => array(
                'rule5' => array(
                    'rule' => array(
                        'between',
                        3,
                        30
                    ) ,
                    'message' => __l('Must be between of 3 to 30 characters')
                ) ,
                'rule4' => array(
                    'rule' => 'alphaNumeric',
                    'message' => __l('Must be a valid character')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Username is already exist')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'custom',
                        '/^[a-zA-Z]/'
                    ) ,
                    'message' => __l('Must be start with an alphabets')
                ) ,
			    'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'email' => array(
				'rule4' => array(
                    'rule' => '_checkEmail',
                    'message' => __l('Email address is already exist')
                ) ,
                'rule3' => array(
                    'rule' => 'isUnique',
                    'on' => 'create',
                    'message' => __l('Email address is already exist')
                ) ,
                'rule2' => array(
                    'rule' => 'email',
                    'message' => __l('Must be a valid email')
                ) ,
				'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'passwd' => array(
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ),
				'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                ),
            ) ,
            'old_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_checkOldPassword',
                        'old_password'
                    ) ,
                    'message' => __l('Your old password is incorrect, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'confirm_password' => array(
                'rule3' => array(
                    'rule' => array(
                        '_isPasswordSame',
                        'passwd',
                        'confirm_password'
                    ) ,
                    'message' => __l('New and confirm password field must match, please try again')
                ) ,
                'rule2' => array(
                    'rule' => array(
                        'minLength',
                        6
                    ) ,
                    'message' => __l('Must be at least 6 characters')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'captcha' => array(
                'rule2' => array(
                    'rule' => '_isValidCaptcha',
                    'message' => __l('Please enter valid captcha')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'is_agree_terms_conditions' => array(
                'rule' => array(
                    'equalTo',
                    '1'
                ) ,
                'message' => __l('You must agree to the terms and conditions')
            ) ,
            'message' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'subject' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'send_to' => array(
                'rule1' => array(
                    'rule' => '_checkMultipleEmail',
                    'message' => __l('Must be a valid email') ,
                    'allowEmpty' => true
                )
            ) ,
            'security_question_id' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'security_answer' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            )
        );
        // filter options in admin index
        $this->isFilterOptions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::OpenID => __l('OpenID')
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete') ,
            ConstMoreAction::Export => __l('Export')
        );
        $this->bulkMailOptions = array(
            1 => __l('All Users') ,
            2 => __l('Inactive Users') ,
            3 => __l('Active Users') ,
            6 => __l('Facebook Users') ,
            7 => __l('Gmail Users') ,
            8 => __l('Twitter Users') ,
            9 => __l('Yahoo Users') ,
            10 => __l('OpenID Users') ,
			11 => __l('LinkedIn Users') ,
			12 => __l('Google Plus Users') ,
        );
    }
    // check the new and confirm password
    public function _isPasswordSame($field1 = array() , $field2 = null, $field3 = null)
    {
        if ($this->data[$this->name][$field2] == $this->data[$this->name][$field3]) {
            return true;
        }
        return false;
    }
    // check the old password field with database
    public function _checkOldPassword($field1 = array() , $field2 = null)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $_SESSION['Auth']['User']['id']
            ) ,
            'recursive' => -1
        ));
        if (crypt($this->data[$this->name][$field2], $user['User']['password']) == $user['User']['password']) {
            return true;
        }
        return false;
    }
    // hash for forgot password mail
    public function getResetPasswordHash($user_id = null)
    {
        return md5($user_id . '-' . date('y-m-d') . Configure::read('Security.salt'));
    }
    // check the forgot password hash
    public function isValidResetPasswordHash($user_id = null, $hash = null)
    {
        return (md5($user_id . '-' . date('y-m-d') . Configure::read('Security.salt')) == $hash);
    }
    // hash for activate mail
    public function getActivateHash($user_id = null)
    {
        return md5($user_id . '-' . Configure::read('Security.salt'));
    }
    // hash for resend activate mail
    function getResendActivateHash($user_id = null)
    {
        return md5(Configure::read('Security.salt') . '-' . $user_id);
    }
    // check the activate mail
    public function isValidActivateHash($user_id = null, $hash = null)
    {
        return (md5($user_id . '-' . Configure::read('Security.salt')) == $hash);
    }
    public function _checkMultipleEmail()
    {
        $multipleEmails = explode(',', $this->data['User']['send_to']);
        foreach($multipleEmails as $key => $singleEmail) {
			$singleEmail = trim($singleEmail);
			if (!empty($singleEmail)) {
				if (!Validation::email(trim($singleEmail))) {
					return false;
				}
			}
        }
        return true;
    }
    public function getUserIdHash($user_ids = null)
    {
        return md5($user_ids . Configure::read('Security.salt'));
    }
    public function isValidUserIdHash($user_ids = null, $hash = null)
    {
        return (md5($user_ids . Configure::read('Security.salt')) == $hash);
    }
    public function checkUsernameAvailable($username)
    {
        $username = str_replace(' ', '', $username);
        $username = str_replace('.', '_', $username);
        $user = $this->find('count', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'recursive' => -1
        ));
        if (!empty($user)) {
            return false;
        }
        return $username;
    }
    public function parentNode()
    {
        if (!$this->id && empty($this->data)) {
            return null;
        }
        $data = $this->data;
        if (empty($this->data)) {
            $data = $this->read();
        }
        if (!isset($data['User']['role_id']) || !$data['User']['role_id']) {
            return null;
        } else {
            return array(
                'Role' => array(
                    'id' => $data['User']['role_id']
                )
            );
        }
    }
    public function afterSave($created)
    {
        $user_id = $this->id;
        // Saving notifications during registerations //
        $notify = array();
        $check_user_notification_exist = $this->UserNotification->find('first', array(
            'conditions' => array(
                'UserNotification.user_id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if (empty($check_user_notification_exist) && !empty($user_id)) {
            $notify['UserNotification']['user_id'] = $user_id;
            $this->UserNotification->save($notify['UserNotification']);
        }
    }
    function checkUserBalance($user_id = null, $field = null)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.available_wallet_amount',
            ) ,
            'recursive' => -1
        ));
        if (!empty($field)) {
            return $user['User'][$field];
        }
        if ($user['User']['available_wallet_amount']) {
            return $user['User']['available_wallet_amount'];
        }
        return false;
    }
    public function getReceiverdata($foreign_id, $transaction_type, $payee_account)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $foreign_id
            ) ,
            'recursive' => -1
        ));
        $return['receiverEmail'] = array(
            $payee_account
        );
        $return['amount'] = array(
            Configure::read('user.signup_fee')
        );
		$return['fees_payer'] = 'buyer';
        if (Configure::read('user.signup_fee_payer') == 'Site') {
            $return['fees_payer'] = 'merchant';
        }
        $return['action'] = 'Capture';
        $return['buyer_email'] = $user['User']['email'];
        $return['sudopay_gateway_id'] = $user['User']['sudopay_gateway_id'];
        return $return;
    }
	public function updateSocialContact($social_profile, $social_type)
    {
        $identifier = $social_profile->identifier;
        $_data['User']['id'] = $_SESSION['Auth']['User']['id'];
        $session_data = $_SESSION['HA::STORE'];
        $stored_access_token = $session_data['hauth_session.' . $social_type . '.token.access_token'];
        $temp_access_token = explode(":", $stored_access_token);
        $temp_access_token = str_replace('"', '', $temp_access_token);
        $temp_access_token = str_replace(';', '', $temp_access_token);
        $access_token = $temp_access_token[2];
        if ($social_type == 'facebook') {
            $_data['User']['is_facebook_connected'] = 1;
            $_data['User']['facebook_access_token'] = $access_token;
            $_data['User']['facebook_user_id'] = $identifier;
        } elseif ($social_type == 'twitter') {
            $_data['User']['is_twitter_connected'] = 1;
            $_data['User']['twitter_access_token'] = $access_token;
            $_data['User']['twitter_user_id'] = $identifier;
            $_data['User']['twitter_avatar_url'] = $social_profile->photoURL;
        } elseif ($social_type == 'google') {
            $_data['User']['is_google_connected'] = 1;
            $_data['User']['google_user_id'] = $identifier;
		} elseif ($social_type == 'googleplus') {
            $_data['User']['is_googleplus_connected'] = 1;
            $_data['User']['googleplus_user_id'] = $identifier;	
        } elseif ($social_type == 'yahoo') {
            $_data['User']['is_yahoo_connected'] = 1;
            $_data['User']['yahoo_user_id'] = $identifier;
        } elseif ($social_type == 'linkedin') {
            $_data['User']['is_linkedin_connected'] = 1;
            $_data['User']['linkedin_access_token'] = $access_token;
            $_data['User']['linkedin_user_id'] = $identifier;
			$_data['User']['linkedin_avatar_url'] = $social_profile->photoURL;
        }
        $this->save($_data);
    }
    public function checkConnection($social_profile, $social_type)
    {
        $identifier = $social_profile->identifier;
        $conditions = array();
		$conditions['User.' . $social_type . '_user_id'] = $identifier;
		$conditions['OR'] = array(
			'User.is_' . $social_type . '_register' => 1,
			'User.is_' . $social_type . '_connected' => 1
		);
        $user = $this->find('first', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        if (empty($user)) {
            return true;
        } else {
            if ($user['User']['id'] == $_SESSION['Auth']['User']['id']) {
                return true;
            } else {
                return false;
            }
        }
    }
	public function _checkEmail()
    {
		if(!empty($_SESSION['Auth']['User']['role_id']) && $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) {
			$user = $this->find('first', array(
				'conditions' => array(
					'User.email'  => $this->data['User']['email'],
				),
				'recursive' => -1
			));
			if(empty($user) || $user['User']['id'] == $this->data['User']['id']) {
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
	function _checkUserBalance($user_id = null)
    {
        $user = $this->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.available_wallet_amount',
                'User.blocked_amount',
            ) ,
            'recursive' => -1
        ));
        if ($user['User']['available_wallet_amount']) {
            return $user['User']['available_wallet_amount'];
        }
        return false;
    }
	// hash for activate mail
    function getInviteHash() 
    {
        return md5(strtotime('Now') . '-' . Configure::read('Security.salt'));
    }
}
?>