<div class="clearfix">
<div class="clearfix">
<h2 class="ver-space ver-mspace span"><?php echo __l('Social');?></h2>
	  <div class="ver-space">
		<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
	  </div>
</div>
<div class="thumbnail sep">
  <?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id')); ?>
  <div class="social_row">
  	<div class="clearfix space">
    	<div class="span2"><div class="social-icon"><i class="icon-facebook-sign facebookc text-46"></i></div></div>
<?php if (!empty($user['User']['is_facebook_connected'])) { ?>
<?php
	$width = Configure::read('thumb_size.medium_thumb.width');
	$height = Configure::read('thumb_size.medium_thumb.height');
	$user_image = $this->Html->getFacebookAvatar($user['User']['facebook_user_id'], $height, $width);
?>
    	<div class="span14 well"><?php echo $user_image . ' ' . __l('You have already connected to Facebook.')?></div>
<?php if (empty($user['User']['is_facebook_register'])): ?>
    	<div class="span hor-space hor-mspace"> <?php echo $this->Html->link(__l('Disconnect from Facebook'), array('controller' => 'social_marketings', 'action' => 'myconnections', 'facebook'), array('title' => __l('Disconnect from Facebook'),'class' => 'grid_4 btn js-confirm js-no-pjax span4')); ?> </div>
<?php endif; ?>
<?php } else { ?>
    	<div class="span14 well"><?php echo __l('Increase your reputation by showing Facebook friends count.'); ?></div>
<?php
	$connect_url = Router::url(array(
		'controller' => 'social_marketings',
		'action' => 'import_friends',
		'type' =>'facebook',
		'import' => 'facebook',
		'from' => 'social'
	), true);
?>
    	<div class="span hor-space hor-mspace">
				<?php echo $this->Html->link(__l('Connect with Facebook'), $connect_url, array('title' => __l('Connect with Facebook'), 'class' => 'js-connect span4 btn {"url":"'.$connect_url.'"}')); ?>
      </div>
<?php } ?>
		</div>
  </div>
  <div class="social_row">
  	<div class="clearfix space">
    	<div class="span2"><div class="social-icon"><i class="icon-twitter-sign twitterc text-46"></i></div></div>
<?php if (!empty($user['User']['is_twitter_connected'])) { ?>
<?php
	$width = Configure::read('thumb_size.medium_thumb.width');
	$height = Configure::read('thumb_size.medium_thumb.height');
	$user_image = '';
	if (!empty($user['User']['twitter_avatar_url'])):
	$user_image = $this->Html->image($user['User']['twitter_avatar_url'], array(
		'title' => $this->Html->cText($user['User']['username'], false) ,
		'width' => $width,
		'height' => $height
	));
	endif;
?>
    	<div class="span14 well"><span class="space-left"><?php echo $user_image . ' ' . __l('You have already connected to Twitter.'); ?></span></div>
<?php if (empty($user['User']['is_twitter_register'])): ?>
    	<div class="span hor-space hor-mspace"><?php echo $this->Html->link(__l('Disconnect from Twitter'), array('controller' => 'social_marketings', 'action' => 'myconnections', 'twitter'), array('title' => __l('Disconnect from Twitter'),'class' => 'grid_4 btn js-confirm js-no-pjax span4')); ?></div>
<?php endif; ?>
<?php } else { ?>
    	<div class="span14 well"><?php echo __l('Increase your reputation by showing Twitter followers count.')?></div>
<?php
	$connect_url = Router::url(array(
		'controller' => 'social_marketings',
		'action' => 'import_friends',
		'type' =>'twitter',
		'import' => 'twitter',
		'from' => 'social'
	), true);
?>
    	<div class="span hor-space">
				<?php echo $this->Html->link(__l('Connect with Twitter'), $connect_url, array('title' => __l('Connect with Twitter'),'class' => 'js-connect span4 btn {"url":"'.$connect_url.'"}')); ?>
      </div>
    <?php } ?>
    </div>
  </div>
  <div class="social_row">
  	<div class="clearfix space">
    	<div class="span2"><div class="social-icon"><i class="icon-google-plus googlec text-46"></i></div></div>
