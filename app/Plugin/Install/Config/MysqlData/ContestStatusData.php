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
class ContestStatusData {

	public $table = 'contest_statuses';

	public $records = array(
		array(
			'id' => '1',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2012-12-22 17:35:10',
			'name' => 'Payment Pending',
			'slug' => 'payment-pending',
			'message' => 'Contest payment is not completed.'
		),
		array(
			'id' => '2',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Pending Approval',
			'slug' => 'pending-approval',
			'message' => 'Contest waiting for admin approval.'
		),
		array(
			'id' => '3',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Open',
			'slug' => 'open',
			'message' => 'New ##CONTEST## posted by ##HOLDER_NAME##'
		),
		array(
			'id' => '4',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Rejected',
			'slug' => 'rejected ',
			'message' => '##CONTEST## rejected by Admin'
		),
		array(
			'id' => '5',
			'created' => '0000-00-00 00:00:00',
			'modified' => '2012-04-27 09:25:29',
			'name' => 'Request for Cancellation',
			'slug' => 'request-for-refund',
			'message' => '##HOLDER_NAME## requested for refund and cancellation for ##CONTEST##'
		),
		array(
			'id' => '6',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Canceled By Admin',
			'slug' => 'canceled-by-admin',
			'message' => '##CONTEST##  canceled by admin'
		),
		array(
			'id' => '7',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Judging',
			'slug' => 'judging',
			'message' => 'Stopped receiving entries for  ##CONTEST## and waiting for ##HOLDER_NAME##\'s judgment. '
		),
		array(
			'id' => '8',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Winner Selected',
			'slug' => 'winner-selected',
			'message' => '##HOLDER_NAME## selected ##WINNER_USER## as winner for ##CONTEST## for entry ##ENTRY_NO##.'
		),
		array(
			'id' => '9',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Winner Selected By Admin',
			'slug' => 'winner-selected-by-admin',
			'message' => '##WINNER_USER## selected as winner by Admin for entry ##ENTRY_NO##.'
		),
		array(
			'id' => '10',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Change Requested',
			'slug' => 'change-requested',
			'message' => 'Contest holder ##HOLDER_NAME## requested for changes in ##CONTEST##.'
		),
		array(
			'id' => '11',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Change Completed',
			'slug' => 'change-completed',
			'message' => '##WINNER_USER## completed the changes requested by ##HOLDER_NAME## in ##CONTEST##'
		),
		array(
			'id' => '12',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Completed',
			'slug' => 'completed',
			'message' => '##CONTEST##  completed.'
		),
		array(
			'id' => '13',
			'created' => '0000-00-00 00:00:00',
			'modified' => '0000-00-00 00:00:00',
			'name' => 'Paid to Participant',
			'slug' => 'paid-to-participant',
			'message' => 'Contest prize ##CONTEST_AMOUNT## for the contest ##CONTEST## is paid to ##WINNER_USER##'
		),
		array(
			'id' => '14',
			'created' => '2012-05-29 09:53:06',
			'modified' => '2012-05-29 09:53:15',
			'name' => 'Pending Action to Admin',
			'slug' => 'pending-action-to-admin',
			'message' => '##CONTEST## status changed to Pending Action to Admin'
		),
		array(
			'id' => '15',
			'created' => '2013-08-31 11:30:31',
			'modified' => '2013-08-31 11:30:33',
			'name' => 'Expecting Deliverables',
			'slug' => 'expecting-deliverables',
			'message' => '##CONTEST## status changed to expecting deliverables'
		),
	);

}
