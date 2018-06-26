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
class UserLoginsController extends AppController
{
    public $name = 'UserLogins';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $conditions = array();
        // check the filer passed through named parameter
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'day') {
			$conditions['UserLogin.created >= '] = date('Y-m-d 00:00:00', strtotime('now'));
			$conditions['UserLogin.created <= '] = date('Y-m-d 23:59:59', strtotime('now'));
            $this->pageTitle.= __l(' - today');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'week') {
			$conditions['UserLogin.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['UserLogin.created >= '] = date('Y-m-d 00:00:00', strtotime('now -7 days'));
            $this->pageTitle.= __l('- in this week');
        }
        if (!empty($this->request->params['named']['stat']) && $this->request->params['named']['stat'] == 'month') {
			$conditions['UserLogin.created <= '] = date('Y-m-d H:is', strtotime('now'));
			$conditions['UserLogin.created >= '] = date('Y-m-d 00:00:00', strtotime('now -30 days'));
            $this->pageTitle.= __l(' - in this month');
        }
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::OpenID) {
                $conditions['User.is_openid_register'] = 1;
                $this->pageTitle.= __l(' - Login through OpenID ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['User.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Twitter) {
                $conditions['User.twitter_user_id != '] = 0;
                $this->pageTitle.= __l(' - Login through Twitter ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Facebook) {
                $conditions['User.facebook_user_id !='] = 0;
                $this->pageTitle.= __l(' - Login through Facebook ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Gmail) {
                $conditions['User.is_google_register !='] = 0;
                $this->pageTitle.= __l(' - Login through Gmail ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Yahoo) {
                $conditions['User.is_yahoo_register !='] = 0;
                $this->pageTitle.= __l(' - Login through Yahoo ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::LinkedIn) {
                $conditions['User.is_linkedin_register !='] = 0;
                $this->pageTitle.= __l(' - Login through Yahoo ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['User.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Normal) {
                $conditions['User.is_yahoo_register'] = 0;
                $conditions['User.is_google_register'] = 0;
                $conditions['User.is_openid_register'] = 0;
                $conditions['User.is_facebook_register'] = 0;
                $conditions['User.is_twitter_register'] = 0;
				$conditions['User.is_linkedin_register'] = 0;
                $this->pageTitle.= __l(' - Normal Users ');
            }
            $this->request->params['named']['filter_id'] = $this->request->params['named']['filter_id'];
        }
        $this->pageTitle = __l('User Logins');
        if (!empty($this->request->params['named']['username']) || !empty($this->request->params['named']['user_id'])) {
            $userConditions = !empty($this->request->params['named']['username']) ? array(
                'User.username' => $this->request->params['named']['username']
            ) : array(
                'User.id' => $this->request->params['named']['user_id']
            );
            $user = $this->{$this->modelClass}->User->find('first', array(
                'conditions' => $userConditions,
                'fields' => array(
                    'User.id',
                    'User.username'
                ) ,
                'recursive' => -1
            ));
            if (empty($user)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['User.id'] = $this->request->data[$this->modelClass]['user_id'] = $user['User']['id'];
            $this->pageTitle.= ' - ' . $user['User']['username'];
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Ip.ip LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'UserLogin.user_agent LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['UserLogin']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->UserLogin->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
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
                'User' => array(
                    'UserAvatar',
                )
            ) ,
            'order' => array(
                'UserLogin.id' => 'desc'
            ) ,
        );
        $this->set('userLogins', $this->paginate());
        $moreActions = $this->UserLogin->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->UserLogin->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('User Login')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>