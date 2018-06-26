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
class ContestUserFlagCategoriesController extends AppController
{
    public $name = 'ContestUserFlagCategories';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $this->pageTitle = __l('Entry Flag Categories');
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $conditions[$this->modelClass . '.is_active'] = 1;
                $this->pageTitle.= __l(' - Approved');
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $conditions[$this->modelClass . '.is_active'] = 0;
                $this->pageTitle.= __l(' - Unapproved');
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        $this->ContestUserFlagCategory->recursive = -1;
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'ContestUserFlagCategory.id' => 'desc'
            ) ,
            'recursive' => -1
        );
        $this->set('contestUserFlagCategories', $this->paginate());
        $filters = $this->ContestUserFlagCategory->isFilterOptions;
        $moreActions = $this->ContestUserFlagCategory->moreActions;
        $this->set(compact('moreActions', 'filters'));
        $this->set('pending', $this->ContestUserFlagCategory->find('count', array(
            'conditions' => array(
                'ContestUserFlagCategory.is_active' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->ContestUserFlagCategory->find('count', array(
            'conditions' => array(
                'ContestUserFlagCategory.is_active' => 1
            ),
			'recursive' => -1
        )));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Entry Flag Category');
        if (!empty($this->request->data)) {
            $this->ContestUserFlagCategory->create();
            if ($this->ContestUserFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Entry Flag Category')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Entry Flag Category')) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Entry Flag Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->ContestUserFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Entry Flag Category')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Entry Flag Category')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ContestUserFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['ContestUserFlagCategory']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->ContestUserFlagCategory->id = $id;
        if ($this->ContestUserFlagCategory->delete()) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Entry Flag Category')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>