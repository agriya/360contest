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
 * Custom configurations
 */
if (!defined('DEBUG')) {
    define('DEBUG', 0);
    // permanent cache re1ated settings
    define('PERMANENT_CACHE_CHECK', (!empty($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] != '127.0.0.1') ? true : false);
    // site default language
    define('PERMANENT_CACHE_DEFAULT_LANGUAGE', 'en');
    // cookie variable name for site language
    define('PERMANENT_CACHE_COOKIE', 'user_language');
    // salt used in setcookie
    define('PERMANENT_CACHE_GZIP_SALT', 'e9a556134534545ab47c6c81c14f06c0b8sdfsdf');
    // Enable support for HTML5 History/State API
    // By enabling this, users will not see full page load
    define('IS_ENABLE_HTML5_HISTORY_API', false);
    // Force hashbang based URL for all browsers
    // When this is disabled, browsers that don't support History API (IE, etc) alone will use hashbang based URL. When enabled, all browsers--including links in Google search results will use hashbang based URL (similar to new Twitter).
    define('IS_ENABLE_HASHBANG_URL', false);
    $_is_hashbang_supported_bot = (!empty($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'Googlebot') !== false);
    define('IS_HASHBANG_SUPPORTED_BOT', $_is_hashbang_supported_bot);
}
$config['debug'] = DEBUG;
$config['site']['is_admin_settings_enabled'] = true;
// site actions that needs random attack protection...
$config['site']['_hashSecuredActions'] = array(
    'edit',
    'delete',
    'update',
    'download',
    'download_entry',
    'v',
    'reply',
    'request_refund',
	'check_status',
);
$config['permanent_cache']['view_action'] = array(
    'contests',
    'contest_users',
    'users',
);
$config['contestuser']['maximum_photos_per_upload'] = 5;
$config['contestuser']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
		'image/pjpeg',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png',
		'pjpeg'
    ) ,
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['contestuser']['maximum_videos_per_upload'] = 1;
$config['contestuser']['video_file'] = array(
    'allowedMime' => array(
        'video/avi',
        'video/msvideo',
        'video/x-msvideo',
		'video/x-ms-wmv',
        'video/avs-video',
        'video/x-dv',
        'video/dl',
        'video/x-dl',
        'video/x-sgi-movie',
        'video/quicktime'
    ) ,
    'allowedExt' => array(
        'mov',
        'avi',
        'mpe',
        'mpeg',
        'mpg',
        'mv',
        'm1v',
        'm2v',
        'isu',
        'gl',
        'fli',
        'dif',
        'avs',
        'asf',
        'afl',
        'vos',
        'flv'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['contestuser']['audio_file'] = array(
    'allowedMime' => array(
        'audio/basic',
		'audio/L24',
		'audio/mp4',
		'audio/mpeg',
		'audio/ogg',
		'audio/opus',
		'audio/vorbis',
		'audio/vnd.rn-realaudio',
		'audio/vnd.wave',
		'audio/webm'
    ) ,
    'allowedExt' => array(
        'AIFF',
		'WAVE',
		'FLAC',
		'OGG',
		'MP2',
		'MP3',
		'AAC',
		'AMR',
		'WMA'
    ),
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['message']['maximum_photos_per_upload'] = 5;
$config['message']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
		'image/pjpeg',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png',
		'pjpeg'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => false
);
$config['avatar']['file'] = array(
    'allowedMime' => array(
        'image/jpeg',
        'image/jpg',
        'image/gif',
		'image/pjpeg',
        'image/png'
    ) ,
    'allowedExt' => array(
        'jpg',
        'jpeg',
        'gif',
        'png',
		'pjpeg'
    ) ,
    'allowedSize' => '5',
    'allowedSizeUnits' => 'MB',
    'allowEmpty' => true
);
$config['WaterMark']['is_handle_aspect'] = 1;
$config['WaterMark']['is_not_allow_resize_beyond_original_size'] = 1;
// CDN...
$config['cdn']['images'] = null; // 'http://images.localhost/';
$config['cdn']['css'] = null; // 'http://static.localhost/';
$default_timezone = 'Europe/Berlin';
if (ini_get('date.timezone')) {
	$default_timezone = ini_get('date.timezone');
}
date_default_timezone_set($default_timezone);
/*date_default_timezone_set('Asia/Calcutta');

Configure::write('Config.language', 'spa');
setlocale (LC_TIME, 'es');*/

/*
** to do move to settings table
*/
$config['sitemap']['models'] = array(
	'User' => array(
		'fields' => array(
			'username',
			'id'
		) ,
		'priority' => 0.7,
		'conditions' => array(
			'User.is_active' => 1,
            'User.is_email_confirmed' => 1,
            'User.role_id !=' => 1,
		)
	)
);
if (class_exists('CmsHook') && method_exists('CmsHook', 'setExceptionUrl')) {
    CmsHook::setExceptionUrl(array(
        'nodes/home',
        'nodes/view',
        'nodes/term',
        'nodes/search',
        'comments/index',
        'comments/add',
        'users/register',
        'users/login',
        'users/logout',
        'users/reset',
        'users/refer',
        'users/forgot_password',
        'users/openid',
        'users/oauth_callback',
        'users/activation',
        'users/resend_activation',
        'users/view',
        'users/show_captcha',
        'users/captcha_play',
        'users/oauth_facebook',
        'images/view',
        'contacts/view',
        'users/admin_login',
        'users/admin_logout',
        'devs/asset_css',
        'devs/asset_js',
        'devs/sitemap',
        'crons/main',
        'contacts/add',
        'messages/index',
        'messages/message_board',
        'messages/compose',
        'messages/activities',
        'contacts/show_captcha',
        'contacts/captcha_play',
        'comments/captcha_play',
        'payments/membership_pay_now',
        'payments/get_gateways',
        'devs/yadis',
        'nodes/how_it_works',
        'users/show_header',
		'languages/change_language',
	    'users/validate_user',
	    'users/facepile',
		'users/index'
    ));
}
$config['site']['is_admin_settings_enabled'] = true;
if (!empty($_SERVER['HTTP_HOST']) && $_SERVER['HTTP_HOST'] == '360contest.dev.agriya.com' && !in_array($_SERVER['REMOTE_ADDR'], array('219.91.232.222', '182.72.136.170', '115.111.183.202'))) {
	$config['site']['is_admin_settings_enabled'] = false;
	$config['site']['admin_demo_mode_update_not_allowed_pages'] = array(
		'users/admin_send_mail',
		'pages/admin_edit',
		'settings/admin_edit',
		'email_templates/admin_edit',
	);
	$config['site']['admin_demo_mode_not_allowed_actions'] = array(
		'admin_delete',
		'admin_update',
	);
}