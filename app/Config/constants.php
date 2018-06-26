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
class ConstUserTypes
{
    const Admin = 1;
    const User = 2;
}
class ConstUserIds
{
    const Admin = 1;
}
class ConstAttachment
{
    const UserAvatar = 1;
    const ContestUser = 2;
    const ContestType = 3;
	const Processing = 4;
}
class ConstMessageFolder
{
    const Inbox = 1;
    const SentMail = 2;
    const Drafts = 3;
    const Spam = 4;
    const Trash = 5;
}
class ConstMessageType
{
    const Conversation = 11;
}
class ConstAltVerb
{
    const FirstLeterCaps = 1;
    const PluralCaps = 2;
    const SingularCaps = 3;
    const SingularSmall = 4;
    const PluralSmall = 5;
}
class ConstMoreAction
{
    const Inactive = 1;
    const Active = 2;
    const Delete = 3;
    const OpenID = 4;
    const Export = 5;
    const Approved = 6;
    const Disapproved = 7;
    const Featured = 8;
    const Notfeatured = 9;
    const Site = 10;
    const Twitter = 11;
    const Facebook = 12;
    const Gmail = 13;
    const Yahoo = 14;
    const Suspend = 15;
    const Unsuspend = 16;
    const Flagged = 17;
    const Unflagged = 18;
    const Normal = 19;
    const Checked = 20;
    const Unchecked = 21;
    const Open = 22;
    const Completed = 23;
    const Withdrawn = 24;
    const Eliminated = 25;
    const TestMode = 33;
    const MassPay = 34;
    const ContestListing = 35;
    const Signup = 36;
    const Wallet = 37;
    const Reject = 38;
    const Cancel = 39;
    const Publish = 40;
    const Unpublish = 41;
    const Promote = 42;
    const Unpromote = 43;
    const PaidToParticipant = 44;
	const RejectRequest = 45;
	const Admin = 46;
	const LinkedIn = 47;
	const GooglePlus = 48;
	const Prelaunch = 49;
	const PrivateBeta = 50;
	const PrelaunchSubscribed = 51;
	const PrivateBetaSubscribed = 52;
	const Subscribed = 53;
	const AffiliateUser = 54;
}
// Banned ips types
class ConstBannedTypes
{
    const SingleIPOrHostName = 1;
    const IPRange = 2;
    const RefererBlock = 3;
}
// Banned ips durations
class ConstBannedDurations
{
    const Permanent = 1;
    const Days = 2;
    const Weeks = 3;
}
class ConstGenders
{
    const Male = 1;
    const Female = 2;
}
//payment related class constant
class ConstPaymentGateways
{
    const Wallet = 2;
    const ManualPay = 4;
	const SudoPay = 4;
}
class ConstTransactionTypes
{
    const NewContestAdded = 1;
    const UserWithdrawalRequest = 2;
    const AmountApprovedForUserCashWithdrawalRequest = 3;
    const AmountRefundedForRejectedWithdrawalRequest = 7;
    const FailedWithdrawalRequestRefundToUser = 8;
    const AcceptCashWithdrawRequest = 9;
    const SignupFee = 11;
    const AmountAddedToWallet = 12;
    const PrizeAmountForCompletedContest = 14;
    const ContestRejectedAndRefunded = 15;
    const ContestCanceledByAdmin = 16;
    const AmountDeductedForCompletedContest = 17;
    const AddFundToWallet = 18;
    const DeductFundFromWallet = 19;
	const ContestFeaturesUpdated = 22;
	const ContestTimeExtended = 23;
	const SiteCommisionDeductUsingMarketplace = 20;
	const ParticipantCommisionDeductUsingMarketplace = 21;
	const CashWithdrawalRequest = 6;
    const CashWithdrawalRequestPaid = 9;
    const CashWithdrawalRequestFailed = 10;
    const ContestListingFee = 24;
}
class ConstWithdrawalStatus
{
    const Pending = 1;
    const Approved = 2;
    const Rejected = 3;
    const Failed = 4;
    const Success = 5;
}
class ConstUserTypeAlternateName
{
    const Participant = 'participant';
    const ContestHolder = 'contestholder';
    const Admin = 'admin';
}
class ConstResourceFolderName
{
    const Image = 'image';
}
class ConstModule
{
    const Affiliate = 14;
}
class ConstModuleEnableFields
{
    const Affiliate = 246;
}
class ConstActivityMessage
{
    const NewEntry = "New entry ##ENTRY_NO## posted by ##CONTEST_USER##";
    const Rated = "<div class='activities-content clearfix'><div class='activities-rating-block'>##RATED_USER## <span class='hor-smspace'>has rated</span> </div><div class='activities-rating-block'>##RATING## <span>for the entry</span> ##ENTRY_NO##  <span>posted by</span> ##CONTEST_USER## </div></div>";
}
class ConstPaymentType
{
    const ContestFee = 1;
    const ContestPrize = 2;
    const SignupFee = 3;
    const Wallet = 4;
	const ContestUpgradeFee = 5;
	const ContestExtendTimeFee = 6;
}
class ConstPluginSettingCategories
{
    const Contests = 8;
    const Wallet = 6;
    const Withdrawals = 7;
	const SocialMarketing = 69;
	const Affiliates = 79;
	const HighPerformance = 84;
}
class ConstUserAvatarSource
{
    const Attachment = 1;
	const Facebook = 2;
	const Twitter = 3;
	const Google = 4;
	const Linkedin = 5;
	const GooglePlus = 6;
	const AngelList = 7;
}
class constContentType
{
    const Page = 1;
}
class ConstSiteState
{
    const Prelaunch = 1;
	const PrivateBeta = 2;
	const Launch = 3;
}
class ConstPaymentGatewaysName
{
    const SudoPay = 'ZazPay';
}
class ConstResourceId
{
    const Image = 1;
    const Video = 2;
	const Audio = 3;
	const Text = 4;
}
class ConstUploadStatus
{
    const Success = 1;
    const Processing = 2;
    const Failure = 3;
}
class ConstUploadServiceType
{
    const Direct = 1;
    const Normal = 2;
}
class ConstUploadService
{
    const Vimeo = 1;
    const YouTube = 2;
	const SoundCloud = 3;
}