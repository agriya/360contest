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
class AudioUploadService extends AppModel
{
    public $name = 'AudioUploadService';
	public $useTable = 'upload_services';
    public $hasOne = array(
        'AudioUploadServiceSetting' => array(
            'className' => 'AudioResources.AudioUploadServiceSetting',
            'foreignKey' => 'upload_service_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public $hasMany = array(
        'AudioUploadHoster' => array(
            'className' => 'AudioResources.AudioUploadHoster',
            'foreignKey' => 'upload_service_id',
            'dependent' => true,
            'conditions' => array(
				'AudioUploadHoster.upload_service_id' => ConstUploadService::SoundCloud
			),
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'AudioUpload' => array(
            'className' => 'AudioResources.AudioUpload',
            'foreignKey' => 'upload_service_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
}
