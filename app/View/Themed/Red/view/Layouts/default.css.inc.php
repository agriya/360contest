<?php
/**
 *
 * @package		360Contest
 * @author 		hariharan_194ac11
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2014-03-03
 *
 */
$css_files = array(
    APP . 'View' . DS . 'Themed' . DS . 'Red' . DS . 'webroot' . DS . 'css' . DS . 'dev1bootstrap.less',
    APP . 'View' . DS . 'Themed' . DS . 'Red' . DS . 'webroot' . DS . 'css' . DS . 'responsive.less',
    APP . 'View' . DS . 'Themed' . DS . 'Red' . DS . 'webroot' . DS . 'css' . DS . 'flag.css',
	APP . 'View' . DS . 'Themed' . DS . 'Red' . DS . 'webroot' . DS . 'css' . DS . 'chart.css',
);
$css_files = Set::merge($css_files, Configure::read('site.default.css_files'));
?>