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
class ContestsController extends AppController
{
    public $name = 'Contests';
    public $helpers = array(
        'Contests.Cakeform'
    );
    public $files = array();
    public $permanentCacheAction = array(
        'public' => array(
            'index',
            'browse',
        ) ,
        'user' => array(
            'request_refund',
            'contest_chart',
            'user_dashboard',
        ) ,
        'admin' => array(
            'add',
            'edit',
            'prizing_selection',
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
            'Form',
            'ContestPackage',
            'Payment.connect',
            'Payment.wallet',
            'Payment.standard_connect',
            'Contest.normal',
            'Contest.payment_type',
            'Contest.payment_gateway_id',
            'Contest.pricing_day_id',
            'Contest.prize',
            'Contest.total_with_out_days',
            'Contest.pricing_package_id',
            'Contest.days_complete',
            'Contest.id',
            'Contest.other_fee',
            'Contest.gateway_method_id',
            'Contest.sudopay_gateway_id',
            'Contest.blind_fee.is_checked',
            'Contest.private_fee.is_checked',
            'Contest.wallet',
            'Contest.normal',
            'Sudopay'
        );
        parent::beforeFilter();
    }
    public function browse()
    {
        $this->pageTitle = __l('Browse Contests');
    }
    public function accept_as_completed($contest_id)
    {
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $contest_id,
            ) ,
            'contain' => array(
                'EntryAttachment'
            ) ,
            'recursive' => 2
        ));
        if (empty($contest)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        $dir_path = APP . "media" . DS . $contest['EntryAttachment']['dir'];
		$file_path = $dir_path . DS . $contest['EntryAttachment']['filename'];
        $new_path = APP . "media" . DS . $contest['EntryAttachment']['dir'];
        $zip = new ZipArchive;
		$is_zip_file = false;
        if ($zip->open($file_path) === TRUE) {
            $zip->extractTo($dir_path . DS . $contest['Contest']['id']);
            $zip->close();
			$dir_path .= $dir_path . DS . $contest['Contest']['id'];
			$is_zip_file = true;
        } else {
            $error = 1;
        }
		$files = $this->_traverse_directory($dir_path, 0, 0);
		if($is_zip_file){
			$this->_traverse_directory($dir_path, 0, 1);
		}
        $this->set(compact('files', 'dir_path', 'contest'));
        $this->pageTitle = __l('Accept as Completed');
    }
    public function _traverse_directory($dir, $dir_count, $is_delete = 0)
    {
        if (file_exists($dir)) {
            $handle = opendir($dir);
            $i = 0;
            while (false !== ($readdir = readdir($handle))) {
                if ($readdir != '.' && $readdir != '..') {
                    $path = $dir . '/' . $readdir;
                    if (is_dir($path)) {
                        @chmod($path, 0777);
                        ++$dir_count;
                        $this->_traverse_directory($path, $dir_count, $is_delete);
                    }
                    if (is_file($path)) {
                        @chmod($path, 0777);
                        if (empty($is_delete)) {
                            $this->files[$i]['name'] = basename($path);
                            $this->files[$i]['size'] = filesize($path);
                        } else {
                            @unlink($path);
                        }
                        flush();
                    }
                    $i++;
                }
            }
            closedir($handle);
            if (empty($is_delete)) {
                return $this->files;
            } else {
                @rmdir($dir);
                return false;
            }
        }
    }
    public function index()
    {
        $conditions = array();
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'mycontest') and (!$this->Auth->user('id'))) {
            $this->Session->setFlash(__l('Authorization Required'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login',
                '?f=contests/index/type:mycontest/filter_id:' . ConstContestStatus::Open
            ));
        }
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->Contest->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['user']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username',
                ) ,
                'recursive' => -1
            ));
            if (!empty($user['User']['id'])) {
                $conditions['Contest.user_id'] = $user['User']['id'];
            } else {
                $conditions['Contest.user_id !='] = '';
            }
        }
        $conditions['Contest.contest_status_id'] = array(
            ConstContestStatus::Open,
            ConstContestStatus::Judging,
            ConstContestStatus::WinnerSelected,
            ConstContestStatus::Completed,
        );
        $conditions['Contest.admin_suspend'] = 0;
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'mycontest' || $this->request->params['named']['type'] == 'my-contests')) {
            if ($this->request->params['named']['type'] == 'mycontest') {
                unset($conditions['Contest.admin_suspend']);
            }
            if (isset($this->request->params['named']['user_id'])) {
                $conditions['Contest.user_id'] = $this->request->params['named']['user_id'];
                unset($conditions['Contest.contest_status_id']);
                $conditions['Contest.contest_status_id'] = array(
                    ConstContestStatus::Open,
                    ConstContestStatus::Judging,
                    ConstContestStatus::WinnerSelected,
                    ConstContestStatus::WinnerSelectedByAdmin,
                    ConstContestStatus::ChangeRequested,
                    ConstContestStatus::ChangeCompleted,
                    ConstContestStatus::Completed,
                    ConstContestStatus::PaidToParticipant,
                );
            } else {
                unset($conditions['Contest.contest_status_id']);
                $conditions['Contest.user_id'] = $this->Auth->user('id');
            }
            $this->pageTitle = __l('My Contests');
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'is_featured')) {
            $conditions['Contest.is_featured'] = 1;
            $conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
            $this->pageTitle = __l('Featured Contests');
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'follower')) {
            if (isset($this->request->params['named']['user_id'])) {
                $user_id = $this->request->params['named']['user_id'];
            } else {
                if (!$this->Auth->user('id')) {
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                } else {
                    $user_id = $this->Auth->user('id');
                }
            }
            unset($conditions['Contest.contest_status_id']);
            $conditions['Contest.contest_status_id'] = array(
                ConstContestStatus::Open,
                ConstContestStatus::Judging,
                ConstContestStatus::WinnerSelected,
                ConstContestStatus::WinnerSelectedByAdmin,
                ConstContestStatus::ChangeRequested,
                ConstContestStatus::ChangeCompleted,
                ConstContestStatus::Completed,
                ConstContestStatus::PaidToParticipant,
            );
            if (isPluginEnabled('EntryRatings')) {
                $followings = $this->Contest->ContestFollower->find('all', array(
                    'conditions' => array(
                        'ContestFollower.user_id' => $user_id
                    ) ,
                    'fields' => array(
                        'ContestFollower.contest_id',
                    ) ,
                    'recursive' => -1
                ));
                $contest_ids = array();
                foreach($followings as $following) {
                    array_push($contest_ids, $following['ContestFollower']['contest_id']);
                }
                $contest_ids = array_unique($contest_ids);
                $conditions['Contest.id'] = $contest_ids;
                $this->pageTitle = __l('Followed Contests');
            }
        }
        if (isset($this->params['named']['filter_id'])) {
            $this->request->data['Contest']['filter_id'] = $this->params['named']['filter_id'];
        }
        if (isset($this->request->params['named']['contest_type_id'])) {
            $contest_type = $this->Contest->ContestType->find('first', array(
                'fields' => array(
                    'ContestType.name'
                ) ,
                'conditions' => array(
                    'ContestType.id' => $this->request->params['named']['contest_type_id'],
                    'ContestType.is_active' => 1
                )
            ));
            if (is_null($contest_type)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $this->set('contest_type', $contest_type);
            $conditions['Contest.contest_type_id'] = $this->request->params['named']['contest_type_id'];
        }
        $contain_condition_array = array();
        if (!empty($this->request->params['named']['status'])) {
            switch ($this->request->params['named']['status']) {
                case 'open':
                    unset($conditions['Contest.contest_status_id']);
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
                    break;

                case 'inprocess':
                    unset($conditions['Contest.contest_status_id']);
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::Judging,
                        ConstContestStatus::WinnerSelected,
                        ConstContestStatus::WinnerSelectedByAdmin,
                        ConstContestStatus::ChangeRequested,
                        ConstContestStatus::ChangeCompleted
                    );
                    break;

                case 'closed':
                    unset($conditions['Contest.contest_status_id']);
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::Completed,
                        ConstContestStatus::PaidToParticipant
                    );
                    break;

                case 'all':
                    unset($conditions['Contest.contest_status_id']);
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::Judging,
                        ConstContestStatus::WinnerSelected,
                        ConstContestStatus::WinnerSelectedByAdmin,
                        ConstContestStatus::ChangeRequested,
                        ConstContestStatus::ChangeCompleted,
                        ConstContestStatus::Completed,
                        ConstContestStatus::PaidToParticipant,
                        ConstContestStatus::Open,
                    );
                    break;
            }
        }
        if (!empty($this->request->data['Contest']['filter_id'])) {
            switch ($this->request->data['Contest']['filter_id']) {
                case ConstContestStatus::PaymentPending:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PaymentPending;
                    $this->pageTitle.= __l(' - Payment Pending ');
                    break;

                case ConstContestStatus::PendingApproval:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PendingApproval;
                    $this->pageTitle.= __l(' - Pending Approval ');
                    break;

                case ConstContestStatus::Open:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
                    $this->pageTitle.= __l(' - Open ');
                    break;

                case ConstContestStatus::Rejected:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Rejected;
                    $this->pageTitle.= __l(' - Rejected');
                    break;

                case ConstContestStatus::RefundRequest:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::RefundRequest;
                    $this->pageTitle.= __l(' - Request For Cancellation');
                    break;

                case ConstContestStatus::CanceledByAdmin:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::CanceledByAdmin;
                    $this->pageTitle.= __l(' - Canceled By Admin ');
                    break;

                case ConstContestStatus::Judging:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Judging;
                    $this->pageTitle.= __l(' - Judging ');
                    break;

                case ConstContestStatus::WinnerSelected:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::WinnerSelected;
                    $contain_condition_array['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Winner Selected');
                    break;

                case ConstContestStatus::WinnerSelectedByAdmin:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::WinnerSelectedByAdmin;
                    $contain_condition_array['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Winner Selected By Admin ');
                    break;

                case ConstContestStatus::ChangeRequested:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeRequested;
                    $contain_condition_array['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Change Requested ');
                    break;

                case ConstContestStatus::ChangeCompleted:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeCompleted;
                    $contain_condition_array['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Change Completed ');
                    break;

                case ConstContestStatus::Completed:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Completed;
                    $contain_condition_array['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= __l(' - Completed');
                    break;

                case ConstContestStatus::PaidToParticipant:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PaidToParticipant;
                    $contain_condition_array['ContestUser.contest_user_status_id'] = ConstContestUserStatus::Won;
                    $this->pageTitle.= sprintf(__l(' - Paid To %s') , Configure::read('contest.participant_alt_name_singular_caps'));
                    break;

                case 'entry':
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::PaymentPending,
                        ConstContestStatus::Rejected,
                        ConstContestStatus::PendingApproval,
                        ConstContestStatus::CanceledByAdmin,
                        ConstContestStatus::RefundRequest,
                        ConstContestStatus::Open,
                    );
                    $this->pageTitle.= __l(' - Entry');
                    break;

                case 'development':
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::Judging,
                        ConstContestStatus::ChangeRequested,
                        ConstContestStatus::WinnerSelected,
                        ConstContestStatus::WinnerSelectedByAdmin,
                        ConstContestStatus::ChangeCompleted,
                        ConstContestStatus::Completed,
                        ConstContestStatus::PaidToParticipant,
                    );
                    $this->pageTitle.= __l(' - Development');
                    break;

                case ConstContestStatus::FilesExpectation:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::FilesExpectation;
                    $this->pageTitle.= __l(' - Expecting Deliverables');
                    break;
            }
        }
        if (!empty($this->request->params['named']['is_pending_action_to_admin'])) {
            $conditions['Contest.is_pending_action_to_admin'] = 1;
            $this->pageTitle.= __l(' - Pending Action to Admin');
        }
        $contain = array();
        $limit = '';
        if (!$this->RequestHandler->prefers('json')) {
            $limit = 1;
        }
        $contain = array(
            'ContestType' => array(
                'Resource',
                'Attachment',
            ) ,
            'PricingPackage',
            'ContestStatus',
            'User',
            'ContestUser' => array(
                'conditions' => $contain_condition_array,
                'Attachment',
                'User',
                'fields' => array(
                    'ContestUser.id',
                    'ContestUser.created',
                    'ContestUser.entry_no',
                    'ContestUser.user_id',
                    'ContestUser.description',
                    'ContestUser.contest_user_status_id',
                    'ContestUser.contest_user_view_count',
                    'ContestUser.contest_user_total_ratings',
                    'ContestUser.contest_user_rating_count',
                    'ContestUser.average_rating',
                ) ,
                'order' => array(
                    'ContestUser.average_rating' => 'desc'
                ) ,
                'limit' => $limit,
            ) ,
            'EntryAttachment'
        );
        if (isPluginEnabled('EntryRatings')) {
            $contain['ContestUser'] = array_merge($contain['ContestUser'], array(
                'ContestUserRating'
            ));
        }
        if (isPluginEnabled('ContestFollowers')) {
            $ContestFollowers_contain = array(
                'ContestFollower'
            );
            $contain = array_merge($contain, $ContestFollowers_contain);
        }
        $order = array();
        if (!empty($thi->request->params['named']['type']) && $this->request->params['named']['type'] == 'mycontest') {
            $order['Contest.id'] = 'desc';
        } else {
            $order['Contest.is_featured'] = 'desc';
            $order['Contest.id'] = 'desc';
        }
        $resource_conditions = array();
        if (!isPluginEnabled('VideoResources')) {
            $resource_conditions['Not']['Contest.resource_id'][] = ConstResourceId::Video;
        }
        if (!isPluginEnabled('ImageResources')) {
            $resource_conditions['Not']['Contest.resource_id'][] = ConstResourceId::Image;
        }
        if (!isPluginEnabled('AudioResources')) {
            $resource_conditions['Not']['Contest.resource_id'][] = ConstResourceId::Audio;
        }
        if (!isPluginEnabled('TextResources')) {
            $resource_conditions['Not']['Contest.resource_id'][] = ConstResourceId::Text;
        }
        $conditions = $conditions+$resource_conditions;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => $order,
            'limit' => 10,
            'recursive' => 2,
        );
        $this->set('contests', $this->paginate());
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'mycontest') and ($this->Auth->user('id'))) {
            $this->render('mycontest');
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'is_featured')) {
            $this->render('contest-featured');
        }
        if (!empty($this->request->params['named']['type']) and ($this->request->params['named']['type'] == 'my-contests') and ($this->Auth->user('id'))) {
            $this->pageTitle = __l('Created Contests');
        }
        if ($this->RequestHandler->prefers('json')) {
            $contests = $this->paginate();
            $total_contests = count($contests);
            for ($i = 0; $i < $total_contests; $i++) {
                $contest_details[$i]['Contest_info']['id'] = $contests[$i]['Contest']['id'];
                $contest_details[$i]['Contest_info']['name'] = $contests[$i]['Contest']['name'];
                $contest_details[$i]['Contest_info']['is_private'] = $contests[$i]['Contest']['is_private'];
                $contest_details[$i]['Contest_info']['is_blind'] = $contests[$i]['Contest']['is_blind'];
                $contest_details[$i]['Contest_info']['is_featured'] = $contests[$i]['Contest']['is_featured'];
                $contest_details[$i]['Contest_info']['is_highlight'] = $contests[$i]['Contest']['is_highlight'];
                $contest_details[$i]['Contest_info']['contest_user_count'] = $contests[$i]['Contest']['contest_user_count'];
                $contest_details[$i]['Contest_info']['prize'] = $contests[$i]['Contest']['prize'];
                $contest_details[$i]['Contest_info']['ContestStatus']['id'] = $contests[$i]['ContestStatus']['id'];
                $contest_details[$i]['Contest_info']['ContestStatus']['name'] = $contests[$i]['ContestStatus']['name'];
                $contest_details[$i]['Contest_info']['ContestType']['name'] = $contests[$i]['ContestType']['name'];
                $contest_details[$i]['Contest_info']['contest_follower_count'] = $contests[$i]['Contest']['contest_follower_count'];
                $contest_details[$i]['Contest_info']['is_select_winner'] = !empty($contests[$i]['Contest']['winner_user_id']) ? True : False;
                if (!empty($contests[$i]['ContestFollower'])) {
                    if (isPluginEnabled('ContestFollowers') && ($this->Auth->user('id') != $contests[$i]['User']['id']) && !in_array($contests[$i]['Contest']['contest_status_id'], array(
                        ConstContestStatus::PaymentPending,
                        ConstContestStatus::PendingApproval,
                        ConstContestStatus::Rejected,
                        ConstContestStatus::CanceledByAdmin
                    ))) {
                        $contest_follower_array = array();
                        for ($k = 0; $k < count($contests[$i]['ContestFollower']); $k++) {
                            array_push($contest_follower_array, $contests[$i]['ContestFollower'][$k]['user_id']);
                        }
                        if (!in_array($this->Auth->user('id') , $contest_follower_array)) {
                            $follow_url = Router::url(array(
                                'controller' => 'contest_followers',
                                'action' => 'add',
                                $contests[$i]['Contest']['id'],
                                'ext' => 'json'
                            ) , true);
                            $contest_details[$i]['Contest_info']['follow_label'] = 'Follow';
                            $contest_details[$i]['Contest_info']['follow_url'] = $follow_url;
                        } else {
                            $unfollow_url = Router::url(array(
                                'controller' => 'contest_followers',
                                'action' => 'delete',
                                $contests[$i]['Contest']['slug'],
                                'ext' => 'json'
                            ) , true);
                            $contest_details[$i]['Contest_info']['follow_label'] = 'Unfollow';
                            $contest_details[$i]['Contest_info']['follow_url'] = $unfollow_url;
                        }
                    }
                }
                $contest_flag = 1;
                if (!empty($contests[$i]['Contest']['admin_suspend'])) {
                    $contest_flag = 0;
                }
                $contest_details[$i]['Contest_info']['ContestType']['name'] = $contests[$i]['ContestType']['name'];
                $contest_details[$i]['Contest_info']['contest_description'] = $contests[$i]['Contest']['description'];
                $contest_details[$i]['Contest_info']['discussion_count'] = $contests[$i]['Contest']['message_count'];
                $contest_type_image_options = array(
                    'dimension' => 'iphone_medium_thumb',
                    'class' => 'ContestType',
                    'alt' => $contests[$i]['Contest']['name'],
                    'title' => $contests[$i]['Contest']['name'],
                    'type' => 'jpg'
                );
                $contest_type_thumb = Router::url('/', true) . $this->Contest->getImageUrl('Contest', $contests[$i]['ContestType']['Attachment'], $contest_type_image_options);
                $contest_details[$i]['Contest_info']['contest_type_img_url'] = $contest_type_thumb;
                $contest_details[$i]['Contest_info']['start_date'] = date('M d, Y', strtotime($contests[$i]['Contest']['start_date']));
                $contest_details[$i]['Contest_info']['end_date'] = date('M d, Y', strtotime($contests[$i]['Contest']['end_date']));
                $contest_details[$i]['Contest_owner_info']['username'] = $contests[$i]['User']['username'];
                for ($j = 0; $j < count($contests[$i]['ContestUser']); $j++) {
                    $contest_details[$i]['Contest_entry_info'][$j]['username'] = $contests[$i]['ContestUser'][$j]['User']['username'];
                    $contest_details[$i]['Contest_entry_info'][$j]['entry_status_id'] = $contests[$i]['ContestUser'][$j]['contest_user_status_id'];
                    $contest_details[$i]['Contest_entry_info'][$j]['select_as_winner'] = array(
                        'url' => '',
                        'label' => 'Select As Winner!'
                    );
                    $contest_details[$i]['Contest_entry_info'][$j]['withdraw'] = array(
                        'url' => '',
                        'label' => 'Withdraw'
                    );
                    $contest_details[$i]['Contest_entry_info'][$j]['eliminate'] = array(
                        'url' => '',
                        'label' => 'Eliminate'
                    );
                    $contest_details[$i]['Contest_entry_info'][$j]['accept_mark_completed'] = array(
                        'url' => '',
                        'label' => 'Accept and Mark as Completed'
                    );
                    if (!empty($contests[$i]['ContestUser'][$j]['Attachment'][0])) {
                        $entry_image_options = array(
                            'dimension' => 'iphone_medium_thumb',
                            'class' => 'ContestType',
                            'alt' => $contests[$i]['ContestUser'][$j]['User']['username'],
                            'title' => $contests[$i]['ContestUser'][$j]['User']['username'],
                            'type' => 'jpg'
                        );
                        $contests[$i]['ContestUser'][$j]['ContestUser']['average_rating'] = 0;
                        if (isPluginEnabled('EntryRatings')) {
                            $avg_rating_percent = 0;
                            if ($contests[$i]['ContestUser'][$j]['contest_user_rating_count'] != 0 && $contests[$i]['ContestUser'][$j]['contest_user_total_ratings'] > 0) {
                                $avg_rating = $contests[$i]['ContestUser'][$j]['average_rating'];
                                $avg_rating_percent = (round($avg_rating, 2)) *20;
                            }
                            $contest_details[$i]['Contest_entry_info'][$j]['avg_rating'] = $avg_rating_percent;
                        }
                        $entry_thumb = Router::url('/', true) . $this->Contest->getImageUrl('ContestUser', $contests[$i]['ContestUser'][$j]['Attachment'][0], $contest_type_image_options);
                        $contest_details[$i]['Contest_entry_info'][$j]['entry_img_url'] = $entry_thumb;
                    }
                    if (!empty($contests[$i]['ContestUser'][$j]['contest_user_status_id']) && !empty($contest_flag)) {
                        if ($contests[$i]['ContestUser'][$j]['contest_user_status_id'] == ConstContestUserStatus::Active && ($contests[$i]['Contest']['contest_status_id'] == ConstContestStatus::Judging || $contests[$i]['Contest']['contest_status_id'] == ConstContestStatus::Open)) {
                            if (($contests[$i]['Contest']['user_id'] == $this->Auth->user('id') && ($contests[$i]['Contest']['contest_status_id'] == ConstContestStatus::Open || ($contests[$i]['Contest']['contest_status_id'] == ConstContestStatus::Judging && empty($contests[$i]['Contest']['is_pending_action_to_admin'])))) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
                                $select_as_winner_url = Router::url(array(
                                    'controller' => 'contest_users',
                                    'action' => 'update_status',
                                    'entry' => $contests[$i]['ContestUser'][$j]['id'],
                                    'status' => ConstContestUserStatus::Won,
                                    'plugin' => 'contests',
                                    'admin' => false,
                                    'ext' => 'json'
                                ) , true);
                                $contest_details[$i]['Contest_entry_info'][$j]['select_as_winner'] = array(
                                    'url' => $select_as_winner_url,
                                    'label' => 'Select As Winner!'
                                );
                            }
                        }
                        if ($contests[$i]['ContestUser'][$j]['contest_user_status_id'] == ConstContestUserStatus::Active) {
                            if ($contests[$i]['Contest']['contest_status_id'] == ConstContestStatus::Open) {
                                if (($contests[$i]['ContestUser'][$j]['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                                    $withdraw_url = Router::url(array(
                                        'controller' => 'contest_users',
                                        'action' => 'update_status',
                                        'entry' => $contests[$i]['ContestUser'][$j]['id'],
                                        'status' => ConstContestUserStatus::Withdrawn,
                                        'plugin' => 'contests',
                                        'admin' => false,
                                        'ext' => 'json'
                                    ) , true);
                                    $contest_details[$i]['Contest_entry_info'][$j]['withdraw'] = array(
                                        'url' => $withdraw_url,
                                        'label' => 'Withdraw'
                                    );
                                }
                                if (($contests[$i]['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                                    $eliminate_url = Router::url(array(
                                        'controller' => 'contest_users',
                                        'action' => 'update_status',
                                        'entry' => $contests[$i]['ContestUser'][$j]['id'],
                                        'status' => ConstContestUserStatus::Eliminated,
                                        'plugin' => 'contests',
                                        'admin' => false,
                                        'ext' => 'json'
                                    ) , true);
                                    $contest_details[$i]['Contest_entry_info'][$j]['eliminate'] = array(
                                        'url' => $eliminate_url,
                                        'label' => 'Eliminate'
                                    );
                                }
                            }
                        }
                        if ($contests[$i]['ContestUser'][$j]['contest_user_status_id'] == ConstContestUserStatus::Eliminated && empty($contests[$i]['Contest']['winner_user_id'])) {
                            if (($contests[$i]['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                                $cancel_eliminate_url = Router::url(array(
                                    'controller' => 'contest_users',
                                    'action' => 'update_status',
                                    'entry' => $contests[$i]['ContestUser'][$j]['id'],
                                    'status' => ConstContestUserStatus::Active,
                                    'plugin' => 'contests',
                                    'admin' => false,
                                    'ext' => 'json'
                                ) , true);
                                $contest_details[$i]['Contest_entry_info'][$j]['eliminate'] = array(
                                    'url' => $cancel_eliminate_url,
                                    'label' => 'Cancel Eliminate'
                                );
                            }
                        }
                        if ($contests[$i]['ContestUser'][$j]['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && empty($contests[$i]['Contest']['winner_user_id'])) {
                            if (($contests[$i]['ContestUser'][$j]['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
                                $cancel_withdrawn_url = Router::url(array(
                                    'controller' => 'contest_users',
                                    'action' => 'update_status',
                                    'entry' => $contests[$i]['ContestUser'][$j]['id'],
                                    'status' => ConstContestUserStatus::Active,
                                    'plugin' => 'contests',
                                    'admin' => false,
                                    'ext' => 'json'
                                ) , true);
                                $contest_details[$i]['Contest_entry_info'][$j]['withdraw'] = array(
                                    'url' => $cancel_withdrawn_url,
                                    'label' => 'Cancel Withdrawn'
                                );
                            }
                        }
                        if (in_array($contests[$i]['Contest']['contest_status_id'], array(
                            ConstContestStatus::WinnerSelected,
                            ConstContestStatus::ChangeCompleted
                        )) && empty($contests[$i]['Contest']['is_pending_action_to_admin']) && $contests[$i]['ContestUser'][$j]['contest_user_status_id'] == ConstContestUserStatus::Won) {
                            if (($contests[$i]['Contest']['user_id'] == $this->Auth->user('id') && empty($contests[$i]['Contest']['is_pending_action_to_admin'])) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
                                $accept_mark_completed_url = Router::url(array(
                                    'controller' => 'contests',
                                    'action' => 'update',
                                    'status_id' => ConstContestStatus::Completed,
                                    $contests[$i]['Contest']['id'],
                                    'ext' => 'json'
                                ) , true);
                                $contest_details[$i]['Contest_entry_info'][$j]['accept_mark_completed'] = array(
                                    'url' => $accept_mark_completed_url,
                                    'label' => 'Accept and Mark as Completed'
                                );
                            }
                        }
                    }
                }
            }
            if ($total_contests > 0) {
                $contest_details[0]['pagination'] = array(
                    "prev" => "",
                    "next" => ""
                );
                $total_contest = $this->Contest->find('count', array(
                    'conditions' => $conditions,
                    'recursive' => 2
                ));
                $total_page = ceil($total_contest/$this->paginate['limit']);
                $page = 1;
                if (!empty($this->request->params['named']['page'])) {
                    $page = $this->request->params['named']['page'];
                }
                if ($page != 1) {
                    $contest_details[0]['pagination']['prev'] = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'index',
                        'status' => $this->request->params['named']['status'],
                        'page' => $page-1,
                        'ext' => 'json'
                    ) , true);
                }
                if ($page < $total_page) {
                    $contest_details[0]['pagination']['next'] = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'index',
                        'status' => $this->request->params['named']['status'],
                        'page' => $page+1,
                        'ext' => 'json'
                    ) , true);
                }
            }
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $contest_details : $this->viewVars['iphone_response']);
        }
    }
    public function view($slug = null)
    {
        $this->pageTitle = __l('Contest');
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        $contain = array();
        $contain = array(
            'ContestType' => array(
                'FormField' => array(
                    'conditions' => array(
                        'FormField.is_active' => 1
                    ) ,
                    'order' => array(
                        'FormField.name' => 'asc'
                    )
                ) ,
            ) ,
            'User',
            'ContestStatus',
            'ContestUser' => array(
                'conditions' => array(
                    'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
                ) ,
                'User'
            ) ,
            'Submission' => array(
                'SubmissionField' => array(
                    'ContestCloneThumb',
                    'SubmissionThumb',
                    'order' => array(
                        'SubmissionField.form_field' => 'asc'
                    )
                )
            ) ,
            'PricingPackage' => array(
                'conditions' => array(
                    'PricingPackage.is_active' => 1
                ) ,
            ) ,
            'Message' => array(
                'conditions' => array(
                    'Message.is_sender' => 0,
                    'Message.contest_status_id' => 0
                )
            ) ,
            'WinnerUser',
            'EntryAttachment' => array(
                'fields' => array(
                    'EntryAttachment.id',
                    'EntryAttachment.dir',
                    'EntryAttachment.filename',
                    'EntryAttachment.width',
                    'EntryAttachment.height'
                )
            )
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
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.slug =' => $slug
            ) ,
            'contain' => $contain,
            'recursive' => 3
        ));
        $resources = $this->Contest->Resource->activeResources();
        if (!in_array($contest['Contest']['resource_id'], $resources)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
		
        if (!$this->Auth->user('id')) {
            if (!empty($contest['Contest']['is_private'])) {
                $this->Session->setFlash(__l('Authorization Required'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login',
                    '?f=contest/view/' . $contest['Contest']['slug']
                ));
            }
        }
        Configure::write('meta.view_image', 1);
        Configure::write('meta.title', $contest['Contest']['name']);
        if (empty($contest) || ((in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected)) || !empty($contest['Contest']['admin_suspend'])) && (!$this->Auth->user() || ($contest['Contest']['user_id'] != $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin)))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $submissionFieldLabel = array();
        $submissionFieldOption = array();
        $submissionFieldDisplay = array();
        if (!empty($contest['ContestType']['FormField'])) {
            foreach($contest['ContestType']['FormField'] as $key => $formField) {
                $submissionFieldLabel[$formField['name']] = $formField['label'];
                $submissionFieldOption[$formField['name']] = $formField['options'];
                $submissionFieldDisplay[$formField['name']] = (!empty($formField['display_text']) ? $formField['display_text'] : '');
            }
        }
        $this->set('submissionFieldLabel', $submissionFieldLabel);
        $this->set('submissionFieldOption', $submissionFieldOption);
        $this->set('submissionFieldDisplay', $submissionFieldDisplay);
        if (!empty($contest)) {
            $this->request->data['ContestView']['user_id'] = $this->Auth->user('id');
            $this->request->data['ContestView']['contest_id'] = $contest['Contest']['id'];
            $this->request->data['ContestView']['ip_id'] = $this->Contest->toSaveIp();
            $this->Contest->ContestView->create();
            $this->Contest->ContestView->save($this->request->data);
        }
        $condition = array(
            'ContestUser.contest_id' => $contest['Contest']['id'],
            'ContestUser.admin_suspend' => 0,
            'ContestUser.is_active' => 1,
        );
        $contest_entries = $this->Contest->ContestUser->find('count', array(
            'conditions' => $condition,
            'recursive' => 0
        ));
        $this->request->data['ContestComment']['contest_id'] = $contest['Contest']['id'];
        $this->pageTitle.= ' - ' . $contest['Contest']['name'];
        $this->set(compact('contest', 'contest_entries'));
        if (!empty($this->request->params['named']['view_type'])) {
            $this->render('simple-view');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'brief') {
            $this->render('view-brief');
        }
    }
    public function add()
    {
        $this->pageTitle = __l('Add Contest');
        if (isset($this->request->params['named']['type']) == 'preview') {
            $contest_type = $this->Contest->ContestType->find('first', array(
                'conditions' => array(
                    'ContestType.id' => $this->request->params['named']['contest_type_id']
                ) ,
                'recursive' => -1
            ));
            $this->pageTitle = __l('Contest Type') . ' - ' . __l('Preview') . ' - ' . $contest_type['ContestType']['name'];
        }
        if (isset($this->request->params['named']['type']) && $this->request->params['named']['type'] != 'preview') {
            throw new NotFoundException(__l('Invalid request'));
        }
        $is_submited = 0;
        $this->loadModel('Contests.Form');
        if (empty($this->request->params['named']['contest_type_id']) && empty($this->request->data['Contest']['contest_type_id'])) {
            throw new NotFoundException(__l('Invalid request'));
        } else {
            $contes_type_id = !(empty($this->request->params['named']['contest_type_id'])) ? $this->request->params['named']['contest_type_id'] : $this->request->data['Contest']['contest_type_id'];
            $contest_type = $this->Contest->ContestType->find('first', array(
                'conditions' => array(
                    'ContestType.id' => $contes_type_id,
                    'ContestType.is_active' => 1
                ) ,
                'recursive' => -1
            ));
            Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                '_trackEvent' => array(
                    'category' => 'Contest',
                    'action' => 'Contest' . $contest_type['ContestType']['resource_id'] . 'Posted',
                    'label' => 'Step1',
                    'value' => '',
                ) ,
                '_setCustomVar' => array(
                    'ctd' => $contes_type_id,
                    'ud' => $this->Auth->user('id') ,
                    'rud' => $this->Auth->user('referred_by_user_id') ,
                )
            ));
            if (empty($contest_type) and ($this->Auth->user('role_id') != ConstUserTypes::Admin)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if (!empty($this->request->params['named']['contest_type_id']) && (!empty($this->request->params['named']['type']) && ($this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin))) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->request->is('post')) {
            $is_submited = 1;
            $this->request->data['Contest']['user_id'] = $this->Auth->user('id');
            $this->request->data['Contest']['contest_status_id'] = ConstContestStatus::PaymentPending;
            $contestType = $this->Form->buildSchema($this->request->data['Contest']['contest_type_id']);
            if (empty($this->request->data['Form'])) {
                $this->request->data['Form'] = array();
            }
            $this->request->data['ValidateForm'] = $this->request->data['Form'];
            foreach($this->request->data['Form'] as $tmpFormField => $value) {
                $field_type = explode('_', $tmpFormField);
                if ($field_type[1] == 'date' || $field_type[1] == 'datetime' || $field_type[1] == 'time') {
                    if ($field_type[1] == 'date') {
                        $format = 'Y-m-d';
                    } elseif ($field_type[1] == 'datetime') {
                        $format = 'Y-m-d H:i:s';
                    } elseif ($field_type[1] == 'time') {
                        $format = 'H:i:s';
                    }
                    $this->request->data['ValidateForm'][$tmpFormField] = $this->Form->deconstructDate($value, $field_type[1], $format);
                }
            }
            $this->Contest->create();
            $this->Contest->set($this->request->data);
            $this->Form->set($this->request->data['ValidateForm']);
            if ($this->Contest->validates() &$this->Form->validates()) {
                if ($this->Contest->save($this->request->data)) {
                    //contest add mail send to admin
                    $contest = $this->Contest->find('first', array(
                        'conditions' => array(
                            'Contest.id = ' => $this->Contest->id
                        ) ,
                        'fields' => array(
                            'Contest.id',
                            'Contest.created',
                            'Contest.name',
                            'Contest.slug',
                            'Contest.contest_type_id',
                        ) ,
                        'contain' => array(
                            'User' => array(
                                'fields' => array(
                                    'User.id',
                                    'User.username',
                                )
                            ) ,
                        ) ,
                        'recursive' => 2
                    ));
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'Contest',
                            'action' => 'Contest' . $contest_type['ContestType']['resource_id'] . 'Posted',
                            'label' => 'Step2',
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'cd' => $contest['Contest']['id'],
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    $this->Contest->_sendAlertOnContestAdd($contest, 'New Contest');
                    $this->Contest->_sendAlertToParticipantsOnContestAdd($contest, 'New Contest For Participants');
                    $this->loadModel('Contests.Submission');
                    if (!empty($this->request->data['Form'])) {
                        $this->request->data['Submission'] = $this->request->data['Form'];
                        $this->request->data['Submission']['contest_id'] = $this->Contest->id;
                        $this->Submission->submit($this->request->data);
                    }
                    $this->Contest->ContestType->updateAll(array(
                        'ContestType.contest_count' => 'ContestType.contest_count +' . 1,
                    ) , array(
                        'ContestType.id' => $this->request->data['Contest']['contest_type_id']
                    ));
                    $this->Contest->Resource->updateAll(array(
                        'Resource.contest_count' => 'Resource.contest_count +' . 1,
                    ) , array(
                        'Resource.id' => $contest_type['ContestType']['resource_id']
                    ));
                    $this->redirect(array(
                        'action' => 'prizing_selection',
                        $this->Contest->id
                    ));
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Contest')) , 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Contest')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['Contest']['contest_type_id'] = (!empty($this->request->params['named']['contest_type_id']) ? $this->request->params['named']['contest_type_id'] : '');
        }
        $contestType = $this->Form->buildSchema($contes_type_id);
        $this->set('contestTypes', $contestType);
        $this->loadModel('Contests.FormFieldGroup');
        $FormFieldGroups = $this->FormFieldGroup->find('all', array(
            'conditions' => array(
                'FormFieldGroup.contest_type_id' => $contestType['ContestType']['id'],
            ) ,
            'contain' => array(
                'FormField' => array(
                    'conditions' => array(
                        'FormField.is_active' => 1,
                    ) ,
                    'order' => array(
                        'FormField.order' => 'ASC'
                    )
                ) ,
            ) ,
            'order' => array(
                'FormFieldGroup.order' => 'ASC'
            ) ,
            'recursive' => 2
        ));
        $this->set('FormFieldGroups', $FormFieldGroups);
        if (isset($this->request->params['named']['type']) == 'preview') {
            $this->loadModel('Contests.ContestTypesPricingPackage');
            $contestTypePricingPackage = $this->ContestTypesPricingPackage->find('first', array(
                'conditions' => array(
                    'ContestTypesPricingPackage.contest_type_id' => $this->request->params['named']['contest_type_id'],
                ) ,
                'recursive' => -1
            ));
            $contestType = $this->Contest->ContestType->find('first', array(
                'conditions' => array(
                    'ContestType.id' => $this->request->params['named']['contest_type_id']
                ) ,
                'contain' => array(
                    'PricingPackage' => array(
                        'conditions' => array(
                            'PricingPackage.is_active' => 1
                        ) ,
                    ) ,
                    'PricingDay' => array(
                        'conditions' => array(
                            'PricingDay.is_active' => 1
                        ) ,
                    )
                ) ,
                'recursive' => 4
            ));
            $this->set('contestType', $contestType);
            $this->render('admin_preview');
        }
    }
    public function prizing_selection($id = null)
    {
        $this->pageTitle = __l('Payment');
        if (!empty($this->request->data)) {
            $id = $this->request->data['Contest']['id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $id,
                'Contest.user_id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $contest_type = $this->Contest->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $contest['Contest']['contest_type_id']
            ) ,
            'recursive' => -1
        ));
        if (empty($contest)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'Contest',
                'action' => 'Contest' . $contest_type['ContestType']['resource_id'] . 'Posted',
                'label' => 'Step3',
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'cd' => $contest['Contest']['id'],
                'ud' => $this->Auth->user('id') ,
                'rud' => $this->Auth->user('referred_by_user_id') ,
            )
        ));
        if ($this->request->is('post') || $this->request->is('put')) {
            $this->request->data['Contest']['contest_type_id'] = $contest['Contest']['contest_type_id'];
            $contest_type = $this->Contest->ContestType->find('first', array(
                'conditions' => array(
                    'ContestType.id' => $contest['Contest']['contest_type_id']
                ) ,
                'recursive' => -1
            ));
            $this->request->data['Contest']['sudopay_gateway_id'] = 0;
            if ($this->request->data['Contest']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['Contest']['payment_gateway_id'], 'sp_') >= 0) {
                $PaymentGateway['PaymentGateway']['id'] = ConstPaymentGateways::SudoPay;
                $this->request->data['Contest']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['Contest']['payment_gateway_id']);
                $this->request->data['Contest']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
            }
            if (!empty($this->request->data['Contest']['blind_fee']['is_checked'])) {
                $this->request->data['Contest']['is_blind'] = 1;
                $this->request->data['Contest']['blind_contest_fee'] = $contest_type['ContestType']['blind_fee'];
            }
            if (!empty($this->request->data['Contest']['private_fee']['is_checked'])) {
                $this->request->data['Contest']['is_private'] = 1;
                $this->request->data['Contest']['private_contest_fee'] = $contest_type['ContestType']['private_fee'];
            }
            if (!empty($this->request->data['Contest']['featured_fee']['is_checked'])) {
                $this->request->data['Contest']['is_featured'] = 1;
                $this->request->data['Contest']['featured_contest_fee'] = $contest_type['ContestType']['featured_fee'];
            }
            if (!empty($this->request->data['Contest']['highlight_fee']['is_checked'])) {
                $this->request->data['Contest']['is_highlight'] = 1;
                $this->request->data['Contest']['highlight_contest_fee'] = $contest_type['ContestType']['highlight_fee'];
            }
            $min_prize = Configure::read('contest.contest_type_minimum_prize');
            if (!empty($contest_type)) {
                $min_prize = $contest_type['ContestType']['minimum_prize'];
            }
            $pricings = $this->Contest->calculateContestPrice($this->request->data);
            if ((isset($this->request->data['Contest']['days_complete']) && empty($this->request->data['Contest']['days_complete'])) || empty($this->request->data['Contest']['payment_gateway_id'])) {
                $this->Session->setFlash(__l('Please select the payment type and days to complete field') , 'default', null, 'error');
            } else {
                if (empty($this->request->data['Contest']['pricing_package_id']) && $pricings['prize'] < $min_prize) {
                    $this->Session->setFlash(__l('Contest prize should not be less than ') . Configure::read('site.currency') . $min_prize, 'default', null, 'error');
                    $this->Contest->validationErrors['prize'] = sprintf(__l('Contest prize should not be less than  %s%s ') , Configure::read('site.currency') , $min_prize);
                } else {
                    if (empty($this->request->data['Contest']['pricing_package_id'])) {
                        $this->request->data['Contest']['site_commision'] = (($pricings['prize']/100) *Configure::read('contest.winner_commission_amount'));
                    } else {
                        $this->loadModel('Contests.ContestTypesPricingPackage');
                        $contestTypePricingPackage = $this->ContestTypesPricingPackage->find('first', array(
                            'conditions' => array(
                                'ContestTypesPricingPackage.contest_type_id' => $this->request->data['Contest']['contest_type_id'],
                                'ContestTypesPricingPackage.pricing_package_id' => $this->request->data['Contest']['pricing_package_id'],
                            ) ,
                            'recursive' => -1
                        ));
                        $this->request->data['Contest']['site_commision'] = (($pricings['prize']/100) *$contestTypePricingPackage['ContestTypesPricingPackage']['participant_commision']);
                    }
                    $this->request->data['Contest']['prize'] = $pricings['prize'];
                    $this->request->data['Contest']['creation_cost'] = $pricings['creation_cost'];
                    if (!empty($this->request->data['Contest']['pricing_package_id'])) {
                        if (!empty($pricings['maximum_entry_allowed'])) {
                            $this->request->data['Contest']['maximum_entry_allowed'] = $pricings['maximum_entry_allowed'];
                        } else {
                            $this->request->data['Contest']['maximum_entry_allowed'] = $contest_type['ContestType']['maximum_entries_allowed'];
                        }
                        $this->request->data['Contest']['maximum_entry_allowed_per_user'] = $contest_type['ContestType']['maximum_entries_allowed_per_user'];
                    } else {
                        $this->request->data['Contest']['maximum_entry_allowed'] = $contest_type['ContestType']['maximum_entries_allowed'];
                        $this->request->data['Contest']['maximum_entry_allowed_per_user'] = $contest_type['ContestType']['maximum_entries_allowed_per_user'];
                    }
                    if ($this->Contest->save($this->request->data)) {
                        $contest = $this->Contest->find('first', array(
                            'conditions' => array(
                                'Contest.id = ' => $this->Contest->id,
                                'Contest.contest_status_id' => ConstContestStatus::PaymentPending,
                            ) ,
                            'contain' => array(
                                'ContestType',
                                'Resource'
                            ) ,
                            'recursive' => 0,
                        ));
                        if (empty($contest)) {
                            throw new NotFoundException(__l('Invalid request'));
                        }
                        $total_amount = $contest['Contest']['creation_cost'];
                        $total_amount = round($total_amount, 2);
                        if (!empty($this->request->data)) {
                            $is_error = 0;
                            if (!empty($this->request->data['Contest']['payment_gateway_id'])) {
                                $PaymentGateway = $this->Contest->PaymentGateway->find('first', array(
                                    'conditions' => array(
                                        'PaymentGateway.id' => $this->request->data['Contest']['payment_gateway_id']
                                    ) ,
                                    'recursive' => -1
                                ));
                                if (!empty($this->request->data['Contest']['payment_gateway_id']) && $this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                    if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
                                        $user = $this->Contest->User->find('first', array(
                                            'conditions' => array(
                                                'User.id' => $this->Auth->user('id')
                                            ) ,
                                            'fields' => array(
                                                'User.id',
                                                'User.username',
                                                'User.available_wallet_amount',
                                            ) ,
                                            'recursive' => -1
                                        ));
                                        if (empty($user)) {
                                            throw new NotFoundException(__l('Invalid request'));
                                        }
                                        if ($user['User']['available_wallet_amount'] < $contest['Contest']['creation_cost']) {
                                            $is_error = 1;
                                            $error_message = __l('Your wallet has insufficient money to add this contest');
                                            $this->Session->setFlash(__l('Your wallet has insufficient money to add this contest') , 'default', null, 'error');
                                        }
                                    }
                                }
                                if (!empty($is_error)) {
                                    $this->Session->setFlash($error_message, 'default', null, 'error');
                                } else {
                                    if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                        $contest_data['Contest']['is_paid'] = 1;
                                        $contest_data['Contest']['contest_status_id'] = ConstContestStatus::Open;
                                    }
                                    $contest_data['Contest']['id'] = $this->request->data['Contest']['id'];
                                    $contest_data['Contest']['payment_gateway_id'] = $this->request->data['Contest']['payment_gateway_id'];
                                    $this->Contest->save($contest_data);
                                    if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                                        $this->loadModel('Sudopay.Sudopay');
                                        $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                                        $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                                        if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                                            $sudopay_data = $this->Sudopay->getSudoPayPostData($this->request->data['Contest']['id'], ConstPaymentType::ContestPrize);
                                            $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                                            $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                                            $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                                            $sudopay_data['action'] = 'capture';
                                            $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sudopay_btn.js' . '\'';
                                            if (!empty($sudopay_gateway_settings['is_test_mode'])) {
                                                $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sandbox/sudopay_btn.js' . '\'';
                                            }
                                            $this->set('sudopay_data', $sudopay_data);
                                        } else if ($sudopay_gateway_settings['is_payment_via_api'] != ConstBrandType::VisibleBranding) {
                                            if (!empty($return['success']) || empty($is_error)) {
                                                $return = $this->Sudopay->processPayment($this->request->data['Contest']['id'], ConstPaymentType::ContestPrize, $this->request->data['Sudopay']);
                                                if (!empty($return['pending'])) {
                                                    $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
                                                } elseif (!empty($return['error'])) {
                                                    $this->Session->setFlash($return['error_message'] . '. ' . __l('Your payment could not be completed.') , 'default', null, 'error');
                                                } elseif (!empty($return['success'])) {
                                                    if (Configure::read('contest.is_auto_approve')) {
                                                        $this->Session->setFlash(__l('You have paid contest fee successfully. Now your contest has been opened') , 'default', null, 'success');
                                                        $this->Contest->updateStatus(ConstContestStatus::Open, $this->request->data['Contest']['id'], $this->request->data['Contest']['payment_gateway_id']);
                                                        if (isPluginEnabled('SocialMarketing')) {
                                                            $this->redirect(array(
                                                                'controller' => 'social_marketings',
                                                                'action' => 'publish',
                                                                $contest['Contest']['id'],
                                                                'publish_action' => 'add',
                                                                'type' => 'facebook'
                                                            ));
                                                        }
                                                    } else {
                                                        $this->Session->setFlash(__l('You have paid contest fee successfully. Your contest will be opened after admin approval') , 'default', null, 'success');
                                                        $this->Contest->updateStatus(ConstContestStatus::PendingApproval, $this->request->data['Contest']['id'], $this->request->data['Contest']['payment_gateway_id']);
                                                    }
                                                    $this->redirect(array(
                                                        'controller' => 'contests',
                                                        'action' => 'index',
                                                        'type' => 'mycontest',
                                                        'filter_id' => ConstContestStatus::Open
                                                    ));
                                                }
                                            } else {
                                                $this->redirect(array(
                                                    'controller' => 'contests',
                                                    'action' => 'index',
                                                    'type' => 'mycontest',
                                                    'filter_id' => ConstContestStatus::Open
                                                ));
                                            }
                                        }
                                    }
                                    if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                        $update_buyer_balance = $user['User']['available_wallet_amount']-$contest['Contest']['creation_cost'];
                                        $this->Contest->User->updateAll(array(
                                            'User.available_wallet_amount' => $update_buyer_balance
                                        ) , array(
                                            'User.id' => $this->Auth->user('id')
                                        ));
                                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                            '_trackEvent' => array(
                                                'category' => 'Contest',
                                                'action' => 'Contest' . $contest_type['ContestType']['resource_id'] . 'Posted',
                                                'label' => 'Step4',
                                                'value' => '',
                                            ) ,
                                            '_setCustomVar' => array(
                                                'cd' => $this->request->data['Contest']['id'],
                                                'ud' => $this->Auth->user('id') ,
                                                'rud' => $this->Auth->user('referred_by_user_id') ,
                                            )
                                        ));
                                        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEcommerce', $this, array(
                                            '_addTrans' => array(
                                                'order_id' => 'ContestListing-' . $contest['Contest']['id'],
                                                'name' => $contest['Contest']['name'],
                                                'total' => (!empty($contest['Contest']['fee_amount'])) ? $contest['Contest']['fee_amount'] : 0
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
                                        if (Configure::read('contest.is_auto_approve')) {
                                            $this->Session->setFlash(__l('You have paid contest fee successfully. Now your contest has been opened') , 'default', null, 'success');
                                            $this->Contest->updateStatus(ConstContestStatus::Open, $this->request->data['Contest']['id'], $this->request->data['Contest']['payment_gateway_id']);
                                            if (isPluginEnabled('SocialMarketing')) {
                                                $this->redirect(array(
                                                    'controller' => 'social_marketings',
                                                    'action' => 'publish',
                                                    $contest['Contest']['id'],
                                                    'publish_action' => 'add',
                                                    'type' => 'facebook'
                                                ));
                                            }
                                        } else {
                                            $this->Session->setFlash(__l('You have paid contest fee successfully. Your contest will be opened after admin approval') , 'default', null, 'success');
                                            $this->Contest->updateStatus(ConstContestStatus::PendingApproval, $this->request->data['Contest']['id'], $this->request->data['Contest']['payment_gateway_id']);
                                        }
                                        $this->redirect(array(
                                            'controller' => 'contests',
                                            'action' => 'index',
                                            'type' => 'mycontest',
                                            'filter_id' => ConstContestStatus::Open
                                        ));
                                    }
                                }
                            }
                        } else {
                            $this->request->data = $contest;
                        }
                        $this->set('total_amount', $total_amount);
                        $this->set('contest', $contest);
                        ///

                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Contest')) , 'default', null, 'error');
                    }
                }
            }
        } else {
            $this->request->data['Contest']['id'] = $id;
            $this->request->data['Contest']['other_fee'] = 0;
        }
        $contestType = $this->Contest->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $contest['Contest']['contest_type_id']
            ) ,
            'contain' => array(
                'PricingPackage' => array(
                    'conditions' => array(
                        'PricingPackage.is_active' => 1
                    ) ,
                ) ,
                'PricingDay' => array(
                    'conditions' => array(
                        'PricingDay.is_active' => 1
                    ) ,
                )
            ) ,
            'recursive' => 4
        ));
        $this->set(compact('contest', 'contestType'));
    }
    public function edit($id = null)
    {
        $this->pageTitle = __l('Edit Contest');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('Contests.Form');
        $this->Contest->id = $id;
        if (!$this->Contest->exists()) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $id,
            ) ,
            'recursive' => -1
        ));
        $contest_status_condition = array();
        if ($contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending || $contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval || $contest['Contest']['contest_status_id'] == ConstContestStatus::Rejected) {
            $contest_status_condition['ContestStatus.id'] = array(
                ConstContestStatus::PaymentPending,
                ConstContestStatus::PendingApproval,
                ConstContestStatus::Open,
                ConstContestStatus::Rejected,
            );
        } elseif ($contest['Contest']['contest_status_id'] == ConstContestStatus::Open && $contest['Contest']['contest_user_count'] == 0) {
            $contest_status_condition['ContestStatus.id'] = array(
                ConstContestStatus::PaymentPending,
                ConstContestStatus::PendingApproval,
                ConstContestStatus::Open,
                ConstContestStatus::Rejected,
                ConstContestStatus::RefundRequest,
                ConstContestStatus::CanceledByAdmin,
            );
        } elseif ($contest['Contest']['contest_status_id'] == ConstContestStatus::Open && $contest['Contest']['contest_user_count'] > 0) {
            $contest_status_condition['NOT']['ContestStatus.id'] = array(
                ConstContestStatus::PendingActionToAdmin,
            );
        } elseif ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging) {
            $contest_status_condition['NOT']['ContestStatus.id'] = array(
                ConstContestStatus::WinnerSelected,
                ConstContestStatus::WinnerSelectedByAdmin,
                ConstContestStatus::ChangeRequested,
                ConstContestStatus::ChangeCompleted,
                ConstContestStatus::Completed,
                ConstContestStatus::PaidToParticipant,
                ConstContestStatus::PendingActionToAdmin,
                ConstContestStatus::FilesExpectation,
            );
        }
        $contest_statuses = $this->Contest->ContestStatus->find('list', array(
            'conditions' => $contest_status_condition
        ));
        $this->set('contest_statuses', $contest_statuses);
        if ((empty($contest) && $this->Auth->user('role_id') != ConstUserTypes::Admin) || ($contest['Contest']['user_id'] != $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $contestType = $this->Form->buildSchema($this->request->data['Contest']['contest_type_id']);
            if (in_array($contest['Contest']['contest_status_id'], array(
                ConstContestStatus::PaymentPending,
                ConstContestStatus::PendingApproval,
                ConstContestStatus::Open
            ))) {
                $this->request->data['Contest']['actual_end_date'] = $this->request->data['Contest']['end_date'];
            }
            if (!empty($this->request->data['Contest']['is_featured']) && $this->request->data['Contest']['is_featured'] == 1) {
                @unlink(WWW_ROOT . 'index.html');
            }
            if (in_array($this->request->data['Contest']['contest_status_id'], array(
                ConstContestStatus::PaymentPending,
                ConstContestStatus::PendingApproval,
                ConstContestStatus::Rejected
            ))) {
                unset($this->Contest->validate['end_date']);
                unset($this->Contest->validate['actual_end_date']);
            }
            if ($this->Contest->save($this->request->data)) {
                $this->loadModel('Contests.Submission');
                if (!empty($this->request->data['Form'])) {
                    $this->request->data['Submission'] = $this->request->data['Form'];
                    $this->request->data['Submission']['contest_type_id'] = $this->request->data['Contest']['contest_type_id'];
                    $this->request->data['Submission']['contest_id'] = $this->request->data['Contest']['id'];
                    $this->request->data['Submission']['id'] = $this->request->data['Contest']['submission_id'];
                    $this->Submission->submit($this->request->data);
                }
                if (!empty($this->request->data['Contest']['existing_contest_status_id']) && ($this->request->data['Contest']['existing_contest_status_id'] != $this->request->data['Contest']['contest_status_id'])) {
                    $this->Contest->updateStatus($this->request->data['Contest']['contest_status_id'], $this->request->data['Contest']['id']);
                }
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Contest')) , 'default', null, 'success');
                $contest = $this->Contest->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $this->request->data['Contest']['id']
                    ) ,
                    'recursive' => -1
                ));
                if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                    $this->redirect(array(
                        'controller' => 'contests',
                        'action' => 'index',
                        'filter_id' => ConstContestStatus::PaymentPending,
                        'admin' => true
                    ));
                } else {
                    if ($contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending) {
                        $this->redirect(array(
                            'controller' => 'contests',
                            'action' => 'prizing_selection',
                            $this->request->data['Contest']['id']
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'contests',
                            'action' => 'index',
                            'type' => 'mycontest',
                            'filter_id' => $contest['Contest']['contest_status_id']
                        ));
                    }
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Contest')) , 'default', null, 'error');
            }
        } else {
            $contain = array(
                'ContestType',
                'User',
                'ContestStatus',
                'ContestUser' => array(
                    'User'
                ) ,
                'Submission' => array(
                    'SubmissionField'
                ) ,
                'PricingPackage' => array(
                    'conditions' => array(
                        'PricingPackage.is_active' => 1
                    ) ,
                ) ,
                'Message' => array(
                    'conditions' => array(
                        'Message.is_sender' => 0,
                        'Message.contest_status_id' => 0
                    )
                ) ,
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
            $this->request->data = $this->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id =' => $id
                ) ,
                'contain' => $contain,
                'recursive' => 2
            ));
        }
        $contest_media = array();
        if (!empty($this->request->data['Submission']['SubmissionField'])) {
            $SubmissionFields = $this->Contest->Submission->SubmissionField->find('all', array(
                'conditions' => array(
                    'SubmissionField.submission_id' => $this->request->data['Submission']['id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($SubmissionFields)) {
                foreach($SubmissionFields as $submissionValue) {
                    if ($submissionValue['SubmissionField']['type'] == 'checkbox' || $submissionValue['SubmissionField']['type'] == 'multiselect') {
                        $multi_selects = explode("\n", $submissionValue['response']);
                        foreach($multi_selects as $multi_select) {
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']][] = $multi_select;
                        }
                    } elseif ($submissionValue['SubmissionField']['type'] == 'date' || $submissionValue['SubmissionField']['type'] == 'datetime' || $submissionValue['SubmissionField']['type'] == 'time') {
                        $multi_selects = explode("\n", $submissionValue['SubmissionField']['response']);
                        if ($field_type[1] == 'date' || $field_type[1] == 'datetime') {
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['month'] = $multi_selects[0];
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['day'] = $multi_selects[1];
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['year'] = $multi_selects[2];
                        }
                        if ($field_type[1] == 'datetime') {
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['hour'] = $multi_selects[3];
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['min'] = $multi_selects[4];
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['meridian'] = $multi_selects[5];
                        }
                        if ($field_type[1] == 'time') {
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['hour'] = $multi_selects[0];
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['min'] = $multi_selects[1];
                            $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']]['meridian'] = $multi_selects[2];
                        }
                    } else {
                        $this->request->data['Form'][$submissionValue['SubmissionField']['form_field']] = $submissionValue['SubmissionField']['response'];
                    }
                    if (!empty($submissionValue['SubmissionThumb']['id'])) {
                        $contest_media[$submissionValue['SubmissionField']['form_field']]['Attachment'] = $submissionValue['SubmissionThumb'];
                    }
                }
            }
        }
        $this->set('contest_media', $contest_media);
        $this->request->data['Contest']['submission_id'] = $this->request->data['Submission']['id'];
        $contest_type_id = $this->request->data['Contest']['contest_type_id'];
        $this->pageTitle.= ' - ' . $this->data['Contest']['name'];
        $contestType = $this->Form->buildSchema($contest_type_id);
        $this->set('contestType', $contestType);
        $this->loadModel('Contests.FormFieldGroup');
        $form_field_groups_conditions = array(
            'FormFieldGroup.contest_type_id' => $contestType['ContestType']['id'],
        );
        $form_fields_conditions = array(
            'FormField.is_active' => 1,
        );
        $FormFieldGroups = $this->FormFieldGroup->find('all', array(
            'conditions' => $form_field_groups_conditions,
            'contain' => array(
                'FormField' => array(
                    'conditions' => $form_fields_conditions,
                    'order' => array(
                        'FormField.order' => 'ASC'
                    )
                ) ,
            ) ,
            'order' => array(
                'FormFieldGroup.order' => 'ASC'
            ) ,
            'recursive' => 2
        ));
        $this->set('FormFieldGroups', $FormFieldGroups);
    }
    public function delete_attachment($contest_id = null, $id = null, $field_id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($field_id)) {
            $this->loadModel('Contest.Submission');
            $this->Submission->SubmissionField->delete($field_id);
        }
        if ($this->Contest->Attachment->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Attachment')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'edit',
                $contest_id
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Contest->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Contest')) , 'default', null, 'success');
            if (empty($this->request->params['named']['type'])) {
                $this->redirect(array(
                    'action' => 'browse',
                ));
            } else {
                $this->redirect(array(
                    'action' => 'index',
                    'type' => $this->request->params['named']['type'],
                    'filter_id' => $this->request->params['named']['filter_id']
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q',
            'filter_id'
        ));
        $this->disableCache();
        $this->pageTitle = __l('Contests');
        $conditions = array();
        if (!empty($this->request->data['Contest']['user_id'])) {
            $this->request->params['named']['user_id'] = $this->request->data['Contest']['user_id'];
        }
        $param_string = "";
        $param_string.= !empty($this->request->params['named']['user_id']) ? '/user_id:' . $this->request->params['named']['user_id'] : $param_string;
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['Contest.user_id'] = $this->request->params['named']['user_id'];
            $this->request->data['Contest']['user_id'] = $this->request->params['named']['user_id'];
        }
        if (!empty($this->request->data['User']['username'])) {
            $get_user_id = $this->Contest->User->find('list', array(
                'conditions' => array(
                    'User.username' => $this->request->data['User']['username'],
                ) ,
                'fields' => array(
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_user_id)) {
                $conditions['Contest.user_id'] = $get_user_id;
            }
        }
        if (!empty($this->request->params['named']['stat'])) {
            if (!empty($this->request->params['named']['stat'])) {
                if ($this->request->params['named']['stat'] == 'day') {
                    $conditions['Contest.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
                    $conditions['Contest.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
                    $this->pageTitle = __l('Contests - Today');
                    $this->set('transaction_filter', __l('- Today'));
                    $days = 0;
                } else if ($this->request->params['named']['stat'] == 'week') {
                    $conditions['Contest.created <= '] = date('Y-m-d H:is', strtotime('now'));
                    $conditions['Contest.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
                    $this->pageTitle = __l('Contests - This Week');
                    $this->set('transaction_filter', __l('- This Week'));
                    $days = 7;
                } else if ($this->request->params['named']['stat'] == 'month') {
                    $conditions['Contest.created <= '] = date('Y-m-d H:is', strtotime('now'));
                    $conditions['Contest.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
                    $this->pageTitle = __l('Contests - This Month');
                    $this->set('transaction_filter', __l('- This Month'));
                    $days = 30;
                } else {
                    $this->pageTitle = __l('Contests - Total');
                    $this->set('transaction_filter', __l('- Total'));
                }
            }
        }
        if (isset($this->params['named']['filter_id'])) {
            $this->request->data['Contest']['filter_id'] = $this->params['named']['filter_id'];
        }
        if (!empty($this->request->data['Contest']['filter_id'])) {
            switch ($this->request->data['Contest']['filter_id']) {
                case ConstContestStatus::PaymentPending:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PaymentPending;
                    $this->pageTitle.= __l(' - Payment Pending ');
                    break;

                case ConstContestStatus::PendingApproval:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PendingApproval;
                    $this->pageTitle.= __l(' - Pending Approval ');
                    break;

                case ConstContestStatus::Open:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
                    $this->pageTitle.= __l(' - Open ');
                    break;

                case ConstContestStatus::FilesExpectation:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::FilesExpectation;
                    $this->pageTitle.= __l(' - Expecting Deliverables ');
                    break;

                case ConstContestStatus::Rejected:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Rejected;
                    $this->pageTitle.= __l(' - Rejected');
                    break;

                case ConstContestStatus::RefundRequest:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::RefundRequest;
                    $this->pageTitle.= __l(' - Request For Cancellation');
                    break;

                case ConstContestStatus::CanceledByAdmin:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::CanceledByAdmin;
                    $this->pageTitle.= __l(' - Canceled By Admin ');
                    break;

                case ConstContestStatus::Judging:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Judging;
                    $this->pageTitle.= __l(' - Judging ');
                    break;

                case ConstContestStatus::WinnerSelected:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::WinnerSelected;
                    $this->pageTitle.= __l(' - Winner Selected');
                    break;

                case ConstContestStatus::WinnerSelectedByAdmin:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::WinnerSelectedByAdmin;
                    $this->pageTitle.= __l(' - Winner Selected By Admin ');
                    break;

                case ConstContestStatus::ChangeRequested:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeRequested;
                    $this->pageTitle.= __l(' - Change Requested ');
                    break;

                case ConstContestStatus::ChangeCompleted:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::ChangeCompleted;
                    $this->pageTitle.= __l(' - Change Completed ');
                    break;

                case ConstContestStatus::Completed:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::Completed;
                    $this->pageTitle.= __l(' - Completed');
                    break;

                case ConstContestStatus::PaidToParticipant:
                    $conditions['Contest.contest_status_id'] = ConstContestStatus::PaidToParticipant;
                    $this->pageTitle.= sprintf(__l(' - Paid To %s') , Configure::read('contest.participant_alt_name_singular_caps'));
                    break;

                case 'entry':
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::PaymentPending,
                        ConstContestStatus::Rejected,
                        ConstContestStatus::PendingApproval,
                        ConstContestStatus::CanceledByAdmin,
                        ConstContestStatus::RefundRequest,
                        ConstContestStatus::Open,
                    );
                    $this->pageTitle.= __l(' - Entry');
                    break;

                case 'development':
                    $conditions['Contest.contest_status_id'] = array(
                        ConstContestStatus::Judging,
                        ConstContestStatus::ChangeRequested,
                        ConstContestStatus::WinnerSelected,
                        ConstContestStatus::WinnerSelectedByAdmin,
                        ConstContestStatus::ChangeCompleted,
                        ConstContestStatus::Completed,
                        ConstContestStatus::PaidToParticipant,
                    );
                    $this->pageTitle.= __l(' - Development');
                    break;
            }
        }
        if (!empty($this->request->params['named']['is_blind'])) {
            $conditions['Contest.is_blind'] = 1;
            $this->pageTitle.= __l(' - Blind Contest');
        }
        if (!empty($this->request->params['named']['is_featured'])) {
            $conditions['Contest.is_featured'] = 1;
            $this->pageTitle.= __l(' - Featured Contest');
        }
        if (!empty($this->request->params['named']['is_private'])) {
            $conditions['Contest.is_private'] = 1;
            $this->pageTitle.= __l(' - Private Contest');
        }
        if (!empty($this->request->params['named']['is_highlight'])) {
            $conditions['Contest.is_highlight'] = 1;
            $this->pageTitle.= __l(' - Highlight Contest');
        }
        if (!empty($this->request->params['named']['is_pending_action_to_admin'])) {
            $conditions['Contest.is_pending_action_to_admin'] = 1;
            $this->pageTitle.= __l(' - Pending Action to Admin');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'flagged') {
            $conditions['Contest.is_system_flagged'] = 1;
            $this->pageTitle.= __l(' - System Flagged');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') {
            $conditions['Contest.is_user_flagged'] = 1;
            $this->pageTitle.= __l(' - User Flagged');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'suspended') {
            $conditions['Contest.admin_suspend'] = 1;
            $this->pageTitle.= __l(' - Suspended');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'image') {
            $conditions['Contest.resource_id'] = ConstResource::Image;
            $this->pageTitle.= __l(' - Image Resource');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'video') {
            $conditions['Contest.resource_id'] = ConstResource::Video;
            $this->pageTitle.= __l(' - Video Resource');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'audio') {
            $conditions['Contest.resource_id'] = ConstResource::Audio;
            $this->pageTitle.= __l(' - Audio Resource');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'text') {
            $conditions['Contest.resource_id'] = ConstResource::Text;
            $this->pageTitle.= __l(' - Text Resource');
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
                )
            );
            $this->request->data['Contest']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $contain = array();
        $contain = array(
            'ContestType' => array(
                'fields' => array(
                    'ContestType.name',
                )
            ) ,
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
        );
        if (isPluginEnabled('ContestFlags')) {
            $ContestFlags_contain = array(
                'ContestFlag'
            );
            $contain = array_merge($contain, $ContestFlags_contain);
        }
        $sudopayPaymentGateway = array();
        if (isPluginEnabled('Sudopay')) {
            App::import('Model', 'Sudopay.SudopayPaymentGateway');
            $this->SudopayPaymentGateway = new SudopayPaymentGateway();
            $sudopayPaymentGateway = $this->SudopayPaymentGateway->find('list', array(
                'fields' => array(
                    'SudopayPaymentGateway.sudopay_gateway_id',
                    'SudopayPaymentGateway.days_after_amount_paid'
                ) ,
                'recursive' => -1
            ));
        }
        if (!isPluginEnabled('VideoResources')) {
            $conditions['Not']['Contest.resource_id'][] = ConstResourceId::Video;
        }
        if (!isPluginEnabled('ImageResources')) {
            $conditions['Not']['Contest.resource_id'][] = ConstResourceId::Image;
        }
        if (!isPluginEnabled('AudioResources')) {
            $conditions['Not']['Contest.resource_id'][] = ConstResourceId::Audio;
        }
        if (!isPluginEnabled('TextResources')) {
            $conditions['Not']['Contest.resource_id'][] = ConstResourceId::Text;
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'order' => array(
                'Contest.id' => 'desc'
            ) ,
            'limit' => 10,
            'recursive' => 2,
        );
        $this->Contest->validate = array();
        $this->Contest->User->validate = array();
        $filters = $this->Contest->isFilterOptions;
        $moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::PaymentPending) {
            $moreActions = array(
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::PendingApproval) {
            $moreActions = array(
                ConstMoreAction::Open => __l('Open') ,
                ConstMoreAction::Reject => __l('Reject') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::RefundRequest) {
            $moreActions = array(
                ConstMoreAction::Cancel => __l('Cancel') ,
                ConstMoreAction::RejectRequest => __l('Reject Request') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::Judging) {
            $moreActions = array(
                ConstMoreAction::Cancel => __l('Cancel') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::WinnerSelected) {
            $moreActions = array(
                ConstMoreAction::Completed => __l('Completed') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin) {
            $moreActions = array(
                ConstMoreAction::Completed => __l('Completed') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::ChangeRequested) {
            $moreActions = array(
                ConstMoreAction::Completed => __l('Completed') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::ChangeCompleted) {
            $moreActions = array(
                ConstMoreAction::Completed => __l('Completed') ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        if (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::Completed) {
            $moreActions = array(
                ConstMoreAction::PaidToParticipant => sprintf(__l('Pay to %s') , Configure::read('contest.participant_alt_name_singular_caps')) ,
                ConstMoreAction::Delete => __l('Delete') ,
            );
        }
        $resource_conditions = array();
        if (!isPluginEnabled('VideoResources')) {
            $resource_conditions['Contest.resource_id !='] = ConstResourceId::Video;
        }
        if (!isPluginEnabled('ImageResources')) {
            if (!empty($resource_conditions)) {
                $resource_conditions = array();
                $resource_conditions['NOT']['Contest.resource_id'] = array(
                    ConstResourceId::Image,
                    ConstResourceId::Video
                );
            } else {
                $resource_conditions['Contest.resource_id !='] = ConstResourceId::Image;
            }
        }
        $image_resource_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.resource_id' => ConstResourceId::Image,
            ) ,
            'recursive' => -1
        ));
        $video_resource_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.resource_id' => ConstResourceId::Video,
            ) ,
            'recursive' => -1
        ));
        $audio_resource_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.resource_id' => ConstResourceId::Audio,
            ) ,
            'recursive' => -1
        ));
        $text_resource_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.resource_id' => ConstResourceId::Text,
            ) ,
            'recursive' => -1
        ));
        $pennding_action_judging_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.contest_status_id' => ConstContestStatus::Judging,
                'Contest.is_pending_action_to_admin' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $pennding_action_winner_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.contest_status_id' => ConstContestStatus::WinnerSelected,
                'Contest.is_pending_action_to_admin' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $pennding_action_winner_selected_admin_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.contest_status_id' => ConstContestStatus::WinnerSelectedByAdmin,
                'Contest.is_pending_action_to_admin' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $pennding_action_change_completed_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.contest_status_id' => ConstContestStatus::ChangeCompleted,
                'Contest.is_pending_action_to_admin' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $pennding_action_all_completed_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_pending_action_to_admin' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $blind_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_blind' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $featured_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_featured' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $private_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_private' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $highlight_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_highlight' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $system_flagged_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_system_flagged' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $user_flagged_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_user_flagged' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $suspended_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.admin_suspend' => 1,
                $resource_conditions
            ) ,
            'recursive' => -1
        ));
        $this->set('image_resource_count', $image_resource_count);
        $this->set('video_resource_count', $video_resource_count);
        $this->set('audio_resource_count', $audio_resource_count);
        $this->set('text_resource_count', $text_resource_count);
        $this->set('pennding_action_judging_count', $pennding_action_judging_count);
        $this->set('pennding_action_winner_count', $pennding_action_winner_count);
        $this->set('pennding_action_winner_selected_admin_count', $pennding_action_winner_selected_admin_count);
        $this->set('pennding_action_change_completed_count', $pennding_action_change_completed_count);
        $this->set('pennding_action_all_completed_count', $pennding_action_all_completed_count);
        $contests = $this->paginate();
        $winnerUsers = array();
        foreach($contests as $contest) {
            if (!empty($contest['Contest']['winner_user_id'])) {
                $winnerUsers[$contest['Contest']['id']] = $this->Contest->User->find('first', array(
                    'conditions' => array(
                        'User.id' => $contest['Contest']['winner_user_id']
                    ) ,
                    'recursive' => -1
                ));
            }
        }
        if (!empty($winnerUsers)) {
            $this->set('winnerUsers', $winnerUsers);
        }
        $this->set(compact('filters', 'moreActions', 'blind_count', 'featured_count', 'private_count', 'highlight_count', 'system_flagged_count', 'user_flagged_count', 'suspended_count', 'sudopayPaymentGateway'));
        $this->set('contests', $this->paginate());
    }
    public function admin_cancel_contest($id = null)
    {
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $id
            ) ,
            'contain' => array(
                'ContestType' => array(
                    'PricingPackage' => array(
                        'conditions' => array(
                            'PricingPackage.is_active' => 1
                        ) ,
                    ) ,
                    'PricingDay' => array(
                        'conditions' => array(
                            'PricingDay.is_active' => 1
                        ) ,
                    )
                ) ,
            ) ,
            'recursive' => 2
        ));
        if (empty($contest) || ($contest['Contest']['contest_status_id'] != ConstContestStatus::Judging && $contest['Contest']['contest_status_id'] != ConstContestStatus::RefundRequest)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        $this->pageTitle = __l('Cancel Contest - ') . $contest['Contest']['name'];
        $this->set('contest', $contest);
    }
    public function admin_add()
    {
        $this->setAction('add');
    }
    public function admin_edit($id = null)
    {
        $this->setAction('edit', $id);
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->Contest->id = $id;
        if (!$this->Contest->exists()) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        $this->_updateCountInUser($id);
        if ($this->Contest->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Contest')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index',
                'filter_id' => ConstContestStatus::Open
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update_status($contest_id = null, $status_id = null)
    {
        if (!empty($this->request->params['named']['status'])) {
            if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'flag')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['is_system_flagged'] = 1;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been flagged') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'systemflag')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['is_system_flagged'] = 0;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been unflagged') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'featured')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['is_featured'] = 1;
                $this->Contest->save($_data);
                @unlink(WWW_ROOT . 'index.html');
                $this->Session->setFlash(__l($this->modelClass . ' has been featured') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'blind')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['is_blind'] = 1;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been blinded') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'private')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['is_private'] = 1;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been made as private') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'userflag')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['is_user_flagged'] = 0;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been unflagged') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'suspend')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['admin_suspend'] = 1;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been suspended') , 'default', null, 'success');
            } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'unsuspend')) {
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['admin_suspend'] = 0;
                $this->Contest->save($_data);
                $this->Session->setFlash(__l($this->modelClass . ' has been unsuspended') , 'default', null, 'success');
            }
            if (isset($_GET['r'])) {
                $this->redirect(Router::url('/', true) . $_GET['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index',
                    'filter_id' => ConstContestStatus::Open
                ));
            }
        } else {
            if (!empty($this->request->params['named']['type']) && $status_id == ConstContestStatus::Judging) {
                $contest = $this->Contest->find('first', array(
                    'conditions' => array(
                        'Contest.id' => $contest_id
                    ) ,
                    'contain' => array(
                        'User'
                    ) ,
                    'recursive' => 0
                ));
                $_data['Contest']['id'] = $contest_id;
                $_data['Contest']['contest_status_id'] = ConstContestStatus::Judging;
                $this->Contest->save($_data);
                $email_replace = array(
                    '##CONTEST_HOLDER##' => $contest['User']['username'],
                    '##CONTEST_NAME##' => $contest['Contest']['name'],
                );
                if ($this->Contest->_checkUserNotifications($contest['User']['id'], 'is_request_refund_reject_alert_to_contestholder')) {
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate('Request reject mail');
                    $this->Contest->_sendEmail($template, $email_replace, $contest['User']['email']);
                }
                $this->Contest->updateCountInUser($contest['Contest']['user_id'], ConstContestStatus::RefundRequest, ConstContestStatus::Judging);
            }
            $this->Contest->updateStatus($status_id, $contest_id);
            $this->Session->setFlash(__l('Contest status updated') , 'default', null, 'success');
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
    public function admin_update()
    {
        if (!empty($this->request->params['named']['user_id'])) {
            $payment_gateway_id = '';
            $this->Contest->ContestUser->_processEntry($this->request->params['named']['entry'], $this->request->params['named']['status']);
            $this->Session->setFlash(__l('Winner has been selected for the selected contest') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'index',
                'filter_id' => ConstContestStatus::WinnerSelectedByAdmin
            ));
        } else {
            if (!empty($this->request->data['Contest'])) {
                $r = $this->request->data[$this->modelClass]['r'];
                $actionid = $this->request->data[$this->modelClass]['more_action_id'];
                unset($this->request->data[$this->modelClass]['r']);
                unset($this->request->data[$this->modelClass]['more_action_id']);
                $contestIds = array();
                foreach($this->request->data['Contest'] as $contest_id => $is_checked) {
                    if ($is_checked['id']) {
                        $contestIds[] = $contest_id;
                    }
                }
                if ($actionid && !empty($contestIds)) {
                    if ($actionid == ConstMoreAction::Open) {
                        foreach($contestIds as $contest_id) {
                            $this->Contest->updateStatus(ConstContestStatus::Open, $contest_id);
                        }
                        $this->Session->setFlash(__l('Checked contest has been opened') , 'default', null, 'success');
                    }
                    if ($actionid == ConstMoreAction::Reject) {
                        foreach($contestIds as $contest_id) {
                            $this->Contest->updateStatus(ConstContestStatus::Rejected, $contest_id);
                        }
                        $this->Session->setFlash(__l('Checked contest has been reject') , 'default', null, 'success');
                    } else if ($actionid == ConstMoreAction::Completed) {
                        foreach($contestIds as $contest_id) {
                            $this->Contest->updateStatus(ConstContestStatus::Completed, $contest_id);
                        }
                        $this->Session->setFlash(__l('Checked contest has marked as complete') , 'default', null, 'success');
                    } else if ($actionid == ConstMoreAction::PaidToParticipant) {
                        foreach($contestIds as $contest_id) {
                            $this->Contest->updateStatus(ConstContestStatus::PaidToParticipant, $contest_id);
                        }
                        $this->Session->setFlash(__l('Amount paid for the participant') , 'default', null, 'success');
                    } else if ($actionid == ConstMoreAction::Cancel) {
                        foreach($contestIds as $contest_id) {
                            $this->Contest->updateStatus(ConstContestStatus::CanceledByAdmin, $contest_id);
                        }
                        $this->Session->setFlash(__l('Checked contest has been canceled') , 'default', null, 'success');
                    } else if ($actionid == ConstMoreAction::Delete) {
                        foreach($contestIds as $contest_id) {
                            $contest = $this->Contest->find('first', array(
                                'conditions' => array(
                                    'Contest.id' => $contest_id
                                ) ,
                                'fields' => array(
                                    'Contest.user_id',
                                    'Contest.contest_status_id',
                                ) ,
                                'recursive' => -1
                            ));
                            $this->Contest->delete($contest_id);
                            if (!empty($contest)) {
                                $this->Contest->updateCountInUser($contest['Contest']['user_id'], $contest['Contest']['contest_status_id']);
                            }
                        }
                        $this->Session->setFlash(__l('Checked contest has been deleted') , 'default', null, 'success');
                    } else if ($actionid == ConstMoreAction::RejectRequest) {
                        foreach($contestIds as $contest_id) {
                            $contest = $this->Contest->find('first', array(
                                'conditions' => array(
                                    'Contest.id' => $contest_id
                                ) ,
                                'contain' => array(
                                    'User'
                                ) ,
                                'recursive' => 0
                            ));
                            $_data['Contest']['id'] = $contest_id;
                            $_data['Contest']['contest_status_id'] = ConstContestStatus::Judging;
                            $this->Contest->save($_data);
                            $email_replace = array(
                                '##CONTEST_HOLDER##' => $contest['User']['username'],
                                '##CONTEST_NAME##' => $contest['Contest']['name'],
                            );
                            if ($this->Contest->_checkUserNotifications($contest['User']['id'], 'is_request_refund_reject_alert_to_contestholder')) {
                                App::import('Model', 'EmailTemplate');
                                $this->EmailTemplate = new EmailTemplate();
                                $template = $this->EmailTemplate->selectTemplate('Request reject mail');
                                $this->Contest->_sendEmail($template, $email_replace, $contest['User']['email']);
                            }
                            $this->Contest->updateCountInUser($contest['Contest']['user_id'], ConstContestStatus::RefundRequest, ConstContestStatus::Judging);
                            $this->Contest->updateStatus(ConstContestStatus::Judging, $contest_id);
                        }
                        $this->Session->setFlash(__l('Contest status updated') , 'default', null, 'success');
                    }
                }
            }
            $this->redirect(Router::url('/', true) . $r);
        }
    }
    public function request_refund($id = null)
    {
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $id
            ) ,
            'recursive' => -1
        ));
        $contest_flag = 0;
        if (Configure::read('contest.enable_request_for_cancellation') && $contest['Contest']['contest_status_id'] == ConstContestStatus::Judging && (Configure::read('ContestUser.request_refund_entry_limit') === '' || $contest['Contest']['partcipant_count'] <= Configure::read('ContestUser.request_refund_entry_limit') || $contest['Contest']['contest_user_count'] <= Configure::read('ContestUser.request_refund_entry_limit')) && empty($contest['Contest']['admin_suspend']) && empty($contest['Contest']['reason_for_cancelation']) && !empty($contest)) {
            $contest_flag = 1;
        }
        if (empty($contest_flag) || is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            $this->Contest->set($this->request->data);
            if ($this->Contest->validates()) {
                $this->Contest->save($this->request->data);
                $this->Contest->updateStatus(ConstContestStatus::RefundRequest, $this->request->data['Contest']['id']);
                $this->Session->setFlash(__l('Your request for cancellation added successfully and the amount will be refunded after admin approval.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'contests',
                    'action' => 'index',
                    'type' => 'mycontest',
                    'filter_id' => ConstContestStatus::RefundRequest
                ));
            } else {
                $this->Session->setFlash(__l('Your request cannot be add. Please specify the reason for cancelation.') , 'default', null, 'error');
            }
        } else {
            $contest = $this->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $id
                ) ,
                'fields' => array(
                    'Contest.name'
                ) ,
                'recursive' => -1
            ));
            $this->pageTitle = __l('Refund Request') . ' - ' . $contest['Contest']['name'];
            $this->request->data['Contest']['id'] = $id;
        }
    }
    public function update($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $conditions['Contest.id'] = $id;
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            if (!empty($this->request->params['named']['status_id']) and $this->request->params['named']['status_id'] == ConstContestStatus::ChangeCompleted) {
                $conditions['Contest.winner_user_id'] = $this->Auth->user('id');
            } else {
                $conditions['Contest.user_id'] = $this->Auth->user('id');
            }
        }
        $contest = $this->Contest->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'EntryAttachment',
            ) ,
            'recursive' => 0
        ));
        if (!empty($this->request->params['named']['status_id']) and !empty($contest)) {
            if ($this->request->params['named']['status_id'] == ConstContestStatus::FilesExpectation) {
                $this->Session->setFlash(__l('Contest moved to expecting deliverables') , 'default', null, 'success');
            } else if ($this->request->params['named']['status_id'] == ConstContestStatus::Completed) {
                $this->Session->setFlash(__l('Contest moved to completed') , 'default', null, 'success');
            }
            $this->Contest->updateStatus($this->request->params['named']['status_id'], $contest['Contest']['id']);
            if (!empty($this->request->params['named']['status_id']) and $this->request->params['named']['status_id'] == ConstContestStatus::Completed) {
                $this->redirect(array(
                    'controller' => 'contests',
                    'action' => 'download_entry',
                    $contest['Contest']['id'],
                    $contest['EntryAttachment']['id']
                ));
            }
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'view',
                $contest['Contest']['slug']
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function user_dashboard()
    {
        App::import('Model', 'User');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'contain' => array(
                'Contest' => array(
                    'ContestUser'
                ) ,
            ) ,
            'recursive' => 3
        ));
        $this->pageTitle = __l('Dashboard');
        //for dashoard table
        $user_id = $this->Auth->user('id');
        if (!empty($user_id)) {
            $periods = array(
                'day' => array(
                    'display' => __l('Today') ,
                    'conditions' => array(
                        'created >= ' => date('Y-m-d 00:00:00', strtotime('now')) ,
                        'created <= ' => date('Y-m-d 23:59:59', strtotime('now')) ,
                    )
                ) ,
                'week' => array(
                    'display' => __l('This week') ,
                    'conditions' => array(
                        'created <= ' => date('Y-m-d H:i:s', strtotime('now')) ,
                        'created >= ' => date('Y-m-d 00:00:00', strtotime('now -7 days')) ,
                    )
                ) ,
                'month' => array(
                    'display' => __l('This month') ,
                    'conditions' => array(
                        'created <= ' => date('Y-m-d H:i:s', strtotime('now')) ,
                        'created >= ' => date('Y-m-d 00:00:00', strtotime('now -30 days')) ,
                    )
                ) ,
                'total' => array(
                    'display' => __l('Total') ,
                    'conditions' => array()
                )
            );
            $models[] = array(
                'ContestUser' => array(
                    'display' => __l('Entries') ,
                    'conditions' => array(
                        'ContestUser.user_id' => $this->Auth->user('id') ,
                    ) ,
                    'alias' => 'ContestUser',
                )
            );
            $this->loadModel('Transaction');
            $models[] = array(
                'Transaction' => array(
                    'display' => sprintf(__l('Earned (%s)') , Configure::read('site.currency')) ,
                    'conditions' => array(
                        'Transaction.user_id' => $this->Auth->user('id') ,
                        'Transaction.transaction_type_id' => ConstTransactionTypes::PrizeAmountForCompletedContest
                    ) ,
                    'alias' => 'Transaction',
                )
            );
            foreach($models as $unique_model) {
                foreach($unique_model as $model => $fields) {
                    foreach($periods as $key => $period) {
                        $conditions = $period['conditions'];
                        if (!empty($fields['conditions'])) {
                            $conditions = array_merge($periods[$key]['conditions'], $fields['conditions']);
                        }
                        $aliasName = !empty($fields['alias']) ? $fields['alias'] : $model;
                        if ($model == 'ContestUser') {
                            $RevenueRecieved = $this->User->ContestUser->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'COUNT(ContestUser.id) as total_count'
                                ) ,
                                'recursive' => -1
                            ));
                            $this->set($aliasName . $key, $RevenueRecieved['0']['total_count']);
                        } else if ($model == 'Transaction') {
                            $RevenueRecieved = $this->Transaction->find('first', array(
                                'conditions' => $conditions,
                                'fields' => array(
                                    'SUM(Transaction.amount) as total_amount'
                                ) ,
                                'recursive' => -1
                            ));
                            $this->set($aliasName . $key, $RevenueRecieved['0']['total_amount']);
                        }
                    }
                }
            }
        }
        $this->set(compact('periods', 'models'));
    }
    public function contest_chart()
    {
        $conditions = array();
        $conditions_ending_participant = array();
        $conditions_ending_participant['Contest.is_pending_action_to_admin'] = 1;
        if (empty($this->request->params['named']['is_admin'])) {
            $conditions['Contest.user_id'] = $this->Auth->user('id');
            $conditions_ending_participant['Contest.user_id'] = $this->Auth->user('id');
        } else {
            $this->set('flagged_count', $this->Contest->find('count', array(
                'conditions' => array(
                    'Contest.is_system_flagged' => 1,
                ) ,
                'recursive' => -1
            )));
            $this->set('suspended_count', $this->Contest->find('count', array(
                'conditions' => array(
                    'Contest.admin_suspend' => 1,
                ) ,
                'recursive' => -1
            )));
        }
        $all_contest_count = $this->Contest->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $resource_conditions = array();
        if (!isPluginEnabled('VideoResources')) {
            $resource_conditions['Contest.resource_id !='] = ConstResourceId::Video;
        }
        if (!isPluginEnabled('ImageResources')) {
            if (!empty($resource_conditions)) {
                $resource_conditions = array();
                $resource_conditions['NOT']['Contest.resource_id'] = array(
                    ConstResourceId::Image,
                    ConstResourceId::Video
                );
            } else {
                $resource_conditions['Contest.resource_id !='] = ConstResourceId::Image;
            }
        }
        $conditions_ending_participant = $conditions_ending_participant+$resource_conditions;
        $contest_count = $this->Contest->find('count', array(
            'conditions' => $conditions_ending_participant,
            'recursive' => -1
        ));
        $this->set('pendingactiontoadmin_count', $contest_count);
        $conditions = $conditions+$resource_conditions;
        $this->set('all_contest_count', $all_contest_count);
        $contest_statuses = $this->Contest->ContestStatus->find('all', array(
            'fields' => array(
                'ContestStatus.id',
                'ContestStatus.name',
                'ContestStatus.slug'
            ) ,
            'recursive' => -1
        ));
        foreach($contest_statuses as $key => $contest_status) {
            $count = 0;
            $conditions['Contest.contest_status_id'] = $contest_status['ContestStatus']['id'];
            $count = $this->Contest->find('count', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            $contest_statuses[$key]['contest_count'] = $count;
        }
        $this->set('contest_statuses', $contest_statuses);
    }
    public function _updateCountInUser($contest_id)
    {
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $contest_id
            ) ,
            'fields' => array(
                'Contest.user_id',
                'Contest.contest_status_id',
            ) ,
            'recursive' => -1
        ));
        if (!empty($contest)) {
            $this->Contest->updateCountInUser($contest['Contest']['user_id'], $contest['Contest']['contest_status_id']);
        }
    }
    public function admin_contest_chart()
    {
        $this->initChart();
        $this->loadModel('Contests.Contest');
        $this->loadModel('Contests.ContestStatus');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        //# contests
        $contest_statuses = $this->ContestStatus->find('all', array(
            'recursive' => -1
        ));
        foreach($contest_statuses as $contest_status) {
            $contest_model_datas[$contest_status['ContestStatus']['name']] = array(
                'display' => $contest_status['ContestStatus']['name'],
                'conditions' => array(
                    'Contest.contest_status_id' => $contest_status['ContestStatus']['id']
                ) ,
            );
        }
        $contest_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array();
        $chart_contest_status_data = $this->_setLineData($select_var, $contest_model_datas, 'Contest', $common_conditions);
        $this->set('chart_contest_status_data', $chart_contest_status_data);
        $this->set('chart_contest_status_periods', $contest_model_datas);
        $this->set('selectRanges', $this->selectRanges);
        //chart entries
        $this->loadModel('Contests.ContestUser');
        $this->loadModel('Contests.ContestUserStatus');
        //# contests entries
        $contest_user_statuses = $this->ContestUserStatus->find('all', array(
            'recursive' => -1
        ));
        foreach($contest_user_statuses as $contest_user_status) {
            $contest_user_model_datas[$contest_user_status['ContestUserStatus']['name']] = array(
                'display' => $contest_user_status['ContestUserStatus']['name'],
                'conditions' => array(
                    'ContestUser.contest_user_status_id' => $contest_user_status['ContestUserStatus']['id']
                ) ,
            );
        }
        $contest_user_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array();
        $chart_contest_user_status_data = $this->_setLineData($select_var, $contest_user_model_datas, 'ContestUser', $common_conditions);
        $this->set('chart_contest_user_status_data', $chart_contest_user_status_data);
        $this->set('chart_contest_user_status_periods', $contest_user_model_datas);
        $is_ajax_load = false;
        if ($this->RequestHandler->isAjax()) {
            $is_ajax_load = true;
        }
        $this->set('is_ajax_load', $is_ajax_load);
    }
    public function download($attachment_id = null, $id = null)
    {
        //checking Authontication
        if (empty($id) or empty($attachment_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('SubmissionField');
        $SubmissionField = $this->SubmissionField->find('first', array(
            'conditions' => array(
                'SubmissionField.id =' => $id,
            ) ,
            'recursive' => 0
        ));
        if (empty($SubmissionField)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('Attachment');
        $file = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.id =' => $attachment_id,
            ) ,
            'recursive' => -1
        ));
        if ($file['Attachment']['foreign_id'] != $SubmissionField['SubmissionField']['id']) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->viewClass = 'Media';
        // Download app/outside_webroot_dir/example.zip
        $file_parts = pathinfo($file['Attachment']['filename']);
        $params = array(
            'id' => $file['Attachment']['filename'],
            'name' => $file_parts['filename'],
            'download' => true,
            'extension' => $file_parts['extension'],
            'path' => 'media' . DS . $file['Attachment']['dir'] . DS
        );
        $this->set($params);
    }
    public function download_entry($contest_id = null, $id = null)
    {
        if (empty($id) or empty($contest_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contestUser = $this->Contest->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contest_id,
                'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won,
            ) ,
            'contain' => array(
                'Contest'
            ) ,
            'recursive' => 2
        ));
        if ($contestUser['Contest']['user_id'] != $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->loadModel('Attachment');
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.id =' => $id,
            ) ,
            'recursive' => -1
        ));
        $data['ContestUserDownload']['user_id'] = $this->Auth->user('id');
        $data['ContestUserDownload']['contest_user_id'] = $contestUser['ContestUser']['id'];
        $data['ContestUserDownload']['ip_id'] = $this->Contest->ContestUser->ContestUserDownload->toSaveIp();
        $this->Contest->ContestUser->ContestUserDownload->create();
        $this->Contest->ContestUser->ContestUserDownload->save($data);
        if (Configure::read('s3.is_enabled') && !Configure::read('s3.keep_copy_in_local')) {
            App::import('Vendor', 'HighPerformance.S3');
            $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
            $s3->setEndpoint(Configure::read('s3.end_point'));
            $s3->getObject(Configure::read('s3.bucket_name') , $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename'], APP . 'media' . '/' . $attachment['Attachment']['dir'] . '/' . $attachment['Attachment']['filename']);
        }
        $attachment_parts = pathinfo($attachment['Attachment']['filename']);
        $params = array(
            'id' => $attachment['Attachment']['filename'],
            'name' => $attachment_parts['filename'],
            'download' => true,
            'extension' => $attachment_parts['extension'],
            'path' => 'media' . DS . $attachment['Attachment']['dir'] . DS
        );
        $this->set($params);
        $this->viewClass = 'Media';
    }
    public function admin_action_taken()
    {
        if (isPluginEnabled('Withdrawals')) {
            $this->loadModel('Withdrawals.UserCashWithdrawal');
            $pending_withdraw_count = $this->UserCashWithdrawal->find('count', array(
                'conditions' => array(
                    'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
                ) ,
                'recursive' => -1
            ));
            $this->set('pending_withdraw_count', $pending_withdraw_count);
        }
        if (isPluginEnabled('ContestFlags')) {
            $contest_system_flagged_count = $this->Contest->find('count', array(
                'conditions' => array(
                    'Contest.is_system_flagged' => 1
                ) ,
                'recursive' => -1
            ));
            $contest_user_flagged_count = $this->Contest->find('count', array(
                'conditions' => array(
                    'Contest.is_user_flagged' => 1
                ) ,
                'recursive' => -1
            ));
            $this->set('contest_user_flagged_count', $contest_user_flagged_count);
            $this->set('contest_system_flagged_count', $contest_system_flagged_count);
        }
        if (isPluginEnabled('EntryFlags')) {
            $contestuser_system_flagged_count = $this->Contest->ContestUser->find('count', array(
                'conditions' => array(
                    'ContestUser.is_system_flagged' => 1
                ) ,
                'recursive' => -1
            ));
            $contestuser_user_flagged_count = $this->Contest->ContestUser->find('count', array(
                'conditions' => array(
                    'ContestUser.is_user_flagged' => 1
                ) ,
                'recursive' => -1
            ));
            $this->set('contestuser_user_flagged_count', $contestuser_user_flagged_count);
            $this->set('contestuser_system_flagged_count', $contestuser_system_flagged_count);
        }
        $pending_for_approval_user_count = $this->Contest->User->find('count', array(
            'conditions' => array(
                'User.is_active' => 0
            ) ,
            'recursive' => -1
        ));
        $pending_for_approval_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.contest_status_id' => ConstContestStatus::PendingApproval
            ) ,
            'recursive' => -1
        ));
        $pending_action_to_admin_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_pending_action_to_admin' => 1
            ) ,
            'recursive' => -1
        ));
        $refund_request_count = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.contest_status_id' => ConstContestStatus::RefundRequest
            ) ,
            'recursive' => -1
        ));
        $this->set('pending_for_approval_user_count', $pending_for_approval_user_count);
        $this->set('pending_action_to_admin_count', $pending_action_to_admin_count);
        $this->set('pending_for_approval_count', $pending_for_approval_count);
        $this->set('refund_request_count', $refund_request_count);
    }
    public function update_view_count()
    {
        if (!empty($this->request->data['ids'])) {
            $ids = explode(',', $this->request->data['ids']);
            $contests = $this->Contest->find('all', array(
                'conditions' => array(
                    'Contest.id' => $ids
                ) ,
                'fields' => array(
                    'Contest.id',
                    'Contest.contest_view_count'
                ) ,
                'recursive' => -1
            ));
            foreach($contests as $contest) {
                $json_arr[$contest['Contest']['id']] = $contest['Contest']['contest_view_count'];
            }
            $this->viewClass = 'Json';
            $this->set('json', $json_arr);
        }
    }
    public function entry_design($contest_id = "", $slug = "")
    {
        $this->loadModel('Contests.EntryAttachment');
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['EntryAttachment']['filename']['name'])) {
                $this->request->data['EntryAttachment']['filename']['type'] = get_mime($this->request->data['EntryAttachment']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['EntryAttachment']['filename']['name'])) {
                $this->EntryAttachment->set($this->request->data);
            }
        }
        if (!empty($this->request->data['EntryAttachment']['filename']['name'])) {
            if ($this->EntryAttachment->validates()) {
                $attachment = $this->Contest->Attachment->find('first', array(
                    'conditions' => array(
                        'Attachment.class' => 'EntryAttachment',
                        'Attachment.foreign_id' => $this->request->data['Contest']['contest_id'],
                    ) ,
                    'recursive' => -1
                ));
                $this->request->data['EntryAttachment']['class'] = 'EntryAttachment';
                $this->request->data['EntryAttachment']['foreign_id'] = $this->request->data['Contest']['contest_id'];
                if (!empty($attachment)) {
                    $this->request->data['EntryAttachment']['id'] = $attachment['Attachment']['id'];
                } else {
                    $this->Contest->Attachment->create();
                }
                $this->Contest->Attachment->save($this->request->data['EntryAttachment']);
                $this->Contest->updateAll(array(
                    'Contest.is_uploaded_entry_design' => 1
                ) , array(
                    'Contest.id' => $this->request->data['Contest']['contest_id']
                ));
                $this->Session->setFlash(sprintf(__l('%s has been uploaded') , __l('Entry Design')) , 'default', null, 'success');
                $contest_url = Router::url(array(
                    'controller' => 'contests',
                    'action' => 'view',
                    $this->request->data['Contest']['contest_slug'],
                ) , true);
                $this->redirect($contest_url);
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be uploaded') , __l('Entry Design')) , 'default', null, 'error');
            }
        }
        $this->set('contest_id', $contest_id);
        $this->set('slug', $slug);
    }
    public function reupload_entry_design($contest_id, $slug)
    {
        $contest = $this->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $contest_id
            ) ,
            'recursive' => -1
        ));
        if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Completed) {
            $this->Session->setFlash(__l('Sorry contest is already completed.') , 'default', null, 'error');
        } else {
            $this->Contest->updateAll(array(
                'Contest.is_uploaded_entry_design' => 0
            ) , array(
                'Contest.id' => $contest_id
            ));
            $this->Session->setFlash(sprintf(__l('%s Reupload has been enabled') , __l('Entry Design')) , 'default', null, 'success');
        }
        $contest_url = Router::url(array(
            'controller' => 'contests',
            'action' => 'view',
            $slug,
        ) , true);
        $this->redirect($contest_url);
    }
    public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'contest') {
            $contest = $this->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => 0
            ));
            $this->set('contest', $contest);
        }
        $this->layout = 'ajax';
    }
    public function upgrade_features($id = null)
    {
        $this->pageTitle = __l('Upgrade Contest Features');
        if (!empty($this->request->data)) {
            $id = $this->request->data['Contest']['id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $conditions['Contest.id'] = $id;
        if ($this->Auth->user('id') != ConstUserIds::Admin) {
            $conditions['OR'][]['Contest.user_id'] = $this->Auth->user('id');
        }
        $contest = $this->Contest->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'ContestStatus',
                'ContestType'
            ) ,
            'recursive' => 1
        ));
        $contestType = $this->Contest->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $contest['Contest']['contest_type_id']
            ) ,
            'recursive' => -1
        ));
        if (empty($contest) || $contest['Contest']['contest_status_id'] != ConstContestStatus::Open) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        if (!empty($contest['Contest']['is_blind']) && !empty($contest['Contest']['is_private']) && !empty($contest['Contest']['is_featured']) && !empty($contest['Contest']['is_highlight'])) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            $_upgrade = array();
            $this->request->data['Contest']['contest_type_id'] = $contest['Contest']['contest_type_id'];
            if (!empty($this->request->data['Contest']['blind_fee']['is_checked'])) {
                $this->request->data['Contest']['is_blind'] = 1;
                $_upgrade['fields']['is_blind'] = 1;
            }
            if (!empty($this->request->data['Contest']['private_fee']['is_checked'])) {
                $this->request->data['Contest']['is_private'] = 1;
                $_upgrade['fields']['is_private'] = 1;
            }
            if (!empty($this->request->data['Contest']['featured_fee']['is_checked'])) {
                $this->request->data['Contest']['is_featured'] = 1;
                $_upgrade['fields']['is_featured'] = 1;
            }
            if (!empty($this->request->data['Contest']['highlight_fee']['is_checked'])) {
                $this->request->data['Contest']['is_highlight'] = 1;
                $_upgrade['fields']['is_highlight'] = 1;
            }
            $this->request->data['Contest']['prize'] = $contest['Contest']['prize'];
            $pricings = $this->Contest->calculateContestPrice($this->request->data);
            $this->request->data['Contest']['is_blind'] = $contest['Contest']['is_blind'];
            $this->request->data['Contest']['is_private'] = $contest['Contest']['is_private'];
            $this->request->data['Contest']['is_featured'] = $contest['Contest']['is_featured'];
            $this->request->data['Contest']['is_highlight'] = $contest['Contest']['is_highlight'];
            $total_amount = $pricings['creation_cost']-$contest['Contest']['prize'];
            $total_amount = round($total_amount, 2);
            $_upgrade['fee'] = $total_amount;
            $_upgrade['type'] = ConstTransactionTypes::ContestFeaturesUpdated;
            $this->request->data['Contest']['upgrade'] = serialize($_upgrade);
            $this->request->data['Contest']['sudopay_gateway_id'] = 0;
            if ($this->request->data['Contest']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['Contest']['payment_gateway_id'], 'sp_') >= 0) {
                $this->request->data['Contest']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['Contest']['payment_gateway_id']);
                $this->request->data['Contest']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
            }
            if ($this->Contest->save($this->request->data)) {
                if (!empty($this->request->data)) {
                    $is_error = 0;
                    if (!empty($this->request->data['Contest']['payment_gateway_id'])) {
                        $PaymentGateway = $this->Contest->PaymentGateway->find('first', array(
                            'conditions' => array(
                                'PaymentGateway.id' => $this->request->data['Contest']['payment_gateway_id']
                            ) ,
                            'recursive' => -1
                        ));
                        if (!empty($this->request->data['Contest']['payment_gateway_id']) && $this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                            if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
                                $user = $this->Contest->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $this->Auth->user('id')
                                    ) ,
                                    'fields' => array(
                                        'User.id',
                                        'User.username',
                                        'User.available_wallet_amount',
                                    ) ,
                                    'recursive' => -1
                                ));
                                if (empty($user)) {
                                    throw new NotFoundException(__l('Invalid request'));
                                }
                                if (empty($total_amount)) {
                                    $is_error = 1;
                                    $error_message = __l('Contest features could not be updated. Please, try again.');
                                    $this->Session->setFlash(__l('Contest features could not be updated. Please, try again.') , 'default', null, 'error');
                                }
                                if ($user['User']['available_wallet_amount'] < $total_amount) {
                                    $is_error = 1;
                                    $error_message = __l('Your wallet has insufficient money to add this contest');
                                    $this->Session->setFlash(__l('Your wallet has insufficient money to add this contest') , 'default', null, 'error');
                                }
                            }
                        }
                        if (!empty($is_error)) {
                            $this->Session->setFlash($error_message, 'default', null, 'error');
                        } else {
                            if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                if (!empty($_upgrade['fields'])) {
                                    foreach($_upgrade['fields'] as $key => $field) {
                                        $contest_data['Contest'][$key] = $field;
                                    }
                                }
                            }
                            $contest_data['Contest']['creation_cost'] = $contest['Contest']['creation_cost']+$pricings['creation_cost']-$contest['Contest']['prize'];
                            $contest_data['Contest']['id'] = $this->request->data['Contest']['id'];
                            $contest_data['Contest']['sudopay_gateway_id'] = $this->request->data['Contest']['sudopay_gateway_id'];
                            $contest_data['Contest']['payment_gateway_id'] = $this->request->data['Contest']['payment_gateway_id'];
                            $this->Contest->save($contest_data, false);
                            if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                $this->redirect(array(
                                    'controller' => 'contests',
                                    'action' => 'view',
                                    $contest['Contest']['slug']
                                ));
                            }
                            if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                                $this->loadModel('Sudopay.Sudopay');
                                $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                                $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                                if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                                    $sudopay_data = $this->Sudopay->getSudoPayPostData($this->request->data['User']['id'], ConstPaymentType::ContestUpgradeFee);
                                    $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                                    $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                                    $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                                    $sudopay_data['action'] = 'capture';
                                    $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sudopay_btn.js' . '\'';
                                    if (!empty($sudopay_gateway_settings['is_test_mode'])) {
                                        $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sandbox/sudopay_btn.js' . '\'';
                                    }
                                    $this->set('sudopay_data', $sudopay_data);
                                } else {
                                    $this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
                                    $return = $this->Sudopay->processPayment($this->request->data['Contest']['id'], ConstPaymentType::ContestUpgradeFee, $this->request->data['Sudopay']);
                                    if (!empty($return['pending'])) {
                                        $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
                                    } elseif (!empty($return['success'])) {
                                        $this->Session->setFlash(__l('You have paid Contest Upgrade fee successfully') , 'default', null, 'success');
                                    } elseif (!empty($return['error'])) {
                                        $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
                                    }
                                    $this->redirect(array(
                                        'controller' => 'contests',
                                        'action' => 'view',
                                        $contest['Contest']['slug']
                                    ));
                                }
                            } else {
                                $return = $this->requestAction(array(
                                    'plugin' => Inflector::camelize($PaymentGateway['PaymentGateway']['name']) ,
                                    'controller' => strtolower($PaymentGateway['PaymentGateway']['name']) . 's',
                                    'action' => 'process_payment',
                                    $this->request->data['Contest']['id'],
                                    $total_amount,
                                    ConstPaymentType::ContestUpgradeFee,
                                    'admin' => false
                                ));
                            }
                        }
                    }
                }
            }
        } else {
            $this->request->data['Contest']['id'] = $id;
            $this->request->data['Contest']['other_fee'] = 0;
        }
        $this->set('total_amount', 0);
        $this->set(compact('contest', 'contestType'));
    }
    public function extend_time($id = null)
    {
        $this->pageTitle = __l('Extend Contest Time');
        if (!empty($this->request->data)) {
            $id = $this->request->data['Contest']['id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $conditions = array();
        $conditions['Contest.id'] = $id;
        if ($this->Auth->user('id') != ConstUserIds::Admin) {
            $conditions['OR'][]['Contest.user_id'] = $this->Auth->user('id');
        }
        $contest = $this->Contest->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'ContestStatus',
                'ContestType'
            ) ,
            'recursive' => 1
        ));
        if (empty($contest) || ($contest['Contest']['contest_status_id'] != ConstContestStatus::Open && $contest['Contest']['contest_status_id'] != ConstContestStatus::Judging)) {
            throw new NotFoundException(__l('Invalid contest'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            App::import('Model', 'Contests.PricingDay');
            $this->PricingDay = new PricingDay();
            $pricingDay = $this->PricingDay->find('first', array(
                'conditions' => array(
                    'PricingDay.id' => $this->request->data['Contest']['pricing_day_id']
                ) ,
                'recursive' => -1
            ));
            $this->request->data['Contest']['sudopay_gateway_id'] = 0;
            if ($this->request->data['Contest']['payment_gateway_id'] != ConstPaymentGateways::Wallet && strpos($this->request->data['Contest']['payment_gateway_id'], 'sp_') >= 0) {
                $this->request->data['Contest']['sudopay_gateway_id'] = str_replace('sp_', '', $this->request->data['Contest']['payment_gateway_id']);
                $this->request->data['Contest']['payment_gateway_id'] = ConstPaymentGateways::SudoPay;
            }
            $this->request->data['Contest']['contest_type_id'] = $contest['Contest']['contest_type_id'];
            $this->request->data['Contest']['prize'] = $contest['Contest']['prize'];
            $pricings = $this->Contest->calculateContestPrice($this->request->data);
            $total_amount = $pricings['creation_cost']-$contest['Contest']['prize'];
            if (empty($this->request->data['Contest']['days_complete']) || empty($this->request->data['Contest']['payment_gateway_id'])) {
                $this->Session->setFlash(__l('Please select the payment type and days to complete field') , 'default', null, 'error');
            } else {
                $actual_end_date = $contest['Contest']['actual_end_date'];
				$new_date = date('Y-m-d', strtotime($actual_end_date . ' + ' . $pricingDay['PricingDay']['no_of_days'] . ' days'));
				if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging) {
                    $new_date = date('Y-m-d', strtotime('now + ' . $pricingDay['PricingDay']['no_of_days'] . ' days'));
                }
                $_upgrade['fields']['end_date'] = $new_date;
                $_upgrade['fields']['actual_end_date'] = $actual_end_date;
                $_upgrade['fields']['pricing_day_id'] = $this->request->data['Contest']['pricing_day_id'];
                $total_amount = round($total_amount, 2);
                $_upgrade['fee'] = $total_amount;
                $_upgrade['type'] = ConstTransactionTypes::ContestTimeExtended;
                $this->request->data['Contest']['pricing_day_id'] = $contest['Contest']['pricing_day_id'];
				$this->request->data['Contest']['end_date'] = $new_date;
                $this->request->data['Contest']['actual_end_date'] = $actual_end_date;
                $this->request->data['Contest']['upgrade'] = serialize($_upgrade);
                $contest_data['Contest']['sudopay_gateway_id'] = $this->request->data['Contest']['sudopay_gateway_id'];
                $contest_data['Contest']['payment_gateway_id'] = $this->request->data['Contest']['payment_gateway_id'];
                if ($this->Contest->save($this->request->data)) {
                    if (!empty($this->request->data)) {
                        $is_error = 0;
                        if (!empty($this->request->data['Contest']['payment_gateway_id'])) {
                            $PaymentGateway = $this->Contest->PaymentGateway->find('first', array(
                                'conditions' => array(
                                    'PaymentGateway.id' => $this->request->data['Contest']['payment_gateway_id']
                                ) ,
                                'recursive' => -1
                            ));
                            if (!empty($this->request->data['Contest']['payment_gateway_id']) && $this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
                                    $user = $this->Contest->User->find('first', array(
                                        'conditions' => array(
                                            'User.id' => $this->Auth->user('id')
                                        ) ,
                                        'fields' => array(
                                            'User.id',
                                            'User.username',
                                            'User.available_wallet_amount',
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    if (empty($user)) {
                                        throw new NotFoundException(__l('Invalid request'));
                                    }
                                    if ($user['User']['available_wallet_amount'] < $total_amount) {
                                        $is_error = 1;
                                        $error_message = __l('Your wallet has insufficient money to add this contest');
                                        $this->Session->setFlash(__l('Your wallet has insufficient money to add this contest') , 'default', null, 'error');
                                    }
                                }
                            }
                            if (!empty($is_error)) {
                                $this->Session->setFlash($error_message, 'default', null, 'error');
                            } else {
                                $contest_data['Contest']['id'] = $this->request->data['Contest']['id'];
                                $contest_data['Contest']['payment_gateway_id'] = $this->request->data['Contest']['payment_gateway_id'];
                                $this->Contest->save($contest_data);
                                if ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::Wallet) {
                                    if (!empty($_upgrade['fields'])) {
                                        if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging) {
                                            $contest_data['Contest']['contest_status_id'] = ConstContestStatus::Open;
                                        }
                                        $contest_data['Contest']['id'] = $this->request->data['Contest']['id'];
                                        $contest_data['Contest']['actual_end_date'] = $_upgrade['fields']['end_date'];
                                        $this->Contest->save($contest_data);
                                    }
                                    $this->Session->setFlash(__l('You have paid Contest Extend Time Fee successfully') , 'default', null, 'success');
                                    $this->redirect(array(
                                        'controller' => 'contests',
                                        'action' => 'view',
                                        $contest['Contest']['slug']
                                    ));
                                } elseif ($this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::SudoPay) {
                                    $this->loadModel('Sudopay.Sudopay');
                                    $sudopay_gateway_settings = $this->Sudopay->GetSudoPayGatewaySettings();
                                    $this->set('sudopay_gateway_settings', $sudopay_gateway_settings);
                                    if ($sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
                                        $sudopay_data = $this->Sudopay->getSudoPayPostData($this->request->data['User']['id'], ConstPaymentType::ContestExtendTimeFee);
                                        $sudopay_data['merchant_id'] = $sudopay_gateway_settings['sudopay_merchant_id'];
                                        $sudopay_data['website_id'] = $sudopay_gateway_settings['sudopay_website_id'];
                                        $sudopay_data['secret_string'] = $sudopay_gateway_settings['sudopay_secret_string'];
                                        $sudopay_data['action'] = 'capture';
                                        $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sudopay_btn.js' . '\'';
                                        if (!empty($sudopay_gateway_settings['is_test_mode'])) {
                                            $sudopay_data['button_url'] = '\'' . '//d1fhd8b1ym2gwa.cloudfront.net/btn/sandbox/sudopay_btn.js' . '\'';
                                        }
                                        $this->set('sudopay_data', $sudopay_data);
                                    } else {
                                        $this->request->data['Sudopay'] = !empty($this->request->data['Sudopay']) ? $this->request->data['Sudopay'] : '';
                                        $return = $this->Sudopay->processPayment($this->request->data['Contest']['id'], ConstPaymentType::ContestExtendTimeFee, $this->request->data['Sudopay']);
                                        if (!empty($return['pending'])) {
                                            $this->Session->setFlash(__l('Your payment is in pending.') , 'default', null, 'success');
                                        } elseif (!empty($return['success'])) {
                                            if (!empty($_upgrade['fields'])) {
                                                if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging) {
                                                    $contest_data['Contest']['contest_status_id'] = ConstContestStatus::Open;
                                                }
                                                $contest_data['Contest']['id'] = $this->request->data['Contest']['id'];
                                                $contest_data['Contest']['actual_end_date'] = $_upgrade['fields']['end_date'];
                                                $this->Contest->save($contest_data);
                                            }
                                            $this->Session->setFlash(__l('You have paid Contest Extend Time Fee successfully') , 'default', null, 'success');
                                        } elseif (!empty($return['error'])) {
                                            $this->Session->setFlash($return['error_message'] . __l('Your payment could not be completed.') , 'default', null, 'error');
                                        }
                                        $this->redirect(array(
                                            'controller' => 'contests',
                                            'action' => 'view',
                                            $contest['Contest']['slug']
                                        ));
                                    }
                                } else {
                                    $return = $this->requestAction(array(
                                        'plugin' => Inflector::camelize($PaymentGateway['PaymentGateway']['name']) ,
                                        'controller' => strtolower($PaymentGateway['PaymentGateway']['name']) . 's',
                                        'action' => 'process_payment',
                                        $this->request->data['Contest']['id'],
                                        $total_amount,
                                        ConstPaymentType::ContestExtendTimeFee,
                                        'admin' => false
                                    ));
                                }
                            }
                        }
                    } else {
                        $this->request->data = $contest;
                    }
                    $this->set('total_amount', $total_amount);
                    $this->set('contest', $contest);
                    ///

                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Contest')) , 'default', null, 'error');
                }
            }
        } else {
            $this->request->data['Contest']['id'] = $id;
            $this->request->data['Contest']['other_fee'] = 0;
        }
        $contestType = $this->Contest->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $contest['Contest']['contest_type_id']
            ) ,
            'contain' => array(
                'PricingPackage' => array(
                    'conditions' => array(
                        'PricingPackage.is_active' => 1
                    ) ,
                ) ,
                'PricingDay' => array(
                    'conditions' => array(
                        'PricingDay.is_active' => 1
                    ) ,
                )
            ) ,
            'recursive' => 4
        ));
        $this->set('total_amount', 0);
        $this->set(compact('contest', 'contestType'));
    }
}
