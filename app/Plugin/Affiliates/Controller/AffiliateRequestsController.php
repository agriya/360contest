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
class AffiliateRequestsController extends AppController
{
    public $name = 'AffiliateRequests';
    public $components = array(
        'Email'
    );
    public function add() 
    {
        $status = 'add';
        if ($this->Auth->user('is_affiliate_user')) {
            $this->redirect(array(
                'controller' => 'affiliates',
                'action' => 'index'
            ));
        }
        $this->pageTitle = __l('Request Affiliate');
        if (!empty($this->request->data)) {
            if (empty($this->request->data['AffiliateRequest']['user_id'])) $this->request->data['AffiliateRequest']['user_id'] = $this->Auth->user('id');
            if ($this->AffiliateRequest->save($this->request->data)) {
                if (Configure::read('affiliate.is_admin_mail_after_affiliate_request')) {
                    $this->_sendAffiliateRequestMail($this->Auth->user('id'));
                }
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Affiliate Request')) , 'default', null, 'success');
                if (empty($this->request->params['isAjax'])) {
                    $this->redirect(array(
                        'controller' => 'affiliates',
                        'action' => 'index'
                    ));
                } else {
                    $ajax_url = Router::url(array(
                        'controller' => 'affiliates',
                        'action' => 'index'
                    ) , true);
                    $success_msg = 'redirect*' . $ajax_url;
                    echo $success_msg;
                    exit;
                }
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Affiliate Request')) , 'default', null, 'error');
            }
        }
        $user = $this->AffiliateRequest->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'fields' => array(
                'User.is_affiliate_user'
            ) ,
            'contain' => array(
                'AffiliateRequest'
            ) ,
            'recursive' => 1
        ));
        $pending_request = $reject_request = 0;
        if (!$user['User']['is_affiliate_user']) {
            if (!empty($user['AffiliateRequest'])) {
                $pending_request = $this->AffiliateRequest->find('count', array(
                    'conditions' => array(
                        'AffiliateRequest.user_id' => $this->Auth->user('id') ,
                        'AffiliateRequest.is_approved' => 0
                    ) ,
                    'recursive' => -1
                ));
                $reject_request = $this->AffiliateRequest->find('count', array(
                    'conditions' => array(
                        'AffiliateRequest.user_id' => $this->Auth->user('id') ,
                        'AffiliateRequest.is_approved' => 2
                    ) ,
                    'recursive' => -1
                ));
            }
            if (($pending_request == 0) && ($reject_request != 0)) {
                $status = 'rejected';
            } else if ($pending_request != 0) {
                $status = 'pending';
            } else {
                $status = 'add';
            }
        } else {
            $status = 'add';
        }
        if (!empty($this->request->data)) {
            $status = 'add';
        }
        $siteCategories = $this->AffiliateRequest->SiteCategory->find('list');
        $this->set(compact('siteCategories'));
        $this->set('status', $status);
    }
    public function admin_index() 
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Affiliate Requests');
        $conditions = array();
        $this->set('waiting_for_approval', $this->AffiliateRequest->find('count', array(
            'conditions' => array(
                'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Pending,
            ) ,
            'recursive' => -1
        )));
        $this->set('approved', $this->AffiliateRequest->find('count', array(
            'conditions' => array(
                'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Accepted,
            ) ,
            'recursive' => -1
        )));
        $this->set('rejected', $this->AffiliateRequest->find('count', array(
            'conditions' => array(
                'AffiliateRequest.is_approved = ' => ConstAffiliateRequests::Rejected,
            ) ,
            'recursive' => -1
        )));
        $this->set('all', $this->AffiliateRequest->find('count', array(
            'recursive' => -1
        )));
        if (isset($this->request->params['named']['main_filter_id'])) {
            if ($this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Pending) {
                $conditions['AffiliateRequest.is_approved'] = ConstAffiliateRequests::Pending;
                $this->pageTitle.= ' - ' . __l('Waiting for Approval');
            } elseif ($this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Accepted) {
                $conditions['AffiliateRequest.is_approved'] = ConstAffiliateRequests::Accepted;
                $this->pageTitle.= ' - ' . __l('Approved');
            } elseif ($this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Rejected) {
                $conditions['AffiliateRequest.is_approved'] = ConstAffiliateRequests::Rejected;
                $this->pageTitle.= ' - ' . __l('Disapproved');
            }
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['AffiliateRequest']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        if (isset($this->request->params['named']['is_approved'])) {
            $conditions['AffiliateRequest.is_approved'] = $this->request->params['named']['is_approved'];
        }
        if (isset($this->request->data['AffiliateRequest']['q'])) {
            $conditions['OR']['AffiliateRequest.site_name LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['AffiliateRequest.site_description LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['AffiliateRequest.site_url LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['User.username LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
            $conditions['OR']['SiteCategory.name LIKE '] = '%' . $this->request->data['AffiliateRequest']['q'] . '%';
        }
        $this->AffiliateRequest->recursive = 2;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'AffiliateRequest.id' => 'desc'
            )
        );
        $moreActions = $this->AffiliateRequest->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('affiliateRequests', $this->paginate());
    }
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Affiliate Request'));
        if (!empty($this->request->data)) {
            $this->AffiliateRequest->create();
            if ($this->AffiliateRequest->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Affiliate Request')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Affiliate Request')) , 'default', null, 'error');
            }
        }
        $users = $this->AffiliateRequest->User->find('list');
        $siteCategories = $this->AffiliateRequest->SiteCategory->find('list');
        $this->set(compact('users', 'siteCategories'));
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Affiliate Request'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->AffiliateRequest->save($this->request->data)) {
                $ids[] = $this->request->data['AffiliateRequest']['id'];
                if ($this->request->data['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Rejected) {
                    $user_update = 0;
                } else if ($this->request->data['AffiliateRequest']['is_approved'] == ConstAffiliateRequests::Pending) {
                    $user_update = 0;
                } else {
                    $user_update = 1;
                }
                $this->__updateAffiliateUser($ids, $user_update);
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Affiliate Request')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Affiliate Request')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->AffiliateRequest->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $users = $this->AffiliateRequest->User->find('list');
        $siteCategories = $this->AffiliateRequest->SiteCategory->find('list');
        $this->set(compact('users', 'siteCategories'));
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->AffiliateRequest->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Affiliate Request')) , 'default', null, 'success');
            if (!empty($this->request->query['r'])) {
                $this->redirect(Router::url('/', true) . $this->request->query['r']);
            } else {
                $this->redirect(array(
                    'action' => 'index'
                ));
            }
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_update() 
    {
        if (!empty($this->request->data[$this->modelClass])) {
            $r = $this->request->data[$this->modelClass]['r'];
            $actionid = $this->request->data[$this->modelClass]['more_action_id'];
            unset($this->request->data[$this->modelClass]['r']);
            unset($this->request->data[$this->modelClass]['more_action_id']);
            $ids = array();
            foreach($this->request->data[$this->modelClass] as $id => $is_checked) {
                if ($is_checked['id']) {
                    $ids[] = $id;
                }
            }
            if ($actionid && !empty($ids)) {
                switch ($actionid) {
                    case ConstMoreAction::Disapproved:
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->save(array(
                                $this->modelClass => array(
                                    'is_approved' => ConstAffiliateRequests::Rejected,
                                    'id' => $id
                                )
                            ));
                        }
                        $this->__updateAffiliateUser($ids, 0);
                        $this->Session->setFlash(__l('Checked records has been disapproved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Approved:
                        $this->__updateAffiliateUser($ids, 1);
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->save(array(
                                $this->modelClass => array(
                                    'is_approved' => ConstAffiliateRequests::Accepted,
                                    'id' => $id
                                )
                            ));
                        }
                        $this->Session->setFlash(__l('Checked records has been approved') , 'default', null, 'success');
                        break;

                    case ConstMoreAction::Delete:
                        $this->__updateAffiliateUser($ids, 0);
                        foreach($ids as $id) {
                            $this->{$this->modelClass}->deleteAll(array(
                                $this->modelClass . '.id' => $id
                            ));
                        }
                        $this->Session->setFlash(__l('Checked records has been deleted') , 'default', null, 'success');
                        break;
                }
            }
        }
        $this->redirect(Router::url('/', true) . $r);
    }
    public function __updateAffiliateUser($ids, $status) 
    {
        foreach($ids as $id) {
            $affiliateRequest = $this->AffiliateRequest->find('first', array(
                'conditions' => array(
                    'AffiliateRequest.id' => $id
                ) ,
                'recursive' => -1
            ));
            $data['User']['id'] = $affiliateRequest['AffiliateRequest']['user_id'];
            $data['User']['is_affiliate_user'] = $status;
            $this->AffiliateRequest->User->save($data, false);
        }
    }
    public function _sendAffiliateRequestMail($user_id) 
    {
        // @todo "User activation" check user.is_send_email_notifications_only_to_verified_email_account
        $user = $this->AffiliateRequest->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
        $this->loadModel('EmailTemplate');
        $email = $this->EmailTemplate->selectTemplate('Affiliate Request');
        $emailFindReplace = array(
            '##USERNAME##' => $user['User']['username'],
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_LINK##' => Router::url('/', true) ,
            '##FROM_EMAIL##' => ($email['from'] == '##FROM_EMAIL##') ? Configure::read('site.from_email') : $email['from'],
            '##CONTACT_URL##' => Router::url(array(
                'controller' => 'contacts',
                'action' => 'add'
            ) , true) ,
            '##SITE_LOGO##' => Router::url(array(
                'controller' => 'img',
                'action' => 'logo.png',
                'admin' => false
            ) , true) ,
        );
        App::uses('CakeEmail', 'Network/Email');
        $this->Email = new CakeEmail();
        $this->Email->from(($email['from'] == '##FROM_EMAIL##') ? $user['User']['email'] : $email['from']);
        $this->Email->replyTo(($email['reply_to'] == '##REPLY_TO_EMAIL##') ? $user['User']['email'] : $email['reply_to']);
        $this->Email->to(Configure::read('site.from_email'));
        $this->Email->subject(strtr($email['subject'], $emailFindReplace));
        $this->Email->emailFormat(($email['is_html']) ? 'html' : 'text');
        if ($this->Email->send(strtr($email['email_content'], $emailFindReplace))) {
            return true;
        }
    }
}
?>