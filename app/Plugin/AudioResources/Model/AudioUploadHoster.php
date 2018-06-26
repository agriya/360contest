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
class AudioUploadHoster extends AppModel
{
    public $name = 'AudioUploadHoster';
	public $useTable = 'upload_hosters';
    public $belongsTo = array(
        'AudioUploadService' => array(
            'className' => 'AudioResources.AudioUploadService',
            'foreignKey' => 'upload_service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UploadServiceType' => array(
            'className' => 'AudioResources.UploadServiceType',
            'foreignKey' => 'upload_service_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public function afterSave($created)
    {
		$this->updateYaml();
        $this->writeConfiguration();
    }
    public function writeConfiguration()
    {
        $uploadHoster = $this->find('first', array(
            'fields' => array(
                'AudioUploadService.name',
                'AudioUploadService.slug',
                'UploadServiceType.name',
                'UploadServiceType.slug',
            ) ,
            'conditions' => array(
                'AudioUploadHoster.is_active' => 1,
				'AudioUploadHoster.upload_service_id' => ConstUploadService::SoundCloud
            ) ,
            'recursive' => 0
        ));
        if (!empty($uploadHoster)) {
            Configure::write('hoster_audio_service', $uploadHoster['AudioUploadService']['slug']);
            Configure::write('hoster_audio_type', $uploadHoster['UploadServiceType']['slug']);
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
