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
class TransactionTypeData {

	public $table = 'transaction_types';

	public $records = array(
		array(
			'id' => '1',
			'created' => '2010-03-04 10:17:14',
			'modified' => '2012-12-22 17:29:42',
			'name' => 'New contest added',
			'is_credit' => '',
			'is_credit_to_admin' => '1',
			'message' => 'You have posted a contest ##CONTEST## with prize amount ##CONTEST_AMOUNT##. (Listing fee ##SITE_FEE##)',
			'message_for_admin' => '##USER## posted a contest ##CONTEST## with prize amount ##CONTEST_AMOUNT##. (Listing fee ##SITE_FEE##)',
			'transaction_variables' => 'USER, CONTEST, CONTEST_AMOUNT'
		),
		array(
			'id' => '2',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'User cash withdrawal request',
			'is_credit' => '',
			'is_credit_to_admin' => '',
			'message' => 'Withdraw request has been made',
			'message_for_admin' => 'Withdraw request has been made by user, ##USER##',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '3',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Approved withdrawal request',
			'is_credit' => '',
			'is_credit_to_admin' => '',
			'message' => 'Administrator have approved your withdrawal request',
			'message_for_admin' => 'You (Administrator) have approved the withdrawal request for ##USER##',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '21',
			'created' => '2012-06-05 18:46:24',
			'modified' => '2012-06-05 18:46:30',
			'name' => 'Participant Commision Deduct Using Paypal Adaptive',
			'is_credit' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Participant commission for contest ##CONTEST## ',
			'message_for_admin' => 'Participant commission for contest ##CONTEST##',
			'transaction_variables' => 'CONTEST'
		),
		array(
			'id' => '7',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2012-05-17 07:31:05',
			'name' => 'Amount refunded for rejected withdrawal request',
			'is_credit' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'Administrator have rejected the withdrawal request',
			'message_for_admin' => 'Amount refunded to ##USER## for rejected withdrawal request',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '8',
			'created' => '2010-08-17 14:31:48',
			'modified' => '2010-08-17 14:31:48',
			'name' => 'Failed withdrawal request and refunded to user',
			'is_credit' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'Withdrawal request failed. Your requested amount has been refunded to your wallet.',
			'message_for_admin' => 'Withdrawal request has been failed. Amount refunded to ##USER##.',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '9',
			'created' => '2010-03-04 10:20:11',
			'modified' => '2010-03-04 10:20:14',
			'name' => 'Paid cash withdraw request amount to user',
			'is_credit' => '',
			'is_credit_to_admin' => '',
			'message' => 'Withdraw request has been successfully made and paid to your money transfer account',
			'message_for_admin' => 'Withdraw request for ##USER## was successfully paid to his money transfer account',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '11',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Membership Fee',
			'is_credit' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Membership fee paid',
			'message_for_admin' => 'Membership fee paid by ##USER##',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '12',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Amount added to wallet',
			'is_credit' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'Amount added to wallet',
			'message_for_admin' => '##USER## added amount to his wallet.',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '14',
			'created' => '2011-09-21 15:29:20',
			'modified' => '2011-09-21 15:29:20',
			'name' => 'Amount transferred to participant',
			'is_credit' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'You have received prize amount ##CONTEST_AMOUNT## for the contest ##CONTEST##. (Site fee ##SITE_COMMISION##)',
			'message_for_admin' => '##USER## received prize amount ##CONTEST_AMOUNT## for the contest ##CONTEST##. (Site fee ##SITE_COMMISION##)',
			'transaction_variables' => 'USER, CONTEST, CONTEST_AMOUNT, SITE_COMMISION'
		),
		array(
			'id' => '15',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Contest rejected and amount refunded to contest holder',
			'is_credit' => '1',
			'is_credit_to_admin' => '',
			'message' => 'Administrator rejected your contest ##CONTEST## with prize amount ##CONTEST_AMOUNT##',
			'message_for_admin' => 'You have rejected the contest ##CONTEST## posted by ##USER## with prize amount ##CONTEST_AMOUNT##',
			'transaction_variables' => 'CONTEST, CONTEST_AMOUNT'
		),
		array(
			'id' => '16',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'name' => 'Contest canceled by admin and amount refunded to contest holder',
			'is_credit' => '1',
			'is_credit_to_admin' => '',
			'message' => 'Administrator canceled your contest ##CONTEST## with prize amount ##CONTEST_AMOUNT##',
			'message_for_admin' => 'You have canceled the contest ##CONTEST## posted by ##USER## with prize amount ##CONTEST_AMOUNT##',
			'transaction_variables' => 'CONTEST, CONTEST_AMOUNT, USER'
		),
		array(
			'id' => '18',
			'created' => '2010-09-17 11:12:37',
			'modified' => '2010-09-17 11:12:42',
			'name' => 'Add fund to wallet',
			'is_credit' => '1',
			'is_credit_to_admin' => '1',
			'message' => 'Administrator added fund to your wallet',
			'message_for_admin' => 'Added fund to ##USER## wallet',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '17',
			'created' => '2012-02-08 06:14:50',
			'modified' => '2012-02-08 06:14:50',
			'name' => 'Amount transferred from contest holder',
			'is_credit' => '',
			'is_credit_to_admin' => '',
			'message' => 'Prize amount ##CONTEST_AMOUNT## moved to winner (##USER##) for completed contest ##CONTEST##',
			'message_for_admin' => 'Prize amount ##CONTEST_AMOUNT## moved to winner (##USER##) for completed contest ##CONTEST##',
			'transaction_variables' => 'CONTEST, USER, CONTEST_AMOUNT'
		),
		array(
			'id' => '19',
			'created' => '2010-09-17 11:13:20',
			'modified' => '2010-09-17 11:13:23',
			'name' => 'Deduct fund from wallet',
			'is_credit' => '',
			'is_credit_to_admin' => '',
			'message' => 'Administrator deducted fund from your wallet',
			'message_for_admin' => 'Deducted fund from ##USER## wallet',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '20',
			'created' => '2012-06-05 18:46:24',
			'modified' => '2012-06-05 18:46:30',
			'name' => 'Site Fee Deduct Using Paypal Adaptive',
			'is_credit' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Listing fee for contest ##CONTEST##',
			'message_for_admin' => 'Listing fee for contest ##CONTEST## posted by ##USER##',
			'transaction_variables' => 'CONTEST'
		),
		array(
			'id' => '22',
			'created' => '2013-09-02 12:31:04',
			'modified' => '2013-09-02 12:31:07',
			'name' => 'Contest Features Updated',
			'is_credit' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Contest features Update fee paid',
			'message_for_admin' => 'Contest features Update fee paid by ##USER##',
			'transaction_variables' => 'USER'
		),
		array(
			'id' => '23',
			'created' => '2013-09-02 12:32:28',
			'modified' => '2013-09-02 12:32:30',
			'name' => 'Contest Time Extended',
			'is_credit' => '',
			'is_credit_to_admin' => '1',
			'message' => 'Contest Time Extended fee paid',
			'message_for_admin' => 'Contest Time Extended fee paid by ##USER##',
			'transaction_variables' => 'USER'
		),
	);

}
