<?php
/**
 *
 * @package		360Contest
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-03-07
 **/
$js_files = array(
	JS . 'libs' . DS . 'jquery.js',
	JS . 'libs' . DS . 'jquery.form.js',
	JS . 'libs' . DS . 'jquery.blockUI.js',
	JS . 'libs' . DS . 'jquery.metadata.js',
	JS . 'libs' . DS . 'jquery-ui-1.10.3.custom.js',
	JS . 'libs' . DS . 'date.format.js',
	JS . 'libs' . DS . 'jquery.cookie.js',
	JS . 'libs' . DS . 'jquery.flash.js',
	JS . 'libs' . DS . 'jquery.easytabs.min.js',
	JS . 'libs' . DS . 'jquery.timeago.js',
	JS . 'libs' . DS . 'jquery.fuploader.js',
    JS . 'libs' . DS . 'jquery.uploader.js',
	JS . 'libs' . DS . 'jquery.slug.js',
	JS . 'libs' . DS . 'jquery.shiftclick.js',
	JS . 'libs' . DS . 'AC_RunActiveContent.js',
	JS . 'libs' . DS . 'jquery.oauthpopup.js',
	JS . 'libs' . DS . 'jquery.scrollTo.js',
	JS . 'libs' . DS . 'bootstrap-tab.js',
	JS . 'libs' . DS . 'bootstrap-dropdown.js',
	JS . 'libs' . DS . 'bootstrap-modal.js',
	JS . 'libs' . DS . 'bootstrap-alert.js',
	JS . 'libs' . DS . 'bootstrap-datetimepicker.min.js',
	JS . 'libs' . DS . 'jquery-migrate-1.2.1.js',
	JS . 'libs' . DS . 'jquery.ui.timepicker.js',
	JS . 'libs' . DS . 'bootstrap-tooltip.js',
	JS . 'libs' . DS . 'bootstrap-collapse.js',
	JS . 'libs' . DS . 'bootstrap-affix.js',
	JS . 'libs' . DS . 'bootstrap-carousel.js',
	JS . 'libs' . DS . 'wysihtml5-0.3.0.js',
	JS . 'libs' . DS . 'bootstrap-wysihtml5-0.0.2.js',
	JS . 'libs' . DS . 'bootstrap-popover.js',
	JS . 'libs' . DS . 'bootstro.js',
	JS . 'libs' . DS . 'jquery.pjax.js',
	JS . 'libs' . DS . 'jquery.sparkline.min.js',
	JS . 'libs' . DS . 'jquery.easy-pie-chart.min.js',
	JS . 'libs' . DS . 'slimScroll.js',
	JS . 'libs' . DS . 'socialite.js',
	JS . 'libs' . DS . 'jquery-gp-gallery.js',
	JS . 'libs' . DS . 'jquery.colorpicker.js',
	JS . 'libs' . DS . 'jquery.payment.js',
	JS . 'libs' . DS . 'uploader' . DS . 'tmpl.min.js',
	JS . 'libs' . DS . 'uploader' . DS . 'jquery.iframe-transport.js',
	JS . 'libs' . DS . 'uploader' . DS . 'jquery.fileupload.js',
	JS . 'libs' . DS . 'uploader' . DS . 'jquery.fileupload-process.js',
	JS . 'libs' . DS . 'uploader' . DS . 'jquery.fileupload-validate.js',
	JS . 'libs' . DS . 'uploader' . DS . 'jquery.fileupload-ui.js',
	JS . 'libs' . DS . 'uploader' . DS . 'locale.js',
	JS . 'common.js',
);
$js_files = Set::merge($js_files, Configure::read('site.default.js_files'));