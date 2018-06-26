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
class ContestFlagsController extends AppController
{
    public $name = 'ContestFlags';
    public $permanentCacheAction = array(
        'admin' => array(
            'add',
        ) ,
    );
    public function add($contest_id = null)
    {
		$Contest_add = $this->ContestFlag->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $contest_id
                ) ,
                'recursive' => -1
        ));
        if (!empty($this->request->data)) {
            if (empty($this->request->data['ContestFlag']['contest_id']) || (!empty($this->request->data['ContestFlag']['user_id']) && $this->Auth->user('id') == $this->request->data['ContestFlag']['user_id'])) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $contest_user = $this->ContestFlag->find('first', array(
                'fields' => array(
                    'ContestFlag.id',
                ) ,
                'conditions' => array(
                    'ContestFlag.contest_id' => $this->request->data['ContestFlag']['contest_id'],
                    'ContestFlag.user_id' => $this->Auth->user('id')
                ),
				'recursive' => -1
            ));
            $Contest = $this->ContestFlag->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->data['ContestFlag']['contest_id']
                ) ,
                'recursive' => -1
            ));
            if ($Contest['Contest']['user_id'] == $this->Auth->user('id')) {
                $this->Session->setFlash(__l('You cannot flag your own contest.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'contests',
                    'action' => 'view',
                    $Contest['Contest']['slug'],
                ));
            }
            if (empty($contest_user)) {
                $this->ContestFlag->create();
                $this->request->data['ContestFlag']['user_id'] = $this->Auth->user('id');
                $this->request->data['ContestFlag']['ip_id'] = $this->ContestFlag->toSaveIp();
                if ($this->ContestFlag->save($this->request->data)) {
                    $_Data['Contest']['id'] = $this->request->data['ContestFlag']['contest_id'];
                    $_Data['Contest']['is_user_flagged'] = 1;
                    $this->ContestFlag->Contest->save($_Data);
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
							'category' => 'ContestFlag',
							'action' => 'Flagged',
							'label' => $Contest['Contest']['id'],
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'cd' => $Contest['Contest']['id'],
							'ud' => $this->Auth->user('id') ,
							'rud' => $this->Auth->user('referred_by_user_id') ,
						)
					));
                    $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Contest Flag')) , 'default', null, 'success');
                    if (!$this->RequestHandler->isAjax()) {
                        $Contest = $this->ContestFlag->Contest->find('first', array(
                            'conditions' => array(
                                'Contest.id' => $this->request->data['ContestFlag']['contest_id']
                            ) ,
                            'recursive' => -1
                        ));
						if(!empty($this->request->params['named']['f']) && $this->request->params['named']['f'] == 'contest_users') {
							$this->redirect(array(
								'controller' => 'contest_users',
								'action' => 'add',
								$Contest['Contest']['slug'],
							));
						} else {
							$this->redirect(array(
								'controller' => 'contests',
								'action' => 'view',
								$Contest['Contest']['slug'],
							));
						}
                    } else {
                        $ajax_url = Router::url(array(
                            'controller' => 'contests',
                            'action' => 'view',
                            $Contest['Contest']['slug'],
                        ));
                        $success_msg = 'redirect*' . $ajax_url;
                        echo $success_msg;
                        exit;
                    }
                } else {
                    $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Contest Flag')) , 'default', null, 'error');
                }
            } else {
                if (!$this->RequestHandler->isAjax()) {
                    $this->Session->setFlash(__l('You have already reported this contest.') , 'default', null, 'error');
                    if(!empty($this->request->params['named']['f']) && $this->request->params['named']['f'] == 'contest_users') {
						$this->redirect(array(
							'controller' => 'contest_users',
							'action' => 'add',
							$Contest['Contest']['slug'],
						));
					} else {
						$this->redirect(array(
							'controller' => 'contests',
							'action' => 'view',
							$Contest['Contest']['slug'],
						));
					}
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'contests',
                        'action' => 'view',
                        $Contest['Contest']['slug'],
                    ));
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            }
        }
        $this->request->data['ContestFlag']['contest_id'] = !empty($this->request->data['ContestFlag']['contest_id']) ? $this->request->data['ContestFlag']['contest_id'] : $contest_id;
        $ContestFlagCategories = $this->ContestFlag->ContestFlagCategory->find('list', array(
            'conditions' => array(
                'ContestFlagCategory.is_active' => 1
            ) ,
			'recursive' => -1
        ));
        $ContestUsers = $this->ContestFlag->User->find('list');
		$this->set('Contest_add',$Contest_add);
        $this->set(compact('ContestFlagCategories'));
        $this->set(compact('ContestUsers'));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Contest Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['category'])) {
            $contestFlagCategory = $this->{$this->modelClass}->ContestFlagCategory->find('first', array(
                'conditions' => array(
                    'ContestFlagCategory.id' => $this->request->params['named']['category']
                ) ,
                'fields' => array(
                    'ContestFlagCategory.id',
                    'ContestFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($contestFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['ContestFlagCategory.id'] = $contestFlagCategory['ContestFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $contestFlagCategory['ContestFlagCategory']['name']);
        }
        if (!empty($this->request->params['named']['contest'])) {
            $contest = $this->{$this->modelClass}->Contest->find('first', array(
                'conditions' => array(
                    'Contest.slug' => $this->request->params['named']['contest']
                ) ,
                'fields' => array(
                    'Contest.id',
                    'Contest.name',
                    'Contest.slug'
                ) ,
                'recursive' => -1
            ));
            if (empty($contest)) {
                $conditions['Contest.id'] = 0;
            } else {
                $conditions['ContestFlag.contest_id'] = $contest['Contest']['id'];
            }
            $this->pageTitle.= ' - ' . __l(' User Flagged');
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
			$conditions['ContestFlag.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
			$conditions['ContestFlag.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
			$conditions['ContestFlag.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['ContestFlag.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
			$conditions['ContestFlag.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['ContestFlag.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Contest.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'ContestFlagCategory.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'ContestFlag.message LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->ContestFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User' => array(
                    'UserAvatar',
                ) ,
                'ContestFlagCategory' => array(
                    'fields' => array(
                        'ContestFlagCategory.name'
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
                'Contest' => array(
					'User' => array(
						'fields' => array(
                            'User.id',
                            'User.username',
                        )
					),
                    'ContestStatus' => array(
                        'fields' => array(
                            'ContestStatus.id',
                            'ContestStatus.name',
                            'ContestStatus.slug',
                        )
                    ) ,
                    'fields' => array(
						'Contest.id',
                        'Contest.name',
                        'Contest.slug'
                    ) ,
                )
            ) ,
            'order' => array(
                'ContestFlag.id' => 'desc'
            )
        );
        $this->set('contestFlags', $this->paginate());
        $moreActions = $this->ContestFlag->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestFlag->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s has been deleted'), __l('Contest Flag')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>