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
class UserFlagsController extends AppController
{
    public $name = 'UserFlags';
    public $permanentCacheAction = array(
        'admin' => array(
            'add',
        ) ,
    );
    public function add($other_user_id = null)
    {
		$User_add = $this->UserFlag->User->find('first', array(
                'conditions' => array(
                    'User.id' => $other_user_id
                ) ,
                'recursive' => -1
        ));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['UserFlag']['other_user_id']) || (!empty($this->request->data['UserFlag']['user_id']) && $this->Auth->user('id') == $this->request->data['UserFlag']['user_id'])) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $user_user = $this->UserFlag->find('first', array(
                'fields' => array(
                    'UserFlag.id',
                ) ,
                'conditions' => array(
                    'UserFlag.user_id' => $this->request->data['UserFlag']['other_user_id'],
                    'UserFlag.user_id' => $this->Auth->user('id')
                ),
				'recursive' => -1
            ));
            $User = $this->UserFlag->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->request->data['UserFlag']['other_user_id']
                ) ,
                'recursive' => -1
            ));
            if ($User['User']['id'] == $this->Auth->user('id')) {
                $this->Session->setFlash(__l('You cannot flag you.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'users',
                    'action' => 'view',
                    $User['User']['username'],
                ));
            }
            if (empty($user_user)) {
                $this->UserFlag->create();
                $this->request->data['UserFlag']['user_id'] = $this->Auth->user('id');
                $this->request->data['UserFlag']['ip_id'] = $this->UserFlag->toSaveIp();
                if ($this->UserFlag->save($this->request->data)) {
                    $_Data['User']['id'] = $this->request->data['UserFlag']['user_id'];
                    $_Data['User']['is_user_flagged'] = 1;
                    $this->UserFlag->User->save($_Data);
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'User',
							'action' => 'Flagged',
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
							'category' => 'UserFlag',
							'action' => 'Flagged',
							'label' => $User['User']['id'],
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'cd' => $User['User']['id'],
							'ud' => $this->Auth->user('id') ,
							'rud' => $this->Auth->user('referred_by_user_id') ,
						)
					));
                    $this->Session->setFlash(sprintf(__l('%s has been added'), __l('User Flag')) , 'default', null, 'success');
                    if (!$this->RequestHandler->isAjax()) {
                        $User = $this->UserFlag->User->find('first', array(
                            'conditions' => array(
                                'User.id' => $this->request->data['UserFlag']['user_id']
                            ) ,
                            'recursive' => -1
                        ));
                        $this->redirect(array(
                            'controller' => 'users',
                            'action' => 'view',
                            $User['User']['username'],
                        ));
                    } else {
                        $ajax_url = Router::url(array(
                            'controller' => 'users',
                            'action' => 'view',
                            $User['User']['username'],
                        ));
                        $success_msg = 'redirect*' . $ajax_url;
                        echo $success_msg;
                        exit;
                    }
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('User Flag')) , 'default', null, 'error');
                }
            } else {
                if (!$this->RequestHandler->isAjax()) {
                    $this->Session->setFlash(__l('You have already reported this user.') , 'default', null, 'error');
                    $this->redirect(array(
                        'controller' => 'users',
                        'action' => 'view',
                        $User['User']['username'],
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'users',
                        'action' => 'view',
                        $User['User']['username'],
                    ));
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
        }
        $this->request->data['UserFlag']['other_user_id'] = !empty($this->request->data['UserFlag']['other_user_id']) ? $this->request->data['UserFlag']['other_user_id'] : $other_user_id;
        $UserFlagCategories = $this->UserFlag->UserFlagCategory->find('list', array(
            'conditions' => array(
                'UserFlagCategory.is_active' => 1
            ) ,
			'recursive' => -1
        ));
        $UserUsers = $this->UserFlag->User->find('list');
		$this->set('User_add',$User_add);
        $this->set(compact('UserFlagCategories'));
        $this->set(compact('UserUsers'));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('User Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['category'])) {
            $userFlagCategory = $this->{$this->modelClass}->UserFlagCategory->find('first', array(
                'conditions' => array(
                    'UserFlagCategory.id' => $this->request->params['named']['category']
                ) ,
                'fields' => array(
                    'UserFlagCategory.id',
                    'UserFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($userFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['UserFlagCategory.id'] = $userFlagCategory['UserFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $userFlagCategory['UserFlagCategory']['name']);
        }
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['user']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.name',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                $conditions['User.id'] = 0;
            } else {
                $conditions['UserFlag.other_user_id'] = $user['User']['id'];
            }
            $this->pageTitle.= ' - ' . $this->request->params['named']['user'];
        }
        if (!empty($this->request->params['named']['username'])) {
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['username']
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $user['User']['id'];
            $this->pageTitle.= sprintf(__l(' - User - %s') , $user['User']['username']);
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(UserFlag.created) <= '] = 0;
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(UserFlag.created) <= '] = 7;
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
            $conditions['TO_DAYS(NOW()) - TO_DAYS(UserFlag.created) <= '] = 30;
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'User.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'UserFlagCategory.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'UserFlag.message LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['UserFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'UserFlagCategory' => array(
                    'fields' => array(
                        'UserFlagCategory.name'
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
                    'Timezone' => array(
                        'fields' => array(
                            'Timezone.name',
                        )
                    ) ,
                ) ,
				'User' => array(
					'fields' => array(
						'User.id',
						'User.username',
					)
				),
				'OtherUser' => array(
					'fields' => array(
						'OtherUser.id',
						'OtherUser.username',
					)
				)
            ) ,
            'order' => array(
                'UserFlag.id' => 'desc'
            )
        );
        $this->set('userFlags', $this->paginate());
        $moreActions = $this->UserFlag->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFlag->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s has been deleted'), __l('User Flag')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>