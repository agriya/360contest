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
class PricingPackagesController extends ContestsAppController
{
    public $name = 'PricingPackages';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q',
        ));
        $this->pageTitle = __l('Prize Packages');
        $this->PricingPackage->recursive = 0;
        $conditions = array();
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'PricingPackage.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'PricingPackage.description LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'PricingPackage.features LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['PricingPackage']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['PricingPackage.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['PricingPackage.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions
        );
        $this->set('pricingPackages', $this->paginate());
		$this->set('pending', $this->PricingPackage->find('count', array(
            'conditions' => array(
                'PricingPackage.is_active = ' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->PricingPackage->find('count', array(
            'conditions' => array(
                'PricingPackage.is_active = ' => 1
            ),
			'recursive' => -1
        )));
        $moreActions = $this->PricingPackage->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add()
    {
        $this->pageTitle = __l('Add Prize Package');
        $this->PricingPackage->create();
        if ($this->request->is('post')) {
            if ($this->PricingPackage->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been added'), __l('Prize Package')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.'), __l('Prize Package')) , 'default', null, 'error');
            }
        } else {
            $this->request->data['PricingPackage']['participant_commision'] = Configure::read('contest.winner_commission_amount');
        }
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Prize Package');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->PricingPackage->id = $id;
        if (!$this->PricingPackage->exists()) {
            throw new NotFoundException(__l('Invalid prize package'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->PricingPackage->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Prize Package')) , 'default', null, 'success');
                $this->redirect(array(
                    'action' => 'index'
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Prize Package')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->PricingPackage->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        if (empty($this->request->data['PricingPackage']['maximum_entry_allowed'])) {
            $this->request->data['PricingPackage']['maximum_entry_allowed'] = '';
        }
        $this->pageTitle.= ' - ' . $this->request->data['PricingPackage']['name'];
    }
     public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->PricingPackage->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Pricing Package')) , 'default', null, 'success');
            $this->redirect(array(
                    'action' => 'index'
                ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
