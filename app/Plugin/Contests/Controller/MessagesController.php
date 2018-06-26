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
class MessagesController extends AppController
{
    public $name = 'Messages';
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'compose',
            'settings',
            'index',
            'inbox',
            'sentmail',
            'all',
            'starred',
            'v',
            'left_sidebar',
            'home_sidebar',
            'activities',
        )
    );
    public function beforeFilter()
    {
        parent::beforeFilter();
        if (!Configure::read('suspicious_detector.is_enabled') && !Configure::read('suspicious_detector.auto_suspend_message_on_system_flag')) {
            $this->Message->Behaviors->detach('SuspiciousWordsDetector');
        }
        $this->Security->disabledFields = array(
            'Message.filter_id',
            'Message.user_id',
            'Message.other_user_id',
            'Message.contest_id',
            'Message.contest_user_id',
            'Attachment.video',
			'Attachment.audio',
			'Message.parent_message_id',
			'Message.is_private',
            'Contest.id',
			'_wysihtml5_mode',
        );
    }
    public function index($folder_type = 'inbox', $is_starred = 0)
    {
        $this->_redirectGET2Named(array(
            'contest_filter_id',
        ));
        if (!empty($this->request->params['named']['folder_type']) && isset($this->request->params['named']['is_starred'])) {
            $folder_type = $this->request->params['named']['folder_type'];
            $is_starred = $this->request->params['named']['is_starred'];
        } else {
            $this->request->params['named']['folder_type'] = $folder_type;
            $this->request->params['named']['is_starred'] = $is_starred;
        }
        if (empty($this->request->params['named']['contest_id']) and !($this->Auth->user('id'))) {
            $this->Session->setFlash(__l('Authorization Required'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        $condition = array();
        if ($folder_type == 'inbox') {
            $this->pageTitle = __l('Messages - Inbox');
            $condition['Message.is_sender'] = 0;
            $condition['Message.parent_message_id'] = 0;
            $condition['OR'] = array(
                array(
                    'Message.user_id' => $this->Auth->user('id') ,
                    'Message.message_folder_id' => ConstMessageFolder::Inbox
                ) ,
                array(
                    'Message.is_child_replied' => 1,
                    'Message.other_user_id' => $this->Auth->user('id')
                )
            );
        } elseif ($folder_type == 'sent') {
            $this->pageTitle = __l('Messages - Sent Mail');
            $condition = array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 1,
                'Message.message_folder_id' => ConstMessageFolder::SentMail
            );
        } elseif ($folder_type == 'starred') {
            $this->pageTitle = __l('Messages - Starred');
            $condition['Message.user_id'] = $this->Auth->user('id');
        } elseif ($folder_type == 'all') {
            $this->pageTitle = __l('Messages - All');
            $condition['Message.user_id'] = $this->Auth->user('id');
        } else {
            $condition['Message.other_user_id'] = $this->Auth->User('id');
        }
        if (isset($this->request->params['named']['contest_filter_id'])) {
            $condition['Message.contest_id'] = $this->request->params['named']['contest_filter_id'];
            $this->request->data['Message']['contest_filter_id'] = $this->request->params['named']['contest_filter_id'];
        }
        $condition['Message.is_deleted'] = 0;
        if (!empty($folder_type) && $folder_type != 'all') {
            $condition['Message.is_archived'] = 0;
        }
        if ($is_starred) {
            $condition['Message.is_starred'] = 1;
        }
        $condition['MessageContent.admin_suspend'] = 0;
        $order = array(
            'Message.id' => 'desc'
        );
        if (isset($this->request->params['named']['contest_id']) && empty($this->request->params['named']['type']) || (!empty($this->request->params['named']['contest_id']) && (!empty($this->request->params['named']['contet_user_id'])))) {
            $contest_user_ids = $this->Message->Contest->ContestUser->find('list', array(
                'conditions' => array(
                    'ContestUser.admin_suspend' => 1,
                    'ContestUser.contest_id' => $this->request->params['named']['contest_id']
                ) ,
				'recursive' => -1
            ));
            $condition = array();
            $tmp_array = array_keys($contest_user_ids);
            // Quick fix for NOT in array
            array_push($tmp_array, -1);
            $condition['NOT']['Message.contest_user_id'] = $tmp_array;
            $condition['MessageContent.admin_suspend'] = 0;
            $condition['Message.contest_id'] = $this->request->params['named']['contest_id'];
            $condition['Message.is_sender'] = 0;
            $contest = $this->Message->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->params['named']['contest_id']
                ) ,
                'contain' => array(
                    'ContestUser' => array(
                        'User' => array(
                            'fields' => array(
                                'User.username',
                                'User.id',
                            )
                        ) ,
                        'fields' => array(
                            'ContestUser.user_id',
                        )
                    ) ,
                    'User',
                ) ,
                'recursive' => 2
            ));
            $this->set('contest', $contest);
            $condition['Message.is_activity'] = 0;
            if (!empty($this->request->params['named']['contet_user_id'])) {
                $condition['Message.contest_user_id'] = $this->request->params['named']['contet_user_id'];
            }
            if (!empty($this->request->params['named']['filter'])) {
                if ($this->request->params['named']['filter'] == "ascending") {
                    $order = array(
                        'Message.root' => 'asc',
                        'Message.materialized_path' => 'asc'
                    );
                }
                if ($this->request->params['named']['filter'] == "descending") {
                    $order = array(
                        'Message.root' => 'DESC',
                        'Message.materialized_path' => 'asc'
                    );
                }
                if ($this->request->params['named']['filter'] == "freshness") {
                    $order = array(
                        'Message.freshness_ts' => 'DESC',
                        'Message.materialized_path' => 'asc'
                    );
                }
            } else {
                $order = array(
                    'Message.root' => 'asc',
                    'Message.materialized_path' => 'asc'
                );
            }
        } else {
            $condition['Message.parent_message_id'] = 0;
        }
        if (!empty($this->request->params['named']['message_id'])) {
            $tmpMessage = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $this->params['named']['message_id']
                ) ,
                'recursive' => -1
            ));
            unset($condition);
            // tmp fix
            if ($tmpMessage['Message']['message_folder_id'] == ConstMessageFolder::SentMail) {
                $tmpMessageNew = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.message_folder_id' => ConstMessageFolder::Inbox,
                        'Message.message_content_id' => $tmpMessage['Message']['message_content_id'],
                    ) ,
                    'recursive' => -1
                ));
                $condition['Message.materialized_path LIKE '] = $tmpMessageNew['Message']['materialized_path'] . '-%';
            } else {
                $condition['Message.materialized_path LIKE '] = $tmpMessage['Message']['materialized_path'] . '-%';
            }
            $condition['OR'] = array(
                array(
                    'Message.user_id' => $this->Auth->user('id') ,
                    'Message.message_folder_id' => ConstMessageFolder::Inbox
                ) ,
                array(
                    'Message.user_id' => $this->Auth->user('id') ,
                    'Message.message_folder_id' => ConstMessageFolder::SentMail
                )
            );
            $order = array(
                'Message.root' => 'asc',
                'Message.materialized_path' => 'asc'
            );
        }
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == 'activities' || $this->request->params['named']['type'] == 'activities-compact') {
                $condition['Message.is_activity'] = 1;
            }
            if ($this->request->params['named']['type'] == 'closed') {
                $contest_participants = $this->Message->Contest->ContestUser->find('list', array(
                    'conditions' => array(
                        'ContestUser.user_id' => $this->Auth->user('id') ,
                    ) ,
                    'fields' => array(
                        'ContestUser.contest_id'
                    ),
					'recursive' => -1
                ));
                $contest_particitant_completed_ids = $this->Message->Contest->find('list', array(
                    'conditions' => array(
                        'Contest.id' => $contest_participants,
                        'Contest.contest_status_id' => ConstContestStatus::Completed,
                        'Contest.contest_status_id' => ConstContestStatus::PaidToParticipant
                    ) ,
                    'fields' => array(
                        'Contest.id'
                    )
                ));
                $contest_ids = $this->Message->Contest->find('list', array(
                    'conditions' => array(
                        'Contest.user_id' => $this->Auth->user('id') ,
                        'Contest.contest_status_id' => ConstContestStatus::Completed,
                        'Contest.contest_status_id' => ConstContestStatus::PaidToParticipant
                    ) ,
                    'fields' => array(
                        'Contest.id'
                    ),
					'recursive' => -1
                ));
                $contest_ids = array_merge($contest_ids, $contest_particitant_completed_ids);
                $contest_ids = array_unique($contest_ids);
                $condition['Message.contest_id'] = $contest_ids;
            }
        }
        if (!empty($this->request->params['named']['type']) && !empty($this->request->params['named']['contest_id'])) {
            $condition['Message.contest_id'] = $this->request->params['named']['contest_id'];
            $contest_filter = $this->Message->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->params['named']['contest_id']
                ) ,
                'contain' => array(
                    'ContestStatus'
                ),
				'recursive' => -1
            ));
            $this->set('contest_filter', $contest_filter);
        }
        if ($folder_type == 'sent' || $folder_type == 'starred') {
            unset($condition['Message.parent_message_id']);
        }
        $this->paginate = array(
            'conditions' => $condition,
            'recursive' => 2,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username',
                        'User.id',
                        'User.is_facebook_register',
                        'User.facebook_user_id',
                        'User.twitter_avatar_url',
						'User.linkedin_avatar_url',
                        'User.user_avatar_source_id'
                    )
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.username',
                        'OtherUser.id',
                        'OtherUser.role_id',
                        'OtherUser.facebook_user_id',
                        'OtherUser.is_facebook_register',
                        'OtherUser.twitter_avatar_url',
                        'OtherUser.linkedin_avatar_url',
                        'OtherUser.user_avatar_source_id'
                    )
                ) ,
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.id',
                        'MessageContent.subject',
                        'MessageContent.message',
						'MessageContent.text_resource'
                    ) ,
                    'Attachment'
                ) ,
                'Contest' => array(
                    'ContestStatus' => array(
                        'fields' => array(
                            'ContestStatus.name',
                            'ContestStatus.slug'
                        )
                    ) ,
                    'Resource',
					'User'
                ) ,
                'ContestUser' => array(
                    'Attachment'
                )
            ) ,
            'order' => $order
        );
        $contest_conditions = array();
        $contest_conditions['or']['Contest.user_id'] = $this->Auth->user('id');
        $contest_users = $this->Message->ContestUser->find('list', array(
            'conditions' => array(
                'ContestUser.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'ContestUser.contest_id'
            ),
			'recursive' => -1
        ));
        if (!empty($contest_users)) {
            $contest_conditions['or']['Contest.id'] = $contest_users;
        }
        $contests = $this->Message->Contest->find('all', array(
            'conditions' => $contest_conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.is_facebook_register',
                        'User.facebook_user_id',
                        'User.twitter_avatar_url',
                        'User.linkedin_avatar_url',
                        'User.user_avatar_source_id'
                    )
                ) ,
                'ContestUser' => array(
                    'conditions' => array(
                        'or' => array(
                            'ContestUser.user_id' => $this->Auth->user('id') ,
                        )
                    ) ,
                    'fields' => array(
                        'ContestUser.user_id',
                        'ContestUser.id'
                    ) ,
                    'User' => array(
                        'fields' => array(
                            'User.id',
                            'User.username',
                            'User.is_facebook_register',
                            'User.facebook_user_id',
                            'User.twitter_avatar_url',
                            'User.linkedin_avatar_url',
                            'User.user_avatar_source_id'
                        )
                    ) ,
                )
            ) ,
            'fields' => array(
                'Contest.id',
                'Contest.name',
                'Contest.slug',
                'Contest.user_id',
                'Contest.resource_id',
            ),
			'recursive' => 2
        ));
        $contest_list = array();
        foreach($contests as $contest) {
            if ($contest['Contest']['user_id'] == $this->Auth->user('id')) {
                if (!empty($contest['ContestUser'][0]['User']['username'])) {
                    $contest_list[$contest['Contest']['id']] = $contest['Contest']['name'] . ' (' . $contest['ContestUser'][0]['User']['username'] . ')';
                } else {
                    $contest_list[$contest['Contest']['id']] = $contest['Contest']['name'];
                }
            } else {
                $contest_list[$contest['Contest']['id']] = $contest['Contest']['name'] . ' (' . $contest['User']['username'] . ')';
            }
        }
        $ContesParticipatedIds = $this->Message->Contest->ContestUser->find('list', array(
            'conditions' => array(
                'ContestUser.user_id' => $this->Auth->user('id') ,
            ) ,
            'fields' => array(
                'ContestUser.contest_id'
            ) ,
            'recursive' => -1
        ));
        $ContesPostedIds = $this->Message->Contest->find('list', array(
            'conditions' => array(
                'Contest.user_id' => $this->Auth->user('id') ,
                'Contest.contest_status_id' => array(
                    ConstContestStatus::WinnerSelected,
                    ConstContestStatus::WinnerSelectedByAdmin,
                    ConstContestStatus::ChangeRequested,
                    ConstContestStatus::ChangeCompleted,
                    ConstContestStatus::Open,
                    ConstContestStatus::Judging,
                )
            ) ,
            'fields' => array(
                'Contest.id'
            ) ,
            'recursive' => -1
        ));
        $ContesParticipatedIds = array_unique($ContesParticipatedIds);
        $ContestIds = array_merge($ContesParticipatedIds, $ContesPostedIds);
        $contest_own = $this->Message->Contest->find('all', array(
            'conditions' => array(
                'Contest.id' => $ContestIds,
                'Contest.contest_status_id' => array(
                    ConstContestStatus::WinnerSelected,
                    ConstContestStatus::WinnerSelectedByAdmin,
                    ConstContestStatus::ChangeRequested,
                    ConstContestStatus::ChangeCompleted,
                    ConstContestStatus::Open,
                    ConstContestStatus::Judging,
                )
            ) ,
            'contain' => array(
                'User',
                'ContestStatus',
                'ContestUser' => array(
                    'conditions' => array(
                        'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                    ) ,
                    'User'
                )
            ) ,
            'recursive' => 2
        ));
        $activities_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender ' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'Message.is_activity' => 1,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'MessageContent.admin_suspend' => 0
            ),
			'recursive' => 0
        ));
        $this->set('activities_count', $activities_count);
        $contests = $contest_list;
        $statClassArray = Configure::read('conteststatus.class');
        $this->set('statClassArray', $statClassArray);
        $this->set('contests', $contests);
        $this->set('messages', $this->paginate());
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('user_id', $this->Auth->user('id'));
        $this->set('contest_own', $contest_own);
        if ($this->Auth->user('id')) {
            $this->set('mail_options', $this->Message->getMessageOptionArray($folder_type));
        }
        if (isset($this->request->params['named']['contest_id']) && empty($this->request->params['named']['type'])) {
            $this->pageTitle = __l('Message Board - ') . $contest['Contest']['name'];
            $this->render('message_board');
        }
        if ($this->RequestHandler->isAjax() and !empty($this->request->params['named']['message_id'])) {
            $this->render('view_child_ajax');
        }
		if ($this->RequestHandler->isAjax() && !empty($this->request->params['named']['type']) && $this->request->params['named']['type']=='activities-compact') {
            $this->render('activities-notification');
        }
    }
    public function inbox()
    {
        $this->setAction('index', 'inbox');
    }
    public function sentmail()
    {
        $this->setAction('index', 'sent');
    }
    public function all()
    {
        $this->setAction('index', 'all');
    }
    public function starred($folder_type = 'starred')
    {
        $this->setAction('index', $folder_type, 1);
        $this->pageTitle = __l('Messages - Starred');
    }
    public function v($id = null, $folder_type = 'inbox', $is_starred = 0)
    {
        $this->pageTitle = __l('Message');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $id,
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email',
                        'User.is_facebook_register',
                        'User.facebook_user_id',
                        'User.twitter_avatar_url',
                        'User.linkedin_avatar_url',
                        'User.role_id'
                    )
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.email',
                        'OtherUser.username',
                        'OtherUser.role_id'
                    )
                ) ,
                'Contest'
            ) ,
            'recursive' => 2,
        ));
        if (empty($message)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin && $message['Message']['user_id'] != $this->Auth->user('id') && $message['Message']['other_user_id'] != $this->Auth->user('id')) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin && !empty($message['MessageContent']['admin_suspend'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $all_parents = array();
        if (!empty($message['Message']['parent_message_id'])) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $message['Message']['parent_message_id']
                ) ,
                'recursive' => 0
            ));
            $all_parents = $this->_findParent($parent_message['Message']['id']);
        }
        if ($message['Message']['is_read'] == 0 && $message['Message']['user_id'] == $this->Auth->user('id')) {
            $this->request->data['Message']['is_read'] = 1;
            $this->request->data['Message']['id'] = $message['Message']['id'];
            $this->Message->save($this->request->data);
        }
        //Its for display details -> Who got this message
        $select_to_details = $this->Message->find('all', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message['Message']['message_content_id'],
            ) ,
            'recursive' => 0,
            'contain' => array(
                'User.email',
                'User.username',
                'User.id'
            )
        ));
        if (!empty($select_to_details)) {
            $receiverNames = array();
            $show_detail_to = array();
            foreach($select_to_details as $select_to_detail) {
                if ($select_to_detail['Message']['is_sender'] == 0) {
                    if ($this->Auth->User('id') != $select_to_detail['User']['id']) {
                        array_push($receiverNames, __l($select_to_detail['User']['username']));
                    }
                    array_push($show_detail_to, __l($select_to_detail['User']['username']));
                }
            }
            $show_detail_to = implode(', ', $show_detail_to);
            $receiverNames = implode(', ', $receiverNames);
            $this->set('show_detail_to', $show_detail_to);
            $this->set('receiverNames', $receiverNames);
        }
        if (!empty($message['MessageContent']['subject'])) {
            $this->pageTitle.= ' - ' . $message['MessageContent']['subject'];
        }
        $this->set('message', $message);
        $this->set('all_parents', $all_parents);
        $this->set('user_name', $this->Auth->user('username'));
        $this->set('folder_type', $folder_type);
        $this->set('is_starred', $is_starred);
        $this->set('user_id', $this->Auth->user('id'));
        // set the mail options array
        $this->set('mail_options', $this->Message->getMessageOptionArray($folder_type));
        // Set the folder type link
        $back_link_msg = ($folder_type == 'all') ? __l('All mails') : $folder_type;
        $this->set('back_link_msg', $back_link_msg);
    }
    public function left_sidebar()
    {
        $this->set('folder_type', !empty($this->request->params['named']['folder_type']) ? $this->request->params['named']['folder_type'] : '');
        $this->set('is_starred', !empty($this->request->params['named']['is_starred']) ? $this->request->params['named']['is_starred'] : '');
        $this->set('compose', !empty($this->request->params['named']['compose']) ? $this->request->params['named']['compose'] : '');
        $id = $this->Auth->user('id');
        $this->set('inbox', $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => 0,
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 0,
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.admin_suspend ' => 0,
            ),
			'recursive' => 0
        )));
        $this->set('stared', $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'Message.is_starred' => 1,
                'MessageContent.admin_suspend ' => 0,
            ),
			'recursive' => 0
        )));
		$this->set('sent', $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => 1,
                'Message.message_folder_id' => ConstMessageFolder::SentMail,
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'MessageContent.admin_suspend' => 0,
            ),
			'recursive' => 0
        )));
		$this->set('all', $this->Message->find('count', array(
            'conditions' => array(
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.message_folder_id' => array(ConstMessageFolder::SentMail,ConstMessageFolder::Inbox),
                'Message.is_deleted' => 0,
                'Message.is_archived' => 0,
                'MessageContent.admin_suspend' => 0,
            ),
			'recursive' => 0
        )));
    }
    public function compose($id = null, $action = null)
    {
        if (empty($this->request->params['named']) && empty($this->request->data['Message'])) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Messages - Compose');
        if (!empty($this->request->data['Message']['contest_id'])) {
            $contest = $this->Message->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->data['Message']['contest_id']
                ) ,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username',
                            'User.is_facebook_register',
                            'User.facebook_user_id',
                            'User.twitter_avatar_url',
                            'User.linkedin_avatar_url'
                        )
                    ) ,
                    'ContestUser' => array(
                        'User' => array(
                            'fields' => array(
                                'User.username'
                            )
                        ) ,
                    )
                ),
				'recursive' => 1
            ));
            $contest_user = $this->Message->ContestUser->find('first', array(
                'conditions' => array(
                    'ContestUser.contest_id' => $this->request->data['Message']['contest_id'],
                    'ContestUser.user_id' => $contest['Contest']['winner_user_id'],
                    'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                ),
				'recursive' => -1
            ));
        }
        if (!empty($id)) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $id
                ) ,
                'contain' => array(
                    'MessageContent' => array(
                        'Attachment'
                    ) ,
                    'OtherUser'
                ) ,
                'recursive' => 2
            ));
            $all_parents = $this->_findParent($id);
            $this->set('parent_message', $parent_message);
            $this->set('id', $id);
            $this->set('action', $action);
        }
        if (!empty($this->request->data)) {
		 if ($contest['Contest']['resource_id'] == ConstResource::Video && !empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {

             		$this->request->data['Attachment']['filename'] = $this->request->data['Attachment']['video'];
		}elseif ($contest['Contest']['resource_id'] == ConstResource::Audio && !empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {

             		$this->request->data['Attachment']['filename'] = $this->request->data['Attachment']['audio'];
			}
			
		    $is_error = false;
            $path = '';
            $depth = 0;
            if (!empty($this->request->data['Message']['parent_message_id'])) {
                $message_path = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.id' => $this->request->data['Message']['parent_message_id']
                    ) ,
                    'fields' => array(
                        'Message.path',
                        'Message.depth'
                    ) ,
                    'recursive' => -1
                ));
                if (!empty($message_path['Message']['path'])) {
                    $path = $message_path['Message']['path'] . '.P' . $this->request->data['Message']['parent_message_id'];
                } else {
                    $path = 'P' . $this->request->data['Message']['parent_message_id'];
                }
                $depth = $message_path['Message']['depth']+1;
            }
            $attachment_validate = 1;
			if (!empty($this->request->data['Attachment']['filename'])) {
		        $filename = $this->request->data['Attachment']['filename'];
                if (!empty($filename['name'])) {
                    if ($contest['Contest']['user_id'] != $this->Auth->user('id')) {
						if($contest['Contest']['resource_id'] == ConstResource::Image) {
							$this->Message->MessageContent->Attachment->Behaviors->attach('ImageUpload', Configure::read('contestuser.file'));
							if ($filename['type'] != 'image/jpeg' && $filename['type'] != 'image/pjpeg' && $filename['type'] != 'image/jpg' && $filename['type'] != 'image/gif' && $filename['type'] != 'image/png') {
								$this->Message->MessageContent->validationErrors = array();
								$this->Message->MessageContent->Attachment->validationErrors['filename'] = __l('File format not supported');
								$attachment_validate = 0;
							}
						} else if($contest['Contest']['resource_id'] == ConstResource::Video && !$this->RequestHandler->isAjax()) {
							if (!in_array($filename['type'], Configure::read('contestuser.video_file.allowedMime'))) {
								$this->Message->MessageContent->validationErrors = array();
								$this->Message->MessageContent->Attachment->validationErrors['filename'] = __l('File format not supported');
								$attachment_validate = 0;
							}
						} else if($contest['Contest']['resource_id'] == ConstResource::Audio && !$this->RequestHandler->isAjax()) {
							if (!in_array($filename['type'], Configure::read('contestuser.audio_file.allowedMime'))) {
								$this->Message->MessageContent->validationErrors = array();
								$this->Message->MessageContent->Attachment->validationErrors['filename'] = __l('File format not supported');
								$attachment_validate = 0;
							}
						}
					}
                }
            }else if($contest['Contest']['resource_id'] == ConstResource::Text && !$this->RequestHandler->isAjax()) {
				if (!empty($this->request->data['MessageContent']['message_type']) && $this->request->data['MessageContent']['message_type'] != 'message_board'  && empty($this->request->data['MessageContent']['text_resource'])) {
					$this->Message->MessageContent->validationErrors = array();
					$this->Message->MessageContent->validationErrors['text_resource'] = __l('Required');
					$flash_message =  __l('Message has not been added. Please enter the entry');
					$attachment_validate = 0;
				}
			}
			if (!empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry' && $contest['Contest']['resource_id'] == ConstResource::Audio || $contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Image) {
                if (empty($this->request->data['Attachment']['filename']['name'])) {
                    $this->Message->MessageContent->Attachment->validationErrors['filename'] = __l('Please select the file');
                    $attachment_validate = 0;
			    }
            }
            $this->Message->set($this->request->data);
			if ($this->Message->validates() && !empty($attachment_validate)) {
			    if ($contest['Contest']['resource_id'] == ConstResource::Video && !empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {
					if(isPluginEnabled('VideoResources')) {
						App::import('Model', 'VideoResources.Upload');
						$this->Upload = new Upload();
						$this->request->data['Attachment']['video'] = $this->request->data['Attachment']['filename'];
						$this->Upload->uploadVideo($contest_user['ContestUser']['id'], $this->request->data, $this->Auth->user('username') , $this->Auth->user('id') , 1, $contest);
					}
				} else if ($contest['Contest']['resource_id'] == ConstResource::Audio && !empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {
					if(isPluginEnabled('AudioResources')) {
						App::import('Model', 'AudioResources.AudioUpload');
						$this->AudioUpload = new AudioUpload();
						$this->request->data['Attachment']['audio'] = $this->request->data['Attachment']['filename'];
						$this->AudioUpload->uploadAudio($contest_user['ContestUser']['id'], $this->request->data, $this->Auth->user('username') , $this->Auth->user('id') , 1, $contest);
					}
				}else {
                    if (!empty($contest)) {
                        if (!empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'request') {
                            $this->Message->Contest->updateStatus(ConstContestStatus::ChangeRequested, $contest['Contest']['id']);
                        }
                        if (!empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {
                            $this->Message->Contest->updateStatus(ConstContestStatus::ChangeCompleted, $contest['Contest']['id']);
                        }
                    }
                    // To take the admin privacy settings
                    $is_saved = 0;
                    if (!intval(Configure::read('messages.is_allow_send_messsage'))) {
                        $this->Session->setFlash(__l('Message send is temporarily stopped. Please try again later.') , 'default', null, 'error');
                        $this->redirect(array(
                            'action' => 'inbox'
                        ));
                    }
                    if (!empty($this->request->data['Message']['subject'])) {
                        $size = strlen($this->request->data['Message']['message']) +strlen($this->request->data['Message']['subject']);
                    } else {
                        $size = strlen($this->request->data['Message']['message']);
                    }
                    $to_users = array();
                    if (!empty($this->request->data['Message']['to'])) {
                        $contest_user = explode(':', $this->request->data['Message']['to']);
                        if (count($contest_user) > 1) {
                            $this->request->data['Message']['to'] = $contest_user[0];
                            $this->request->data['Message']['contest_user_id'] = $contest_user[1];
                        }
                        $to_users = explode(',', $this->request->data['Message']['to']);
                    }
                    $userList = array();
                    if (!empty($to_users)) {
                        foreach($to_users as $user_to) {
                            // To find the user id of the user
                            $user = $this->Message->User->find('first', array(
                                'conditions' => array(
                                    'User.username' => trim($user_to)
                                ) ,
                                'fields' => array(
                                    'User.id',
                                    'User.email',
                                    'User.username',
                                    'User.is_facebook_register',
                                    'User.facebook_user_id',
                                    'User.twitter_avatar_url',
                                    'User.linkedin_avatar_url'
                                ) ,
                                'recursive' => 0
                            ));
                            if (!empty($user)) {
                                $userList[$user['User']['id']] = $user_to;
                            }
                        }
                    }
                    if ($this->request->data['Message']['to'] == 0) {
                        $to_users[] = 'all';
                        $user[] = 'all';
                    }
                    if (!empty($to_users) && !empty($user)) {
                        //  to save message content
                        if (!empty($this->request->data['Message']['subject'])) {
                            $message_content['MessageContent']['subject'] = $this->request->data['Message']['subject'];
                        }
                        $message_content['MessageContent']['message'] = $this->request->data['Message']['message'];
						if(!empty($this->request->data['MessageContent']['text_resource'])){
							 $message_content['MessageContent']['text_resource'] = $this->request->data['MessageContent']['text_resource'];
						}
                        if (!empty($this->request->data['Message']['message_content_id'])) {
                            $message_content['MessageContent']['id'] = $this->request->data['Message']['message_content_id'];
                            $this->Message->MessageContent->save($message_content);
                            $message_id = $this->request->data['Message']['message_content_id'];
                        } else {
                            $this->Message->MessageContent->create();
                            $this->Message->MessageContent->save($message_content);
                            $message_id = $this->Message->MessageContent->id;
                            $messageContent = $this->Message->MessageContent->find('first', array(
                                'conditions' => array(
                                    'MessageContent.id' => $message_id,
                                ) ,
                                'recursive' => -1
                            ));
                            if (!empty($messageContent['MessageContent']['admin_suspend'])) {
                                $flash_message = !empty($this->request->data['Message']['contest_id']) ? __l('Comment has been suspended due to containing suspicious words') : __l('Message has been suspended due to containing suspicious words');
                                $this->Session->setFlash($flash_message, 'default', null, 'error');
                            } else {
                                $flash_message = !empty($this->request->data['Message']['contest_id']) ? __l('Comment has been posted successfully') : __l('Message has been sent successfully');
                                $this->Session->setFlash($flash_message, 'default', null, 'success');
                            }
                        }
                        if (!empty($this->request->data['Attachment'])) {
                            $filename = array();
                            $filename = $this->request->data['Attachment']['filename'];
                            if (!empty($filename['name'])) {
                                $attachment['Attachment']['filename'] = $filename;
                                $attachment['Attachment']['class'] = 'MessageContent';
                                $attachment['Attachment']['description'] = 'message';
                                $attachment['Attachment']['foreign_id'] = $message_id;
                                $this->Message->MessageContent->Attachment->set($attachment);
                                $this->Message->MessageContent->Attachment->create();
                                $this->Message->MessageContent->Attachment->save($attachment);
                                $size+= $filename['size'];
                            }
                        }
                        foreach($to_users as $user_to) {
                            // To find the user id of the user
                            $user = $this->Message->User->find('first', array(
                                'conditions' => array(
                                    'User.username' => trim($user_to)
                                ) ,
                                'fields' => array(
                                    'User.id',
                                    'User.email',
                                    'User.username',
                                ) ,
                                'recursive' => -1
                            ));
                            if (empty($user) and $user_to == 0) {
                                $user['User']['id'] = $user_to;
                            }
                            if ($user_to == 'all') {
                                $user['User']['id'] = 0;
                            }
                            if (!empty($user)) {
                                $is_send_message = true;
                                // to check for allowed message sizes
                                $allowed_size = higher_to_bytes(Configure::read('messages.allowed_message_size') , Configure::read('messages.allowed_message_size_unit'));
                                $total_used_size = $this->Message->myUsedSpace();
                                if ($is_send_message) {
                                    if (!empty($this->request->data['Message']['parent_message_id'])) {
                                        $parent_id = $this->request->data['Message']['parent_message_id'];
                                    } else {
                                        $parent_id = 0;
                                    }
                                    $folder_id = ConstMessageFolder::Inbox;
                                    $contest_id = !empty($this->request->data['Message']['contest_id']) ? $this->request->data['Message']['contest_id'] : 0;
                                    $contest_user_id = !empty($this->request->data['Message']['contest_user_id']) ? $this->request->data['Message']['contest_user_id'] : 0;
                                    $contest_status_id = !empty($this->request->data['Message']['contest_status_id']) ? $this->request->data['Message']['contest_status_id'] : 0;
                                    if (isset($this->request->data['Message']['is_private'])) {
                                        if (!empty($contest) && $contest['Contest']['user_id'] == $this->Auth->user('id') && !empty($this->request->data['Message']['to'])) {
                                            $is_provate = 1;
                                        } else {
                                            $is_provate = $this->request->data['Message']['is_private'];
                                        }
                                    } else {
                                        if ($user['User']['id'] == 0) {
                                            $is_provate = 0;
                                        } else {
                                            $is_provate = 1;
                                        }
                                    }
                                    if (!empty($contest)) {
                                        $contest_status_id = $contest['Contest']['contest_status_id'];
                                    }
                                    // To save in inbox //
                                    $msg = $is_saved = $this->_saveMessage($depth, $path, $user['User']['id'], $this->Auth->user('id') , $message_id, $folder_id, 0, 0, $parent_id, $size, $contest_id, $contest_user_id, $contest_status_id, $is_provate);
                                    // To save in sent iteams //
                                    $is_saved = $this->_saveMessage($depth, $path, $this->Auth->user('id') , $user['User']['id'], $message_id, ConstMessageFolder::SentMail, 1, 1, $parent_id, $size, $contest_id, $contest_user_id, $contest_status_id, $is_provate);
                                    if (empty($is_private) && !empty($contest_id)) {
										$contest = $this->Message->Contest->find('first', array(
											'conditions' => array(
												'Contest.id' => $contest_id
											) ,
											'contain' => array(
												'User'
											) ,
											'recursive' => 0
										));
										Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
											'_trackEvent' => array(
												'category' => 'User',
												'action' => 'ContestCommented',
												'label' => $this->Auth->user('username') ,
												'value' => '',
											) ,
											'_setCustomVar' => array(
												'ud' => $this->Auth->user('id') ,
												'rud' => $this->Auth->user('referred_by_user_id') ,
											)
										));
										Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
											'_trackEvent' => array(
												'category' => 'ContestComment',
												'action' => 'ContestCommented',
												'label' => $contest['Contest']['id'],
												'value' => '',
											) ,
											'_setCustomVar' => array(
												'cd' => $contest['Contest']['id'],
												'ud' => $this->Auth->user('id') ,
												'rud' => $this->Auth->user('referred_by_user_id') ,
											)
										));
									}
									// To send email when post comments
                                    $messageContent = $this->Message->MessageContent->find('first', array(
                                        'conditions' => array(
                                            'MessageContent.id' => $message_id,
                                        ) ,
										'recursive' => -1
                                    ));
                                    if (Configure::read('messages.is_send_email_on_new_message') && !$messageContent['MessageContent']['admin_suspend']) {
                                        if (!empty($user['User']['email'])) {
                                            if ($this->Message->_checkUserNotifications($user['User']['id'], 'is_notification_for_new_message')) {
                                                $this->_sendAlertOnNewMessage($user['User']['email'], $user['User']['username'], $this->request->data['Message']['message'], $message_id, $user['User']['id']);
                                            }
                                        }
                                    }
                                    if ($this->RequestHandler->isAjax()) {
                                        if (!empty($this->request->data['Message']['quickreply'])) {
                                            $this->redirect(array(
                                                'controller' => 'messages',
                                                'action' => 'view_ajax',
                                                $msg,
                                                'type' => 'message_board'
                                            ));
                                        } else {
                                            echo 'redirect*' . $this->request->data['Message']['redirect_url'];
                                            exit;
                                        }
                                    } else {
                                        if (!empty($this->request->data['Message']['redirect_url'])) {
                                            if (!empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'request') {
                                                if (!empty($messageContent['MessageContent']['admin_suspend'])) {
                                                    $this->Session->setFlash(__l('Request for change has been suspended due to containing suspicious words') , 'default', null, 'error');
                                                } else {
                                                    $this->Session->setFlash(__l('Request for change has been sent successfully') , 'default', null, 'success');
                                                }
                                            } elseif (!empty($this->request->data['Message']['request_type']) && $this->request->data['Message']['request_type'] == 'revised_entry') {
                                                if (!empty($messageContent['MessageContent']['admin_suspend'])) {
                                                    $this->Session->setFlash(__l('Revised entry has been suspended due to containing suspicious words and that will be approved or deleted after administrative reviewing') , 'default', null, 'error');
                                                } else if($contest['Contest']['resource_id'] == ConstResource::Image || $contest['Contest']['resource_id'] == ConstResource::Text){
													 $this->Session->setFlash(__l('Revised entry has been sent for successfully') , 'default', null, 'success');
												}else {
                                                    $this->Session->setFlash(__l('Revised entry has been sent for processing. Please check the status in your participations list') , 'default', null, 'success');
                                                }
                                            }
                                            $this->redirect($this->request->data['Message']['redirect_url']);
                                        } else {
                                            if (!empty($messageContent['MessageContent']['admin_suspend'])) {
                                                $flash_message = !empty($this->request->data['Message']['contest_id']) ? __l('Comment has been suspended due to containing suspicious words') : __l('Message has been suspended due to containing suspicious words');
                                                $this->Session->setFlash($flash_message, 'default', null, 'error');
                                            } else {
                                                $flash_message = !empty($this->request->data['Message']['contest_id']) ? __l('Comment has been posted successfully') : __l('Message has been sent successfully');
                                                $this->Session->setFlash($flash_message, 'default', null, 'success');
                                            }
                                            if ($this->request->data['Message']['message_type'] == 'inbox') {
                                                $this->redirect(array(
                                                    'controller' => 'messages',
                                                    'action' => 'index',
                                                ));
                                            } else {
                                                if (!empty($this->request->data['Message']['contest_id']) && $this->request->data['Message']['contest_id'] != 0) {
                                                    $this->redirect(array(
                                                        'controller' => 'contests',
                                                        'action' => 'view',
                                                        $contest['Contest']['slug'],
                                                    ));
                                                } else {
                                                    $this->redirect(array(
                                                        'controller' => 'contest_users',
                                                        'action' => 'view',
                                                        $contest['Contest']['slug'],
                                                        'entry' => $this->request->data['Message']['entry'],
                                                        'page' => $this->request->data['Message']['page']
                                                    ));
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $this->Session->setFlash(__l('Problem in sending message. You can send message only to your friends network') , 'default', null, 'error');
                                }
                            }
                        }
                    } else {
                        $is_error = true;
                        if (!empty($this->request->data['Message']['to'])) {
                            $this->Session->setFlash(sprintf(__l('Please specify coreect recipient')) , 'default', null, 'error');
                        } else {
                            $this->Session->setFlash(sprintf(__l('Please specify atleast one recipient')) , 'default', null, 'error');
                        }
                        if (empty($this->request->data)) {
                            $this->redirect(array(
                                'action' => 'compose'
                            ));
                        }
                    }
                    if (!$is_error) {
                        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                            $this->redirect(array(
                                'action' => 'activities',
                                'admin' => true,
                                'contest_id' => $this->request->data['Message']['contest_id'],
                            ));
                        } elseif (!empty($this->request->data['Message']['contest_id'])) {
                            $this->redirect(array(
                                'controller' => 'messages',
                                'action' => 'index',
                                'contest_id' => $this->request->data['Message']['contest_id']
                            ));
                        }
                        $this->redirect(array(
                            'action' => 'inbox'
                        ));
                    }
                }
            } else {
			    if (empty($attachment_validate) && $this->request->data['Message']['redirect_url']) {
					if($contest['Contest']['resource_id'] == ConstResource::Text){
						$this->Session->setFlash($flash_message, 'default', null, 'error');
					}else{
						$this->Session->setFlash($this->Message->MessageContent->Attachment->validationErrors['filename'], 'default', null, 'error');
					}
					$this->redirect($this->request->data['Message']['redirect_url']);
			    }
                if (!empty($this->request->data) && !empty($this->request->data['Message']['message_type']) && !empty($this->request->data['Message']['contest_id'])) {
                    $this->request->params['named']['contest_id'] = $this->request->data['Message']['contest_id'];
                }
            }
        }
        if (!empty($parent_message)) {
            if (!empty($action)) {
                if (!empty($this->request->params['named']['reply_type'])) {
                    $this->pageTitle = __l('Messages - Reply');
                }
                $this->request->data['Message']['message'] = $parent_message['MessageContent']['message'];
                $this->request->data['Message']['message_reply'] = $parent_message['MessageContent']['message'];
                if (empty($parent_message['Message']['is_private'])) {
                    $this->request->data['Message']['to'] = 0;
                } else {
                    $this->request->data['Message']['to'] = $parent_message['OtherUser']['username'];
                }
                $this->request->data['Message']['parent_message_id'] = $parent_message['Message']['id'];
                $this->request->data['Message']['is_private'] = $parent_message['Message']['is_private'];
                switch ($action) {
                    case 'reply':
                        $this->request->data['Message']['subject'] = __l('Re:') . $parent_message['MessageContent']['subject'];
                        $this->set('all_parents', $all_parents);
                        $this->request->data['Message']['contest_id'] = $parent_message['Message']['contest_id'];
                        $this->request->data['Message']['type'] = 'reply';
                        break;

                    case 'forword':
                        $this->request->data['Message']['subject'] = __l('Fwd:') . $parent_message['MessageContent']['subject'];
                        $this->request->data['Message']['to'] = '';
                        break;
                }
            }
        }
        $user_settings = $this->Message->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'UserProfile.message_page_size',
                'UserProfile.message_signature'
            ) ,
            'recursive' => -1
        ));
        if (!empty($user_settings['UserProfile']['message_signature'])) {
            if (!empty($this->request->data['Message']['message'])) {
                $this->request->data['Message']['message'].= $user_settings['UserProfile']['message_signature'];
            } else {
                $this->request->data['Message']['message'] = $user_settings['UserProfile']['message_signature'];
            }
        }
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->Message->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['user']
                ) ,
                'fields' => array(
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (!isset($this->request->data['Message']['to'])) {
                $this->request->data['Message']['to'] = $user['User']['username'];
                if (!empty($this->request->params['named']['contest_id']) && !empty($this->request->params['named']['contest_type'])) {
                    $contest_user_id = $this->Message->Contest->ContestUser->find('first', array(
                        'conditions' => array(
                            'ContestUser.contest_id' => $this->request->params['named']['contest_id'],
                            'ContestUser.entry_no' => $this->request->params['named']['contest_type'],
                        ),
						'recursive' => -1
                    ));
                    $this->request->data['Message']['to'] = $user['User']['username'] . ':' . $contest_user_id['ContestUser']['id'];
                }
            }
        }
        if (!empty($this->request->params['named']['contest_id']) && !empty($this->request->params['named']['contest_type'])) {
            $contest_user_id = $this->Message->Contest->ContestUser->find('first', array(
                'conditions' => array(
                    'ContestUser.contest_id' => $this->request->params['named']['contest_id'],
                    'ContestUser.entry_no' => $this->request->params['named']['contest_type'],
                ),
				'recursive' => -1
            ));
            $this->request->data['Message']['contest_user_id'] = $contest_user_id['ContestUser']['id'];
        }
        if (!empty($this->request->params['named']['contest_user'])) {
            $this->request->data['Message']['contest_user'] = $this->request->params['named']['contest_user'];
        }
        if (!empty($this->request->params['named']['message_type'])) {
            $this->request->data['Message']['message_type'] = $this->request->params['named']['message_type'];
        } else {
            $this->request->data['Message']['message_type'] = 'message_board';
        }
        if (!empty($this->request->params['named']['m_path'])) {
            $this->request->data['Message']['m_path'] = $this->request->params['named']['m_path'];
        } else {
            $this->request->data['Message']['m_path'] = '';
        }
        if (!empty($this->request->params['named']['root'])) {
            $this->request->data['Message']['root'] = $this->request->params['named']['root'];
        } else {
            $this->request->data['Message']['root'] = 0;
        }
        if (!empty($this->request->params['named']['to'])) {
            $this->request->data['Message']['to'] = $this->request->params['named']['to'];
        }
        if (!empty($this->request->params['named']['page'])) {
            $this->request->data['Message']['page'] = $this->request->params['named']['page'];
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'contact')) {
            $this->render('message_compose');
        }
        if (!empty($this->request->params['named']['contest_id'])) {
            $contest = $this->Message->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->params['named']['contest_id']
                ) ,
                'fields' => array(
                    'Contest.name',
                    'Contest.user_id',
                    'Contest.id',
                    'Contest.slug',
                    'Contest.winner_user_id',
                    'Contest.contest_status_id',
                    'Contest.resource_id',
                ) ,
                'contain' => array(
                    'ContestUser' => array(
                        'conditions' => array(
                            'ContestUser.admin_suspend' => 0
                        ) ,
                        'User' => array(
                            'fields' => array(
                                'User.username',
                                'User.is_facebook_register',
                                'User.facebook_user_id',
                                'User.twitter_avatar_url',
                                'User.linkedin_avatar_url'
                            )
                        ) ,
                    )
                ) ,
                'recursive' => 2
            ));
            $this->set('contest', $contest);
            $this->request->data['Message']['contest_id'] = $this->request->params['named']['contest_id'];
            if ($contest['Contest']['user_id'] == $this->Auth->user('id')) {
                $entries = array();
                if ($contest['Contest']['contest_status_id'] > ConstContestStatus::Judging) {
                    foreach($contest['ContestUser'] as $contest_user) {
                        if ($contest_user['contest_user_status_id'] == ConstContestUserStatus::Won) {
                            if (!empty($contest_user['User']['username'])) {
                                $user_entries = $contest_user['User']['username'] . ":" . $contest_user['id'];
                                $entries[$user_entries] = $contest_user['User']['username'] . ' (#' . $contest_user['entry_no'] . ')';
                            }
                            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'winner') {
                                $this->request->data['Message']['to'] = $user_entries;
                            }
                            break;
                        }
                    }
                } else {
                    foreach($contest['ContestUser'] as $contest_user) {
                        if ($contest_user['contest_user_status_id'] != ConstContestUserStatus::Won) {
                            if (!empty($contest_user['User']['username'])) {
                                $user_entries = $contest_user['User']['username'] . ":" . $contest_user['id'];
                                $entries[$user_entries] = $contest_user['User']['username'] . ' (#' . $contest_user['entry_no'] . ')';
                            }
                        }
                    }
                    foreach($contest['ContestUser'] as $contest_user) {
                        if ($contest_user['contest_user_status_id'] == ConstContestUserStatus::Won) {
                            if (!empty($contest_user['User']['username'])) {
                                $user_entries = $contest_user['User']['username'] . ":" . $contest_user['id'];
                                $entries[$user_entries] = $contest_user['User']['username'] . ' (#' . $contest_user['entry_no'] . ')';
                            }
                            if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'winner') {
                                $this->request->data['Message']['to'] = $user_entries;
                            }
                            break;
                        }
                    }
                }
                $select_array = array();
                if (!empty($entries)) {
                    $select_array = array(
                        __l('Public') => array(
                            '0' => __l('Post to all')
                        ) ,
                        sprintf(__l('Private to %s') , Configure::read('contest.participant_alt_name_singular_caps')) => array(
                            $entries
                        )
                    );
                } else {
                    $select_array = array(
                        __l('Public') => array(
                            '0' => __l('Post to all')
                        ) ,
                    );
                }
                $this->set('select_array', $select_array);
            }
            if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'request' || $this->request->params['named']['type'] == 'revised_entry') || !empty($this->request->data['Message']['request_type'])) {
                if (!empty($this->request->data['Message']['request_type'])) {
                    $this->request->params['named']['type'] = $this->request->data['Message']['request_type'];
                }
                $contest_user = $this->Message->Contest->ContestUser->find('first', array(
                    'conditions' => array(
                        'ContestUser.user_id' => $contest['Contest']['winner_user_id'],
                        'ContestUser.contest_id' => $contest['Contest']['id'],
                        'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                    ) ,
                    'recursive' => -1
                ));
                if ($this->request->params['named']['type'] == 'request') {
                    $winner_user = $this->Message->User->find('first', array(
                        'conditions' => array(
                            'User.id' => $contest['Contest']['winner_user_id']
                        ) ,
                        'recursive' => -1
                    ));
                    $this->request->data['Message']['contest_user_id'] = $contest_user['ContestUser']['id'];
                    $this->request->data['Message']['to'] = $winner_user['User']['username'];
                } else {
                    $this->request->data['Message']['contest_user_id'] = $contest_user['ContestUser']['id'];
                }
				if($contest['Contest']['resource_id'] == ConstResource::Video) {
					if(isPluginEnabled('VideoResources')) {
						App::import('Model', 'VideoResources.Upload');
						$this->Upload = new Upload();
						$upload = $this->Upload->find('first', array(
							'conditions' => array(
								'Upload.contest_user_id' => $contest_user['ContestUser']['id'],
								'Upload.upload_status_id' => ConstUploadStatus::Processing
							),
							'recursive' => -1
						));
						$this->set('upload', $upload);
					}
				}else if($contest['Contest']['resource_id'] == ConstResource::Audio) {
					if(isPluginEnabled('AudioResources')) {
						App::import('Model', 'AudioResources.AudioUpload');
						$this->AudioUpload = new AudioUpload();
						$upload = $this->AudioUpload->find('first', array(
							'conditions' => array(
								'AudioUpload.contest_user_id' => $contest_user['ContestUser']['id'],
								'AudioUpload.upload_status_id' => ConstUploadStatus::Processing
							),
							'recursive' => -1
						));
						$this->set('upload', $upload);
					}
				}
                $this->render('message_request');
            }
        }
        if (empty($this->request->params['named']['reply_type'])) {
            $conditions = array();
            $conditions['User.role_id <>'] = ConstUserTypes::Admin;
            $conditions['User.id <>'] = $this->Auth->user('id');
            if (!empty($contest) && !empty($contest['ContestUser'][0]['user_id'])) {
                $conditions['User.id'] = $contest['ContestUser'][0]['user_id'];
            }
            $users = $this->Message->User->find('list', array(
                'conditions' => $conditions,
				'recursive' => -1
            ));
            $new_users = array();
            foreach($users as $user) {
                $new_users[$user] = $user;
            };
            $users = $new_users;
            $to_options = array(
                __l('Public') => array(
                    'Public' => __l('Post to all') ,
                ) ,
                __l('Selecte a') . ' ' . Configure::read('site.name') => $users
            );
            $this->set('to_options', $to_options);
            $contestids = $this->Message->ContestUser->find('list', array(
                'conditions' => array(
                    'ContestUser.user_id' => $this->Auth->user('id') ,
                ) ,
                'fields' => array(
                    'ContestUser.contest_id'
                ),
				'recursive' => -1
            ));
            $contest_list_conditions['OR']['Contest.id'] = $contestids;
            $contest_list_conditions['OR']['Contest.user_id'] = $this->Auth->user('id');
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                unset($contest_list_conditions);
                $contest_list_conditions = array();
            }
            $contests = $this->Message->Contest->find('all', array(
                'conditions' => $contest_list_conditions,
                'contain' => array(
                    'User' => array(
                        'fields' => array(
                            'User.username',
                            'User.id',
                            'User.is_facebook_register',
                            'User.facebook_user_id',
                            'User.twitter_avatar_url',
                            'User.linkedin_avatar_url'
                        )
                    ) ,
                    'ContestUser' => array(
                        'User' => array(
                            'fields' => array(
                                'User.username',
                                'User.id',
                            )
                        )
                    )
                ) ,
                'recursive' => 3,
            ));
            $contest_list = array();
            foreach($contests as $contest) {
                if ($contest['Contest']['user_id'] == $this->Auth->user('id')) {
                    if (!empty($contest['ContestUser'][0]['User']['username'])) {
                        $contest_list[$contest['Contest']['id']] = $contest['Contest']['name'] . ' - ' . $contest['ContestUser'][0]['User']['username'];
                    } else {
                        $contest_list[$contest['Contest']['id']] = $contest['Contest']['name'];
                    }
                } else {
                    $contest_list[$contest['Contest']['id']] = $contest['Contest']['name'] . ' - ' . $contest['User']['username'];
                }
            }
            $this->set('contests', $contest_list);
            $this->request->data['Message']['message'] = '';
        }
        $this->request->data['Message']['message'] = '';
    }
    public function _sendAlertOnNewMessage($email, $username, $message, $message_id, $user_id)
    {
        $get_message_hash = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id = ' => $message_id,
                'Message.is_sender' => 0
            ) ,
            'fields' => array(
                'Message.id',
            ) ,
            'recursive' => -1
        ));
        $email_replace = array(
            '##OTHERUSERNAME##' => $username,
            '##USERNAME##' => $this->Auth->user('username') ,
            '##MESSAGE_LINK##' => Router::url(array(
                'controller' => 'messages',
                'action' => 'v',
                $get_message_hash['Message']['id'],
            ) , true) ,
            '##MESSAGE##' => $message
        );
		App::import('Model', 'EmailTemplate');
		$this->EmailTemplate = new EmailTemplate();
		$template = $this->EmailTemplate->selectTemplate('New Message');
        $this->Message->_sendEmail($template, $email_replace, $email);
    }
    public function _sendMail($to, $subject, $body, $format = 'text')
    {
        $from = Configure::read('site.no_reply_email');
        $subject = $subject;
        $this->Email->from = $from;
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->sendAs = $format;
        return $this->Email->send($body);
    }
    public function _saveMessage($depth = 0, $path = null, $user_id, $other_user_id, $message_id, $folder_id, $is_sender = 0, $is_read = 0, $parent_id = null, $size, $contest_id = null, $contest_user_id = null, $contest_status_id = null, $is_private = 1)
    {
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
        $message['Message']['contest_status_id'] = $contest_status_id;
        if (!empty($this->request->data['Message']['contest_id'])) {
            $message['Message']['contest_id'] = $this->request->data['Message']['contest_id'];
        }
        $this->Message->create();
        $this->Message->save($message);
        $id = $this->Message->id;
        $message['Message']['id'] = $id;
        $id_converted = base_convert($id, 10, 36);
        $materialized_path = sprintf("%08s", $id_converted);
        if (empty($this->request->data['Message']['m_path'])) {
            $message['Message']['materialized_path'] = $materialized_path;
        } else {
            $message['Message']['materialized_path'] = $this->request->data['Message']['m_path'] . '-' . $materialized_path;
        }
        if (empty($this->request->data['Message']['root'])) {
            $message['Message']['root'] = $id;
        } else {
            $message['Message']['root'] = $this->request->data['Message']['root'];
        }
        $RootMessage = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id' => $message['Message']['root'],
            ) ,
            'recursive' => -1
        ));
        if (!empty($RootMessage)) {
            $message['Message']['contest_user_id'] = $RootMessage['Message']['contest_user_id'];
        }
        $this->Message->save($message);
        $this->Message->updateAll(array(
            'Message.freshness_ts' => '\'' . date('Y-m-d h:i:s') . '\''
        ) , array(
            'Message.root' => $message['Message']['root'],
        ));
        $this->Message->updateAll(array(
            'Message.is_read' => 0
        ) , array(
            'Message.id' => $message['Message']['root'],
            'Message.other_user_id != ' => $this->Auth->User('id')
        ));
        if (!empty($this->request->data['Message']['root'])) {
            $this->Message->updateAll(array(
                'Message.is_child_replied' => 1
            ) , array(
                'Message.id' => $this->request->data['Message']['root']
            ));
        }
        return $id;
    }
    public function download($id = null, $attachment_id = null)
    {
        //checking Authontication
        if (empty($id) or empty($attachment_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $message_content = $this->Message->MessageContent->find('first', array(
            'conditions' => array(
                'MessageContent.id =' => $id,
            ) ,
            'recursive' => 0
        ));
        if (empty($message_content)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('Attachment');
        $file = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.id =' => $attachment_id,
                'Attachment.class =' => 'MessageContent',
            ) ,
            'recursive' => -1
        ));
        if ($file['Attachment']['foreign_id'] != $message_content['MessageContent']['id']) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $mime_type = $file['Attachment']['mimetype'];
        $filename = substr($file['Attachment']['filename'], 0, strrpos($file['Attachment']['filename'], '.'));
        $file_extension = substr($file['Attachment']['filename'], strrpos($file['Attachment']['filename'], '.') +1, strlen($file['Attachment']['filename']));
        $file_path = str_replace('\\', '/', 'media' . DS . $file['Attachment']['dir'] . DS . $file['Attachment']['filename']);
        // Code to download
        Configure::write('debug', 0);
        $this->viewClass = 'Media';
        $this->set('name', trim($filename));
        $this->set('download', true);
        $this->set('extension', trim($file_extension));
        $this->set('mimeType', trim($mime_type));
        $this->set('path', $file_path);
    }
    // public function move_to . One copy of this action is in search action
    // If do change change.. please also make in search action
    public function move_to()
    {
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['Message']['Id'])) {
                // To show alert message when message is not selected
                // By checking if any of the (Message id,value) pair have value=1
                if (!in_array('1', $this->request->data['Message']['Id'])) {
                    $this->Session->setFlash('No messages selected.', 'default', null, 'error');
                } else {
                    $do_action = '';
                    if (isset($this->request->data['Message']['more_action_1']) and $this->request->data['Message']['more_action_1'] != 'More actions') {
                        $do_action = $this->request->data['Message']['more_action_1'];
                    } elseif (isset($this->request->data['Message']['more_action_2']) and $this->request->data['Message']['more_action_2'] != 'More actions') {
                        $do_action = $this->request->data['Message']['more_action_2'];
                    }
                    foreach($this->request->data['Message']['Id'] AS $message_id => $is_checked) {
                        if ($is_checked) {
                            //	For make archived.  -- Change Status
                            if (!empty($this->request->data['Message']['Archive'])) {
                                $this->_make_archive($message_id);
                            }
                            //	Its from the Dropdown
                            switch ($do_action) {
                                case 'Mark as read':
                                    $this->_make_read($message_id, 1);
                                    break;

                                case 'Mark as unread':
                                    $this->_make_read($message_id, 0);
                                    break;

                                case 'Add star':
                                    $this->_make_starred($message_id, 1);
                                    break;

                                case 'Remove star':
                                    $this->_make_starred($message_id, 0);
                                    break;

                                case 'Move to inbox':
                                    $this->_change_folder($message_id, ConstMessageFolder::Inbox);
                                    $message = $this->Message->find('first', array(
                                        'conditions' => array(
                                            'Message.user_id =' => $this->Auth->User('id') ,
                                            'Message.id =' => $message_id
                                        ) ,
                                        'fields' => array(
                                            'Message.id',
                                            'Message.user_id',
                                            'Message.other_user_id',
                                            'Message.parent_message_id',
                                            'Message.is_sender',
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    if ($message['Message']['is_sender'] == 1) {
                                        $this->Message->id = $message_id;
                                        $this->Message->saveField('is_sender', 2);
                                    }
                                    break;

                                default:
                                    break;
                            }
                        }
                    }
                }
            }
            // to redirect to to the previous page
            $folder_type = $this->request->data['Message']['folder_type'];
            $is_starred = $this->request->data['Message']['is_starred'];
            if (!empty($is_starred)) {
                $this->redirect(array(
                    'action' => 'starred'
                ));
            } else {
                if ($folder_type == 'sent') $folder_type = 'sentmail';
                elseif ($folder_type == 'draft') $folder_type = 'drafts';
                $this->redirect(array(
                    'action' => $folder_type
                ));
            }
        } else {
            $this->redirect(array(
                'action' => 'index'
            ));
        }
    }
    public function star($message_id, $current_star)
    {
        $message = '';
        $message['Message']['id'] = $message_id;
        if ($current_star == 'star') $message['Message']['is_starred'] = 1;
        else $message['Message']['is_starred'] = 0;
        if ($this->Message->save($message)) {
            if (!$this->RequestHandler->isAjax()) {
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                if ($message['Message']['is_starred'] == 1) {
                    $message_print = "star|" . Router::url(array(
                        'controller' => 'messages',
                        'action' => 'star',
                        $message_id,
                        'unstar'
                    ) , true);
                } else {
                    $message_print = "unstar|" . Router::url(array(
                        'controller' => 'messages',
                        'action' => 'star',
                        $message_id,
                        'star'
                    ) , true);
                }
				$starred_count = $this->Message->find('count', array(
					'conditions' => array(
						'Message.user_id' => $this->Auth->user('id') ,
						'Message.is_deleted' => 0,
						'Message.is_archived' => 0,
						'Message.is_starred' => 1,
						'MessageContent.admin_suspend' => 0,
					) ,
					'recursive' => 0
				));
                echo $message_print . '|' . $starred_count;
                exit;
            }
        }
        $this->set('message', $message);
    }
    public function _make_read($message_id, $read_status)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('is_read', $read_status);
    }
    public function _make_starred($message_id, $starred_status)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('is_starred', $starred_status);
    }
    public function _make_archive($message_id)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('is_archived', 1);
    }
    public function _change_folder($message_id, $folder_id)
    {
        $this->Message->id = $message_id;
        $this->Message->saveField('message_folder_id', $folder_id);
    }
    public function settings()
    {
        $this->pageTitle.= __l('Settings');
        $setting = $this->Message->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'UserProfile.user_id',
                'UserProfile.id',
                'UserProfile.message_page_size',
                'UserProfile.message_signature'
            ),
			'recursive' => -1
        ));
        if (!empty($this->request->data)) {
            $this->Message->User->UserProfile->set($this->request->data);
            if ($this->Message->User->UserProfile->validates()) {
                if (empty($setting)) {
                    $this->Message->User->UserProfile->create();
                    $this->request->data['UserProfile']['user_id'] = $this->Auth->user('id');
                } else {
                    $this->request->data['UserProfile']['id'] = $setting['UserProfile']['id'];
                }
                $this->Message->User->UserProfile->save($this->request->data);
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Message Settings')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('Message Settings could not be updated') , 'default', null, 'error');
            }
        } else {
            $this->request->data['UserProfile']['message_page_size'] = !empty($setting['UserProfile']['message_page_size']) ? $setting['UserProfile']['message_page_size'] : Configure::read('messages.page_size');
            $this->request->data['UserProfile']['message_signature'] = !empty($setting['UserProfile']['message_signature']) ? $setting['UserProfile']['message_signature'] : '';
            $this->set($this->request->data);
            $this->set('user_id', $this->Auth->user('id'));
        }
    }
    public function _findParent($id = null)
    {
        $all_parents = array();
        for ($i = 0;; $i++) {
            $parent_message = $this->Message->find('first', array(
                'conditions' => array(
                    'Message.id' => $id
                ) ,
                'recursive' => 0
            ));
            array_unshift($all_parents, $parent_message);
            if ($parent_message['Message']['parent_message_id'] != 0) {
                $parent_message_data = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.id' => $parent_message['Message']['parent_message_id']
                    ) ,
                    'recursive' => 0
                ));
                $id = $parent_message_data['Message']['id'];
            } else {
                break;
            }
        }
        return $all_parents;
    }
    public function admin_index($view = null)
    {
        if (!empty($view) && $view == 'contest_comments') {
            $this->pageTitle = __l('Contest Comments');
            $comment_conditions = array(
                'Message.user_id !=' => 0,
                'Message.user_id !=' => '',
                'Message.other_user_id !=' => 0,
                'Message.other_user_id !=' => '',
                'Message.contest_id !=' => 0,
                'Message.contest_user_id =' => 0,
                'Message.is_activity =' => 0,
                'Message.message_folder_id =' => ConstMessageFolder::SentMail,
                'Message.is_sender =' => 1,
            );
            $conditions = $comment_conditions;
            $count_conditions = $comment_conditions;
            $this->set('view', $view);
        } elseif (!empty($view) && $view == 'contest_activities') {
            $this->pageTitle = __l('Contest Activities');
            $activities_conditions = array(
                'Message.is_activity =' => 1,
                'Message.contest_id !=' => 0,
                'Message.contest_user_id =' => 0,
                'Message.is_sender =' => 0,
            );
            $conditions = $activities_conditions;
            $count_conditions = $activities_conditions;
            $this->set('view', $view);
        } else {
            $this->pageTitle = __l('Messages');
            $count_conditions = '';
            $conditions['Message.is_sender'] = 1;
        }
        if (!empty($this->request->data['Message']['username']) || !empty($this->request->params['named']['from'])) {
            $this->request->data['Message']['username'] = !empty($this->request->data['Message']['username']) ? $this->request->data['Message']['username'] : $this->request->params['named']['from'];
            $conditions['User.username'] = $this->request->data['Message']['username'];
            $this->request->params['named']['from'] = $this->request->data['Message']['username'];
        }
        if (!empty($this->request->data['Message']['other_username']) || !empty($this->request->params['named']['to'])) {
            $this->request->data['Message']['other_username'] = !empty($this->request->data['Message']['other_username']) ? $this->request->data['Message']['other_username'] : $this->request->params['named']['to'];
            $conditions['OtherUser.username'] = $this->request->data['Message']['other_username'];
            $this->request->params['named']['to'] = $this->request->data['Message']['other_username'];
        }
        if (!empty($this->request->data['Contest']['name']) || !empty($this->request->params['named']['contest'])) {
            $contest = $this->Message->Contest->find('first', array(
                'conditions' => array(
                    'or' => array(
                        'Contest.name' => !empty($this->request->data['Contest']['name']) ? $this->request->data['Contest']['name'] : '',
                        'Contest.id' => !empty($this->request->params['named']['contest']) ? $this->request->params['named']['contest'] : '',
                    )
                ) ,
                'fields' => array(
                    'Contest.id',
                    'Contest.name',
                ) ,
                'recursive' => -1
            ));
            $conditions['Message.contest_id'] = $contest['Contest']['id'];
            $this->request->data['Contest']['name'] = $contest['Contest']['name'];
            $this->request->params['named']['contest'] = $contest['Contest']['id'];
        }
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data['Message']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Message']['filter_id'])) {
            if ($this->request->data['Message']['filter_id'] == ConstMoreAction::Suspend) {
                $conditions['MessageContent.admin_suspend'] = 1;
                $this->pageTitle.= __l(' - Suspended ');
            } elseif ($this->request->data['Message']['filter_id'] == ConstMoreAction::Flagged) {
                $conditions['MessageContent.is_system_flagged'] = 1;
                $this->pageTitle.= __l(' - System Flagged');
            }
            $this->request->params['named']['filter_id'] = $this->request->data['Message']['filter_id'];
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
			$conditions['Message.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
			$conditions['Message.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
			$conditions['Message.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['Message.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
			$conditions['Message.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['Message.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (!empty($this->request->data['Message']['from_date']['year']) && !empty($this->request->data['Message']['from_date']['month']) && !empty($this->request->data['Message']['from_date']['day'])) {
            $this->request->params['named']['from_date'] = $this->request->data['Message']['from_date']['year'] . '-' . $this->request->data['Message']['from_date']['month'] . '-' . $this->request->data['Message']['from_date']['day'] . ' 00:00:00';
        }
        if (!empty($this->request->data['Message']['to_date']['year']) && !empty($this->request->data['Message']['to_date']['month']) && !empty($this->request->data['Message']['to_date']['day'])) {
            $this->request->params['named']['to_date'] = $this->request->data['Message']['to_date']['year'] . '-' . $this->request->data['Message']['to_date']['month'] . '-' . $this->request->data['Message']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            if ($this->request->params['named']['from_date'] < $this->request->params['named']['to_date']) {
                $conditions['Message.created >='] = $this->request->params['named']['from_date'];
                $conditions['Message.created <='] = $this->request->params['named']['to_date'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'MessageContent',
                'OtherUser',
                'Contest' => array(
                    'ContestStatus'
                ) ,
            ) ,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
            'recursive' => 2
        );
        if (!empty($view) && ($view == 'contest_comments' || $view == 'contest_activities')) {
            $this->set('suspended', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.admin_suspend = ' => 1,
                    $count_conditions
                ),
				'recursive' => 0
            )));
            $this->set('system_flagged', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.is_system_flagged = ' => 1,
                    $count_conditions
                ),
				'recursive' => 0
            )));
            $this->set('all', $this->Message->find('count', array(
                'conditions' => array(
                    $count_conditions
                ),
				'recursive' => -1
            )));
        } else {
            $this->set('suspended', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.admin_suspend = ' => 1,
                    'Message.is_sender' => 1,
                ),
				'recursive' => 0
            )));
            $this->set('system_flagged', $this->Message->find('count', array(
                'conditions' => array(
                    'MessageContent.is_system_flagged = ' => 1,
                    'Message.is_sender' => 1,
                ),
				'recursive' => 0
            )));
            $this->set('all', $this->Message->find('count', array(
                'conditions' => array(
                    'Message.is_sender' => 1,
                ),
				'recursive' => -1
            )));
        }
        $this->Message->Contest->validate = array();
        $this->Message->User->validate = array();
        $moreActions = $this->Message->moreActions;
        $this->set(compact('moreActions'));
        $this->set('messages', $this->paginate());
    }
    public function admin_update_status($id = null, $status_id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'active')) {
            $_data['MessageContent']['id'] = $id;
            $_data['MessageContent']['is_system_flagged'] = 1;
            $this->Message->MessageContent->save($_data);
			if(!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'contest_comments'){
				$this->Session->setFlash(__l('Contest comment has been flagged') , 'default', null, 'success');
			} else{
            $this->Session->setFlash(__l('Message has been flagged') , 'default', null, 'success');
			}
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'deactivate')) {
            $_data['MessageContent']['id'] = $id;
            $_data['MessageContent']['is_system_flagged'] = 0;
            $this->Message->MessageContent->save($_data);
			if(!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'contest_comments'){
				$this->Session->setFlash(__l('Contest comment has been unflagged') , 'default', null, 'success');
			} else{
            $this->Session->setFlash(__l('Message has been unflagged') , 'default', null, 'success');
			}
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'suspend')) {
            $_data['MessageContent']['id'] = $id;
            $_data['MessageContent']['admin_suspend'] = 1;
            $this->Message->MessageContent->save($_data);
			if(!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'contest_comments'){
				$this->Session->setFlash(__l('Contest comment has been suspend') , 'default', null, 'success');
			} else{
            $this->Session->setFlash(__l('Message has been suspend') , 'default', null, 'success');
			}
        } elseif (!empty($this->request->params['named']['flag']) && ($this->request->params['named']['flag'] == 'unsuspend')) {
            $_data['MessageContent']['id'] = $id;
            $_data['MessageContent']['admin_suspend'] = 0;
            $this->Message->MessageContent->save($_data);
			if(!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'contest_comments'){
				$this->Session->setFlash(__l('Contest comment has been unsuspend') , 'default', null, 'success');
			} else{
            $this->Session->setFlash(__l('Message has been unsuspend') , 'default', null, 'success');
			}
        }
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.message_content_id' => $id
            ) ,
            'recursive' => -1
        ));
        $_data['Message']['id'] = $message['Message']['id'];
        $_data['Message']['message_content_id'] = $id;
        $this->Message->save($_data);
        $this->redirect(array(
            'action' => 'index',
			$this->request->params['named']['from']
        ));
    }
    public function admin_update()
    {
        if (!empty($this->request->data['Message'])) {
            $this->Message->Behaviors->detach('SuspiciousWordsDetector');
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $userIds = array();
            foreach($this->request->data['Message'] as $message_id => $is_checked) {
                if ($is_checked['id']) {
                    $messageIds[] = $message_id;
                }
            }
            if ($actionid && !empty($messageIds)) {
                if ($actionid == ConstMoreAction::Delete) {
                    foreach($messageIds as $id) {
                        $this->Message->MessageContent->delete($id, true);
                    }
                    $this->Session->setFlash(__l('Checked messages has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Suspend) {
					foreach($messageIds as $id) {
						$_data['MessageContent']['id'] = $id;
						$_data['MessageContent']['admin_suspend'] = 1;
						$this->Message->MessageContent->save($_data);
					}
                    $this->Session->setFlash(__l('Checked messages has been suspended') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Unsuspend) {
					foreach($messageIds as $id) {
						$_data['MessageContent']['id'] = $id;
						$_data['MessageContent']['admin_suspend'] = 0;
						$this->Message->MessageContent->save($_data);
					}
                    $this->Session->setFlash(__l('Checked messages has been unsuspended') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Flagged) {
					foreach($messageIds as $id) {
						$_data['MessageContent']['id'] = $id;
						$_data['MessageContent']['is_system_flagged'] = 1;
						$this->Message->MessageContent->save($_data);
					}
                    $this->Session->setFlash(__l('Checked messages has been flagged') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Unflagged) {
					foreach($messageIds as $id) {
						$_data['MessageContent']['id'] = $id;
						$_data['MessageContent']['is_system_flagged'] = 0;
						$this->Message->MessageContent->save($_data);
					}
                    $this->Session->setFlash(__l('Checked messages has been unflagged') , 'default', null, 'success');
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function activities()
    {
		if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'compact')) {
			$this->setAction('activities_notification');
		}
        $this->pageTitle = __l('Contest Activities');
        $conditions = array();
        $conditions['MessageContent.admin_suspend'] = 0;
        $conditions['Message.is_activity'] = 1;
		$conditions['Message.is_sender'] = 0;
        if (!empty($this->request->params['named']['contest_user_id'])) {
            $conditions['Message.contest_user_id'] = $this->request->params['named']['contest_user_id'];
        }
        if (isset($this->request->params['named']['contest_id'])) {
            $conditions['OR']['Message.contest_id'] = $this->request->params['named']['contest_id'];
            $conditions['or']['Message.is_auto'] = 1;
            $ContestUserIds = array();
            $ContestUserIds = $this->Message->ContestUser->find('list', array(
                'conditions' => array(
                    'ContestUser.contest_id' => $this->request->params['named']['contest_id'],
                    'ContestUser.admin_suspend' => 1
                ) ,
                'recursive' => -1,
                'fields' => array(
                    'ContestUser.id'
                )
            ));
            $conditions['not']['Message.contest_user_id'] = $ContestUserIds;
        }
		if(empty($this->request->params['named']['contest_id']) && empty($this->request->params['named']['contest_user_id'])) {
			$conditions['OR']['Message.user_id'] = $this->Auth->user('id');
			$ContestIds = $this->Message->Contest->find('list', array(
                'conditions' => array(
                    'Contest.user_id' => $this->Auth->user('id'),
                    'Contest.admin_suspend' => 0
                ) ,
                'recursive' => -1,
                'fields' => array(
                    'Contest.id'
                )
            ));
			if(!empty($ContestIds)) {
				$conditions['OR']['Message.contest_id'] = $ContestIds;
			}
			$ContestUserIds = $this->Message->ContestUser->find('list', array(
                'conditions' => array(
                    'ContestUser.user_id' => $this->Auth->user('id'),
                    'ContestUser.admin_suspend' => 0
                ) ,
                'recursive' => -1,
                'fields' => array(
                    'ContestUser.id'
                )
            ));
			if(!empty($ContestUserIds)) {
				$conditions['OR']['Message.contest_user_id'] = $ContestUserIds;
			}
		}
        $contain = array(
            'User' => array(
                'fields' => array(
                    'User.username',
                    'User.id',
                    'User.is_facebook_register',
                    'User.facebook_user_id',
                    'User.twitter_avatar_url',
                    'User.linkedin_avatar_url'
                )
            ) ,
            'OtherUser' => array(
                'fields' => array(
                    'OtherUser.username',
                    'OtherUser.id',
                    'OtherUser.role_id',
                    'OtherUser.is_facebook_register',
                    'OtherUser.facebook_user_id',
                    'OtherUser.twitter_avatar_url',
                    'OtherUser.linkedin_avatar_url'
                )
            ) ,
            'MessageContent' => array(
                'fields' => array(
                    'MessageContent.subject',
                    'MessageContent.message'
                ) ,
                'Attachment'
            ) ,
            'Contest' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'WinnerUser' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'ContestUser' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'ContestStatus' => array(
                'fields' => array(
                    'ContestStatus.id',
                    'ContestStatus.name',
                    'ContestStatus.message',
                    'ContestStatus.slug',
                )
            )
        );
        if (isPluginEnabled('EntryRatings')) {
            $entryRatingsContain = array(
                'ContestUserRating' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                ) ,
            );
            $contain = array_merge($contain, $entryRatingsContain);
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 3,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        );
		if(!empty($this->request->params['named']['contest_id'])){
           $this->set('contest_id', $this->request->params['named']['contest_id']);
		}
        $this->set('messages', $this->paginate());
    }
	public function activities_notification()
    {
        $this->pageTitle = __l('Contest Activities');
        $conditions = array();
        $conditions['MessageContent.admin_suspend'] = 0;
        $conditions['Message.is_activity'] = 1;
		$conditions['Message.is_sender'] = 0;
		$conditions['OR']['Message.user_id'] = $this->Auth->user('id');
		$ContestIds = $this->Message->Contest->find('list', array(
			'conditions' => array(
				'Contest.user_id' => $this->Auth->user('id'),
				'Contest.admin_suspend' => 0
			) ,
			'recursive' => -1,
			'fields' => array(
				'Contest.id'
			)
		));
		if(!empty($ContestIds)) {
			$conditions['OR']['Message.contest_id'] = $ContestIds;
		}
		$conditions['OR']['Contest.user_id'] = $this->Auth->user('id');
		$conditions['OR']['ContestUser.user_id'] = $this->Auth->user('id');
        $contain = array(
            'User' => array(
                'fields' => array(
                    'User.username',
                    'User.id',
                    'User.is_facebook_register',
                    'User.facebook_user_id',
                    'User.twitter_avatar_url',
                    'User.linkedin_avatar_url'
                )
            ) ,
            'OtherUser' => array(
                'fields' => array(
                    'OtherUser.username',
                    'OtherUser.id',
                    'OtherUser.role_id',
                    'OtherUser.is_facebook_register',
                    'OtherUser.facebook_user_id',
                    'OtherUser.twitter_avatar_url',
                    'OtherUser.linkedin_avatar_url'
                )
            ) ,
            'MessageContent' => array(
                'fields' => array(
                    'MessageContent.subject',
                    'MessageContent.message'
                ) ,
                'Attachment'
            ) ,
            'Contest' => array(
				'User' => array(
                    'UserAvatar'
                ) ,
                'WinnerUser' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'ContestUser' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'ContestStatus' => array(
                'fields' => array(
                    'ContestStatus.id',
                    'ContestStatus.name',
                    'ContestStatus.message',
                    'ContestStatus.slug',
                )
            )
        );
        if (isPluginEnabled('EntryRatings')) {
            $entryRatingsContain = array(
                'ContestUserRating' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                ) ,
            );
            $contain = array_merge($contain, $entryRatingsContain);
        }
		$final_id = $this->Message->find('first', array(
            'conditions' => $conditions,
            'fields' => array(
                'Message.id'
            ) ,
            'recursive' => 0,
            'limit' => 1,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        ));
        $this->set('final_id', $final_id);
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 3,
			'limit' => 5,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        );
        $this->set('messages', $this->paginate());
    }
    public function view_ajax($id)
    {
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $id,
            ) ,
            'contain' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.subject',
                        'MessageContent.message'
                    ) ,
                    'Attachment'
                ) ,
                'User' => array(
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.email'
                    )
                ) ,
                'OtherUser' => array(
                    'fields' => array(
                        'OtherUser.id',
                        'OtherUser.email',
                        'OtherUser.username'
                    )
                ) ,
                'Contest' => array(
                    'fields' => array(
                        'Contest.name',
                        'Contest.slug',
                        'Contest.id',
                        'Contest.contest_status_id',
                        'Contest.user_id',
                    ) ,
                )
            ) ,
            'recursive' => 2,
        ));
        $this->set('message', $message);
    }
    public function update_message_read($message_id = null)
    {
        $message = $this->Message->find('first', array(
            'conditions' => array(
                'Message.id = ' => $message_id,
            ) ,
            'fields' => array(
                'Message.id',
                'Message.created',
                'Message.user_id',
                'Message.other_user_id',
                'Message.parent_message_id',
                'Message.message_content_id',
                'Message.message_folder_id',
                'Message.is_sender',
                'Message.is_starred',
                'Message.is_read',
                'Message.is_deleted',
                'Message.contest_id'
            ) ,
            'recursive' => -1,
        ));
        if (!empty($message) and $message['Message']['is_read'] == 0 && $message['Message']['user_id'] == $this->Auth->user('id')) {
            $this->request->data['Message']['is_read'] = 1;
            $this->request->data['Message']['id'] = $message['Message']['id'];
            $this->Message->save($this->request->data);
        }
        $unread_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => '0',
                'Message.user_id' => $this->Auth->user('id') ,
                'Message.is_sender' => '0',
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.is_system_flagged' => 0
            ) ,
            'recursive' => 0
        ));
        $unread_count = !empty($unread_count) ? $unread_count : '';
        $unread_count = $unread_count;
        echo $unread_count;
        exit;
    }
    public function update()
    {
    }
	public function admin_activities() 
    {
        $this->pageTitle = __l('Site Activities');
        $conditions = array();
        $conditions['MessageContent.admin_suspend'] = 0;
        $conditions['Message.is_activity'] = 1;
		$conditions['Message.is_sender'] = 0;
        
        $contain = array(
            'User' => array(
                'fields' => array(
                    'User.username',
                    'User.id',
                    'User.is_facebook_register',
                    'User.facebook_user_id',
                    'User.twitter_avatar_url',
                    'User.linkedin_avatar_url'
                )
            ) ,
            'OtherUser' => array(
                'fields' => array(
                    'OtherUser.username',
                    'OtherUser.id',
                    'OtherUser.role_id',
                    'OtherUser.is_facebook_register',
                    'OtherUser.facebook_user_id',
                    'OtherUser.twitter_avatar_url',
                    'OtherUser.linkedin_avatar_url'
                )
            ) ,
            'MessageContent' => array(
                'fields' => array(
                    'MessageContent.subject',
                    'MessageContent.message'
                ) ,
                'Attachment'
            ) ,
            'Contest' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
                'WinnerUser' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'ContestUser' => array(
                'User' => array(
                    'UserAvatar'
                ) ,
            ) ,
            'ContestStatus' => array(
                'fields' => array(
                    'ContestStatus.id',
                    'ContestStatus.name',
                    'ContestStatus.message',
                    'ContestStatus.slug',
                )
            )
        );
        if (isPluginEnabled('EntryRatings')) {
            $entryRatingsContain = array(
                'ContestUserRating' => array(
                    'User' => array(
                        'UserAvatar'
                    ) ,
                ) ,
            );
            $contain = array_merge($contain, $entryRatingsContain);
        }
		if (!empty($this->request->data['Message']['username']) || !empty($this->request->params['named']['from'])) {
            $this->request->data['Message']['username'] = !empty($this->request->data['Message']['username']) ? $this->request->data['Message']['username'] : $this->request->params['named']['from'];
			$this->request->data['Message']['other_username'] = !empty($this->request->data['Message']['username']) ? $this->request->data['Message']['username'] : $this->request->params['named']['from'];
            $conditions['User.username'] = $this->request->data['Message']['username'];
            $this->request->params['named']['from'] = $this->request->data['Message']['username'];
        }
  
        if (!empty($this->request->data['Contest']['name']) || !empty($this->request->params['named']['contest'])) {
            $contest = $this->Message->Contest->find('first', array(
                'conditions' => array(
                    'or' => array(
                        'Contest.name' => !empty($this->request->data['Contest']['name']) ? $this->request->data['Contest']['name'] : '',
                        'Contest.id' => !empty($this->request->params['named']['contest']) ? $this->request->params['named']['contest'] : '',
                    )
                ) ,
                'fields' => array(
                    'Contest.id',
                    'Contest.name',
                ) ,
                'recursive' => -1
            ));
            $conditions['Message.contest_id'] = $contest['Contest']['id'];
            $this->request->data['Contest']['name'] = $contest['Contest']['name'];
            $this->request->params['named']['contest'] = $contest['Contest']['id'];
        }
		
		
		if (!empty($this->request->data['Message']['from_date']['year']) && !empty($this->request->data['Message']['from_date']['month']) && !empty($this->request->data['Message']['from_date']['day'])) {
            $this->request->params['named']['from_date'] = $this->request->data['Message']['from_date']['year'] . '-' . $this->request->data['Message']['from_date']['month'] . '-' . $this->request->data['Message']['from_date']['day'] . ' 00:00:00';
        }
        if (!empty($this->request->data['Message']['to_date']['year']) && !empty($this->request->data['Message']['to_date']['month']) && !empty($this->request->data['Message']['to_date']['day'])) {
            $this->request->params['named']['to_date'] = $this->request->data['Message']['to_date']['year'] . '-' . $this->request->data['Message']['to_date']['month'] . '-' . $this->request->data['Message']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            if ($this->request->params['named']['from_date'] < $this->request->params['named']['to_date']) {
                $conditions['Message.created >='] = $this->request->params['named']['from_date'];
                $conditions['Message.created <='] = $this->request->params['named']['to_date'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
		$limit = 20;
        if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'compact')) {
            $limit = 3;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 3,
			'limit' => $limit ,
            'order' => array(
                'Message.id' => 'desc'
            ) ,
        );
        $this->set('messages', $this->paginate());
		 if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'compact')) {
            $this->render('admin_activities_compact');
        }
        if (!empty($this->request->params['prefix']) && isset($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'list')) {
            $this->render('admin_activities');
        }
    }
	public function clear_activities() 
    {
        $this->loadModel('User');
        $data['User']['activity_message_id'] = $this->request->params['named']['final_id'];
        $data['User']['id'] = $this->Auth->user('id');
        $this->User->save($data);
        $this->Session->setFlash(__l('Notifications cleared successfully') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'dashboard'
        ));
    }
}
?>