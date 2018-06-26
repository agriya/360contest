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
class EmailTemplateData {

	public $table = 'email_templates';

	public $records = array(
		array(
			'id' => '1',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-12-22 17:28:40',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Forgot Password',
			'description' => 'we will send this mail, when

user submit the forgot password form.',
			'subject' => 'Forgot password',
			'email_content' => 'Hi ##USERNAME##,

A password reset request has been made for your user account at ##SITE_NAME##.

If you made this request, please click on the following link:

##RESET_URL##

If you did not request this action and feel this is in error, please contact us.

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

	<table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A password reset request has been made for your user account at ##SITE_NAME##.  If you made this request, please click on the following link:  ##RESET_URL##

</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##

</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME,RESET_URL,SITE_NAME',
			'is_html' => ''
		),
		array(
			'id' => '2',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:34:15',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Activation Request',
			'description' => 'we will send this mail,

when user registering an account he/she will get an activation

request.',
			'subject' => 'Please activate your ##SITE_NAME## account',
			'email_content' => 'Hi ##USERNAME##,\\n\\nYour account has been created. Please visit the following URL to activate your account.\\n##ACTIVATION_URL##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been created.</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please visit the following URL to activate your account.</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"> ##ACTIVATION_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME,ACTIVATION_URL',
			'is_html' => ''
		),
		array(
			'id' => '3',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:34:40',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New User Join',
			'description' => 'we will

send this mail to admin, when a new user registered in the site.',
			'subject' => 'New user joined in ##SITE_NAME## account',
			'email_content' => 'Hi,\\n\\nA new user named \"##USERNAME##\" has joined in ##SITE_NAME## account.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A new user named \"##USERNAME##\" has joined in ##SITE_NAME##.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '25',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-08-08 06:59:53',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Payment pending alert mail to Contest holder',
			'description' => 'if the contest is in payment pending status mail send to contest

holder.',
			'subject' => '[##CONTEST_NAME##] Payment pending',
			'email_content' => 'Dear ##USERNAME##,

  Your contest \"##CONTEST_NAME##\" is currently under Inactive status due to pending payment.  You can pay the contest payment using the following URL, ##PENDING_PAYMENT_URL##.

             If you fails to make a payment within ##PENDING_PAYMENT_DAYS## days, the contest leads to auto delete.

Thanks,

 ##SITE_NAME##

 ##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"###SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your contest \"##CONTEST_NAME##\" is currently under Inactive status due to pending payment.  You can pay the contest payment using the following URL, ##PENDING_PAYMENT_URL##.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you fails to make a payment within ##PENDING_PAYMENT_DAYS## days, the contest leads to auto delete.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME, CONTEST_NAME, PENDING_PAYMENT_URL, PENDING_PAYMENT_DAYS, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '4',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-08-03 01:53:12',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Welcome Email',
			'description' => 'we will send this mail, when

user register in this site and get activate.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_content' => 'Hi ##USERNAME##,

We wish to say a quick hello and thanks for registering at ##SITE_NAME##.

If you did not request this account and feel this is an error, please contact us at ##CONTACT_MAIL##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">We wish to say a quick hello and thanks for registering at ##SITE_NAME##.</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you did not request this account and feel this is an error, please

contact us at ##CONTACT_MAIL##.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, USERNAME, CONTACT_MAIL',
			'is_html' => ''
		),
		array(
			'id' => '5',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:35:54',
			'from' => '##FIRST_NAME####LAST_NAME## <##FROM_EMAIL##>',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Contact Us',
			'description' => 'We will send this mail to admin, when user submit any

contact form.',
			'subject' => '[##SITE_NAME##] ##SUBJECT##',
			'email_content' => '##MESSAGE##\\n\\n----------------------------------------------------\\nTelephone  : ##TELEPHONE##\\nIP             : ##IP##, ##SITE_ADDR##\\nWhois       : http://whois.sc/##IP##\\nURL          : ##FROM_URL##\\n----------------------------------------------------\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">##MESSAGE##</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Telephone    : ##TELEPHONE##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">IP           : ##IP##, ##SITE_ADDR##</p></td>

                </tr><tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Whois        : http://whois.sc/##IP##</p></td>

                </tr><tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL          : ##FROM_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'FROM_URL, IP, TELEPHONE, MESSAGE, SITE_NAME, SUBJECT, FROM_EMAIL, LAST_NAME, FIRST_NAME',
			'is_html' => ''
		),
		array(
			'id' => '6',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:36:23',
			'from' => '\"##SITE_NAME## (auto response)\" ##NO_REPLY_EMAIL##',
			'reply_to' => '',
			'name' => 'Contact Us Auto Reply',
			'description' => 'we

will send this mail ti user, when user submit the contact us form.',
			'subject' => '[##SITE_NAME##] RE: ##SUBJECT##',
			'email_content' => 'Dear ##FIRST_NAME####LAST_NAME##,

Thanks for contacting us. We\'ll get back to you shortly.

Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site ##CONTACT_URL##

------ On

##POST_DATE## you wrote from ##IP##

-----

##MESSAGE##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Thanks for contacting us. We\'ll get back to you shortly.</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please do not reply to this automated response. If you have not contacted us and if you feel this is an error, please contact us through our site ##CONTACT_URL##

</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'MESSAGE, POST_DATE, SITE_NAME, CONTACT_URL, FIRST_NAME, LAST_NAME, SUBJECT, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '7',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:36:52',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Membership Fee',
			'description' => 'Pay Membership Fee',
			'subject' => '[##SITE_NAME##] Pay Membership Fee',
			'email_content' => 'Dear ##USERNAME##,\\n\\nYou have successfully registered with our site ##SITE_NAME##. Please pay your membership fee for activate your account.\\n\\n##MEMBERSHIP_URL##.\\n\\nNote: If you paid membership fee then please ignore this email. Thanks for signup with us.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">You have successfully registered with our site ##SITE_NAME##. Please pay your membership fee for activate your account. ##MEMBERSHIP_URL##.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Note: If you paid membership fee then please ignore this email. Thanks for signup with us.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME,MEMBERSHIP_URL,SITE_NAME,SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '8',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:37:16',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Message',
			'description' => 'we will send this mail, when a

user get new message',
			'subject' => '##USERNAME## sent you a message on ##SITE_NAME##...',
			'email_content' => '##USERNAME## sent you a message.

--------------------

##MESSAGE##

--------------------

To view this message, follow the link below:

##MESSAGE_LINK##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\"></p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##USERNAME## sent you a message.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##MESSAGE##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this message, follow the link below: ##MESSAGE_LINK##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'USERNAME,MESSAGE,MESSAGE_LINK,SITE_NAME',
			'is_html' => ''
		),
		array(
			'id' => '9',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:37:36',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Add',
			'description' => 'we will send this mail to

user, when a admin add a new user.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_content' => 'Hi ##USERNAME##,\\n\\n##SITE_NAME## team added you as a user in ##SITE_NAME##.\\n\\nYour account details.\\n##LOGINLABEL##:##USEDTOLOGIN##\\nPassword:##PASSWORD##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## team added you as a user in ##SITE_NAME##.

</p></td>

                </tr>

                <tr>

                  <td width=\"27%\"><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account details.</p></td>

                </tr>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##LOGINLABEL##:##USEDTOLOGIN##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Password:##PASSWORD##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME,PASSWORD, LOGINLABEL, USEDTOLOGIN',
			'is_html' => ''
		),
		array(
			'id' => '17',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-19 13:29:50',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Contest Canceled Alert To Participant',
			'description' => 'We will send this mail to participants, when a contest has been canceled.',
			'subject' => '[##CONTEST_NAME##] Contest Canceled',
			'email_content' => 'Dear ##PARTICIPANT##,

The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was canceled in ##SITE_NAME##.

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was canceled in ##SITE_NAME##.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_NO',
			'is_html' => ''
		),
		array(
			'id' => '10',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:37:47',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Active',
			'description' => 'We will send this mail to

user, when user active

by administator.',
			'subject' => 'Your ##SITE_NAME## account has been activated',
			'email_content' => 'Hi ##USERNAME##,\\n\\nYour account has been activated.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been activated.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '11',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:38:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Deactivate',
			'description' => 'We will send this mail

to user, when user deactive by administator.',
			'subject' => 'Your ##SITE_NAME## account has been deactivated',
			'email_content' => 'Hi ##USERNAME##,\\n\\nYour ##SITE_NAME## account has been deactivated.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your account has been deactivated.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '12',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:38:11',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Delete',
			'description' => 'We will send this mail to

user, when user delete by administrator.',
			'subject' => 'Your ##SITE_NAME## account has been removed',
			'email_content' => 'Hi ##USERNAME##,\\n\\nYour ##SITE_NAME## account has been removed.\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your ##SITE_NAME## account has been removed.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '13',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:38:23',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin Change Password',
			'description' => 'we will send this mail

to user, when admin change user\'s password.',
			'subject' => 'Password changed',
			'email_content' => 'Hi ##USERNAME##,\\n\\nAdmin reset your password for your  ##SITE_NAME## account.\\n\\nYour new password:\\n##PASSWORD##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Admin reset your password for your  ##SITE_NAME## account.</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your new password: ##PASSWORD##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'SITE_NAME,PASSWORD,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '14',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-20 13:39:05',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Contest Entry',
			'description' => 'We will send this mail to

contest owner, when a user posts a new entry.',
			'subject' => 'There is a new entry for your contest!!!',
			'email_content' => 'Hi ##USERNAME##,\\n\\nYour contest ##CONTEST## got a new entry!!!\\n\\nClick the below link to check it out..\\n\\n##CONTEST##\\n\\nEntry Details:\\nEntry No: ###ENTRY_ID##\\nPosted User: ##OTHER_USERNAME##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your contest ##CONTEST## got a new entry!!!</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Click the below link to check it out..</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##CONTEST##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Entry Details:</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Entry No: ###ENTRY_ID##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Posted User: ###OTHER_USERNAME##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'USERNAME,COMMENT,CONTEST,ENTRY_ID,SITE_NAME',
			'is_html' => ''
		),
		array(
			'id' => '15',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2012-04-19 07:06:17',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Activity Alert Mail',
			'description' => 'we will send this mail, when we change the contest status.',
			'subject' => '[##CONTEST_NAME##] Status changed: ##PREVIOUS_STATUS## -> ##CURRENT_STATUS##',
			'email_content' => 'Dear ##USERNAME##,

The status of the contest \"##CONTEST_NAME##\" is changed from \"##PREVIOUS_STATUS##\" to \"##CURRENT_STATUS##\".

##CONTEST_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The status of the contest \"##CONTEST_NAME##\" is changed from \"##PREVIOUS_STATUS##\" to \"##CURRENT_STATUS##\".</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##CONTEST_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'FROM_EMAIL,REPLY_TO_EMAIL,CONTEST_NAME,CURRENT_STATUS,PREVIOUS_STATUS,,CURRENT_STATUS,CONTEST_URL,,SITE_NAME,  SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '16',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-20 13:42:51',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Request Refund Alert',
			'description' => 'We will send this mail to admin, when the contest holder request a refund for contest.',
			'subject' => '[##CONTEST_NAME##] Request for refund',
			'email_content' => 'Dear admin,\\n\\n##CONTEST_HOLDER## request refund for this contest ##CONTEST_NAME##,\\n##CONTEST_URL##\\n\\nMessage:\\n##MESSAGE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear admin,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##CONTEST_HOLDER## request refund for this contest ##CONTEST_NAME##,

##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Message:</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##MESSAGE##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '18',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-19 13:26:51',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Winner Selected Alert To Participant',
			'description' => 'We will send this mail to participant, when winner has been selected for the contest.',
			'subject' => '[##CONTEST_NAME##] Won Contest',
			'email_content' => 'Dear ##PARTICIPANT##,

Congratulations! Your entry has been selected and you won this \"##CONTEST_NAME##\" contest.

To view this contest click this URL,

##CONTEST_URL##

To view the entry click this URL,

##ENTRY_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Congratulations! Your entry has been selected and you won this \"##CONTEST_NAME##\" contest.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the entry click this URL, ##ENTRY_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '19',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-19 13:23:59',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Contest Change Requested Alert To Participant',
			'description' => 'We will send this mail to participant, when the contest holder make a change request for contest.',
			'subject' => '[##CONTEST_NAME##] Change Requested',
			'email_content' => 'Dear ##PARTICIPANT##,\\n\\n##CONTEST_HOLDER## requested a change in your entry ###ENTRY_NO## for the \"##CONTEST_NAME##\" contest.\\n\\nMessage:\\n##MESSAGE##\\n\\nTo view this contest click this URL,\\n##CONTEST_URL##\\n\\nTo view the entry click this URL,\\n##ENTRY_URL##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##CONTEST_HOLDER## requested a change in your entry ###ENTRY_NO## for the \"##CONTEST_NAME##\" contest.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Message:</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##MESSAGE##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the entry click this URL, ##ENTRY_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_NO, CONTEST_HOLDER',
			'is_html' => ''
		),
		array(
			'id' => '20',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-19 13:23:24',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Contest Completed Alert To Participant',
			'description' => 'We will send this mail to Participant, when the contest has been completed.',
			'subject' => '[##CONTEST_NAME##] Contest Completed',
			'email_content' => 'Dear ##PARTICIPANT##,

The entry ###ENTRY_NO## you won for the \"##CONTEST_NAME##\" contest has been completed.

To view this contest click this URL,

##CONTEST_URL##

To view the entry click this URL,

##ENTRY_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The entry ###ENTRY_NO## you won for the \"##CONTEST_NAME##\" contest has been completed</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the entry click this URL, ##ENTRY_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL,  ENTRY_NO',
			'is_html' => ''
		),
		array(
			'id' => '21',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-19 13:19:54',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Contest Amount Paid Alert To Participant',
			'description' => 'We will send this mail to corresponding Participant, when the contest prize amount paid.',
			'subject' => '[##CONTEST_NAME##] Contest prize amount paid',
			'email_content' => 'Dear ##PARTICIPANT##,

This is to notify you that the contest prize amount paid to you for the \"##CONTEST_NAME##\" contest.

To view this contest click this URL,

##CONTEST_URL##

To view the entry click this URL,

##ENTRY_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">This is to notify you that the contest prize amount paid to you for the \"##CONTEST_NAME##\" contest.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the entry click this URL, ##ENTRY_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_URL ',
			'is_html' => ''
		),
		array(
			'id' => '22',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-20 13:44:06',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Entry Eliminated Alert To Participant',
			'description' => 'We will send this mail to participants, when their entry has been eliminated',
			'subject' => '[##CONTEST_NAME##] Entry Eliminated',
			'email_content' => 'Dear ##PARTICIPANT##,

The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was eliminated.

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was eliminated.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_NO',
			'is_html' => ''
		),
		array(
			'id' => '23',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-04-20 13:44:25',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Entry Withdrawn Alert To Participant',
			'description' => 'We will send this mail to participants, when their entry has been withdrawn',
			'subject' => '[##CONTEST_NAME##] Entry Withdrawn',
			'email_content' => 'Dear ##PARTICIPANT##,

The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was withdrawn.

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was withdrawn.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_NO',
			'is_html' => ''
		),
		array(
			'id' => '24',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-11-16 08:35:11',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Entry Lost Alert To Participant',
			'description' => 'We will send this mail to participants, when their entry has been Lost',
			'subject' => '[##CONTEST_NAME##] Entry Lost',
			'email_content' => 'Dear ##PARTICIPANT##,

The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was lost.

To view this contest click this URL,

##CONTEST_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was lost.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_NO',
			'is_html' => ''
		),
		array(
			'id' => '47',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Request reject mail',
			'description' => 'We will send this mail to contest holder when the request is rejected',
			'subject' => '[##CONTEST_NAME##] Contest Cancellation Request Rejected',
			'email_content' => 'Dear ##CONTEST_HOLDER##,

Cancellation request asked for the contest  \"##CONTEST_NAME##\"  was rejected by admin, and it again changed to judging status.

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##CONTEST_HOLDER##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Cancellation request asked for the contest  \"##CONTEST_NAME##\"  was rejected by admin, and it again changed to judging status.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'CONTEST_HOLDER, CONTEST_NAME, SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '26',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-11-26 08:51:51',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Eliminated Entry Cancel Alert To Participant',
			'description' => 'if the contest is in payment pending status mail send to

contest

holder.',
			'subject' => '[##CONTEST_NAME##] Elimination Canceled',
			'email_content' => 'Dear ##USERNAME##,

The elimination canceled for the entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest.

To view this contest click this URL, ##CONTEST_URL##

To view the entry click this URL, ##ENTRY_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The elimination canceled for the entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the entry click this URL, ##ENTRY_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'CONTEST_URL,ENTRY_NO

CONTEST_NAME,SITE_NAME, SITE_URL,',
			'is_html' => ''
		),
		array(
			'id' => '27',
			'created' => '2012-04-19 15:03:54',
			'modified' => '2012-05-11 11:56:15',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Withdraw Entry Cancel Alert To Participant',
			'description' => 'Mail send to participant if the contest holder cancel the

withdrawal

of a entry',
			'subject' => '[##CONTEST_NAME##]  Canceled withdrawal',
			'email_content' => 'Dear ##USERNAME##,

Canceled a withdrawal of the  entry

###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\"

contest.

To view this contest click this

URL,

##CONTEST_URL##

To view the entry click this

URL,

##ENTRY_URL##

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Canceled a withdrawal of the  entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view this contest click this URL, ##CONTEST_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">To view the entry click this URL, ##ENTRY_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'USERNAME,CONTEST_URL,ENTRY_NO

CONTEST_NAME,SITE_NAME,

SITE_URL,',
			'is_html' => ''
		),
		array(
			'id' => '48',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Comment Notification',
			'description' => 'We will send this notification to admin when a user posted comment in blog or node page.',
			'subject' => '[##SITE_NAME##] New comment posted under ##NODE_TITLE##',
			'email_content' => 'A new comment has been posted under: ##NODE_TITLE##

##NODE_URL##

Name: ##NAME##

Email: ##EMAIL##

Website: ##WEBSITE##

IP: ##IP##

Comment: ##COMMENT##

Thanks,

##SITE_URL##

##SITE_NAME##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\"></p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">A new comment has been posted under: ##NODE_TITLE##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##NODE_URL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Name: ##NAME##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Email: ##EMAIL##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Website: ##WEBSITE##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">IP: ##IP##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Comment: ##COMMENT##</p></td>

                </tr

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => '',
			'is_html' => ''
		),
		array(
			'id' => '49',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Contest',
			'description' => 'we will send this when a new contest is added.',
			'subject' => 'New contest added - ##CONTEST_NAME##',
			'email_content' => 'Dear Admin,

New contest added.

Contest Name: ##CONTEST_NAME##

Contest Holder: ##CONTEST_HOLDER##

URL: ##CONTEST_URL##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Admin,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">New contest added.</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\"></p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Contest Name: ##CONTEST_NAME##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Contest Holder: ##CONTEST_HOLDER##</p></td>

                </tr>

				<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">URL: ##CONTEST_URL##</p></td>

                </tr>

				</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => '',
			'is_html' => ''
		),
		array(
			'id' => '50',
			'created' => '2012-12-28 11:41:12',
			'modified' => '2012-12-28 11:41:14',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Entry Deleted Alert To Participant',
			'description' => 'We will send this mail to participants, when their entry has been deleted',
			'subject' => '[##CONTEST_NAME##] Entry Deleted',
			'email_content' => 'Dear ##PARTICIPANT##,

The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was deleted ##SUSPICIOUS_CONTENT##.

Thanks,

##SITE_NAME##

##SITE_URL##

You are receiving this email because you opted in at our website ##SITE_NAME##.

If you don\'t want to receive these emails in the future, please click: ##UNSUBSCRIBE_LINK##.',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##PARTICIPANT##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">The entry ###ENTRY_NO## you have posted for this \"##CONTEST_NAME##\" contest was deleted ##SUSPICIOUS_CONTENT##.</p></td>

                </tr>

				</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">You are receiving this email because you opted in at our website ##SITE_NAME##.</p></td>

        </tr>

		<tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">If you don\'t want to receive these emails in the future, please click: <a style=\"color: #DE3C7A;\" title=\"Unsubscribe ##SITE_NAME##\" href=\"##UNSUBSCRIBE_LINK##\" target=\"_blank\">Unsubscribe</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'PARTICIPANT, CONTEST_NAME, SITE_NAME, SITE_URL, ENTRY_NO, SUSPICIOUS_CONTENT',
			'is_html' => ''
		),
		array(
			'id' => '51',
			'created' => '2013-02-05 11:41:12',
			'modified' => '2013-02-05 11:41:14',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Admin User Edit',
			'description' => 'we will send this mail\\rinto user, when admin edit user\'s profile.',
			'subject' => 'Profile updated',
			'email_content' => 'Hi ##USERNAME##,

Admin updated your profile in ##SITE_NAME## account.

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Admin updated your profile in ##SITE_NAME## account</p></td>

                </tr>

				</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'SITE_NAME,EMAIL,USERNAME',
			'is_html' => ''
		),
		array(
			'id' => '52',
			'created' => '1970-01-01 00:00:00',
			'modified' => '2013-03-29 11:36:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Reactivation',
			'description' => 'we will send this mail,

when user registering an account he/she will not get an activation

request.',
			'subject' => 'Reactivate your ##SITE_NAME## account',
			'email_content' => 'Hi ##USERNAME##,\\n\\nPlease click on the following URL to reactivate your account.\\n##ACTIVATION_URL##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please click on the following URL to reactivate your account.

##ACTIVATION_URL##</p></td>

                </tr>

				</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => 'SITE_NAME,USERNAME,ACTIVATION_URL',
			'is_html' => ''
		),
		array(
			'id' => '53',
			'created' => '2013-03-29 14:02:36',
			'modified' => '2013-03-29 14:02:39',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite New User',
			'description' => 'we will send this mail to invite user by other user',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_content' => 'Dear ##USER_NAME##,

##OTHER_USER_NAME## has invited you to the site ##SITE_NAME## (##SITE_URL##)

Thanks,

##SITE_NAME##

##SITE_URL##,

##USER_NAME##,

##OTHER_USER_NAME##,

##SITE_NAME##,##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USER_NAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##OTHER_USER_NAME## has invited you to the site ##SITE_NAME## (##SITE_URL##)</p></td>

                </tr>

				</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

			  <h6 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 14px;\">##USER_NAME##, ##OTHER_USER_NAME##, ##SITE_NAME##,##SITE_URL##</h6>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => '0',
			'is_html' => ''
		),
		array(
			'id' => '54',
			'created' => '2012-07-27 15:17:04',
			'modified' => '2012-07-27 15:17:07',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Failed Forgot Password',
			'description' => 'we will send this mail, when user submit the forgot password form.',
			'subject' => 'Forgot password request failed',
			'email_content' => 'Hi there,

You (or someone else) entered this email address when trying to change the password of an ##user_email## account.

However, this email address is not in our registered users and therefore the attempted password request has failed. If you are our customer and were expecting this email, please try again using the email you gave when opening your account.

If you are not an ##SITE_NAME## customer, please ignore this email. If you did not request this action and feel this is an error, please contact us ##SUPPORT_EMAIL##.

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi there,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">You (or someone else) entered this email address when trying to change the password of an ##user_email## account.</p></td>

                </tr>

	 <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">

However, this email address is not in our registered users and therefore the attempted password request has failed. If you are our customer and were expecting this email, please try again using the email you gave when opening your account.</p></td>

	</tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">If you are not an ##SITE_NAME## customer, please ignore this email. If you did not request this action and feel this is an error, please contact us </p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'CONTENT,SITE_NAME, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '55',
			'created' => '2012-07-30 10:30:44',
			'modified' => '2012-07-30 10:30:44',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Failed Social User',
			'description' => 'we will send this mail, when user submit the forgot password form and the user users social network websites like twitter, facebook to register.',
			'subject' => 'Forgot password request failed',
			'email_content' => 'Hi ##USERNAME##,

Your forgot password request was failed because you have registered via ##OTHER_SITE## site.

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USERNAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your forgot password request was failed because you have registered via ##OTHER_SITE## site.</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'CONTENT,SITE_NAME, SITE_URL,OTHER_SITE',
			'is_html' => ''
		),
		array(
			'id' => '56',
			'created' => '2012-09-05 15:44:58',
			'modified' => '2012-09-05 15:45:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite User',
			'description' => 'we will send this mail to invite user for private beta.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_content' => 'Dear Subscriber,\\n\\n##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...\\n##INVITE_LINK##\\n\\nInvite Code: ##INVITE_CODE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...##INVITE_LINK##</p></td>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Invite Code: ##INVITE_CODE##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '57',
			'created' => '2012-09-05 15:44:58',
			'modified' => '2012-09-05 15:45:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Launch mail',
			'description' => 'we will send this mail to inform user that the site launched.',
			'subject' => ' ##SITE_NAME## Launched',
			'email_content' => 'Dear Subscriber,

##SITE_NAME##  Launched

##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...

##INVITE_LINK##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  Launched ##SITE_NAME## team want to add you as a user in ##SITE_NAME##.Click the below link to join us...##INVITE_LINK##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '58',
			'created' => '2012-09-05 15:44:58',
			'modified' => '2012-09-05 15:45:01',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Private Beta mail',
			'description' => 'we will send this mail to inform user that the site move to Private Beta.',
			'subject' => '##SITE_NAME## moved to Private Beta',
			'email_content' => 'Dear Subscriber,\\n\\n##SITE_NAME##  moved to Private Beta, Click the below link to join us...\\n##INVITE_LINK##\\n\\nInvite Code: ##INVITE_CODE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">##SITE_NAME##  moved to Private Beta, Click the below link to join us...##INVITE_LINK##</p></td>

                </tr>

	<tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Invite Code: ##INVITE_CODE##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '59',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Invite Friend',
			'description' => 'we will send this mail to invite friend for private beta.',
			'subject' => 'Welcome to ##SITE_NAME##',
			'email_content' => 'Dear Subscriber,\\n\\nYour friend ##USER_NAME## has invited you to join ##SITE_NAME##. Click the below link to join us...\\n##INVITE_LINK##\\n\\nInvite Code: ##INVITE_CODE##\\n\\nThanks,\\n##SITE_NAME##\\n##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear Subscriber,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your friend ##USER_NAME## has invited you to join ##SITE_NAME##. Click the below link to join us...##INVITE_LINK##</p></td>

                </tr>

	 <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please Invite Code: ##INVITE_CODE##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, SITE_URL,INVITE_LINK,',
			'is_html' => ''
		),
		array(
			'id' => '60',
			'created' => '1970-01-01 00:00:00',
			'modified' => '1970-01-01 00:00:00',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'Prelaunch subscription email confirmation',
			'description' => 'Email confirmation for pre lanuch mode subscription',
			'subject' => 'Email Confirmation',
			'email_content' => 'Hi,

Your subscription made successfully. You need to do one more step to confirm your email address. This confirmation is recommended to receive further valuable email from us.

Please visit the following URL to confirm your email

##VERIFICATION_URL##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Hi</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Your subscription made successfully. You need to do one more step to confirm your email address. This confirmation is recommended to receive further valuable email from us.</p></td>

                </tr>

	 <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">Please visit the following URL to confirm your email ##VERIFICATION_URL##</p></td>

                </tr>

              </tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>',
			'email_variables' => 'SITE_NAME, VERIFICATION_URL, SITE_URL',
			'is_html' => ''
		),
		array(
			'id' => '61',
			'created' => '2013-08-31 12:45:01',
			'modified' => '2013-08-31 12:45:03',
			'from' => '##FROM_EMAIL##',
			'reply_to' => '##REPLY_TO_EMAIL##',
			'name' => 'New Contest For Participants',
			'description' => 'we will send this when a new contest is added to all previous participants.',
			'subject' => 'New contest added - ##CONTEST_NAME##',
			'email_content' => 'Dear ##USER_NAME##,

New contest was added in ##SITE_NAME## by ##CONTEST_HOLDER##. To view the contest click the below URL, ##CONTEST_URL##

Thanks,

##SITE_NAME##

##SITE_URL##',
			'email_html_content' => '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">

<html xmlns=\"http://www.w3.org/1999/xhtml\">

<head>

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />

<title>Admin Change Password</title>

<style type=\"text/css\">

 @import url(http://fonts.googleapis.com/css?family=Open+Sans);

</style>

<link href=\"http://fonts.googleapis.com/css?family=Open+Sans\" rel=\"stylesheet\" type=\"text/css\" />

</head>

<body>

<div style=\"margin: 5px 0pt; padding: 20px; width: 700px; font-family: Open Sans,sans-serif; background-color: #f2f2f2; background-repeat: no-repeat;-webkit-border-radius: 10px;

-moz-border-radius: 10px;

border-radius: 10px;\">

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"text-align: center; font-size: 11px; color: #929292; margin: 3px;\">Be sure to add <a style=\"color: #DE3C7A;\" title=\"Add ##FROM_EMAIL## to your whitelist\" href=\"mailto:##FROM_EMAIL##\" target=\"_blank\">##FROM_EMAIL##</a> to your address book or safe sender list so our emails get to your inbox.</p></td>

      </tr>

    </tbody>

  </table>

  <div style=\"border-bottom: 1px solid #ccc; margin: 0pt; background: -moz-linear-gradient(top, #ffffff 0%, #f2f2f2 100%);

background: -webkit-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -o-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

background: -ms-linear-gradient(top, #ffffff 0%,#f2f2f2 100%);

filter: progid:DXImageTransform.Microsoft.gradient( startColorstr=\'#ffffff\', endColorstr=\'#f2f2f2\',GradientType=0 );

 min-height: 70px;\">

<table cellspacing=\"0\" cellpadding=\"0\" width=\"700\">

<tbody>

<tr>

<td  valign=\"top\" style=\"padding:14px 0 0 10px; width: 110px; min-height: 37px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\"><img style=\"padding-right: 15px; border: 0px 1px 0px 0px none solid none none -moz-use-text-color #333333 -moz-use-text-color -moz-use-text-color;\" src=\"##SITE_URL##/img/logo.png\" alt=\"[Image: ##SITE_NAME##]\" /></a></td>

<td width=\"505\" align=\"center\" valign=\"top\" style=\"padding-left: 15px; width: 250px; padding-top: 16px;\"><a style=\"color: #0981be;\" title=\"##SITE_NAME##\" href=\"#\" target=\"_blank\"></a></td>

<td width=\"21\" align=\"right\" valign=\"top\" style=\"padding-right: 20px; padding-top: 21px;\">&nbsp;</td>

</tr>

</tbody>

</table>

</div>

  <div style=\" padding: 20px; background-repeat: no-repeat; background-color: #ffffff; box-shadow: 0 0 7px rgba(0, 0, 0, 0.067);\">

    <table style=\"background-color: #ffffff;\" width=\"100%\">

      <tbody>

        <tr>

          <td style=\"padding: 20px 30px 5px;\"><p style=\"color: #545454; font-size: 18px;\">Dear ##USER_NAME##,</p>

            <table border=\"0\" width=\"100%\">

              <tbody>

                <tr>

                  <td><p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: left; padding: 5px 0px;\">New contest was added in ##SITE_NAME## by ##CONTEST_HOLDER##. To view the contest click the below URL, ##CONTEST_URL##</p></td>

                </tr>

				</tbody>

            </table>

            <p style=\" color: #545454; margin: 0pt 20px; font-size: 16px; text-align: center; padding: 15px 0px;\">&nbsp;</p></td>

        </tr>

        <tr>

          <td><div style=\"border-top: 1px solid #d6d6d6; padding: 15px 30px 25px; margin: 0pt 30px;\">

              <h4 style=\" font-size: 22px; font-weight: bold; text-align: center; margin: 0pt 0pt 5px; line-height: 26px; color: #DE3C7A;\">Thanks,</h4>

              <h5 style=\" color: #545454; line-height: 20px; text-align: center; margin: 0pt; font-size: 16px;\">##SITE_NAME## - <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_URL##</a></h5>

            </div></td>

        </tr>

      </tbody>

    </table>

    <table style=\"margin-top: 2px; background-color: #f5f5f5;\" width=\"100%\">

      <tbody>

        <tr>

          <td><p style=\" color: #000; font-size: 12px; text-align: center; line-height: 16px; margin: 10px;\">Need help? Have feedback? Feel free to <a style=\"color: #DE3C7A;\" title=\"Contact ##SITE_NAME##\" href=\"##CONTACT_URL##\" target=\"_blank\">Contact Us</a></p></td>

        </tr>

      </tbody>

    </table>

  </div>

  <table cellspacing=\"0\" cellpadding=\"0\" width=\"720px\">

    <tbody>

      <tr>

        <td align=\"center\"><p style=\"font-size: 11px; color: #929292; margin: 3px; padding-top: 10px;\">Delivered by <a style=\"color: #DE3C7A;\" title=\"##SITE_NAME##\" href=\"##SITE_URL##\" target=\"_blank\">##SITE_NAME##</a></p></td>

      </tr>

    </tbody>

  </table>

</div>

</body>

</html>',
			'email_variables' => '',
			'is_html' => ''
		),
	);

}
