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
class IncomeRangesController extends AppController
{
    public $name = 'IncomeRanges';
    public function admin_index() 
    {
        $this->pageTitle = __l('Income Ranges');
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
        $this->IncomeRange->recursive = 1;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'IncomeRange.id',
                'IncomeRange.income',
                'IncomeRange.is_active'
            ) ,
            'order' => array(
                'IncomeRange.id' => 'desc'
            )
        );
        $this->set('userIncomeRanges', $this->paginate());
        $filters = $this->IncomeRange->isFilterOptions;
        $moreActions = $this->IncomeRange->moreActions;
        $this->set('filters', $filters);
        $this->set('moreActions', $moreActions);
        $this->set('pending', $this->IncomeRange->find('count', array(
            'conditions' => array(
                'IncomeRange.is_active' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->IncomeRange->find('count', array(
            'conditions' => array(
                'IncomeRange.is_active' => 1
            ),
			'recursive' => -1
        )));
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_add() 
    {
        $this->pageTitle = sprintf(__l('Add %s') , __l('Income Range'));
        $this->IncomeRange->create();
        if (!empty($this->request->data)) {
            if ($this->IncomeRange->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added') , __l('Income Range')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Income Range')) , 'default', null, 'error');
            }
        }
        $this->set('pageTitle', $this->pageTitle);
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = sprintf(__l('Edit %s') , __l('Income Range'));
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->IncomeRange->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Income Range')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Income Range')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->IncomeRange->read(null, $id);
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
        if ($this->IncomeRange->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted') , __l('Income Range')) , 'default', null, 'success');
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