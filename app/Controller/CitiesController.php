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
class CitiesController extends AppController
{
    public $name = 'Cities';
	public function autocomplete($param_encode = null, $param_hash = null)
    {
        $conditions['City.is_approved'] = 1;
		$this->XAjax->autocomplete($param_encode, $param_hash, $conditions);
    }
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'filter_id',
            'q'
        ));
        $this->disableCache();
        $this->pageTitle = __l('Cities');
        $conditions = array();
        $this->City->validate = array();
        if (!empty($this->request->params['named']['filter_id'])) {
            $this->request->data[$this->modelClass]['filter_id'] = $this->request->params['named']['filter_id'];
        }
        if (!empty($this->request->data[$this->modelClass]['filter_id'])) {
            if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Active) {
                $this->pageTitle.= __l(' - Approved');
                $conditions[$this->modelClass . '.is_approved'] = 1;
            } else if ($this->request->data[$this->modelClass]['filter_id'] == ConstMoreAction::Inactive) {
                $this->pageTitle.= __l(' - Disapproved');
                $conditions[$this->modelClass . '.is_approved'] = 0;
            }
            $this->request->params['named']['filter_id'] = $this->request->data[$this->modelClass]['filter_id'];
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'City.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'State.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Country.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['City']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->City->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'fields' => array(
                'City.id',
                'City.name',
                'City.latitude',
                'City.longitude',
                'City.timezone',
                'City.county',
                'City.code',
                'City.is_approved',
                'State.name',
                'Country.name',
            ) ,
            'order' => array(
                'City.name' => 'asc'
            ) ,
            'limit' => 15
        );
        $this->set('cities', $this->paginate());
        $filters = $this->City->isFilterOptions;
        $moreActions = $this->City->moreActions;
        $this->set(compact('filters', 'moreActions'));
        $this->set('active', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved' => 1
            ),
			'recursive' => -1
        )));
        $this->set('inactive', $this->City->find('count', array(
            'conditions' => array(
                'City.is_approved' => 0
            ),
			'recursive' => -1
        )));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit City');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('City')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('City')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->City->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['City']['name'];
        $countries = $this->City->Country->find('list', array(
			'order' => array(
				'Country.id' => 'asc'
			)
		));
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved' => 1
            ),
			'recursive' => -1
        ));
        $this->set(compact('countries', 'states'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add City');
        if (!empty($this->request->data)) {
            $this->request->data['City']['is_approved'] = 1;
            $this->City->create();
            if ($this->City->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('City')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('City')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['City']['is_approved'] = 1;
        }
        $countries = $this->City->Country->find('list', array(
			'order' => array(
				'Country.id' => 'asc'
			)
		));
        $states = $this->City->State->find('list', array(
            'conditions' => array(
                'State.is_approved =' => 1
            ) ,
            'order' => array(
                'State.name'
            ),
			'recursive' => -1
        ));
        $this->set(compact('countries', 'states'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->City->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('City')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>