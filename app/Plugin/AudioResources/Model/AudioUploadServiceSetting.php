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
class AudioUploadServiceSetting extends AppModel
{
    public $name = 'AudioUploadServiceSetting';
	public $useTable = 'upload_service_settings';
    public function afterSave($created)
    {
        $this->updateYaml();
        $this->writeConfiguration();
    }
    /**
     * All key/value pairs are made accessible from Configure class
     *
     * @return void
     */
    public function writeConfiguration()
    {
        $uploadServiceSettings = $this->find('all', array(
            'fields' => array(
                'AudioUploadServiceSetting.name',
                'AudioUploadServiceSetting.value',
            ) ,
			'recursive' => -1
        ));
        foreach($uploadServiceSettings AS $uploadServiceSetting) {
            Configure::write($uploadServiceSetting['AudioUploadServiceSetting']['name'], $uploadServiceSetting['AudioUploadServiceSetting']['value']);
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
