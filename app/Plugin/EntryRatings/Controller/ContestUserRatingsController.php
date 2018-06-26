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
class ContestUserRatingsController extends AppController
{
    public $name = 'ContestUserRatings';
    public function add($contest_user_id = null, $rate = null)
    {
        if (is_null($contest_user_id) || is_null($rate)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (($rate > 5) || ($rate < 1)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contestUser = $this->ContestUserRating->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $contest_user_id
            ) ,
            'contain' => array(
                'ContestUserRating' => array(
                    'fields' => array(
                        'ContestUserRating.user_id'
                    ) ,
                    'conditions' => array(
                        'ContestUserRating.user_id' => $this->Auth->user('id')
                    )
                ) ,
                'Contest' => array(
                    'fields' => array(
                        'Contest.id',
                        'Contest.name',
                        'Contest.slug',
                        'Contest.description',
                        'Contest.user_id',
                        'Contest.contest_status_id'
                    ) ,
                ) ,
            ) ,
            'recursive' => 1
        ));
        if (empty($contestUser) || ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated || $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) || $contestUser['Contest']['contest_status_id'] != ConstContestStatus::Open || $this->Auth->user('id')== $contestUser['ContestUser']['user_id']) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($contestUser)) {
            if (empty($contestUser['ContestUserRating'])) {
                $this->ContestUserRating->create();
                $this->request->data['ContestUserRating']['user_id'] = $this->Auth->user('id');
                $this->request->data['ContestUserRating']['rating'] = $rate;
                $this->request->data['ContestUserRating']['contest_user_id'] = $contest_user_id;
                $this->request->data['ContestUserRating']['ip_id'] = $this->ContestUserRating->toSaveIp();
                if ($this->ContestUserRating->save($this->request->data)) {
                    $this->ContestUserRating->ContestUser->updateAll(array(
                        'ContestUser.contest_user_total_ratings ' => 'ContestUser.contest_user_total_ratings  + ' . $rate
                    ) , array(
                        'ContestUser.id' => $contest_user_id
                    ));
					Cms::dispatchEvent('Controller.IntegratedGoogleAnalytics.trackEvent', $this, array(
						'_trackEvent' => array(
							'category' => 'User',
							'action' => 'Voted',
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
							'category' => 'EntryRating',
							'action' => 'Voted',
							'label' => $contestUser['ContestUser']['id'],
							'value' => '',
						) ,
						'_setCustomVar' => array(
							'cud' => $contestUser['ContestUser']['id'],
							'ud' => $this->Auth->user('id') ,
							'rud' => $this->Auth->user('referred_by_user_id') ,
						)
					));
					if ($this->RequestHandler->prefers('json')) {
							$response = array(
							'status' => 0,
							'message' => sprintf(__l('%s has been added'), __l('Rating')) ,
							);
						$this->view = 'Json';
						$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
					} elseif($this->RequestHandler->isAjax()) {
						$response = array(
							'status' => 0,
							'message' => sprintf(__l('%s has been added'), __l('Rating')) ,
							);
					} else {
						$this->Session->setFlash(sprintf(__l('%s has been added'), __l('Rating')) , 'default', null, 'success');
					}
                    $post_data = $this->ContestUserRating->ContestUser->find('first', array(
                        'conditions' => array(
                            'ContestUser.id' => $contest_user_id
                        ) ,
                        'contain' => array(
                            'ContestUserRating' => array(
                                'User' => array(
                                    'fields' => array(
                                        'User.id',
                                        'User.username',
										'User.is_facebook_register',
										'User.facebook_user_id',
										'User.twitter_avatar_url',
										'User.linkedin_avatar_url'
                                    ) ,
                                ) ,
                                'conditions' => array(
                                    'ContestUserRating.id' => $this->ContestUserRating->getLastInsertId()
                                )
                            ) ,
                            'Contest' => array(
                                'User' => array(
                                    'fields' => array(
                                        'User.id',
                                        'User.username',
										'User.is_facebook_register',
										'User.facebook_user_id',
										'User.twitter_avatar_url',
										'User.linkedin_avatar_url'
                                    ) ,
                                ) ,
                            ) ,
                            'User' => array(
                                'fields' => array(
                                    'User.id',
                                    'User.username',
                                ) ,
                            )
                        ) ,
                        'recursive' => 2
                    ));
                    $contestUser = $this->ContestUserRating->ContestUser->find('all', array(
                        'conditions' => array(
                            'ContestUser.user_id' => $post_data['ContestUser']['user_id']
                        ) ,
                        'fields' => array(
                            'SUM(ContestUser.contest_user_total_ratings) as total_ratings',
                            'SUM(ContestUser.contest_user_rating_count) as rating_count',
                        ) ,
                        'recursive' => -1
                    ));
                    $this->ContestUserRating->User->updateAll(array(
                        'User.total_ratings' => $contestUser[0][0]['total_ratings'],
                        'User.rating_count' => $contestUser[0][0]['rating_count']
                    ) , array(
                        'User.id' => $post_data['ContestUser']['user_id']
                    ));
					$this->ContestUserRating->updatecount($contest_user_id);
                    $this->ContestUserRating->ContestUser->Contest->postActivity($post_data, ConstContestStatus::Rated, ConstContestStatus::Rated);
                } else {
        			if ($this->RequestHandler->prefers('json')) {
						$response = array(
						'status' => 1,
						'message' => sprintf(__l('%s could not be added. Please, try again.'), __l('Rating')) ,
						);
						$this->view = 'Json';
						$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
				    } elseif($this->RequestHandler->isAjax()) {
						$response = array(
						'status' => 1,
						'message' => sprintf(__l('%s could not be added. Please, try again.'), __l('Rating')) ,
						);
					} else {
						$this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Rating')) , 'default', null, 'error');
					}
                }
            } else {
				if ($this->RequestHandler->prefers('json')) {
						$response = array(
						'status' => 1,
						'message' => __l('You have already rated this entry.') ,
						);
						$this->view = 'Json';
						$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
				} elseif($this->RequestHandler->isAjax()) {
					$response = array(
						'status' => 1,
						'message' => __l('You have already rated this entry.') ,
						);
				} else {
					$this->Session->setFlash(__l('You have already rated this entry') , 'default', null, 'error');
				}
            }
            if ($this->RequestHandler->isAjax()) {
                $contestUser = $this->ContestUserRating->ContestUser->find('first', array(
                    'conditions' => array(
                        'ContestUser.id' => $contest_user_id
                    ) ,
                    'fields' => array(
                        'ContestUser.id',
                        'ContestUser.contest_user_total_ratings',
                        'ContestUser.contest_user_rating_count',
                    ) ,
                    'recursive' => -1
                ));
                $this->set('contestUser', $contestUser);
            } else {
				if (!$this->RequestHandler->prefers('json')) {
                $this->redirect(array(
                    'controller' => 'contests',
                    'action' => 'view',
                    $contestUser['Contest']['slug']
                ));
			  }
            }
        } else {
			if ($this->RequestHandler->prefers('json')) {
					$response = array(
					'status' => 1,
					'message' => __l('Invalid request.') ,
					);
					$this->view = 'Json';
					$this->set('json', (empty($this->viewVars['iphone_response'])) ? $response : $this->viewVars['iphone_response']);
			} else {
            throw new NotFoundException(__l('Invalid request'));
			}
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Entry Ratings');
        $this->_redirectGET2Named(array(
            'username',
            'q',
            'filter_id'
        ));
        unset($this->ContestUserRating->User->validate);
        $conditions = array();
        if (!empty($this->request->data['ContestUserRating']['user_id'])) {
            $this->request->params['named']['user_id'] = $this->request->data['ContestUserRating']['user_id'];
        }
        $param_string = "";
        $param_string.= !empty($this->request->params['named']['user_id']) ? '/user_id:' . $this->request->params['named']['user_id'] : $param_string;
        if (!empty($this->request->params['named']['user_id'])) {
            $conditions['ContestUserRating.user_id'] = $this->request->params['named']['user_id'];
            $this->request->data['ContestUserRating']['user_id'] = $this->request->params['named']['user_id'];
        }
        if (!empty($this->request->data['User']['username'])) {
            $get_user_id = $this->ContestUserRating->User->find('list', array(
                'conditions' => array(
                    'User.username' => $this->request->data['User']['username'],
                ) ,
                'fields' => array(
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_user_id)) {
                $conditions['ContestUserRating.user_id'] = $get_user_id;
            }
        }
        if (!empty($this->request->params['named']['entryid'])) {
            $conditions['ContestUserRating.contest_user_id'] = $this->request->params['named']['entryid'];
        }
        if (!empty($this->request->params['named']['q'])) {
			$get_contest_id = $this->ContestUserRating->ContestUser->Contest->find('list', array(
                'conditions' => array(
                    'Contest.name LIKE' => '%'. $this->request->params['named']['q']. '%',
                ) ,
                'fields' => array(
                    'Contest.id',
                ) ,
                'recursive' => -1
            ));
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
					array(
						'ContestUser.contest_id' => $get_contest_id
					),
                )
            );
            $this->request->data['ContestUserRating']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (isset($this->params['named']['filter_id'])) {
            $this->request->data['ContestUserRating']['filter_id'] = $this->params['named']['filter_id'];
        }
        if (!empty($this->request->data['ContestUserRating']['filter_id'])) {
            $conditions['ContestUser.contest_id'] = $this->request->data['ContestUserRating']['filter_id'];
        }
        if (isset($this->params['named']['username'])) {
            $get_user_id = $this->ContestUserRating->User->find('list', array(
                'conditions' => array(
                    'User.username' => $this->params['named']['username'],
                ) ,
                'fields' => array(
                    'User.id',
                ) ,
                'recursive' => -1
            ));
            if (!empty($get_user_id)) {
                $this->request->data['ContestUserRating']['user_id'] = $get_user_id;
            }
        }
        if (!empty($this->request->data['ContestUserRating']['user_id'])) {
            $conditions['ContestUserRating.user_id'] = $this->request->data['ContestUserRating']['user_id'];
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'ContestUser' => array(
                    'Attachment',
                    'ContestUserStatus',
                    'Contest' => array(
                        'ContestStatus',
                        'Resource',
                        'fields' => array(
                            'Contest.id',
                            'Contest.name',
                            'Contest.slug',
                            'Contest.contest_status_id',
                            'Contest.user_id',
                        ) ,
                        'ContestType' => array(
                            'fields' => array(
                                'ContestType.id',
                                'ContestType.resource_id',
                                'ContestType.is_watermarked',
                            )
                        ) ,
                    ) ,
                    'User',
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
                    'fields' => array(
                        'Ip.ip',
                        'Ip.latitude',
                        'Ip.longitude',
                        'Ip.host'
                    )
                ) ,
            ) ,
            'order' => 'ContestUserRating.id desc',
            'recursive' => 3
        );
        $moreActions = $this->ContestUserRating->moreActions;
        $this->set(compact('filters', 'moreActions'));
        $this->set('contestUserRatings', $this->paginate());
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->ContestUserRating->id = $id;
        if (!$this->ContestUserRating->exists()) {
            throw new NotFoundException(__l('Invalid contest user rating'));
        }
        $ContestUserRating = $this->ContestUserRating->find('first', array(
            'conditions' => array(
                'ContestUserRating.id' => $id
            ) ,
            'fields' => array(
                'ContestUserRating.contest_user_id'
            ) ,
            'recursive' => -1,
        ));
        if ($this->ContestUserRating->delete()) {
            $this->ContestUserRating->updatecount($ContestUserRating['ContestUserRating']['contest_user_id']);
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Contest user rating')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
