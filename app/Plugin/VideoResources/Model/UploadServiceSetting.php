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
class UploadServiceSetting extends AppModel
{
    public $name = 'UploadServiceSetting';
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
                'UploadServiceSetting.name',
                'UploadServiceSetting.value',
            ) ,
			'recursive' => -1
        ));
        foreach($uploadServiceSettings AS $uploadServiceSetting) {
            Configure::write($uploadServiceSetting['UploadServiceSetting']['name'], $uploadServiceSetting['UploadServiceSetting']['value']);
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
