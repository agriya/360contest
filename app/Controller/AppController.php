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
App::uses('Controller', 'Controller');
class AppController extends Controller
{
    /**
     * Components
     *
     * @var array
     * @access public
     */
    public $components = array(
        'Cms',
        'Security',
        'Auth',
        'Acl.AclFilter',
        'Cookie',
        'Session',
        'XAjax',
        'RequestHandler',
        //'DebugKit.Toolbar',

    );
    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Html',
        'Form',
        'Javascript',
        'Session',
        'Text',
        'Js',
        'Time',
        'Layout',
        'Auth',
    );
    /**
     * Models
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Block',
        'Link',
        'Setting',
        'Node',
    );
    /**
     * Pagination
     */
    public $paginate = array(
        'limit' => 10,
    );
    /**
     * Cache pagination results
     *
     * @var boolean
     * @access public
     */
    public $usePaginationCache = true;
    /**
     * View
     *
     * @var string
     * @access public
     */
    public $viewClass = 'Theme';
    /**
     * Theme
     *
     * @var string
     * @access public
     */
    public $theme;
    /**
     * Constructor
     *
     * @access public
     */
    public function __construct($request = null, $response = null)
    {
        Cms::applyHookProperties('Hook.controller_properties', $this);
        parent::__construct($request, $response);
        if ($this->name == 'CakeError') {
            $this->_set(Router::getPaths());
            $this->request->params = Router::getParams();
            $this->constructClasses();
            $this->startupProcess();
        }
    }
    function beforeRender()
    {
        $this->set('meta_for_layout', Configure::read('meta'));
        parent::beforeRender();
    }
    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter()
    {
        parent::beforeFilter();
        $cur_page = $this->request->params['controller'] . '/' . $this->request->params['action'];
		if ($this->Auth->user('id')) {
			$this->loadModel('User');
			$user = $this->User->find('first', array(
				'conditions' => array(
					'User.id' => $this->Auth->user('id')
				) ,
				'recursive' => -1
			));
		}
		if (!$this->Auth->user('id') && !empty($_COOKIE['_gz'])) {
			setcookie('_gz', '', time() -3600, '/');
        }
        if ($this->Auth->user('id') && empty($_COOKIE['_gz'])) {
            $hashed_val = md5($this->Auth->user('id') . session_id() . PERMANENT_CACHE_GZIP_SALT);
            $hashed_val = substr($hashed_val, 0, 7);
            $form_cookie = $this->Auth->user('id') . '|' . $hashed_val;
            setcookie('_gz', $form_cookie, time() +60*60*24, '/');
        }
		$is_redirect_to_social_marketing = 1;
		if(Configure::read('user.signup_fee') && $this->Auth->user('id') && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
			$fee_urls = array(
				'devs/asset_js',
	            'devs/asset_css',
				'users/login',
				'users/logout',
				'payments/membership_pay_now',
				'payments/get_gateways',
				'users/show_header',
			);
			if(!in_array($cur_page, $fee_urls) && empty($user['User']['is_paid'])) {
				$this->redirect(array(
					'controller' => 'payments',
					'action' => 'membership_pay_now',
					$this->Auth->user('id'),
					$this->User->getActivateHash($this->Auth->user('id'))
				));
			}
			if(empty($user['User']['is_paid'])) {
				$is_redirect_to_social_marketing = 0;
			}
		}

		if (isPluginEnabled('SocialMarketing') && !empty($is_redirect_to_social_marketing)) {
			$skip_urls = array(
				'devs/asset_js',
	            'devs/asset_css',
				'users/login',
				'users/logout',
				'social_marketings/import_friends',
				'social_contacts/index',
				'social_contacts/update',
				'users/follow_friends',
				'user_followers/add_multiple',
				'users/show_header',
			);
            if ($this->Auth->user('id') && !in_array($cur_page, $skip_urls) && !empty($user) && (!$user['User']['is_skipped_fb'] || !$user['User']['is_skipped_twitter'] || !$user['User']['is_skipped_google'] || !$user['User']['is_skipped_yahoo'])) {
                if (!$user['User']['is_skipped_fb']) {
                    $type = 'facebook';
                } elseif (!$user['User']['is_skipped_twitter']) {
                    $type = 'twitter';
                } elseif (!$user['User']['is_skipped_google']) {
                    $type = 'gmail';
                } elseif (!$user['User']['is_skipped_yahoo']) {
                    $type = 'yahoo';
                }
                $this->redirect(array(
                    'controller' => 'social_marketings',
                    'action' => 'import_friends',
                    'type' => $type,
                    'admin' => false
                ));
            }
        }
		if (isPluginEnabled('LaunchModes')) {
            $pre_launch_exception_array = array(
                'subscriptions/add',
                'subscriptions/check_invitation',
                'subscriptions/confirmation',
                'users/logout',
                'users/facepile',
                'nodes/view',
                'nodes/home',
                'pages/view',
                'images/view',
                'devs/asset_js',
                'devs/asset_css',
                'devs/robots',
                'devs/sitemap',
                'users/show_captcha',
                'users/captcha_play',
                'payments/user_pay_now',
                'payments/get_gateways',
                'users/show_header',
            );
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (Configure::read('site.launch_mode') == 'Pre-launch' && !in_array($cur_page, $pre_launch_exception_array)) {
                    if (empty($this->request->params['prefix'])) {
                        $this->redirect(array(
                            'controller' => 'nodes',
                            'action' => 'home',
                            'admin' => false
                        ));
                    }
                }
            }
            $private_beta_exception_array = array_merge($pre_launch_exception_array, array(
                'users/login',
                'users/logout',
                'users/register',
                'users/admin_login',
                'users/show_header',
                'users/forgot_password',
                'users/activation',
                'users/reset',
                'payments/user_pay_now',
                'payments/_processPayment',
                'payments/success_payment',
                'payments/cancel_payment',
                'payments/get_gateways',
            ));
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                if (Configure::read('site.launch_mode') == 'Private Beta' && !in_array($cur_page, $private_beta_exception_array) && !$this->Auth->user('id')) {
                    if (empty($this->request->params['prefix'])) {
                        $this->redirect(array(
                            'controller' => 'nodes',
                            'action' => 'home',
                            'admin' => false
                        ));
                    } else {
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                }
            }
        }
		// Coding done to disallow demo user to change the admin settings
        if ($this->request->params['action'] != 'flashupload') {
            if ($this->Auth->user('id') && !Configure::read('site.is_admin_settings_enabled') && (in_array($this->request->params['action'], Configure::read('site.admin_demo_mode_not_allowed_actions')) || (!empty($this->request->data) && in_array($cur_page, Configure::read('site.admin_demo_mode_update_not_allowed_pages'))))) {
                $this->Session->setFlash(__l('Sorry. We have disabled this action in demo mode') , 'default', null, 'error');
                if (in_array($this->request->params['controller'], array(
                    'settings',
                    'email_templates'
                ))) {
                    unset($this->request->data);
                } else {
                    $this->redirect(array(
                        'controller' => $this->request->params['controller'],
                        'action' => 'index'
                    ));
                }
            }
        }
        // check site is under maintenance mode or not. admin can set in settings page and then we will display maintenance message, but admin side will work.
        $maintenance_exception_array = array(
            'devs/asset_js',
            'devs/asset_css',
            'devs/robots',
            'devs/sitemap',
        );
        if (Configure::read('site.maintenance_mode') && $this->Auth->user('role_id') != ConstUserTypes::Admin && empty($this->request->params['prefix']) && !in_array($cur_page, $maintenance_exception_array)) {
            throw new MaintenanceModeException(__l('Maintenance Mode'));
        }
		if ($this->Auth->user('id')) {
            App::import('Model', 'User');
            $user_model_obj = new User();
            $user = $user_model_obj->find('first', array(
                'conditions' => array(
                    'User.id =' => $this->Auth->user('id') ,
                ) ,
                'contain' => array(
                    'UserAvatar',
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2'
                            )
                        )
                    ) ,
                ) ,
                'recursive' => 2
            ));
            $this->set('logged_in_user', $user);
            $count_conditions = array();
            $count_conditions = array(
                'Contest.user_id' => $user['User']['id'],
                'Contest.admin_suspend !=' => 1,
            );
			$contest_count = $all_contest_count = $user_model_obj->Contest->find('count', array(
                'conditions' => $count_conditions,
                'recursive' => 0
            ));
			$this->set('contest_count', $contest_count);
			$this->set('all_contest_count', $all_contest_count);
        }
        // Writing site name in cache, required for getting sitename retrieving in cron
        if (!(Cache::read('site_url_for_shell', 'long'))) {
            Cache::write('site_url_for_shell', Router::url('/', true) , 'long');
        }
		// referral link that update cookies
        $this->_friend_referral();
        $this->AclFilter->_checkAuth();
        if (Configure::read('site.theme')) {
            $this->theme = Configure::read('site.theme');
        }
        if (isset($this->request->params['locale'])) {
            Configure::write('Config.language', $this->request->params['locale']);
        }
        $this->layout = 'default';
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin && (isset($this->request->params['prefix']) and $this->request->params['prefix'] == 'admin')) {
            $this->layout = 'admin';
        }
        if (Configure::read('site.maintenance_mode') && !$this->Auth->user('role_id')) {
            $this->layout = 'maintenance';
        }
		// <-- For iPhone App code
        $this->Auth->fields = array(
            'username' => Configure::read('user.using_to_login') ,
            'password' => 'password'
        );
        if (!empty($_GET['key'])) {
            $this->_handleIPhoneApp();
        }
    }
	// <-- For iPhone App code
    function _handleIPhoneApp()
    {
		$this->Security->enabled = false;
        $this->loadModel('User');
        if (!empty($_POST['data']) && in_array($this->request->params['action'], array(
            'validate_user',
        ))) {
            foreach($_POST['data'] as $controller => $values) {
                $this->request->data[Inflector::camelize(Inflector::singularize($controller)) ] = $values;
            }
        }
	/*	if (stripos($_SERVER['HTTP_USER_AGENT'], 'iPhone') === false && stripos($_SERVER['HTTP_USER_AGENT'], 'Android') === false) {
            $this->set('iphone_response', array(
				'status' => 1,
				'message' => __l('Unknown Application')
			));
        } elseif (Configure::read('site.iphone_app_key') != $_GET['key']) {
			$this->set('iphone_response', array(
				'status' => 2,
				'message' => __l('Invalid App key')
			));
        }
        else{*/
			if (!empty($_GET['username']) && $this->request->params['action'] != 'validate_user') {
				$this->request->data['User'][Configure::read('user.using_to_login') ] = trim($_GET['username']);
				$user = $this->User->find('first', array(
					'conditions' => array(
						'User.mobile_app_hash' => $_GET['passwd']
					) ,
					'fields' => array(
						'User.password'
					) ,
					'recursive' => -1
				));
				if (empty($user)) {
					$this->set('iphone_response', array(
						'status' => 1,
						'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
					));
				} else {
					$this->Session->delete('HA::CONFIG');
					$this->Session->delete('HA::STORE');
					$this->Auth->logout();
					$this->request->data['User']['password'] = $user['User']['password'];
					$this->User->set($this->request->data);
					if (!$this->Auth->login()) {
						$this->set('iphone_response', array(
							'status' => 1,
							'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
						));
					}
				}
			}
		//}
    }
    function update_iphone_user($latitude, $longitude, $user_id)
    {
        $this->loadModel('User');
        $this->User->updateAll(array(
            'User.iphone_latitude' => $latitude,
            'User.iphone_longitude' => $longitude,
            'User.iphone_last_access' => "'" . date("Y-m-d H:i:s") . "'"
        ) , array(
            'User.id' => $user_id
        ));
    }
	function _unum()
    {
        $acceptedChars = '0123456789';
        $max = strlen($acceptedChars) -1;
        $unique_code = '';
        for ($i = 0; $i < 8; $i++) {
            $unique_code.= $acceptedChars{mt_rand(0, $max) };
        }
        return $unique_code;
    }
    // For iPhone App code -->
    function _redirectGET2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->query[$param_name])) { // querystring
                    $query_strings[$param_name] = strip_tags($this->request->query[$param_name]);
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
    function _redirectPOST2Named($whitelist_param_names = null)
    {
        $query_strings = array();
        $model = Inflector::classify($this->request->params['controller']);
        if (is_array($whitelist_param_names)) {
            foreach($whitelist_param_names as $param_name) {
                if (isset($this->request->data[$model][$param_name])) { // querystring
                    $query_strings[$param_name] = strip_tags($this->request->data[$model][$param_name]);
                }
            }
        } else {
            $query_strings = $this->request->query;
            unset($query_strings['url']); // Can't use ?url=foo

        }
        if (!empty($query_strings)) {
            $query_strings = array_merge($this->request->params['named'], $query_strings);
            $this->redirect($query_strings, null, true);
        }
    }
    public function admin_update()
    {
        if (!empty($this->request->data[$this->modelClass])) {
            if ($this->{$this->modelClass}->Behaviors->attached('SuspiciousWordsDetector')) {
                $this->{$this->modelClass}->Behaviors->detach('SuspiciousWordsDetector');
            }
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Inactive:
                        $field_name = 'is_active';
                        if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                            $field_name = 'is_approved';
                        }
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'User') {
                            foreach($ids as $key => $user_id) {
                                $this->_sendAdminActionMail($user_id, 'Admin User Deactivate');
                            }
                        }
                        $this->Session->setFlash(__l('Checked records has been inactivated') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Active:
                        $field_name = 'is_active';
                        if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                            $field_name = 'is_approved';
                        }
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        if ($this->modelClass == 'User') {
                            foreach($ids as $key => $user_id) {
                                $this->_sendAdminActionMail($user_id, 'Admin User Active');
                            }
                        }
                        $this->Session->setFlash(__l('Checked records has been activated') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        foreach($ids as $key => $id) {
                            if ($this->modelClass == 'User') {
                                $this->_sendAdminActionMail($id, 'Admin User Delete');
                            }
                            if ($this->modelClass == 'ContestUserRating') {
                                $ContestUserRating = $this->ContestUserRating->find('first', array(
                                    'conditions' => array(
                                        'ContestUserRating.id' => $id
                                    ) ,
                                    'fields' => array(
                                        'ContestUserRating.contest_user_id'
                                    ) ,
                                    'recursive' => -1,
                                ));
                            }
                            $this->{$this->modelClass}->id = $id;
                            $this->{$this->modelClass}->delete();
                            if ($this->modelClass == 'ContestUserRating') {
                                $this->ContestUserRating->updatecount($ContestUserRating['ContestUserRating']['contest_user_id']);
                            }
                        }
                        $this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Suspend:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.admin_suspend' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been suspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unsuspend:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.admin_suspend' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been unsuspended') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Flagged:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_system_flagged' => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been flagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unflagged:
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.is_system_flagged' => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been unflagged') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Disapproved:
                        $field_name = 'is_approved';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been disapproved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Approved:
                        $field_name = 'is_approved';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been approved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unpublish:
                        $field_name = 'status';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been unpublished') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Publish:
                        $field_name = 'status';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been published') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Unpromote:
                        $field_name = 'promote';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 0
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been promoted') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Promote:
                        $field_name = 'promote';
                        $this->{$this->modelClass}->updateAll(array(
                            $this->modelClass . '.' . $field_name => 1
                        ) , array(
                            $this->modelClass . '.id' => $ids
                        ));
                        $this->Session->setFlash(__l('Checked records has been un promoted') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Export:
                        $user_ids = implode(',', $ids);
                        $hash = $this->User->getUserIdHash($user_ids);
                        $_SESSION['user_export'][$hash] = $ids;
                        $this->Session->setFlash(__l('Checked records has been exported') , 'default', null, 'success');
                        $this->redirect(Router::url(array(
                            'controller' => 'users',
                            'action' => 'export',
                            'ext' => 'csv',
                            $hash,
                            'admin' => true
                        ) , true));
                        break;
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function admin_update_status($id = null, $action = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'active')) {
            $field_name = 'is_active';
            if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                $field_name = 'is_approved';
            } elseif ($this->request->params['controller'] == 'blocks' || $this->request->params['controller'] == 'nodes' || $this->request->params['controller'] == 'links') {
                $field_name = 'status';
            }
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass][$field_name] = 1;
			$this->{$this->modelClass}->save($_data);
            if ($this->modelClass == 'User') {
                $this->_sendAdminActionMail($id, 'Admin User Active');
            }
            $this->Session->setFlash(__l('Selected record has been activated') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'approved')) {
            $field_name = 'is_approved';
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass][$field_name] = 1;
			$this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been approved') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'inactive')) {
            $field_name = 'is_active';
            if (isset($this->{$this->modelClass}->_schema['is_approved'])) {
                $field_name = 'is_approved';
            } elseif ($this->request->params['controller'] == 'blocks' || $this->request->params['controller'] == 'nodes' || $this->request->params['controller'] == 'links') {
                $field_name = 'status';
            }
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass][$field_name] = 0;
			$this->{$this->modelClass}->save($_data);
            if ($this->modelClass == 'User') {
                $this->_sendAdminActionMail($id, 'Admin User Deactivate');
            }
            $this->Session->setFlash(__l('Selected record has been inactivated') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'disapproved')) {
            $field_name = 'is_approved';
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass][$field_name] = 0;
			$this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been disapproved') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'flag')) {
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass]['is_system_flagged'] = 1;
			$this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been flagged') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'unflag')) {
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass]['is_system_flagged'] = 0;
			$this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been unflagged') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'suspend')) {
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass]['admin_suspend'] = 1;
			$this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been suspended') , 'default', null, 'success');
        } elseif (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'unsuspend')) {
			$_data[$this->modelClass]['id'] = $id;
			$_data[$this->modelClass]['admin_suspend'] = 0;
			$this->{$this->modelClass}->save($_data);
            $this->Session->setFlash(__l('Selected record has been unsuspended') , 'default', null, 'success');
        }
        if (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'templates') {
            $this->redirect(Router::url(array(
                'controller' => $this->request->controller,
                'action' => 'index',
                'type' => 'templates'
            ) , true));
        } elseif (!empty($this->request->params['controller']) && ($this->request->params['controller'] == 'links') && $this->request->params['action'] == 'admin_update_status') {
            $this->redirect(Router::url(array(
                'controller' => $this->request->controller,
                'action' => 'index',
                $this->request->params['named']['menu_id']
            ) , true));
        } else {
            $this->redirect(Router::url(array(
                'controller' => $this->request->controller,
                'action' => 'index',
            ) , true));
        }
    }
    public function isAutoSuspendEnabled($model)
    {
        if (Configure::read('suspicious_detector.is_enabled') && Configure::read('suspicious_detector.auto_suspend_' . $model . '_on_system_flag')) {
            return 1;
        } else {
            return 0;
        }
    }
    public function show_captcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new securimage();
        $img->show(); // alternate use:  $img->show('/path/to/background.jpg');
        $this->autoRender = false;
    }
    public function captcha_play($session_var = null)
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        $img->session_var = $session_var;
        $this->disableCache();
        $this->RequestHandler->respondAs('mp3', array(
            'attachment' => 'captcha.mp3'
        ));
        $img->audio_format = 'mp3';
        echo $img->getAudibleCode('mp3');
        $this->autoRender = false;
    }
    public function autocomplete($param_encode = null, $param_hash = null)
    {
        $modelClass = Inflector::singularize($this->name);
        $conditions = false;
        if (isset($this->{$modelClass}->_schema['is_active'])) {
            $conditions['is_active'] = '1';
        }
        $this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
	function _friend_referral()
    {
        if (!empty($this->request->params['named']['r'])) {
            $this->loadModel('User');
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r'],
                    'User.is_affiliate_user' => 1
                ) ,
                'fields' => array(
                    'User.username',
                    'User.id'
                ) ,
                'recursive' => -1
            ));
            if (!empty($user)) {
                $this->Cookie->delete('referrer');
                $this->Cookie->write('referrer', $user['User']['id'], false, '+5 hours');
				$_SESSION['refer_id'] = $user['User']['id'];
				$r_value = $this->request->params['named']['r'];
				unset($this->request->params['named']['r']);
                $params = '';
                foreach($this->request->params['pass'] as $value) {
                    $params.= $value . '/';
                }
                foreach($this->request->params['named'] as $key => $value) {
                    $params.= $key . ':' . $value . '/';
                }
                $this->redirect(array(
                    'controller' => $this->request->params['controller'],
                    'action' => $this->request->params['action'],
					'r_value' => $r_value,
                    $params
                ));
            }
        }
    }
}
