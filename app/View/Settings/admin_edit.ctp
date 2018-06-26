<div class="hor-space">
    <div class="js-response js-clone space thumbnail">
        <?php if (!empty($setting_categories['SettingCategory']['description'])):?>
            <div class="alert alert-info">
                <?php
                    if(stristr($setting_categories['SettingCategory']['description'], '##PAYMENT_SETTINGS_URL##') === FALSE) {
                        echo $setting_categories['SettingCategory']['description'];
                    } else {
                        echo $category_description = str_replace('##PAYMENT_SETTINGS_URL##',Router::url('/', true) . '/admin/payment_gateways',$setting_categories['SettingCategory']['description']);
                    }
                ?>
            </div>
        <?php endif;?>
        <?php
            $form_class = 'form-horizontal setting-add-form add-live-form';
            if (!empty($this->request->params['pass']['0']) && $this->request->params['pass']['0'] == 8) {
                $form_class = 'form-horizontal setting-add-form add-live-form  form-large-fields';
            }
            if (!empty($settings)):
                echo $this->Form->create('Setting', array('action' => 'edit', 'class' => $form_class.' space','enctype' => 'multipart/form-data'));
                echo $this->Form->input('setting_category_id', array('label' => __l('Setting Category'),'type' => 'hidden'));
                if (!empty($plugin_name)) {
                echo $this->Form->input('plugin_name', array('label' => __l('Plugin Name'),'type' => 'hidden', 'value'=>$plugin_name));
                }
                // hack to delete the thumb folder in img directory
                $inputDisplay = 0;
                $is_changed = $prev_cat_id = 0;
                $i = 0;
                foreach ($settings as $setting):
                    $categorySettingPluginName = '';
                    if (!empty ($setting['SettingCategory']['plugin_name'])) {
                    $categorySettingPluginName = $setting['SettingCategory']['plugin_name'];
                    }
                    $settingPluginName = '';
                    if (!empty ($setting['Setting']['plugin_name'])) {
                    $settingPluginName = $setting['Setting']['plugin_name'];
                    }
                    if ($setting['Setting']['id'] == 582) {
                        $find_Replace = array(
                            '##TEST_CONNECTION##' => $this->Html->link(__l('Test Connection'), array('controller' => 'high_performances', 'action' => 'check_s3_connection', '?f=' . $this->request->url))
                        );
                        $setting['Setting']['description'] = strtr($setting['Setting']['description'], $find_Replace);
                    }
                    if ($setting['Setting']['id'] == 543 and !empty($attachment)) {
                ?>
                    <div class="row">
                        <div class="hor-mspace pull-left offset2"><?php echo  $this->Html->showImage('Setting', $attachment['Attachment'], array('dimension' => 'medium_thumb')); ?></div>
                        <div class="pull-left">
                            <div class="input checkbox no-mar top-space">
                                <?php echo $this->Form->input($setting['Setting']['id'].'.is_delete_attachemnt', array('label' => __l('Delete?'),'type' => 'checkbox','div'=>'false'));?>
                            </div>
                        </div>
                    </div>
                <?php
                    }
					$findReplace = array(
						'##ANALYTICS_IMAGE##' => Router::url('/', true).'img/google_analytics_example.gif',
					);
					$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
                    if($setting['Setting']['name'] == 'site.language'):
                        $empty_language = 0;
                        $get_language_options = $this->Html->getLanguage();
                        if(!empty($get_language_options)):
                            $options['options'] = $get_language_options;
                        else:
                            $empty_language = 1;
                        endif;
                    endif;
                    $field_name = explode('.', $setting['Setting']['name']);
                    if(isset($field_name[2]) && ($field_name[2] == 'is_not_allow_resize_beyond_original_size' || $field_name[2] == 'is_handle_aspect')){
                        continue;
                    }
                    $options['type'] = $setting['Setting']['type'];
                    $options['value'] = $setting['Setting']['value'];
                    $tmp_setting_name = Inflector::slug($setting['Setting']['name']);
                    $options['div'] = array('id' => "setting-{$tmp_setting_name}");
                    if($options['type'] == 'checkbox' && $options['value']):
                        $options['checked'] = 'checked';
                    endif;
                    if($options['type'] == 'select'):
                        $selectOptions = explode(',', $setting['Setting']['options']);
                        $setting['Setting']['options'] = array();
                        if(!empty($selectOptions)):
                            foreach($selectOptions as $key => $value):
                                if(!empty($value)):
                                    $setting['Setting']['options'][trim($value)] = trim($value);
                                endif;
                            endforeach;
                        endif;
                        $options['options'] = $setting['Setting']['options'];
                    elseif ($options['type'] == 'radio'):
                            $selectOptions = explode(',', $setting['Setting']['options']);
                            $setting['Setting']['options'] = array();
                            $options['legend'] = false;
							$options['div'] = array('class' => 'input radio no-mar bot-space');
                            if(!empty($selectOptions)):
                                foreach($selectOptions as $key => $value):
                                    if(!empty($value)):
                                        $setting['Setting']['options'][trim($value)] = trim($value);
                                    endif;
                                endforeach;
                            endif;
                            $options['options'] = $setting['Setting']['options'];
                    endif;
                    $tmp_prev_cat_id = $prev_cat_id;
                        if (empty($prev_cat_id)) {
                            $prev_cat_id = $setting['SettingCategory']['id'];
                            $is_changed = 1;
                        } else {
                            $is_changed = 0;
                            if ($setting_categories['SettingCategory']['id'] != 1146 && $setting['SettingCategory']['id'] != $prev_cat_id ) {
                                $is_changed = 1;
                                $prev_cat_id  = $setting['SettingCategory']['id'];
                            }
                        }
                        if ($is_changed) {
                            $isGroup = false;
                        }
                        if (!empty($is_changed)) {
                            if ($setting['SettingCategory']['id'] != $tmp_prev_cat_id && in_array($tmp_prev_cat_id, array(88, 86, 87, 85))) {
                    ?>
                    <?php if ($tmp_prev_cat_id != 86) { ?>
                    </div>
                    <div class="span10 well">
                    <?php } ?>
                        <?php if ($tmp_prev_cat_id == 86) { ?>
                            <div class="clearfix">
                                <div class="span13">&nbsp;</div>
                                <div class="span10 well">
                                    <h4><?php echo __l('Configuration steps:');?></h4> <br>
                                    <?php echo __l('1. Sign in using your google account in <a target="blank" href="https://developers.google.com/speed/pagespeed/service">https://developers.google.com/speed/pagespeed/service</a>.'); ?><br/>
                                    <?php echo __l('2. Click sign up now button and answer simple questions. Google will enable PageSpeed service within 2 hours.'); ?><br/>
                                    <?php echo __l('3. You have to configure this service in this link <a target="blank" href="https://code.google.com/apis/console">https://code.google.com/apis/console</a>, please follow the steps mentioned in this link <a target="blank" href="https://developers.google.com/speed/pagespeed/service/setup">https://developers.google.com/speed/pagespeed/service/setup</a>'); ?>
                                </div>
                            </div>
                        <?php } elseif ($tmp_prev_cat_id == 85) { ?>
                            <h4><?php echo __l('Configuration steps:'); ?></h4><br>
                            <?php echo __l('1. Create a CloudFlare account, configure the domain and change DNS.'); ?><br>
                            <?php echo __l('2. To create token please refer '); ?> <a target="blank" href="http://blog.cloudflare.com/2-factor-authentication-now-available">http://blog.cloudflare.com/2-factor-authentication-now-available</a><br>
                            <?php echo __l('3. Create three page rules like /, /contest/*, /user/* in this link'); ?> <a target="blank" href="https://www.cloudflare.com/page-rules?z=<?php echo $_SERVER["SERVER_NAME"]; ?>">https://www.cloudflare.com/page-rules?z=<?php echo $_SERVER["SERVER_NAME"]; ?></a><?php echo __l('. Note: Please select \'Cache Everything\' option for \'Custom Caching\' setting.'); ?><br>
                            <?php echo __l('4. Update your CloudFlare Email and Token and enable CloudFlare option here.'); ?><br>
                            <?php echo __l('5. Minimum cache timing for free users will be 30 minutes. Only enterprise users can reduce upto 30 seconds.'); ?>
                        <?php } elseif ($tmp_prev_cat_id == 88) { ?>
                            <h4><?php echo __l('Configuration steps:');?></h4> <br>
                            <?php echo __l('You can configure SMTP server by any one of the followings Amazon SES, Sendgrid, Mandrill, Gmail and your own host SMTP settings'); ?><br>
                            <?php echo __l('1. Amazon SES: To get your security credentials, login with amazon and go to <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a> . To create your smtp username password go to <a target="blank" href="https://console.aws.amazon.com/ses/home#smtp-settings">https://console.aws.amazon.com/ses/home#smtp-settings</a>'); ?><br>
                            <?php echo __l('2. Sendgrid: To get your security credentials, refer <a target="blank" href="http://sendgrid.com/docs/Integrate/index.html">http://sendgrid.com/docs/Integrate/index.html</a>'); ?><br>
                            <?php echo __l('3. Mandrill:  To get your security credentials, login with Mandrill and go to <a target="blank" href="https://mandrillapp.com/settings">https://mandrillapp.com/settings</a>'); ?><br>
                            <?php echo __l('4. Gmail: To use gmail please refer <a target="blank" href="http://gmailsmtpsettings.com/gmail-smtp-settings">http://gmailsmtpsettings.com/gmail-smtp-settings</a>'); ?>
                        <?php } elseif ($tmp_prev_cat_id == 87) { ?>
                            <h4><?php echo __l('Configuration steps:');?></h4> <br>
                            <?php echo __l('1. Amazon CloudFront: To setup Amazon CloudFront CDN please follow the step mentioned in this <a target="blank" href="http://aws.amazon.com/console/#cf">http://aws.amazon.com/console/#cf</a> and watch this screencast <a href="http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html" target="blank">http://d36cz9buwru1tt.cloudfront.net/videos/console/cloudfront_console_4.html</a>'); ?><br>
                            <?php echo __l('2. CloudFlare: To setup CloudFlare please follow the step mentioned in this link <a href="https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-" target="blank">https://support.cloudflare.com/entries/22054357-How-do-I-do-CNAME-setup-</a>'); ?><br>
                        <?php } ?>
                    </div>
                    <?php
                            }
                        }
                        if (!empty($i) && !empty($is_changed)):
                ?>
			</fieldset>
			<?php
                endif;
                if(!empty($is_changed)):
					if($setting_categories['SettingCategory']['id'] != 12) :
             ?>
             <fieldset>
                <?php if ($setting['Setting']['id'] == 561) { ?>
                    <legend><h3><?php echo __l('Instant Scaling'); ?></h3></legend>
                        <div class="alert alert-info"><?php echo __l('By enabling these easy options, site can achieve instant scaling.');;?></div>
                    <?php } ?>
                    <?php if (in_array( $setting['SettingCategory']['id'], array(85, 86, 87, 88))) : ?>
                        <legend class="offset1">
                    <?php else : ?>
                        <legend>
                    <?php endif;?>
                        <h3 id="<?php echo str_replace(' ','',$setting['SettingCategory']['name']); ?>">
                            <?php
                            if (empty($plugin_name) && !empty($categorySettingPluginName) && in_array($categorySettingPluginName, array_keys($plugins)) ) {
                                $isGroup = true;
                                if (!empty($plugins[$categorySettingPluginName]['icon'])):
                                     if (!in_array($plugins[$categorySettingPluginName]['icon'], $image_plugin_icons)):
                                        echo $this->Html->image('plugin-icons/small/' . $plugins[$categorySettingPluginName]['icon'] . '.png', array('title' => $categorySettingPluginName, 'class' => 'js-tooltip', 'width'=>16, 'height'=>16));
                                     else:
                                        echo '<i class="icon-'.$plugins[$categorySettingPluginName]['icon'].' text-20 js-tooltip" title="'.$categorySettingPluginName.'"></i>';
                                    endif;
                                endif;
                            } ?>
                            <?php echo $setting['SettingCategory']['name']; ?>
                      </h3>
                      </legend>
                      <?php if($setting['SettingCategory']['name'] == 'Commission'): ?>
                        <div class="pull-right">
                            <?php echo $this->Html->link('<i class="icon-cog text-16"></i> <span>'.__l('Commission Settings').'</span>', array('controller' =>'affiliate_types', 'action' => 'edit'), array('title' => __l('Here you can update and modify affiliate types'),'escape'=>false, 'class' => 'blackc')); ?>
                        </div><br/>
                      <?php endif; ?>
                      <?php if (!empty($setting['SettingCategory']['description']) && $setting_categories['SettingCategory']['id'] != 16):?>
                        <?php if (in_array( $setting['SettingCategory']['id'], array(85, 86, 87, 88))) : ?>
                            <div class="alert alert-info offset1">
                        <?php else : ?>
                            <div class="alert alert-info">
                        <?php endif;?>
                            <?php
                                $findReplace = array(
                                    '##TRANSLATIONADD##' => $this->Html->link(Router::url('/', true) . 'admin/translations/add', Router::url('/', true) . 'admin/translations/add', array('title' => __l('Translations add'))),
                                    '##APPLICATION_KEY##' => $this->Html->link($appliation_key_link . '#SolveMedia',$appliation_key_link . '#SolveMedia'),
                                    '##CATPCHA_CONF##' => $this->Html->link($captcha_conf_link . '#CAPTCHA',$captcha_conf_link . '#CAPTCHA'),
                                    '##DEMO_URL##' => $this->Html->link('http://dev1products.dev.agriya.com/doku.php?id=360contest-install#how_to','http://dev1products.dev.agriya.com/doku.php?id=360contest-install#how_to'),
                                    '##PAYPAL_INSTRUCTION##' => $this->Html->link(__l('instruction to accept the specified currency'), Router::url('/', true) . 'img/paypal-profile-currencies.png', array('target' => '_blank')),
                                );
                                $setting['SettingCategory']['description'] = strtr($setting['SettingCategory']['description'], $findReplace);
                                echo $setting['SettingCategory']['description'];
                            ?>
                            </div>
                        <?php
                       endif;
                    endif;
                 endif;
                    if (!empty($is_changed)) {
                        if (in_array( $setting['SettingCategory']['id'], array(92, 86, 87, 25, 136, 85, 88))) {
                            if (in_array( $setting['SettingCategory']['id'], array(88, 87, 85))) {
                                echo '<div class="clearfix offset1 row-fluid"><div class="span13">';
                            } elseif($setting['SettingCategory']['id'] == 86) {
                                echo '<div class="clearfix offset1 row-fluid">';
                            } else {
                                echo '<div class="offset1 clearfix row-fluid"><div class="span13">';
                            }
                        }
                    }
				?>
				<?php if (in_array($setting['Setting']['id'], array(172, 170, 175, 174, 168, 177, 557, 179, 260, 263))): ?>

                        <h3>
                           <?php echo (in_array($setting['Setting']['id'], array(170, 168))) ? __l('Application Info') : ''; ?>
                           <?php echo (in_array($setting['Setting']['id'], array(175, 177, 557))) ? __l('Credentials') : ''; ?>
                           <?php echo (in_array($setting['Setting']['id'], array(174, 172))) ? __l('Other Info') : ''; ?>
                        </h3>
						<?php if(in_array( $setting['Setting']['id'], array(175, 177, 557))):?>
                           <div class="alert alert-info">
                                <?php
                                    if($setting['Setting']['id'] == 175) :
                                        echo __l('Here you can update Facebook credentials . Click \'Update Facebook Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
                                    elseif($setting['Setting']['id'] == 177) :
                                        echo __l('Here you can update Twitter credentials like Access key and Accss Token. Click \'Update Twitter Credentials\' link below and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.');
									elseif($setting['Setting']['id'] == 557) :
										echo __l('Here you can update Google Analytics credentials . Click  \'Update Google Analytics Credentials\' link below and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.');
                                    endif;
                                ?>
                            </div>
                        <?php endif;?>
						<?php if($setting['Setting']['id'] == 175) : ?>
							<div class="clearfix">
    							<div class="">
    						      	<div class="credentials-right">
            							<?php	echo $this->Html->link(__l('<span><i class="icon-facebook-sign facebookc space text-16"></i>Update Facebook Credentials</span>'), $fb_login_url, array('escape'=>false,'class' => 'js-connect facebook-link btn mspace', 'title' => __l('Here you can update Facebook credentials . Click this link and Follow the steps. Please make sure that you have updated the API Key and Secret before you click this link.')));
                                        ?>
                                    </div>
                                </div>
                            <div class="credentials-right-block">
                            <?php
                            elseif($setting['Setting']['id'] == 177) :
                            ?>
                            <div class="clearfix credentials-info-block">
                            <div class="credentials-left">
						      	<div class="credentials-right">
                                    <?php
                                    	echo $this->Html->link(__l('<span><i class="icon-twitter-sign twitterc space text-16"></i>Update Twitter Credentials</span>'), $tw_login_url, array('escape'=>false,'class' => 'js-connect twitter-link btn mspace', 'title' => __l('Here you can update Twitter credentials like Access key and Accss Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and  Consumer secret before you click this link.')));
                                    ?>
                                </div>
                             </div>
                             <div class="credentials-right-block">
							 <?php
                            elseif($setting['Setting']['id'] == 557) :
                            ?>
                            <div class="clearfix credentials-info-block">
                            <div class="credentials-left">
						      	<div class="credentials-right space">
                                    <?php echo $this->Html->link(__l('<span><i class="icon-google-sign googlec space text-16"></i>Update Google Analytics Credentials</span>'), array('controller' => 'settings', 'action' => 'update_credentials', 'type' => 'google'), array('class' => 'btn tp-credential js-tooltip', 'escape' => false, 'title' => __l('Here you can update Google Analytics credentials like Access Token. Click this link and Follow the steps. Please make sure that you have updated the Consumer Key and Consumer secret before you click this link.'))); ?>
                                </div>
                             </div>
                             <div class="credentials-right-block">
                            <?php
                        	endif;
						?>
<?php 				endif; ?>
					<?php if ($setting['Setting']['id'] == 584) { ?>
							<div class="clearfix bot-space">
								<?php echo $this->Html->link(__l('<span>Copy static contents to S3</span>'), array('controller' => 'high_performances', 'action' => 'copy_static_contents', '?f=' . $this->request->url), array('class' => 'js-connect js-confirm js-tooltip js-no-pjax btn', 'escape' => false, 'title' => __l('Clicking this button will copy static contents such as CSS, JavaScript, images files in <code>webroot</code> folder of this server to Amazon S3 and will enable them to be delivered from there.'))); ?>
							</div>
						<?php } ?>
				<?php
					if ($setting['Setting']['name'] == 'site.is_ssl_enabled' && !($ssl_enable)) {
						$options['disabled'] = 'disabled';
					}
				?>
				<?php
				if ($setting['Setting']['name'] == 'cdn.images' || $setting['Setting']['name'] == 'cdn.js' || $setting['Setting']['name'] == 'cdn.css'){
					$options['class'] = 'js-remove-error';
				}
					if ($setting['Setting']['name'] == 'twitter.site_user_access_key' || $setting['Setting']['name'] == 'twitter.site_user_access_token' || $setting['Setting']['name'] == 'facebook.fb_access_token' || $setting['Setting']['name'] == 'google_analytics.access_token'):
						$options['readonly'] = true;
						$options['class'] = 'disabled';
					endif;
					if ($setting['Setting']['name'] == 'site.language'):
						$options['options'] = $this->Html->getLanguage();
					endif;
					$options['label'] = $setting['Setting']['label'];
					if ($setting['SettingCategory']['id'] == 47 && $setting['Setting']['id'] != 161 && $inputDisplay == 0):
						$options['class'] = 'image-settings';
						echo '<div class="outer-image-settings clearfix">';
					elseif ($setting['SettingCategory']['id'] == 47 && $setting['Setting']['id'] != 161):
						$options['class'] = 'image-settings image-settings-height';
					endif;
					if (in_array($setting['Setting']['name'], array('affiliate.referral_cookie_expire_time'))):
						$options['after'] = __l('hrs') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
					endif;
					if (in_array($setting['Setting']['name'], array('contest.days_after_amount_paid', 'contest.judging_to_winner_selected_days', 'contest.contest_payment_pending_days_limit', 'contest.change_completed_to_completed_days', 'contest.winner_selected_to_completed_days'))):
						$options['after'] = __l('days') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
					endif;
					if (in_array($setting['Setting']['name'], array('contestuser.file.allowedSize', 'contestuser.video.allowedSize'))){
						$options['after'] = __l('MB') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
					}
					if (in_array($setting['Setting']['name'], array('contest.winner_commission_amount'))):
					if(!empty($setting['Setting']['description'])):
						$options['after'] = __l('%') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
						endif;
					endif;
					if (in_array( $setting['Setting']['name'], array('wallet.min_wallet_amount', 'wallet.max_wallet_amount', 'user.minimum_withdraw_amount', 'user.maximum_withdraw_amount', 'affiliate.payment_threshold_for_threshold_limit_reach','contest.contest_type_minimum_prize','user.signup_fee','contest.blind_fee','contest.private_fee','contest.featured_fee', 'contest.highlight_fee'))):
					if(!empty($setting['Setting']['description'])):
						$options['after'] = Configure::read('site.currency') . '<span class="info">' . $setting['Setting']['description'] . '</span>';
						endif;
					endif;
					$findReplace = array(
						'##SITE_NAME##' => Configure::read('site.name'),
						'##USER_LOGIN##' => $this->Html->link(Router::url(array('controller' => 'user_logins', 'action' => 'index', 'admin' => true), true), Router::url(array('controller' => 'user_logins', 'action' => 'index', 'admin' => true), true), array('title' => __l('User Logins'))),
						'##SITE_NAME##' => Configure::read('site.name'),
						'##PAYPAL_INSTRUCTION##' => $this->Html->link(__l('instruction to accept the specified currency'), Router::url('/', true) . 'img/paypal-profile-currencies.png', array('target' => '_blank')),
					);
					$setting['Setting']['description'] = strtr($setting['Setting']['description'], $findReplace);
					if ($setting_categories['SettingCategory']['id'] != 69){
					if (!empty($setting['Setting']['description']) && empty($options['after'])):
						$options['help'] = "{$setting['Setting']['description']}";
					endif;
					}
					//default account
					if (!empty($is_module) && $is_module) {
						if (!in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Affiliate))) {
							$options['class'] = 'js-disabled-inputs';
						} else {
							$options['class'] = 'js-disabled-inputs-active';
						}
						if (!$active_module && !in_array($setting['Setting']['id'], array(ConstModuleEnableFields::Affiliate))) {
							$options['disabled'] = 'disabled';
						}
					}
					?>
          <?php
						if (empty($isGroup) && empty($plugin_name) && !empty($settingPluginName) && in_array($settingPluginName, array_keys($plugins)) && $setting_categories['SettingCategory']['id'] != 12 ) {
							if (!empty($plugins[$settingPluginName]['icon'])):
								 echo '<div class="grid_left">';
								if (!in_array($plugins[$settingPluginName]['icon'], $image_plugin_icons)):
									echo $this->Html->image('plugin-icons/small/' . $plugins[$settingPluginName]['icon'] . '.png', array('title' => $settingPluginName, 'class' => 'js-tooltip', 'width'=>16, 'height'=>16));
								else:
									echo '<i class="icon-'.$plugins[$settingPluginName]['icon'].' text-16 js-tooltip" title="'.$settingPluginName.'"></i>';
								endif;
								 echo '</div>';
							endif;
						}
					?>
					<?php if ($options['type'] == 'radio'): ?>
						<fieldset class="fields-block revnue-block round-5 settings-radio">

					<?php endif; ?>
					<div class="show"> 
						<?php 
						if (in_array( $setting['Setting']['id'], array(242, 243, 589, 590))){
							$options['legend'] = false;
						?>		
								<label> <?php echo $setting['Setting']['label']; ?> </label>
						<?php 		
								}
						?>
						<?php if ($setting['SettingCategory']['id'] != 86) { ?>
                    <?php echo $this->Form->input("Setting.{$setting['Setting']['id']}.name", $options); ?>
					<?php }?>
				  </div>
					<?php if ($options['type'] == 'radio'): ?>
						</fieldset>
					<?php endif; ?>
					<?php if($setting['Setting']['id'] == 92 and !empty($watermark_image)):?>
                     <div class="watermark-image offset3">
                        <?php echo $this->Html->showImage('WaterMark', $watermark_image['WaterMark'], array('dimension' => 'big_thumb', 'type' => 'png', 'alt' => sprintf(__l('[Image: %s]'), __l('Watermark image'), false), 'title' => __l('Watermark image'), 'class' => 'offset1 bot-space'));?>
                      </div>
                    <?php
                     endif;
					if ($setting['SettingCategory']['id'] == 47 && $setting['Setting']['id'] != 161 && $inputDisplay == 2):
						echo '</div>';
					endif;

					$inputDisplay = ($inputDisplay == 2) ? 0 : $inputDisplay;
					unset($options);
					if (in_array($setting['Setting']['id'], array(176, 178))) {
					?>
                        </div>
                        </div>
					<?php
					}
                    $i++;
		endforeach;
        if ($setting['SettingCategory']['id'] == 92) {
		?>
            </div>
			<div class="span10 well">
                <h4><?php echo __l('Configuration steps:'); ?></h4><br>
                <?php echo __l('1. To get your security credentials, login with amazon and go to <a target="blank" href="https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials">https://portal.aws.amazon.com/gp/aws/securityCredentials#access_credentials</a><br>2. To create bucket name go to <a target="blank" href="https://console.aws.amazon.com/s3/home">https://console.aws.amazon.com/s3/home</a> and click s3 link.'); ?>
            </div>
		<?php
			}
			if ($setting['SettingCategory']['id'] == 25) {
		?>
			</div>
			<div class="span10 well">
				<h4><?php echo __l('Configuration steps:');?></h4> <br>
				<?php echo __l('This is the site tracker script used for tracking and analyzing the data on how the people are getting into your website. e.g., <a target="blank" href="http://www.google.com/analytics">Google Analytics</a>, <a target="blank" href="https://kissmetrics.com">KISSmetrics</a>, <a target="blank" href="https://mixpanel.com">Mixpanel</a>, <a target="blank" href="https://quantcast.com">Quantcast</a>'); ?>
			</div>
		<?php
			}
		?>
        </fieldset>
		<?php
		if(!empty($beyondOriginals)){
            echo $this->Form->input('not_allow_beyond_original', array('label' => __l('Not Allow Beyond Original'),'type' => 'select', 'multiple' => 'multiple', 'options' => $beyondOriginals));
        }
        if(!empty($aspects)){
            echo $this->Form->input('allow_handle_aspect', array('label' => __l('Allow Handle Aspect'),'type' => 'select', 'multiple' => 'multiple', 'options' => $aspects));
        } ?>
	<?php if ($setting_categories['SettingCategory']['id'] == 9): ?>
		<fieldset class="form-block">
			<legend><h3 id="OtherFee"><?php echo __l('Other Fees'); ?></h3></legend>
			<div class="alert alert-info"><?php echo sprintf(__l('Refer "%s" page for contest type based fee settings.'), $this->Html->link(__l('Contest Form and Pricing for Types'), array('controller' => 'contest_types', 'action' => 'index'), array('title' => __l('Contest Form and Pricing for Types')))); ?></div>
		</fieldset>
	<?php endif; ?>
    <div class="clearfix">
    <?php	echo $this->Form->submit('Update'); ?>
    </div>
        <?php	echo $this->Form->end(); ?>
    <?php
	else:
?>
		<div class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('settings')); ?></div>
<?php
	endif;
?>

</div>
</div>