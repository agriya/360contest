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
class UserProfilesController extends AppController
{
    public $name = 'UserProfiles';
    public $uses = array(
        'UserProfile',
        'Attachment',
    );
    public $components = array(
        'Email'
    );
    public $permanentCacheAction = array(
        'admin' => array(
            'edit',
        )
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'UserAvatar.filename',
            'City.id',
            'State.id'
        );
        parent::beforeFilter();
    }
    public function edit($user_id = null)
    {
        $this->pageTitle = __l('Edit Profile');
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
		if ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
            unset($this->UserProfile->validate['country_id']);
            unset($this->UserProfile->City->validate['name']);
            unset($this->UserProfile->State->validate['name']);
            unset($this->UserProfile->validate['gender_id']);
        }
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ),
					'UserProfile',
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
               if(!empty($user['UserProfile']['id'])) {
					$this->request->data['UserProfile']['id'] = $user['UserProfile']['id'];
				}
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }
            $this->request->data['UserProfile']['user_id'] = $this->request->data['User']['id'];
            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }
            $this->UserProfile->set($this->request->data);
            $this->UserProfile->User->set($this->request->data);
            $this->UserProfile->State->set($this->request->data);
            $this->UserProfile->City->set($this->request->data);
            $ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }
            if ($this->UserProfile->User->validates() & $this->UserProfile->validates() & $this->UserProfile->User->UserAvatar->validates() & $this->UserProfile->City->validates() & $this->UserProfile->State->validates() && $ini_upload_error) {
                $this->request->data['UserProfile']['state_id'] = !empty($this->request->data['State']['id']) ? $this->request->data['State']['id'] : $this->UserProfile->State->findOrSaveAndGetId($this->request->data['State']['name'], $this->request->data['UserProfile']['country_id']);
                $this->request->data['UserProfile']['city_id'] = !empty($this->request->data['City']['id']) ? $this->request->data['City']['id'] : $this->UserProfile->City->findOrSaveAndGetId($this->request->data['City']['name'], $this->request->data['UserProfile']['country_id'], $this->request->data['UserProfile']['state_id']);
                if ($this->UserProfile->save($this->request->data)) {
                    $this->UserProfile->User->save($this->request->data['User']);
                    if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                        $this->Attachment->create();
                        $this->request->data['UserAvatar']['class'] = 'UserAvatar';
                        $this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
                        $this->Attachment->save($this->request->data['UserAvatar']);
                    }
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'UserProfile',
							'action' => 'Updated',
							'label' => $this->Auth->user('username') ,
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'ud' => $this->Auth->user('id') ,
							'rud' => $this->Auth->user('referred_by_user_id') ,
						)
					));
                    $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('User Profile')) , 'default', null, 'success');
                    if ($this->Auth->user('role_id') == ConstUserTypes::Admin and $this->Auth->user('id') != $this->request->data['User']['id']) {
                        // Send mail to user to activate the account and send account details
						if($user['User']['email'] != $this->request->data['User']['email']) {
							$to_email = $this->request->data['User']['email'];
						} else {
							$to_email = $user['User']['email'];
						}
						$emailFindReplace = array(
							'##USERNAME##' => $user['User']['username'],
						);
						App::import('Model', 'EmailTemplate');
						$this->EmailTemplate = new EmailTemplate();
						$template = $this->EmailTemplate->selectTemplate('Admin User Edit');
                        $this->UserProfile->_sendEmail($template, $emailFindReplace, $to_email);
                    }
                }
            } else {
                if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                    $this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
                }
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('User Profile')) , 'default', null, 'error');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.filename',
                            'UserAvatar.dir',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    )
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin || empty($user_id)) {
                $user_id = $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'contain' => array(
                    'UserAvatar' => array(
                        'fields' => array(
                            'UserAvatar.id',
                            'UserAvatar.dir',
                            'UserAvatar.filename',
                            'UserAvatar.width',
                            'UserAvatar.height'
                        )
                    ) ,
                    'UserProfile' => array(
                        'City' => array(
                            'fields' => array(
                                'City.name'
                            )
                        ) ,
                        'State' => array(
                            'fields' => array(
                                'State.name'
                            )
                        )
                    )
                ) ,
                'recursive' => 2
            ));
            if (!empty($this->request->data['UserProfile']['City'])) {
                $this->request->data['City']['name'] = $this->request->data['UserProfile']['City']['name'];
            }
            if (!empty($this->request->data['UserProfile']['State']['name'])) {
                $this->request->data['State']['name'] = $this->request->data['UserProfile']['State']['name'];
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
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
        $genders = $this->UserProfile->Gender->find('list');
        $countries = $this->UserProfile->Country->find('list', array(
			'order' => array(
				'Country.id' => 'asc'
			)
		));
        $languages = $this->UserProfile->Language->find('list', array(
            'conditions' => array(
                'Language.is_active' => 1
            ),
			'recursive' => -1
        ));
        $this->set(compact('genders', 'countries', 'languages'));
    }
	public function profile_image($user_id = null)
    {
        $this->pageTitle = sprintf(__l('%s Image') , __l('Profile'));
        $this->UserProfile->User->UserAvatar->Behaviors->attach('ImageUpload', Configure::read('avatar.file'));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['User']['id'])) {
                $this->request->data['User']['id'] = $this->Auth->user('id');
            }
            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user)) {
                if (!empty($user['UserAvatar']['id'])) {
                    $this->request->data['UserAvatar']['id'] = $user['UserAvatar']['id'];
                }
            }

            if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
                $this->request->data['UserAvatar']['filename']['type'] = get_mime($this->request->data['UserAvatar']['filename']['tmp_name']);
            }
            if (!empty($this->request->data['UserAvatar']['filename']['name']) || (!Configure::read('avatar.file.allowEmpty') && empty($this->request->data['UserAvatar']['id']))) {
                $this->UserProfile->User->UserAvatar->set($this->request->data);
            }

            $this->UserProfile->User->set($this->request->data);
			$ini_upload_error = 1;
            if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
                $ini_upload_error = 0;
            }

			if ($this->UserProfile->User->validates() && $this->UserProfile->User->UserAvatar->validates() && $ini_upload_error ) {
				$this->UserProfile->User->save($this->request->data['User']);
				if (!empty($this->request->data['UserAvatar']['filename']['name'])) {
					$this->Attachment->create();
					$this->request->data['UserAvatar']['class'] = 'UserAvatar';
					$this->request->data['UserAvatar']['foreign_id'] = $this->request->data['User']['id'];
					$this->Attachment->save($this->request->data['UserAvatar']);
				}
				$this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Profile Image')) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'user_profiles',
                    'action' => 'profile_image',
                    $this->request->data['User']['id']
                ));
			} else {
				if ($this->request->data['UserAvatar']['filename']['error'] == 1) {
					$this->UserProfile->User->UserAvatar->validationErrors['filename'] = sprintf(__l('The file uploaded is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
				}
				$this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Profile Image')) , 'default', null, 'error');
			}

            $user = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['User']['id']
                ) ,
                'contain' => array(
                    'UserProfile' => array(
                        'fields' => array(
                            'UserProfile.id'
                        )
                    ) ,
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
            if (!empty($user['User'])) {
                unset($user['UserProfile']);
                $this->request->data['User'] = array_merge($user['User'], $this->request->data['User']);
                $this->request->data['UserAvatar'] = $user['UserAvatar'];
            }
        } else {
            if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
                $user_id = $this->Auth->user('id');
            } else {
                $user_id = $user_id ? $user_id : $this->Auth->user('id');
            }
            $this->request->data = $this->UserProfile->User->find('first', array(
                'conditions' => array(
                    'User.id' => $user_id
                ) ,
                'contain' => array(
                    'UserAvatar'
                ) ,
                'recursive' => 0
            ));
        }
        $this->pageTitle.= ' - ' . $this->request->data['User']['username'];
    }
    public function admin_edit($id = null)
    {
        if (is_null($id) && empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->setAction('edit', $id);
    }
}
?>