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
class ContestFlagCategoriesController extends AppController
{
    public $name = 'ContestFlagCategories';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id'
        ));
        $this->pageTitle = __l('Contest Flag Categories');
        $conditions = array();
        if (isset($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $conditions[$this->modelClass . '.is_active'] = 1;
                $this->pageTitle.= __l(' - Active');
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $conditions[$this->modelClass . '.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive');
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        $this->ContestFlagCategory->recursive = -1;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'ContestFlagCategory.id',
                'ContestFlagCategory.name',
                'ContestFlagCategory.contest_flag_count',
                'ContestFlagCategory.is_active'
            ) ,
            'order' => array(
                'ContestFlagCategory.id' => 'desc'
            )
        );
        $this->set('contestFlagCategories', $this->paginate());
        $filters = $this->ContestFlagCategory->isFilterOptions;
        $moreActions = $this->ContestFlagCategory->moreActions;
        $this->set(compact('moreActions', 'filters'));
        $this->set('pending', $this->ContestFlagCategory->find('count', array(
            'conditions' => array(
                'ContestFlagCategory.is_active' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->ContestFlagCategory->find('count', array(
            'conditions' => array(
                'ContestFlagCategory.is_active' => 1
            ),
			'recursive' => -1
        )));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Contest Flag Category');
        if (!empty($this->request->data)) {
            $this->ContestFlagCategory->create();
            if ($this->ContestFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Contest Flag Category')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Contest Flag Category')) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Contest Flag Category');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->ContestFlagCategory->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Contest Flag Category')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Contest Flag Category')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ContestFlagCategory->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['ContestFlagCategory']['name'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->ContestFlagCategory->id = $id;
        if ($this->ContestFlagCategory->delete()) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Contest Flag Category')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>