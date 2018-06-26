<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class SocialMarketingsController extends AppController
{
    public $name = 'SocialMarketings';
    public $components = array(
        'RequestHandler'
    );
    public $permanentCacheAction = array(
        'user' => array(
            'publish',
            'import_friends',
        ) ,
    );
    public function import_friends()
    {
        $this->pageTitle = __l('Find Friends');
        $this->loadModel('User');
        $config = array(
            'base_url' => Router::url('/', true) . 'socialauth/',
            'providers' => array(
                'Facebook' => array(
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('facebook.fb_app_id') ,
                        'secret' => Configure::read('facebook.fb_secrect_key')
                    ) ,
                    'scope' => 'email, user_about_me, user_birthday, user_hometown',
                ) ,
                'Twitter' => array(
                    'enabled' => true,
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
                    'enabled' => true,
                    'keys' => array(
                        'id' => Configure::read('googleplus.consumer_key') ,
                        'secret' => Configure::read('googleplus.consumer_secret')
                    ) ,
                ) ,
                'Yahoo' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('yahoo.consumer_key') ,
                        'secret' => Configure::read('yahoo.consumer_secret')
                    ) ,
                ) ,
                'Linkedin' => array(
                    'enabled' => true,
                    'keys' => array(
                        'key' => Configure::read('linkedin.consumer_key') ,
                        'secret' => Configure::read('linkedin.consumer_secret')
                    ) ,
                ) ,
            )
        );
        if ($this->request->params['named']['type'] == 'facebook') {
            $this->pageTitle.= ' - Facebook';
            $next_action = 'twitter';
        } elseif ($this->request->params['named']['type'] == 'twitter') {
            $this->pageTitle.= ' - Twitter';
            $next_action = 'gmail';
            $this->User->updateAll(array(
                'User.is_skipped_fb' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'gmail') {
            $this->pageTitle.= ' - Gmail';
            $next_action = 'yahoo';
            $this->User->updateAll(array(
                'User.is_skipped_twitter' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'yahoo') {
            $this->pageTitle.= ' - Yahoo!';
            $next_action = 'linkedin';
            $this->User->updateAll(array(
                'User.is_skipped_google' => 1,
				'User.is_skipped_yahoo' => 1,
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        } elseif ($this->request->params['named']['type'] == 'linkedin') {
            $this->pageTitle.= ' - LinkedIn';
            $this->User->updateAll(array(
                'User.is_skipped_yahoo' => 1,
                'User.is_skipped_linkedin' => 1
            ) , array(
                'User.id' => $this->Auth->user('id')
            ));
        }
        if (!empty($this->request->params['named']['import'])) {
            $options = array();
            if ($this->request->params['named']['import'] == 'openid') {
                $options = array(
                    'openid_identifier' => 'https://openid.stackexchange.com/'
                );
            }
			try{
            require_once (APP . DS . WEBROOT_DIR . DS . 'socialauth/Hybrid/Auth.php');
            $hybridauth = new Hybrid_Auth($config);
            if (!empty($this->request->params['named']['redirecting'])) {
                $adapter = $hybridauth->authenticate(ucfirst($this->request->params['named']['import']) , $options);
                $social_profile = $adapter->getUserProfile();
                $is_correct_user = $this->User->checkConnection($social_profile, $this->request->params['named']['import']);
                if ($is_correct_user) {
                    $this->User->updateSocialContact($social_profile, $this->request->params['named']['import']);
                    $social_contacts = $adapter->getUserContacts();
                    $this->SocialMarketing->import_contacts($social_contacts, $this->request->params['named']['import']);
					$this->Session->delete('HA::CONFIG');
					$this->Session->delete('HA::STORE');
                    if (!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] == 'social') {
                        $this->Session->setFlash(sprintf(__l('You have connected %s successfully!') , $this->request->params['named']['import']) , 'default', null, 'success');
					} elseif (empty($this->request->params['named']['from'])) {
						$this->Session->setFlash(sprintf(__l('Your %s contact has been imported successfully!.') , $this->request->params['named']['import']) , 'default', null, 'success');
					}
					echo '<script>window.close();</script>';
					exit;
                } else {
					$this->Session->delete('HA::CONFIG');
					$this->Session->delete('HA::STORE');
                    $this->Session->setFlash(__l('This social network account already connected by other user.') , 'default', null, 'error');
					echo '<script>window.close();</script>';
					exit;
                }
            } else {
                $reditect = Router::url(array(
                    'controller' => 'social_marketings',
                    'action' => 'import_friends',
                    'type' => $this->request->params['named']['type'],
                    'import' => $this->request->params['named']['import'],
                    'redirecting' => $this->request->params['named']['import'],
                    'from' => !empty($this->request->params['named']['from']) ? $this->request->params['named']['from'] : '',
                ) , true);
                $this->layout = 'redirection';
                $this->set('redirect_url', $reditect);
                $this->set('authorize_name', ucfirst($this->request->params['named']['import']));
                $this->render('authorize');
			}
            }
			catch( Exception $e ){
				$error = "";
				switch( $e->getCode() ){
					case 6 : 
							$error = __l("User profile request failed. Most likely the user is not connected to the provider and he should to authenticate again.");
							$this->Session->delete('HA::CONFIG');
							$this->Session->delete('HA::STORE');
							break;
					case 7 : 
							$this->Session->delete('HA::CONFIG');
							$this->Session->delete('HA::STORE');
							$error = __l("User not connected to the provider.");
							break;
					default: $error = __l("Authentication failed. The user has canceled the authentication or the provider refused the connection"); break;
				} 			
				$this->Session->setFlash($error, 'default', null, 'error');
					echo '<script>window.close();</script>';
					exit;
			}
        }
        $this->set(compact('next_action'));
    }
    public function publish($id = null)
    {
        $this->loadModel('Contests.Contest');
        $this->loadModel('User');
        if (empty($id) || empty($this->request->params['named']['type']) || empty($this->request->params['named']['publish_action'])) {
            $this->redirect(array(
                'controller' => 'users',
                'action' => 'dashboard',
            ));
        }
		if ($this->request->params['named']['publish_action'] == 'add') {
			$condition['Contest.id'] = $id;
			$contest = $this->Contest->find('first', array(
				'conditions' => $condition,
				'contain' => array(
					'Attachment',
					'User',
				) ,
				'recursive' => 0
			));
		   $page_title = $this->Auth->user('username').' '.__l('posted').' ';
		}
		$image_options = array(
			'dimension' => 'big_thumb',
			'class' => '',
			'alt' => $contest['Contest']['name'],
			'title' => $contest['Contest']['name'],
			'type' => 'png',
			'full_url' => true
		);
		$contest_image = Router::url('/', true) . 'img/logo.png';
		$contest_url = Router::url(array(
			'controller' => 'contests',
			'action' => 'view',
			$contest['Contest']['slug'],
		) , true);
		if ($this->request->params['named']['type'] == 'facebook') {
			$user = $this->User->find('first', array(
				'conditions' => array(
					'id' => $this->Auth->user('id')
				) ,
				'recursive' => -1
			));
			$feed_url = 'https://www.facebook.com/dialog/feed?fb_app_id=' . Configure::read('facebook.fb_app_id') . '&display=iframe&access_token=' . $user['User']['facebook_access_token'] . '&show_error=true&link=' . $contest_url . '&picture=' . $contest_image . '&name=' . urlencode($contest['Contest']['name']) . '&caption=' . urlencode($contest['Contest']['name']) . '&description=' . $contest['Contest']['description'] . '&redirect_uri=' . Router::url('/', true) . 'social_marketings/publish_success/share/' . $id . '/' . $this->request->params['named']['publish_action'];
			$next_action = 'twitter';
		} elseif ($this->request->params['named']['type'] == 'twitter') {
			$next_action = 'others';
		} elseif ($this->request->params['named']['type'] == 'others') {
			$next_action = 'promote';
		}
        $this->pageTitle = $page_title.$contest['Contest']['name'] . ' - ' . __l('Share');;
        $this->set(compact('contest_image', 'contest_url', 'contest', 'feed_url', 'next_action', 'id'));
    }
    public function publish_success($current_page, $id, $action)
    {
        $this->set(compact('current_page', 'id', 'action'));
        $this->layout = 'ajax';
        $this->render('publish_success');
    }
    public function myconnections($social_type = null)
    {
        $this->pageTitle = __l('Social');
        if (!empty($social_type)) {
            $this->loadModel('User');
			$__data = array();
            $_data['User']['id'] = $this->Auth->user('id');
            if ($social_type == 'facebook') {
                $_data['User']['is_facebook_connected'] = 0;
            } elseif ($social_type == 'twitter') {
                $_data['User']['is_twitter_connected'] = 0;
            } elseif ($social_type == 'google') {
                $_data['User']['is_google_connected'] = 0;
            } elseif ($social_type == 'yahoo') {
                $_data['User']['is_yahoo_connected'] = 0;
            } elseif ($social_type == 'linkedin') {
                $_data['User']['is_linkedin_connected'] = 0;
            }
			$_data['User']['user_avatar_source_id'] = 0;
            $this->User->save($_data);
            $this->Session->setFlash(sprintf(__l('You have disconnected from %s') , $social_type) , 'default', null, 'success');
        }
    }
    public function promote_retailmenot($id)
    {
        $this->loadModel('ProjectRewards.ProjectReward');
        $reward = $this->ProjectReward->find('first', array(
            'conditions' => array(
                'ProjectReward.id' => $id
            ) ,
            'recursive' => -1
        ));
        $this->set('reward', $reward);
    }
}
?>