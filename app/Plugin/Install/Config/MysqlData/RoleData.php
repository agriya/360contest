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
class RoleData {

	public $table = 'roles';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2012-03-20 11:07:09',
			'modified' => '2012-03-20 11:07:09',
			'name' => 'Admin',
			'parent_id' => '0',
			'lft' => '1',
			'rght' => '2'
		),
		array(
			'id' => '2',
			'created' => '2012-03-20 11:58:15',
			'modified' => '2012-03-20 11:58:15',
			'name' => 'User',
			'parent_id' => '0',
			'lft' => '5',
			'rght' => '6'
		),
	);

}
