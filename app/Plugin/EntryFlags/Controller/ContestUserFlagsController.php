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
class ContestUserFlagsController extends AppController
{
    public $name = 'ContestUserFlags';
    public $permanentCacheAction = array(
        'admin' => array(
            'add',
        ) ,
    );
    public function add($contest_user_id = null, $slug = null)
    {
		if(!empty($contest_user_id)){
			$ContestUser = $this->ContestUserFlag->ContestUser->find('first',array(
				'conditions' => array(
					'ContestUser.id' => $contest_user_id
				),
				'contain' => array(
					'Contest'
				),
				'recursive' => 0
			));
			if(empty($ContestUser) || !empty($ContestUser['ContestUser']['admin_suspend']) || $ContestUser['ContestUser']['contest_user_status_id'] ==ConstContestUserStatus::Eliminated || $ContestUser['ContestUser']['contest_user_status_id'] ==ConstContestUserStatus::Withdrawn || !empty($ContestUser['Contest']['admin_suspend'])){
				throw new NotFoundException(__l('Invalid request'));
			}
		}
        if (!empty($this->request->data)) {
            if (empty($this->request->data['ContestUserFlag']['contest_user_id'])) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $contest_user = $this->ContestUserFlag->find('first', array(
                'fields' => array(
                    'ContestUserFlag.id',
                ) ,
                'conditions' => array(
                    'ContestUserFlag.contest_user_id' => $this->request->data['ContestUserFlag']['contest_user_id'],
                    'ContestUserFlag.user_id' => $this->Auth->user('id')
                )
            ));
            $contest = $this->ContestUserFlag->ContestUser->find('first', array(
                'fields' => array(
                    'ContestUser.user_id',
                ) ,
                'conditions' => array(
                    'ContestUser.id' => $this->request->data['ContestUserFlag']['contest_user_id'],
                ) ,
                'recursive' => -1
            ));
            $userid = $this->Auth->user('id');
            if ($userid != $contest['ContestUser']['user_id']) {
                if (empty($contest_user)) {
                    $this->ContestUserFlag->create();
                    $this->request->data['ContestUserFlag']['user_id'] = $this->Auth->user('id');
                    $this->request->data['ContestUserFlag']['ip_id'] = $this->ContestUserFlag->toSaveIp();
                    if ($this->ContestUserFlag->save($this->request->data)) {
                        $_Data['ContestUser']['id'] = $this->request->data['ContestUserFlag']['contest_user_id'];
                        $_Data['ContestUser']['is_user_flagged'] = 1;
                        $this->ContestUserFlag->ContestUser->save($_Data);
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
								'category' => 'EntryFlag',
								'action' => 'Flagged',
								'label' => $contest_user['ContestUser']['id'],
								'value' => '',
							) ,
							'_setCustomVar' => array(
								'cud' => $contest_user['ContestUser']['id'],
								'ud' => $this->Auth->user('id') ,
								'rud' => $this->Auth->user('referred_by_user_id') ,
							)
						));
                        $this->Session->setFlash(__l('Entry Flag has been added') , 'default', null, 'success');
						if (!$this->RequestHandler->isAjax()) {
							if($this->request->data['ContestUserFlag']['entry']!='') {
								$this->redirect(array(
									'controller' => 'contest_users',
									'action' => 'view',
									$this->request->params['pass']['1'],
									'entry'=>$this->request->data['ContestUserFlag']['entry'],
									'page'=>$this->request->data['ContestUserFlag']['page'],
								));
							} else { 
								$this->redirect(array(
									'controller' => 'contests',
									'action' => 'view',
									$this->request->params['pass']['1'],						
								));
							}
						} else {
							if($this->request->data['ContestUserFlag']['entry']!='') {
								$ajax_url = Router::url(array(
									'controller' => 'contest_users',
									'action' => 'view',
									$this->request->params['pass']['1'],
									'entry'=>$this->request->data['ContestUserFlag']['entry'],
									'page'=>$this->request->data['ContestUserFlag']['page'],
								));
							} else { 
								$ajax_url = Router::url(array(
									'controller' => 'contests',
									'action' => 'view',
									$this->request->params['pass']['1'],						
								));
							}

							$success_msg = 'redirect*' . $ajax_url;
							echo $success_msg;
							exit;
						}
                    } else {
                        $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Entry Flag')) , 'default', null, 'error');
                    }
                } else {
					$this->Session->setFlash(__l('You have already reported this entry.') , 'default', null, 'error');
					if (!$this->RequestHandler->isAjax()) {
						if($this->request->data['ContestUserFlag']['entry']!='') {
							$this->redirect(array(
								'controller' => 'contest_users',
								'action' => 'view',
								$this->request->params['pass']['1'],
								'entry'=>$this->request->data['ContestUserFlag']['entry'],
								'page'=>$this->request->data['ContestUserFlag']['page'],
							));
						} else { 
							$this->redirect(array(
								'controller' => 'contests',
								'action' => 'view',
								$this->request->params['pass']['1'],
							));
						}
					} else {

if($this->request->data['ContestUserFlag']['entry']!='') {
							$ajax_url = Router::url(array(
								'controller' => 'contest_users',
								'action' => 'view',
								$this->request->params['pass']['1'],
								'entry'=>$this->request->data['ContestUserFlag']['entry'],
								'page'=>$this->request->data['ContestUserFlag']['page'],
							));
						} else { 
							$ajax_url = Router::url(array(
								'controller' => 'contests',
								'action' => 'view',
								$this->request->params['pass']['1'],
							));
						}


						$success_msg = 'redirect*' . $ajax_url;
						echo $success_msg;
						exit;
					}
                }
            } else {
                $this->Session->setFlash(__l('You could not flag your own entry.') , 'default', null, 'error');
                $this->redirect(array(
                    'controller' => 'contests',
                    'action' => 'view',
                    $this->request->params['pass']['1'],
                ));
            }
        }
		if (!empty($this->request->params['named']['page'])) {
            $this->request->data['ContestUserFlag']['page'] = $this->request->params['named']['page'];
        }   if (!empty($this->request->params['named']['entry'])) {
            $this->request->data['ContestUserFlag']['entry'] = $this->request->params['named']['entry'];
        } 
        $this->request->data['ContestUserFlag']['contest_user_id'] = !empty($this->request->data['ContestUserFlag']['contest_id']) ? $this->request->data['ContestUserFlag']['contest_id'] : $contest_user_id;
        $ContestUserFlagCategories = $this->ContestUserFlag->ContestUserFlagCategory->find('list', array(
            'conditions' => array(
                'ContestUserFlagCategory.is_active' => 1
            ) ,
        ));
        $users = $this->ContestUserFlag->User->find('list', array(
            'conditions' => array(
                'User.is_active' => 1
            ) ,
			'recursive' => -1
        ));
        $this->set(compact('ContestUserFlagCategories', 'users'));
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Entry Flags');
        $conditions = array();
        if (!empty($this->request->params['named']['entryid'])) {
            $conditions['ContestUserFlag.contest_user_id'] = $this->request->params['named']['entryid'];
        }
        if (!empty($this->request->params['named']['category'])) {
            $contest_userFlagCategory = $this->{$this->modelClass}->ContestUserFlagCategory->find('first', array(
                'conditions' => array(
                    'ContestUserFlagCategory.id' => $this->request->params['named']['category']
                ) ,
                'fields' => array(
                    'ContestUserFlagCategory.id',
                    'ContestUserFlagCategory.name'
                ) ,
                'recursive' => -1
            ));
            if (empty($contest_userFlagCategory)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['ContestUserFlagCategory.id'] = $contest_userFlagCategory['ContestUserFlagCategory']['id'];
            $this->pageTitle.= sprintf(__l(' - Category - %s') , $contest_userFlagCategory['ContestUserFlagCategory']['name']);
        }
        if (!empty($this->request->params['named']['contestid'])) {
            $contest_id = $this->{$this->modelClass}->ContestUser->find('first', array(
                'conditions' => array(
                    'ContestUser.contest_id' => $this->request->params['named']['contestid']
                ) ,
                'fields' => array(
                    'ContestUser.contest_id'
                ) ,
                'recursive' => 1
            ));
            $conditions['ContestUser.contest_id'] = $contest_id['ContestUser']['contest_id'];
        }
        if (!empty($this->request->params['named']['entry_id'])) {
            $conditions['ContestUser.id'] = $this->request->params['named']['entry_id'];
            $this->pageTitle.= ' - ' . __l(' User Flagged');
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
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
			$conditions['ContestUserFlag.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
			$conditions['ContestUserFlag.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
            $this->pageTitle.= __l(' - Added today');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
			$conditions['ContestUserFlag.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['ContestUserFlag.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
            $this->pageTitle.= __l(' - Added in this week');
        }
        if (isset($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
			$conditions['ContestUserFlag.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['ContestUserFlag.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - Added in this month');
        }
        if (isset($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'ContestUserFlagCategory.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'ContestUserFlag.message LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestUserFlag']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->ContestUserFlag->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'ContestUserFlagCategory' => array(
                    'fields' => array(
                        'ContestUserFlagCategory.name'
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
                'ContestUser' => array(
                    'Attachment',
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
                )
            ) ,
            'recursive' => 4,
            'order' => array(
                'ContestUserFlag.id' => 'desc'
            )
        );
        $this->set('contest_userFlags', $this->paginate());
        $moreActions = $this->ContestUserFlag->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestUserFlag->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s has been deleted'), __l('Entry Flag')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>