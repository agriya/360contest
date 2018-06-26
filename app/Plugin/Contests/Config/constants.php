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
class ConstContestStatus
{
    const PaymentPending = 1;
    const PendingApproval = 2;
    const Open = 3;
    const Rejected = 4;
    const RefundRequest = 5;
    const CanceledByAdmin = 6;
    const Judging = 7;
    const WinnerSelected = 8;
    const WinnerSelectedByAdmin = 9;
    const ChangeRequested = 10;
    const ChangeCompleted = 11;
    const Completed = 12;
    const PaidToParticipant = 13;
	const PendingActionToAdmin = 14;
	const FilesExpectation = 15;
    const ActivityConversatation = 47;
    const SenderNotification = 48;
    const ContestEntry = 49;
    const ContestComment = 50;
    const NewEntry = 51;
    const Rated = 52;
    const Conversation = 53;
}
class ConstContestUserStatus
{
    const Active = 1;
    const Won = 2;
    const Lost = 3;
    const Withdrawn = 4;
    const Eliminated = 5;
	const Deleted = 6;
}
class ConstResource
{
    const Image = 1;
    const Video = 2;
	const Audio = 3;
	const Text = 4;
}
?>