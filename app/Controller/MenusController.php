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
class MenusController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Menus';
    public function admin_index()
    {
        $this->pageTitle = __l('Menus');
        $this->Menu->recursive = 0;
        $this->paginate['Menu']['order'] = 'Menu.id ASC';
        $this->set('menus', $this->paginate());
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Menu');
        if (!empty($this->request->data)) {
            $this->Menu->create();
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__l('Menu has been saved') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Menu could not be saved. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Menu');
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__l('Invalid Menu') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Menu->save($this->request->data)) {
                $this->Session->setFlash(__l('Menu has been saved') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Menu could not be saved. Please, try again.') , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->Menu->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Menu']['title'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Menu->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Menu')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
