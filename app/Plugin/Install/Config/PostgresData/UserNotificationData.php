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
class UserNotificationData {

	public $table = 'user_notifications';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2014-03-31 11:55:47',
			'modified' => '2014-03-31 11:55:47',
			'user_id' => '1',
			'is_contest_canceled_alert_to_participant' => '1',
			'is_winner_selected_alert_to_participant' => '1',
			'is_contest_completed_alert_to_participant' => '1',
			'is_contest_amount_paid_alert_to_participant' => '1',
			'is_entry_eliminated_alert_to_participant' => '1',
			'is_entry_withdrawn_alert_to_participant' => '1',
			'is_entry_lost_alert_to_participant' => '1',
			'is_new_contest_entry_alert_to_contestholder' => '1',
			'is_cancel_withdraw_entry_alert_to_participant' => '1',
			'is_eliminate_entry_cancel_alert_to_participan' => '1',
			'is_request_refund_reject_alert_to_contesthold' => '1',
			'is_notification_for_new_message' => '1',
			'is_payment_pending_alert_to_participant' => '1',
			'is_activity_alert_to_contestholder' => '1',
			'is_entry_deleted_alert_to_participant' => '1',
			'is_contest_created_alert_to_participant' => '1'
		),
	);

}
