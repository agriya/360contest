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
class Contest extends AppModel
{
    public $name = 'Contest';
    public $displayField = 'name';
    public $actsAs = array(
        'Sluggable' => array(
            'label' => array(
                'name'
            )
        ) ,
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'name',
                'description'
            )
        )
    );
    public $belongsTo = array(
        'ContestType' => array(
            'className' => 'Contests.ContestType',
            'foreignKey' => 'contest_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Resource' => array(
            'className' => 'Contests.Resource',
            'foreignKey' => 'resource_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'Contest.contest_status_id !=' => ConstContestStatus::PaymentPending,
                'Contest.admin_suspend' => 0,
            )
        ) ,
        'WinnerUser' => array(
            'className' => 'User',
            'foreignKey' => 'winner_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'ContestStatus' => array(
            'className' => 'Contests.ContestStatus',
            'foreignKey' => 'contest_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'PricingPackage' => array(
            'className' => 'Contests.PricingPackage',
            'foreignKey' => 'pricing_package_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
		'PricingDay' => array(
            'className' => 'Contests.PricingDay',
            'foreignKey' => 'pricing_day_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'PaymentGateway' => array(
            'className' => 'PaymentGateway',
            'foreignKey' => 'payment_gateway_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public $hasMany = array(
        'ContestUser' => array(
            'className' => 'Contests.ContestUser',
            'foreignKey' => 'contest_id',
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
        'ContestView' => array(
            'className' => 'Contests.ContestView',
            'foreignKey' => 'contest_id',
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
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Transaction.class' => 'Contest',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Message' => array(
            'className' => 'Contests.Message',
            'foreignKey' => 'contest_id',
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
        'Submission' => array(
            'className' => 'Contests.Submission',
            'foreignKey' => 'contest_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
		'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'Attachment.class' => 'SubmissionThumb',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,		
		'EntryAttachment' => array(
            'className' => 'Contests.EntryAttachment',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'EntryAttachment.class' => 'EntryAttachment',
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
    //$validate set in __construct for multi-language support
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'ContestUser',
            'User',
            'Chart',
			'ContestStatus',
			'ContestType'
        );
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'contest_type_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'contest_status_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'name' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'slug' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
			'description' => array(
				'rule' => 'notempty',
				'allowEmpty' => false,
				'message' => __l('Required') ,
            ) ,
            'company_name' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'contest_user_count' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'winner_user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'is_active' => array(
                'rule1' => array(
                    'rule' => 'boolean',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'reason_for_cancelation' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
			'end_date' => array(
                'rule' => '_checkValidDate',
                'message' => __l('End date should be greater than today. Please, try again.') ,
                'allowEmpty' => false
            ) ,
        );
        $this->isFilterOptions = array(
            ConstContestStatus::Open => __l('Open') ,
            ConstContestStatus::Judging => __l('Judging') ,
            ConstContestStatus::WinnerSelected => __l('Winner Selected') ,
            ConstContestStatus::Completed => __l('Completed')
        );
        $this->moreActions = array(
            ConstMoreAction::Open => __l('Open') ,
            ConstMoreAction::Reject => __l('Reject') ,
            ConstMoreAction::Completed => __l('Completed') ,
            ConstMoreAction::PaidToParticipant => sprintf(__l('Pay to %s') , Configure::read('contest.participant_alt_name_singular_caps')) ,
            ConstMoreAction::Cancel => __l('Cancel') ,
            ConstMoreAction::Delete => __l('Delete') ,
			ConstMoreAction::RejectRequest => __l('Reject request') ,
        );
    }
    public function calculateContestPrice($data)
    {
        App::import('Model', 'Contests.ContestType');
        $this->ContestType = new ContestType();
        $contestType = $this->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $data['Contest']['contest_type_id']
            ) ,
            'contain' => array(
                'PricingDay',
                'PricingPackage',
            ) ,
            'recursive' => 3
        ));
        $pricings = array();
        $pricings['creation_cost'] = 0;
        if (!empty($data['Contest']['pricing_package_id'])) {
            foreach($contestType['PricingPackage'] as $contestTypePricingPackage) {
                if ($contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id'] == $data['Contest']['pricing_package_id']) {
                    $pricings['prize'] = $contestTypePricingPackage['ContestTypesPricingPackage']['price'];
                    $pricings['maximum_entry_allowed'] = $contestTypePricingPackage['ContestTypesPricingPackage']['maximum_entry_allowed'];
                    break;
                }
            }
        } else {
            $min_prize = 0;
            foreach($contestType['PricingPackage'] as $contestTypePricingPackage) {
                if (!($min_prize != 0 && $min_prize < $contestTypePricingPackage['ContestTypesPricingPackage']['price'])) {
                    $min_prize = $contestTypePricingPackage['ContestTypesPricingPackage']['price'];
                }
            }
            $pricings['min_prize'] = $min_prize;
            $pricings['prize'] = $data['Contest']['prize'];
        }
        if (!empty($data['Contest']['pricing_day_id'])) {
            foreach($contestType['PricingDay'] as $contestTypePricingDay) {
                if ($contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'] == $data['Contest']['pricing_day_id']) {
                    $pricings['creation_cost']+= $contestTypePricingDay['ContestTypesPricingDay']['price'];
                    $pricings['end_date'] = date('Y-m-d H:i:s', strtotime('+' . $contestTypePricingDay['no_of_days'] . ' day'));
                    break;
                }
            }
        }
        $other_fee = 0;
        if (!empty($data['Contest']['is_blind'])) {
            $other_fee = $other_fee+$contestType['ContestType']['blind_fee'];
        }
        if (!empty($data['Contest']['is_private'])) {
            $other_fee = $other_fee+$contestType['ContestType']['private_fee'];
        }
        if (!empty($data['Contest']['is_featured'])) {
            $other_fee = $other_fee+$contestType['ContestType']['featured_fee'];
        }
		if (!empty($data['Contest']['is_highlight'])) {
  			$other_fee = $other_fee+$contestType['ContestType']['highlight_fee'];
  		}
        $pricings['creation_cost']+= $pricings['prize'];
        $pricings['creation_cost']+= $other_fee;
        return $pricings;
    }
    //To sand mail to admin when contest has been added
    function _sendAlertOnContestAdd($contest, $emailType)
    {
     $emailFindReplace = array(
            '##CONTEST_HOLDER##' => $contest['User']['username'],
            '##CONTEST_NAME##' => $contest['Contest']['name'],
            '##CONTEST_URL##' => Router::url(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug'],
                'admin' => false
            ) , true) ,
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
        );
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$template = $this->EmailTemplate->selectTemplate($emailType);
        $this->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
	}
	//To sand mail to participants when contest has been added
    function _sendAlertToParticipantsOnContestAdd($contest, $emailType)
    {
		$participants = $this->ContestUser->find('all',array(
			'conditions' => array(
				'ContestUser.user_id !=' => 0,
			),
			'contain' => array(
				'User',
			) ,
			'group' => array('ContestUser.user_id', 'ContestUser.id', 'User.id'),
			'recursive' => 0
		));
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$template = $this->EmailTemplate->selectTemplate($emailType);
		if (!empty($participants)) {			
			foreach($participants as $participant) {
				if ($this->_checkUserNotifications($contest['User']['id'], 'is_contest_created_alert_to_participant')) {
					 $emailFindReplace = array(
						'##CONTEST_HOLDER##' => $contest['User']['username'],
						'##CONTEST_NAME##' => $contest['Contest']['name'],
						'##USER_NAME##' => $participant['User']['username'],
						'##CONTEST_URL##' => Router::url(array(
							'controller' => 'contests',
							'action' => 'view',
							$contest['Contest']['slug'],
							'admin' => false
						) , true) ,
						'##SITE_NAME##' => Configure::read('site.name') ,
						'##SITE_URL##' => Router::url('/', true) ,
					);
					$this->_sendEmail($template, $emailFindReplace, $participant['User']['email']);
				}
			}
		}
	}
    // Process PendingApproval
    function processStatus2($contest, $payment_gateway_id = null)
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        //Update Status
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['contest_status_id'] = ConstContestStatus::PendingApproval;
        $this->save($_Data);
		$data = array();
		$data['User']['id'] = $contest['Contest']['user_id'];
		$data['User']['is_idle'] = 0;
		$data['User']['is_contest_posted'] = 1;
		$this->User->save($data);
        //Update Transaction
        $this->Transaction->log($contest['Contest']['id'], 'Contests.Contest', $payment_gateway_id, ConstTransactionTypes::NewContestAdded);
    }
    // Process Open
    function processStatus3($contest, $payment_gateway_id = null)
    {
        //Update Status
        $_Data['Contest']['start_date'] = date('Y-m-d H:i:s');
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['contest_status_id'] = ConstContestStatus::Open;
        App::import('Model', 'Contests.ContestType');
        $this->ContestType = new ContestType();
        $contestType = $this->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $contest['Contest']['contest_type_id']
            ) ,
            'contain' => array(
                'PricingDay',
                'PricingPackage',
            ) ,
            'recursive' => 3
        ));
        if (!empty($contest['Contest']['pricing_day_id'])) {
            foreach($contestType['PricingDay'] as $contestTypePricingDay) {
                if ($contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'] == $contest['Contest']['pricing_day_id']) {
                    $_Data['Contest']['end_date'] = date('Y-m-d H:i:s', strtotime('+' . $contestTypePricingDay['no_of_days'] . ' day'));
                    $_Data['Contest']['actual_end_date'] = date('Y-m-d H:i:s', strtotime('+' . $contestTypePricingDay['no_of_days'] . ' day'));
                    break;
                }
            }
        }
        $this->save($_Data);
		$u_data = array();
		$u_data['User']['id'] = $contest['Contest']['user_id'];
		$u_data['User']['is_idle'] = 0;
		$u_data['User']['is_contest_posted'] = 1;
		$this->User->save($u_data);
        if ($contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending) {
            App::import('Model', 'Transaction');
            $this->Transaction = new Transaction();
            //Update Transaction
            $this->Transaction->log($contest['Contest']['id'], 'Contests.Contest', $contest['Contest']['payment_gateway_id'], ConstTransactionTypes::NewContestAdded);
        }
        $image_options = array(
            'dimension' => 'normal_thumb',
            'class' => 'Review',
            'alt' => $contest['Contest']['name'],
            'title' => $contest['Contest']['name'],
            'type' => 'jpg'
        );
        $image_url = '';
        if (!empty($contest['Attachment'])) {
            $image_url = Router::url('/', true) . $this->getImageUrl('Contest', $contest['Attachment'], $image_options);
        }
        // Importing Facebook //
        App::import('Vendor', 'facebook/facebook');
        $this->facebook = new Facebook(array(
            'appId' => Configure::read('facebook.fb_app_id') ,
            'secret' => Configure::read('facebook.fb_secrect_key') ,
            'cookie' => true
        ));
        // Post in facebook //
        $fb_message = "Contest " . $contest['Contest']['name'] . ' has added on @' . Configure::read('site.name') . ': ' . Router::url(array(
            'controller' => 'contests',
            'action' => 'view',
            $contest['Contest']['slug'],
        ) , true);
        $data['message'] = $fb_message;
        $data['image_url'] = $image_url;
        $data['url'] = Router::url(array(
            'controller' => 'contests',
            'action' => 'view',
            $contest['Contest']['slug'],
        ) , true);
        $data['description'] = $contest['Contest']['description'];
        $data['fb_access_token'] = Configure::read('facebook.fb_access_token');
        $data['fb_user_id'] = Configure::read('facebook.fb_user_id');
        $this->_postInFacebook($data);
        // Importing Twitter //
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'OauthConsumer');
        $this->OauthConsumer = new OauthConsumerComponent($collection);
        // Post in twitter //
        $sightings_url = Router::url(array(
            'controller' => 'contests',
            'action' => 'view',
            $contest['Contest']['slug'],
        ) , true);
        $tw_message = "Contest " . $contest['Contest']['name'] . ' has added on @' . Configure::read('site.name') . ': ' . Router::url(array(
            'controller' => 'contests',
            'action' => 'view',
            $contest['Contest']['slug'],
        ) , true);
        $data['message'] = $tw_message;
        $data['twitter_access_token'] = Configure::read('twitter.site_user_access_token');
        $data['twitter_access_key'] = Configure::read('twitter.site_user_access_key');
        $this->_postInTwitter($data);
    }
    // Process Rejected
    function processStatus4($contest, $payment_gateway_id = null)
    {
        $this->_processRefund($contest, ConstTransactionTypes::ContestRejectedAndRefunded);
    }
    // Process RefundRequest
    function processStatus5($contest, $payment_gateway_id = null)
    {
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['refund_request_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
        //Send refund request mail for admin
        $emailFindReplace = array(
            '##CONTEST_NAME##' => $contest['Contest']['name'],
            '##CONTEST_HOLDER##' => $contest['User']['username'],
            '##MESSAGE##' => $contest['Contest']['reason_for_cancelation'],
            '##CONTEST_URL##' => Router::url(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug'],
                'admin' => false
            ) , true)
        );
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$template = $this->EmailTemplate->selectTemplate('Request Refund Alert');
        $this->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
    }
    // Process CanceledByAdmin
    function processStatus6($contest, $payment_gateway_id = null)
    {
        $this->_processRefund($contest, ConstTransactionTypes::ContestCanceledByAdmin);
        $_data = array();
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        if (!empty($_SESSION['reason_for_cancelation'])) {
            $_Data['Contest']['reason_for_cancelation'] = $_SESSION['reason_for_cancelation'];
        }
        $_Data['Contest']['canceled_by_admin_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
        $contestUsers = $this->ContestUser->find('all', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest['Contest']['id'],
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        foreach($contestUsers as $contestUser) {
            $_data = array();
            $_data['ContestUser']['id'] = $contestUser['ContestUser']['id'];
            $_data['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Lost;
            $this->ContestUser->save($_data);
            $emailFindReplace = array(
                '##PARTICIPANT##' => $contestUser['User']['username'],
                '##CONTEST_NAME##' => $contest['Contest']['name'],
                '##ENTRY_NO##' => $contestUser['ContestUser']['entry_no'],
                '##CONTEST_URL##' => Router::url(array(
                    'controller' => 'contests',
                    'action' => 'view',
                    $contest['Contest']['slug'],
                    'admin' => false
                ) , true)
            );
            if ($this->_checkUserNotifications($contestUser['User']['id'], 'is_contest_canceled_alert_to_participant')) {
                App::import('Model', 'EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				$template = $this->EmailTemplate->selectTemplate('Contest Canceled Alert To Participant');
				$this->_sendEmail($template, $emailFindReplace, $contestUser['User']['email']);
            }
        }
    }
    // Process Judging
    function processStatus7($contest, $payment_gateway_id = null)
    {
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['judging_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
        //TODO - Send mail to contest holder that contest reached max_allowed_entries

    }
    // Process WinnerSelected
    function processStatus8($contest, $payment_gateway_id = null, $winner_user_id = null, $to_contest_status_id = null)
    {
        $_Data['Contest']['winner_user_id'] = $winner_user_id;
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['winner_selected_date'] = date('Y-m-d H:i:s');
        $_data['Contest']['is_pending_action_to_admin'] = 0;
        if (!empty($to_contest_status_id)) {
            $_Data['Contest']['is_winner_selected_by_admin'] = 1;
            $_Data['Contest']['contest_status_id'] = $to_contest_status_id;
        } else {
            $_Data['Contest']['contest_status_id'] = ConstContestStatus::WinnerSelected;
        }
        $this->save($_Data);
        //for participant name and entry name
        $contestUser = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.user_id' => $winner_user_id,
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $emailFindReplace = array(
            '##PARTICIPANT##' => $contestUser['User']['username'],
            '##CONTEST_NAME##' => $contest['Contest']['name'],
			'##ENTRY_NO##' => $contestUser['ContestUser']['entry_no'],
            '##CONTEST_URL##' => Router::url(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug'],
                'admin' => false
            ) , true) ,
            '##ENTRY_URL##' => Router::url(array(
                'controller' => 'contest_users',
                'action' => 'view',
                $contest['Contest']['slug'],
                'entry' => $contestUser['ContestUser']['entry_no'],
                'admin' => false
            ) , true)
        );
        if ($this->_checkUserNotifications($contestUser['User']['id'], 'is_winner_selected_alert_to_participant')) {
            App::import('Model', 'EmailTemplate');
			$this->EmailTemplate = new EmailTemplate();
			$template = $this->EmailTemplate->selectTemplate('Winner Selected Alert To Participant');
			$this->_sendEmail($template, $emailFindReplace, $contestUser['User']['email']);
        }
        $contest_arr = array();
		$contest_arr = $this->find('first', array(
			'conditions' => array(
				'Contest.id' => $contest['Contest']['id'],
				) ,
			'contain' => array(
					'User',
					'WinnerUser',
					'ContestUser' => array(
						'conditions' => array(
							'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
						)
					)
				) ,
			'recursive' => 1
		));
        return $contest_arr;
    }
    // Process WinnerSelectedByAdmin
    function processStatus9($contest, $payment_gateway_id = null, $winner_user_id = null)
    {
        return $this->processStatus8($contest, $payment_gateway_id, $winner_user_id, ConstContestStatus::WinnerSelectedByAdmin);
    }
    // Process ChangeRequested
    function processStatus10($contest)
    {
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['change_requested_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
    }
    // Process ChangeCompleted
    function processStatus11($contest)
    {
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['change_completed_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
    }
	// Process FilesExpectation
    function processStatus15($contest)
    { 
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['files_expectation_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
		
    }
    // Process Completed
    function processStatus12($contest)
    {
        $contestUser = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.user_id' => $contest['Contest']['winner_user_id'],
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.blocked_amount',
                        'User.available_wallet_amount',
                    )
                )
            ) ,
            'recursive' => 2,
        ));
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.user_id' => $contest['Contest']['winner_user_id'],
                'Message.contest_user_id' => $contestUser['ContestUser']['id'],
                'Message.contest_id' => $contest['Contest']['id'],
                'Message.is_sender' => 1
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'Attachment'
                )
            ) ,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
            'recursive' => 2
        ));
        $attachment_contestUser = $this->ContestUser->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class' => 'ContestUser',
                'Attachment.foreign_id' => $contestUser['ContestUser']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($message['MessageContent']['Attachment'][0])) {
            $this->ContestUser->Attachment->Behaviors->detach('ImageUpload');
            $_data['Attachment']['filename']['type'] = $message['MessageContent']['Attachment'][0]['mimetype'];
            $_data['Attachment']['filename']['name'] = $message['MessageContent']['Attachment'][0]['filename'];
            $_data['Attachment']['filename']['tmp_name'] = APP . 'media' . DS . $message['MessageContent']['Attachment'][0]['dir'] . DS . $message['MessageContent']['Attachment'][0]['filename'];
            $_data['Attachment']['filename']['size'] = $message['MessageContent']['Attachment'][0]['filesize'];
            $_data['Attachment']['filename']['error'] = 0;
            $this->ContestUser->Attachment->Behaviors->attach('ImageUpload', Configure::read('message.file'));
            $this->ContestUser->Attachment->isCopyUpload(true);
            $this->ContestUser->Attachment->set($_data);
            $_data['Attachment']['class'] = $attachment_contestUser['Attachment']['class'];
            $_data['Attachment']['foreign_id'] = $attachment_contestUser['Attachment']['foreign_id'];
            $_data['Attachment']['filename'] = $_data['Attachment']['filename'];
            $_data['Attachment']['id'] = $attachment_contestUser['Attachment']['id'];
            $this->ContestUser->Attachment->save($_data);
        }
        $_data = array();
        $_data['Contest']['id'] = $contest['Contest']['id'];
        $_data['Contest']['completed_date'] = date('Y-m-d H:i:s');
        $_data['Contest']['actual_end_date'] = date('Y-m-d H:i:s');
		if($_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin){
			$_data['Contest']['is_admin_complete'] = 1;
		}
        $this->save($_data);
        $emailFindReplace = array(
            '##PARTICIPANT##' => $contestUser['User']['username'],
            '##CONTEST_NAME##' => $contest['Contest']['name'],
            '##ENTRY_NO##' => $contestUser['ContestUser']['entry_no'],
            '##ENTRY_URL##' => Router::url(array(
                'controller' => 'contest_users',
                'action' => 'view',
                $contest['Contest']['slug'],
                'entry' => $contestUser['ContestUser']['entry_no'],
                'admin' => false
            ) , true) ,
            '##CONTEST_URL##' => Router::url(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug'],
                'admin' => false
            ) , true)
        );
        if ($this->_checkUserNotifications($contestUser['User']['id'], 'is_contest_completed_alert_to_participant')) {
            App::import('Model', 'EmailTemplate');
			$this->EmailTemplate = new EmailTemplate();
			$template = $this->EmailTemplate->selectTemplate('Contest Completed Alert To Participant');
			$this->_sendEmail($template, $emailFindReplace, $contestUser['User']['email']);
        }
    }
    // Process PaidToParticipant
    function processStatus13($contest)
    {
        $_Data['Contest']['id'] = $contest['Contest']['id'];
        $_Data['Contest']['paid_to_participant_date'] = date('Y-m-d H:i:s');
        $this->save($_Data);
		App::import('Model', 'Wallet.Wallet');
		$this->Wallet = new Wallet();
		$contest_price = $contest['Contest']['prize']-$contest['Contest']['site_commision'];
		$this->Wallet->refund($contest['Contest']['id'], 'Contests.Contest', $contest_price, $contest['Contest']['winner_user_id'], ConstTransactionTypes::PrizeAmountForCompletedContest);
        $this->update_revenue($contest);
        $contestUser = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.user_id' => $contest['Contest']['winner_user_id'],
                'ContestUser.contest_id' => $contest['Contest']['id'],
            ) ,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                    )
                )
            ) ,
            'recursive' => 0,
        ));
        $emailFindReplace = array(
            '##PARTICIPANT##' => $contestUser['User']['username'],
            '##CONTEST_NAME##' => $contest['Contest']['name'],
            '##ENTRY_URL##' => Cache::read('site_url_for_shell', 'long') . 'contest_users/view/' . $contest['Contest']['slug'] . '/entry:' . $contestUser['ContestUser']['entry_no'],
            '##CONTEST_URL##' => Cache::read('site_url_for_shell', 'long') . 'contests/view/' . $contest['Contest']['slug'],
        );
        if ($this->_checkUserNotifications($contestUser['User']['id'], 'is_contest_amount_paid_alert_to_participant')) {
            App::import('Model', 'EmailTemplate');
			$this->EmailTemplate = new EmailTemplate();
			$template = $this->EmailTemplate->selectTemplate('Contest Amount Paid Alert To Participant');
			$this->_sendEmail($template, $emailFindReplace, $contestUser['User']['email']);
        }
    }
    // Process Refund
    function _processRefund($contest, $type)
    {
        if ($contest['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
            App::import('Model', 'Wallet.Wallet');
            $this->Wallet = new Wallet();
            $this->Wallet->refund($contest['Contest']['id'], 'Contests.Contest', $contest['Contest']['prize'], $contest['Contest']['user_id'], $type);
        }
    }
    function updateStatus($to_contest_status_id, $contest_id, $payment_gateway_id = null, $winner_user_id = null)
    {
        $contest = $this->find('first', array(
            'conditions' => array(
                'Contest.id = ' => $contest_id,
            ) ,
            'contain' => array(
                'User',
                'WinnerUser',
                'ContestUser' => array(
                    'conditions' => array(
                        'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                    )
                )
            ) ,
            'recursive' => 1,
        ));
        if (!in_array($to_contest_status_id, array(
            ConstContestStatus::PendingApproval,
            ConstContestStatus::Open,
            ConstContestStatus::WinnerSelected,
            ConstContestStatus::WinnerSelectedByAdmin
        ))) {
            $_data = array();
            $_data['Contest']['id'] = $contest['Contest']['id'];
            $_data['Contest']['contest_status_id'] = $to_contest_status_id;
            $_data['Contest']['is_pending_action_to_admin'] = 0;
            $this->save($_data);
        }
        $tmp_contest = $this->
        {
            'processStatus' . $to_contest_status_id}($contest, $payment_gateway_id, $winner_user_id);
            if ($to_contest_status_id != ConstContestStatus::PendingApproval) {
                $from_contest_status_id = $contest['Contest']['contest_status_id'];
                if ($contest['Contest']['contest_status_id'] == $to_contest_status_id) {
                    $from_contest_status_id = ConstContestStatus::RefundRequest;
                }
                $contest = !empty($tmp_contest) ? $tmp_contest : $contest;
                $this->postActivity($contest, $from_contest_status_id, $to_contest_status_id);
            }
            $this->updateCountInUser($contest['Contest']['user_id'], $contest['Contest']['contest_status_id'], $to_contest_status_id);
        }
        function update_revenue($contest)
        {
            $total_site_revenue_as_contest_holder = $contest['Contest']['creation_cost']-$contest['Contest']['prize'];
            $total_site_revenue_as_participant = $contest['Contest']['site_commision'];
            $site_revenue = $total_site_revenue_as_participant+$total_site_revenue_as_contest_holder;
            $contest_data['Contest']['id'] = $contest['Contest']['id'];
            $contest_data['Contest']['total_site_revenue'] = $site_revenue;
            $this->save($contest_data);
            $this->ContestUser->updateAll(array(
                'ContestUser.site_revenue' => 'ContestUser.site_revenue +' . $site_revenue,
            ) , array(
                'ContestUser.id' => $contest['ContestUser'][0]['id']
            ));
            $this->ContestType->updateAll(array(
                'ContestType.site_revenue' => 'ContestType.site_revenue +' . $site_revenue,
            ) , array(
                'ContestType.id' => $contest['Contest']['contest_type_id']
            ));
			$this->Resource->updateAll(array(
                'Resource.revenue' => 'Resource.revenue +' . $site_revenue,
            ) , array(
                'Resource.id' => $contest['Contest']['resource_id']
            ));
            App::import('Model', 'User');
            $this->User = new User();
            $this->User->updateAll(array(
                'User.total_site_revenue_as_participant' => 'User.total_site_revenue_as_participant +' . $total_site_revenue_as_participant,
                'User.participant_total_earned_amount' => 'User.participant_total_earned_amount +' . $contest['Contest']['prize'],
            ) , array(
                'User.id' => $contest['Contest']['winner_user_id']
            ));
            $this->User->updateAll(array(
                'User.total_site_revenue_as_contest_holder' => 'User.total_site_revenue_as_contest_holder +' . $total_site_revenue_as_contest_holder,
            ) , array(
                'User.id' => $contest['Contest']['user_id']
            ));
        }
        public function getReceiverdata($foreign_id, $transaction_type, $payee_account)
        {
            $contest = $this->find('first', array(
                'conditions' => array(
                    'Contest.id' => $foreign_id
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.email'
                        )
                    ) ,
                ) ,
                'recursive' => 0,
            ));
			if ($transaction_type == ConstPaymentType::ContestUpgradeFee) {
				$return['receiverEmail'] = array(
					$payee_account
				);
				$upgrade = unserialize($contest['Contest']['upgrade']);
				$return['amount'] = array($upgrade['fee']);
				$return['fees_payer'] = 'buyer';
				if (Configure::read('contest.upgrade_fee_payer') == 'Site') {
					$return['fees_payer'] = 'merchant';
				}
			} elseif($transaction_type == ConstPaymentType::ContestExtendTimeFee) {
				$return['receiverEmail'] = array(
					$payee_account
				);
				$upgrade = unserialize($contest['Contest']['upgrade']);
				$return['amount'] = array($upgrade['fee']);
				$return['fees_payer'] = 'buyer';
				if (Configure::read('contest.extend_time_fee_payer') == 'Site') {
					$return['fees_payer'] = 'merchant';
				}
			} elseif($transaction_type == ConstPaymentType::ContestPrize) {
				$return['receiverEmail'] = array(
					$payee_account
				);
				$return['fees_payer'] = 'merchant';
				$return['amount'] = array($contest['Contest']['creation_cost']);
			}
			$return['buyer_email'] = $contest['User']['email'];
			$return['sudopay_gateway_id'] = $contest['Contest']['sudopay_gateway_id'];
			return $return;
		}
		public function processContestUpgradePayment($contest_id, $payment_gateway_id = null)
		{
			$contest = $this->find('first', array(
				'conditions' => array(
				'Contest.id = ' => $contest_id,
				) ,
				'recursive' => -1,
			));
			if(!empty($contest['Contest']['upgrade'])) {
				$_upgrade = unserialize($contest['Contest']['upgrade']);
				$_Data = array();
				$_Data['Contest']['id'] = $contest_id;
				$_Data['Contest']['upgrade'] = $_upgrade['fee'];
				$_Data = array_merge($_Data['Contest'], $_upgrade['fields']);
				if($this->save($_Data)) {
					$transaction_type =
					App::import('Model', 'Transaction');
					$this->Transaction = new Transaction();
					//Update Transaction
					$this->Transaction->log($contest_id, 'Contests.Contest', $payment_gateway_id, $_upgrade['type']);
					return true;
				}
			}
		}
        public function updateCountInUser($user_id, $from_contest_status_id = null, $to_contest_status_id = null)
        {
            $contest_status['ContestStatus.id'] = array(
                $from_contest_status_id,
                $to_contest_status_id
            );
            $contest_statuses = $this->ContestStatus->find('list', array(
                'conditions' => $contest_status,
				'recursive' => -1
            ));
            $update_array = array();
            foreach($contest_statuses as $id => $name) {
                $field = 'contest_' . strtolower(Inflector::underscore(Inflector::camelize($name))) . '_count';
                $count = $this->find('count', array(
                    'conditions' => array(
                        'Contest.user_id' => $user_id,
                        'Contest.contest_status_id' => $id,
                    ),
					'recursive' => -1
                ));
                $update_array['User.' . $field] = $count;
            }
            if (!empty($update_array)) {
                $this->User->updateAll($update_array, array(
					'User.id' => $user_id
				));
            }
        }
        public function postActivity($contest = array() , $from_contest_status_id = null, $to_contest_status_id = null)
        {
			$other_status = array(
                ConstContestStatus::NewEntry,
                ConstContestStatus::Rated,
                ConstContestStatus::Conversation
            );
            $subject = "Contest Activity";
            if ($to_contest_status_id == ConstContestStatus::NewEntry) {
                $subject = "New Entry Posted";
				$data = array();
				$data['User']['id'] = $_SESSION['Auth']['User']['id'];
				$data['User']['is_idle'] = 0;
				$data['User']['is_entry_posted'] = 1;
				$this->User->save($data);
            }
            if ($to_contest_status_id == ConstContestStatus::Rated) {
                $subject = "Rating Added for entry";
				$data = array();
				$data['User']['id'] = $_SESSION['Auth']['User']['id'];
				$data['User']['is_idle'] = 0;
				$data['User']['is_engaged'] = 1;
				$this->User->save($data);
            }
            if (!in_array($to_contest_status_id, $other_status)) {
                $contestStatus = $this->ContestStatus->find('list', array(
                    'conditions' => array(
                        'ContestStatus.id' => array(
                            $from_contest_status_id,
                            $to_contest_status_id
                        )
                    ) ,
                    'recursive' => -1
                ));
                $FindReplace = array(
                    '##CONTEST##' => $contest['Contest']['name'],
                    '##HOLDER_NAME##' => $contest['User']['username'],
                    '##AMOUNT##' => $this->siteCurrencyFormat($contest['Contest']['prize']) ,
                    '##CONTEST_AMOUNT##' => $this->siteCurrencyFormat($contest['Contest']['prize']) ,
                );
                if (!empty($contest['Contest']['winner_user_id'])) {
					$FindReplace = array_merge($FindReplace, array(
                    '##WINNER_USER##' => $contest['WinnerUser']['username'],
                    '##ENTRY_NO##' => '#' . $contest['ContestUser']['0']['entry_no'],
					));
				}
                $contest_status = $this->ContestStatus->find('first', array(
                    'conditions' => array(
                        'ContestStatus.id' => $to_contest_status_id
                    ) ,
                    'recursive' => -1
                ));
                $message = strtr($contest_status['ContestStatus']['message'], $FindReplace);
                $emailFindReplace = array(
                    '##USERNAME##' => $contest['User']['username'],
                    '##CONTEST_NAME##' => $contest['Contest']['name'],
                    '##PREVIOUS_STATUS##' => $contestStatus[$from_contest_status_id],
                    '##CURRENT_STATUS##' => $contestStatus[$to_contest_status_id],
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug'],
                        'admin' => false
                    ) , true)
                );
				App::import('Model', 'EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				$template = $this->EmailTemplate->selectTemplate('Activity Alert Mail');
                if ($this->_checkUserNotifications($contest['User']['id'], 'is_activity_alert_to_contestholder')) {
                    $this->_sendEmail($template, $emailFindReplace, $contest['User']['email']);
                }
				$emailFindReplace = array(
                    '##USERNAME##' => 'admin',
                    '##CONTEST_NAME##' => $contest['Contest']['name'],
                    '##PREVIOUS_STATUS##' => $contestStatus[$from_contest_status_id],
                    '##CURRENT_STATUS##' => $contestStatus[$to_contest_status_id],
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contest['Contest']['slug'],
                        'admin' => false
                    ) , true)
                );
                $this->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
            } else {
                if ($to_contest_status_id == ConstContestStatus::NewEntry) {
                    $contest_user = $contest;
                    $message = ConstActivityMessage::NewEntry;
                    $FindReplace = array(
                        '##CONTEST_USER##' => $contest_user['User']['username'],
                        '##ENTRY_NO##' => '#' . $contest_user['ContestUser']['entry_no'],
                    );
                    $message = strtr($message, $FindReplace);
					$message_options['contest_user_id'] = $contest_user['ContestUser']['id'];
                }
                if ($to_contest_status_id == ConstContestStatus::Rated) {
                    $contest_user = $contest;
                    $message = ConstActivityMessage::Rated;
                    $FindReplace = array(
                        '##CONTEST##' => $contest_user['Contest']['name'],
                        '##ENTRY_NO##' => '#' . $contest_user['ContestUser']['entry_no'],
                        '##CONTEST_USER##' => $contest_user['User']['username'],
                        '##RATED_USER##' => $contest['ContestUserRating'][0]['User']['username'],
                        '##RATING##' => $contest['ContestUserRating'][0]['rating']
                    );
                    $message = strtr($message, $FindReplace);
					$message_options['contest_user_id'] = $contest_user['ContestUser']['id'];
                }
            }
            $message_options = array();
            $message_options['contest_id'] = $contest['Contest']['id'];
            $message_options['contest_status_id'] = $to_contest_status_id;
            if (!empty($contest_user['ContestUser']['id'])) {
                $message_options['contest_user_id'] = $contest_user['ContestUser']['id'];
            }
            if (!empty($contest['ContestUserRating'])) {
                $message_options['contest_user_rating_id'] = $contest['ContestUserRating'][0]['id'];
            }
            $message_options['is_auto'] = 1;
			if(empty($message_options['contest_user_id']) && !empty($contest['Contest']['winner_user_id'])){
				$contest_user = $this->ContestUser->find('first', array(
					'conditions' => array(
						'ContestUser.contest_id' => $contest['Contest']['id'],
						'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
					),
					'recursive' => -1
				));
				$message_options['contest_user_id'] = $contest_user['ContestUser']['id'];
			}
            if ($to_contest_status_id == ConstContestStatus::PaidToParticipant) {
                $to_user = array(
                    $contest['Contest']['winner_user_id']
                );
            } elseif($to_contest_status_id == ConstContestStatus::WinnerSelectedByAdmin && $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) {
				$to_user = array(
                    $contest['Contest']['winner_user_id']
                );
			} else {
                $to_user = array(
                    $contest['User']['id']
                );
            }
			$message_id = $this->Message->sendNotifications($to_user, $subject, $message, $message_options);
        }
        function _postInFacebook($data)
        {
            try {
                $this->facebook->api('/' . (!empty($data['fb_user_id']) ? $data['fb_user_id'] : Configure::read('facebook.page_id')) . '/feed', 'POST', array(
                    'access_token' => (!empty($data['fb_access_token']) ? $data['fb_access_token'] : Configure::read('facebook.fb_access_token')) ,
                    'message' => $data['message'],
                    'picture' => $data['image_url'],
                    'icon' => $data['image_url'],
                    'link' => $data['url'],
                    'caption' => Router::url('/', true) ,
                    'description' => $data['description']
                ));
            }
            catch(Exception $e) {
                $this->log('Post on facebook error');
            }
        }
        function _postInTwitter($data)
        {
            $xml = $this->OauthConsumer->post('Twitter', (!empty($data['twitter_access_token']) ? $data['twitter_access_token'] : Configure::read('twitter.site_user_access_token')) , (!empty($data['twitter_access_key']) ? $data['twitter_access_key'] : Configure::read('twitter.site_user_access_key')) , 'http://api.twitter.com/1/statuses/update.json', array(
                'status' => $data['message']
            ));
        }
		function _checkValidDate(){
			if (strtotime($this->data['Contest']['end_date']) < strtotime(date('Y-m-d'))) {
				return false;
			}
			return true;
		}

		public function processPayment($foreign_id = null, $total_amount = null, $payment_gateway_id = null, $transaction_type = null)
		{
			$contest = $this->find('first', array(
				'conditions' => array(
					'Contest.id = ' => $foreign_id,
				) ,
				'contain' => array(
					'ContestType',
					'Resource'
				) ,
				'recursive' => 0
			));
			if (empty($contest)) {
				throw new NotFoundException(__l('Invalid request'));
			}
			if($transaction_type == ConstPaymentType::ContestPrize) {
				if (empty($contest['Contest']['is_paid'])) {
					$_Data['Contest']['id'] = $foreign_id;
					$_Data['Contest']['contest_status_id'] = ConstContestStatus::Open;
					$_Data['Contest']['is_paid'] = 1;
					$this->save($_Data, false);					
					App::import('Model', 'Transaction');
					$this->Transaction = new Transaction();
					$this->Transaction->log($foreign_id, 'Contest', $payment_gateway_id, ConstTransactionTypes::NewContestAdded);
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'Contest',
							'action' => 'Contest'. $contest_type['ContestType']['resource_id'] .'Posted',
							'label' => 'Step4',
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'cd' => $this->request->data['Contest']['id'],
							'ud' => $this->Auth->user('id'),
							'rud' => $this->Auth->user('referred_by_user_id'),
						)
					));
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
						'_addTrans' => array(
							'order_id' => 'ContestListing-' . $contest['Contest']['id'],
							'name' => $contest['Contest']['name'],
							'total' => (!empty($contest['Contest']['fee_amount']))?$contest['Contest']['fee_amount']:0
						) ,
						'_addItem' => array(
							'order_id' => 'ContestListing-' . $contest['Contest']['id'],
							'sku' => 'C' . $contest['Contest']['id'],
							'name' => $contest['Contest']['name'],
							'category' => $contest['Resource']['name'],
							'unit_price' => $total_amount
						) ,
						'_setCustomVar' => array(
							'cd' => $contest['Contest']['id'],
							'ud' => $_SESSION['Auth']['User']['id'],
							'rud' => $_SESSION['Auth']['User']['referred_by_user_id'],
						)
					));                
					return true;
				} elseif (!empty($contest['Contest']['is_paid'])) {
					return true;
				}
			} else if($transaction_type == ConstPaymentType::ContestUpgradeFee) {
				if(!empty($contest['Contest']['upgrade'])) {
					$_upgrade = unserialize($contest['Contest']['upgrade']);
					if(!empty($_upgrade['fields'])) {
						$contest_data['Contest']['id'] = $foreign_id;
						foreach($_upgrade['fields'] as $key => $field) {
							$contest_data['Contest'][$key] = $field;
							if($key == 'is_blind') {
								$contest_data['Contest']['blind_contest_fee'] = $contest['ContestType']['blind_fee'];
							} elseif($key == 'is_private') {
								$contest_data['Contest']['private_contest_fee'] = $contest['ContestType']['private_fee'];
							} elseif($key == 'is_featured') {
								$contest_data['Contest']['featured_contest_fee'] = $contest['ContestType']['featured_fee'];
							} elseif($key == 'is_highlight') {
								$contest_data['Contest']['highlight_contest_fee'] = $contest['ContestType']['highlight_fee'];
							}
						}
						$this->save($contest_data);
					}
					App::import('Model', 'Transaction');
					$this->Transaction = new Transaction();
					$this->Transaction->log($foreign_id, 'Contest', $payment_gateway_id, ConstTransactionTypes::ContestFeaturesUpdated);
					$contest_updated_data['Contest']['id'] = $foreign_id;
					$contest_updated_data['Contest']['upgrade'] = '';
					$this->save($contest_updated_data);
				}
			} else if($transaction_type == ConstPaymentType::ContestExtendTimeFee) {
				if(!empty($contest['Contest']['upgrade'])) {
					$_upgrade = unserialize($contest['Contest']['upgrade']);
					if(!empty($_upgrade['fields'])) {
						if($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging) {
							$contest_data['Contest']['contest_status_id'] = ConstContestStatus::Open;
						}
						$contest_data['Contest']['id'] = $foreign_id;
						$contest_data['Contest']['actual_end_date'] = $_upgrade['fields']['end_date'];
						$this->save($contest_data);
					}
					App::import('Model', 'Transaction');
					$this->Transaction = new Transaction();
					$this->Transaction->log($foreign_id, 'Contest', $payment_gateway_id, ConstTransactionTypes::ContestTimeExtended);
					$contest_updated_data['Contest']['id'] = $foreign_id;
					$contest_updated_data['Contest']['upgrade'] = '';
					$this->save($contest_updated_data);
				}
			}
			return false;
		 }
    }
