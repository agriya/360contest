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
class ValidationRuleData {

	public $table = 'validation_rules';

	public $records = array(
		array(
			'id' => '1',
			'rule' => 'email',
			'message' => 'Please enter a valid email address.',
			'name' => 'Email'
		),
		array(
			'id' => '3',
			'rule' => 'alphaNumeric',
			'message' => 'This field may only contain letters and numbers.',
			'name' => 'AlphaNumeric'
		),
		array(
			'id' => '4',
			'rule' => 'cc',
			'message' => 'Please enter a valid credit card number.',
			'name' => 'Credit Card'
		),
		array(
			'id' => '5',
			'rule' => 'date',
			'message' => 'Please enter a valid date.',
			'name' => 'Date'
		),
		array(
			'id' => '6',
			'rule' => 'decimal',
			'message' => 'Please enter a decimal number.',
			'name' => 'Decimal'
		),
		array(
			'id' => '7',
			'rule' => 'money',
			'message' => 'Please enter a valid monetary amount.',
			'name' => 'Money'
		),
		array(
			'id' => '8',
			'rule' => 'numeric',
			'message' => 'Please enter a valid whole number.',
			'name' => 'Numeric'
		),
		array(
			'id' => '9',
			'rule' => 'phone',
			'message' => 'Please enter a valid US phone number.',
			'name' => 'Phone(US)'
		),
		array(
			'id' => '10',
			'rule' => 'postal',
			'message' => 'Please enter a valid Postal Code.',
			'name' => 'Postal Code'
		),
		array(
			'id' => '11',
			'rule' => 'ssn',
			'message' => 'Please enter a valid Social Securit Number.',
			'name' => 'SSN'
		),
		array(
			'id' => '12',
			'rule' => 'url',
			'message' => 'Please enter a valid URL.',
			'name' => 'Url'
		),
	);

}
