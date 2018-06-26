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
CmsNav::add('activities', array(
    'title' => 'Activities',
    'url' => array(
        'controller' => 'contests',
        'action' => 'index',
    ) ,
    'weight' => 41,
    'icon-class' => 'icon-time',
    'children' => array(
        'Audio Uploads' => array(
            'title' => __l('Audio Uploads') ,
            'url' => array(
                'controller' => 'audio_uploads',
                'action' => 'index',
            ) ,
            'weight' => 106,
        ) ,
    ) ,
));
CmsHook::setCssFile(array(
    APP . 'Plugin' . DS . 'AudioResources' . DS . 'webroot' . DS . 'css' . DS . 'jquery.fileupload-ui.css',
) , 'default');
CmsHook::setExceptionUrl(array(
    'audio_uploads/getIFrameTrack',
));
$defaultModel = array();
$pluginModel = array();
if (isPluginEnabled('Contests')) {
    $pluginModel = array(
		'ContestUser' => array(
            'hasMany' => array(
				'AudioUpload' => array(
					'className' => 'AudioResources.AudioUpload',
					'foreignKey' => 'contest_user_id',
					'dependent' => true,
					'conditions' => array(
						'AudioUpload.upload_service_id' => ConstUploadService::SoundCloud
					),
					'fields' => '',
					'order' => '',
					'limit' => '',
					'offset' => '',
					'exclusive' => '',
					'finderQuery' => '',
					'counterQusery' => ''
				) ,
        ) ,
    ));
}
$defaultModel = $defaultModel+$pluginModel;
CmsHook::bindModel($defaultModel);