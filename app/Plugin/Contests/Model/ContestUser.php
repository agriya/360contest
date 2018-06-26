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
class ContestUser extends ContestsAppModel
{
    public $name = 'ContestUser';
    public $actsAs = array(
        'SuspiciousWordsDetector' => array(
            'fields' => array(
                'description'
            )
        )
    );
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'ContestUser.contest_user_status_id' => array(
                    ConstContestUserStatus::Active,
                    ConstContestUserStatus::Withdrawn,
                    ConstContestUserStatus::Won,
                    ConstContestUserStatus::Lost,
                ) ,
                'ContestUser.is_system_flagged' => 0,
                'ContestUser.admin_suspend' => 0,
                'ContestUser.is_active' => 1,
            )
        ) ,
        'Contest' => array(
            'className' => 'Contests.Contest',
            'foreignKey' => 'contest_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true,
            'counterScope' => array(
                'ContestUser.is_system_flagged' => 0,
                'ContestUser.admin_suspend' => 0,
                'ContestUser.is_active' => 1,
            )
        ) ,
        'ContestUserStatus' => array(
            'className' => 'Contests.ContestUserStatus',
            'foreignKey' => 'contest_user_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public $hasMany = array(
        'ContestUserView' => array(
            'className' => 'Contests.ContestUserView',
            'foreignKey' => 'contest_user_id',
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
        'ContestUserDownload' => array(
            'className' => 'Contests.ContestUserDownload',
            'foreignKey' => 'contest_user_id',
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
        'Message' => array(
            'className' => 'Contests.Message',
            'foreignKey' => 'contest_user_id',
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
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'ContestUser'
            ) ,
            'dependent' => true,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociatedUsers = array(
            'contest_owner_user_id',
            'user_id',
        );
        $this->_permanentCacheAssociations = array(
            'User',
            'Contest',
        );
        $this->validate = array(
            'user_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'contest_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'description' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
            'title' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
        );
        $this->isFilterOptions = array(
            ConstContestUserStatus::Active => __l('Active') ,
            ConstContestUserStatus::Withdrawn => __l('Withdrawn') ,
            ConstContestUserStatus::Eliminated => __l('Eliminated') ,
            ConstContestUserStatus::Won => __l('Won')
        );
        $this->moreActions = array(
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Withdrawn => __l('Withdrawn') ,
            ConstMoreAction::Eliminated => __l('Eliminated') ,
            ConstMoreAction::Delete => __l('Delete') ,
        );
    }
    function _getEntry($entry_id)
    {
        $conditions = array();
        $conditions = array(
            'ContestUser.id' => $entry_id
        );
        $contestUser = $this->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'Attachment',
                'ContestUserStatus' => array(
                    'fields' => array(
                        'ContestUserStatus.id',
                        'ContestUserStatus.name',
                        'ContestUserStatus.description',
                        'ContestUserStatus.slug',
                    ) ,
                ) ,
                'Contest' => array(
                    'fields' => array(
                        'Contest.id',
                        'Contest.name',
                        'Contest.slug',
                        'Contest.user_id',
                        'Contest.contest_status_id',
                        'Contest.prize',
                        'Contest.winner_selected_date',
                        'Contest.completed_date',
                        'Contest.winner_user_id'
                    ) ,
                    'ContestType' => array(
                        'fields' => array(
                            'ContestType.id',
                            'ContestType.resource_id',
                            'ContestType.is_watermarked',
                        )
                    ) ,
                    'ContestStatus' => array(
                        'fields' => array(
                            'ContestStatus.id',
                            'ContestStatus.name',
                        )
                    ) ,
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
        if (!empty($contestUser)) {
            return $contestUser;
        } else {
            return 0;
        }
    }
    public function updateContestUserCountInUser($contest_user_ids = array() , $to_status_id = null)
    {
        $get_user_id = $this->find('list', array(
            'conditions' => array(
                'ContestUser.id' => $contest_user_ids,
            ) ,
            'fields' => array(
                'ContestUser.user_id',
            ) ,
            'recursive' => -1
        ));
        $contest_user_status['ContestUserStatus.id'] = array(
            $to_status_id
        );
        $contest_user_statuses = $this->ContestUserStatus->find('list', array(
            'conditions' => $contest_user_status,
        ));
        foreach($get_user_id as $user_id) {
            $update_array = array();
            foreach($contest_user_statuses as $id => $name) {
                $field = 'contest_user_' . strtolower(Inflector::underscore(Inflector::camelize($name))) . '_count';
                $count = $this->find('count', array(
                    'conditions' => array(
                        'ContestUser.user_id' => $user_id,
                        'ContestUser.contest_user_status_id' => $id,
                    ) ,
                    'recursive' => -1
                ));
                $update_array['User.' . $field] = $count;
            }
        }
        if (!empty($update_array)) {
            $this->User->updateAll($update_array, array(
                'User.id' => $user_id
            ));
        }
    }
    public function _processEntry($entry_id, $process)
    {
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $request = $this->_getEntry($entry_id);
        if (empty($request)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $request_update = $return = $update_transaction = $pay = $email_template = $update_contest = array();
        $is_update_points = 0;
        $return['Contest'] = $request['Contest'];
        switch ($process) {
            case ConstContestUserStatus::Withdrawn:
                // Updating Status //
                $request_update['ContestUser']['id'] = $request['ContestUser']['id'];
                $request_update['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Withdrawn;
                // Return //
                if ($this->save($request_update)) {
                    $return['success'] = 1;
                    $return['message'] = __l('You\'ve withdrawn this entry successfully.');
                } else {
                    $return['error'] = 1;
                    $return['message'] = __l('Error occured. Please try again later.');
                }
                $emailFindReplace = array(
                    '##PARTICIPANT##' => $request['User']['username'],
                    '##CONTEST_NAME##' => $request['Contest']['name'],
                    '##ENTRY_NO##' => $request['ContestUser']['entry_no'],
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $request['Contest']['slug'],
                        'admin' => false
                    ) , true) ,
                    '##SITE_NAME##' => Configure::read('site.name') ,
                    '##SITE_URL##' => Router::url('/', true) ,
                );
                if ($this->_checkUserNotifications($request['User']['id'], 'is_entry_withdrawn_alert_to_participant')) {
                    $template = $this->EmailTemplate->selectTemplate('Entry Withdrawn Alert To Participant');
                    $this->_sendEmail($template, $emailFindReplace, $request['User']['email']);
                }
                break;

            case ConstContestUserStatus::Deleted:
                // Updating Status //
                $request_update['ContestUser']['id'] = $request['ContestUser']['id'];
                $request_update['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Withdrawn;
                // Return //
                if ($this->save($request_update)) {
                    $return['success'] = 1;
                    $return['message'] = __l('You\'ve Deleted this entry successfully.');
                } else {
                    $return['error'] = 1;
                    $return['message'] = __l('Error occured. Please try again later.');
                }
                $emailFindReplace = array(
                    '##PARTICIPANT##' => $request['User']['username'],
                    '##CONTEST_NAME##' => $request['Contest']['name'],
                    '##ENTRY_NO##' => $request['ContestUser']['entry_no'],
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $request['Contest']['slug'],
                        'admin' => false
                    ) , true) ,
                    '##SUSPICIOUS_CONTENT##' => empty($request['ContestUser']['admin_suspend']) ? '' : 'due to containing suspicious word'
                );
                if ($this->_checkUserNotifications($request['User']['id'], 'is_entry_deleted_alert_to_participant')) {
                    $template = $this->EmailTemplate->selectTemplate('Entry Deleted Alert To Participant');
                    $this->_sendEmail($template, $emailFindReplace, $request['User']['email']);
                }
                break;

            case ConstContestUserStatus::Eliminated:
                // Updating Status //
                $request_update['ContestUser']['id'] = $request['ContestUser']['id'];
                $request_update['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Eliminated;
                // Return //
                if ($this->save($request_update)) {
                    $return['success'] = 1;
                    $return['message'] = __l('You\'ve eliminated this entry successfully.');
                } else {
                    $return['error'] = 1;
                    $return['message'] = __l('Error occured. Please try again later.');
                }
                $emailFindReplace = array(
                    '##PARTICIPANT##' => $request['User']['username'],
                    '##CONTEST_NAME##' => $request['Contest']['name'],
                    '##ENTRY_NO##' => $request['ContestUser']['entry_no'],
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $request['Contest']['slug'],
                        'admin' => false
                    ) , true)
                );
                if ($this->_checkUserNotifications($request['User']['id'], 'is_entry_eliminated_alert_to_participant')) {
                    $template = $this->EmailTemplate->selectTemplate('Entry Eliminated Alert To Participant');
                    $this->_sendEmail($template, $emailFindReplace, $request['User']['email']);
                }
                break;
                //send mail to participant to inform the entry status changed from eleminated status to active status (or) send mail to contest holder to inform the entry status changed from withdrawn status to active status

            case ConstContestUserStatus::Active:
                $cancelWithdrawal = 0;
                if ($request['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn):
                    $cancelWithdrawal = 1;
                endif;
                // Updating Status //
                $request_update['ContestUser']['id'] = $request['ContestUser']['id'];
                $request_update['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Active;
                // Return //
                if ($this->save($request_update)) {
                    $return['success'] = 1;
                    if (!empty($cancelWithdrawal)) {
                        $return['message'] = __l('You\'ve canceled the withdrawn successfully.');
                    } else {
                        $return['message'] = __l('You\'ve canceled the elimination successfully.');
                    }
                } else {
                    $return['error'] = 1;
                    $return['message'] = __l('Error occured. Please try again later.');
                }
                $username = !empty($cancelWithdrawal) ? $request['Contest']['User']['username'] : $request['User']['username'];
                $emailFindReplace = array(
                    '##USERNAME##' => $request['User']['username'],
                    '##CONTEST_NAME##' => $request['Contest']['name'],
                    '##ENTRY_NO##' => $request['ContestUser']['entry_no'],
                    '##ENTRY_URL##' => Router::url(array(
                        'controller' => 'contest_users',
                        'action' => 'view',
                        $request['Contest']['slug'],
                        'entry' => $request['ContestUser']['entry_no'],
                        'admin' => false
                    ) , true) ,
                    '##CONTEST_URL##' => Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $request['Contest']['slug'],
                        'admin' => false
                    ) , true)
                );
                if (!empty($cancelWithdrawal) && ($cancelWithdrawal == 1)) {
                    if ($this->_checkUserNotifications($request['User']['id'], 'is_cancel_withdraw_entry_alert_to_participant')) {
                        $template = $this->EmailTemplate->selectTemplate('Withdraw Entry Cancel Alert To Participant');
                        $this->_sendEmail($template, $emailFindReplace, $request['User']['email']);
                    }
                } else {
                    if ($this->_checkUserNotifications($request['User']['id'], 'is_eliminate_entry_cancel_alert_to_participant')) {
                        $template = $this->EmailTemplate->selectTemplate('Eliminated Entry Cancel Alert To Participant');
                        $this->_sendEmail($template, $emailFindReplace, $request['User']['email']);
                    }
                }
                break;

            case ConstContestUserStatus::Won:
                if ($request['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active && ($request['Contest']['contest_status_id'] == ConstContestStatus::Judging || $request['Contest']['contest_status_id'] == ConstContestStatus::Open) && (($_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) || ($_SESSION['Auth']['User']['id'] == $request['ContestUser']['contest_owner_user_id']))) {
                    // Updating Status //
                    $request_update['ContestUser']['id'] = $request['ContestUser']['id'];
                    $request_update['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Won;
                    if ($this->save($request_update)) {
                        $_data['ContestUser']['contest_id'] = $request['Contest']['id'];
                        $_data['ContestUser']['id'] = $request['Contest']['id'];
                        $this->updateAll(array(
                            'ContestUser.contest_user_status_id' => ConstContestUserStatus::Lost
                        ) , array(
                            'ContestUser.contest_id' => $request['Contest']['id'],
                            'ContestUser.id !=' => $request['ContestUser']['id'],
                            'ContestUser.contest_user_status_id' => ConstContestUserStatus::Active
                        ));
                        $contestUsers = $this->find('all', array(
                            'conditions' => array(
                                'ContestUser.contest_id' => $request['Contest']['id'],
                                'ContestUser.contest_user_status_id' => ConstContestUserStatus::Lost,
                            ) ,
                            'contain' => array(
                                'Contest' => array(
                                    'fields' => array(
                                        'Contest.id',
                                        'Contest.slug',
                                        'Contest.name',
                                    ) ,
                                    'User' => array(
                                        'fields' => array(
                                            'User.id',
                                            'User.username',
                                        )
                                    )
                                ) ,
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
                            'recursive' => 0,
                        ));
                        foreach($contestUsers as $contestUser) {
                            $emailFindReplace = array(
                                '##PARTICIPANT##' => $contestUser['User']['username'],
                                '##CONTEST_NAME##' => $contestUser['Contest']['name'],
                                '##ENTRY_NO##' => $contestUser['ContestUser']['entry_no'],
                                '##ENTRY_URL##' => Router::url(array(
                                    'controller' => 'contest_users',
                                    'action' => 'view',
                                    $contestUser['Contest']['slug'],
                                    'entry' => $contestUser['ContestUser']['entry_no'],
                                    'admin' => false
                                ) , true) ,
                                '##CONTEST_URL##' => Router::url(array(
                                    'controller' => 'contests',
                                    'action' => 'view',
                                    $contestUser['Contest']['slug'],
                                    'admin' => false
                                ) , true) ,
                            );
                            if ($this->_checkUserNotifications($contestUser['User']['id'], 'is_entry_lost_alert_to_participant')) {
                                $template = $this->EmailTemplate->selectTemplate('Entry Lost Alert To Participant');
                                $this->_sendEmail($template, $emailFindReplace, $contestUser['User']['email']);
                            }
                        }
                        // Contest User Won count update
                        App::import('Model', 'User');
                        $this->User = new User();
                        $user_contest_won_count = $this->find('count', array(
                            'conditions' => array(
                                'ContestUser.user_id = ' => $request['ContestUser']['user_id'],
                                'ContestUser.contest_user_status_id = ' => ConstContestUserStatus::Won,
                                'ContestUser.admin_suspend' => 0
                            ) ,
                            'recursive' => -1
                        ));
                        $this->User->updateAll(array(
                            'User.contest_user_won_count' => $user_contest_won_count
                        ) , array(
                            'User.id' => $request['ContestUser']['user_id']
                        ));
                        // Updating Contest //
                        $contest_status = ConstContestStatus::WinnerSelected;
                        if ($_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) {
                            $contest_status = ConstContestStatus::WinnerSelectedByAdmin;
                        }
                        $this->Contest->updateStatus($contest_status, $request['Contest']['id'], null, $request['ContestUser']['user_id']);
                        // Return //
                        $return['success'] = 1;
                        $return['message'] = __l('You\'ve selected the winner');
                    } else {
                        $return['error'] = 1;
                        $return['message'] = __l('Error occured. Please try again later.');
                    }
                }
                break;
        }
        return $return;
    }
    public function beforeDelete($cascade = true)
    {
        $emtry_id = $this->id;
        // Contest User Won count update
        $contestUser = $this->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $emtry_id
            ) ,
            'fields' => array(
                'ContestUser.user_id',
                'ContestUser.contest_user_status_id',
                'ContestUser.admin_suspend'
            ) ,
            'recursive' => -1
        ));
        if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won && empty($contestUser['ContestUser']['admin_suspend'])) {
            App::import('Model', 'User');
            $this->User = new User();
            $this->User->updateAll(array(
                'User.contest_user_won_count' => 'User.contest_user_won_count -' . 1
            ) , array(
                'User.id' => $contestUser['ContestUser']['user_id']
            ));
        }
    }
    public function saveMessageContent($requestData, $userName)
    {
        $message_content['MessageContent']['subject'] = 'Entry Posted by ' . $userName;
        $message_content['MessageContent']['message'] = $requestData['ContestUser']['description'];
        if (!empty($requestData['MessageContent']['text_resource'])) {
            $message_content['MessageContent']['text_resource'] = $requestData['MessageContent']['text_resource'];
        }
        App::import('Model', 'Contests.Message');
        $this->Message = new Message();
        $this->Message->MessageContent->save($message_content);
        $message_id = $this->Message->MessageContent->id;
        return $message_id;
    }
    public function saveAttachment($attach, $upload)
    {
        App::import('Model', 'Contests.Message');
        $this->Message = new Message();
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.contest_user_id' => $attach['Attachment']['foreign_id'],
                'Message.is_activity' => 0,
                'Message.is_sender' => 0
            ) ,
            'recursive' => -1,
            'order' => array(
                'Message.id' => 'desc'
            )
        ));
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class' => 'ContestUser',
                'Attachment.foreign_id' => $attach['Attachment']['foreign_id']
            ) ,
            'recursive' => -1,
            'order' => array(
                'Attachment.id' => 'desc'
            )
        ));
        $this->Message->MessageContent->Attachment->enableUpload(false);
        $this->Message->MessageContent->Attachment->create();
        if (isPluginEnabled('VideoResources') && !empty($upload['Upload'])) {
            if ($upload['Upload']['vimeo_video_id']) {
                $_data['Attachment']['vimeo_video_id'] = $upload['Upload']['vimeo_video_id'];
                $_data['Attachment']['vimeo_thumbnail_url'] = $upload['Upload']['video_url'];
            }
            if ($upload['Upload']['youtube_video_id']) {
                $_data['Attachment']['youtube_video_id'] = $upload['Upload']['youtube_video_id'];
                $_data['Attachment']['youtube_thumbnail_url'] = $upload['Upload']['video_url'];
            }
        }
        if (isPluginEnabled('AudioResources') && !empty($upload['AudioUpload'])) {
            if ($upload['AudioUpload']['audio_url']) {
                $_data['Attachment']['soundcloud_audio_id'] = $upload['AudioUpload']['soundcloud_audio_id'];
                $_data['Attachment']['soundcloud_audio_url'] = $upload['AudioUpload']['audio_url'];
            }
        }
        $_data['Attachment']['class'] = 'MessageContent';
        $_data['Attachment']['message_id'] = $message['Message']['id'];
        $_data['Attachment']['foreign_id'] = $message['Message']['message_content_id'];
        $this->Message->MessageContent->Attachment->save($_data);
    }
    public function _saveMessage($depth = 0, $path = null, $user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $contest_id = null, $contest_user_id = null, $contest_status_id = null, $contest_dispute_id = null, $is_private = 1)
    {
        App::import('Model', 'Contests.Message');
        $this->Message = new Message();
        $message['Message']['depth'] = $depth;
        $message['Message']['path'] = $path;
        $message['Message']['message_content_id'] = $message_id;
        $message['Message']['user_id'] = $user_id;
        $message['Message']['other_user_id'] = $other_user_id;
        $message['Message']['message_folder_id'] = $folder_id;
        $message['Message']['is_private'] = $is_private;
        $message['Message']['is_sender'] = $is_sender;
        $message['Message']['is_read'] = $is_read;
        $message['Message']['parent_message_id'] = $parent_id;
        $message['Message']['size'] = $size;
        $message['Message']['contest_id'] = $contest_id;
        $message['Message']['contest_user_id'] = $contest_user_id;
        $message['Message']['contest_status_id'] = ConstContestStatus::Open;
        $message['Message']['contest_dispute_id'] = $contest_dispute_id;
        $this->Message->create();
        $this->Message->save($message);
        $id = $this->Message->id;
        $message['Message']['id'] = $id;
        $id_converted = base_convert($id, 10, 36);
        $materialized_path = sprintf("%08s", $id_converted);
        $message['Message']['materialized_path'] = $materialized_path;
        $message['Message']['root'] = $id;
        $this->Message->save($message);
        $this->Message->updateAll(array(
            'Message.freshness_ts' => '\'' . date('Y-m-d h:i:s') . '\''
        ) , array(
            'Message.root' => $message['Message']['root']
        ));
        return $id;
    }
    function postEntryActivity($contest = array() , $contest_user_id = null)
    {
        //Post activity
        $post_data = $this->_getEntry($contest_user_id);
        $data = array();
        $data['Contest']['id'] = $contest['Contest']['id'];
        $data['Contest']['last_contest_user_entry_no'] = ($contest['Contest']['last_contest_user_entry_no']+1);
        $this->Contest->save($data);
        $contest_user = $this->find('list', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.admin_suspend' => 0
            ) ,
            'fields' => array(
                'ContestUser.user_id',
                'ContestUser.contest_id',
            ) ,
            'recursive' => -1
        ));
        $contest_user_count = count($contest_user);
        if (!empty($contest_user)) {
            $data = array();
            $data['Contest']['id'] = $contest['Contest']['id'];
            $data['Contest']['partcipant_count'] = $contest_user_count;
            $this->Contest->save($data);
        }
        if ($contest['Contest']['maximum_entry_allowed'] == $contest['Contest']['contest_user_count']+1) {
            $this->Contest->updateStatus(ConstContestStatus::Judging, $contest['Contest']['id']);
        }
        $this->Contest->postActivity($post_data, ConstContestStatus::NewEntry, ConstContestStatus::NewEntry);
    }
    function updateMaxumumEntryNo($contest_id, $contest_user_id)
    {
        $contestEntry = $this->find('first', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest_id
            ) ,
            'fields' => array(
                'MAX(entry_no) AS entry_count'
            ) ,
            'recursive' => -1
        ));
        $entry_no = $contestEntry['0']['entry_count']+1;
        $this->updateAll(array(
            'ContestUser.entry_no' => $entry_no,
        ) , array(
            'ContestUser.id' => $contest_user_id
        ));
        return $entry_no;
    }
}