<?php if (!empty($user['User']['is_google_connected'])) { ?>
    	<div class="span14 well"><?php echo __l('You have already connected to Gmail.')?></div>
<?php if (empty($user['User']['is_google_register'])): ?>
    	<div class="span hor-space hor-mspace"><?php echo $this->Html->link(__l('Disconnect from Gmail'), array('controller' => 'social_marketings', 'action' => 'myconnections', 'google'), array('title' => __l('Disconnect from Gmail'),'class' => 'grid_4 btn js-confirm js-no-pjax span4')); ?></div>
<?php endif; ?>
<?php } else { ?>
    	<div class="span14 well"><?php echo __l('Increase your reputation by showing Google contacts count.')?></div>
<?php
	$connect_url = Router::url(array(
		'controller' => 'social_marketings',
		'action' => 'import_friends',
		'type' =>'google',
		'import' => 'google',
		'from' => 'social'
	), true);
?>
    	<div class="span hor-space">
				<?php echo $this->Html->link(__l('Connect with Gmail'), $connect_url, array('title' => __l('Connect with Gmail'),'class' => 'js-connect span4 btn {"url":"'.$connect_url.'"}'));?>
      </div>
<?php } ?>
		</div>
  </div>
  <div class="social_row">
  	<div class="clearfix space">
    	<div class="span2"><div class="social-icon"><i class="icon-yahoo yahooc text-46"></i></div></div>
<?php if (!empty($user['User']['is_yahoo_connected'])) { ?>
    	<div class="span14 well"><?php echo __l('You have already connected to Yahoo!.')?></div>
<?php if (empty($user['User']['is_yahoo_register'])): ?>
    	<div class="span hor-space hor-mspace"> <?php echo $this->Html->link(__l('Disconnect from Yahoo!'), array('controller' => 'social_marketings', 'action' => 'myconnections', 'yahoo'), array('title' => __l('Disconnect from Yahoo'),'class' => 'grid_4 btn js-confirm js-no-pjax span4')); ?> </div>
<?php endif; ?>
<?php } else { ?>
<?php
	$connect_url = Router::url(array(
		'controller' => 'social_marketings',
		'action' => 'import_friends',
		'type' =>'yahoo',
		'import' => 'yahoo',
		'from' => 'social'
	), true);
?>
    	<div class="span14 well"><?php echo __l('Increase your reputation by showing Yahoo! contacts count.')?></div>
    	<div class="span hor-space">
				<?php echo $this->Html->link(__l('Connect with Yahoo!'), $connect_url, array('title' => __l('Connect with Yahoo'), 'class' => 'js-connect span4 btn {"url":"'.$connect_url.'"}'));?>
      </div>
<?php } ?>
		</div>
  </div>
  <div class="social_row">
  	<div class="clearfix space">
    	<div class="span2"><div class="social-icon"><i class="icon-linkedin-sign linkedc text-46"></i></div></div>
<?php if (!empty($user['User']['is_linkedin_connected'])) { ?>
<?php
	$width = Configure::read('thumb_size.medium_thumb.width');
	$height = Configure::read('thumb_size.medium_thumb.height');
	$user_image = '';
	if (!empty($user['User']['linkedin_avatar_url'])):
	$user_image = $this->Html->image($user['User']['linkedin_avatar_url'], array(
		'title' => $this->Html->cText($user['User']['username'], false) ,
		'width' => $width,
		'height' => $height
	));
	endif;
?>
    	<div class="span14 well"><span class="space-left"><?php echo $user_image . ' ' . __l('You have already connected to LinkedIn.')?></span></div>
<?php if (empty($user['User']['is_linkedin_register'])): ?>
    	<div class="span hor-space hor-mspace"> <?php echo $this->Html->link(__l('Disconnect from LinkedIn'), array('controller' => 'social_marketings', 'action' => 'myconnections', 'linkedin'), array('title' => __l('Disconnect from LinkedIn'),'class' => 'grid_4 btn js-confirm js-no-pjax span4')); ?> </div>
<?php endif; ?>
<?php } else { ?>
    	<div class="span14 well"><?php echo __l('Increase your reputation by showing LinkedIn connections count.')?></div>
<?php
	$connect_url = Router::url(array(
		'controller' => 'social_marketings',
		'action' => 'import_friends',
		'type' =>'linkedin',
		'import' => 'linkedin',
		'from' => 'social'
	), true);
?>
			<div class="span hor-space">
				<?php echo $this->Html->link(__l('Connect with LinkedIn'), $connect_url, array('title' => __l('Connect with LinkedIn') ,'class' => 'js-connect span4 btn {"url":"'.$connect_url.'"}'));?>
      </div>
<?php } ?>
		</div>
  </div>
</div>
</div>