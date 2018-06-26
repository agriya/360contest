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
class ContestUserStatusData {

	public $table = 'contest_user_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2011-10-01 10:44:30',
			'modified' => '2011-10-01 10:44:30',
			'name' => 'Active',
			'description' => 'This entry is in active status',
			'slug' => 'active'
		),
		array(
			'id' => '2',
			'created' => '2011-10-01 10:44:30',
			'modified' => '2011-10-01 10:44:30',
			'name' => 'Won',
			'description' => 'This entry won!',
			'slug' => 'won'
		),
		array(
			'id' => '3',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Lost',
			'description' => 'Entry is in lost status',
			'slug' => 'lost'
		),
		array(
			'id' => '4',
			'created' => '2011-10-01 10:44:30',
			'modified' => '2011-10-01 10:44:30',
			'name' => 'Withdrawn',
			'description' => 'This entry has been withdrawn',
			'slug' => 'withdrawn'
		),
		array(
			'id' => '5',
			'created' => '2011-10-01 10:44:30',
			'modified' => '2011-10-01 10:44:30',
			'name' => 'Eliminated',
			'description' => 'This entry has been eliminated',
			'slug' => 'eliminated'
		),
	);

}
