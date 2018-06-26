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
class PaymentGatewayData {

	public $table = 'payment_gateways';

	public $records = array(
		array(
			'id' => '2',
			'created' => '2010-05-10 10:43:02',
			'modified' => '2012-07-02 05:38:54',
			'name' => 'Wallet',
			'display_name' => 'Wallet',
			'description' => 'Wallet option for purchase',
			'gateway_fees' => '',
			'transaction_count' => '0',
			'payment_gateway_setting_count' => '0',
			'is_test_mode' => '1',
			'is_active' => '1',
			'is_mass_pay_enabled' => ''
		),
		array(
			'id' => '4',
			'created' => '2013-08-26 12:28:30',
			'modified' => '2013-08-26 12:28:33',
			'name' => 'ZazPay',
			'display_name' => 'ZazPay',
			'description' => 'Payment through ZazPay',
			'gateway_fees' => '',
			'transaction_count' => '0',
			'payment_gateway_setting_count' => '0',
			'is_test_mode' => '1',
			'is_active' => '1',
			'is_mass_pay_enabled' => ''
		),
	);

}
