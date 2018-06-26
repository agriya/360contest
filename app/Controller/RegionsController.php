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
class RegionsController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Regions';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Region'
    );
    public function admin_index()
    {
        $this->pageTitle = __l('Regions');
        $this->Region->recursive = 0;
        $this->paginate['Region']['order'] = 'Region.title ASC';
        $this->set('regions', $this->paginate());
        $this->set('displayFields', $this->Region->displayFields());
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Region');
        if (!empty($this->request->data)) {
            $this->Region->create();
            if ($this->Region->save($this->request->data)) {
                $this->Session->setFlash(__l('Region has been saved') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Region could not be saved. Please, try again.') , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Region');
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__l('Invalid Region') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if ($this->Region->save($this->request->data)) {
                $this->Session->setFlash(__l('Region has been saved') , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(__l('Region could not be saved. Please, try again.') , 'default', null, 'error');
            }
        }
        if (empty($this->request->data)) {
            $this->request->data = $this->Region->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['Region']['title'];
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Region->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Region')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
