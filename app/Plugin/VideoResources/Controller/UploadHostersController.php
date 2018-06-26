<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
class UploadHostersController extends AppController
{
    public $name = 'UploadHosters';
    public function admin_index()
    {
		$condition['OR']['UploadHoster.upload_service_id']= array(
			ConstUploadService::Vimeo,
			ConstUploadService::YouTube
		);
        $this->pageTitle = __l('Hosters');
        $this->paginate = array(
			'conditions' => $condition,
            'contain' => array(
                'UploadService',
                'UploadServiceType',
            ) ,
            'recursive' => 0,
        );
        $this->set('uploadHosters', $this->paginate());
    }
    public function admin_edit($upload_service_id = null)
    {
        $this->loadModel('VideoResources.UploadServiceSetting');
        if (!empty($this->request->data)) {
            // Save settings
            foreach($this->request->data['UploadServiceSetting'] as $id => $value) {
                if ($id != 'upload_service_id') {
                    $this->UploadServiceSetting->create(array(
                        'id' => $id,
                        'value' => $value['name']
                    ));
                    $this->UploadServiceSetting->save(null, array(
                        'validate' => false
                    ));
                }
            }
            App::import('Model', 'VideoResources.UploadService');
            $this->UploadService = new UploadService();
            $this->UploadService->updateQuota($this->request->data['UploadHoster']['upload_service_id']);
            $this->Session->setFlash(__l('Upload Hosters settings updated.') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'upload_hosters',
                'action' => 'index',
            ));
        }
        $uploadService = $this->UploadHoster->UploadService->find('first', array(
            'conditions' => array(
                'UploadService.id' => $upload_service_id
            ) ,
            'recursive' => -1
        ));
        $this->set('uploadService', $uploadService);
        $this->pageTitle = sprintf(__l('%s Configuration') , $uploadService['UploadService']['name']);
        $uploadServiceSettings = $this->UploadServiceSetting->find('all', array(
            'conditions' => array(
                'UploadServiceSetting.upload_service_id = ' => $upload_service_id
            ) ,
            'order' => array(
                'UploadServiceSetting.id' => 'ASC'
            ) ,
            'recursive' => 0
        ));
        $this->set('uploadServiceSettings', $uploadServiceSettings);
    }
    public function admin_update_status($id = null)
    {
        $this->UploadHoster->updateAll(array(
            'UploadHoster.is_active' => 0
        ), array(
			'UploadHoster.upload_service_id !=' => ConstUploadService::SoundCloud
		));
        if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'active')) {
            $_data['UploadHoster']['id'] = $id;
            $_data['UploadHoster']['is_active'] = 1;
            $this->UploadHoster->save($_data);
        }
        $this->Session->setFlash(__l('Uploader service settings updated.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'upload_hosters',
            'action' => 'index',
        ));
    }
}
?>