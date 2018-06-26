<?php
/**
 *
 * @package		360Contest
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-03-07
 *
 */
$css_files = array(
	CSS . 'chart.css',
	CSS . 'dev1bootstrap.less',
	CSS . 'responsive.less',
	CSS . 'bootstrap-wysihtml5-0.0.2.css',
	CSS . 'bootstrap-datetimepicker.min.css',
	CSS . 'flag.css',
	CSS . 'star-rate.css',
	CSS . 'bootstro.css',
	CSS . 'jquery-gp-gallery.css',
	CSS . 'colorpicker.css',
	CSS . 'ui.slider.extras.css',
	CSS . 'jquery-ui-timepicker.css',
);
$css_files = Set::merge($css_files, Configure::read('site.default.css_files'));
?>