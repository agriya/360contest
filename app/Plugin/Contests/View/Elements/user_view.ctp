<div class="view-content-blocks">
	   <h3><?php echo __l('As').' '. Configure::read('contest.contest_holder_alt_name_singular_caps');?></h3>
	   <div class="entries-block clearfix">
	 	 <div class="entries-inner-block clearfix">
		   <span class="posted-block"><?php echo __l('Posted Contest');?></span>
		   <span><?php echo $this->Html->cInt($user_contest_count);?></span>
	  	 </div>
	</div>
</div>
<div class="view-content-blocks">
	<h3><?php echo __l('As').' '. Configure::read('contest.participant_alt_name_singular_caps');?></h3>
	<div class="entries-block clearfix">
	 	 <div class="entries-inner-block clearfix">
    		 <span class="posted-block"><?php echo __l('Entries Posted');?></span>
    		 <span><?php echo $this->Html->cInt($user_entry_count);?></span>
		 </div>
	</div>
    <div class="entries-block clearfix">
	 	 <div class="entries-inner-block clearfix">
    		 <span class="posted-block"><?php echo __l('Contest Won');?></span>
    		 <span><?php echo $this->Html->cInt($user_contest_won_count);?></span>
		 </div>
	</div>
</div>
<?php if (isPluginEnabled('SocialMarketing')) {?>
<div class="view-content-blocks">
	<h3><?php echo __l('Verifications'); ?></h3>
  <div class="entries-block clearfix">
    <div class="entries-inner-block clearfix">
		<span class="grid_1 social-small-icons"><i class="small-icon facebook"></i></span>
		<span class="posted-block"><?php echo __l('Facebook');?><br /><?php echo $user['User']['fb_friends_count'] . ' ' . __l('friends');?></span>
		<span class="grid_1">
		<?php 
		$icon = (!empty($user['User']['is_facebook_connected']))?'tick.png':'cross.png'; 
		echo $this->Html->image('icons/'.$icon);
		?>
		</span>
    </div>
  </div>
  <div class="entries-block clearfix">
    <div class="entries-inner-block clearfix">
		<span class="grid_1 social-small-icons"><i class="small-icon twitter"></i></span>
		<span class="posted-block"><?php echo __l('Twitter');?><br /><?php echo $user['User']['twitter_followers_count'] . ' ' . __l('followers');?></span>
		<span class="grid_1">
		<?php 
		$icon = (!empty($user['User']['is_twitter_connected']))?'tick.png':'cross.png'; 
		echo $this->Html->image('icons/'.$icon);
		?>
		</span>
    </div>
  </div>
  <div class="entries-block clearfix">
    <div class="entries-inner-block clearfix">
		<span class="grid_1 social-small-icons"><i class="small-icon linkedin"></i></span>
		<span class="posted-block"><?php echo __l('Linkedin');?><br /><?php echo $user['User']['linkedin_contacts_count'] . ' ' . __l('Connections');?></span>
		<span class="grid_1">
		<?php 
		$icon = (!empty($user['User']['is_linkedin_connected']))?'tick.png':'cross.png'; 
		echo $this->Html->image('icons/'.$icon);
		?>
		</span>
    </div>
  </div>
  <div class="entries-block clearfix">
    <div class="entries-inner-block clearfix">
		<span class="grid_1 social-small-icons"><i class="small-icon google"></i></span>
		<span class="posted-block"><?php echo __l('Google');?><br /><?php echo $user['User']['google_contacts_count'] . ' ' . __l('contacts');?></span>
		<span class="grid_1">
		<?php 
		$icon = (!empty($user['User']['is_google_connected']))?'tick.png':'cross.png'; 
		echo $this->Html->image('icons/'.$icon);
		?>
		</span>
    </div>
  </div>
  <div class="entries-block clearfix">
    <div class="entries-inner-block clearfix">
		<span class="grid_1 social-small-icons"><i class="small-icon yahoo"></i></span>
		<span class="posted-block"><?php echo __l('Yahoo!');?><br /><?php echo $user['User']['yahoo_contacts_count'] . ' ' . __l('contacts');?></span>
		<span class="grid_1">
		<?php 
		$icon = (!empty($user['User']['is_yahoo_connected']))?'tick.png':'cross.png'; 
		echo $this->Html->image('icons/'.$icon);
		?>
		</span>
    </div>
  </div>
</div>
<?php } ?>