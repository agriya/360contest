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
class UserFavoritesController extends AppController
{
    public $name = 'UserFavorites';
    public function add($user_id = null, $slug = null)
    {
        if (is_null($user_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		if($user_id != $this->Auth->user('id')) {
			$userfavorite = $this->UserFavorite->find('first', array(
				'conditions' => array(
					'UserFavorite.user_favorite_id' => $user_id,
					'UserFavorite.user_id' => $this->Auth->user('id')
				) ,
				'recursive' => 1
			));
			if (empty($userfavorite)) {
				$this->UserFavorite->create();
				$this->request->data['UserFavorite']['user_id'] = $this->Auth->user('id');
				$this->request->data['UserFavorite']['user_favorite_id'] = $user_id;
				$this->request->data['UserFavorite']['ip_id'] = $this->UserFavorite->toSaveIp();
				if ($this->UserFavorite->save($this->request->data)) {
					$data = array();
					$data['User']['id'] = $this->Auth->user('id');
					$data['User']['is_idle'] = 0;
					$data['User']['is_engaged'] = 1;
					$this->UserFavorite->User->save($data);
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'UserFavorite',
							'action' => 'Followed',
							'label' => $this->Auth->user('username') ,
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'ud' => $this->Auth->user('id') ,
							'rud' => $this->Auth->user('referred_by_user_id') ,
							'fud' => $userfavorite['User']['id']
						)
					));
					if ($this->RequestHandler->isAjax()) {
						echo "added|" . Router::url(array(
							'controller' => 'user_favorites',
							'action' => 'delete',
							$this->UserFavorite->id
						) , true);
						exit;
					}  else {
						$user = $this->UserFavorite->User->find('first', array(
							'conditions' => array(
								'User.id' => $user_id
							),
							'fields' => array(
								'User.id',
								'User.username',
							),
							'recursive' => -1
						));
						$this->Session->setFlash(__l('User has added to your favorites list') , 'default', null, 'success');
						$this->redirect(array(
							'controller' => 'users',
							'action' => 'view',
							$user['User']['username']
						));
					}
				} else {
					$this->Session->setFlash(__l('You could not be follow this user. Please, try again') , 'default', null, 'error');
				}
			} else {
				$this->Session->setFlash(__l('You have already followed this user') , 'default', null, 'error');
			}
		} else {
			$this->Session->setFlash(__l('You could not be follow yourself') , 'default', null, 'error');
		}
        $user = $this->UserFavorite->User->find('first', array(
            'fields' => array(
                'User.username'
            ) ,
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        if ($this->RequestHandler->isAjax()) {
            echo "removed|" . Router::url(array(
                'controller' => 'user_favorites',
                'action' => 'add',
                $user_id,
                $slug
            ) , true);
            exit;
        } else if(isset($this->request->params['named']['f'])) {
			$this->redirect(array(
                'controller' => 'users',
				'action' => 'view',
				$this->request->params['named']['f']
            ));
		} else{
            $this->redirect(array(
                'controller' => 'users',
				'action' => 'index',
				'type' => 'favorites'
            ));
        }
    }
	public function add_multiple()
	{
		if (!empty($this->request->data['UserFavorite'])) {
			foreach($this->request->data['UserFavorite'] as $user_id => $is_checked) {
				if ($is_checked['id']) {
					$userIds[] = $user_id;
				}
			}
			if (!empty($userIds)) {
				foreach($userIds as $val) {
					if (!empty($val)) {
						$this->UserFavorite->create();
						$this->request->data['UserFavorite']['user_id'] = $this->Auth->user('id');
						$this->request->data['UserFavorite']['user_favorite_id'] = $val;
						$this->UserFavorite->save($this->request->data);
					}
				}
				$this->Session->setFlash(__l('Checked users has been followed') , 'default', null, 'success');
			} else {
				$this->Session->setFlash(__l('Please select users to follow') , 'default', null, 'success');
			}
			$this->redirect($this->request->data['UserFavorite']['r']);
		}
	}
    public function delete($username = null)
    {
        if (is_null($username)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$user = $this->UserFavorite->User->find('first', array(
            'conditions' => array(
                'User.username' => $username
            ) ,
            'recursive' => -1
        ));
		if (empty($user)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->UserFavorite->find('first', array(
            'conditions' => array(
                'UserFavorite.user_id' => $this->Auth->user('id') ,
                'UserFavorite.user_favorite_id' => $user['User']['id']
            ) ,
            'recursive' => -1
        ));
		if (!empty($chkFavorites)) {
			if ($this->UserFavorite->delete($chkFavorites['UserFavorite']['id'])) {
				if ($this->RequestHandler->isAjax()) {
					echo "removed|" . Router::url(array(
						'controller' => 'user_favorites',
						'action' => 'add',
						$chkFavorites['UserFavorite']['user_favorite_id']
					) , true);
					exit;
				} else {
					$this->Session->setFlash(sprintf(__l('%s deleted'), __l('User Favorite')) , 'default', null, 'success');
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'view',
						$username
					));
				}
			} else {
				throw new NotFoundException(__l('Invalid request'));
			}
		}
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('User Followers');
        $conditions = array();
        if (!empty($this->request->params['named']['user'])) {
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => array(
                    'User.slug' => $this->request->params['named']['user']
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $user['User']['id'];
            $this->pageTitle.= sprintf(__l(' - User - %s') , $user['User']['title']);
        }
        if (!empty($this->request->params['named']['username'])) {
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => array(
                    'User.username' => $this->request->params['named']['username']
                ) ,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $user['User']['id'];
            $this->pageTitle.= sprintf(__l(' - User - %s') , $user['User']['username']);
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'FavoriteUser.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['UserFavorite']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserFavorite->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'fields' => array(
                        'User.username',
						'User.is_facebook_register',
						'User.facebook_user_id',
						'User.twitter_avatar_url',
						'User.linkedin_avatar_url'
                    ),
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
                'FavoriteUser' => array(
                    'fields' => array(
                        'FavoriteUser.username',
						'FavoriteUser.is_facebook_register',
						'FavoriteUser.facebook_user_id',
						'FavoriteUser.twitter_avatar_url',
						'FavoriteUser.linkedin_avatar_url'
                    ),
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
            ) ,
            'recursive' => 2,
            'order' => array(
                'UserFavorite.id' => 'desc'
            )
        );
        $this->set('userFavorites', $this->paginate());
        $moreActions = $this->UserFavorite->moreActions;
        $this->set(compact('moreActions'));
    }
    public function index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = sprintf(__l('Followed %s') , Configure::read('contest.participant_alt_name_plural_caps'));
        $conditions = array();
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['UserFavorite']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $conditions['UserFavorite.user_id'] = $this->Auth->user('id');
        $this->UserFavorite->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
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
                'FavoriteUser' => array(
                    'fields' => array(
                        'FavoriteUser.username',
                        'FavoriteUser.id',
                        'FavoriteUser.contest_user_count',
                        'FavoriteUser.contest_user_own_count',
                        'FavoriteUser.contest_user_won_count',
                        'FavoriteUser.average_rating',
                    )
                ) ,
                'Ip' => array(
                    'fields' => array(
                        'ip',
                        'host'
                    )
                ) ,
            ) ,
            'order' => array(
                'FavoriteUser.contest_user_won_count' => 'desc',
                'FavoriteUser.average_rating' => 'desc',
            ) ,
        );
        $this->set('userFavorites', $this->paginate());
        $moreActions = $this->UserFavorite->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserFavorite->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('User Follower')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
