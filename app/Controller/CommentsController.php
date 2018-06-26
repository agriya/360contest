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
class CommentsController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Comments';
    /**
     * Components
     *
     * @var array
     * @access public
     */
    public $components = array(
        'Akismet',
        'Email',
    );
    public $permanentCacheAction = array(
        'admin' => array(
            'index',
        )
    );
    public function beforeFilter()
    {
        parent::beforeFilter();
        if ($this->action == 'admin_edit') {
            $this->Security->disabledFields = array(
                'ip'
            );
        }
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Comments');
        $conditions = array();
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Publish) {
                $conditions['Comment.status'] = 1;
                $this->pageTitle.= ' - ' . __l('Publish');
            } elseif ($this->request->params['named']['filter_id'] == ConstMoreAction::Unpublish) {
                $conditions['Comment.status'] = 0;
                $this->pageTitle.= ' - ' . __l('Unpublish');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Node'
            ) ,
            'order' => array(
                'Comment.created' => 'DESC'
            ) ,
            'recursive' => 0
        );
        $comments = $this->paginate();
        $this->set(compact('comments'));
        $this->set('publish', $this->Comment->find('count', array(
            'conditions' => array(
                'Comment.status' => 1,
            ) ,
            'recursive' => -1
        )));
        $this->set('unpublish', $this->Comment->find('count', array(
            'conditions' => array(
                'Comment.status' => 0,
            ) ,
            'recursive' => -1
        )));
        $moreActions = $this->Node->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Comment');
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__l('Invalid Comment') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Comment->save($this->request->data)) {
                $this->Session->setFlash(__l('Comment has been saved') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Comment could not be saved. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Comment->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Comment->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Comment')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_process()
    {
        $action = $this->request->data['Comment']['action'];
        $ids = array();
        foreach($this->request->data['Comment'] as $id => $value) {
            if ($id != 'action' && $value['id'] == 1) {
                $ids[] = $id;
            }
        }
        if (count($ids) == 0 || $action == null) {
            $this->Session->setFlash(__l('No items selected.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if ($action == 'delete' && $this->Comment->deleteAll(array(
            'Comment.id' => $ids
        ) , true, true)) {
            $this->Session->setFlash(__l('Comments deleted.') , 'default', null, 'success');
        } elseif ($action == 'publish' && $this->Comment->updateAll(array(
            'Comment.status' => true
        ) , array(
            'Comment.id' => $ids
        ))) {
            $this->Session->setFlash(__l('Comments published') , 'default', null, 'success');
        } elseif ($action == 'unpublish' && $this->Comment->updateAll(array(
            'Comment.status' => false
        ) , array(
            'Comment.id' => $ids
        ))) {
            $this->Session->setFlash(__l('Comments unpublished') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('An error occurred.') , 'default', null, 'error');
        }
        $this->redirect(array(
            'action' => 'index'
        ));
    }
    public function index()
    {
        $this->pageTitle = __l('Comments');
        if (!isset($this->request['ext']) || $this->request['ext'] != 'rss') {
            $this->redirect('/');
        }
        $this->paginate = array(
            'conditions' => array(
                'Comment.status' => 1,
            ) ,
            'order' => array(
                'Comment.created' => 'desc'
            )
        );
        $comments = $this->paginate();
        $this->set(compact('comments'));
    }
    public function add($nodeId = null, $parentId = null)
    {
        if (!$nodeId) {
            $this->Session->setFlash(__l('Invalid Node') , 'default', null, 'error');
            $this->redirect('/');
        }
        $node = $this->Comment->Node->find('first', array(
            'conditions' => array(
                'Node.id' => $nodeId,
                'Node.status' => 1,
            ) ,
			'recursive' => -1
        ));
        if (!isset($node['Node']['id'])) {
            $this->Session->setFlash(__l('Invalid Node') , 'default', null, 'error');
            $this->redirect('/');
        }
        if ($parentId) {
            $commentPath = $this->Comment->getPath($parentId, array(
                'Comment.id'
            ));
            $commentLevel = count($commentPath);
            if ($commentLevel > Configure::read('Comment.level')) {
                $this->Session->setFlash(__l('Maximum level reached. You cannot reply to that comment.') , 'default', null, 'error');
                $this->redirect($node['Node']['url']);
            }
        }
        $type = $this->Comment->Node->Taxonomy->Vocabulary->Type->findByAlias($node['Node']['type']);
        $continue = false;
        if ($type['Type']['comment_status'] && $node['Node']['comment_status']) {
            $continue = true;
        }
        // spam protection
        $continue = $this->_spam_protection($continue, $type, $node);
        $success = 0;
        if (!empty($this->request->data) && $continue === true) {
            $data = array();
            if ($parentId && $this->Comment->hasAny(array(
                'Comment.id' => $parentId,
                'Comment.node_id' => $nodeId,
                'Comment.status' => 1,
            ))) {
                $data['parent_id'] = $parentId;
            }
            $data['node_id'] = $nodeId;
            if ($this->Session->check('Auth.User.id')) {
                $data['user_id'] = $this->Session->read('Auth.User.id');
                $data['name'] = $this->Session->read('Auth.User.name');
                $data['email'] = $this->Session->read('Auth.User.email');
                $data['website'] = $this->Session->read('Auth.User.website');
            } else {
                $data['name'] = htmlspecialchars($this->request->data['Comment']['name']);
                $data['email'] = $this->request->data['Comment']['email'];
                $data['website'] = $this->request->data['Comment']['website'];
            }
            $data['captcha'] = $this->request->data['Comment']['captcha'];
            $data['body'] = htmlspecialchars($this->request->data['Comment']['body']);
            $data['ip'] = $_SERVER['REMOTE_ADDR'];
            $data['type'] = $node['Node']['type'];
            if ($type['Type']['comment_approve']) {
                $data['status'] = 1;
            } else {
                $data['status'] = 0;
            }
            if ($this->Comment->save($data)) {
                $success = 1;
                if ($type['Type']['comment_approve']) {
                    $this->Session->setFlash(__l('Your comment has been added successfully.') , 'default', null, 'success');
                } else {
                    $this->Session->setFlash(__l('Your comment will appear after moderation.') , 'default', null, 'success');
                }
                $emailFindReplace = array(
                    '##NODE_TITLE##' => $node['Node']['title'],
                    '##COMMENT_URL##' => Router::url($node['Node']['url'], true) . '#comment-' . $commentId,
                    '##NAME##' => $data['name'],
                    '##EMAIL##' => $data['email'],
                    '##WEBSITE##' => $data['website'],
                    '##IP##' => $data['ip'],
                    '##COMMENT##' => $data['name'],
                );
				App::import('Model', 'EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				$template = $this->EmailTemplate->selectTemplate('New Comment Notification');
                $this->Comment->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
                $this->redirect(Router::url($node['Node']['url'], true) . '#comment-' . $this->Comment->id);
            }
        }
        $this->set(compact('success', 'node', 'type', 'nodeId', 'parentId'));
    }
    protected function _spam_protection($continue, $type, $node)
    {
        if (!empty($this->request->data) && $type['Type']['comment_spam_protection'] && $continue === true) {
            $this->Akismet->setCommentAuthor($this->request->data['Comment']['name']);
            $this->Akismet->setCommentAuthorEmail($this->request->data['Comment']['email']);
            $this->Akismet->setCommentAuthorURL($this->request->data['Comment']['website']);
            $this->Akismet->setCommentContent($this->request->data['Comment']['body']);
            //$this->Akismet->setPermalink(Router::url($node['Node']['url'], true));
            if ($this->Akismet->isCommentSpam()) {
                $continue = false;
                $this->Session->setFlash(__l('Sorry, the comment appears to be spam.') , 'default', null, 'error');
            }
        }
        return $continue;
    }
    public function delete($id)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $success = 0;
        if ($this->Session->check('Auth.User.id')) {
            $userId = $this->Session->read('Auth.User.id');
            $comment = $this->Comment->find('first', array(
                'conditions' => array(
                    'Comment.id' => $id,
                    'Comment.user_id' => $userId,
                ) ,
				'recursive' => -1
            ));
            if (isset($comment['Comment']['id']) && $this->Comment->delete($id)) {
                $success = 1;
            }
        }
        $this->set(compact('success'));
    }
}
