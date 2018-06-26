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
class RelationshipsController extends AppController
{
    public $name = 'Relationships';
    public function admin_index() 
    {
        $this->pageTitle = __l('Relationships');
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $conditions[$this->modelClass . '.is_active'] = 1;
                $this->pageTitle.= ' - ' . __l('Active');
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $conditions[$this->modelClass . '.is_active'] = 0;
                $this->pageTitle.= ' - ' . __l('Inactive');
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        $this->Relationship->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'Relationship.id',
                'Relationship.relationship',
                'Relationship.is_active'
            ) ,
            'order' => array(
                'Relationship.id' => 'desc'
            )
        );
        $this->set('userRelationships', $this->paginate());
        $filters = $this->Relationship->isFilterOptions;
        $moreActions = $this->Relationship->moreActions;
        $this->set('filters', $filters);
        $this->set('moreActions', $moreActions);
        $this->set('pending', $this->Relationship->find('count', array(
            'conditions' => array(
                'Relationship.is_active' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->Relationship->find('count', array(
            'conditions' => array(
                'Relationship.is_active' => 1
            ),
			'recursive' => -1
        )));
        $this->set('pageTitle', $this->pageTitle);
        $this->pageTitle = __l('Relationships');
        $this->Relationship->recursive = 0;
        $this->set('userRelationships', $this->paginate());
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Relationship'));
        $this->Relationship->create();
        if (!empty($this->request->data)) {
            if ($this->Relationship->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Relationship')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Relationship')) , 'default', null, 'error');
            }
        }
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Relationship'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->Relationship->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Relationship')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Relationship')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Relationship->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_delete($id = null) 
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Relationship->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Relationship')) , 'default', null, 'success');
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
}
?>