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
class SettingCategoryData {

	public $table = 'setting_categories';

	public $records = array(
		array(
			'id' => '1',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'System',
			'description' => 'Manage site name, contact email, from email, reply to email.',
			'plugin_name' => ''
		),
		array(
			'id' => '2',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Developments',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '3',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'SEO',
			'description' => 'Manage content, meta data and other information relevant to browsers or search engines',
			'plugin_name' => ''
		),
		array(
			'id' => '4',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Regional, Currency & Language',
			'description' => 'Manage site default language, currency, date-time format',
			'plugin_name' => ''
		),
		array(
			'id' => '5',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Account',
			'description' => 'Manage different type of login option such as Facebook, Twitter and OpenID',
			'plugin_name' => ''
		),
		array(
			'id' => '6',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Wallet',
			'description' => 'Manage wallet related settings. Manage different types payment gateway settings of the site. [Wallet, PayPal Adaptive, PayPal Standard]. <a title=\"Update Payment Gateway Settings\" class=\"paymentgateway-link\" href=\"##PAYMENT_SETTINGS_URL##\">Update Payment Gateway Settings</a>',
			'plugin_name' => 'Wallet'
		),
		array(
			'id' => '8',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Contests',
			'description' => 'Manage and configure settings such as contest minimum prize, winner commission etc.,',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '11',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Suspicious Words Detector',
			'description' => 'Manage Suspicious word detector feature, Auto suspend contest on system flag, Auto suspend message on system flag.',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '12',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Messages',
			'description' => 'Manage and configure settings such as email notification, send message option.',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '94',
			'created' => '2013-09-03 18:19:02',
			'modified' => '2013-09-03 18:19:05',
			'parent_id' => '9',
			'name' => 'Contest Upgrade and Extend Time Fee',
			'description' => '',
			'plugin_name' => 'Contest'
		),
		array(
			'id' => '15',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Third Party API',
			'description' => 'Manage third party settings such as Facebook, Twitter, Gmail, Yahoo for authentication.',
			'plugin_name' => ''
		),
		array(
			'id' => '21',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '1',
			'name' => 'Site Information',
			'description' => 'Here you can modify site related settings such as site name.',
			'plugin_name' => ''
		),
		array(
			'id' => '22',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '1',
			'name' => 'E-mails',
			'description' => 'Here you can modify email related settings such as contact email, from email, reply-to email.',
			'plugin_name' => ''
		),
		array(
			'id' => '23',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '2',
			'name' => 'Server',
			'description' => 'Here you can change server settings such as maintenance mode.',
			'plugin_name' => ''
		),
		array(
			'id' => '24',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '3',
			'name' => 'Metadata',
			'description' => 'Here you can set metadata settings such as meta keyword and description.',
			'plugin_name' => ''
		),
		array(
			'id' => '25',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '3',
			'name' => 'SEO',
			'description' => 'Here you can set SEO settings such as inserting tracker code and robots.',
			'plugin_name' => ''
		),
		array(
			'id' => '26',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '4',
			'name' => 'Regional',
			'description' => 'Here you can change regional setting such as site language.',
			'plugin_name' => 'Translation'
		),
		array(
			'id' => '27',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '4',
			'name' => 'Date and Time',
			'description' => 'Here you can modify date time settings such as timezone, date time format.',
			'plugin_name' => ''
		),
		array(
			'id' => '28',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '4',
			'name' => 'Currency Settings',
			'description' => 'Here you can modify site currency settings such as currency position and default currency.',
			'plugin_name' => ''
		),
		array(
			'id' => '29',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Logins',
			'description' => 'Here you can modify user login settings such as enabling 3rd party logins and other login options.',
			'plugin_name' => ''
		),
		array(
			'id' => '30',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Account Settings',
			'description' => 'Here you can modify account settings such as admin approval, email verification, and other site account settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '31',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Configuration',
			'description' => 'Here you can modify option to change language for user.',
			'plugin_name' => 'Translation'
		),
		array(
			'id' => '32',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '6',
			'name' => 'Wallet',
			'description' => 'Here you can modify wallet funding limit settings.',
			'plugin_name' => 'Wallet'
		),
		array(
			'id' => '33',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '7',
			'name' => 'Cash Withdraw',
			'description' => 'Here you can modify cash withdraw limit',
			'plugin_name' => 'Withdrawals'
		),
		array(
			'id' => '36',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Image Resource Watermark',
			'description' => '',
			'plugin_name' => 'ImageResources'
		),
		array(
			'id' => '41',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '11',
			'name' => 'Configuration',
			'description' => '<div class=\"suspicious-words-detector\"><p>Here you can update the Suspicious Words Detector related settings.</p> <p>Here you can place various words, which accepts regular expressions also, to match with your terms and policies. </p> <h4>Common Regular expressions</h4> <dl class=\"list clearfix\"> <dt>Email</dt> <dd>\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*([,;]\\s*\\w+([-+.]\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*)*</dd> <dt>Phone Number</dt> <dd>(?:\\+?1)?[-\\/. ]?[2-9][0-8][0-9][-\\/. ]?[2-9][0-9]{2}[-\\/. ]?[0-9]{4}<br/> For reference: http://en.wikipedia.org/wiki/North_American_Numbering_Plan#List_of_NANPA_countries_and_territories</dd></dl></div>',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '42',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '11',
			'name' => 'Auto Suspend Module',
			'description' => 'Here you can modify auto suspend modules as contests and messages.',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '43',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '12',
			'name' => 'Configuration',
			'description' => 'Here you modify message settings such as send message options and other message related settings.',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '44',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '13',
			'name' => 'Configuration',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '45',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '14',
			'name' => 'Configuration',
			'description' => 'Here you can modify affiliate related settings such as enabling affiliate and referral expire time.',
			'plugin_name' => ''
		),
		array(
			'id' => '46',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '14',
			'name' => 'Commission',
			'description' => 'Here you can modify affiliate related commission settings such as commission holding period, commission pay type settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '47',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '14',
			'name' => 'Withdrawal',
			'description' => 'Here you can modify affiliate withdrawal settings such as threshold limit, transaction fee settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '48',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Facebook',
			'description' => 'Facebook is used for login and posting message using its account details. For doing above, our site must be configured with existing Facebook account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=facebook-setup\" target=\"_blank\"> http://dev1products.dev.agriya.com/doku.php?id=facebook-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '49',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Twitter',
			'description' => 'Twitter is used for login and posting message using its account details. For doing above, our site must be configured with existing Twitter account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=twitter-hybridauth-setup\" target=\"_blank\"> http://dev1products.dev.agriya.com/doku.php?id=twitter-hybridauth-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '50',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'Google Translations',
			'description' => 'We use this service for quick translation to support new languages in ##TRANSLATIONADD##.</br> Note that Google Translate API is now a <a href=\"http://code.google.com/apis/language/translate/v2/pricing.html\" target=\"_blank\">paid service</a>. Getting Api key, refer <a href=\"http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup\" target=\"_blank\">http://dev1products.dev.agriya.com/doku.php?id=google-translation-setup</a>.',
			'plugin_name' => 'Translation'
		),
		array(
			'id' => '51',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '16',
			'name' => 'Module',
			'description' => 'Here you can modify module settings such as enabling/disabling master modules settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '52',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Configuration',
			'description' => 'Here you can enable/disable module such as contest comments, flags and other contest configuration.',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '57',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Global Prefill Values',
			'description' => 'These values are global values that get prefilled in respective forms.
These values aren\'t final.',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '54',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Alternate Name',
			'description' => 'Here you can modify the alternate name for Contest holder and Participant. ',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '7',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Withdrawals',
			'description' => 'Manage withdrawal related settings. Manage different types payment gateway settings of the site. [Wallet, PayPal Adaptive, PayPal Standard]. <a title=\"Update Payment Gateway Settings\" class=\"paymentgateway-link\" href=\"##PAYMENT_SETTINGS_URL##\">Update Payment Gateway Settings</a>',
			'plugin_name' => 'Withdrawals'
		),
		array(
			'id' => '56',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '9',
			'name' => 'Membership Fee',
			'description' => 'Here you can modify membership fee.',
			'plugin_name' => ''
		),
		array(
			'id' => '58',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '8',
			'name' => 'Waiting Period',
			'description' => '',
			'plugin_name' => 'Contests'
		),
		array(
			'id' => '9',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Revenue',
			'description' => 'Here you can update the Revenue related settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '59',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '9',
			'name' => 'Other Fees',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '60',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '9',
			'name' => 'Deposit To Wallet Fee',
			'description' => 'Here you can modify deposit to wallet fee payer.',
			'plugin_name' => ''
		),
		array(
			'id' => '61',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '15',
			'name' => 'SolveMedia Captcha',
			'description' => 'To configure application keys please refer <a href=\"http://dev1products.dev.agriya.com/doku.php?id=solvemedia-setup\" target=\"_blank\">http://dev1products.dev.agriya.com/doku.php?id=solvemedia-setup</a>',
			'plugin_name' => ''
		),
		array(
			'id' => '62',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Widget',
			'description' => 'Widgets for footer, contest view page. Widgets can be in iframe and JavaScript embed code, etc (e.g., Twitter Widget, Facebook Like Box, Facebook Feeds Code, Google Ads).',
			'plugin_name' => ''
		),
		array(
			'id' => '63',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '62',
			'name' => 'Widget #1',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '64',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '1',
			'name' => 'Captcha Type',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '65',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '62',
			'name' => 'Widget #2',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '66',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '62',
			'name' => 'Widget #3',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '67',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '62',
			'name' => 'Widget #4',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '68',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'Mobile Apps',
			'description' => 'All mobile apps will send secret key (hard coded in Mobile App) to fetch the data from server. App\'s key should be matched with this value.<br/> Warning: changing this value may break your mobile apps. ',
			'plugin_name' => ''
		),
		array(
			'id' => '69',
			'created' => '2013-02-04 15:58:58',
			'modified' => '2013-02-04 15:59:01',
			'parent_id' => '0',
			'name' => 'Social Marketing',
			'description' => 'Manage & configure settings such as invite, share content etc.,',
			'plugin_name' => 'SocialMarketing'
		),
		array(
			'id' => '70',
			'created' => '2013-02-04 16:02:55',
			'modified' => '2013-02-04 16:02:58',
			'parent_id' => '69',
			'name' => 'Invite',
			'description' => '',
			'plugin_name' => 'SocialMarketing'
		),
		array(
			'id' => '71',
			'created' => '2013-02-05 12:11:23',
			'modified' => '2013-02-05 12:11:26',
			'parent_id' => '69',
			'name' => 'Share',
			'description' => '',
			'plugin_name' => 'SocialMarketing'
		),
		array(
			'id' => '72',
			'created' => '2013-02-05 10:42:11',
			'modified' => '2013-02-05 10:42:14',
			'parent_id' => '15',
			'name' => 'Google',
			'description' => 'Google is used for login using its account details. For doing above, our site must be configured with existing Google account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=google-hybridauth-setup\" target=\"_blank\"> http://dev1products.dev.agriya.com/doku.php?id=google-hybridauth-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '73',
			'created' => '2013-02-05 10:42:40',
			'modified' => '2013-02-05 10:42:43',
			'parent_id' => '15',
			'name' => 'Yahoo!',
			'description' => 'Yahoo is used for login using its account details. For doing above, our site must be configured with existing Yahoo account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=yahoo-api-setup\" target=\"_blank\"> http://dev1products.dev.agriya.com/doku.php?id=yahoo-api-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '74',
			'created' => '2013-02-05 10:50:37',
			'modified' => '2013-02-05 10:50:39',
			'parent_id' => '15',
			'name' => 'LinkedIn',
			'description' => 'LinkedIn is used for login using its account details. For doing above, our site must be configured with existing LinkedIn account. <a href=\"http://dev1products.dev.agriya.com/doku.php?id=linkedin-hybridauth-setup\" target=\"_blank\"> http://dev1products.dev.agriya.com/doku.php?id=linkedin-hybridauth-setup </a>',
			'plugin_name' => ''
		),
		array(
			'id' => '75',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '68',
			'name' => 'Mobile Apps',
			'description' => 'All mobile apps will send a secret key (hard coded in Mobile App) to fetch the data from the server. The app\'s key should be matched with this value.<br/> Warning: changing this value may break your mobile apps. ',
			'plugin_name' => ''
		),
		array(
			'id' => '76',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '5',
			'name' => 'Remember me',
			'description' => '',
			'plugin_name' => ''
		),
		array(
			'id' => '77',
			'created' => '2013-08-20 19:28:00',
			'modified' => '2013-08-20 19:28:00',
			'parent_id' => '15',
			'name' => 'Google+',
			'description' => 'Google+ is used for login and fetching contacts.',
			'plugin_name' => ''
		),
		array(
			'id' => '78',
			'created' => '2013-08-20 19:28:15',
			'modified' => '2013-08-20 19:28:15',
			'parent_id' => '2',
			'name' => 'Site State',
			'description' => 'Here you can change the site state as Prelaunch, Private Beta or Launch',
			'plugin_name' => 'LaunchModes'
		),
		array(
			'id' => '79',
			'created' => '2013-08-21 19:20:43',
			'modified' => '2013-08-21 19:20:43',
			'parent_id' => '0',
			'name' => 'Affiliate',
			'description' => 'Manage affiliate information, commission and withdrawal amount details.',
			'plugin_name' => 'Affiliates'
		),
		array(
			'id' => '80',
			'created' => '2013-08-21 19:20:43',
			'modified' => '2013-08-21 19:20:43',
			'parent_id' => '79',
			'name' => 'Withdrawal',
			'description' => 'Here you can modify affiliate withdrawal settings such as threshold limit, transaction fee settings.',
			'plugin_name' => 'Withdrawals'
		),
		array(
			'id' => '81',
			'created' => '2013-08-21 19:20:43',
			'modified' => '2013-08-21 19:20:43',
			'parent_id' => '79',
			'name' => 'Commission',
			'description' => 'Here you can modify all the \"Affiliate related commission settings\" such as \"commission holding\" period and \"commission pay type\" settings.',
			'plugin_name' => ''
		),
		array(
			'id' => '82',
			'created' => '2013-08-21 19:20:43',
			'modified' => '2013-08-21 19:20:43',
			'parent_id' => '79',
			'name' => 'Configuration',
			'description' => 'Here you can modify affiliate related settings such as enabling affiliate and referral expiry time.',
			'plugin_name' => 'Affiliates'
		),
		array(
			'id' => '83',
			'created' => '2013-08-21 19:50:09',
			'modified' => '2013-08-21 19:50:09',
			'parent_id' => '15',
			'name' => 'Google Analytics',
			'description' => '',
			'plugin_name' => 'IntegratedGoogleAnalytics'
		),
		array(
			'id' => '84',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '0',
			'name' => 'High Performance',
			'description' => 'Manage high performance related settings',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '85',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '84',
			'name' => 'CloudFlare',
			'description' => 'CloudFlare acts as a CDN and is capable of mitigating DDoS attacks.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '86',
			'created' => '2013-05-15 10:30:01',
			'modified' => '2013-05-15 10:30:03',
			'parent_id' => '84',
			'name' => 'Google PageSpeed',
			'description' => 'Google PageSpeed is also easy to setup through DNS change. This will optimize site\'s HTML, JavaScript, Style Sheets and images on the fly. You may not usually need to turn this on as Agriya SFPlatform script is highly optimized already.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '87',
			'created' => '2012-02-27 12:03:49',
			'modified' => '2012-02-27 12:03:55',
			'parent_id' => '84',
			'name' => 'Pull CDN',
			'description' => 'By configuring Pull CDN services and entering the CDN domains below, we can make assets to be delivered through CDN easily.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '88',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '84',
			'name' => 'Email Delivery',
			'description' => 'Normally emails will be delivered through PHP. By enabling this option, email will be sent through this custom SMTP server. For performance, cloud email services like Amazon SES, Sendgrid, Mandrill, Gmail can be configured. ',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '89',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '84',
			'name' => 'Redis',
			'description' => 'By enabling this, session data will be stored in Redis instead from the database or files. This will improve site performance when site\'s user base is high.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '90',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '84',
			'name' => 'Memcached',
			'description' => 'By enabling this, database queries\' results will be stored in Memcached. As this reducing direct database access to some extent, this will improve site performance.',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '91',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'parent_id' => '84',
			'name' => 'Full-page Caching',
			'description' => 'By enabling this, most of the pages will be disk-cached. This will avoid PHP and database access. Caveat of this approach is that users will be presented with little outdated contents. Since, this Agriya SFPlatform script is highly optimized for this approach, this is highly recommended for good performance. ',
			'plugin_name' => 'HighPerformance'
		),
		array(
			'id' => '92',
			'created' => '2013-04-29 12:12:09',
			'modified' => '2013-04-29 12:12:12',
			'parent_id' => '84',
			'name' => 'Amazon S3',
			'description' => 'By enabling this, uploaded contents and static (CSS, JavaScript, images, etc) will be stored in Amazon S3 and will be delivered from there. This will have 2 benefits: 1. You may reduce storage and bandwidth cost--based on your server plan, 2. As files will be delivered from Amazon S3 infrastructure, site\'s loading speed may improve. ',
			'plugin_name' => 'HighPerformance'
		),
	);

}
