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
$content_dashboard = $content_user = $content_affiliates = '';
if (isPluginEnabled('IntegratedGoogleAnalytics')) {
    $content_dashboard = __l('and to analyze the site analytic status');
}
if (isPluginEnabled('LaunchModes')) {
    $content_user = __l('and manage prelaunch subscribed email list');
}
if (isPluginEnabled('Affiliates')) {
    $content_affiliates = __l(', affiliates and their requests etc');
}
CmsNav::add('dashboard', array(
    'title' => __l('Dashboard') ,
    'url' => array(
        'admin' => true,
        'controller' => 'users',
        'action' => 'stats',
    ) ,
	'data-bootstro-step' => '1',
    'data-bootstro-content' => __l('To see overall site activities and to notify the actions that admin need to taken') . ' ' . $content_dashboard,
    'icon-class' => 'dashboard',
    'allowedActions' => array(
        'admin_stats'
    ) ,
    'weight' => 10,
    'children' => array(
        'users' => array(
            'title' => __l('Snapshot') ,
            'url' => array(
                'admin' => true,
                'controller' => 'users',
                'action' => 'stats',
            ) ,
			'sub_class' => 'js-no-pjax',
            'weight' => 10,
        ) ,
    )
));
CmsNav::add('users', array(
    'title' => __l('Users') ,
    'url' => array(
        'admin' => true,
        'controller' => 'users',
        'action' => 'index',
    ) ,
	'data-bootstro-step' => '2',
    'data-bootstro-content' => __l('To manage the site user list, to send bulk email to site users') . ' ' . $content_user,
    'notAllowedActions' => array(
        'admin_stats',
        'admin_diagnostics',
        'admin_logs'
    ) ,
    'icon-class' => 'admin-users',
    'weight' => 10,
    'children' => array(
        'users' => array(
            'title' => __l('Users') ,
            'url' => array(
                'admin' => true,
                'controller' => 'users',
                'action' => 'index',
            ) ,
            'weight' => 10,
        ) ,
        'Send Email to Users' => array(
            'title' => __l('Send Email to Users') ,
            'url' => array(
                'admin' => true,
                'controller' => 'users',
                'action' => 'send_mail',
            ) ,
            'weight' => 40,
        ),
        'Contacts' => array(
            'title' => __l('Contacts') ,
            'url' => array(
                'admin' => true,
                'controller' => 'contacts',
                'action' => 'index',
            ) ,
            'weight' => 41,
        )
    ) ,
));
CmsNav::add('activities', array(
    'title' => __l('Activities') ,
    'url' => array(
        'admin' => true,
        'controller' => 'users',
        'action' => 'index',
    ) ,
    'data-bootstro-step' => '5',
    'data-bootstro-content' => __l('To manage the overall site activities like comments, messages, views etc.') ,
    'icon-class' => 'icon-time',
    'weight' => 40,
    'children' => array(
        'user_logins' => array(
            'title' => __l('User Logins') ,
            'url' => array(
                'admin' => true,
                'controller' => 'user_logins',
                'action' => 'index',
            ) ,
            'weight' => 20,
        ) ,
        'user_views' => array(
            'title' => __l('User Views') ,
            'url' => array(
                'admin' => true,
                'controller' => 'user_views',
                'action' => 'index',
            ) ,
            'weight' => 30,
        ) ,
        'Messages' => array(
            'title' => __l('User Messages') ,
            'url' => array(
                'admin' => true,
                'controller' => 'messages',
                'action' => 'index',
            ) ,
            'weight' => 40,
        )
    ) ,
));
App::import('Model', 'SettingCategory');
$SettingCategory = new SettingCategory();
$setting_categories_ids = array();
if (!isPluginEnabled('Wallet')) {
    array_push($setting_categories_ids, ConstPluginSettingCategories::Wallet);
}
if (!isPluginEnabled('Withdrawals') || !isPluginEnabled('Wallet')) {
    array_push($setting_categories_ids, ConstPluginSettingCategories::Withdrawals);
}
if (!isPluginEnabled('Contests')) {
    array_push($setting_categories_ids, ConstPluginSettingCategories::Contests);
}
if (!isPluginEnabled('SocialMarketing')) {
    array_push($setting_categories_ids, ConstPluginSettingCategories::SocialMarketing);
}
if (!isPluginEnabled('Affiliates')) {
    array_push($setting_categories_ids, ConstPluginSettingCategories::Affiliates);
}
if (!isPluginEnabled('HighPerformance')) {
    array_push($setting_categories_ids, ConstPluginSettingCategories::HighPerformance);
}
$settingCategories = $SettingCategory->find('all', array(
    'conditions' => array(
        'SettingCategory.parent_id' => 0,
        'NOT' => array(
            'SettingCategory.id' => $setting_categories_ids
        )
    ) ,
    'order' => array(
        'SettingCategory.id' => 'asc'
    ) ,
    'recursive' => -1
));
$tmp_settings = array();
$i = 0;
foreach($settingCategories as $settingCategory) {
    $i = $i+10;
    $tmp_settings[$settingCategory['SettingCategory']['name']] = array(
        'title' => $settingCategory['SettingCategory']['name'],
        'url' => array(
            'admin' => true,
            'controller' => 'settings',
            'action' => 'edit',
            $settingCategory['SettingCategory']['id'],
        ) ,
        'weight' => $i,
    );
}
CmsNav::add('settings', array(
    'title' => __l('Settings') ,
	'data-bootstro-step' => '9',
    'data-bootstro-content' => __l('To manage overall settings of the site.') ,
    'column_1' => 8,
    'url' => array(
        'admin' => true,
        'controller' => 'settings',
        'action' => 'prefix',
        'Site',
    ) ,
    'column' => 2,
    'icon-class' => 'admin-setting',
    'weight' => 100,
    'children' => $tmp_settings,
));
CmsNav::add('payments', array(
    'title' => __l('Payments') ,
    'show_title' => 1,
    'icon-class' => 'admin-payment',
    'url' => array(
        'admin' => true,
        'controller' => 'transactions',
        'action' => 'index',
    ) ,
	'data-bootstro-step' => '6',
    'data-bootstro-content' => __l('To manage and monitor all the payment related things such as transactions, payment gateway management') . ' ' . $content_affiliates,
    'weight' => 50,
    'children' => array(
        'Transactions' => array(
            'title' => __l('Transactions') ,
            'url' => array(
                'admin' => true,
                'controller' => 'transactions',
                'action' => 'index',
            ) ,
            'weight' => 10,
        ) ,
        'Payment Gateways' => array(
            'title' => __l('Payment Gateways') ,
            'url' => array(
                'admin' => true,
                'controller' => 'payment_gateways',
                'action' => 'index',
            ) ,
            'htmlAttributes' => array(
                'class' => 'payment-gateway'
            ) ,
            'weight' => 20,
        ) ,
    )
));
CmsNav::add('cms', array(
    'title' => __l('Site Builder') ,
    'url' => array(
        'admin' => true,
        'controller' => 'nodes',
        'action' => 'index',
    ) ,
	'data-bootstro-step' => '8',
    'data-bootstro-content' => __l('To customize and manage the contest form and their pricing type, also manage the site themes, contents, menu etc.') ,
    'allowedControllers' => array(
        'extensions_themes',
        'nodes',
        'menus',
        'blocks',
        'links',
        'attachments',
        'comments',
		'contest_types'
    ) ,
	'notallowedParams' => 'type',

    'notAllowedActions' => array(
        'admin_tools',
    ) ,
    'is_hide_title' => 1,
    'icon-class' => 'admin-cms',
    'weight' => 80,
    'children' => array()
));
CmsNav::add('masters', array(
    'title' => __l('Masters') ,
	'data-bootstro-step' => '10',
    'data-bootstro-content' => __l('To manage all the master. Master includes cities, countries, states, email template, contest categories and contest statuses etc.') ,
    'is_hide_title' => 1,
    'column' => 2,
    'column_1' => 12,
    'url' => array(
        'admin' => true,
        'controller' => 'email_templates',
        'action' => 'index',
    ) ,
    'icon-class' => 'admin-masters',
    'allowedControllers' => array(
        'terms'
    ) ,
    'weight' => 110,
    'children' => array(
        'Regional' => array(
            'title' => __l('Regional') ,
            'url' => '',
            'weight' => 10,
        ) ,
        'Banned IPs' => array(
            'title' => __l('Banned IPs') ,
            'url' => array(
                'admin' => true,
                'controller' => 'banned_ips',
                'action' => 'index',
            ) ,
            'weight' => 20,
        ) ,
        'Cities' => array(
            'title' => __l('Cities') ,
            'url' => array(
                'admin' => true,
                'controller' => 'cities',
                'action' => 'index',
            ) ,
            'weight' => 30,
        ) ,
        'Countries' => array(
            'title' => __l('Countries') ,
            'url' => array(
                'admin' => true,
                'controller' => 'countries',
                'action' => 'index',
            ) ,
            'weight' => 40,
        ) ,
        'States' => array(
            'title' => __l('States') ,
            'url' => array(
                'admin' => true,
                'controller' => 'states',
                'action' => 'index',
            ) ,
            'weight' => 50,
        ) ,
        'Email' => array(
            'title' => __l('Email') ,
            'url' => '',
            'weight' => 130,
        ) ,
        'Email Templates' => array(
            'title' => __l('Email Templates') ,
            'url' => array(
                'admin' => true,
                'controller' => 'email_templates',
                'action' => 'index',
            ) ,
            'weight' => 140,
        ) ,
        'CMS' => array(
            'title' => __l('CMS') ,
            'url' => '',
            'weight' => 200,
        ) ,
        'Content Types' => array(
            'title' => __l('Content Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'types',
                'action' => 'index',
            ) ,
            'weight' => 210,
        ) ,
        'Taxonomy' => array(
            'title' => __l('Taxonomies') ,
            'url' => array(
                'admin' => true,
                'controller' => 'vocabularies',
                'action' => 'index',
            ) ,
            'weight' => 220,
        ) ,
        'Others' => array(
            'title' => __l('Others') ,
            'url' => '',
            'weight' => 230,
        ) ,
        'IPs' => array(
            'title' => __l('IPs') ,
            'url' => array(
                'admin' => true,
                'controller' => 'ips',
                'action' => 'index',
            ) ,
            'weight' => 250,
        ) ,
        'Transaction Types' => array(
            'title' => __l('Transaction Types') ,
            'url' => array(
                'admin' => true,
                'controller' => 'transaction_types',
                'action' => 'index',
            ) ,
            'weight' => 260,
        ) ,
    )
));
