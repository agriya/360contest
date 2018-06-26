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
class PricingDaysController extends ContestsAppController
{
    public $name = 'PricingDays';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q',
        ));
        $this->pageTitle = __l('Contest Days');
        $this->PricingDay->recursive = 0;
        $conditions = array();
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'PricingDay.no_of_days LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'PricingDay.global_price LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['PricingDay']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['PricingDay.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['PricingDay.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions
        );
        $this->set('pricingDays', $this->paginate());
		$this->set('pending', $this->PricingDay->find('count', array(
            'conditions' => array(
                'PricingDay.is_active = ' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->PricingDay->find('count', array(
            'conditions' => array(
                'PricingDay.is_active = ' => 1
            ),
			'recursive' => -1
        )));
        $moreActions = $this->PricingDay->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Contest Day');
        $this->PricingDay->create();
        if ($this->request->is('post')) {
            if ($this->PricingDay->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Contest Day')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Contest Day')) , 'default', null, 'error');
            }
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Contest Day');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->PricingDay->id = $id;
        if (!$this->PricingDay->exists()) {
            throw new NotFoundException(__l('Invalid contest day'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->PricingDay->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Contest Day')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Contest Day')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PricingDay->read(null, $id);
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
        if ($this->PricingDay->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Contest Day')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
