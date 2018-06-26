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
class LinkData {

	public $table = 'links';

	public $records = array(
		array(
			'id' => '1',
			'parent_id' => '',
			'menu_id' => '1',
			'title' => 'Acceptable Use Policy',
			'class' => '',
			'description' => '',
			'link' => 'controller:nodes/action:view/type:page/slug:aup',
			'target' => '',
			'rel' => '',
			'status' => '1',
			'lft' => '7',
			'rght' => '8',
			'visibility_roles' => '',
			'params' => '',
			'updated' => '2012-11-05 07:07:43',
			'created' => '2009-08-19 12:23:33'
		),
		array(
			'id' => '2',
			'parent_id' => '',
			'menu_id' => '1',
			'title' => 'Contact Us',
			'class' => 'js-no-pjax',
			'description' => '',
			'link' => 'controller:contacts/action:add',
			'target' => '',
			'rel' => '',
			'status' => '1',
			'lft' => '9',
			'rght' => '10',
			'visibility_roles' => '',
			'params' => '',
			'updated' => '2012-08-22 13:06:37',
			'created' => '2009-08-19 12:34:56'
		),
		array(
			'id' => '3',
			'parent_id' => '',
			'menu_id' => '1',
			'title' => 'Privacy Policy',
			'class' => 'privacy',
			'description' => '',
			'link' => 'controller:nodes/action:view/type:page/slug:privacy',
			'target' => '',
			'rel' => '',
			'status' => '1',
			'lft' => '3',
			'rght' => '4',
			'visibility_roles' => '',
			'params' => '',
			'updated' => '2012-11-05 07:21:21',
			'created' => '2012-03-21 11:07:11'
		),
		array(
			'id' => '4',
			'parent_id' => '',
			'menu_id' => '1',
			'title' => 'How It Works',
			'class' => 'how-does-it-work',
			'description' => '',
			'link' => 'controller:nodes/action:how_it_works',
			'target' => '',
			'rel' => '',
			'status' => '1',
			'lft' => '5',
			'rght' => '6',
			'visibility_roles' => '',
			'params' => '',
			'updated' => '2012-11-05 07:13:56',
			'created' => '2012-11-05 07:13:56'
		),
		array(
			'id' => '5',
			'parent_id' => '',
			'menu_id' => '1',
			'title' => 'Terms and Conditions',
			'class' => 'terms-of-service',
			'description' => '',
			'link' => 'controller:nodes/action:view/type:page/slug:terms',
			'target' => '',
			'rel' => '',
			'status' => '1',
			'lft' => '1',
			'rght' => '2',
			'visibility_roles' => '',
			'params' => '',
			'updated' => '2012-11-05 07:19:05',
			'created' => '2012-11-05 07:19:05'
		),
	);

}
