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
/**
 * This file is loaded automatically by the app/webroot/index.php file after the core bootstrap.php
 *
 * This is an application wide file to load any function that is not used within a class
 * define. You can also use this to include or require any files in your application.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2009, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * The settings below can be used to set additional paths to models, views and controllers.
 * This is related to Ticket #470 (https://trac.cakephp.org/ticket/470)
 *
 * App::build(array(
 *     'plugins' => array('/full/path/to/plugins/', '/next/full/path/to/plugins/'),
 *     'models' =>  array('/full/path/to/models/', '/next/full/path/to/models/'),
 *     'views' => array('/full/path/to/views/', '/next/full/path/to/views/'),
 *     'controllers' => array('/full/path/to/controllers/', '/next/full/path/to/controllers/'),
 *     'datasources' => array('/full/path/to/datasources/', '/next/full/path/to/datasources/'),
 *     'behaviors' => array('/full/path/to/behaviors/', '/next/full/path/to/behaviors/'),
 *     'components' => array('/full/path/to/components/', '/next/full/path/to/components/'),
 *     'helpers' => array('/full/path/to/helpers/', '/next/full/path/to/helpers/'),
 *     'vendors' => array('/full/path/to/vendors/', '/next/full/path/to/vendors/'),
 *     'shells' => array('/full/path/to/shells/', '/next/full/path/to/shells/'),
 *     'locales' => array('/full/path/to/locale/', '/next/full/path/to/locale/')
 * ));
 *
 */
/**
 * As of 1.3, additional rules for the inflector are added below
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */
App::import('Lib', 'CmsHook');
App::uses('PhpReader', 'Configure');
Configure::config('default', new PhpReader());
Configure::load('config');
require_once 'constants.php';
App::uses('CakeLog', 'Log');
App::uses('CmsPlugin', 'Extensions.Lib');
App::uses('CmsEventManager', 'Event');
App::import('Lib', 'Cms');
App::import('Lib', 'CmsNav');
CakePlugin::load(array(
    'Extensions'
) , array(
    'bootstrap' => true
));
CakePlugin::load(array(
    'DebugKit'
));
// settings
App::import('Vendor', 'Spyc/Spyc');
if (file_exists(APP . 'Config' . DS . 'settings.yml')) {
    $settings = Spyc::YAMLLoad(file_get_contents(APP . 'Config' . DS . 'settings.yml'));
    foreach($settings AS $settingKey => $settingValue) {
        Configure::write($settingKey, $settingValue);
    }
    require_once 'cms_menus.php';
}
require_once 'cms_bootstrap.php';
// Load Install plugin
if (Configure::read('Security.salt') == 'f78b12a5c38e9e5c6ae6fbd0ff1f46c77a1e3' || Configure::read('Security.cipherSeed') == '60170779348589376') {
    $_securedInstall = false;
}
Configure::write('Install.secured', !isset($_securedInstall));
Configure::write('Install.installed', file_exists(APP . 'Config' . DS . 'database.php') && file_exists(APP . 'Config' . DS . 'settings.yml'));
if (!Configure::read('Install.installed') || !Configure::read('Install.secured')) {
    CakePlugin::load('Install', array(
        'routes' => true
    ));
}
if (($baseUrl = Configure::read('App.baseUrl')) !== false) {
	Configure::write('App.base', $baseUrl);
}
function isPluginEnabled($pluginName)
{
    $plugins = explode(',', Configure::read('Hook.bootstraps'));
    if (in_array($pluginName, $plugins)) {
        return true;
    }
    return false;
}
function cAlt($verb = null, $type = null)
{
    $alternate_name = (Configure::read('site.contest_holder_alternate_name') != '') ? Configure::read('site.contest_holder_alternate_name') : 'contest holder';
    return _replaceVerb($alternate_name, $verb, $type);
}
// 'Participant' Alternate Name //
function pAlt($verb = null, $type = null)
{
    $alternate_name = (Configure::read('site.participant_alternate_name') != '') ? Configure::read('site.participant_alternate_name') : 'participant';
    return _replaceVerb($alternate_name, $verb, $type);
}
function _replaceVerb($alternate_name, $verb = null, $type = null)
{
    if ($verb == ConstAltVerb::PluralCaps || $verb == ConstAltVerb::PluralSmall) {
        $alternate_name = Inflector::pluralize($alternate_name);
    } elseif ($verb == ConstAltVerb::SingularCaps || $verb == ConstAltVerb::SingularSmall) {
        $alternate_name = Inflector::singularize($alternate_name);
    }
    if (empty($type)) {
        $type = $verb;
    }
    switch ($type) {
        case ConstAltVerb::PluralCaps:
            $alternate_name = ucfirst($alternate_name);
            break;

        case ConstAltVerb::SingularCaps:
            $alternate_name = ucfirst($alternate_name);
            break;

        default:
            $alternate_name = strtolower($alternate_name);
            break;
    }
    return __l($alternate_name);
}