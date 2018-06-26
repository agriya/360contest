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
class AudioUploadHostersController extends AppController
{
    public $name = 'AudioUploadHosters';
    public function admin_index()
    {
		$condition['AudioUploadHoster.upload_service_id']= ConstUploadService::SoundCloud;
        $this->pageTitle = __l('Hosters');
        $this->paginate = array(
			'conditions' => $condition,
            'contain' => array(
                'AudioUploadService',
                'UploadServiceType',
            ) ,
            'recursive' => 0,
        );
        $this->set('uploadHosters', $this->paginate());
    }
    public function admin_edit($upload_service_id = null)
    {
        $this->loadModel('AudioResources.AudioUploadServiceSetting');
        if (!empty($this->request->data)) {
            // Save settings
            foreach($this->request->data['AudioUploadServiceSetting'] as $id => $value) {
                if ($id != 'upload_service_id') {
                    $this->AudioUploadServiceSetting->create(array(
                        'id' => $id,
                        'value' => $value['name']
                    ));
                    $this->AudioUploadServiceSetting->save(null, array(
                        'validate' => false
                    ));
                }
            }
            App::import('Model', 'AudioResources.AudioUploadService');
            $this->Session->setFlash(__l('Audio Upload Hosters settings updated.') , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'audio_upload_hosters',
                'action' => 'index',
            ));
        }
        $uploadService = $this->AudioUploadHoster->AudioUploadService->find('first', array(
            'conditions' => array(
                'AudioUploadService.id' => $upload_service_id
            ) ,
            'recursive' => -1
        ));
        $this->set('uploadService', $uploadService);
        $this->pageTitle = sprintf(__l('%s Configuration') , $uploadService['AudioUploadService']['name']);
        $uploadServiceSettings = $this->AudioUploadServiceSetting->find('all', array(
            'conditions' => array(
                'AudioUploadServiceSetting.upload_service_id = ' => $upload_service_id
            ) ,
            'order' => array(
                'AudioUploadServiceSetting.id' => 'ASC'
            ) ,
            'recursive' => 0
        ));
        $this->set('uploadServiceSettings', $uploadServiceSettings);
    }
    public function admin_update_status($id = null)
    {
        $this->AudioUploadHoster->updateAll(array(
            'AudioUploadHoster.is_active' => 0
        ), array(
			'AudioUploadHoster.upload_service_id' => ConstUploadService::SoundCloud
		));
        if (!empty($this->request->params['named']['status']) && ($this->request->params['named']['status'] == 'active')) {
            $_data['AudioUploadHoster']['id'] = $id;
            $_data['AudioUploadHoster']['is_active'] = 1;
            $this->AudioUploadHoster->save($_data);
        }
        $this->Session->setFlash(__l('Audio uploader service settings updated.') , 'default', null, 'success');
        $this->redirect(array(
            'controller' => 'audio_upload_hosters',
            'action' => 'index',
        ));
    }
}
?>