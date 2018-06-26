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
class UploadHoster extends AppModel
{
    public $name = 'UploadHoster';
    public $belongsTo = array(
        'UploadService' => array(
            'className' => 'VideoResources.UploadService',
            'foreignKey' => 'upload_service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UploadServiceType' => array(
            'className' => 'VideoResources.UploadServiceType',
            'foreignKey' => 'upload_service_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public function afterSave($created)
    {
		$this->UploadService->updateQuota(ConstUploadService::Vimeo);
        $this->updateYaml();
        $this->writeConfiguration();
    }
    public function writeConfiguration()
    {
        $uploadHoster = $this->find('first', array(
            'fields' => array(
                'UploadService.name',
                'UploadService.slug',
                'UploadServiceType.name',
                'UploadServiceType.slug',
            ) ,
            'conditions' => array(
                'UploadHoster.is_active' => 1,
				'OR' => array(
					'UploadHoster.upload_service_id' => array(
						ConstUploadService::Vimeo,
						ConstUploadService::YouTube
					)
				)
            ) ,
            'recursive' => 0
        ));
        if (!empty($uploadHoster)) {
            Configure::write('hoster_service', $uploadHoster['UploadService']['slug']);
            Configure::write('hoster_type', $uploadHoster['UploadServiceType']['slug']);
        }
    }
    /**
     * Find list and save yaml dump in app/config/settings.yml file.
     * Data required in bootstrap.
     *
     * @return void
     */
    public function updateYaml()
    {
        App::import('Model', 'Setting');
        $Setting = new Setting();
        $Setting->updateYaml();
    }
}
