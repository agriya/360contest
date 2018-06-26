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
class AffiliateTypeData {

	public $table = 'affiliate_types';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2011-02-08 00:00:00',
			'modified' => '2012-05-12 02:52:10',
			'name' => 'Sign Up',
			'model_name' => 'User',
			'commission' => '2.00',
			'affiliate_commission_type_id' => '2',
			'is_active' => '1',
			'plugin_name' => ''
		),
		array(
			'id' => '2',
			'created' => '2011-02-08 00:00:00',
			'modified' => '2012-05-12 02:52:10',
			'name' => 'Contest Listing',
			'model_name' => 'Contest',
			'commission' => '5.00',
			'affiliate_commission_type_id' => '1',
			'is_active' => '1',
			'plugin_name' => ''
		),
		array(
			'id' => '3',
			'created' => '2011-02-08 00:00:00',
			'modified' => '2012-05-12 02:52:10',
			'name' => 'Contest Prize',
			'model_name' => 'ContestPrize',
			'commission' => '5.00',
			'affiliate_commission_type_id' => '1',
			'is_active' => '1',
			'plugin_name' => ''
		),
	);

}
