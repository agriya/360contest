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
require_once 'constants.php';
CmsNav::add('analytics', array(
    'title' => __l('Analytics') ,
    'icon-class' => 'bar-chart',
    'weight' => 11,
    'children' => array(
        'google_analytics' => array(
            'title' => __l('Google Analytics') ,
            'url' => array(
                'admin' => true,
                'controller' => 'google_analytics',
                'action' => 'analytics_chart',
            ) ,
            'htmlAttributes' => array(
                'class' => 'js-no-pjax'
            ) ,
            'weight' => 20,
        ) ,
    )
));
CmsHook::setJsFile(array(
    APP . 'Plugin' . DS . 'IntegratedGoogleAnalytics' . DS . 'webroot' . DS . 'js' . DS . 'common.js'
) , 'default');
?>