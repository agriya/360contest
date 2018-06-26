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
class UsersController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Users';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $components = array(
        'Email',
        'PersistentLogin',
    );
    public $uses = array(
        'User',
        'EmailTemplate'
    );
    public $helpers = array(
        'Csv'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'index',
            'show_header',
            'dashboard',
            'change_password',
        ) ,
        'is_view_count_update' => true
    );
    public function show_header()
    {
        $this->disableCache();
    }
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'User.send_to_user_id',
            'adcopy_response',
            'adcopy_challenge'
        );
        parent::beforeFilter();
    }
    public function beforeRender()
    {
        parent::beforeRender();
        if (in_array($this->request->params['action'], array(
            'admin_login',
            'login'
        ))) {
            if (!empty($this->request->data)) {
                $field = $this->Auth->fields['username'];
                $cacheName = 'auth_failed_' . (!empty($this->request->data['User'][$field]) ? $this->request->data['User'][$field] : '');
                $cacheValue = Cache::read($cacheName, 'users_login');
                Cache::write($cacheName, (int)$cacheValue+1, 'users_login');
            }
        }
    }
    public function admin_index()
    {
        $this->_redirectPOST2Named(array(
            'User.from_date',
            'User.to_date',
            'User.q',
        ));
        $this->disableCache();
        $this->set('title_for_layout', __l('Users', true));
        $conditions = array();
        $this->pageTitle = __l('Users');
        if (isPluginEnabled('UserFlags')) {
            $this->loadModel('UserFlags.UserFlag');
        }
        if (!empty($this->request->params['named']['main_filter_id'])) {
            if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Facebook) {
                $conditions['User.is_facebook_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Facebook ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.is_twitter_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Twitter ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_google_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Gmail ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::GooglePlus) {
                $conditions['User.is_googleplus_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Google+ ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Yahoo ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::LinkedIn) {
                $conditions['User.is_linkedin_register'] = 1;
                $this->pageTitle.= __l(' - Registered through Yahoo ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::Admin) {
                $conditions['User.role_id'] = ConstUserTypes::Admin;
                $this->pageTitle.= __l(' - Admin ');
            }
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if (isPluginEnabled('LaunchModes') && !empty($this->request->data['User']['filter_id']) && $this->request->data['User']['filter_id'] == ConstMoreAction::Prelaunch) {
                $conditions['User.site_state_id'] = ConstSiteState::Prelaunch;
                $this->pageTitle.= ' - ' . __l('Pre-launch Users');
            } else if (isPluginEnabled('LaunchModes') && !empty($this->request->data['User']['filter_id']) && $this->request->data['User']['filter_id'] == ConstMoreAction::PrivateBeta) {
                $conditions['User.site_state_id'] = ConstSiteState::PrivateBeta;
                $this->pageTitle.= ' - ' . __l('Private Beta Users');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Flagged) {
                $flaggedUserIds = $this->UserFlag->find('list', array(
                    'fields' => array(
                        'UserFlag.other_user_id'
                    ) ,
                    'recursive' => -1
                ));
                $conditions['User.id'] = $flaggedUserIds;
                $this->pageTitle.= __l(' - User Flagged ');
            }
        }
        if (!empty($this->request->data['User']['from_date']['year']) && !empty($this->request->data['User']['from_date']['month']) && !empty($this->request->data['User']['from_date']['day'])) {
            $this->request->params['named']['from_date'] = $this->request->data['User']['from_date']['year'] . '-' . $this->request->data['User']['from_date']['month'] . '-' . $this->request->data['User']['from_date']['day'] . ' 00:00:00';
        }
        if (!empty($this->request->data['User']['to_date']['year']) && !empty($this->request->data['User']['to_date']['month']) && !empty($this->request->data['User']['to_date']['day'])) {
            $this->request->params['named']['to_date'] = $this->request->data['User']['to_date']['year'] . '-' . $this->request->data['User']['to_date']['month'] . '-' . $this->request->data['User']['to_date']['day'] . ' 23:59:59';
        }
        if (isset($this->request->data['User']['from_date']) and isset($this->request->data['User']['to_date'])) {
            $from_date = $this->request->data['User']['from_date']['year'] . '-' . $this->request->data['User']['from_date']['month'] . '-' . $this->request->data['User']['from_date']['day'] . ' 00:00:00';
            $to_date = $this->request->data['User']['to_date']['year'] . '-' . $this->request->data['User']['to_date']['month'] . '-' . $this->request->data['User']['to_date']['day'] . ' 23:59:59';
        }
        if (!empty($this->request->params['named']['from_date']) && !empty($this->request->params['named']['to_date'])) {
            if ($this->request->params['named']['from_date'] < $this->request->params['named']['to_date']) {
                $conditions['User.created >='] = $this->request->params['named']['from_date'];
                $conditions['User.created <='] = $this->request->params['named']['to_date'];
                $credit_conditions['User.created >='] = $this->request->params['named']['from_date'];
                $credit_conditions['User.created <='] = $this->request->params['named']['to_date'];
                $debit_conditions['User.created >='] = $this->request->params['named']['from_date'];
                $debit_conditions['User.created <='] = $this->request->params['named']['to_date'];
            } else {
                $this->Session->setFlash(__l('To date should greater than From date. Please, try again.') , 'default', null, 'error');
            }
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%',
                    ) ,
                    array(
                        'User.email LIKE ' => '%' . $this->params['named']['q'] . '%',
                    ) ,
                )
            );
            $this->request->data['User']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if ($this->RequestHandler->ext == 'csv') {
            Configure::write('debug', 0);
            $this->set('user', $this);
            $this->set('conditions', $conditions);
            if (isset($this->request->data['User']['q'])) {
                $this->set('q', $this->request->data['User']['q']);
            }
        } else {
            $this->paginate = array(
                'conditions' => $conditions,
                'contain' => array(
                    'LastLoginIp' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'Timezone' => array(
                            'fields' => array(
                                'Timezone.name',
                            )
                        ) ,
                        'fields' => array(
                            'LastLoginIp.ip',
                            'LastLoginIp.host',
                            'LastLoginIp.latitude',
                            'LastLoginIp.longitude'
                        )
                    ) ,
                    'Ip' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name',
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2',
                            )
                        ) ,
                        'fields' => array(
                            'Ip.ip',
                            'Ip.latitude',
                            'Ip.longitude',
                            'Ip.host'
                        )
                    ) ,
                    'Transaction' => array(
                        'fields' => array(
                            'Transaction.amount',
                        ) ,
                        'conditions' => array(
                            'Transaction.transaction_type_id' => ConstTransactionTypes::SignupFee
                        )
                    ) ,
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.created',
                            'UserProfile.first_name',
                            'UserProfile.last_name',
                            'UserProfile.middle_name',
                            'UserProfile.about_me',
                            'UserProfile.dob',
                            'UserProfile.address',
                            'UserProfile.zip_code',
                        ) ,
                        'Gender' => array(
                            'fields' => array(
                                'Gender.name'
                            )
                        ) ,
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'Language' => array(
                            'fields' => array(
                                'Language.id',
                                'Language.name',
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        ) ,
                        'Country' => array(
                            'fields' => array(
                                'Country.name',
                                'Country.iso_alpha2'
                            )
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserFlag'
                ) ,
                'order' => array(
                    'User.id' => 'desc'
                ) ,
                'recursive' => 2
            );
            $this->set('users', $this->paginate());
            // total approved users list
            $this->set('active', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_active' => 1,
                ) ,
                'recursive' => -1
            )));
            // total approved users list
            $this->set('inactive', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_active' => 0,
                ) ,
                'recursive' => -1
            )));
            // total openid users list
            $this->set('openid', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_openid_register' => 1,
                ) ,
                'recursive' => -1
            )));
            // total facebook users list
            $this->set('facebook', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                ) ,
                'recursive' => -1
            )));
            // total twitter users list
            $this->set('twitter', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_twitter_register' => 1,
                ) ,
                'recursive' => -1
            )));
            // total gmail users list
            $this->set('gmail', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_google_register' => 1,
                ) ,
                'recursive' => -1
            )));
            // total gogoleplus users list
            $this->set('googleplus', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_googleplus_register' => 1,
                    'User.role_id = ' => ConstUserTypes::User
                ) ,
                'recursive' => -1
            )));
            // total yahoo users list
            $this->set('yahoo', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_yahoo_register' => 1,
                ) ,
                'recursive' => -1
            )));
            // total linkedin users list
            $this->set('linkedin', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_linkedin_register' => 1,
                ) ,
                'recursive' => -1
            )));
            // total admin users list
            $this->set('admin', $this->User->find('count', array(
                'conditions' => array(
                    'User.role_id' => ConstUserTypes::Admin,
                ) ,
                'recursive' => -1
            )));
            $this->set('idle_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_idle' => 1
                ) ,
                'recursive' => -1
            )));
            $this->set('contest_posted_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_contest_posted' => 1
                ) ,
                'recursive' => -1
            )));
            $this->set('entry_posted_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_entry_posted' => 1
                ) ,
                'recursive' => -1
            )));
            $this->set('engaged_users', $this->User->find('count', array(
                'conditions' => array(
                    'User.is_engaged' => 1
                ) ,
                'recursive' => -1
            )));
            if (isPluginEnabled('UserFlags')) {
                // total flagged users list
                $this->set('flagged_users', $this->UserFlag->find('count', array(
                    'recursive' => -1
                )));
            }
            if (isPluginEnabled('LaunchModes')) {
                $this->loadModel('LaunchModes.Subscription');
                // total pre-launch users list
                $this->set('prelaunch_users', $this->User->find('count', array(
                    'conditions' => array(
                        'User.site_state_id' => ConstSiteState::Prelaunch
                    ) ,
                    'recursive' => -1
                )));
                // total privatebeta users list
                $this->set('privatebeta_users', $this->User->find('count', array(
                    'conditions' => array(
                        'User.site_state_id' => ConstSiteState::PrivateBeta
                    ) ,
                    'recursive' => -1
                )));
                // total pre-launch subscribed users list
                $this->set('prelaunch_subscribed', $this->Subscription->find('count', array(
                    'conditions' => array(
                        'Subscription.site_state_id = ' => ConstSiteState::Prelaunch
                    ) ,
                    'recursive' => -1
                )));
                // total privatebeta subscribed users list
                $this->set('privatebeta_subscribed', $this->Subscription->find('count', array(
                    'conditions' => array(
                        'Subscription.site_state_id = ' => ConstSiteState::PrivateBeta
                    ) ,
                    'recursive' => -1
                )));
            }
            $moreActions = $this->User->moreActions;
            $this->set(compact('moreActions'));
        }
    }
    public function dashboard()
    {
        $this->pageTitle = __l('Dashboard');
    }
    public function admin_login()
    {
        $this->setAction('login');
    }
    public function admin_logout()
    {
        $this->setAction('logout');
    }
    public function admin_stats()
    {
        $this->pageTitle = __l('Snapshot');
    }
    public function index()
    {
        $this->pageTitle = __l('Top') . ' ' . Configure::read('contest.participant_alt_name_plural_caps');
        $conditions['User.role_id !='] = ConstUserTypes::Admin;
        if (isset($this->request->params['named']['user_id'])) {
            $user_id = $this->request->params['named']['user_id'];
        } else {
            $user_id = $this->Auth->user('id');
        }
        if (!empty($this->request->params['named']['type'])) {
            $this->pageTitle = __l('Followed') . ' ' . Configure::read('contest.participant_alt_name_plural_caps');
            $userFavorites = $this->User->UserFavorite->find('list', array(
                'conditions' => array(
                    'UserFavorite.user_id' => $user_id
                ) ,
                'fields' => array(
                    'UserFavorite.id',
                    'UserFavorite.user_favorite_id',
                ) ,
                'recursive' => -1
            ));
            $conditions['User.id'] = array_values($userFavorites);
        } else {
            $conditions['User.contest_user_count !='] = 0;
            $conditions['User.is_active'] = 1;
        }
        $contain = array(
            'UserProfile' => array(
                'Country'
            ) ,
            'ContestUser' => array(
                'conditions' => array(
                    'ContestUser.admin_suspend' => 0
                )
            )
        );
        if (isPluginEnabled('UserFavourites')) {
            $UserFavourites_contain = array(
                'FavoriteUser' => array(
                    'conditions' => array(
                        'FavoriteUser.user_id' => $user_id,
                    )
                )
            );
            $contain = array_merge($contain, $UserFavourites_contain);
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => $contain,
            'fields' => array(
                'User.id',
                'User.created',
                'User.last_logged_in_time',
                'User.contest_user_count',
                'User.role_id',
                'User.username',
                'User.contest_user_won_count',
                'User.average_rating',
            ) ,
            'order' => array(
                'User.contest_user_won_count' => 'desc',
                'User.average_rating' => 'desc',
            ) ,
            'recursive' => 2
        );
        $this->set('users', $this->paginate());
    }
    public function reset($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Reset Password');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_active' => 1,
            ) ,
            'fields' => array(
                'User.id',
                'User.username',
                'date(User.pwd_reset_requested_date) as request_date',
                'User.security_question_id',
                'User.security_answer',
                'User.pwd_reset_requested_date',
                'User.pwd_reset_token',
                'User.email',
            ) ,
            'recursive' => -1
        ));
        $expected_date_diff = strtotime('now') -strtotime($user['User']['pwd_reset_requested_date']);
        if (empty($user) || empty($user['User']['pwd_reset_token']) || ($expected_date_diff < 0)) {
            $this->Session->setFlash(__l('Invalid request'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
        if (isPluginEnabled('SecurityQuestions')) {
            $security_questions = $this->User->SecurityQuestion->find('first', array(
                'conditions' => array(
                    'SecurityQuestion.id' => $user['User']['security_question_id']
                )
            ));
        }
        $this->set('user_id', $user_id);
        $this->set('hash', $hash);
        if (!empty($this->request->data)) {
            if (isset($this->request->data['User']['security_answer']) && isPluginEnabled('SecurityQuestions')) {
                if (strcmp($this->request->data['User']['security_answer'], $user['User']['security_answer'])) {
                    $this->Session->setFlash(__l('Sorry incorrect answer. Please try again') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'reset',
                        $user_id,
                        $hash
                    ));
                }
            } else {
                if ($this->User->isValidResetPasswordHash($this->request->data['User']['user_id'], $this->request->data['User']['hash'], $user[0]['request_date'])) {
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        $this->User->updateAll(array(
                            'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                            'User.pwd_reset_token' => '\'' . '' . '\'',
                        ) , array(
                            'User.id' => $this->request->data['User']['user_id']
                        ));
                        $emailFindReplace = array(
                            '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                            '##USERNAME##' => $user['User']['username']
                        );
                        App::import('Model', 'EmailTemplate');
                        $this->EmailTemplate = new EmailTemplate();
                        $template = $this->EmailTemplate->selectTemplate('Password Changed');
                        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                        $this->Session->setFlash(__l('Your password has been changed successfully, Please login now') , 'default', null, 'success');
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'login'
                        ));
                    }
                    $this->request->data['User']['passwd'] = '';
                    $this->request->data['User']['confirm_password'] = '';
                } else {
                    $this->Session->setFlash(__l('Invalid change password request'));
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
            }
        } else {
            if (is_null($user_id) or is_null($hash)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            if (empty($user)) {
                $this->Session->setFlash(__l('User cannot be found in server or admin deactivated your account, please register again'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register'
                ));
            }
            if (!$this->User->isValidResetPasswordHash($user_id, $hash, $user[0]['request_date'])) {
                $this->Session->setFlash(__l('Invalid request'));
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            $this->request->data['User']['user_id'] = $user_id;
            $this->request->data['User']['hash'] = $hash;
            if (isPluginEnabled('SecurityQuestions') && !empty($user['User']['security_question_id']) && !empty($user['User']['security_answer'])) {
                $this->set('security_questions', $security_questions);
                $this->render('check_security_question');
            }
        }
    }
    public function register($type = null)
    {
        // When already logged user trying to access the registration page we are redirecting to site home page
        if ($this->Auth->user()) {
            $this->redirect('/');
        }
        $is_register = 1;
        if (isPluginEnabled('LaunchModes')) {
            $this->loadModel('LaunchModes.Subscription');
        }
        $this->pageTitle = __l('User Registration');
        $captcha_flag = $third_party_flag = 1;
        $socialuser = $this->Session->read('socialuser');
        if (!empty($socialuser) && empty($this->request->data)) {
            $this->Session->delete('socialuser');
            $this->request->data['User'] = $socialuser;
            $captcha_flag = 0;
        }
        if (isPluginEnabled('LaunchModes')) {
            if (Configure::read('site.launch_mode') == "Private Beta" && !empty($this->request->data) || !empty($_SESSION['invite_hash'])) {
                if (!empty($_SESSION['invite_hash'])) {
                } elseif (isset($this->request->data['User']['invite_hash']) && !empty($this->request->data['User']['invite_hash'])) {
                    $is_valid = $this->Subscription->find('count', array(
                        'conditions' => array(
                            'Subscription.invite_hash' => $this->request->data['User']['invite_hash']
                        ) ,
                        'recursive' => -1
                    ));
                    if ($is_valid) {
                        $this->Session->setFlash(sprintf(__l('You have submitted invitation code successfully, Welcome to %s') , Configure::read('site.name')) , 'default', null, 'success');
                        unset($this->request->data['User']);
                    }
                }
            } elseif (Configure::read('site.launch_mode') == "Private Beta") {
                if (empty($socialuser)) {
                    $this->redirect(Router::url('/', true));
                    $is_register = 0;
                }
            }
        }
        if ($is_register) {
            if (!empty($this->request->data)) {
                //Captcha validation
                if (!$this->User->_isValidCaptchaSolveMedia()) {
                    $captcha_error = 1;
                }
                if (Configure::read('system.captcha_type') == "Basic" || !empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_twitter_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_googleplus_register']) || empty($captcha_flag)) {
                    $captcha_error = 0;
                }
                if (empty($captcha_error)) {
                    $this->User->set($this->request->data);
                    if ($this->User->validates()) {
                        $this->User->create();
                        if (!empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_twitter_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_googleplus_register'])) {
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['email'] . Configure::read('Security.salt'));
                            //For open id register no need for email confirm, this will override is_email_verification_for_register setting
                            $this->request->data['User']['is_agree_terms_conditions'] = 1;
                            $this->request->data['User']['is_email_confirmed'] = 1;
                        } else {
                            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
                            $this->request->data['User']['is_email_confirmed'] = (Configure::read('user.is_email_verification_for_register')) ? 0 : 1;
                        }
                        $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
                        $this->request->data['User']['role_id'] = ConstUserTypes::User;
                        if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                            $this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
                        }
                        $this->request->data['User']['signup_ip_id'] = $this->User->toSaveIp();
                        if (isPluginEnabled('LaunchModes')) {
                            if (Configure::read('site.launch_mode') == 'Private Beta' && isset($_SESSION['invite_hash'])) {
                                $Subscription = $this->Subscription->find('first', array(
                                    'fields' => array(
                                        'Subscription.id',
                                        'Subscription.site_state_id'
                                    ) ,
                                    'conditions' => array(
                                        'Subscription.invite_hash' => $_SESSION['invite_hash']
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->request->data['User']['is_sent_private_beta_mail'] = 1;
                                if (!empty($Subscription)) {
                                    $this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];
                                } else {
                                    $this->request->data['User']['site_state_id'] = ConstSiteState::PrivateBeta;
                                }
                            } else {
                                $Subscription = $this->Subscription->find('first', array(
                                    'fields' => array(
                                        'Subscription.id',
                                        'Subscription.site_state_id'
                                    ) ,
                                    'conditions' => array(
                                        'Subscription.email' => $this->request->data['User']['email']
                                    ) ,
                                    'recursive' => -1
                                ));
                                if (!empty($Subscription)) {
                                    $this->request->data['User']['site_state_id'] = $Subscription['Subscription']['site_state_id'];;
                                } else {
                                    $this->request->data['User']['site_state_id'] = ConstSiteState::Launch;
                                }
                            }
                        }
                        if ($this->User->save($this->request->data, false)) {
                            if (!empty($this->request->data['City']['name'])) {
                                $this->request->data['UserProfile']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->User->UserProfile->City->findOrSaveAndGetId($this->request->data['City']['name']);
                            }
                            if (!empty($this->request->data['State']['name'])) {
                                $this->request->data['UserProfile']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->User->UserProfile->State->findOrSaveAndGetId($this->request->data['State']['name']);
                            }
                            if (!empty($this->request->data['UserProfile']['country_iso_code'])) {
                                $this->request->data['UserProfile']['country_id'] = $this->User->UserProfile->Country->findCountryIdFromIso2($this->request->data['UserProfile']['country_iso_code']);
                                if (empty($this->request->data['UserProfile']['country_id'])) {
                                    unset($this->request->data['UserProfile']['country_id']);
                                }
                            }
                            $this->request->data['UserProfile']['user_id'] = $this->User->getLastInsertId();
                            $this->User->UserProfile->set($this->request->data);
                            $this->User->UserProfile->create();
                            $this->User->UserProfile->save($this->request->data);
                            if ($referred_by_user_id = $this->Cookie->read('referrer')) {
                                $referredUser = $this->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $referred_by_user_id
                                    ) ,
                                    'recursive' => -1
                                ));
                                $this->request->data['User']['referred_by_user_id'] = $referred_by_user_id;
                                $this->_referer_follow($this->User->id, $referred_by_user_id, $this->request->data['User']['username']);
                                $this->_referer_follow($referred_by_user_id, $this->User->id, $referredUser['User']['username']);
                            }
                            if (isPluginEnabled('LaunchModes')) {
                                //Update the subscription table
                                if (!empty($Subscription)) {
                                    $this->request->data['Subscription']['user_id'] = $this->User->id;
                                    $this->request->data['Subscription']['id'] = $Subscription['Subscription']['id'];
                                    $this->Subscription->save($this->request->data);
                                }
                                unset($_SESSION['invite_hash']);
                            }
                            // send to admin mail if is_admin_mail_after_register is true
                            if (Configure::read('user.is_admin_mail_after_register')) {
                                $emailFindReplace = array(
                                    '##USERNAME##' => $this->request->data['User']['username'],
                                );
                                // Send e-mail to users
                                App::import('Model', 'EmailTemplate');
                                $this->EmailTemplate = new EmailTemplate();
                                $template = $this->EmailTemplate->selectTemplate('New User Join');
                                $this->User->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
                            }
                            if (!empty($this->request->data['User']['openid_url'])) {
                                $this->User->UserOpenid->create();
                                $this->request->data['UserOpenid']['openid'] = $this->request->data['User']['openid_url'];
                                $this->request->data['UserOpenid']['user_id'] = $this->User->id;
                                $this->User->UserOpenid->save($this->request->data);
                            }
                            if (Configure::read('user.signup_fee')) {
                                $is_third_party_register = 0;
                                if (!empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_twitter_register'])) {
                                    $is_third_party_register = 1;
                                    // send welcome mail to user if is_welcome_mail_after_register is true
                                    if (Configure::read('user.is_welcome_mail_after_register')) {
                                        $this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                    }
                                } else {
                                    $is_third_party_register = 0;
                                    if (Configure::read('user.is_email_verification_for_register')) {
                                        $this->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                                    }
                                }
                                $this->_sendMembershipMail($this->User->id, $this->User->getActivateHash($this->User->id));
                                if (Configure::read('user.is_admin_activate_after_register') && Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification and administrator approval, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
                                } else if (Configure::read('user.is_admin_activate_after_register')) {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site after administrator approval you can login to site, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
                                } else if (Configure::read('user.is_email_verification_for_register') && empty($is_third_party_register)) {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login after email verification, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
                                } else {
                                    $this->Session->setFlash(__l(' You have successfully registered with our site you can login now, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
                                }
                                $this->redirect(array(
                                    'controller' => 'payments',
                                    'action' => 'membership_pay_now',
                                    $this->User->id,
                                    $this->User->getActivateHash($this->User->id)
                                ));
                            } else {
                                $user = $this->User->find('first', array(
                                    'conditions' => array(
                                        'User.id' => $this->User->id
                                    ) ,
                                    'recursive' => -1
                                ));
                                if (!empty($this->request->data['User']['is_linkedin_register'])) {
                                    $label = 'LinkedIn';
                                } else if (!empty($this->request->data['User']['is_facebook_register'])) {
                                    $label = 'Facebook';
                                } else if (!empty($this->request->data['User']['is_twitter_register'])) {
                                    $label = 'Twitter';
                                } else if (!empty($this->request->data['User']['is_yahoo_register'])) {
                                    $label = 'Yahoo!';
                                } else if (!empty($this->request->data['User']['is_google_register'])) {
                                    $label = 'Gmail';
                                } else if (!empty($this->request->data['User']['is_googleplus_register'])) {
                                    $label = 'GooglePlus';
                                } else if (!empty($this->request->data['User']['is_angellist_register'])) {
                                    $label = 'AngelList';
                                } else {
                                    $label = 'Direct';
                                }
                                Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                    '_trackEvent' => array(
                                        'category' => 'User',
                                        'action' => 'Registered',
                                        'label' => $label,
                                        'value' => '',
                                    ) ,
                                    '_setCustomVar' => array(
                                        'ud' => $user['User']['id'],
                                        'rud' => $user['User']['referred_by_user_id'],
                                    )
                                ));
                                if (!empty($user['User']['referred_by_user_id'])) {
                                    $referredUser = $this->User->find('first', array(
                                        'conditions' => array(
                                            'User.id' => $user['User']['referred_by_user_id']
                                        ) ,
                                        'recursive' => -1
                                    ));
                                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                                        '_trackEvent' => array(
                                            'category' => 'User',
                                            'action' => 'Referred',
                                            'label' => $referredUser['User']['username'],
                                            'value' => '',
                                        ) ,
                                        '_setCustomVar' => array(
                                            'ud' => $user['User']['id'],
                                            'rud' => $user['User']['referred_by_user_id'],
                                        )
                                    ));
                                }
                                if (Configure::read('user.is_admin_activate_after_register')) {
                                    $this->Session->setFlash(__l('You have successfully registered with our site. after administrator approval you can login to site') , 'default', null, 'success');
                                } else {
                                    $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                                }
                                if (!empty($this->request->data['User']['is_openid_register']) || !empty($this->request->data['User']['is_linkedin_register']) || !empty($this->request->data['User']['is_google_register']) || !empty($this->request->data['User']['is_yahoo_register']) || !empty($this->request->data['User']['is_facebook_register']) || !empty($this->request->data['User']['is_twitter_register'])) {
                                    // send welcome mail to user if is_welcome_mail_after_register is true
                                    if (Configure::read('user.is_welcome_mail_after_register')) {
                                        $this->_sendWelcomeMail($this->User->id, $this->request->data['User']['email'], $this->request->data['User']['username']);
                                    }
                                    if ($this->Auth->login()) {
                                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                    }
                                } else {
                                    //For openid register no need to send the activation mail, so this code placed in the else
                                    if (Configure::read('user.is_email_verification_for_register')) {
                                        $this->Session->setFlash(__l('You have successfully registered with our site and your activation mail has been sent to your mail inbox.') , 'default', null, 'success');
                                        $this->_sendActivationMail($this->request->data['User']['email'], $this->User->id, $this->User->getActivateHash($this->User->id));
                                    }
                                }
                                if (!Configure::read('user.is_email_verification_for_register') and Configure::read('user.is_auto_login_after_register')) {
                                    $this->Session->setFlash(__l('You have successfully registered with our site.') , 'default', null, 'success');
                                    if ($this->Auth->login()) {
                                        $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                                        $this->redirect(array(
                                            'controller' => 'user_profiles',
                                            'action' => 'edit'
                                        ));
                                    }
                                }
                                if ($this->Auth->user('id')) {
                                    $this->redirect(array(
                                        'controller' => 'contests',
                                        'action' => 'browse',
                                    ));
                                } else {
                                    $this->redirect(array(
                                        'controller' => 'users',
                                        'action' => 'login'
                                    ));
                                }
                            }
                        }
                    } else {
                        if (empty($this->request->data['User']['email'])) {
                            $this->User->validationErrors['email'] = __l('Required');
                        }
                        unset($this->request->data['User']['captcha']);
                        if (!empty($this->request->data['User']['provider'])) {
                            if (!empty($this->request->data['User']['is_google_register'])) {
                                $flash_verfy = 'Gmail';
                            } else if (!empty($this->request->data['User']['is_googleplus_register'])) {
                                $flash_verfy = 'GooglePlus';
                            } elseif (!empty($this->request->data['User']['is_yahoo_register'])) {
                                $flash_verfy = 'Yahoo!';
                            } else {
                                $flash_verfy = $this->request->data['User']['provider'];
                            }
                            $this->Session->setFlash($flash_verfy . ' ' . __l('verification is completed successfully. But you have to fill the following required fields to complete our registration process.') , 'default', null, 'success');
                        } else {
                            $this->Session->setFlash(__l('Your registration process is not completed. Please, try again.') , 'default', null, 'error');
                        }
                    }
                } else {
                    $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
                }
            }
            unset($this->request->data['User']['passwd']);
            // geocode variables
            if (!empty($_COOKIE['_geo']) && empty($this->request->data['UserProfile']['country_iso_code'])) {
                $_geo = explode('|', $_COOKIE['_geo']);
                $this->request->data['UserProfile']['country_iso_code'] = $_geo[0];
                $this->request->data['State']['name'] = $_geo[1];
                $this->request->data['City']['name'] = $_geo[2];
            }
            if (isPluginEnabled('SecurityQuestions')) {
                $this->loadModel('SecurityQuestions.SecurityQuestion');
                $securityQuestions = $this->SecurityQuestion->find('list', array(
                    'conditions' => array(
                        'SecurityQuestion.is_active' => 1
                    )
                ));
                $this->set(compact('securityQuestions'));
            }
            if (empty($type)) {
                $this->render('social');
            }
        }
        if (!$is_register && empty($socialuser)) {
            $this->layout = 'subscription';
            $this->render('invite_page');
        }
    }
    public function _openid()
    {
        //open id component included
        App::import('Core', 'ComponentCollection');
        $collection = new ComponentCollection();
        App::import('Component', 'Openid');
        $this->Openid = new OpenidComponent($collection);
        $returnTo = Router::url(array(
            'controller' => 'users',
            'action' => $this->request->data['User']['redirect_page']
        ) , true);
        $siteURL = Router::url('/', true);
        // send openid url and fields return to our server from openid
        if (!empty($this->request->data)) {
            try {
                $this->Openid->authenticate($this->request->data['User']['openid'], $returnTo, $siteURL, array(
                    'email',
                    'nickname'
                ) , array());
            }
            catch(InvalidArgumentException $e) {
                $this->Session->setFlash(__l('Invalid OpenID') , 'default', null, 'error');
            }
            catch(Exception $e) {
                $this->Session->setFlash(__l($e->getMessage()));
            }
        }
    }
    public function _sendActivationMail($user_email, $user_id, $hash)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.email' => $user_email
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##ACTIVATION_URL##' => Router::url(array(
                'controller' => 'users',
                'action' => 'activation',
                $user_id,
                $hash
            ) , true) ,
        );
        $template_name = '';
        if (!empty($this->request->params['action']) && $this->request->params['action'] == 'resend_activation') {
            $template_name = 'Reactivation';
        } else {
            $template_name = 'Activation Request';
        }
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate($template_name);
        $this->User->_sendEmail($template, $emailFindReplace, $user_email);
        return true;
    }
    public function _sendMembershipMail($user_id, $hash)
    {
        //send membership mail to users
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##MEMBERSHIP_URL##' => Router::url(array(
                'controller' => 'payments',
                'action' => 'membership_pay_now',
                $user['User']['id'],
                $hash,
                'admin' => false,
            ) , true) ,
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate('Membership Fee');
        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
    }
    public function _sendWelcomeMail($user_id, $user_email, $username)
    {
        $emailFindReplace = array(
            '##USERNAME##' => $username,
            '##CONTACT_MAIL##' => Configure::read('EmailTemplate.admin_email')
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate('Welcome Email');
        $this->User->_sendEmail($template, $emailFindReplace, $user_email);
    }
    public function activation($user_id = null, $hash = null)
    {
        $this->pageTitle = __l('Activate your account');
        if (is_null($user_id) or is_null($hash)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
                'User.is_email_confirmed' => 0
            ) ,
            'recursive' => -1
        ));
        if (empty($user)) {
            $this->Session->setFlash(__l('Invalid activation request, please register again'));
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register'
            ));
        }
        if (!$this->User->isValidActivateHash($user_id, $hash)) {
            $hash = $this->User->getResendActivateHash($user_id);
            $this->Session->setFlash(__l('Invalid activation request'));
            $this->set('show_resend', 1);
            $resend_url = Router::url(array(
                'controller' => 'users',
                'action' => 'resend_activation',
                $user_id,
                $hash
            ) , true);
            $this->set('resend_url', $resend_url);
        } else {
            $this->request->data['User']['id'] = $user_id;
            $this->request->data['User']['is_email_confirmed'] = 1;
            // admin will activate the user condition check
            if (!Configure::read('user.signup_fee') && empty($user['User']['is_active'])) {
                $this->request->data['User']['is_active'] = (Configure::read('user.is_admin_activate_after_register')) ? 0 : 1;
            }
            $this->User->save($this->request->data);
            // active is false means redirect to home page with message
            if (!$user['User']['is_active']) {
                if ((Configure::read('user.signup_fee') && $user['User']['is_paid'] == 0) || !Configure::read('user.is_admin_activate_after_register')) {
                    $this->Session->setFlash(__l('You have successfully activated your account. You can login now, but you can able to access all features after paying signup fee.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'payments',
                        'action' => 'membership_pay_now',
                        $user['User']['id'],
                        $this->User->getActivateHash($user['User']['id'])
                    ));
                } else {
                    $this->Session->setFlash(__l('You have successfully activated your account. But you can login after admin activate your account.') , 'default', null, 'success');
                }
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'login'
                ));
            }
            // send welcome mail to user if is_welcome_mail_after_register is true
            if (Configure::read('user.is_welcome_mail_after_register')) {
                $this->_sendWelcomeMail($user['User']['id'], $user['User']['email'], $user['User']['username']);
            }
            // after the user activation check script check the auto login value. it is true then automatically logged in
            if (Configure::read('user.is_auto_login_after_register')) {
                $this->Session->setFlash(__l('You have successfully activated and logged in to your account.') , 'default', null, 'success');
                $this->request->data['User']['email'] = $user['User']['email'];
                $this->request->data['User']['username'] = $user['User']['username'];
                $this->request->data['User']['password'] = $user['User']['password'];
                if ($this->Auth->login()) {
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    $this->redirect(array(
                        'controller' => 'user_profiles',
                        'action' => 'edit'
                    ));
                }
            }
            // user is active but auto login is false then the user will redirect to login page with message
            $this->Session->setFlash(sprintf(__l('You have successfully activated your account. Now you can login with your %s.') , Configure::read('user.using_to_login')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function resend_activation($user_id = null, $hash = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $hash = $this->User->getActivateHash($user_id);
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if ($this->_sendActivationMail($user['User']['email'], $user_id, $hash)) {
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                $this->Session->setFlash(__l('Activation mail has been resent.') , 'default', null, 'success');
            } else {
                $this->Session->setFlash(__l('A Mail for activating your account has been sent.') , 'default', null, 'success');
            }
        } else {
            $this->Session->setFlash(__l('Try some time later as mail could not be dispatched due to some error in the server') , 'default', null, 'error');
        }
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'index',
                'admin' => true
            ));
        } else {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'login'
            ));
        }
    }
    public function forgot_password()
    {
        $this->pageTitle = __l('Forgot Password');
        if ($this->Auth->user('id')) {
            $this->redirect('/');
        }
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            //Important: For forgot password unique email id check validation not necessary.
            unset($this->User->validate['email']['rule3']);
            $captcha_error = 0;
            if (!$this->RequestHandler->isAjax()) {
                if (Configure::read('user.is_enable_forgot_password_captcha') && Configure::read('system.captcha_type') == "Solve Media") {
                    if (!$this->User->_isValidCaptchaSolveMedia()) {
                        $captcha_error = 1;
                    }
                }
            }
            if (empty($captcha_error)) {
                if ($this->User->validates()) {
                    $user = $this->User->find('first', array(
                        'conditions' => array(
                            'User.email' => $this->request->data['User']['email'],
                            'User.is_active' => 1
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($user['User']['email'])) {
                        if (!empty($user['User']['is_openid_register']) || !empty($user['User']['is_yahoo_register']) || !empty($user['User']['is_google_register']) || !empty($user['User']['is_googleplus_register']) || !empty($user['User']['is_angellist_register']) || !empty($user['User']['is_facebook_register']) || !empty($user['User']['is_twitter_register'])) {
                            if (!empty($user['User']['is_yahoo_register'])) {
                                $site = __l('Yahoo!');
                            } elseif (!empty($user['User']['is_google_register'])) {
                                $site = __l('Gmail');
                            } elseif (!empty($user['User']['is_googleplus_register'])) {
                                $site = __l('GooglePlus');
                            } elseif (!empty($user['User']['is_angellist_register'])) {
                                $site = __l('AngelList');
                            } elseif (!empty($user['User']['is_openid_register'])) {
                                $site = __l('OpenID');
                            } elseif (!empty($user['User']['is_facebook_register'])) {
                                $site = __l('Facebook');
                            } elseif (!empty($user['User']['is_twitter_register'])) {
                                $site = __l('Twitter');
                            }
                            $emailFindReplace = array(
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                                '##OTHER_SITE##' => $site,
                                '##USERNAME##' => $user['User']['username'],
                            );
                            $email_template = "Failed Social User";
                        } else {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.email' => $user['User']['email']
                                ) ,
                                'recursive' => -1
                            ));
                            $reset_token = $this->User->getResetPasswordHash($user['User']['id']);
                            $this->User->updateAll(array(
                                'User.pwd_reset_token' => '\'' . $reset_token . '\'',
                                'User.pwd_reset_requested_date' => '\'' . date("Y-m-d H:i:s", time()) . '\'',
                            ) , array(
                                'User.id' => $user['User']['id']
                            ));
                            $this->log(Router::url(array(
                                'controller' => 'users',
                                'action' => 'reset',
                                $user['User']['id'],
                                $reset_token
                            ) , true));
                            $emailFindReplace = array(
                                '##USERNAME##' => $user['User']['username'],
                                '##FIRST_NAME##' => (isset($user['User']['first_name'])) ? $user['User']['first_name'] : '',
                                '##LAST_NAME##' => (isset($user['User']['last_name'])) ? $user['User']['last_name'] : '',
                                '##SITE_NAME##' => Configure::read('site.name') ,
                                '##SITE_URL##' => Router::url('/', true) ,
                                '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                                '##RESET_URL##' => Router::url(array(
                                    'controller' => 'users',
                                    'action' => 'reset',
                                    $user['User']['id'],
                                    $reset_token
                                ) , true)
                            );
                            $email_template = 'Forgot Password';
                        }
                    } else {
                        $email_template = 'Failed Forgot Password';
                        $emailFindReplace = array(
                            '##SITE_NAME##' => Configure::read('site.name') ,
                            '##SITE_URL##' => Router::url('/', true) ,
                            '##SUPPORT_EMAIL##' => Configure::read('EmailTemplate.admin_email') ,
                            '##user_email##' => $this->request->data['User']['email']
                        );
                    }
                    App::import('Model', 'EmailTemplate');
                    $this->EmailTemplate = new EmailTemplate();
                    $template = $this->EmailTemplate->selectTemplate($email_template);
                    $this->User->_sendEmail($template, $emailFindReplace, $this->request->data['User']['email']);
                    $this->Session->setFlash(__l('We have sent an email to ' . $this->request->data['User']['email'] . ' with further instructions.') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'login'
                    ));
                }
            } else {
                $this->Session->setFlash(__l('Please enter valid captcha') , 'default', null, 'error');
            }
        }
    }
    public function change_password($user_id = null)
    {
        $this->pageTitle = __l('Change Password');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['user_id']
                ) ,
                'fields' => array(
                    'User.username',
                    'User.email',
                    'User.password',
                ) ,
                'recursive' => -1
            ));
            if ($user['User']['password'] == crypt($this->request->data['User']['passwd'], $user['User']['password'])) {
                $this->Session->setFlash(__l('You can\'t use the old password as a new password.') , 'default', null, 'error');
            } else {
                if ($this->User->validates()) {
                    if ($this->User->updateAll(array(
                        'User.password' => '\'' . getCryptHash($this->request->data['User']['passwd']) . '\'',
                    ) , array(
                        'User.id' => $this->request->data['User']['user_id']
                    ))) {
                        if ($this->Auth->user('role_id') != ConstUserTypes::Admin && Configure::read('user.is_logout_after_change_password')) {
                            $this->Auth->logout();
                            $this->Session->setFlash(__l('Your password has been changed successfully. Please login now') , 'default', null, 'success');
                            $this->redirect(array(
                                'action' => 'login'
                            ));
                        } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->request->data['User']['user_id']) {
                            $emailFindReplace = array(
                                '##PASSWORD##' => $this->request->data['User']['passwd'],
                                '##USERNAME##' => $user['User']['username'],
                            );
                            // Send e-mail to users
                            App::import('Model', 'EmailTemplate');
                            $this->EmailTemplate = new EmailTemplate();
                            $template = $this->EmailTemplate->selectTemplate('Admin Change Password');
                            $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
                        }
                        if ($this->Auth->user('role_id') == ConstUserTypes::Admin && $this->Auth->user('id') != $this->request->data['User']['user_id']) {
                            $this->Session->setFlash(__l('User password has been changed successfully') , 'default', null, 'success');
                        } else {
                            $this->Session->setFlash(__l('Your password has been changed successfully') , 'default', null, 'success');
                        }
                    } else {
                        $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                    }
                } else {
                    $this->Session->setFlash(__l('Password could not be changed') , 'default', null, 'error');
                }
            }
            unset($this->request->data['User']['old_password']);
            unset($this->request->data['User']['passwd']);
            unset($this->request->data['User']['confirm_password']);
            if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                $this->redirect(array(
                    'action' => 'index',
                    'admin' => true
                ));
            }
        } else {
            if (empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
        }
        $conditions = array(
            'User.is_twitter_register' => 0,
            'User.is_facebook_register' => 0,
            'User.is_openid_register' => 0,
            'User.is_yahoo_register' => 0,
            'User.is_google_register' => 0,
            'User.is_linkedin_register' => 0,
        );
        if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            $users = $this->User->find('list', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            $this->set(compact('users'));
        }
        if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
            $conditions['User.id'] = $this->Auth->user('id');
            $user = $this->User->find('first', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->request->data['User']['user_id'] = (!empty($this->request->data['User']['user_id'])) ? $this->request->data['User']['user_id'] : $user_id;
    }
    public function login()
    {
        $socialuser = $this->Session->read('socialuser');
        if (!empty($socialuser)) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'register',
                'manual',
                'admin' => false,
            ));
        }
        $this->pageTitle = __l('Login');
        if ($this->Auth->user()) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
            ));
        }
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => Configure::read('facebook.is_enabled_facebook_connect') ,
                    'keys' => array(
                        'id' => Configure::read('facebook.fb_app_id') ,
                        'secret' => Configure::read('facebook.fb_secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => Configure::read('twitter.is_enabled_twitter_connect') ,
                    'keys' => array(
                        'key' => Configure::read('twitter.consumer_key') ,
                        'secret' => Configure::read('twitter.consumer_secret')
                    ) ,
                ) ,
                'Google' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('google.consumer_key') ,
                        'secret' => Configure::read('google.consumer_secret')
                    ) ,
                ) ,
                'GooglePlus' => array(
                    'enabled' => Configure::read('googleplus.is_enabled_googleplus_connect') ,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => Configure::read('yahoo.is_enabled_yahoo_connect') ,
                    'keys' => array(
                        'key' => Configure::read('yahoo.consumer_key') ,
                        'secret' => Configure::read('yahoo.consumer_secret')
                    ) ,
                ) ,
                'Openid' => array(
                    'enabled' => Configure::read('openid.is_enabled_openid_connect') ,
                ) ,
                'Linkedin' => array(
                    'enabled' => Configure::read('linkedin.is_enabled_linkedin_connect') ,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if (!empty($this->request->params['named']['type'])) {
            $options = array();
            $social_type = $this->request->params['named']['type'];
            if ($social_type == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
            try {
                require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
                $hybridauth = new Hybrid_Auth($config);
                if (!empty($this->request->params['named']['redirecting'])) {
                    $adapter = $hybridauth->authenticate(ucfirst($social_type) , $options);
                    $social_profile = $adapter->getUserProfile();
                    $social_profile = (array)$social_profile;
                    $social_profile['username'] = $social_profile['displayName'];
                    if ($social_type != 'openid') {
                        $session_data = $this->Session->read('HA::STORE');
                        if (!empty($session_data['hauth_session.' . $social_type . '.token.access_token'])) {
                            $social_profile[$social_type . '_access_token'] = unserialize($session_data['hauth_session.' . $social_type . '.token.access_token']);
                        }
                        if (!empty($session_data['hauth_session.' . $social_type . '.token.access_token_secret'])) {
                            $social_profile[$social_type . '_access_key'] = unserialize($session_data['hauth_session.' . $social_type . '.token.access_token_secret']);
                        }
                    }
                    $social_profile['provider'] = ucfirst($social_type);
                    $social_profile['is_' . $social_type . '_register'] = 1;
                    $social_profile[$social_type . '_user_id'] = $social_profile['identifier'];
                    $condition['User.' . $social_type . '_user_id'] = $social_profile['identifier'];
                    if ($social_type != 'openid') {
                        $condition['OR'] = array(
                            'User.is_' . $social_type . '_register' => 1,
                            'User.is_' . $social_type . '_connected' => 1
                        );
                    } else {
                        $condition['User.is_' . $social_type . '_register'] = 1;
                    }
                    $user = $this->User->find('first', array(
                        'conditions' => $condition,
                        'recursive' => -1
                    ));
                    $is_social = 0;
                    if (!empty($user)) {
                        $this->request->data['User']['username'] = $user['User']['username'];
                        $this->request->data['User']['password'] = $user['User']['password'];
                        $is_social = 1;
                    } else {
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $this->Session->write('socialuser', $social_profile);
                        if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
                            $this->redirect(Router::url(array(
                                'controller' => 'users',
                                'action' => 'register'
                            )));
                        } else {
                            echo '<script>window.close();</script>';
                            exit;
                        }
                    }
                } else {
                    $reditect = Router::url(array(
                        'controller' => 'users',
                        'action' => 'login',
                        'type' => $social_type,
                        'redirecting' => $social_type
                    ) , true);;
                    $this->layout = 'redirection';
                    $this->pageTitle.= ' - ' . ucfirst($social_type);
                    $this->set('redirect_url', $reditect);
                    $this->set('authorize_name', ucfirst($social_type));
                    $this->render('authorize');
                }
            }
            catch(Exception $e) {
                $error = "";
                switch ($e->getCode()) {
                    case 6:
                        $error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        break;

                    case 7:
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                        $error = __l("User not connected to the provider.");
                        break;

                    default:
                        $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection");
                        break;
                }
                $this->Session->setFlash($error, 'default', null, 'error');
                if (stripos(getenv('HTTP_HOST') , 'touch.') === 0) {
                    $this->redirect(Router::url(array(
                        'controller' => 'users',
                        'action' => 'register'
                    )));
                } else {
                    echo '<script>window.close();</script>';
                    exit;
                }
            }
        }
        // remember me for user
        if (!empty($this->request->data)) {
            $this->request->data['User'][Configure::read('user.using_to_login') ] = trim($this->request->data['User'][Configure::read('user.using_to_login') ]);
            //Important: For login unique username or email check validation not necessary. Also in login method authentication done before validation.
            unset($this->User->validate[Configure::read('user.using_to_login') ]['rule3']);
            $this->User->set($this->request->data);
            if ($this->User->validates()) {
                if (empty($social_type)) {
                    if (!empty($this->request->data['User'][Configure::read('user.using_to_login') ])) {
                        $user = $this->User->find('first', array(
                            'conditions' => array(
                                'User.' . Configure::read('user.using_to_login') => $this->request->data['User'][Configure::read('user.using_to_login') ]
                            ) ,
                            'recursive' => -1
                        ));
                        $this->request->data['User']['password'] = crypt($this->request->data['User']['passwd'], $user['User']['password']);
                    }
                }
                //$this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
                if ($this->Auth->login()) {
                    Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
                        '_trackEvent' => array(
                            'category' => 'User',
                            'action' => 'Loggedin',
                            'label' => $this->Auth->user('username') ,
                            'value' => '',
                        ) ,
                        '_setCustomVar' => array(
                            'ud' => $this->Auth->user('id') ,
                            'rud' => $this->Auth->user('referred_by_user_id') ,
                        )
                    ));
                    if (!empty($social_type) && ($social_type == 'twitter' || $social_type == 'linkedin') && !empty($social_profile['photoURL'])) {
                        $_data = array();
                        $_data['User']['id'] = $user['User']['id'];
                        if ($social_type == 'twitter') {
                            $_data['User']['twitter_avatar_url'] = $social_profile['photoURL'];
                        } else if ($social_type == 'linkedin') {
                            $_data['User']['linkedin_avatar_url'] = $social_profile['photoURL'];
                        }
                        $this->User->save($_data);
                    }
                    if (!empty($social_type)) {
                        $this->Session->delete('HA::CONFIG');
                        $this->Session->delete('HA::STORE');
                    }
                    $this->User->UserLogin->insertUserLogin($this->Auth->user('id'));
                    if ($this->Auth->user()) {
                        if (!empty($this->request->data['User']['is_remember'])) {
                            $user = $this->User->find('first', array(
                                'conditions' => array(
                                    'User.id' => $this->Auth->user('id')
                                ) ,
                                'recursive' => -1
                            ));
                            $this->PersistentLogin->_persistent_login_create_cookie($user, $this->request->data);
                        }
                        if (!empty($is_social)) {
                            echo '<script>window.close();</script>';
                            exit;
                        }
                        if (!empty($this->request->data['User']['f']) and !$this->RequestHandler->isAjax()) {
                            $this->redirect(Router::url('/', true) . $this->request->data['User']['f']);
                        } elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'stats',
                                'prefix' => 'admin',
                                'admin' => true
                            ));
                        } else {
                            $this->redirect(array(
                                'controller' => 'users',
                                'action' => 'dashboard',
                                'admin' => false
                            ));
                        }
                    }
                } else {
                    $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
                }
            } else {
                $this->Session->setFlash($this->Auth->loginError, 'default', null, 'error');
            }
        }
        //When already logged user trying to access the login page we are redirecting to site home page
        if ($this->Auth->user()) {
            if ($this->RequestHandler->isAjax()) {
                echo 'success';
                exit;
            } else {
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'dashboard',
                    'admin' => false
                ));
            }
        }
        $this->request->data['User']['passwd'] = '';
    }
    public function logout()
    {
        if ($this->Auth->user('facebook_user_id')) {
            // Quick fix for facebook redirect loop issue.
            $this->Session->delete('fbuser');
            $this->Session->write('is_fab_session_cleared', 1);
        }
        $this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Auth->logout();
        $this->Cookie->delete('User');
        $this->Cookie->delete('user_language');
        $cookie_name = $this->PersistentLogin->_persistent_login_get_cookie_name();
        $cookie_val = $this->Cookie->read($cookie_name);
        if (!empty($cookie_val)) {
            list($uid, $series, $token) = explode(':', $cookie_val);
            $this->User->PersistentLogin->deleteAll(array(
                'PersistentLogin.user_id' => $uid,
                'PersistentLogin.series' => $series
            ));
        }
        if (!empty($_COOKIE['_gz'])) {
            setcookie('_gz', '', time() -3600, '/');
        }
        $this->Session->setFlash(__l('You are now logged out of the site.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'login'
        ));
    }
    public function facepile()
    {
        $conditions = array(
            'OR' => array(
                array(
                    'User.is_facebook_connected' => 1
                ) ,
                array(
                    'User.is_facebook_register' => 1
                )
            ) ,
            'User.is_active' => 1
        );
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'contain' => array(
                'UserAvatar'
            ) ,
            'order' => array(
                'User.created' => 'desc'
            ) ,
            'limit' => 12,
            'recursive' => 0
        ));
        $this->set('users', $users);
        $totalUserCount = $this->User->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $this->set('totalUserCount', $totalUserCount);
    }
    public function view($username)
    {
        $this->pageTitle = __l('User') . ' - ' . $username;
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.username = ' => $username
            ) ,
            'contain' => array(
                'UserProfile' => array(
                    'fields' => array(
                        'UserProfile.created',
                        'UserProfile.first_name',
                        'UserProfile.last_name',
                        'UserProfile.middle_name',
                        'UserProfile.about_me',
                        'UserProfile.dob',
                        'UserProfile.address',
                        'UserProfile.zip_code',
                    ) ,
                    'Gender' => array(
                        'fields' => array(
                            'Gender.name'
                        )
                    ) ,
                    'City' => array(
                        'fields' => array(
                            'City.name'
                        )
                    ) ,
                    'Language' => array(
                        'fields' => array(
                            'Language.id',
                            'Language.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name'
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2'
                        )
                    )
                ) ,
                'UserAvatar' => array(
                    'fields' => array(
                        'UserAvatar.id',
                        'UserAvatar.dir',
                        'UserAvatar.filename',
                        'UserAvatar.width',
                        'UserAvatar.height'
                    )
                )
            ) ,
            'recursive' => 2
        ));
        if (empty($user['User']['is_active']) && $this->Auth->user('role_id') != ConstUserTypes::Admin) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (isPluginEnabled('Contests')) {
            $user_contest_rating_count = $this->User->ContestUser->find('first', array(
                'conditions' => array(
                    'ContestUser.user_id = ' => $user['User']['id']
                ) ,
                'fields' => array(
                    'SUM(ContestUser.contest_user_rating_count) as rating_count'
                ) ,
                'recursive' => -1
            ));
            $user_contest_won_count = $this->User->ContestUser->find('count', array(
                'conditions' => array(
                    'ContestUser.user_id = ' => $user['User']['id'],
                    'ContestUser.contest_user_status_id = ' => ConstContestUserStatus::Won,
                    'ContestUser.admin_suspend' => 0
                ) ,
                'recursive' => -1
            ));
            $contest_conditions = array();
            $contest_conditions['Contest']['user_id'] = $user['User']['id'];
            $contest_conditions['Contest']['contest_status_id'] = array(
                ConstContestStatus::Open,
                ConstContestStatus::Judging,
                ConstContestStatus::WinnerSelected,
                ConstContestStatus::WinnerSelectedByAdmin,
                ConstContestStatus::ChangeRequested,
                ConstContestStatus::ChangeCompleted,
                ConstContestStatus::Completed,
                ConstContestStatus::PaidToParticipant,
            );
            $user_contest_count = $this->User->Contest->find('count', array(
                'conditions' => array(
                    'Contest.user_id' => $user['User']['id'],
                    'Contest.contest_status_id' => array(
                        ConstContestStatus::Open,
                        ConstContestStatus::Judging,
                        ConstContestStatus::WinnerSelected,
                        ConstContestStatus::WinnerSelectedByAdmin,
                        ConstContestStatus::ChangeRequested,
                        ConstContestStatus::ChangeCompleted,
                        ConstContestStatus::Completed,
                        ConstContestStatus::PaidToParticipant,
                    ) ,
                    'Contest.admin_suspend' => 0
                ) ,
                'recursive' => -1
            ));
            $user_entry_count = $this->User->ContestUser->find('count', array(
                'conditions' => array(
                    'ContestUser.user_id = ' => $user['User']['id'],
                    'ContestUser.admin_suspend' => 0
                ) ,
                'recursive' => -1
            ));
            if (isPluginEnabled('ContestFollowers')) {
                $conditions = array();
                $conditions['Contest.contest_status_id'] = array(
                    ConstContestStatus::Open,
                    ConstContestStatus::Judging,
                    ConstContestStatus::WinnerSelected,
                    ConstContestStatus::WinnerSelectedByAdmin,
                    ConstContestStatus::ChangeRequested,
                    ConstContestStatus::ChangeCompleted,
                    ConstContestStatus::Completed,
                    ConstContestStatus::PaidToParticipant
                );
                $followings = $this->User->Contest->ContestFollower->find('all', array(
                    'conditions' => array(
                        'ContestFollower.user_id' => $user['User']['id']
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
                $conditions['Contest.admin_suspend'] = 0;
                $resources = $this->User->Contest->Resource->activeResources();
                if ($resources) {
                    $conditions['Contest.resource_id'] = $resources;
                }
                $contest_followed_count = $this->User->Contest->find('count', array(
                    'conditions' => $conditions,
                    'recursive' => -1
                ));
                $this->set('contest_followed_count', $contest_followed_count);
            }
            if (isPluginEnabled('UserFavourites')) {
                $conditions = array();
                $userFavorites = $this->User->UserFavorite->find('list', array(
                    'conditions' => array(
                        'UserFavorite.user_id' => $user['User']['id']
                    ) ,
                    'fields' => array(
                        'UserFavorite.id',
                        'UserFavorite.user_favorite_id',
                    ) ,
                    'recursive' => -1
                ));
                $conditions['User.id'] = array_values($userFavorites);
                $conditions['User.role_id !='] = ConstUserTypes::Admin;
                $user_followed_count = $this->User->find('count', array(
                    'conditions' => $conditions,
                    'recursive' => -1
                ));
                $this->set('user_followed_count', $user_followed_count);
                if ($username != $this->Auth->user('username')) {
                    $userFavorite = $this->User->UserFavorite->find('first', array(
                        'conditions' => array(
                            'UserFavorite.user_id' => $this->Auth->user('id') ,
                            'UserFavorite.user_favorite_id' => $user['User']['id']
                        ) ,
                        'recursive' => 0
                    ));
                    $this->set('userFavorite', $userFavorite);
                }
            }
            $this->set('user_contest_count', $user_contest_count);
            $this->set('user_entry_count', $user_entry_count);
            $this->set('user_contest_won_count', $user_contest_won_count);
            $this->set('contest_user_rating_count', $user_contest_rating_count);
        }
        if (!isset($user['User']['id'])) {
            $this->Session->setFlash(__l('Invalid User.', true) , 'default', array(
                'class' => 'error'
            ));
            $this->redirect('/');
        }
        $this->set('title_for_layout', $user['User']['username']);
        $this->User->UserView->create();
        $this->request->data['UserView']['user_id'] = $user['User']['id'];
        $this->request->data['UserView']['viewing_user_id'] = $this->Auth->user('id');
        $this->request->data['UserView']['ip_id'] = $this->User->UserView->toSaveIp();
        $this->User->UserView->save($this->request->data);
        $this->set(compact('user'));
    }
    public function admin_send_mail()
    {
        $this->pageTitle = __l('Email to users');
        if (!empty($this->request->data)) {
            $this->User->set($this->request->data);
            if (empty($this->request->data['User']['bulk_mail_option_id']) && empty($this->request->data['User']['send_to'])) {
                $this->User->validationErrors['send_to'] = __l('Required');
            }
            if ($this->User->validates()) {
                $conditions = $emails = array();
                $notSendCount = $sendCount = 0;
                if (!empty($this->request->data['User']['send_to'])) {
                    $sendTo = explode(',', $this->request->data['User']['send_to']);
                    foreach($sendTo as $email) {
                        $email = trim($email);
                        if (!empty($email)) {
                            if ($this->User->find('count', array(
                                'conditions' => array(
                                    'User.email' => $email
                                ) ,
                                'recursive' => -1
                            ))) {
                                $emails[] = $email;
                                $sendCount++;
                            } else {
                                $notSendCount++;
                            }
                        }
                    }
                }
                if (!empty($this->request->data['User']['bulk_mail_option_id'])) {
                    if ($this->request->data['User']['bulk_mail_option_id'] == 2) {
                        $conditions['User.is_active'] = 0;
                    }
                    if ($this->request->data['User']['bulk_mail_option_id'] == 3) {
                        $conditions['User.is_active'] = 1;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 4) {
                        $conditions['UserProfile.gender_id'] = ConstGenders::Male;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 5) {
                        $conditions['UserProfile.gender_id'] = ConstGenders::Female;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 6) {
                        $conditions['User.is_facebook_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 7) {
                        $conditions['User.is_google_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 8) {
                        $conditions['User.is_twitter_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 9) {
                        $conditions['User.is_openid_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 10) {
                        $conditions['User.is_google_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 11) {
                        $conditions['User.is_linkedin_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    if ($this->data['User']['bulk_mail_option_id'] == 12) {
                        $conditions['User.is_googleplus_register !='] = 0;
                        $conditions['User.role_id = '] = ConstUserTypes::User;
                    }
                    $users = $this->User->find('all', array(
                        'conditions' => $conditions,
                        'fields' => array(
                            'User.email'
                        ) ,
                        'recursive' => -1
                    ));
                    if (!empty($users)) {
                        $sendCount++;
                        foreach($users as $user) {
                            $emails[] = $user['User']['email'];
                        }
                    }
                }
                $message_content['text'] = $this->request->data['User']['message'] . "\n\n" . Configure::read('site.name') . "\n" . Router::url('/', true);
                if (!empty($emails)) {
                    App::uses('CakeEmail', 'Network/Email');
                    $this->Email = new CakeEmail();
                    foreach($emails as $email) {
                        if (!empty($email)) {
                            $this->Email->to(trim($email));
                            $this->Email->from(Configure::read('EmailTemplate.from_email'));
                            $this->Email->subject($this->request->data['User']['subject']);
                            $this->Email->emailFormat('text');
                            $this->Email->send($message_content);
                        }
                    }
                }
                if ($sendCount && !$notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully') , 'default', null, 'success');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'send_mail',
                        'admin' => true
                    ));
                } elseif ($sendCount && $notSendCount) {
                    $this->Session->setFlash(__l('Email sent successfully. Some emails are not sent') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('No email send') , 'default', null, 'success');
                }
            } else {
                $this->Session->setFlash(__l('Problem on sending email') , 'default', null, 'error');
            }
        }
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['user']
                ) ,
                'recursive' => -1,
            ));
            if (!empty($user)) {
                $this->request->data['User']['send_to'] = $user['User']['email'];
            }
        }
        $bulkMailOptions = $this->User->bulkMailOptions;
        $this->set(compact('bulkMailOptions'));
    }
    public function admin_change_password($user_id = null)
    {
        $this->setAction('change_password', $user_id);
    }
    public function _sendAdminActionMail($user_id, $email_template)
    {
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'fields' => array(
                'User.username',
                'User.email'
            ) ,
            'recursive' => -1
        ));
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
        );
        App::import('Model', 'EmailTemplate');
        $this->EmailTemplate = new EmailTemplate();
        $template = $this->EmailTemplate->selectTemplate($email_template);
        $this->User->_sendEmail($template, $emailFindReplace, $user['User']['email']);
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add New User/Admin');
        if (!empty($this->request->data)) {
            $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['passwd']);
            $this->request->data['User']['is_agree_terms_conditions'] = '1';
            $this->request->data['User']['is_email_confirmed'] = 1;
            $this->request->data['User']['is_active'] = 1;
            $this->request->data['User']['signup_ip_id'] = $this->User->toSaveIp();
            $this->User->create();
            if ($this->User->save($this->request->data)) {
                // Send mail to user to activate the account and send account details
                $emailFindReplace = array(
                    '##USERNAME##' => $this->request->data['User']['username'],
                    '##LOGINLABEL##' => ucfirst(Configure::read('user.using_to_login')) ,
                    '##USEDTOLOGIN##' => $this->request->data['User'][Configure::read('user.using_to_login') ],
                    '##PASSWORD##' => $this->request->data['User']['passwd']
                );
                App::import('Model', 'EmailTemplate');
                $this->EmailTemplate = new EmailTemplate();
                $template = $this->EmailTemplate->selectTemplate('Admin User Add');
                $this->User->_sendEmail($template, $emailFindReplace, $this->request->data['User']['email']);
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('User')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                unset($this->request->data['User']['passwd']);
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('User')) , 'default', null, 'error');
            }
        }
        $roles = $this->User->Role->find('list');
        $this->set(compact('roles'));
        if (!!empty($this->request->data['User']['role_id'])) {
            $this->request->data['User']['role_id'] = ConstUserTypes::User;
        }
    }
    public function admin_export($hash = null)
    {
        Configure::write('debug', 0);
        $conditions = array();
        if (isset($this->request->params['named']['from_date']) || isset($this->request->params['named']['to_date'])) {
            $conditions['User.created >='] = _formatDate('Y-m-d H:i:s', $this->request->params['named']['from_date'] . " 00:00:00", true);
            $conditions['User.created <='] = _formatDate('Y-m-d H:i:s', $this->request->params['named']['to_date'] . " 23:59:59", true);
        }
        if (!empty($this->request->params['named']['main_filter_id'])) {
            if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Registered through OpenID ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstMoreAction::FaceBook) {
                $conditions['User.facebook_user_id != '] = NULL;
                $this->pageTitle.= __l(' - Registered through FaceBook ');
            } else if ($this->request->params['named']['main_filter_id'] == ConstUserTypes::User) {
                $conditions['User.role_id'] = ConstUserTypes::User;
                $conditions['User.facebook_user_id = '] = NULL;
                $conditions['User.is_openid_register'] = 0;
            } else if ($this->request->params['named']['main_filter_id'] == ConstUserTypes::Admin) {
                $conditions['User.role_id'] = ConstUserTypes::Admin;
                $this->pageTitle.= __l(' - Admin ');
            } else if ($this->request->params['named']['main_filter_id'] == 'all') {
                $this->pageTitle.= __l(' - All ');
            }
            $count_conditions = $conditions;
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['User.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
            $conditions['User.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
            $this->pageTitle.= __l(' - Registered today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['User.created <= '] = date('Y-m-d H:is', strtotime('now'));
            $conditions['User.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Registered in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['User.created <= '] = date('Y-m-d H:is', strtotime('now'));
            $conditions['User.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Registered in this month');
        }
        if (!empty($hash) && isset($_SESSION['user_export'][$hash])) {
            $user_ids = implode(',', $_SESSION['user_export'][$hash]);
            if ($this->User->isValidUserIdHash($user_ids, $hash)) {
                $conditions['User.id'] = $_SESSION['user_export'][$hash];
            } else {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if (isset($this->request->params['named']['q']) && !empty($this->request->params['named']['q'])) {
            $conditions['User.username like'] = '%' . $this->request->params['named']['q'] . '%';
        }
        $users = $this->User->find('all', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        if (!empty($users)) {
            foreach($users as $key => $user) {
                $data[]['User'] = array(
                    __l('Username') => $user['User']['username'],
                    __l('Email') => $user['User']['email'],
                    __l('Login count') => $user['User']['user_login_count']
                );
                if (isPluginEnabled('Contests')) {
                    $contest = array(
                        __l('Created Contests') => $user['User']['contest_count'],
                        __l('Site Revenue via') . ' ' . Configure::read('contest.contest_holder_alt_name_singular_caps') => $user['User']['total_site_revenue_as_contest_holder'],
                        __l('Entries Posted') => $user['User']['contest_user_count'],
                        __l('Earned Amount') => $user['User']['participant_total_earned_amount'],
                        __l('Site Revenue via') . ' ' . Configure::read('contest.participant_alt_name_plural_caps') => $user['User']['total_site_revenue_as_participant'],
                    );
                    $data[$key]['User'] = array_merge($data[$key]['User'], $contest);
                }
                if (isPluginEnabled('Wallet')) {
                    $wallet = array(
                        __l('Available Balance') => $user['User']['available_wallet_amount']
                    );
                    $data[$key]['User'] = array_merge($data[$key]['User'], $wallet);
                }
            }
        }
        $this->set('data', $data);
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->_sendAdminActionMail($id, 'Admin User Delete');
        if ($this->User->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s has been deleted') , __l('User')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_diagnostics()
    {
        $this->pageTitle = __l('Diagnostics');
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_recent_users()
    {
        $recentUsers = $this->User->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'User.role_id',
                'User.username',
                'User.id',
            ) ,
            'recursive' => -1,
            'limit' => 10,
            'order' => array(
                'User.id' => 'desc'
            )
        ));
        $this->set(compact('recentUsers'));
    }
    public function admin_online_users()
    {
        $onlineUsers = $this->User->CkSession->find('all', array(
            'conditions' => array(
                'User.is_active' => 1,
                'CkSession.user_id != ' => 0,
                'User.role_id != ' => ConstUserTypes::Admin
            ) ,
            'fields' => array(
                'DISTINCT CkSession.user_id',
                'User.username',
                'User.role_id',
                'User.id',
            ) ,
            'recursive' => 0,
            'limit' => 10,
            'order' => array(
                'User.last_logged_in_time' => 'desc'
            )
        ));
        $this->set(compact('onlineUsers'));
    }
    public function whois($ip = null)
    {
        if (!empty($ip)) {
            $this->redirect(Configure::read('site.look_up_url') . $ip);
        }
    }
    // <-- For iPhone App code
    public function validate_user()
    {
        $this->Session->delete('HA::CONFIG');
        $this->Session->delete('HA::STORE');
        $this->Auth->logout();
        if ((Configure::read('user.using_to_login') == 'email') && isset($this->request->data['User']['username'])) {
            $this->request->data['User']['email'] = $this->request->data['User']['username'];
            unset($this->request->data['User']['username']);
        }
        $this->request->data['User'][Configure::read('user.using_to_login') ] = trim($this->request->data['User'][Configure::read('user.using_to_login') ]);
        $this->request->data['User']['password'] = $_POST['data']['User']['password'];
        $this->request->data['User']['password'] = getCryptHash($this->request->data['User']['password']);
        if ($this->Auth->login()) {
            $mobile_app_hash = md5($this->_unum() . $this->request->data['User'][Configure::read('user.using_to_login') ] . $this->request->data['User']['password'] . Configure::read('Security.salt'));
            $this->User->updateAll(array(
                'User.mobile_app_hash' => '\'' . $mobile_app_hash . '\'',
                'User.mobile_app_time_modified' => '\'' . date('Y-m-d h:i:s') . '\'',
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
            if (!empty($this->request->data['User']['devicetoken'])) {
                $this->User->ApnsDevice->findOrSave_apns_device($this->Auth->user('id') , $this->request->data['User']);
            }
            if (!empty($_GET['latitude']) && !empty($_GET['longtitude'])) {
                $this->update_iphone_user($_GET['latitude'], $_GET['longtitude'], $this->Auth->user('id'));
            }
            $resonse = array(
                'status' => 0,
                'message' => __l('Success') ,
                'hash_token' => $mobile_app_hash,
                'username' => $this->request->data['User'][Configure::read('user.using_to_login') ]
            );
        } else {
            $resonse = array(
                'status' => 1,
                'message' => sprintf(__l('Sorry, login failed.  Your %s or password are incorrect') , Configure::read('user.using_to_login'))
            );
        }
        if ($this->RequestHandler->prefers('json')) {
            $this->view = 'Json';
            $this->set('json', (empty($this->viewVars['iphone_response'])) ? $resonse : $this->viewVars['iphone_response']);
        }
    }
    public function follow_friends()
    {
        $type = $this->request->params['named']['type'];
        $social_conditions['SocialContact.user_id'] = $this->Auth->user('id');
        if ($type == 'facebook') {
            $social_conditions['SocialContact.social_source_id'] = ConstSocialSource::facebook;
        } elseif ($type == 'twitter') {
            $social_conditions['SocialContact.social_source_id'] = ConstSocialSource::twitter;
        }
        $this->loadModel('SocialMarketing.SocialContact');
        $this->loadModel('UserFavorite');
        $socialContacts = $this->SocialContact->find('all', array(
            'conditions' => $social_conditions,
            'recursive' => 0
        ));
        if (!empty($socialContacts)) {
            if ($type == 'facebook') {
                foreach($socialContacts as $socialContact) {
                    $contacts[] = $socialContact['SocialContactDetail']['facebook_user_id'];
                }
                $conditions['User.facebook_user_id'] = $contacts;
            } else if ($type == 'twitter') {
                foreach($socialContacts as $socialContact) {
                    $contacts[] = $socialContact['SocialContactDetail']['twitter_user_id'];
                }
                $conditions['User.twitter_user_id'] = $contacts;
            } else if ($type == 'gmail' || $type == 'yahoo' || $type == 'linkedin') {
                foreach($socialContacts as $socialContact) {
                    $contacts[] = $socialContact['SocialContactDetail']['email'];
                }
                $conditions['User.email'] = $contacts;
            }
            $userFavorites = $this->UserFavorite->find('all', array(
                'conditions' => array(
                    'UserFavorite.user_id' => $this->Auth->user('id')
                ) ,
                'recursive' => -1
            ));
            if (!empty($userFavorites)) {
                foreach($userFavorites as $userFavorite) {
                    $userFavoriteIds[] = $userFavorite['UserFavorite']['user_favorite_id'];
                }
                $conditions['User.id NOT'] = $userFavoriteIds;
            }
            $this->paginate = array(
                'conditions' => $conditions,
                'limit' => 15,
                'order' => array(
                    'User.id' => 'desc'
                ) ,
                'recursive' => -1
            );
            $this->set('followFriends', $this->paginate());
        }
    }
    public function refer()
    {
        $referred_by_user_id = $this->Cookie->read('referrer');
        $user_refername = '';
        if (!empty($this->request->params['named']['r_value'])) {
            $user_refername = $this->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['r_value']
                ) ,
                'recursive' => -1
            ));
            if (empty($user_refername)) {
                $this->Session->setFlash(__l('Referrer username does not exist.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'register',
                    'type' => 'social'
                ));
            }
        }
        //cookie value should be empty or same user id should not be over written
        if (!empty($user_refername) && (empty($referred_by_user_id) || (!empty($referred_by_user_id) && (!empty($user_refername)) && ($referred_by_user_id != $user_refername['User']['id'])))) {
            $this->Cookie->delete('referrer');
            $this->Cookie->write('referrer', $user_refername['User']['id'], false, '+5 hours');
        }
        $this->redirect(array(
            'controller' => 'users',
            'action' => 'register',
            'manual'
        ));
    }
    public function show_admin_control_panel()
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'user') {
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => -1
            ));
            $this->set('user', $user);
        }
        $this->layout = 'ajax';
    }
    public function _referer_follow($user_id, $followed_user_id, $username)
    {
        $this->User->UserFavorite->create();
        $this->request->data['UserFavorite']['user_id'] = $user_id;
        $this->request->data['UserFavorite']['user_favorite_id '] = $followed_user_id;
        $this->request->data['UserFavorite']['ip_id '] = $this->User->UserFavorite->toSaveIp();
        $this->User->UserFavorite->save($this->request->data);
        Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
            '_trackEvent' => array(
                'category' => 'UserFavorite',
                'action' => 'Followed',
                'label' => $username,
                'value' => '',
            ) ,
            '_setCustomVar' => array(
                'ud' => $user_id,
            )
        ));
    }
}
?>