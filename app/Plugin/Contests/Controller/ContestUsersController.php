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
class ContestUsersController extends AppController
{
    public $name = 'ContestUsers';
    public $permanentCacheAction = array(
        'public' => array(
            'index',
        ) ,
        'user' => array(
            'add',
            'entry_chart',
        ) ,
        'is_view_count_update' => true
    );
    public function beforeFilter()
    {
        if (in_array($this->request->action, array(
            'update_view_count'
        ))) {
            $this->Security->validatePost = false;
        }
        $this->Security->disabledFields = array(
            'Attachment',
            'ContestUser.is_file_added',
            'ContestUser.user_id',
            '_wysihtml5_mode'
        );
        parent::beforeFilter();
    }
    public function index()
    {
        $this->pageTitle = __l('Entries');
        $conditions = array();
        $order = array(
            'ContestUser.id' => 'desc'
        );
        $limit = 20;
        $conditions['ContestUser.is_active'] = 1;
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'myparticipation')) {
            unset($conditions['ContestUser.is_active']);
        }
        if (!empty($this->request->params['named']['status'])) {
            $conditions['ContestUserStatus.slug'] = $this->request->params['named']['status'];
        }
        if (!empty($this->request->params['named']['contest'])) {
            $contest = $this->ContestUser->Contest->find('first', array(
                'conditions' => array(
                    'Contest.slug' => $this->request->params['named']['contest'],
                    'Contest.contest_status_id !=' => ConstContestStatus::PaymentPending,
                ) ,
                'contain' => array(
                    'ContestType' => array(
                        'fields' => array(
                            'ContestType.id',
                            'ContestType.resource_id',
                            'ContestType.is_watermarked',
                        )
                    )
                ) ,
                'recursive' => 1,
            ));
            $conditions['ContestUser.contest_id'] = $contest['Contest']['id'];
            if (empty($contest)) {
                throw new NotFoundException(__l('Invalid Contest'));
            }
            $this->set('contest', $contest);
            $this->pageTitle.= ' - ' . $contest['Contest']['name'];
            if (!empty($this->request->params['named']['view_type'])) {
                if ($this->request->params['named']['view_type'] == 'unrated') {
                    $conditions['ContestUser.contest_user_rating_count'] = 0;
                    $this->pageTitle.= ' - ' . __l('Showing Only Unrated');
                } elseif ($this->request->params['named']['view_type'] == 'rated') {
                    $conditions['ContestUser.contest_user_rating_count >'] = 0;
                    $this->pageTitle.= ' - ' . __l('Showing Only Rated');
                } elseif ($this->request->params['named']['view_type'] == 'withdrawn') {
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Withdrawn;
                    $this->pageTitle.= ' - ' . __l('Showing Only Withdrawn');
                } elseif ($this->request->params['named']['view_type'] == 'eliminated') {
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Eliminated;
                    $this->pageTitle.= ' - ' . __l('Showing Only Eliminated');
                } elseif ($this->request->params['named']['view_type'] == 'open') {
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Active;
                    $this->pageTitle.= ' - ' . __l('Showing Only Open');
                } elseif ($this->request->params['named']['view_type'] == 'liked_participant') {
                    if (isPluginEnabled('UserFavourites')) {
                        $user_favorites = $this->ContestUser->User->UserFavorite->find('list', array(
                            'conditions' => array(
                                'UserFavorite.user_id' => $contest['Contest']['user_id'],
                            ) ,
                            'fields' => array(
                                'UserFavorite.user_favorite_id',
                            ) ,
                            'recursive' => -1
                        ));
                        $conditions['ContestUser.user_id'] = $user_favorites;
                        $this->pageTitle.= ' - ' . __l('Showing Only Liked Participant');
                    }
                }
            }
            if (!empty($this->request->params['named']['filter'])) {
                if ($this->request->params['named']['filter'] == 'rating') {
                    $order = array(
                        'ContestUser.contest_user_rating_count' => 'desc'
                    );
                    $this->pageTitle.= ' - ' . __l('Sorted By Highest Rated');
                } elseif ($this->request->params['named']['filter'] == 'time') {
                    $order = array(
                        'ContestUser.created' => 'asc'
                    );
                    $this->pageTitle.= ' - ' . __l('Sorted By Recently Added');
                }
            }
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'myparticipation' || $this->request->params['named']['type'] == "slider")) {
            if ($this->Auth->user() && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $conditions[] = array(
                    'OR' => array(
                        array(
                            'ContestUser.admin_suspend' => 0,
                        ) ,
                        array(
                            'ContestUser.user_id' => $this->Auth->user('id') ,
                        ) ,
                    )
                );
            }
            if (!$this->Auth->user()) {
                $conditions['ContestUser.admin_suspend'] = 0;
            }
        } else {
            $conditions['ContestUser.admin_suspend'] = 0;
        }
        if (!empty($this->request->params['named']['type'])) {
            if ($this->request->params['named']['type'] == ConstUserTypeAlternateName::ContestHolder) {
                $conditions['ContestUser.contest_owner_user_id'] = $this->Auth->user('id');
                $this->pageTitle = sprintf(__l('My %s') , Configure::read('contest.participant_alt_name_singular_caps'));
            } else if ($this->request->params['named']['type'] == "myparticipation") {
                unset($conditions['ContestUser.admin_suspend']);
                $this->pageTitle = __l('My Entries & Won Contests');
                $conditions['ContestUser.user_id'] = $this->Auth->user('id');
            } else if ($this->request->params['named']['type'] == "myparticipated") {
                $this->pageTitle = __l('Participated Contests');
                $conditions['ContestUser.user_id'] = $this->request->params['named']['user_id'];
            } else { // listing my purchases //
                $conditions['ContestUser.user_id'] = $this->Auth->user('id');
            }
        }
        if ((!empty($this->request->params['named']['type']) and ($this->Auth->user('id')) and $this->request->params['named']['type'] == 'myparticipation') || (!empty($this->request->params['named']['type']) and $this->request->params['named']['type'] == 'myparticipated') || (!empty($this->request->params['named']['type']) and ($this->Auth->user('id')) and $this->request->params['named']['type'] == ConstUserTypeAlternateName::ContestHolder)) {
            if (isset($this->params['named']['filter_id'])) {
                $this->request->data['ContestUser']['filter_id'] = $this->params['named']['filter_id'];
            }
            if (!empty($this->request->data['ContestUser']['filter_id'])) {
                switch ($this->request->data['ContestUser']['filter_id']) {
                    case ConstContestUserStatus::Active:
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Active;
                        $this->pageTitle.= __l(' - Active ');
                        break;

                    case ConstContestUserStatus::Withdrawn:
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Withdrawn;
                        $this->pageTitle.= __l(' - Withdrawn ');
                        break;

                    case ConstContestStatus::FilesExpectation:
                        $conditions['Contest.contest_status_id'] = ConstContestStatus::FilesExpectation;
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Expecting Deliverables ');
                        break;

                    case ConstContestUserStatus::Eliminated:
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Eliminated;
                        $this->pageTitle.= __l(' - Eliminated ');
                        break;

                    case ConstContestUserStatus::Won:
                        $conditions['Contest.contest_status_id'] = array(
                            ConstContestStatus::WinnerSelected,
                            ConstContestStatus::WinnerSelectedByAdmin,
                        );
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Won');
                        break;

                    case ConstContestUserStatus::Lost:
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Lost;
                        $this->pageTitle.= __l(' - Lost');
                        break;

                    case ConstContestStatus::ChangeRequested:
                        $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeRequested;
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Change Requested');
                        break;

                    case ConstContestStatus::ChangeCompleted:
                        $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeCompleted;
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Change Completed');
                        break;

                    case ConstContestStatus::Completed:
                        $conditions['Contest.contest_status_id'] = ConstContestStatus::Completed;
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Completed');
                        break;

                    case ConstContestStatus::PaidToParticipant:
                        $conditions['Contest.contest_status_id'] = ConstContestStatus::PaidToParticipant;
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Closed');
                        break;

                    case 'entry':
                        $conditions['ContestUser.contest_user_status_id'] = array(
                            ConstContestUserStatus::Active,
                            ConstContestUserStatus::Withdrawn,
                            ConstContestUserStatus::Eliminated,
                            ConstContestUserStatus::Lost,
                        );
                        $conditions['ContestUser.user_id'] = $this->Auth->user('id');
                        $this->pageTitle.= __l(' - Entry');
                        break;

                    case 'development':
                        $conditions = array(
                            'OR' => array(
                                array(
                                    'Contest.contest_status_id' => array(
                                        ConstContestStatus::ChangeRequested,
                                        ConstContestStatus::ChangeCompleted,
                                        ConstContestStatus::Completed,
                                        ConstContestStatus::PaidToParticipant,
                                    ) ,
                                    'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                                ) ,
                                array(
                                    'Contest.contest_status_id' => array(
                                        ConstContestStatus::WinnerSelected,
                                        ConstContestStatus::WinnerSelectedByAdmin,
                                    )
                                )
                            )
                        );
                        $conditions['ContestUser.user_id'] = $this->Auth->user('id');
                        $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                        $this->pageTitle.= __l(' - Development');
                        break;
                }
            }
        } else {
            if (empty($this->request->params['named']['contest'])):
                throw new NotFoundException(__l('Invalid request'));
            endif;
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == "slider")) {
            unset($conditions['ContestUser.user_id']);
            $conditions['ContestUser.contest_user_status_id'] = array(
                ConstContestUserStatus::Active,
                ConstContestUserStatus::Won,
                ConstContestUserStatus::Lost,
                ConstContestUserStatus::Eliminated,
            );
            $limit = 12;
            $order = array(
                'ContestUser.contest_user_status_id' => 'asc',
                'ContestUser.id' => 'asc',
            );
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == "participant_slider")) {
            $conditions['ContestUser.user_id'] = $this->request->params['named']['user_id'];
            $limit = 2;
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'myparticipated')) {
            $limit = 12;
        }
        if (empty($conditions)) {
            throw new NotFoundException(__l('Invalid Contest'));
        }
        if (!empty($contest['Contest']['winner_user_id']) && ($contest['Contest']['winner_user_id'] != 0)) {
            if (!empty($this->request->params['named']['contest']) && empty($this->request->params['named']['contest_type']) && empty($this->request->params['named']['type'])) {
                $order = array(
                    'ContestUser.contest_user_status_id' => 'asc',
                    'ContestUser.id' => 'desc'
                );
                $conditions['ContestUser.contest_user_status_id'] = array(
                    ConstContestUserStatus::Active,
                    ConstContestUserStatus::Withdrawn,
                    ConstContestUserStatus::Eliminated,
                    ConstContestUserStatus::Lost,
                );
            }
        }
        if (isPluginEnabled('UserFavourites')) {
            $user_contain = array(
                'FavoriteUser' => array(
                    'conditions' => array(
                        'FavoriteUser.user_id' => $this->Auth->user('id') ,
                    )
                ) ,
                'UserAvatar',
            );
        } else {
            $user_contain = array(
                'UserAvatar',
            );
        }
        $contain = array(
            'Attachment',
            'Message' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.text_resource',
                    )
                )
            ) ,
            'User' => $user_contain,
            'ContestUserStatus' => array(
                'fields' => array(
                    'ContestUserStatus.id',
                    'ContestUserStatus.name',
                    'ContestUserStatus.description',
                    'ContestUserStatus.slug',
                ) ,
            ) ,
            'Contest' => array(
                'Resource',
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
                        'ContestStatus.slug',
                    )
                ) ,
                'User',
                'EntryAttachment'
            ) ,
        );
        if (isPluginEnabled('EntryRatings')) {
            $EntryRatings_contain = array(
                'ContestUserRating' => array(
                    'conditions' => array(
                        'ContestUserRating.user_id' => $this->Auth->user('id')
                    )
                ) ,
            );
            $contain = array_merge($contain, $EntryRatings_contain);
        }
        if (isPluginEnabled('VideoResources')) {
            $contain[] = 'Upload';
        }
        if (isPluginEnabled('AudioResources')) {
           
			if (!empty($this->request->params['named']['view_type']) &&$this->request->params['named']['view_type'] == 'open') {
				$contain['AudioUpload'] = array(
					'conditions' => array(
						'AudioUpload.upload_status_id' => ConstUploadStatus::Success
					)
				);
			}else{
				 $contain[] = 'AudioUpload';
			}
            // We used table 'uploads' for model AudioUpload with useTable concept in model. But it working in admin/audio_uploads.. But here it cases the error (Missing Database Table Error: Table audio_uploads for model AudioUpload was not found in datasource default.) So here we mapped  useTable again.
            App::import('Model', 'AudioResources.AudioUpload');
            $this->AudioUpload = new AudioUpload();
            $this->AudioUpload->useTable = 'uploads';
        }
		 if (isPluginEnabled('TextResources')) {
            $contain['TextResource'] = array(
				'MessageContent'
			);
        }
        if (!empty($this->request->params['named']['contest_type']) and ($this->request->params['named']['contest_type'] == 'participant')) {
            $contestUsers = $this->ContestUser->find('all', array(
                'conditions' => $conditions,
                'contain' => $contain,
                'order' => $order,
                'recursive' => 3
            ));
        } else {
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => $contain,
                'order' => $order,
                'limit' => $limit,
                'recursive' => 3
            );
        }
		
		if (!empty($this->request->params['named']['contest_type']) and ($this->request->params['named']['contest_type'] == 'participant')) {
            $this->set('contestUsers', $contestUsers);
        } else {
            $this->set('contestUsers', $this->paginate());
        }
        if (isPluginEnabled('UserFavourites')) {
            $user_favorites = $this->ContestUser->User->UserFavorite->find('list', array(
                'conditions' => array(
                    'UserFavorite.user_id' => $this->Auth->user('id') ,
                ) ,
                'fields' => array(
                    'UserFavorite.id',
                    'UserFavorite.user_favorite_id',
                ) ,
                'recursive' => -1
            ));
            $this->set('user_favorites', $user_favorites);
        }
        $winner_entry_array = array();
        if (!empty($contest['Contest']['winner_user_id']) && ($contest['Contest']['winner_user_id'] != 0) && ((empty($this->request->params['named']['page']) || ($this->request->params['named']['page'] == 1)))) {
            $contain = array(
                'Attachment',
                'User' => array(
                    'FavoriteUser' => array(
                        'conditions' => array(
                            'FavoriteUser.user_id' => $this->Auth->user('id') ,
                        )
                    ) ,
                    'UserAvatar',
                    'fields' => array(
                        'User.id',
                        'User.username',
                        'User.role_id',
                    ) ,
                ) ,
                'ContestUserStatus' => array(
                    'fields' => array(
                        'ContestUserStatus.id',
                        'ContestUserStatus.name',
                        'ContestUserStatus.description',
                        'ContestUserStatus.slug',
                    ) ,
                ) ,
                'Contest' => array(
                    'User',
                    'EntryAttachment',
                    'Resource',
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
                            'ContestStatus.slug',
                        )
                    ) ,
                ) ,
            );
            if (isPluginEnabled('EntryRatings')) {
                $EntryRatings_contain = array(
                    'ContestUserRating' => array(
                        'conditions' => array(
                            'ContestUserRating.user_id' => $this->Auth->user('id')
                        )
                    ) ,
                );
                $contain = array_merge($contain, $EntryRatings_contain);
            }
            if (isPluginEnabled('VideoResources')) {
                $contain[] = 'Upload';
            }
            if (isPluginEnabled('AudioResources')) {
               if (!empty($this->request->params['named']['view_type']) &&$this->request->params['named']['view_type'] == 'open') {
					$contain['AudioUpload'] = array(
						'conditions' => array(
							'AudioUpload.upload_status_id' => ConstUploadStatus::Success
						)
					);
				}else{
					 $contain[] = 'AudioUpload';
				}
                // We used table 'uploads' for model AudioUpload with useTable concept in model. But it working in admin/audio_uploads.. But here it cases the error (Missing Database Table Error: Table audio_uploads for model AudioUpload was not found in datasource default.) So here we mapped  useTable again.
                App::import('Model', 'AudioResources.AudioUpload');
                $this->AudioUpload = new AudioUpload();
                $this->AudioUpload->useTable = 'uploads';
            }
            if (isPluginEnabled('TextResources')) {
                $contain['TextResource'] = array(
                    'MessageContent' => array(
                        'fields' => array(
                            'MessageContent.text_resource',
                        )
                    )
                );
            }
            $winner_condition = array(
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won,
                'ContestUser.is_active' => 1,
            );
            if (!empty($this->request->params['named']['view_type'])) {
                if ($this->request->params['named']['view_type'] == 'unrated') {
                    $winner_condition['ContestUser.contest_user_rating_count'] = 0;
                    $this->pageTitle.= ' - ' . __l('Showing Only Unrated');
                } elseif ($this->request->params['named']['view_type'] == 'rated') {
                    $winner_condition['ContestUser.contest_user_rating_count >'] = 0;
                    $this->pageTitle.= ' - ' . __l('Showing Only Rated');
                }
            }
            $winner_entry_array = $this->ContestUser->find('first', array(
                'conditions' => $winner_condition,
                'contain' => $contain,
                'recursive' => 3
            ));
            $this->set('winner_entry_array', $winner_entry_array);
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'slider')) {
            $this->render('participant_slider');
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == "participant_slider")) {
            $this->render('participant_slider_child_ajax');
        }
        if (!empty($this->request->params['named']['contest']) && empty($this->request->params['named']['contest_type']) && empty($this->request->params['named']['type'])) {
            $this->render('contest_view_index');
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'myparticipated')) {
            $this->render('myparticipated_contests');
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'myparticipation')) {
            $this->render('myparticipation');
        }
        if (!empty($this->request->params['named']['contest_type']) and ($this->request->params['named']['contest_type'] == 'participant')) {
            $this->render('contest_partcipant');
        }
    }
    public function view($slug)
    {
        $contest = $this->ContestUser->Contest->find('first', array(
            'conditions' => array(
                'Contest.slug' => $slug
            ) ,
            'fields' => array(
                'Contest.id',
                'Contest.name',
                'Contest.slug',
                'Contest.resource_id',
            ) ,
            'contain' => array(
                'ContestType'
            ) ,
            'recursive' => 0
        ));
        $contest_entries = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.entry_no' => $this->request->params['named']['entry'],
                'ContestUser.contest_id' => $contest['Contest']['id'],
            ) ,
            'contain' => array(
                'Contest'
            ) ,
            'recursive' => 0
        ));
        $contest_user_ids = $this->ContestUser->find('list', array(
            'conditions' => array(
                'ContestUser.admin_suspend' => 1,
                'ContestUser.contest_id' => $contest_entries['ContestUser']['contest_id']
            ) ,
            'recursive' => -1
        ));
        $condition = array();
        $tmp_array = array_keys($contest_user_ids);
        // Quick fix for NOT in array
        array_push($tmp_array, -1);
        $count_condition['NOT']['Message.contest_user_id'] = $tmp_array;
        $count_condition['Message.is_sender'] = 0;
        $count_condition['Message.is_activity'] = 0;
        $count_condition['Message.contest_user_id'] = $contest_entries['ContestUser']['id'];
        $count_condition['Message.contest_id'] = $contest_entries['ContestUser']['contest_id'];
        $count_condition['MessageContent.admin_suspend'] = 0;
        $discussion_count = $this->ContestUser->Message->find('count', array(
            'conditions' => $count_condition,
            'recursive' => 0,
            'order' => array(
                'MessageContent.id'
            )
        ));
        if (!$this->Auth->user('id')) {
            if (!empty($contest_entries['Contest']['is_private'])) {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
        }
        $contest_flag = 1;
        $blind_flag = 1;
        if (!empty($contest_entries) && $contest_entries['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
            $contest_flag = 0;
        }
        if (!empty($contest_entries['Contest']['is_blind']) && empty($contest_entries['Contest']['winner_user_id'])) {
            $blind_flag = 0;
            if ($this->Auth->user() && ($contest_entries['ContestUser']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || $contest_entries['Contest']['user_id'] == $this->Auth->user('id'))) {
                $blind_flag = 1;
            }
        }
        if (empty($contest) || empty($contest_entries) || empty($contest_flag) || empty($blind_flag)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($contest_entries['ContestUser']['admin_suspend']) && (!$this->Auth->user() || ($contest_entries['ContestUser']['user_id'] != $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin))) {
            $this->Session->setFlash(__l('This Entry suspended by admin.') , 'default', null, 'error');
            $this->redirect(Router::url('/', true));
        }
        $conditions = array();
        $conditions['ContestUser.contest_id'] = $contest['Contest']['id'];
		$conditions['ContestUser.admin_suspend'] = 0;
        if (!empty($this->request->params['named']['entry'])) {
            $conditions['ContestUser.entry_no'] = $this->request->params['named']['entry'];
        }
        $contain = array(
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
                'Resource',
                'ContestType' => array(
                    'fields' => array(
                        'ContestType.id',
                        'ContestType.resource_id',
                        'ContestType.is_watermarked',
                        'ContestType.featured_fee',
                        'ContestType.blind_fee',
                        'ContestType.private_fee',
                        'ContestType.highlight_fee',
                    )
                ) ,
                'ContestStatus' => array(
                    'fields' => array(
                        'ContestStatus.id',
                        'ContestStatus.name',
                        'ContestStatus.slug',
                    )
                ) ,
                'User',
                'EntryAttachment'
            ) ,
            'Message' => array(
                'conditions' => array(
                    'Message.other_user_id !=' => $contest_entries['Contest']['user_id'],
                    'Message.is_sender' => 0
                ) ,
                'MessageContent' => array(
                    'Attachment'
                ) ,
                'order' => array(
                    'Message.id' => 'DESC'
                )
            ) ,
            'User'
        );
        if (isPluginEnabled('VideoResources') && $contest['Contest']['resource_id'] == ConstResourceId::Video) {
            $contain = array_merge($contain, array(
                'Upload'
            ));
        } else if (isPluginEnabled('AudioResources') && $contest['Contest']['resource_id'] == ConstResourceId::Audio) {
			$audio_contain = array(
                'AudioUpload' => array(
					'conditions' => array(
						'AudioUpload.upload_status_id' => ConstUploadStatus::Success
					)
				)
            );
            $contain = array_merge($contain, $audio_contain);
        } else if (isPluginEnabled('TextResources') && $contest['Contest']['resource_id'] == ConstResourceId::Text) {
			$text_contain = array(
                'TextResource' => array(
					'conditions' => array(
						'TextResource.message_folder_id' => 1
					),
					'MessageContent' => array(
						'conditions' => array(
							'Not' => array(
								'MessageContent.text_resource' => ''
							)
						)
					)
				)
            );
            $contain = array_merge($contain, $text_contain);
        }
        if (isPluginEnabled('EntryRatings')) {
            $EntryRatings_contain = array(
                'ContestUserRating' => array(
                    'conditions' => array(
                        'ContestUserRating.user_id' => $this->Auth->user('id')
                    )
                ) ,
            );
            $contain = array_merge($contain, $EntryRatings_contain);
        }
        $contestUser = $this->ContestUser->find('first', array(
            'conditions' => $conditions,
            'contain' => $contain,
            'recursive' => 3,
        ));
        if (!empty($contestUser)) {
            $this->request->data['ContestUserView']['user_id'] = $this->Auth->user('id');
            $this->request->data['ContestUserView']['contest_user_id'] = $contestUser['ContestUser']['id'];
            $this->request->data['ContestUserView']['ip_id'] = $this->ContestUser->toSaveIp();
            $this->ContestUser->ContestUserView->create();
            $this->ContestUser->ContestUserView->save($this->request->data);
        }
        if (empty($contestUser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contest_user_count = $this->ContestUser->find('count', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest['Contest']['id']
            ) ,
            'recursive' => -1
        ));
        $this->set('contest_user_count', $contest_user_count);
		
        $side_entries = $this->ContestUser->find('neighbors', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.contest_user_status_id' => array(
                    ConstContestUserStatus::Active,
                    ConstContestUserStatus::Won,
                    ConstContestUserStatus::Lost,
                    ConstContestUserStatus::Eliminated,
                ) ,
                'ContestUser.admin_suspend' => 0,
				'ContestUser.is_active' => 1
            ) ,
            'fields' => array(
                'ContestUser.entry_no',
                'ContestUser.user_id'
            ) ,
            'field' => 'entry_no',
            'value' => $contestUser['ContestUser']['entry_no'],
            'recursive' => -1
        ));
        $this->pageTitle = sprintf(__l('Entry #%s from %s') , $contestUser['ContestUser']['entry_no'], $contest['Contest']['name']);
        $this->layout = 'entries';
        $this->set('side_entries', $side_entries);
        $contest['Contest'] = $contestUser['Contest'];
        $contest['ContestType'] = $contestUser['Contest']['ContestType'];
        $this->set('contest', $contest);
        $this->set('contestUser', $contestUser);
        $this->set('discussion_count', $discussion_count);
    }
    public function add($contest_slug = null)
    {
        if (!empty($this->request->data['Contest']['slug'])) {
            $contest_slug = $this->request->data['Contest']['slug'];
        }
        if (empty($contest_slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contain = array(
            'User',
            'ContestStatus',
            'ContestType'
        );
        if (isPluginEnabled('ContestFollowers')) {
            $ContestFollowers_contain = array(
                'ContestFollower' => array(
                    'conditions' => array(
                        'ContestFollower.user_id' => $this->Auth->user('id')
                    )
                )
            );
            $contain = array_merge($contain, $ContestFollowers_contain);
        }
        if (isPluginEnabled('TextResources')) {
            App::import('Model', 'Contests.MessageContent');
            $this->MessageContent = new MessageContent();
        }
        $contest = $this->ContestUser->Contest->find('first', array(
            'conditions' => array(
                'Contest.slug' => $contest_slug,
                'Contest.contest_status_id' => ConstContestStatus::Open,
                'Contest.user_id !=' => $this->Auth->user('id') ,
            ) ,
            'contain' => $contain,
            'recursive' => 1
        ));
        $resources = $this->ContestUser->Contest->Resource->activeResources();
        if (!in_array($contest['Contest']['resource_id'], $resources)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        $contest_user_count = $this->ContestUser->find('count', array(
            'conditions' => array(
                'ContestUser.user_id' => $this->Auth->user('id') ,
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.contest_user_status_id !=' => ConstContestUserStatus::Withdrawn,
                'ContestUser.is_active' => 1,
            ) ,
            'recursive' => -1
        ));
        $entries_count = $this->ContestUser->find('count', array(
            'conditions' => array(
                'ContestUser.contest_user_status_id !=' => ConstContestUserStatus::Withdrawn,
                'ContestUser.contest_id' => $contest['Contest']['id'],
                'ContestUser.is_active' => 1,
            ) ,
            'recursive' => -1
        ));
        $entry_condition = array(
            'ContestUser.user_id' => $this->Auth->user('id') ,
            'ContestUser.contest_id' => $contest['Contest']['id'],
            'ContestUser.is_active' => 1,
        );
        if (($contest_user_count >= $contest['Contest']['maximum_entry_allowed_per_user']) && $contest['Contest']['maximum_entry_allowed_per_user'] != 0) {
            $this->Session->setFlash(__l('Contest entry limit reached for you') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug']
            ));
        }
        if (empty($contest) || (strtotime($contest['Contest']['end_date']) -strtotime('now') < 0)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (($entries_count >= $contest['Contest']['maximum_entry_allowed']) && $contest['Contest']['maximum_entry_allowed'] != 0) {
            $this->Session->setFlash(__l('Its too late!!! This contest has reached its maximum allowed entry :(') , 'default', null, 'error');
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug']
            ));
        }
        $this->pageTitle = __l('Submit Your Work') . ' - ' . $contest['Contest']['name'];
        if ($this->request->is('post')) {
            $file_upload_size_setting = Configure::read('contestuser.file');
            if ($contest['Contest']['resource_id'] == ConstResource::Video) {
                $file_upload_size_setting = Configure::read('contestuser.video_file');
            } else if ($contest['Contest']['resource_id'] == ConstResource::Audio) {
                $file_upload_size_setting = Configure::read('contestuser.audio_file');
            }
            if (isset($this->request->data['Attachment']) && isPluginEnabled('VideoResources') && $contest['Contest']['resource_id'] == ConstResource::Video && Configure::read('hoster_service') == 'vimeo') {
                App::import('Model', 'VideoResources.Upload');
                $this->Upload = new Upload();
                if ($this->Upload->vimeoCheckQuota(Configure::read('hoster_service') , $this->request->data['Attachment']['video']['size']) == false) {
                    $this->Session->setFlash(__l('Problem in uploading. Please try again later.') , 'default', null, 'error');
                    $redirect_url = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $this->request->data['Contest']['slug']
                    ) , false);
                    $this->set('redirect_url', $redirect_url);
                    $this->autoLayout = true;
                    $this->render('redirect');
                }
            }
            $is_form_valid = true;
            $is_photo_uploaded = true;
            $photo_count = 0;
            if (isset($this->request->data['Attachment']) && !$this->RequestHandler->isAjax()) {
                for ($i = 0; $i < Configure::read('contestuser.maximum_photos_per_upload'); $i++) {
                    if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                        $photo_count++;
                        $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                        $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                        $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                        $this->ContestUser->Attachment->Behaviors->attach('ImageUpload', $file_upload_size_setting);
                        $this->ContestUser->Attachment->set($this->request->data);
                        if (!$this->ContestUser->validates() || !$this->ContestUser->Attachment->validates()) {
                            $attachmentValidationError[$i] = $this->ContestUser->Attachment->validationErrors['filename'][0];
                            $is_form_valid = false;
                        }
                    }
                }
                if (!$photo_count) {
                    $is_photo_uploaded = false;
                }
            }
            $is_file_added = 1;
            if (($contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio) && !isset($this->request->data['Attachment']) && empty($this->request->data['ContestUser']['is_file_added'])) {
                $is_file_added = 0;
            }
            if ($is_file_added && $is_photo_uploaded && $is_form_valid) {
                $this->ContestUser->create();
                $this->request->data['ContestUser']['ip_id'] = $this->ContestUser->toSaveIp();
                $this->request->data['ContestUser']['user_id'] = $this->Auth->user('id');
                $this->request->data['ContestUser']['contest_owner_user_id'] = $contest['Contest']['user_id'];
                $this->request->data['ContestUser']['contest_id'] = $contest['Contest']['id'];
                // Saving //
                $this->ContestUser->set($this->request->data);
				if ($contest['Contest']['resource_id'] != ConstResource::Text || ($contest['Contest']['resource_id'] == ConstResource::Text && trim(strip_tags(str_replace("&nbsp;", '', $this->request->data['MessageContent']['text_resource']))) != '')) {
                    if ($this->ContestUser->save($this->request->data)) {
                        $contest_user_id = $this->ContestUser->id;
                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                            '_trackEvent' => array(
                                'category' => 'EntryPost',
                                'action' => 'Entry',
                                'label' => 'Step 2',
                                'value' => '',
                            ) ,
                            '_setCustomVar' => array(
                                'cd' => $contest['Contest']['id'],
                                'cud' => $contest_user_id,
                                'ud' => $this->Auth->user('id') ,
                                'rud' => $this->Auth->user('referred_by_user_id') ,
                            )
                        ));
                        $this->ContestUser->Contest->ContestType->updateAll(array(
                            'ContestType.contest_user_count' => 'ContestType.contest_user_count +' . 1,
                        ) , array(
                            'ContestType.id' => $contest['Contest']['contest_type_id']
                        ));
                        $this->ContestUser->Contest->Resource->updateAll(array(
                            'Resource.contest_user_count' => 'Resource.contest_user_count +' . 1,
                        ) , array(
                            'Resource.id' => $contest['Contest']['resource_id']
                        ));
                        $contest_user_id = $this->ContestUser->getLastInsertId();
                        $folder_id = ConstMessageFolder::Inbox;
                        $depth = 0;
                        $parent_id = 0;
                        $contest_id = $contest['Contest']['id'];
                        $size = strlen($this->request->data['ContestUser']['description']);
                        $path = '';
                        $contest_status_id = ConstContestStatus::Open;
                        $contest_dispute_id = 0;
                        $is_private = 1;
                        if ($contest['Contest']['resource_id'] != ConstResource::Video && $contest['Contest']['resource_id'] != ConstResource::Audio || ($contest['Contest']['resource_id'] == ConstResource::Text && $this->MessageContent->validates())) {
                            $message_id = $this->ContestUser->saveMessageContent($this->request->data, $this->Auth->user('username'));
                            // To save in inbox //
                            $msg = $is_saved = $this->ContestUser->_saveMessage($depth, $path, $contest['Contest']['user_id'], $this->Auth->user('id') , $message_id, $folder_id, 0, 0, $parent_id, $size, $contest_id, $contest_user_id, $contest_status_id, $contest_dispute_id, $is_private);
                            // To save in sent iteams //
                            $is_saved = $this->ContestUser->_saveMessage($depth, $path, $this->Auth->user('id') , $contest['Contest']['user_id'], $message_id, ConstMessageFolder::SentMail, 1, 1, $parent_id, $size, $contest_id, $contest_user_id, $contest_status_id, $contest_dispute_id, $is_private);
                            // send Mail
                            $ContestUser = $this->ContestUser->find('first', array(
                                'conditions' => array(
                                    'ContestUser.id' => $contest_user_id
                                ) ,
                                'recursive' => -1
                            ));
                            $user = $this->ContestUser->User->find('first', array(
                                'conditions' => array(
                                    'User.id' => $contest['Contest']['user_id']
                                ) ,
                                'recursive' => -1
                            ));
                            App::import('Model', 'Contests.Message');
                            $this->Message = new Message();
                            $messageContent = $this->Message->MessageContent->find('first', array(
                                'conditions' => array(
                                    'MessageContent.id = ' => $message_id,
                                ) ,
                                'recursive' => -1
                            ));
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
                                '##OTHERUSERNAME##' => $user['User']['username'],
                                '##USERNAME##' => $this->Auth->user('username') ,
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##MESSAGE_LINK##' => Router::url(array(
                                    'controller' => 'messages',
                                    'action' => 'v',
                                    $get_message_hash['Message']['id'],
                                ) , true) ,
                                '##MESSAGE##' => $this->request->data['ContestUser']['description'],
                            );
                            if (!$messageContent['MessageContent']['admin_suspend'] && !$ContestUser['ContestUser']['admin_suspend']) {
                                App::import('Model', 'EmailTemplate');
                                $this->EmailTemplate = new EmailTemplate();
                                $template = $this->EmailTemplate->selectTemplate('New Message');
                                $this->ContestUser->_sendEmail($template, $email_replace, $user['User']['email']);
                            }
                            $this->ContestUser->postEntryActivity($contest, $contest_user_id);
                        }
                        if ($contest['Contest']['resource_id'] == ConstResource::Video) {
                            App::import('Model', 'VideoResources.Upload');
                            $this->Upload = new Upload();
                            $status_value = $this->Upload->uploadVideo($contest_user_id, $this->request->data, $this->Auth->user('username') , $this->Auth->user('id'));
                            switch ($status_value) {
                                case 1:
                                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
                                    break;

                                case 2:
                                    $this->update_maxumum_entry_no($contest['Contest']['id'], $contest_user_id);
                                    $this->Session->setFlash(__l('Your entry has submitted for processing. Please check the status in your participations list') , 'default', null, 'success');
                                    break;

                                case 3:
                                    $this->Session->setFlash(__l('Not able to retrieve the video status information yet. Please try again later.') , 'default', null, 'error');
                                    break;

                                case 5:
                                    $this->Session->setFlash(__l('Video file did not exist!') , 'default', null, 'error');
                                    break;

                                default:
                                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
                                    break;
                            }
                            $redirect_url = Router::url(array(
                                'controller' => 'contests',
                                'action' => 'view',
                                $this->request->data['Contest']['slug']
                            ) , false);
                            echo "<script>location.href = '" . $redirect_url . "'</script>";
                            exit;
                        } elseif ($contest['Contest']['resource_id'] == ConstResource::Audio) {
                            App::import('Model', 'AudioResources.AudioUpload');
                            $this->AudioUpload = new AudioUpload();
                            $status_value = $this->AudioUpload->uploadAudio($contest_user_id, $this->request->data, $this->Auth->user('username') , $this->Auth->user('id') , null, $contest);
                            switch ($status_value) {
                                case 'processing':
                                    $this->update_maxumum_entry_no($contest['Contest']['id'], $contest_user_id);
                                    $this->Session->setFlash(__l('Your entry has submitted for processing. Please check the status in your participations list') , 'default', null, 'success');
                                    break;

                                case 'finished':
                                    $this->update_maxumum_entry_no($contest['Contest']['id'], $contest_user_id);
                                    $this->Session->setFlash(__l('Your entry has submitted successfully') , 'default', null, 'success');
                                    break;

                                default:
                                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
                                    break;
                            }
                            $redirect_url = Router::url(array(
                                'controller' => 'contests',
                                'action' => 'view',
                                $this->request->data['Contest']['slug']
                            ) , false);
                            echo "<script>location.href = '" . $redirect_url . "'</script>";
                            exit;
                        } elseif ($contest['Contest']['resource_id'] == ConstResource::Text) {
                            if (empty($this->MessageContent->validationErrors)) {
                                $this->update_maxumum_entry_no($contest['Contest']['id'], $contest_user_id);
                                $this->Session->setFlash(__l('Your entry has submitted successfully') , 'default', null, 'success');
                            } else {
                                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
                            }
                            $this->redirect(array(
                                'controller' => 'contests',
                                'action' => 'view',
                                $this->request->data['Contest']['slug']
                            ));
                        } elseif (!isset($this->request->data['Attachment']) && $this->RequestHandler->isAjax()) {
                            $this->request->data['Attachment']['foreign_id'] = $contest_user_id;
                            $this->request->data['Attachment']['description'] = 'ContestUser';
                            $this->Session->write('ContestUser.id', $contest_user_id);
                            $this->XAjax->flashuploadset($this->request->data);
                        } else {
                            // Check for allowed file size
                            $filesize = 0;
                            foreach($this->request->data['Attachment'] as $files) {
                                if (!empty($files['filename'])) {
                                    $filesize+= $files['filename']['size'];
                                }
                            }
                            $is_form_valid = true;
                            $upload_photo_count = 0;
                            for ($i = 0; $i < Configure::read('contestuser.maximum_photos_per_upload'); $i++) {
                                if (!empty($this->request->data['Attachment'][$i]['filename']['error'])) {
                                    $attachmentValidationError[$i] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                                    $is_form_valid = false;
                                    $upload_photo_count++;
                                    continue;
                                }
                                if (!empty($this->request->data['Attachment'][$i]['filename']['tmp_name'])) {
                                    $upload_photo_count++;
                                    $image_info = getimagesize($this->request->data['Attachment'][$i]['filename']['tmp_name']);
                                    $this->request->data['Attachment']['filename'] = $this->request->data['Attachment'][$i]['filename'];
                                    $this->request->data['Attachment']['filename']['type'] = $image_info['mime'];
                                    $this->request->data['Attachment'][$i]['foreign_id'] = $contest_user_id;
                                    $this->ContestUser->Attachment->Behaviors->attach('ImageUpload', $file_upload_size_setting);
                                    $this->ContestUser->Attachment->set($this->request->data);
                                    if (!$this->ContestUser->validates() |!$this->ContestUser->Attachment->validates()) {
                                        $attachmentValidationError[$i] = $this->ContestUser->Attachment->validationErrors['filename'][0];
                                        $is_form_valid = false;
                                        $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
                                    }
                                }
                            }
                            if (!$upload_photo_count) {
                                $this->ContestUser->validates();
                                $this->ContestUser->Attachment->validationErrors[0]['filename'] = __l('Required');
                                $is_form_valid = false;
                            }
                            if (!empty($attachmentValidationError)) {
                                foreach($attachmentValidationError as $key => $error) {
                                    $this->ContestUser->Attachment->validationErrors[$key]['filename'] = $error;
                                }
                            }
                            if ($is_form_valid) {
                                $this->request->data['foreign_id'] = $contest_user_id;
                                $entry_no = $this->update_maxumum_entry_no($contest['Contest']['id'], $contest_user_id);
                                $this->XAjax->normalupload($this->request->data, false);
                                App::import('Model', 'Contests.Message');
                                $this->Message = new Message();
                                $message = $this->Message->find('first', array(
                                    'conditions' => array(
                                        'Message.contest_user_id' => $this->request->data['foreign_id'],
                                        'Message.is_activity' => 0,
                                        'Message.is_sender' => 0
                                    ) ,
                                    'recursive' => -1
                                ));
                                $attachment = $this->ContestUser->Attachment->find('first', array(
                                    'conditions' => array(
                                        'Attachment.class' => 'ContestUser',
                                        'Attachment.foreign_id' => $this->request->data['foreign_id']
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->Message->MessageContent->Attachment->Behaviors->detach('ImageUpload');
                                $_data['Attachment']['filename'] = $this->request->data['Attachment']['filename'];
                                $_data['Attachment']['filename']['tmp_name'] = APP . 'media' . DS . $attachment['Attachment']['dir'] . DS . $attachment['Attachment']['filename'];
                                $this->Message->MessageContent->Attachment->Behaviors->attach('ImageUpload', $file_upload_size_setting);
                                $this->Message->MessageContent->Attachment->isCopyUpload(true);
                                $this->Message->MessageContent->Attachment->set($_data);
                                $this->Message->MessageContent->Attachment->create();
                                $_data['Attachment']['filename'] = $_data['Attachment']['filename'];
                                $_data['Attachment']['class'] = 'MessageContent';
                                $_data['Attachment']['message_id'] = $message['Message']['id'];
                                $_data['Attachment']['foreign_id'] = $message['Message']['message_content_id'];
                                $this->Message->MessageContent->Attachment->save($_data);
                                if (!empty($entry_no)) {
                                    $ContestUser = $this->ContestUser->find('first', array(
                                        'conditions' => array(
                                            'ContestUser.entry_no' => $entry_no,
                                            'ContestUser.contest_id' => $this->request->data['ContestUser']['contest_id'],
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    if (!empty($ContestUser['ContestUser']['admin_suspend'])) {
                                        $this->Session->setFlash(__l('Entry has been suspended due to containing suspicious words and that will be approved or deleted after administrative reviewing') , 'default', null, 'error');
                                    } else {
                                        $this->Session->setFlash(__l('Your entry has submitted successfully') , 'default', null, 'success');
                                    }
                                }
                                $this->redirect(array(
                                    'controller' => 'contests',
                                    'action' => 'view',
                                    $this->request->data['Contest']['slug']
                                ));
                            }
                        }
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
                    }
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, enter the your entry.') , __l('Entry')) , 'default', null, 'error');
                }
            } else {
                if (!$is_photo_uploaded) {
                    $this->ContestUser->validates();
                    $this->ContestUser->Attachment->validationErrors[0]['filename'] = __l('Required');
                }
                if (!empty($attachmentValidationError)) {
                    foreach($attachmentValidationError as $key => $error) {
                        $this->ContestUser->Attachment->validationErrors[$key]['filename'] = $error;
                    }
                }
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
            }
        } else {
            Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'EntryPost',
                    'action' => 'Entry',
                    'label' => 'Step 1',
                    'value' => '',
                ) ,
                '_setCustomVar' => array(
                    'cd' => $contest['Contest']['id'],
                    'ud' => $this->Auth->user('id') ,
                    'rud' => $this->Auth->user('referred_by_user_id') ,
                )
            ));
        }
        $user_details = $this->ContestUser->User->UserProfile->find('first', array(
            'conditions' => array(
                'UserProfile.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $this->set('user_details', $user_details);
        $this->set('contest', $contest);
        if (empty($this->request->data)) {
            $this->request->data['Contest']['slug'] = $contest['Contest']['slug'];
        }
        $this->set(compact('users'));
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contest_user = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($contest_user) || $contest_user['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won) {
            throw new NotFoundException(__l('Invalid entry'));
        }
        $this->ContestUser->id = $id;
        if (!$this->ContestUser->exists()) {
            throw new NotFoundException(__l('Invalid entry'));
        }
        $ContestUser = array();
        $ContestUser = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $id
            ) ,
            'recursive' => -1
        ));
        $process_return = $this->ContestUser->_processEntry($id, ConstContestUserStatus::Deleted);
        if ($this->ContestUser->delete()) {
            $_Data = array();
            $_Data['Contest']['id'] = $ContestUser['ContestUser']['contest_id'];
            $_Data['Contest']['winner_user_id'] = 0;
            $this->ContestUser->Contest->save($_Data);
            $this->_updatecount($id, $ContestUser['ContestUser']['contest_id'], $ContestUser['ContestUser']['user_id']);
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Entry')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
                'type' => 'myparticipation',
                'filter_id' => 1,
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function flashupload()
    {
        $this->autoRender = false;
        $this->ContestUser->Attachment->Behaviors->attach('ImageUpload', Configure::read('contestuser.file'));
        $this->XAjax->flashupload();
    }
    public function update()
    {
        if ($this->Session->check('flashupload_data') || !empty($this->request->data)) {
            $contest_users = $this->Session->read('flashupload_data');
            if (empty($contest_users)) {
                $contest_user = $this->request->data;
                $contest_users['ContestUsers'] = $this->request->data;
            } else {
                $contest_user = $contest_users['ContestUsers'];
                $attachment = $this->ContestUser->Attachment->find('first', array(
                    'conditions' => array(
                        'Attachment.class' => 'ContestUser',
                        'Attachment.foreign_id' => $contest_users['ContestUsers']['Attachment']['foreign_id']
                    ) ,
                    'recursive' => -1
                ));
                App::import('Model', 'Contests.Message');
                $this->Message = new Message();
                $message = $this->Message->find('first', array(
                    'conditions' => array(
                        'Message.contest_user_id' => $contest_users['ContestUsers']['Attachment']['foreign_id']
                    ) ,
                    'recursive' => -1
                ));
                $this->request->data['Attachment']['filename']['type'] = $attachment['Attachment']['mimetype'];
                $this->request->data['Attachment']['filename']['name'] = $attachment['Attachment']['filename'];
                $this->request->data['Attachment']['filename']['tmp_name'] = APP . 'media' . DS . $attachment['Attachment']['dir'] . DS . $attachment['Attachment']['filename'];
                $this->request->data['Attachment']['filename']['size'] = $attachment['Attachment']['filesize'];
                $this->request->data['Attachment']['filename']['error'] = 0;
                $this->Message->MessageContent->Attachment->Behaviors->attach('ImageUpload', Configure::read('contestuser.file'));
                $this->Message->MessageContent->Attachment->isCopyUpload(true);
                $this->Message->MessageContent->Attachment->set($this->request->data);
                $this->Message->MessageContent->Attachment->create();
                $this->request->data['Attachment']['filename'] = $this->request->data['Attachment']['filename'];
                $this->request->data['Attachment']['class'] = 'MessageContent';
                $this->request->data['Attachment']['foreign_id'] = $message['Message']['message_content_id'];
                $this->request->data['Attachment']['message_id'] = $message['Message']['id'];
                $this->Message->MessageContent->Attachment->save($this->request->data);
                $this->Session->delete('flash_uploaded');
                $this->Session->delete('flashupload_data');
            }
            $this->update_maxumum_entry_no($contest_users['ContestUsers']['ContestUser']['contest_id'], $contest_users['ContestUsers']['Attachment']['foreign_id']);
            $ContestUser = $this->ContestUser->find('first', array(
                'conditions' => array(
                    'ContestUser.entry_no' => $contest_user['ContestUser']['entry_no'],
                    'ContestUser.contest_id' => $contest_user['ContestUser']['contest_id'],
                ) ,
                'recursive' => -1
            ));
            if (!empty($ContestUser['ContestUser']['admin_suspend'])) {
                $this->Session->setFlash(__l('Entry has been suspended due to containing suspicious words and that will be approved or deleted after administrative reviewing') , 'default', null, 'error');
            } else {
                $this->Session->setFlash(__l('Your entry has submitted successfully') , 'default', null, 'success');
            }
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest_user['Contest']['slug']
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    function update_status()
    {
        if (empty($this->request->params['named']['status']) || (empty($this->request->params['named']['entry']) && !is_numeric($this->request->params['named']['entry']))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contestUser = $this->ContestUser->_getEntry($this->request->params['named']['entry']);
        if (empty($contestUser)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active) {
            if ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open and $this->request->params['named']['status'] != ConstContestUserStatus::Won) {
                if ($this->request->params['named']['status'] == ConstContestUserStatus::Withdrawn && (($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin)) {
                    $process_return = $this->ContestUser->_processEntry($this->request->params['named']['entry'], $this->request->params['named']['status']);
                } elseif ($this->request->params['named']['status'] == ConstContestUserStatus::Eliminated && (($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin)) {
                    $process_return = $this->ContestUser->_processEntry($this->request->params['named']['entry'], $this->request->params['named']['status']);
                }
            } else if ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) {
                $process_return = $this->ContestUser->_processEntry($this->request->params['named']['entry'], $this->request->params['named']['status']);
            }
        }
        if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated || $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
            if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
                if ($this->Auth->user('id') != $contestUser['Contest']['user_id'] && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
                    throw new NotFoundException(__l('Invalid request'));
                }
            } else {
                if ($this->Auth->user('id') != $contestUser['ContestUser']['user_id'] && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
                    throw new NotFoundException(__l('Invalid request'));
                }
            }
            $process_return = $this->ContestUser->_processEntry($this->request->params['named']['entry'], $this->request->params['named']['status']);
        }
        if (!empty($process_return)) {
            if (!empty($process_return['error'])) {
                if ($this->RequestHandler->prefers('json')) {
                    $response = array(
                        'status' => false,
                        'message' => $process_return['message'],
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
                } else {
                    $this->Session->setFlash($process_return['message'], 'default', null, 'error');
                }
            } elseif (!empty($process_return['success'])) {
                if ($this->RequestHandler->prefers('json')) {
                    $url = array();
                    $won = "";
                    if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == ConstContestUserStatus::Withdrawn || $this->request->params['named']['status'] == ConstContestUserStatus::Eliminated)) {
                        if ($this->request->params['named']['status'] == ConstContestUserStatus::Withdrawn) {
                            $label = 'Cancel Withdrawn';
                        }
                        if ($this->request->params['named']['status'] == ConstContestUserStatus::Eliminated) {
                            $label = 'Cancel Eliminate';
                        }
                        $url = Router::url(array(
                            'controller' => 'contest_users',
                            'action' => 'update_status',
                            'entry' => $contestUser['ContestUser']['id'],
                            'status' => ConstContestUserStatus::Active,
                            'plugin' => 'contests',
                            'admin' => false,
                            'ext' => 'json'
                        ) , true);
                    } else if (!empty($this->request->params['named']['status'])) {
                        if ($contestUser['Contest']['user_id'] == $this->Auth->user('id')) {
                            $status = ConstContestUserStatus::Eliminated;
                            $label = 'Eliminate';
                        }
                        if ($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) {
                            $status = ConstContestUserStatus::Withdrawn;
                            $label = 'Withdraw';
                        }
                        $url = Router::url(array(
                            'controller' => 'contest_users',
                            'action' => 'update_status',
                            'entry' => $contestUser['ContestUser']['id'],
                            'status' => $status,
                            'plugin' => 'contests',
                            'admin' => false,
                            'ext' => 'json'
                        ) , true);
                        $won = Router::url(array(
                            'controller' => 'contest_users',
                            'action' => 'update_status',
                            'entry' => $contestUser['ContestUser']['id'],
                            'status' => ConstContestUserStatus::Won,
                            'plugin' => 'contests',
                            'admin' => false,
                            'ext' => 'json'
                        ) , true);
                    }
                    $response = array(
                        'status' => true,
                        'message' => $process_return['message'],
                        'url' => $url,
                        'label' => $label,
                        'won' => $won
                    );
                    $this->view = 'Json';
                    $this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
                } else {
                    $this->Session->setFlash($process_return['message'], 'default', null, 'success');
                }
            }
            if (!$this->RequestHandler->prefers('json')) {
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    if (isset($_GET['r'])) {
                        $this->redirect(Router::url('/', true) . $_GET['r']);
                    } else {
                        $this->redirect(array(
                            'action' => 'index',
                            'filter_id' => 1,
                            'admin' => true
                        ));
                    }
                } else {
                    if (isset($_GET['r'])) {
                        $this->redirect(Router::url('/', true) . $_GET['r']);
                    } else {
                        $this->redirect(array(
                            'controller' => 'contests',
                            'action' => 'view',
                            $process_return['Contest']['slug']
                        ));
                    }
                }
            }
        }
        $this->ContestUser->updateContestUserCountInUser(array(
            $contestUser['ContestUser']['user_id']
        ) , $contestUser['ContestUser']['contest_user_status_id']);
        if (!$this->RequestHandler->prefers('json')) {
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                if (isset($_GET['r'])) {
                    $this->redirect(Router::url('/', true) . $_GET['r']);
                } else {
                    $this->redirect(array(
                        'action' => 'index',
                        'filter_id' => 1,
                        'admin' => true
                    ));
                }
            } else {
                if (isset($_GET['r'])) {
                    $this->redirect(Router::url('/', true) . $_GET['r']);
                } else {
                    $this->redirect(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $contestUser['Contest']['slug']
                    ));
                }
            }
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Entries');
        $this->_redirectPOST2Named(array(
            'ContestUser.from_date',
            'ContestUser.to_date',
            'User.username',
            'ContestUser.q',
        ));
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $conditions = array();
		if (isPluginEnabled('VideoResources')) {
            	$conditions['OR']['Contest.resource_id'][] =  ConstResourceId::Video;
        }
        if (isPluginEnabled('AudioResources')) {
			$conditions['OR']['Contest.resource_id'][] = ConstResourceId::Audio;
		}
		if (isPluginEnabled('TextResources')) {
			$conditions['OR']['Contest.resource_id'][] = ConstResourceId::Text;
		}
		if (isPluginEnabled('ImageResources')) {
			$conditions['OR']['Contest.resource_id'][] = ConstResourceId::Image;
		}
		
        if (!empty($this->request->data['ContestUser']['user_id'])) {
            $this->request->params['named']['user_id'] = $this->request->data['ContestUser']['user_id'];
        }
        $param_string = "";
        $param_string.= !empty($this->request->params['named']['user_id']) ? '/user_id:' . $this->request->params['named']['user_id'] : $param_string;
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['q'])) {
            $this->pageTitle.= __l(' - Search');
        }
        if (!empty($this->request->data['ContestUser']['from_date']['year']) && !empty($this->request->data['ContestUser']['from_date']['month']) && !empty($this->request->data['ContestUser']['from_date']['day'])) {
            $this->request->params['named']['from_date'] = $this->request->data['ContestUser']['from_date']['year'] . '-' . $this->request->data['ContestUser']['from_date']['month'] . '-' . $this->request->data['ContestUser']['from_date']['day'] . ' 00:00:00';
        }
        if (!empty($this->request->data['ContestUser']['to_date']['year']) && !empty($this->request->data['ContestUser']['to_date']['month']) && !empty($this->request->data['ContestUser']['to_date']['day'])) {
            $this->request->params['named']['to_date'] = $this->request->data['ContestUser']['to_date']['year'] . '-' . $this->request->data['ContestUser']['to_date']['month'] . '-' . $this->request->data['ContestUser']['to_date']['day'] . ' 23:59:59';
        }
        if (isset($this->request->data['ContestUser']['from_date']) and isset($this->request->data['ContestUser']['to_date'])) {
            $from_date = $this->request->data['ContestUser']['from_date']['year'] . '-' . $this->request->data['ContestUser']['from_date']['month'] . '-' . $this->request->data['ContestUser']['from_date']['day'] . ' 00:00:00';
            $to_date = $this->request->data['ContestUser']['to_date']['year'] . '-' . $this->request->data['ContestUser']['to_date']['month'] . '-' . $this->request->data['ContestUser']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            if ($this->request->params['named']['from_date'] < $this->request->params['named']['to_date']) {
                $conditions['ContestUser.created >='] = $this->request->params['named']['from_date'];
                $conditions['ContestUser.created <='] = $this->request->params['named']['to_date'];
                $credit_conditions['ContestUser.created >='] = $this->request->params['named']['from_date'];
                $credit_conditions['ContestUser.created <='] = $this->request->params['named']['to_date'];
                $debit_conditions['ContestUser.created >='] = $this->request->params['named']['from_date'];
                $debit_conditions['ContestUser.created <='] = $this->request->params['named']['to_date'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['username'])) {
            $get_user_id = $this->ContestUser->User->find('list', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['username'],
                ) ,
                'fields' => array(
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            $conditions['OR']['ContestUser.user_id'] = $get_user_id;
            $conditions['OR']['ContestUser.contest_owner_user_id'] = $get_user_id;
            $this->request->data['ContestUser']['user_id'] = $get_user_id;
            $this->pageTitle.= sprintf(__l(' - %s') , $this->request->params['named']['username']);
            if (!empty($this->request->params['named']['username'])) {
                $this->set('username', $this->request->params['named']['username']);
            }
        }
        if (!empty($this->request->params['named']['contestid'])) {
            $contest = $this->ContestUser->Contest->find('first', array(
                'conditions' => array(
                    'Contest.slug' => $this->request->params['named']['contestid'],
                ) ,
                'recursive' => -1
            ));
            $conditions['ContestUser.contest_id'] = $contest['Contest']['id'];
        }
        if (!empty($this->request->params['named']['contest_id'])) {
            $conditions['ContestUser.contest_id'] = $this->request->params['named']['contest_id'];
        }
        if (!empty($this->request->params['named']['type']) && ($this->request->params['named']['type'] == 'winner_select')) {
            $this->request->params['named']['sort'] = 'contest_user_rating_count';
            $this->request->params['named']['direction'] = 'desc';
        }
        if (!empty($this->request->data['User']['username'])) {
            $get_user_id = $this->ContestUser->User->find('list', array(
                'conditions' => array(
                    'User.username' => $this->request->data['User']['username'],
                ) ,
                'fields' => array(
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_user_id)) {
                $conditions['ContestUser.user_id'] = $get_user_id;
            }
        }
        if (!empty($this->request->params['named']['stat'])) {
            if (!empty($this->request->params['named']['stat'])) {
                if ($this->request->params['named']['stat'] == 'day') {
                    $conditions['ContestUser.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
                    $conditions['ContestUser.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
                    $this->pageTitle = __l('Contest Entries - Today');
                    $this->set('transaction_filter', __l('- Today'));
                    $days = 0;
                } else if ($this->request->params['named']['stat'] == 'week') {
                    $conditions['TO_DAYS(NOW()) - TO_DAYS(ContestUser.created) <='] = 7;
                    $conditions['ContestUser.created <= '] = date('Y-m-d H:is', strtotime('now'));
                    $conditions['ContestUser.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
                    $this->pageTitle = __l('Contest Entries - This Week');
                    $this->set('transaction_filter', __l('- This Week'));
                    $days = 7;
                } else if ($this->request->params['named']['stat'] == 'month') {
                    $conditions['ContestUser.created <= '] = date('Y-m-d H:is', strtotime('now'));
                    $conditions['ContestUser.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
                    $this->pageTitle = __l('Contest Entries - This Month');
                    $this->set('transaction_filter', __l('- This Month'));
                    $days = 30;
                } else {
                    $this->pageTitle = __l('Contest Entries - Total');
                    $this->set('transaction_filter', __l('- Total'));
                }
            }
        }
        if (isset($this->params['named']['filter_id'])) {
            $this->request->data['ContestUser']['filter_id'] = $this->params['named']['filter_id'];
        }
        if (!empty($this->request->data['ContestUser']['filter_id'])) {
            switch ($this->request->data['ContestUser']['filter_id']) {
                case ConstContestUserStatus::Active:
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Active;
                    $this->pageTitle.= __l(' - Active');
                    break;

                case ConstContestUserStatus::Withdrawn:
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Withdrawn;
                    $this->pageTitle.= __l(' - Withdrawn');
                    break;

                case ConstContestUserStatus::Eliminated:
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Eliminated;
                    $this->pageTitle.= __l(' - Eliminated');
                    break;

                case ConstContestStatus::FilesExpectation:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::FilesExpectation;
                    $this->pageTitle.= __l(' - Expecting Deliverables ');
                    break;

                case ConstContestUserStatus::Won:
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::WinnerSelected,
                        ConstContestStatus::WinnerSelectedByAdmin,
                    );
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Won');
                    break;

                case ConstContestUserStatus::Lost:
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Lost;
                    $this->pageTitle.= __l(' - Lost');
                    break;

                case ConstContestStatus::ChangeRequested:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeRequested;
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Change Requested');
                    break;

                case ConstContestStatus::ChangeCompleted:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeCompleted;
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Change Completed');
                    break;

                case ConstContestStatus::Completed:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Completed;
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Completed');
                    break;

                case ConstContestStatus::PaidToParticipant:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PaidToParticipant;
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Closed');
                    break;

                case 'entry':
                    $conditions['ContestUser.contest_user_status_id'] = array(
                        ConstContestUserStatus::Active,
                        ConstContestUserStatus::Withdrawn,
                        ConstContestUserStatus::Eliminated,
                        ConstContestUserStatus::Lost,
                    );
                    $this->pageTitle.= __l(' - Entry');
                    break;

                case 'development':
                    $conditions = array(
                        'OR' => array(
                            array(
                                'Contest.contest_status_id' => array(
                                    ConstContestStatus::ChangeRequested,
                                    ConstContestStatus::ChangeCompleted,
                                    ConstContestStatus::Completed,
                                    ConstContestStatus::PaidToParticipant,
                                ) ,
                                'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                            ) ,
                            array(
                                'Contest.contest_status_id' => array(
                                    ConstContestStatus::WinnerSelected,
                                    ConstContestStatus::WinnerSelectedByAdmin,
                                )
                            )
                        )
                    );
                    $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Development');
                    break;
            }
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Contest.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'ContestUser.description LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestUser']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'flagged') {
            $conditions['ContestUser.is_system_flagged'] = 1;
            $this->pageTitle.= __l(' - System Flagged');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') {
            $conditions['ContestUser.is_user_flagged'] = 1;
            $this->pageTitle.= __l(' - User Flagged');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'suspended') {
            $conditions['ContestUser.admin_suspend'] = 1;
            $this->pageTitle.= __l(' - Suspended');
        }
        $this->loadModel('Contests.ContestType');
        $contain = array(
            'Attachment',
            'Message' => array(
                'MessageContent' => array(
                    'fields' => array(
                        'MessageContent.text_resource',
                    )
                )
            ) ,
            'User' => array(
                'UserAvatar',
            ) ,
            'ContestUserStatus',
            'Contest' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'ContestStatus' => array(
                    'fields' => array(
                        'ContestStatus.id',
                        'ContestStatus.name',
                        'ContestStatus.slug',
                    )
                ) ,
                'ContestType' => array(
                    'Resource',
                    'fields' => array(
                        'ContestType.id',
                        'ContestType.resource_id',
                        'ContestType.is_watermarked',
                    )
                ) ,
                'Resource'
            ) ,
        );
        if (isPluginEnabled('VideoResources')) {
            $video_contain = array(
                'Upload'
            );
            $contain = array_merge($contain, $video_contain);
        }
        if (isPluginEnabled('AudioResources')) {
            $audio_contain = array(
                'AudioUpload'
            );
            // We used table 'uploads' for model AudioUpload with useTable concept in model. But it working in admin/audio_uploads.. But here it cases the error (Missing Database Table Error: Table audio_uploads for model AudioUpload was not found in datasource default.) So here we mapped  useTable again.
            App::import('Model', 'AudioResources.AudioUpload');
            $this->AudioUpload = new AudioUpload();
            $this->AudioUpload->useTable = 'uploads';
            $contain = array_merge($contain, $audio_contain);
        }
		if (isPluginEnabled('TextResources')) {
            $contain['TextResource'] = array(
				'MessageContent'
			);
        }
        if (isPluginEnabled('EntryFlags')) {
            $EntryFlags_contain = array(
                'ContestUserFlag'
            );
            $contain = array_merge($contain, $EntryFlags_contain);
        }
		$this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => 'ContestUser.id desc',
            'recursive' => 3
        );
        $contestUsers = $this->paginate();
        $moreActions = array();
        if (!empty($this->request->data['ContestUser']['filter_id'])) {
            if ($this->request->data['ContestUser']['filter_id'] == ConstContestUserStatus::Active) {
                $moreActions = array(
                    ConstMoreAction::Withdrawn => __l('Withdraw') ,
                    ConstMoreAction::Eliminated => __l('Eliminate') ,
                );
            } elseif (in_array($this->request->data['ContestUser']['filter_id'], array(
                ConstContestUserStatus::Won,
                ConstContestStatus::ChangeRequested,
                ConstContestStatus::ChangeCompleted
            ))) {
                $moreActions = array(
                    ConstMoreAction::Completed => __l('Completed') ,
                );
            } elseif ($this->request->data['ContestUser']['filter_id'] == ConstContestUserStatus::Withdrawn) {
                $moreActions = array(
                    ConstMoreAction::Active => __l('Cancel Withdraw') ,
                );
            } elseif ($this->request->data['ContestUser']['filter_id'] == ConstContestUserStatus::Eliminated) {
                $moreActions = array(
                    ConstMoreAction::Active => __l('Cancel Eliminate') ,
                );
            }
            $moreActions+= array(
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        $system_flagged_count = $this->ContestUser->find('count', array(
            'conditions' => array(
                'ContestUser.is_system_flagged' => 1
            ) ,
            'recursive' => -1
        ));
        $user_flagged_count = $this->ContestUser->find('count', array(
            'conditions' => array(
                'ContestUser.is_user_flagged' => 1
            ) ,
            'recursive' => -1
        ));
        $suspended_count = $this->ContestUser->find('count', array(
            'conditions' => array(
                'ContestUser.admin_suspend' => 1
            ) ,
            'recursive' => -1
        ));
        $this->ContestUser->validate = array();
        $this->ContestUser->User->validate = array();
        $filters = $this->ContestUser->isFilterOptions;
        $this->set(compact('filters', 'moreActions', 'system_flagged_count', 'user_flagged_count', 'suspended_count'));
        $this->set('contestUsers', $this->paginate());
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->ContestUser->id = $id;
        if (!$this->ContestUser->exists()) {
            throw new NotFoundException(__l('Invalid entry'));
        }
        $ContestUser = array();
        $ContestUser = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $id
            ) ,
            'recursive' => -1
        ));
        $process_return = $this->ContestUser->_processEntry($id, ConstContestUserStatus::Deleted);
        if ($this->ContestUser->delete()) {
            $_Data = array();
            $_Data['Contest']['id'] = $ContestUser['ContestUser']['contest_id'];
            $_Data['Contest']['winner_user_id'] = 0;
            $this->ContestUser->Contest->save($_Data);
            $this->_updatecount($id, $ContestUser['ContestUser']['contest_id'], $ContestUser['ContestUser']['user_id']);
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Entry')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
                'filter_id' => 1
            ));
        }
        $this->Session->setFlash(sprintf(__l('%s was not deleted') , __l('Entry')) , 'default', null, 'error');
        $this->redirect(array(
            'action' => 'index',
            'filter_id' => 1
        ));
    }
    public function admin_update_status($contest_id = null, $status_id = null)
    {
        if (!empty($this->request->params['named']['status'])) {
            if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'flag')) {
                $_data['ContestUser']['id'] = $contest_id;
                $_data['ContestUser']['is_system_flagged'] = 1;
                $this->ContestUser->save($_data);
                $this->Session->setFlash(__l('Entry has been flagged') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'userflag')) {
                $_data['ContestUser']['id'] = $contest_id;
                $_data['ContestUser']['is_user_flagged'] = 0;
                $this->ContestUser->save($_data);
                $this->Session->setFlash(__l('Entry has been unflagged') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'systemflag')) {
                $_data['ContestUser']['id'] = $contest_id;
                $_data['ContestUser']['is_system_flagged'] = 0;
                $this->ContestUser->save($_data);
                $this->Session->setFlash(__l('Entry has been unflagged') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'suspend')) {
                $_data['ContestUser']['id'] = $contest_id;
                $_data['ContestUser']['admin_suspend'] = 1;
                $this->ContestUser->save($_data);
                $this->_updatecount($contest_id);
                $this->Session->setFlash(__l('Entry has been suspended') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'unsuspend')) {
                $_data['ContestUser']['id'] = $contest_id;
                $_data['ContestUser']['admin_suspend'] = 0;
                $this->ContestUser->save($_data);
                $this->_updatecount($contest_id);
                $this->Session->setFlash(__l('Entry has been unsuspended') , 'default', null, 'success');
            }
            if (isset($_GET['r'])) {
                $this->redirect(Router::url('/', true) . $_GET['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index',
                    'filter_id' => ConstContestUserStatus::Active
                ));
            }
        } else {
            $this->ContestUser->Contest->updateStatus($status_id, $contest_id);
            if (isset($_GET['r'])) {
                $this->redirect(Router::url('/', true) . $_GET['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index',
                    'filter_id' => $status_id
                ));
            }
        }
    }
    public function _updatecount($id, $contest_id = null, $user_id = null)
    {
        $contest_user = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $id
            ) ,
            'recursive' => -1
        ));
        if (empty($contest_id)) {
            $contest_id = $contest_user['ContestUser']['contest_id'];
        }
        $ContestUsers = $this->ContestUser->find('list', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest_id,
                'ContestUser.admin_suspend' => 0
            ) ,
            'fields' => array(
                'ContestUser.user_id',
                'ContestUser.contest_id',
            ) ,
            'recursive' => -1
        ));
        $participant_count = count($ContestUsers);
        $this->ContestUser->Contest->updateAll(array(
            'Contest.partcipant_count' => $participant_count,
        ) , array(
            'Contest.id' => $contest_id
        ));
        if (!empty($user_id)) {
            $contestUser = $this->ContestUser->find('all', array(
                'conditions' => array(
                    'ContestUser.user_id' => $user_id
                ) ,
                'fields' => array(
                    'SUM(ContestUser.contest_user_total_ratings) as total_ratings',
                    'SUM(ContestUser.contest_user_rating_count) as rating_count',
                ) ,
                'recursive' => -1
            ));
            $this->ContestUser->User->updateAll(array(
                'User.total_ratings' => $contestUser[0][0]['total_ratings'],
                'User.rating_count' => $contestUser[0][0]['rating_count']
            ) , array(
                'User.id' => $user_id
            ));
        }
    }
    public function admin_update()
    {
        if (!empty($this->request->data['ContestUser'])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $contestUserIds = array();
            foreach($this->request->data['ContestUser'] as $contest_user_id => $is_checked) {
                if ($is_checked['id']) {
                    $contestUserIds[] = $contest_user_id;
                }
            }
            if ($actionid && !empty($contestUserIds)) {
                if ($actionid == ConstMoreAction::Active) {
                    foreach($contestUserIds as $id) {
                        $_data['ContestUser']['id'] = $id;
                        $_data['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Active;
                        $this->ContestUser->save($_data);
                    }
                    $this->ContestUser->updateContestUserCountInUser($contestUserIds, ConstContestUserStatus::Active);
                    $this->Session->setFlash(__l('Checked contest entries has been actived') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Eliminated) {
                    foreach($contestUserIds as $id) {
                        $_data['ContestUser']['id'] = $id;
                        $_data['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Eliminated;
                        $this->ContestUser->save($_data);
                    }
                    $process_return = $this->ContestUser->_processEntry($contestUserIds, ConstMoreAction::Eliminated);
                    $this->ContestUser->updateContestUserCountInUser($contestUserIds, ConstMoreAction::Eliminated);
                    $this->Session->setFlash(__l('Checked entries has been eliminated') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Withdrawn) {
                    foreach($contestUserIds as $id) {
                        $_data['ContestUser']['id'] = $id;
                        $_data['ContestUser']['contest_user_status_id'] = ConstContestUserStatus::Withdrawn;
                        $this->ContestUser->save($_data);
                    }
                    $process_return = $this->ContestUser->_processEntry($contestUserIds, ConstMoreAction::Withdrawn);
                    $this->ContestUser->updateContestUserCountInUser($contestUserIds, ConstContestUserStatus::Withdrawn);
                    $this->Session->setFlash(__l('Checked entries has been withdrawn') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Delete) {
                    foreach($contestUserIds as $contestUserId) {
                        $ContestUser = array();
                        $ContestUser = $this->ContestUser->find('first', array(
                            'conditions' => array(
                                'ContestUser.id' => $contestUserId
                            ) ,
                            'recursive' => -1
                        ));
                        $this->ContestUser->id = $contestUserId;
                        $this->ContestUser->delete();
                        $_Data = array();
                        $_Data['Contest']['id'] = $ContestUser['ContestUser']['contest_id'];
                        $_Data['Contest']['winner_user_id'] = 0;
                        $this->ContestUser->Contest->save($_Data);
                        $this->_updatecount($contestUserId, $ContestUser['ContestUser']['contest_id'], $ContestUser['ContestUser']['user_id']);
                    }
                    $this->Session->setFlash(__l('Checked entries has been deleted') , 'default', null, 'success');
                } else if ($actionid == ConstMoreAction::Completed) {
                    $contestIds = array();
                    foreach($contestUserIds as $contestUserId) {
                        $contest = $this->ContestUser->find('first', array(
                            'conditions' => array(
                                'ContestUser.id' => $contestUserId
                            ) ,
                            'fields' => array(
                                'ContestUser.contest_id'
                            ) ,
                            'recursive' => -1
                        ));
                        $contestIds[] = $contest['ContestUser']['contest_id'];
                    }
                    foreach($contestIds as $contest_id) {
                        $this->ContestUser->Contest->updateStatus(ConstContestStatus::Completed, $contest_id);
                    }
                    $this->Session->setFlash(__l('Checked entries contest has marked as complete') , 'default', null, 'success');
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function entry_chart()
    {
        $conditions = array();
        if (empty($this->request->params['named']['is_admin'])) {
            $conditions['ContestUser.user_id'] = $this->Auth->user('id');
        }
		$plugin_conditions  = array();
		if (isPluginEnabled('VideoResources')) {
            $plugin_conditions['OR']['Contest.resource_id'][] =  ConstResourceId::Video;
        }
        if (isPluginEnabled('AudioResources')) {
			$plugin_conditions['OR']['Contest.resource_id'][] = ConstResourceId::Audio;
		}
		if (isPluginEnabled('TextResources')) {
			$plugin_conditions['OR']['Contest.resource_id'][] = ConstResourceId::Text;
		}
		if (isPluginEnabled('ImageResources')) {
			$plugin_conditions['OR']['Contest.resource_id'][] = ConstResourceId::Image;
		}
		$conditions = array_merge($conditions, $plugin_conditions);
        $all_entry_count = $this->ContestUser->find('count', array(
            'conditions' => $conditions,
            'recursive' => 0
        ));
		$flagged_count_conditions = array(
                'ContestUser.is_system_flagged' => 1,
            );
		$flagged_count_conditions = array_merge($flagged_count_conditions, $plugin_conditions);
        $this->set('flagged_count', $this->ContestUser->find('count', array(
            'conditions' => $flagged_count_conditions ,
            'recursive' => 0
        )));
		$suspended_count_conditions = array(
                'ContestUser.admin_suspend' => 1,
        );
		$suspended_count_conditions = array_merge($suspended_count_conditions, $plugin_conditions);
        $this->set('suspended_count', $this->ContestUser->find('count', array(
            'conditions' => $suspended_count_conditions ,
            'recursive' => 0
        )));
        $this->set('all_entry_count', $all_entry_count);
        $contest_user_statuses = $this->ContestUser->ContestUserStatus->find('all', array(
            'fields' => array(
                'ContestUserStatus.id',
                'ContestUserStatus.name',
                'ContestUserStatus.slug'
            ) ,
            'recursive' => -1
        ));
        foreach($contest_user_statuses as $key => $contest_status) {
            $count = 0;
            if ($key == ConstContestUserStatus::Won-1) {
                $conditions['Contest.contest_status_id'] = array(
                    ConstContestStatus::WinnerSelected,
                    ConstContestStatus::WinnerSelectedByAdmin
                );
                $conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
            } else {
                $conditions['ContestUser.contest_user_status_id'] = $contest_status['ContestUserStatus']['id'];
                unset($conditions['Contest.contest_status_id']);
            }
            // quick fix for plugin issue
            $count = $this->ContestUser->find('count', array(
                'conditions' => $conditions,
                'contain' => array(
                    'Contest'
                ) ,
                'recursive' => 1
            ));
            $contest_user_statuses[$key]['contest_count'] = $count;
        }
        $this->set('contest_user_statuses', $contest_user_statuses);
        $development_conditions = array();
        if (empty($this->request->params['named']['is_admin'])) {
            $development_conditions['Contest.winner_user_id'] = $this->Auth->user('id');
        }
        $development_conditions['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
        $development_conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeRequested;
		$development_conditions = array_merge($development_conditions, $plugin_conditions);
        $this->set('change_requested_count', $this->ContestUser->find('count', array(
            'conditions' => $development_conditions,
            'recursive' => 0
        )));
        $development_conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeCompleted;
		
        $this->set('change_completed_count', $this->ContestUser->find('count', array(
            'conditions' => $development_conditions,
            'recursive' => 0
        )));
        $development_conditions['Contest.contest_status_id'] = ConstContestStatus::FilesExpectation;
        $this->set('files_expectation_count', $this->ContestUser->find('count', array(
            'conditions' => $development_conditions,
            'recursive' => 0
        )));
        $development_conditions['Contest.contest_status_id'] = ConstContestStatus::Completed;
        $this->set('completed_count', $this->ContestUser->find('count', array(
            'conditions' => $development_conditions,
            'recursive' => 0
        )));
        $development_conditions['Contest.contest_status_id'] = ConstContestStatus::PaidToParticipant;
        $this->set('close_count', $this->ContestUser->find('count', array(
            'conditions' => $development_conditions,
            'recursive' => 0
        )));
    }
    public function update_view_count()
    {
        if (!empty($this->request->data['ids'])) {
            $ids = explode(',', $this->request->data['ids']);
            $contestUsers = $this->ContestUser->find('all', array(
                'conditions' => array(
                    'ContestUser.id' => $ids
                ) ,
                'fields' => array(
                    'ContestUser.id',
                    'ContestUser.contest_user_view_count'
                ) ,
                'recursive' => -1
            ));
            foreach($contestUsers as $contestUser) {
                $json_arr[$contestUser['ContestUser']['id']] = $contestUser['ContestUser']['contest_user_view_count'];
            }
            $this->viewClass = 'Json';
            $this->set('json', $json_arr);
        }
    }
    private function update_maxumum_entry_no($contest_id, $contest_user_id)
    {
        $entry_no = $this->ContestUser->updateMaxumumEntryNo($contest_id, $contest_user_id);
        return $entry_no;
    }
}
