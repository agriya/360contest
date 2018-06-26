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
class UploadStatusData {

	public $table = 'upload_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2013-06-04 16:50:21',
			'modified' => '2013-06-04 16:50:23',
			'name' => 'Success'
		),
		array(
			'id' => '2',
			'created' => '2013-06-04 16:50:33',
			'modified' => '2013-06-04 16:50:35',
			'name' => 'Processing'
		),
		array(
			'id' => '3',
			'created' => '2013-06-04 16:51:05',
			'modified' => '2013-06-04 16:51:07',
			'name' => 'Failure'
		),
	);

}
