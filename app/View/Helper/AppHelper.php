<?php
/**
 *
 * @package		360Contest
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-03-07
 *
 */
App::uses('Helper', 'View');
class AppHelper extends Helper
{
    public function assetUrl($path, $options = array() , $cdn_path = '') 
	{
        $assetURL = Cms::dispatchEvent('Helper.HighPerformance.getAssetUrl', $this->_View, array(
            'options' => $options,
            'assetURL' => '',
        ));
        return parent::assetUrl($path, $options, $assetURL->data['assetURL']);
    }
    /**
     * Url helper function
     *
     * @param string $url
     * @param bool $full
     * @return mixed
     * @access public
     */
    public function url($url = null, $full = false)
    {
        if (!isset($url['locale']) && isset($this->request->params['locale'])) {
            $url['locale'] = $this->request->params['locale'];
        }
        return parent::url($url, $full);
    }
    public function getUserLink($user_details)
    {
        if ((!empty($user_details['role_id']) && $user_details['role_id'] == ConstUserTypes::Admin) || (!empty($user_details['role_id']) && $user_details['role_id'] == ConstUserTypes::User)) {
			$class="grayc text-12";
			if((!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')) { $class="text-12"; }
            return $this->link($this->cText($user_details['username'], false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
				'class' => $class,
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
    }
	public function getUserLinkCustom($user_details, $class='link-style')
    {
        if ((!empty($user_details['role_id']) && $user_details['role_id'] == ConstUserTypes::Admin) || (!empty($user_details['role_id']) && $user_details['role_id'] == ConstUserTypes::User)) {
            return $this->link($this->cText($user_details['username'], false) , array(
                'controller' => 'users',
                'action' => 'view',
                $user_details['username'],
                'admin' => false
            ) , array(
				'class' => $class,
                'title' => $this->cText($user_details['username'], false) ,
                'escape' => false
            ));
        }
    }
    public function getCurrUserInfo($id)
    {
        App::uses('User', 'Model');
        $this->User = new User();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $id,
            ) ,
            'recursive' => -1
        ));
        return $user;
    }
    function getUserAvatarLink($user_details, $dimension = 'medium_thumb', $is_link = true)
    {
		$width = Configure::read('thumb_size.' . $dimension . '.width');
		$height = Configure::read('thumb_size.' . $dimension . '.height');
		$user_image = '';
        if ((!empty($user_details['user_avatar_source_id']) && $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Facebook)) {
            $user_image = $this->getFacebookAvatar($user_details['facebook_user_id'], $height, $width);
        } elseif ((!empty($user_details['user_avatar_source_id']) &&  $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Twitter)) {
            $user_image = $this->image($user_details['twitter_avatar_url'], array(
                'title' => $this->cText($user_details['username'], false) ,
                'width' => $width,
                'height' => $height
            ));
        } elseif((!empty($user_details['user_avatar_source_id']) &&  $user_details['user_avatar_source_id'] == ConstUserAvatarSource::Linkedin)) {
			if (!empty($user_details['linkedin_avatar_url'])) {
				$user_image = $this->image($user_details['linkedin_avatar_url'], array(
					'title' => $this->cText($user_details['username'], false),
					'width' => $width,
					'height' => $height
				));
			} else {
				$user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
				$user_image = $this->image(getImageUrl('UserAvatar', '', array(
					'dimension' => $dimension
				)) , array(
					'width' => $width,
					'height' => $height,
					'alt' => sprintf(__l('[Image: %s]') , $this->cText($user_details['username'], false)) ,
					'title' => (!$is_link) ? $this->cText($user_details['username'], false) : '',
				));				
			}
		} else {
		if (empty($user_details['UserAvatar'])) {
			if (!empty($user_details['id'])) {
				App::uses('User', 'Model');
				$this->User = new User();
				$user = $this->User->find('first', array(
					'conditions' => array(
						'User.id' => $user_details['id'],
					) ,
					'contain' => array(
						'UserAvatar'
					) ,
					'recursive' => 0
				));
				if (!empty($user['UserAvatar']['id'])) {
					$user_details['UserAvatar'] = $user['UserAvatar'];
				}
			}
		}
		if (!empty($user_details['UserAvatar'])) {
            $user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
            $user_image = $this->Html->Image(getImageUrl('UserAvatar', $user_details['UserAvatar'], array(
                'dimension' => $dimension,
                'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                'title' => $user_details['username'],
		         )),
				array(
				'width'=>$width, 
				'height'=>$height
				));
		}
		else
		{
			$user_details['username'] = !empty($user_details['username']) ? $user_details['username'] : '';
            $user_image = $this->Html->Image(getImageUrl('UserAvatar', '', array(
                'dimension' => $dimension,
                'alt' => sprintf('[Image: %s]', $user_details['username']) ,
                'title' => $user_details['username'],
	            )),
				array(
				'width'=>$width, 
				'height'=>$height
				));
		}
		}
        //return image to user
        return (!$is_link) ? $user_image : $this->link($user_image, array(
            'controller' => 'users',
            'action' => 'view',
            $user_details['username'],
            'admin' => false
        ) , array(
            'title' => $this->cText($user_details['username'], false) ,
            'escape' => false
        ));
    }
    public function isWalletEnabled()
    {
        App::uses('PaymentGateway', 'Model');
        $this->PaymentGateway = new PaymentGateway();
        $PaymentGateway = $this->PaymentGateway->find('first', array(
            'conditions' => array(
                'PaymentGateway.id' => ConstPaymentGateways::Wallet
            ) ,
            'recursive' => -1
        ));
        if (!empty($PaymentGateway['PaymentGateway']['is_active'])) {
            return true;
        }
        return false;
    }
    public function getUserAvatar($user_id)
    {
        App::import('Model', 'User');
        $modelObj = new User();
        $user = $modelObj->find('first', array(
            'conditions' => array(
                'User.id' => $user_id,
            ) ,
            'fields' => array(
                'UserAvatar.id',
                'UserAvatar.dir',
                'UserAvatar.filename'
            ) ,
            'recursive' => 0
        ));
        return $user['UserAvatar'];
    }
    public function siteCurrencyFormat($amount, $wrap = 'span')
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $this->cCurrency($amount, $wrap);
        } else {
            return $this->cCurrency($amount, $wrap) . Configure::read('site.currency');
        }
    }
    public function getLanguage()
    {
		if (isPluginEnabled('Translation')){
			App::import('Model', 'Translation.Translation');
			$this->Translation = new Translation();
			$languages = $this->Translation->find('all', array(
				'conditions' => array(
					'Language.id !=' => 0
				) ,
				'fields' => array(
					'DISTINCT(Translation.language_id)',
					'Language.name',
					'Language.iso2'
				) ,
				'order' => array(
					'Language.name' => 'ASC'
				),
				'recursive' => 0
			));
			$languageList = array();
			if (!empty($languages)) {
				foreach($languages as $language) {
					$languageList[$language['Language']['iso2']] = $language['Language']['name'];
				}
			}
			return $languageList;
		}
    }
    public function transactionDescription($transaction, $is_admin = 0)
    {
        App::import('Model', 'Transaction');
        $this->Transaction = new Transaction();
        $user_link = $this->getUserLink($transaction['User']);
        if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AmountDeductedForCompletedContest) {
            App::import('Model', 'User');
            $modelObj = new User();
            $user = $modelObj->find('first', array(
                'conditions' => array(
                    'User.id' => $transaction['Contest']['winner_user_id'],
                ) ,
                'recursive' => -1
            ));
            $user_link = $this->getUserLink($user['User']);
        }
        $transactionReplace = array(
            '##USER##' => $user_link,
            '##CONTEST##' => !empty($transaction['Contest']) ? $this->link($transaction['Contest']['name'], array(
                'controller' => 'contests',
                'action' => 'view',
                $transaction['Contest']['slug'],
                'admin' => false
            ), array('title' => $transaction['Contest']['name'])) : '',
            '##SITE_COMMISION##' => !empty($transaction['Contest']['site_commision']) ? $this->siteCurrencyFormat($transaction['Contest']['site_commision']) : '',
            '##SITE_FEE##' => !empty($transaction['Contest']) ? $this->siteCurrencyFormat($transaction['Contest']['creation_cost']-$transaction['Contest']['prize']) : 0,
            '##CONTEST_AMOUNT##' => !empty($transaction['Contest']) ? $this->siteCurrencyFormat($transaction['Contest']['prize']) : '',
			'##UPGRADE_AMOUNT##' => !empty($transaction['Contest']) ? $this->siteCurrencyFormat($transaction['Transaction']['amount']) : '',
            '##SECOND_USER##' => !empty($transaction['SecondUser']['username']) ? $this->link($transaction['SecondUser']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $transaction['SecondUser']['username'],
                'admin' => false
            )) : '',
        );
        if ($is_admin) {
            return strtr($transaction['TransactionType']['message_for_admin'], $transactionReplace);
        } else {
            return strtr($transaction['TransactionType']['message'], $transactionReplace);
        }
    }
    public function getFacebookAvatar($fbuser_id, $height = 35, $width = 35)
    {
        return $this->image("http://graph.facebook.com/{$fbuser_id}/picture", array(
            'height' => $height,
            'width' => $width
        ));
    }
    public function getUserUnReadMessages($user_id = null)
    {
        App::import('Model', 'Contests.Message');
        $this->Message = new Message();
        $unread_count = $this->Message->find('count', array(
            'conditions' => array(
                'Message.is_read' => '0',
                'Message.user_id' => $user_id,
                'Message.is_sender' => '0',
                'Message.message_folder_id' => ConstMessageFolder::Inbox,
                'MessageContent.admin_suspend ' => 0,
            ) ,
            'recursive' => 0
        ));
        return $unread_count;
    }
    public function displayActivities($message,$notification=null)
    {
        $contest_flag = 1;
        if (!empty($message['Contest']['admin_suspend'])) {
            $contest_flag = 0;
        }
        $entry_flag = 1;
        if (!empty($message['ContestUser']['admin_suspend'])) {
            $entry_flag = 0;
        }
        $blind_flag = 1;
        if (!empty($message['Contest']['is_blind']) && empty($message['Contest']['winner_user_id'])) {
            if (empty($message['ContestUser']['user_id'])) {
                $message['ContestUser']['user_id'] = 0;
            }
            if (!empty($_SESSION['Auth']) && !empty($_SESSION['Auth']['User']) && ($message['ContestUser']['user_id'] == $_SESSION['Auth']['User']['id'] || $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin || $message['Contest']['user_id'] == $_SESSION['Auth']['User']['id'])) {
                $blind_flag = 0;
            }
        }
        if (!empty($message['ContestStatus']['message'])) {
            $activity_message = $message['ContestStatus']['message'];
        } elseif ($message['Message']['contest_status_id'] == ConstContestStatus::NewEntry) {
            $activity_message = ConstActivityMessage::NewEntry;
        } elseif ($message['Message']['contest_status_id'] == ConstContestStatus::Rated) {
            $activity_message = ConstActivityMessage::Rated;
        }
        $FindReplace = array();
        if (!empty($contest_flag)) {
            $FindReplace['##CONTEST##'] = $this->link($message['Contest']['name'], array(
                'controller' => 'contests',
                'action' => 'view',
                $message['Contest']['slug']
            ), array(
				'class' => 'grayc'	
			));
        } else {
            $FindReplace['##CONTEST##'] = $message['Contest']['name'];
        }
        $FindReplace['##CONTEST_AMOUNT##'] = $this->siteCurrencyFormat($message['Contest']['prize']);
        $FindReplace['##HOLDER_NAME##'] = $this->Html->getUserAvatarLink($message['Contest']['User'], 'micro_thumb') . $this->link($message['Contest']['User']['username'], array(
            'controller' => 'users',
            'action' => 'view',
            $message['Contest']['User']['username']
        ), array(
			'class' => 'pinkc textb text-14 hor-smspace'
		));
        if (!empty($message['Contest']['WinnerUser']['id'])) {
            $FindReplace['##WINNER_USER##'] = $this->Html->getUserAvatarLink($message['Contest']['WinnerUser'], 'micro_thumb')  . $this->link($message['Contest']['WinnerUser']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $message['Contest']['WinnerUser']['username']
            ), array(
			    'class' => 'pinkc textb text-14 hor-smspace'
		    ));
        }
		$FindReplace['##ENTRY_NO##'] = '#' . $message['ContestUser']['entry_no'];
        if (!empty($message['ContestUser']['id'])) {
            if ($message['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn || empty($entry_flag) || empty($blind_flag)) {
                $FindReplace['##ENTRY_NO##'] = '#' . $message['ContestUser']['entry_no'];
            } else {
                $FindReplace['##ENTRY_NO##'] = $this->link('#' . $message['ContestUser']['entry_no'], array(
                    'controller' => 'contest_users',
                    'action' => 'view',
                    $message['Contest']['slug'],
                    'entry' => $message['ContestUser']['entry_no']
                ));
            }
			if(!empty($message['ContestUser']['User']['username'])){
            $FindReplace['##CONTEST_USER##'] = $this->Html->getUserAvatarLink($message['ContestUser']['User'], 'micro_thumb') . $this->link($message['ContestUser']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $message['ContestUser']['User']['username']
            ), array(
			    'class' => 'pinkc textb text-14 hor-smspace'
		    ));
			}
        }
        if (isPluginEnabled('EntryRatings')) {
            if (!empty($message['ContestUserRating']['id'])) {
                $FindReplace['##RATING##'] = $this->get_star_rating(round($message['ContestUserRating']['rating'], 2));
                $FindReplace['##RATED_USER##'] = $this->Html->getUserAvatarLink($message['ContestUserRating']['User'], 'micro_thumb') . $this->link($message['ContestUserRating']['User']['username'], array(
                    'controller' => 'users',
                    'action' => 'view',
                    $message['ContestUserRating']['User']['username']
                ), array(
			        'class' => 'pinkc textb text-14 hor-smspace'
		        ));
            }
        }
        $activity_messages = strtr($activity_message, $FindReplace);
		if(empty($notification)){
			$span ="span10";
		}
		else{
			$span="span6";
		}
		if(empty($notification)){
			$activity_message = $activity_messages;
		} else {
			$activity_message = '<div class="'.$span.' clearfix grayc hor-mspace"><span class="pull-left">' . $activity_messages . '</span></div>';
		}
        return $activity_message;
    }
    public function get_star_rating($current_rating)
    {
        $current_rating_percentage = $current_rating*20;
        $rating = '<ul class="small-star star-rating"><li class="current-rating" style="width:' . $current_rating_percentage . '%;" title="' . $current_rating . '/5' . __l('Stars') . '">' . $current_rating . '/5' . __l('Stars') . '</li></ul>';
        return $rating;
    }
	function cCurrency($str, $wrap = 'span', $title = false, $currency_code = null) 
    {
        if (empty($currency_code)) {
            $currency_code = Configure::read('site.currency_code');
        }
        $_precision = 2;
        $changed = (($r = floatval($str)) != $str);
        $rounded = (($rt = round($r, $_precision)) != $r);
        $r = $rt;
        if ($wrap) {
            if (!$title) {
                $Numbers_Words = new Numbers_Words();
                $title = ucwords($Numbers_Words->toCurrency($r, 'en_US', $currency_code));
            }
            $r = '<' . $wrap . ' class="c' . $changed . ' cr' . $rounded . '" title="' . $title . '">' . number_format($r, $_precision, '.', ',') . '</' . $wrap . '>';
        }
        return $r;
    }
	function getPluginChildren($plugin, $depth, $image_title_icons) 
    {
        if (!empty($plugin['Children'])) {
            foreach($plugin['Children'] as $key => $subPlugin) {
                if (empty($subPlugin['name'])) {
                    echo $this->_View->element('plugin_head', array(
                        'key' => $key,
                        'image_title_icons' => $image_title_icons,
                        'depth' => $depth
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                } else {
                    echo $this->_View->element('plugin', array(
                        'pluginData' => $subPlugin,
                        'depth' => $depth
                    ) , array(
                        'plugin' => 'Extensions'
                    ));
                }
                if (!empty($subPlugin['Children'])) {
                    $depth++;
                    $this->getPluginChildren($subPlugin, $depth, $image_title_icons);
                    $depth = 0;
                }
            }
        }
    }
	public function displayEntryActivities($message)
    {
        $contest_flag = 1;
        if (!empty($message['Contest']['admin_suspend'])) {
            $contest_flag = 0;
        }
        $entry_flag = 1;
        if (!empty($message['ContestUser']['admin_suspend'])) {
            $entry_flag = 0;
        }
        $blind_flag = 1;
        if (!empty($message['Contest']['is_blind']) && empty($message['Contest']['winner_user_id'])) {
            if (empty($message['ContestUser']['user_id'])) {
                $message['ContestUser']['user_id'] = 0;
            }
            if (!empty($_SESSION['Auth']) && ($message['ContestUser']['user_id'] == $_SESSION['Auth']['User']['id'] || $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin || $message['Contest']['user_id'] == $_SESSION['Auth']['User']['id'])) {
                $blind_flag = 0;
            }
        }
        if (!empty($message['ContestStatus']['message'])) {
            $activity_message = $message['ContestStatus']['message'];
        } elseif ($message['Message']['contest_status_id'] == ConstContestStatus::NewEntry) {
            $activity_message = ConstActivityMessage::NewEntry;
        } elseif ($message['Message']['contest_status_id'] == ConstContestStatus::Rated) {
            $activity_message = ConstActivityMessage::Rated;
        }
        $FindReplace = array();
        if (!empty($contest_flag)) {
            $FindReplace['##CONTEST##'] = $this->link($message['Contest']['name'], array(
                'controller' => 'contests',
                'action' => 'view',
                $message['Contest']['slug']
            ), array(
				'class' => 'grayc'	
			));
        } else {
            $FindReplace['##CONTEST##'] = $message['Contest']['name'];
        }
        $FindReplace['##CONTEST_AMOUNT##'] = $this->siteCurrencyFormat($message['Contest']['prize']);
        $FindReplace['##HOLDER_NAME##'] = '<span class="inline">'.$this->Html->getUserAvatarLink($message['Contest']['User'], 'micro_thumb') . $this->link($message['Contest']['User']['username'], array(
            'controller' => 'users',
            'action' => 'view',
            $message['Contest']['User']['username']
        ), array(
			'class' => 'pinkc textb text-14 hor-smspace'
		)).'</span>';
        if (!empty($message['Contest']['WinnerUser']['id'])) {
            $FindReplace['##WINNER_USER##'] = $this->Html->getUserAvatarLink($message['Contest']['WinnerUser'], 'micro_thumb')  . $this->link($message['Contest']['WinnerUser']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $message['Contest']['WinnerUser']['username']
            ), array(
			    'class' => 'pinkc textb text-14 hor-smspace'
		    ));
        }
		$FindReplace['##ENTRY_NO##'] = '#' . $message['ContestUser']['entry_no'];
        if (!empty($message['ContestUser']['id'])) {
            if ($message['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn || empty($entry_flag) || empty($blind_flag)) {
                $FindReplace['##ENTRY_NO##'] = '#' . $message['ContestUser']['entry_no'];
            } else {
                $FindReplace['##ENTRY_NO##'] = $this->link('#' . $message['ContestUser']['entry_no'], array(
                    'controller' => 'contest_users',
                    'action' => 'view',
                    $message['Contest']['slug'],
                    'entry' => $message['ContestUser']['entry_no']
                ));
            }
			if(!empty($message['ContestUser']['User']['username'])){
            $FindReplace['##CONTEST_USER##'] = $this->Html->getUserAvatarLink($message['ContestUser']['User'], 'micro_thumb') . $this->link($message['ContestUser']['User']['username'], array(
                'controller' => 'users',
                'action' => 'view',
                $message['ContestUser']['User']['username']
            ), array(
			    'class' => 'pinkc textb text-14 hor-smspace'
		    ));
			}
        }
        if (isPluginEnabled('EntryRatings')) {
            if (!empty($message['ContestUserRating']['id'])) {
                $FindReplace['##RATING##'] = $this->get_star_rating(round($message['ContestUserRating']['rating'], 2));
                $FindReplace['##RATED_USER##'] = $this->Html->getUserAvatarLink($message['ContestUserRating']['User'], 'micro_thumb') . $this->link($message['ContestUserRating']['User']['username'], array(
                    'controller' => 'users',
                    'action' => 'view',
                    $message['ContestUserRating']['User']['username']
                ), array(
			        'class' => 'pinkc textb text-14 hor-smspace'
		        ));
            }
        }
        $activity_messages = strtr($activity_message, $FindReplace);
		$activity_message = '<div class="'.(!empty($this->request->params['action']) && ($this->request->params['action'] == 'activities_notification')?'span7':'span6').' clearfix grayc hor-space no-mar"><span class="pull-left">' . $activity_messages . '</span></div>';
        return $activity_message;
    }
	public function getActivitiesCount($user_id = null){
		App::import('Model', 'User');
        $this->User = new User();
		App::import('Model', 'Contests.Message');
        $this->Message = new Message();
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $user_id
            ) ,
            'recursive' => -1
        ));
		$conditions = array(
			'Message.is_sender' => 0,
			'Message.message_folder_id' => ConstMessageFolder::Inbox,
			'Message.is_activity' => 1,
			'Message.is_deleted' => 0,
			'Message.is_archived' => 0,
			'MessageContent.admin_suspend' => 0
		);
		$conditions['Message.id >'] = $user['User']['activity_message_id'];
		$conditions['OR']['Message.user_id'] = $user_id;
		$ContestIds = $this->Message->Contest->find('list', array(
			'conditions' => array(
				'Contest.user_id' => $user_id,
				'Contest.admin_suspend' => 0
			) ,
			'recursive' => -1,
			'fields' => array(
				'Contest.id'
			)
		));
		if(!empty($ContestIds)) {
			$conditions['OR']['Message.contest_id'] = $ContestIds;
		}
	    $activities_count = $this->Message->find('count', array(
            'conditions' => $conditions,
			'recursive' => 0
        ));
     return $activities_count;
    }
	function getBgImage() 
    {
        App::import('Model', 'Attachment');
        $this->Attachment = new Attachment();
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.class = ' => 'Setting'
            ) ,
            'fields' => array(
                'Attachment.id',
                'Attachment.dir',
                'Attachment.foreign_id',
                'Attachment.filename',
                'Attachment.width',
                'Attachment.height',
            ) ,
            'recursive' => -1
        ));
        return $attachment;
    }
	public function beforeLayout($layoutFile) 
    {
		if ($this instanceof HtmlHelper && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) {
            $url = Router::url(array(
                'controller' => 'high_performances',
                'action' => 'update_content',
                'ext' => 'css'
            ) , true);
            if (Configure::read('highperformance.cuids') && $this->request->params['controller'] == 'contest_users' && $this->request->params['action'] == 'view') {
				echo $this->Html->css($url . '?cuids=' . Configure::read('highperformance.cuids') . '&from=contest_user_view', null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.cids') && $this->request->params['controller'] == 'contests' && $this->request->params['action'] == 'view') {
				echo $this->Html->css($url . '?cids=' . Configure::read('highperformance.cids') . '&from=contest_view', null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.uids') && $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'view') {
				if(Configure::read('highperformance.cuids'))
					$cuids = implode(',', Configure::read('highperformance.cuids')); 
				else
					$cuids = ''; 
				echo $this->Html->css($url . '?uids=' . Configure::read('highperformance.uids') . '&cuids=' . $cuids , null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            } elseif (Configure::read('highperformance.cuids') && empty($this->request->params['prefix'])) {
				$cuids = implode(',', Configure::read('highperformance.cuids'));
				echo $this->Html->css($url . '?cuids=' . $cuids , null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
			} elseif (Configure::read('highperformance.uids')) {
				echo $this->Html->css($url . '?uids=' . Configure::read('highperformance.uids') , null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
			} elseif (!empty($_SESSION['Auth']['User']['id']) && $_SESSION['Auth']['User']['id'] == ConstUserIds::Admin && empty($this->request->params['prefix'])) {
                echo $this->Html->css($url . '?uids=' . $_SESSION['Auth']['User']['id'], null, array(
                    'inline' => false, 'block' => 'highperformance'
                ));
            }
            parent::beforeLayout($layoutFile);
        }
    }
	function getUserInvitedFriendsRegisteredCount($id) 
    {
        App::import('Model', 'Subscription');
        $this->Subscription = new Subscription();
        $count = $this->Subscription->find('count', array(
            'conditions' => array(
                'Subscription.invite_user_id' => $id,
                'Subscription.user_id !=' => '',
            ) ,
            'recursive' => -1
        ));
        return $count;
    }
}
?>