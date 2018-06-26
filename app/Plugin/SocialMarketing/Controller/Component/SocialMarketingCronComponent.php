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
class SocialMarketingCronComponent extends Component
{
    public function daily()
    {
        App::import('Model', 'SocialMarketing.SocialMarketing');
        $this->SocialMarketing = new SocialMarketing();
	    App::import('Model', 'User');
        $this->User = new User();
        App::import('Model', 'SocialMarketing.SocialContactDetail');
        $this->SocialContactDetail = new SocialContactDetail();
        App::import('Model', 'SocialMarketing.SocialContact');
        $this->SocialContact = new SocialContact();
        $users = $this->User->find('all', array(
            'recursive' => -1
        ));
        $facebookIds = array();
        $twitterIds = array();
        $gmailIds = array();
        $yahooIds = array();
        foreach($users as $user) {
            if (!empty($user['User']['is_facebook_connected']) || !empty($user['User']['is_facebook_register'])) {
                $facebookIds[$user['User']['id']]['facebook_user_id'] = $user['User']['facebook_user_id'];
            }
            if (!empty($user['User']['is_twitter_connected']) || !empty($user['User']['is_twitter_register'])) {
                $twitterIds[$user['User']['id']]['twitter_user_id'] = $user['User']['twitter_user_id'];
            }
            if (!empty($user['User']['is_google_connected']) || !empty($user['User']['is_google_register'])) {
                $gmailIds[$user['User']['id']]['email'] = $user['User']['email'];
            }
            if (!empty($user['User']['is_yahoo_connected']) || !empty($user['User']['is_yahoo_register'])) {
                $yahooIds[$user['User']['id']]['email'] = $user['User']['email'];
            }
        }
        $this->saveUserId($facebookIds, 'facebook_user_id');
        $this->saveUserId($twitterIds, 'twitter_user_id');
        $this->saveUserId($gmailIds, 'email');
        $this->saveUserId($yahooIds, 'email');
    }
    public function saveUserId($ids, $field)
    {
        foreach($ids as $key => $id) {
            $SocialContactDetails = $this->SocialContactDetail->find('list', array(
                'conditions' => array(
                    'SocialContactDetail.' . $field => $id
                ) ,
                'fields' => array(
                    'SocialContactDetail.id'
                )
            ));
            if (!empty($SocialContactDetails)) {
                foreach($SocialContactDetails as $SocialContactDetail) {
                    $socailContact = $this->SocialContact->find('first', array(
                        'conditions' => array(
                            'SocialContact.social_contact_detail_id' => $SocialContactDetail
                        ) ,
                        'recursive' => -1
                    ));
                    $_data = $socailContact;
                    $_data['SocialContact']['social_user_id'] = $key;
                    $this->SocialContact->save($_data);
                }
            }
        }
    }
}
