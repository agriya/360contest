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
CmsNav::add('activities', array(
    'title' => 'Activities',
    'url' => array(
        'controller' => 'contests',
        'action' => 'index',
    ) ,
    'weight' => 40,
    'icon-class' => 'icon-time',
    'children' => array(
        'Video Uploads' => array(
            'title' => __l('Video Uploads') ,
            'url' => array(
                'controller' => 'uploads',
                'action' => 'index',
            ) ,
            'weight' => 105,
        ) ,
    ) ,
));
CmsHook::setCssFile(array(
    APP . 'Plugin' . DS . 'VideoResources' . DS . 'webroot' . DS . 'css' . DS . 'jquery.fileupload-ui.css',
) , 'default');
$defaultModel = array();
$pluginModel = array();
if (isPluginEnabled('Contests')) {
    $pluginModel = array(
		'ContestUser' => array(
            'hasMany' => array(
				'Upload' => array(
					'className' => 'VideoResources.Upload',
					'foreignKey' => 'contest_user_id',
					'dependent' => true,
					'conditions' => '',
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