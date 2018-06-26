<div class="users form">
	<div class="ver-space">
		<h2><?php echo __l('Register'); ?></h2>
	</div>
	<div class=" clearfix">
		<div class="clearfix span22 ver-mspace">
			<div class="clearfix openid-block ver-space sep-bot">
				<div class="offset7 mob-no-mar">
					<h3 class="pull-left mob-clr bot-space dc"><?php echo __l('Sign up using'); ?></h3>
					<ul class="unstyled hor-mspace  row span bot-space mob-clr">
					<?php if(Configure::read('facebook.is_enabled_facebook_connect')):
						$url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
						<li class="row pull-left">
						<?php echo $this->Html->link('<i class="icon-facebook-sign facebookc text-24"></i><span class="hide">Facebook</span>', '#', array('title' => __l('Sign up with Facebook'), 'escape' => false,'class' =>
						"js-connect {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif; ?>
					<?php if(Configure::read('twitter.is_enabled_twitter_connect')):
						$url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
						<li class="row pull-left">
						<?php echo $this->Html->link('<i class="icon-twitter-sign twitterc text-24"></i><span class="hide">Twitter</span>', '#', array('title' => __l('Sign up with Twitter'), 'escape' => false,'class' =>
						"js-connect {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif;?>
					<?php if(Configure::read('google.is_enabled_google_connect')):
						$url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
						<li class="row pull-left google-sign">
						<?php echo $this->Html->link('<i class="icon-google-sign googlec text-24 no-pad"></i><span class="hide">Google</span>', '#', array('title' => __l('Sign up with Google'), 'escape' => false,'class' =>
						"js-connect {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif;?>
					<?php if (Configure::read('googleplus.is_enabled_googleplus_connect')): ?>
						<li class="row no-mar pull-left">
						<?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
						<?php echo $this->Html->link('<i class="icon-google-plus-sign googleplusc text-24"></i><span class="hide">Google+</span>', '#', array('title' => 'Google+', 'escape' => false,'class' => "no-under js-connect js-no-pjax {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif; ?>
					<?php if(Configure::read('yahoo.is_enabled_yahoo_connect')):
						$url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
						
						<li class="row pull-left yahoo-icon">
						<?php echo $this->Html->link('<i class="icon-yahoo yahooc text-24"></i><span class="hide">Yahoo</span>', '#', array('title' => __l('Sign up with Yahoo'), 'escape' => false,'class' =>
						"js-connect {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif;?>
					<?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):
						$url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
						<li class="row pull-left">
						<?php echo $this->Html->link('<i class="icon-linkedin-sign linkedc text-24"></i><span class="hide">LinkedIn</span>', '#', array('title' => __l('Sign up with LinkedIn'), 'escape' => false,'class' =>
						"js-connect {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif;?>
					<?php if(Configure::read('openid.is_enabled_openid_connect')):
						$url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
						<li class="row stack pull-left">
						<?php echo $this->Html->link(__l('Sign up with  OpenID'), '#', array('title' => 'OpenID', 'escape' => false,'class' => "js-connect {'url':'$url', 'r':'manual'}")); ?>
						</li>
					<?php endif;?>
					</ul>
				</div>
			</div>
			
		</div>
		<h4 class="dc pr  bot-space	"><span class="space register-or-hor or-hor pa hidden-sm"><?php echo __l('Or');?></span></h4>
		<div class="clearfix span19">
			<div class="clearfix ver-space ">
			<?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'register', 'manual'), 'class' => 'form-horizontal offset5 mob-no-mar')); ?>
                <fieldset>
                <?php
                    if(!empty($this->request->data['User']['openid_url'])):
                        echo $this->Form->input('openid_url', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_url']));
                    endif;
                    echo $this->Form->input('username');
                    if (empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_facebook_register']) && empty($this->request->data['User']['is_twitter_register'])):
                        echo $this->Form->input('passwd', array('label' => __l('Password')));
                    endif;
                    echo $this->Form->input('email');
                    if (!empty($this->request->data['User']['facebook_user_id'])):
                        echo $this->Form->input('facebook_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['facebook_user_id']));
                        echo $this->Form->input('is_facebook_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_facebook_register']));
                        echo $this->Form->input('is_facebook_connected', array('type' => 'hidden', 'value' => 1));
                        echo $this->Form->input('facebook_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['facebook_access_token']));
                        echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 2));
                    endif;
                    if (!empty($this->request->data['User']['twitter_user_id'])):
                        echo $this->Form->input('twitter_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_user_id']));
                        echo $this->Form->input('is_twitter_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_twitter_register']));
                        echo $this->Form->input('is_twitter_connected', array('type' => 'hidden', 'value' => 1));
                        echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 3));
                        if (!empty($this->request->data['User']['photoURL'])):
                          echo $this->Form->input('twitter_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
                        endif;
                        if (!empty($this->request->data['User']['twitter_access_token'])):
                          echo $this->Form->input('twitter_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_token']));
                        endif;
                        if (!empty($this->request->data['User']['twitter_access_key'])):
                          echo $this->Form->input('twitter_access_key', array('type' => 'hidden', 'value' => $this->request->data['User']['twitter_access_key']));
                        endif;
                    endif;
                    if (!empty($this->request->data['User']['is_yahoo_register'])):
                        echo $this->Form->input('is_yahoo_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_yahoo_register']));
                        echo $this->Form->input('is_yahoo_connected', array('type' => 'hidden', 'value' => 1));
                         echo $this->Form->input('yahoo_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['yahoo_user_id']));
                        echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
                    endif;
                     if (!empty($this->request->data['User']['is_openid_register'])):
                        echo $this->Form->input('is_openid_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_openid_register']));
                        echo $this->Form->input('openid_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['openid_user_id']));
                        echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
                    endif;
                    if (!empty($this->request->data['User']['is_google_register'])):
                        echo $this->Form->input('is_google_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_google_register']));
                        echo $this->Form->input('is_google_connected', array('type' => 'hidden', 'value' => 1));
                        echo $this->Form->input('google_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['google_user_id']));
                        echo $this->Form->input('google_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['google_access_token']));
                        echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 1));
                    endif;
					if (!empty($this->request->data['User']['is_googleplus_register'])):
						echo $this->Form->input('is_googleplus_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_googleplus_register']));
						echo $this->Form->input('is_googleplus_connected', array('type' => 'hidden', 'value' => 1));
						echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 6));
						echo $this->Form->input('googleplus_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['googleplus_user_id']));
						echo $this->Form->input('googleplus_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['googleplus_access_token']));
						if (!empty($this->request->data['User']['photoURL'])):
						  echo $this->Form->input('googleplus_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
						endif;
					  endif;
                    if (!empty($this->request->data['User']['is_linkedin_register'])):
                        echo $this->Form->input('is_linkedin_register', array('type' => 'hidden', 'value' => $this->request->data['User']['is_linkedin_register']));
                        echo $this->Form->input('is_linkedin_connected', array('type' => 'hidden', 'value' => 1));
						echo $this->Form->input('user_avatar_source_id', array('type' => 'hidden', 'value' => 5));
                        echo $this->Form->input('linkedin_user_id', array('type' => 'hidden', 'value' => $this->request->data['User']['linkedin_user_id']));
                        echo $this->Form->input('linkedin_access_token', array('type' => 'hidden', 'value' => $this->request->data['User']['linkedin_access_token']));
						if (!empty($this->request->data['User']['photoURL'])):
						  echo $this->Form->input('linkedin_avatar_url', array('type' => 'hidden', 'value' => $this->request->data['User']['photoURL']));
						endif;
                    endif;
                    echo $this->Form->input('UserProfile.country_iso_code', array('type' => 'hidden'));
                    echo $this->Form->input('State.name', array('type' => 'hidden'));
                    echo $this->Form->input('City.name', array('type' => 'hidden'));
				?>
				<?php if (empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_facebook_register']) && empty($this->request->data['User']['is_twitter_register'])): ?>
                        <?php if(Configure::read('system.captcha_type') == "Solve Media"){?>
                            <div class="input captcha-block clearfix js-captcha-container">
                                <?php
                                include_once VENDORS . DS . 'solvemedialib.php';		//include the Solve Media library
                                echo solvemedia_get_html(Configure::read('captcha.challenge_key'));	//outputs the widget?>
                            </div>
                        <?php } else
                        {?>
						  <div class="clearfix bot-space">
							<div class="input js-captcha-container thumbnail span captcha-block">
							<div class="pull-left">
							  <?php echo $this->Html->image($this->Html->url(array('controller' => 'users', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?>
							</div>
							<div class="input-append pull-left">
							  <div class="dc text-20">
							  <?php echo $this->Html->link('<i class="icon-refresh text-16"></i> <span class="hide">' . __l('Reload CAPTCHA') . '</span>', '#', array('escape' => false, 'class' => 'js-captcha-reload js-no-pjax captcha-reload blackc no-under', 'title' => __l('Reload CAPTCHA')));?>
							  </div>
							  <div class="text-16 top-smspace">
							  <div class="play-link">
								<?php echo $this->Html->link(__l('Click to play'), Router::url('/', true) . "flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'comments', 'action'=>'captcha_play')) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play js-no-pjax')); ?>
							  </div>
							  </div>
							</div>
							</div>
						  </div>
                          <?php echo $this->Form->input('captcha', array('label' => __l('Security Code'))); ?>
                        <?php } ?>
						<?php  if(isPluginEnabled('SecurityQuestions')) {
							echo '<div class="ver-space">';
							echo $this->Form->input('security_question_id',array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
							echo '</div>';
							echo $this->Form->input('security_answer', array('label' => __l('Answer')));
						} ?>
						<div class="terms-error">
                        <?php echo $this->Form->input('is_agree_terms_conditions', array('label' => sprintf(__l('I have read, understood &amp; agree to the %s'), $this->Html->link('Terms & Policies', array('controller' => 'nodes', 'action' => 'view', 'type'=>'page', 'slug'=>'terms'), array('class' => 'js-no-pjax', 'target' => '_blank'))))); ?></div>
                  <?php endif; ?>
                </fieldset>
				<div class="submit-block clearfix">
					<?php echo $this->Form->submit(__l('Submit')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>