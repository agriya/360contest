<div class="ver-space">
<div class="dropdown pull-right pr z-top ver-space">
	<a href="#" class="btn dropdown-toggle js-no-pjax js-tooltip tooltiper no-under" data-toggle="dropdown" title = "Actions"><i class="icon-cog text-16"></i><span class="hide"><?php echo sprintf(__l('%s Owner Control Panel'), Configure::read('project.alt_name_for_project_singular_caps')); ?></span> <span class="caret"></span></a>
	<ul class="unstyled dropdown-menu arrow arrow-right dl clearfix">
			<?php if (!$this->Auth->user('is_openid_register') && !$this->Auth->user('is_yahoo_register') && !$this->Auth->user('is_google_register') && !$this->Auth->user('is_facebook_register') && !$this->Auth->user('is_twitter_register')): ?>
		  <li><?php echo $this->Html->link('<i class="icon-lock"></i>'.__l('Change Password'), array('controller' => 'users', 'action' => 'change_password'), array('title' => __l('Change Password'),'escape'=>false));?></li>
			<?php endif; ?>
			<?php if (isPluginEnabled('SocialMarketing')): ?>
		  <li><?php echo $this->Html->link('<i class="icon-share"></i>'.__l('Social'), array('controller' => 'social_marketings', 'action' => 'myconnections'), array('title' => __l('Social'),'escape'=>false));?></li>
		  <?php endif; ?>
		  <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Email settings'), array('controller' => 'user_notifications', 'action' => 'edit'), array('title' => __l('Email settings'),'escape'=>false));?></li>
		  	<?php if (isPluginEnabled('Wallet')):?>
		  <li><?php echo $this->Html->link('<i class="icon-save"></i>'.__l('Add Amount to Wallet'), array('controller' => 'wallets', 'action' => 'add_to_wallet'), array('title' => __l('Add Amount to Wallet'),'escape'=>false));?></li>
			<?php endif;?>
			<?php if (isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')):?>
		  <li><?php echo $this->Html->link('<i class="icon-briefcase"></i>'.__l('Cash Withdrawal'), array('controller' => 'user_cash_withdrawals', 'action' => 'index'), array('title' => __l('Cash Withdrawal'),'escape'=>false));?></li>
		  <li><?php echo $this->Html->link('<i class="icon-credit-card"></i>'.__l('Money Transfer Accounts'), array('controller' => 'money_transfer_accounts', 'action' => 'index'), array('title' => __l('Money Transfer Accounts'),'escape'=>false));?></li>
			<?php endif;?>
	</ul>
</div>
</div>