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
/**
 * Setting Model
 *
 * Site settings.
 *
 */
App::uses('File', 'Utility');
class Setting extends AppModel
{
    public $actsAs = array(
        'Cached' => array(
            'prefix' => array(
                'setting_',
            ) ,
        ) ,
    );
    public $belongsTo = array(
        'SettingCategory' => array(
            'className' => 'SettingCategory',
            'foreignKey' => 'setting_category_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasOne = array(
        'WaterMark' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'dependent' => true,
            'conditions' => array(
                'WaterMark.class' => 'WaterMark',
            ) ,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
	public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'ExtensionsPlugin',
        );
	}
    /**
     * afterSave callback
     *
     * @return void
     */
    public function afterSave($created)
    {
        $this->updateYaml();
        $this->writeConfiguration();
    }
    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete()
    {
        $this->updateYaml();
        $this->writeConfiguration();
    }
    /**
     * Creates a new record with name/value pair if name does not exist.
     *
     * @param string $name
     * @param string $value
     * @param array $options
     * @return boolean
     */
    public function write($key, $value, $options = array())
    {
        $_options = array(
            'description' => '',
            'input_type' => '',
            'editable' => 0,
            'params' => '',
        );
        $options = array_merge($_options, $options);
        $setting = $this->findByName($key);
        if (isset($setting['Setting']['id'])) {
            $setting['Setting']['id'] = $setting['Setting']['id'];
            $setting['Setting']['value'] = $value;
            $setting['Setting']['description'] = $options['description'];
            $setting['Setting']['input_type'] = $options['input_type'];
            $setting['Setting']['editable'] = $options['editable'];
            $setting['Setting']['params'] = $options['params'];
        } else {
            $setting = array();
            $setting['name'] = $key;
            $setting['value'] = $value;
            $setting['description'] = $options['description'];
            $setting['input_type'] = $options['input_type'];
            $setting['editable'] = $options['editable'];
            $setting['params'] = $options['params'];
        }
        $this->id = false;
        if ($this->save($setting)) {
            Configure::write($key, $value);
            return true;
        } else {
            return false;
        }
    }
    /**
     * Deletes setting record for given key
     *
     * @param string $key
     * @return boolean
     */
    public function deleteKey($key)
    {
        $setting = $this->findByName($key);
        if (isset($setting['Setting']['id']) && $this->delete($setting['Setting']['id'])) {
            return true;
        }
        return false;
    }
    /**
     * All key/value pairs are made accessible from Configure class
     *
     * @return void
     */
    public function writeConfiguration()
    {
        $settings = $this->find('all', array(
            'fields' => array(
                'Setting.name',
                'Setting.value',
            ) ,
            'cache' => array(
                'name' => 'setting_write_configuration',
                'config' => 'setting_write_configuration',
            ) ,
			'recursive' => -1
        ));
        foreach($settings AS $setting) {
            Configure::write($setting['Setting']['name'], $setting['Setting']['value']);
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
        $list = $this->find('list', array(
            'fields' => array(
                'name',
                'value',
            ) ,
            'order' => array(
                'Setting.name' => 'ASC',
            ) ,
			'recursive' => -1
        ));
		if (isPluginEnabled('VideoResources')) {
            App::import('Model', 'VideoResources.UploadServiceSetting');
            $UploadServiceSetting = new UploadServiceSetting();
            $uploadServiceSettings = $UploadServiceSetting->find('list', array(
                'fields' => array(
                    'UploadServiceSetting.name',
                    'UploadServiceSetting.value',
                ) ,
                'order' => array(
                    'UploadServiceSetting.name' => 'ASC',
                ) ,
				'recursive' => -1
            ));
            App::import('Model', 'VideoResources.UploadHoster');
            $UploadHoster = new UploadHoster();
            $uploadHoster = $UploadHoster->find('first', array(
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
                $list['hoster_service'] = $uploadHoster['UploadService']['slug'];
                $list['hoster_type'] = $uploadHoster['UploadServiceType']['slug'];
            } else {
                $list['hoster_service'] = "";
                $list['hoster_type'] = "";
            }
			$list = array_merge($list, $uploadServiceSettings);
        }
		if (isPluginEnabled('AudioResources')) {
            App::import('Model', 'AudioResources.AudioUploadServiceSetting');
            $AudioUploadServiceSetting = new AudioUploadServiceSetting();
            $uploadServiceSettings = $AudioUploadServiceSetting->find('list', array(
                'fields' => array(
                    'AudioUploadServiceSetting.name',
                    'AudioUploadServiceSetting.value',
                ) ,
                'order' => array(
                    'AudioUploadServiceSetting.name' => 'ASC',
                ) ,
				'recursive' => -1
            ));
            App::import('Model', 'AudioResources.AudioUploadHoster');
            $AudioUploadHoster = new AudioUploadHoster();
            $uploadAudioHoster = $AudioUploadHoster->find('first', array(
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
            if (!empty($uploadAudioHoster)) {
                $list['hoster_audio_service'] = $uploadAudioHoster['AudioUploadService']['slug'];
                $list['hoster_audio_type'] = $uploadAudioHoster['UploadServiceType']['slug'];
            } else {
                $list['hoster_audio_service'] = "";
                $list['hoster_audio_type'] = "";
            }
            $list = array_merge($list, $uploadServiceSettings);
        }
        $filePath = APP . 'Config' . DS . 'settings.yml';
        $file = new File($filePath, true);
        $listYaml = Spyc::YAMLDump($list, 4, 60);
        $file->write($listYaml);
    }
}
