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
class PaymentGatewaySettingData {

	public $table = 'payment_gateway_settings';

	public $records = array(
		array(
			'id' => '13',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'payment_gateway_id' => '2',
			'name' => 'is_enable_for_contest_listing',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '23',
			'created' => '2013-08-26 12:32:41',
			'modified' => '2013-08-26 12:32:43',
			'payment_gateway_id' => '4',
			'name' => 'sudopay_merchant_id',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '24',
			'created' => '2013-08-26 12:33:01',
			'modified' => '2013-08-26 12:33:04',
			'payment_gateway_id' => '4',
			'name' => 'sudopay_website_id',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '25',
			'created' => '2013-08-26 12:33:25',
			'modified' => '2013-08-26 12:33:27',
			'payment_gateway_id' => '4',
			'name' => 'sudopay_secret_string',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '26',
			'created' => '2013-08-26 12:33:42',
			'modified' => '2013-08-26 12:33:44',
			'payment_gateway_id' => '4',
			'name' => 'sudopay_api_key',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '',
			'description' => ''
		),
		array(
			'id' => '27',
			'created' => '2013-08-26 12:34:11',
			'modified' => '2013-08-26 12:34:13',
			'payment_gateway_id' => '4',
			'name' => 'sudopay_subscription_plan',
			'type' => 'text',
			'options' => '',
			'test_mode_value' => 'Enterprise',
			'live_mode_value' => 'Enterprise',
			'description' => 'Subscription plan name'
		),
		array(
			'id' => '28',
			'created' => '2013-08-26 13:36:25',
			'modified' => '2013-08-26 13:36:27',
			'payment_gateway_id' => '4',
			'name' => 'is_payment_via_api',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '',
			'live_mode_value' => '1',
			'description' => 'Enable/Disable the current payment option'
		),
		array(
			'id' => '29',
			'created' => '2013-08-26 13:37:12',
			'modified' => '2013-08-26 13:37:14',
			'payment_gateway_id' => '4',
			'name' => 'is_enable_for_add_to_wallet',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => ''
		),
		array(
			'id' => '30',
			'created' => '2013-08-26 13:37:38',
			'modified' => '2013-08-26 13:37:40',
			'payment_gateway_id' => '4',
			'name' => 'is_enable_for_contest_listing',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => ''
		),
		array(
			'id' => '31',
			'created' => '2013-08-26 13:38:06',
			'modified' => '2013-08-26 13:38:08',
			'payment_gateway_id' => '4',
			'name' => 'is_enable_for_signup',
			'type' => 'checkbox',
			'options' => '',
			'test_mode_value' => '1',
			'live_mode_value' => '1',
			'description' => ''
		),
	);

}
