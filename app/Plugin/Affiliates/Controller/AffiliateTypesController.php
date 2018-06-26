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
class AffiliateTypesController extends AppController
{
    public $name = 'AffiliateTypes';
    public function admin_index() 
    {
        $this->pageTitle = __l('Affiliate Types');
        $this->AffiliateType->recursive = 0;
        $moreActions = $this->AffiliateType->moreActions;
        $this->set('moreActions', $moreActions);
        $this->set('affiliateTypes', $this->paginate());
    }
    public function admin_edit($id = null) 
    {
        $this->pageTitle = __l('Commission Settings');
        $plugins = explode(',', Configure::read('Hook.bootstraps'));
        array_push($plugins, '');
        $conditions['AffiliateType.plugin_name'] = $plugins;
        if (!empty($this->request->data)) {
            $i = 0;
            $errors = array();
            foreach($this->request->data['AffiliateType'] as $data) {
                $this->AffiliateType->set($data);
                if (!$this->AffiliateType->save($data)) {
                    $errors[$i] = $this->AffiliateType->validationErrors;
                }
                $i++;
            }
            foreach($errors as $i => $error) {
                foreach($error as $key => $value) $this->AffiliateType->validationErrors[$i][$key] = $value;
            }
            if (empty($errors)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated') , __l('Affiliate Commission')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.') , __l('Affiliate Commission')) , 'default', null, 'error');
            }
        } else {
            $affiliateTypes = $this->AffiliateType->find('all', array(
                'conditions' => $conditions,
                'recursive' => -1
            ));
            if (empty($affiliateTypes)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $i = 0;
            foreach($affiliateTypes as &$affiliateType) {
                foreach($affiliateType as $key => $value) $this->request->data['AffiliateType'][$i] = $value;
                $i++;
            }
        }
        $affiliateCommissionTypes = $this->AffiliateType->AffiliateCommissionType->find('list');
        $this->set(compact('affiliateCommissionTypes'));
    }
}
?>