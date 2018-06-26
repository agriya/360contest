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
class ContestFollowersController extends AppController
{
    public $name = 'ContestFollowers';
    public $permanentCacheAction = array(
        'user' => array(
            'index_contest_follow',
        ) ,
    );
    public function add($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $Contest = $this->ContestFollower->Contest->find('first', array(
            'fields' => array(
                'Contest.user_id',
                'Contest.slug',
                'Contest.contest_status_id'
            ) ,
            'conditions' => array(
                'Contest.id' => $id,
            ) ,
            'recursive' => -1
        ));
        if (empty($Contest) || in_array($Contest['Contest']['contest_status_id'], array(
            ConstContestStatus::PaymentPending,
            ConstContestStatus::PendingApproval,
            ConstContestStatus::Rejected,
            ConstContestStatus::CanceledByAdmin
        )) ||  $this->Auth->user('id')== $Contest['Contest']['user_id']) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $ContestFollower = $this->ContestFollower->find('first', array(
            'conditions' => array(
                'ContestFollower.contest_id' => $id,
                'ContestFollower.user_id' => $this->Auth->user('id')
            ) ,
			'recursive' => -1
        ));
        if (!empty($ContestFollower) || $ContestFollower['ContestFollower']['user_id'] == $this->Auth->user('id')) {
            $this->Session->setFlash(__l('Contest has already added to your watch list') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'contest',
                'action' => 'view',
                $Contest['Contest']['slug']
            ));
        }
        $ContestFollower['ContestFollower']['contest_id'] = $id;
        $ContestFollower['ContestFollower']['user_id'] = $this->Auth->user('id');
        $ContestFollower['ContestFollower']['ip_id'] = $this->ContestFollower->toSaveIp();
        if ($this->ContestFollower->save($ContestFollower['ContestFollower'])) {
			$data = array();
			$data['User']['id'] = $this->Auth->user('id');
			$data['User']['is_idle'] = 0;
			$data['User']['is_engaged'] = 1;
			$this->ContestFollower->User->save($data);
			if ($this->RequestHandler->prefers('json')) {
				$unfollow_url = Router::url(array(
					'controller' => 'contest_followers',
					'action' => 'delete',
					$Contest['Contest']['slug']
				));
				$response = array(
				'status' => 0,
				'message' => __l('Contest has added to your watchlist.') ,
				'label' => 'Unfollow',
				'unfollow_url' => $unfollow_url
				);
			$this->view = 'Json';
			$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
            } else {
            //@todo report mail //
            if ($this->RequestHandler->isAjax()) {
                $ContestFollowerCount = $this->ContestFollower->find('count', array(
                    'conditions' => array(
                        'ContestFollower.user_id' => $this->Auth->user('id')
                    ) ,
					'recursive' => -1
                ));
                echo "followed|" . Router::url(array(
                    'controller' => 'contest_followers',
                    'action' => 'delete',
                    $Contest['Contest']['slug'],
                ) , true);
                exit;
            } else {
                $this->Session->setFlash(__l('Contest has added to your watchlist') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'contest',
                    'action' => 'view',
                    $Contest['Contest']['slug']
                ));
            }
          }
        } else {
			if ($this->RequestHandler->prefers('json')) {
				$response = array(
				'status' => 1,
				'message' => __l('Contest has not added to your watchlist.') ,
				);
			$this->view = 'Json';
			$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
            } else {
            throw new NotFoundException(__l('Invalid request'));
			}
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestFollower->delete($id)) {
            $ContestFollowerCount = $this->ContestFollower->find('count', array(
                'conditions' => array(
                    'ContestFollower.contest_id' => $id,
                ) ,
				'recursive' => -1
            ));
            $this->Session->setFlash(__l('Contest follower has been removed.') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'contest_followers',
                'action' => 'index',
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function delete($slug = null)
    {
        if (is_null($slug)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contest = $this->ContestFollower->Contest->find('first', array(
            'conditions' => array(
                'Contest.slug' => $slug
            ) ,
            'recursive' => -1
        ));
		if (empty($contest)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $chkFavorites = $this->ContestFollower->find('first', array(
            'conditions' => array(
                'ContestFollower.user_id' => $this->Auth->user('id') ,
                'ContestFollower.contest_id' => $contest['Contest']['id']
            ) ,
            'recursive' => -1
        ));
        if (!empty($chkFavorites['ContestFollower']['id'])) {
            $id = $chkFavorites['ContestFollower']['id'];
            if ($this->ContestFollower->delete($id)) {
			  if ($this->RequestHandler->prefers('json')) {
				$follow_url = Router::url(array(
					'controller' => 'contest_followers',
					'action' => 'add',
					$contest['Contest']['id']
				));
				$response = array(
				'status' => 0,
				'message' => __l('Contest follower has been removed.') ,
				'label' => 'Follow',
				'follow_url' => $follow_url
				);
		   	    $this->view = 'Json';
				$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
              } else {
                if ($this->RequestHandler->isAjax()) {
                    echo "unfollowed|" . Router::url(array(
                        'controller' => 'contest_followers',
                        'action' => 'add',
                        $contest['Contest']['id']
                    ) , true);
                    exit;
                }
                $this->Session->setFlash(__l('Contest follower has been removed.') , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'contests',
                    'action' => 'view',
                    $contest['Contest']['slug']
                ));
			 }
            } else {
				if ($this->RequestHandler->prefers('json')) {
				$response = array(
				'status' => 1,
				'message' => __l('Contest follower has been not removed.') ,
				);
		   	    $this->view = 'Json';
				$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
              } else {
                throw new NotFoundException(__l('Invalid request'));
			  }
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Contest Followers');
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.role_id',
                    'User.username',
                    'User.id',
                    'User.facebook_user_id',
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (!empty($this->request->params['named']['contestid'])) {
            $conditions['ContestFollower.contest_id'] = $this->request->params['named']['contestid'];
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
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestFollower']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (!empty($this->request->params['named']['id'])) {
            $conditions['ContestFollower.user_interest_id'] = $this->request->params['named']['id'];
        }
        $this->ContestFollower->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'Contest' => array(
					'ContestStatus',
				),
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
            'order' => array(
                'ContestFollower.id' => 'desc'
            ) ,
        );
        $this->set('contestFollowers', $this->paginate());
        $moreActions = $this->ContestFollower->moreActions;
        $this->set(compact('moreActions'));
    }
    public function index_contest_follow()
    {
        $this->pageTitle = __l('Contest Followers');
        $conditions = array();
        if (!empty($this->request->params['named']['contest_id'])) {
            $conditions['ContestFollower.contest_id'] = $this->request->params['named']['contest_id'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                    'ContestUser' => array(
                        'conditions' => array(
                            'ContestUser.contest_id' => $this->request->params['named']['contest_id']
                        ) ,
                    )
                ) ,
                'Contest',
            ) ,
            'order' => array(
                'ContestFollower.id' => 'desc'
            ) ,
        );
        $this->set('contestFollows', $this->paginate());
    }
}
