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
$defaultModel = array();
$pluginModel = array();
if (isPluginEnabled('Contests')) {
    $pluginModel = array(
		'ContestUser' => array(
            'hasMany' => array(
				'TextResource' => array(
					'className' => 'Contests.Message',
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