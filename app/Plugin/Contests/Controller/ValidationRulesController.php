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
class ValidationRulesController extends ContestsAppController
{
    public $name = 'ValidationRules';
    public function admin_index()
    {
        $this->pageTitle = __l('Validation Rules');
        $this->_redirectGET2Named(array(
            'q',
        ));
        $this->ValidationRule->recursive = 0;
        $this->set('validationRules', $this->paginate());
        $moreActions = $this->ValidationRule->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        if (!empty($this->request->data)) {
            $this->ValidationRule->create();
            $this->pageTitle = __l('Validation Rules');
            if ($this->ValidationRule->save($this->request->data)) {
                $this->Session->setFlash(__l('The ValidationRule has been saved'));
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('The ValidationRule could not be saved. Please, try again.'));
            }
        }
        $formFields = $this->ValidationRule->FormField->find('list');
        $this->set(compact('formFields'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Validation Rule');
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__l('Invalid ValidationRule'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->ValidationRule->save($this->request->data)) {
                $this->Session->setFlash(__l('The ValidationRule has been saved'));
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('The ValidationRule could not be saved. Please, try again.'));
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->ValidationRule->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $formFields = $this->ValidationRule->FormField->find('list');
        $this->set(compact('formFields'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ValidationRule->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('ValidationRule')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
