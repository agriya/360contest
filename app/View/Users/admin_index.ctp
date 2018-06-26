<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="js-response">
<div class="top-pattern sep-bot">
  <div class="container-fluid space">
	<ul class="row no-mar mob-c unstyled top-mspace">
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Admin) ? 'pinkc' : 'blackc';; ?>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Admin) ? 'pinkc' : 'grayc'; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-user no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Admin') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($admin, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Admin), array('title' => __l('Admin'), 'escape' => false)); ?></li>

		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-eye-open no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Active') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($active, false).'</span>', array('controller' => 'users', 'action' => 'index', 'filter_id' => ConstMoreAction::Active), array('title' => __l('Active'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-eye-close no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Inactive') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($inactive, false).'</span>', array('controller' => 'users', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive), array('title' => __l('Inactive'),'escape' => false)); ?> </li>
		<?php if (isPluginEnabled('UserFlags')) { ?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Flagged) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Flagged) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('user-flag.png', array('class' => 'img', 'alt' => __l('User Flagged'))).'</span> <span class="show  '.$class.' ">' . __l('User Flagged') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($flagged_users, false).'</span>', array('controller' => 'users', 'action' => 'index', 'filter_id' => ConstMoreAction::Flagged), array('title' => __l('User Flagged'),'escape' => false)); ?> </li>
		<?php } ?>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::OpenID) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::OpenID) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar">'.$this->Html->image('openid.png', array('class' => 'img', 'alt' => __l('OpenID'))).'</span> <span class="show  '.$class.' ">' . __l('OpenID') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($openid, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::OpenID), array('title' => __l('OpenID'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Facebook) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Facebook) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-facebook no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Facebook') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($facebook, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Facebook), array('title' => __l('Facebook'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Twitter)? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Twitter)? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-twitter no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Twitter') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($twitter, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Twitter), array('title' => __l('Twitter'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Gmail) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Gmail) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-google no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Gmail') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($gmail, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Gmail), array('title' => __l('Gmail'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::GooglePlus) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::GooglePlus) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-google-plus no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Google+') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($googleplus, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::GooglePlus), array('title' => __l('Google+'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Yahoo) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Yahoo) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label show label-important space dc text-24 textb no-mar"><span style="font-size: 26px;" class="hor-smspace"><em>Y!</em> </span></span> <span class="show  '.$class.' ">' . __l('Yahoo') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($yahoo, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Yahoo), array('title' => __l('Yahoo'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::LinkedIn) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::LinkedIn) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-linkedin no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('LinkedIn') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($linkedin, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::LinkedIn), array('title' => __l('LinkedIn'),'escape' => false)); ?> </li>
		<?php $class = (empty($this->request->params['named']['filter_id']) && empty($this->request->params['named']['main_filter_id'])) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (empty($this->request->params['named']['filter_id']) && empty($this->request->params['named']['main_filter_id'])) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Total') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($active+$inactive, false).'</span>', array('controller' => 'users', 'action' => 'index'), array('title' => __l('Total'),'escape' => false)); ?> </li>
	</ul>
  </div>
</div>
<section class="top-mspace">
	<div class='clearfix no-mar'>
		<div class="span no-mar">
			<?php if(isPluginEnabled('LaunchModes')) : ?>
				<ul class="row no-mar mob-c unstyled top-mspace">
				<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? 'pinkc' : 'grayc'; ?>
				<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? 'pinkc' : 'blackc';; ?>
					  <li class="span dc no-mar" title="<?php echo __l('Subscribed for Pre-launch');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-plane no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">'.__l('Subscribed for Pre-launch').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($prelaunch_subscribed, false).'</span>', array('controller' => 'subscriptions', 'action' => 'index', 'filter_id' => ConstMoreAction::PrelaunchSubscribed), array('escape' => false, 'class'=>"blackc")); ?>
					  </li>
					  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? 'pinkc' : 'grayc'; ?>
					  <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? 'pinkc' : 'blackc';; ?>
					  <li class="span dc no-mar" title="<?php echo __l('Subscribed for Private Beta');?>">
					  <?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-list-alt no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Subscribed for Private Beta').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($privatebeta_subscribed, false).'</span>', array('controller' => 'subscriptions', 'action' => 'index', 'filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('escape' => false, 'class'=>"blackc")); ?>
					  </li>
				</ul>
			<?php endif; ?>
		</div>
		<div class="span12 pull-right sep clearfix space engagement hor-mspace">
			<div ><?php echo  __l('Engagement Metrics'); ?> <i class="icon-info-sign js-tooltip" data-placement="top" title="<?php echo __l('Quick overview of how the users got engaged with the site.'); ?>"></i></div>
			<div class="pull-left mspace"><?php echo $this->Html->image('rgb-img.png', array('alt' => __l('[Image: Engagement Metrics]') ,'width' => 31, 'height' => 28)); ?></span></div>
			<ul class="unstyled " >
				<li class="pull-left hor-space"><?php echo  __l('Idle Users ('.$this->Html->cInt($idle_users, false).'), '); ?></li>
				<li class="pull-left hor-space"><?php echo  __l('Contest Posted Users ('.$this->Html->cInt($contest_posted_users, false).'), '); ?></li>
				<li class="pull-left hor-space"><?php echo  __l('Entry Posted Users ('.$this->Html->cInt($entry_posted_users, false).'), '); ?></li>
				<li class="pull-left hor-space"><?php echo  __l('Engaged Users ('.$this->Html->cInt($engaged_users, false).'), '); ?></li>
				<li class="pull-left hor-space"><?php echo  __l('Total Users ('.$this->Html->cInt($active+$inactive, false).')'); ?></li>
			</ul>
		</div>
	</div>
</section>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('User', array('type' => 'post', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
		<div class="input date-time clearfix hor-mspace">
            <div class="js-boostarp-datetime">
          <div class="js-cake-date">
                <?php echo $this->Form->input('from_date', array('label' => __l('From'), 'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
            </div>
			</div>
        </div>
        <div class="input date-time clearfix hor-mspace">
            <div class="js-boostarp-datetime">
          		<div class="js-cake-date">
                <?php echo $this->Form->input('to_date', array('label' => __l('To'),  'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
            </div>
			</div>
        </div>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb">Search</button>
        <?php echo $this->Form->end(); ?>
      </div>
      <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add') . '</span>', array('controller' => 'users', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add'),'escape' => false)); ?>
        </span> 
		<span class="hor-mspace "><?php
        	echo $this->Html->link('<span><i class="icon-download-alt"></i></span> <span class="pinkc">' . __l('Export') . '</span>', array_merge(array('controller' => 'users', 'action' => 'index', 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('title' => __l('Export'), 'class' => 'grayc js-no-pjax','escape' => false)); ?>
		</span>
      </div>
    </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
	<?php echo $this->Form->create('User' , array('class' => 'normal','action' => 'update'));	?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<table class="table table-striped table-hover">
	  <thead class="yellow-bg">
 		<tr class="sep-top sep-bot">
		  <th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		  <th rowspan="2" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		  <th rowspan="2" class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('username', __l('User')); ?></div></th>
          <?php if (isPluginEnabled('Contests')) { ?>
		    <th colspan="2" class="sep-right dc"><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps'); ?></th>
			<th colspan="3" class="sep-right dc"><?php echo Configure::read('contest.participant_alt_name_singular_caps'); ?></th>
		  <?php } ?>
		    <?php if(Configure::read('user.signup_fee')): ?>
				    <th rowspan="2" class="sep-right dr"><?php echo __l('Sign Up Fee') . ' (' . Configure::read('site.currency') . ')'; ?></th>
			<?php endif; ?>
          <?php if (isPluginEnabled('Wallet')) { ?>
			<th rowspan="2" class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('User.available_wallet_amount',
			sprintf('%s ('.Configure::read('site.currency').')', __l('Available Balance'))); ?></div></th>
          <?php } ?>
		  <th colspan="3" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('User.user_login_count',__l('Logins')); ?></div></th>	
		  <th colspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Registered on')); ?></div></th>
		</tr>
		<tr>
		  <?php if (isPluginEnabled('Contests')) { ?>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_count',__l('Contests')); ?></div></th>
			<th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('total_site_revenue_as_contest_holder',
			sprintf('%s ('.Configure::read('site.currency').')', __l('Site Revenue'))); ?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count',__l('Entries')); ?></div></th>
			<th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('participant_total_earned_amount',sprintf('%s ('.Configure::read('site.currency').')', __l('Earned'))) ?></div></th>	
			<th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('total_site_revenue_as_participant',sprintf('%s ('.Configure::read('site.currency').')', __l('Site Revenue'))); ?></div></th>
		  <?php } ?>    
		  <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('user_login_count',__l('Count')); ?></div></th>
		  <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('last_logged_in_time',__l('Time')); ?></div></th>	
          <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('LastLoginIp.ip',__l('IP')); ?></div></th>
          <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Time')); ?></div></th>
          <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip',__l('IP')); ?></div></th>
		</tr>
	  </thead>
	  <tbody>
		<?php if (!empty($users)):
          $i = 0;
          foreach ($users as $user):
                $active_class = '';
                $email_active_class = ' email-not-comfirmed';
                if($user['User']['is_email_confirmed']):
                    $email_active_class = ' email-comfirmed';
                endif;
                if($user['User']['is_active']):
                    $status_class = 'js-checkbox-active';
					$disabled = '';
                else:
                    $active_class = ' inactive-record';
                    $status_class = 'js-checkbox-inactive';
					$disabled = 'class="disabled"';
                endif;
                $online_class = 'offline';
                if (!empty($user['CkSession']['user_id'])) {
                    $online_class = 'online';
                }?>
            <tr <?php echo $disabled; ?>>
              <td class="dc span1">
                <?php echo $this->Form->input('User.'.$user['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$user['User']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
              <td  class="dc span1">
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
                    <ul class="dropdown-menu dl arrow">									
                      <?php if(Configure::read('user.is_email_verification_for_register') && !$user['User']['is_email_confirmed']):?>
                        <?php if((Configure::read('user.signup_fee') && $user['User']['is_paid']) || !Configure::read('user.signup_fee')):?>
                            <li>
                              <?php echo $this->Html->link('<i class="icon-envelope"></i>'.__l('Resend Activation'), array('controller' => 'users', 'action'=>'resend_activation', $user['User']['id'], 'admin' => false),array('class' => 'resend-activation','title' => __l('Resend Activation'),'escape' => false));?>
                            </li>
                        <?php endif; ?>
                      <?php endif; ?>
                      <li><?php echo $this->Html->link('<i class="icon-pencil blackc"></i>'.__l('Edit'), array('controller' => 'user_profiles', 'action'=>'edit', $user['User']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape' => false));?></li>
                      <?php if($user['User']['role_id'] != ConstUserTypes::Admin) { ?>
                        <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action'=>'delete', $user['User']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?>
                        </li>
                      <?php } ?>
                      <li><?php echo $this->Html->link('<i class="icon-reorder blackc"></i>'.__l('Transactions'), array('controller' => 'transactions', 'action'=>'admin_index','user_id' => $user['User']['id']), array('title' => __l('Transactions'),'class' => 'transaction', 'escape' => false));?>
                      </li>
                      <?php if (!$user['User']['is_openid_register'] && !$user['User']['is_yahoo_register'] && !$user['User']['is_google_register'] && !$user['User']['is_facebook_register'] && !$user['User']['is_twitter_register'] && !$user['User']['is_linkedin_register']): ?>
                            <li><?php echo $this->Html->link('<i class="icon-lock"></i>'.__l('Change password'), array('controller' => 'users', 'action'=>'admin_change_password', $user['User']['id']), array('class' => 'password', 'title' => __l('Change password'),'escape' => false));?></li>
                      <?php endif; ?>
                      <?php echo $this->Layout->adminRowActions($user['User']['id']);	?>
                      <li>
                        <?php echo $this->Html->link('<i class="icon-envelope"></i>'.__l('Send Email'), array('controller' => 'users', 'action'=>'send_mail','user'=>$user['User']['id'], 'admin' => true),array('class' => 'send-mail','title' => __l('Send Email'),'escape' => false));?>
                      </li>
                      <li>
                        <?php 
                        if($user['User']['is_active']){
                            echo $this->Html->link('<i class="icon-minus-sign"></i>'.__l('Inactivate'), array('controller' => 'users', 'action'=>'update_status',$user['User']['id'],'status'=>'inactive', 'admin' => true),array('class' => 'inactive-user js-confirm js-no-pjax','title' => __l('Inactivate'),'escape' => false));
                        }else{
                            echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Activate'), array('controller' => 'users', 'action'=>'update_status',$user['User']['id'],'status'=>'active', 'admin' => true),array('class' => 'active-user js-confirm js-no-pjax','title' => __l('Activate'),'escape' => false));
                        }?>
                      </li>						       
                    </ul>
                  </div>
                </td>
                <td>
                  <div>
                    <span>
                    <?php
                      echo $this->Html->getUserAvatarLink($user['User'], 'micro_thumb',true);?>
					</span>
					<?php
                      echo $this->Html->getUserLink($user['User']);
                    ?>
                    <div>
                      <?php if($user['User']['role_id'] == ConstUserTypes::Admin):?>
                        <div class="clearfix"><span title="Admin" class="label"> <?php echo __l('Admin'); ?> </span></div>
                      <?php endif; ?>
					  <?php if(!empty($user['User']['is_affiliate_user'])):?>
                        <div class="clearfix"><span title="Affiliate" class="label label-complete"> <?php echo __l('Affiliate'); ?> </span></div>
                      <?php endif; ?>
					  	
                      <?php 					
                        if(!empty($user['UserProfile']['Country'])):?>
                          <span class="no-mar ver-smspace left-space flags flag-<?php echo strtolower($user['UserProfile']['Country']['iso_alpha2']); ?>" title ="<?php echo $user['UserProfile']['Country']['name']; ?>">
                          </span>
                      <?php endif; ?>    
                      <?php if($user['User']['is_openid_register']):?>
                            <span title="<?php echo __l('OpenID'); ?>"><?php echo $this->Html->image('open-id.png', array('alt' => __l('[Image: OpenID]') ,'width' => 12, 'height' => 12, 'class' => 'text-12 hor-smspace'));?></span>
                      <?php endif; ?>
                      <?php if($user['User']['is_google_register']):?>
                            <span title="<?php echo __l('Gmail'); ?>"><i class="icon-google-sign"></i></span>
                      <?php endif; ?>
					  <?php if($user['User']['is_googleplus_register']):?>
                            <span title="<?php echo __l('Google+'); ?>"><i class="icon-google-plus-sign googlec"></i></span>
                      <?php endif; ?>
                      <?php if($user['User']['is_yahoo_register']):?>
                            <span title="<?php echo __l('Yahoo'); ?>"><i class="icon-yahoo-sign"></i></span>
                      <?php endif; ?>
                      <?php if($user['User']['is_facebook_register']):?>
                            <span title="<?php echo __l('Facebook'); ?>"><i class="icon-facebook-sign"></i></span>
                      <?php endif; ?>
                      <?php if($user['User']['is_twitter_register']):?>
                            <span title="<?php echo __l('Twitter'); ?>"><i class="icon-twitter-sign"></i></span>
                      <?php endif; ?>
                      <?php if($user['User']['is_linkedin_register']):?>
                            <span title="<?php echo __l('LinkedIn'); ?>"><i class="icon-linkedin-sign"></i></span>
                      <?php endif; ?>
                      <?php if(!empty($user['User']['email'])):?>
                            <span title="<?php echo $user['User']['email']; ?>"><i class="icon-envelope"></i></span>
                            <span>  
                                <?php 
                                if(strlen($user['User']['email'])>14) :
                                    echo '..' . substr($user['User']['email'], strlen($user['User']['email'])-14, strlen($user['User']['email'])); 
                                else:
                                    echo $user['User']['email']; 
                                endif; 
                                ?> 
                            </span>
                      <?php endif; ?>
					  <?php if (isPluginEnabled('UserFlags')) { ?>
						  <?php if(!empty($user['UserFlag'])){?>
						   <?php $user_flagged_count = count($user['UserFlag']); ?>
						  <div class="clearfix top-smspace">
							<?php echo $this->Html->link(__l('User Flagged') . ' (' . $user_flagged_count . ')', array('controller'=> 'user_flags', 'action' => 'index', 'user'=>$user['User']['username'], 'admin' => true), array('escape' => false,'class'=>'label label-important user-flagged','title'=>__l('User Flagged') . ' (' . $user_flagged_count . ')'));?></div>
						<?php } ?>
					<?php } ?>
                    </div>
                  </div>
                </td>	
                <?php if (isPluginEnabled('Contests')) { ?>
                  <td class="dc"><?php echo $this->Html->cInt($user['User']['contest_count']);?></td>
                  <td class="dr"><?php echo $this->Html->cCurrency($user['User']['total_site_revenue_as_contest_holder']);?></td>
                  <td class="dc"><?php echo $this->Html->cInt($user['User']['contest_user_count']);?></td>
                  <td class="dr"><?php echo $this->Html->cCurrency($user['User']['participant_total_earned_amount']);?></td>
                  <td class="dr"><?php echo $this->Html->cCurrency($user['User']['total_site_revenue_as_participant']);?></td>
                <?php } ?>
				  <?php if(Configure::read('user.signup_fee')): ?>
      <td class="dr"><?php if(isset($user['Transaction']['0']['amount'])) { echo $this->Html->cInt($user['Transaction']['0']['amount']); } else { echo '-';}?></td>
  <?php endif; ?>
                <?php if (isPluginEnabled('Wallet')) { ?>
                  <td class="dr"><span class="pinkc textb"><?php echo $this->Html->cCurrency($user['User']['available_wallet_amount']);?></span></td>
                <?php } ?>
                <td class="dc"><?php echo $this->Html->link($this->Html->cInt($user['User']['user_login_count'], false), array('controller' => 'user_logins', 'action' => 'index', 'username' => $user['User']['username']));?></td>
                <td class="dc">
                  <span class="show">
                    <?php if($user['User']['last_logged_in_time'] == '0000-00-00 00:00:00' || empty($user['User']['last_logged_in_time'])){
                        echo '-';
                    }else{
                        echo $this->Html->cDateTimeHighlight($user['User']['last_logged_in_time']);
                    }?>
                  </span>
                </td>
                <td>
                  <?php if(!empty($user['LastLoginIp']['ip'])): ?>
                    <span class="show">
                        <?php echo  $this->Html->link($user['LastLoginIp']['ip'], array('controller' => 'users', 'action' => 'whois', $user['LastLoginIp']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$user['User']['username'], 'escape' => false));?>
                    </span>
                    <?php if(!empty($user['LastLoginIp']['Country'])):?>
                        <span class="flags flag-<?php echo strtolower($user['LastLoginIp']['Country']['iso_alpha2']); ?>" title ="<?php echo $user['LastLoginIp']['Country']['name']; ?>">
                            <?php echo $user['LastLoginIp']['Country']['name']; ?>
                        </span>
                    <?php endif; 
                    if(!empty($user['LastLoginIp']['City'])):?>             
                        <span> 	<?php echo $user['LastLoginIp']['City']['name']; ?>    </span>
                    <?php endif; ?>
                  <?php else: ?>
                    <?php echo __l('N/A'); ?>
                  <?php endif; ?>
                </td>
                <td class="dc"><span class="show"><?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?></span></td>
                <td>
                  <?php if(!empty($user['Ip']['ip'])): ?>
                    <span class="show">
                      <?php echo  $this->Html->link($user['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $user['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$user['Ip']['host'], 'escape' => false));?>
                    </span>
                    <?php if(!empty($user['Ip']['Country'])): ?>
                        <span class="flags flag-<?php echo strtolower($user['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $user['Ip']['Country']['name']; ?>">
                            <?php echo $user['Ip']['Country']['name']; ?>
                        </span>
                    <?php endif;
                    if(!empty($user['Ip']['City'])):?>
                      <span> 	<?php echo $user['Ip']['City']['name']; ?>    </span>
                    <?php endif; ?>
                  <?php else: ?>
                    <?php echo __l('n/a'); ?>
                  <?php endif; ?>
                </td>
              </tr>
		  <?php endforeach;
		else:?>
			<tr>
				<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('users'));?></td>
			</tr>
		<?php endif;?>
	  </tbody>
    </table>
	<?php if (!empty($users)):?>
<section class="clearfix">
      <div class="span top-mspace pull-left">
		<span class="grayc"><?php echo __l('Select:'); ?></span>
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all', 'title' => __l('All'))); ?>
    	<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none','title' => __l('None'))); ?>
    	<?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'hor-mspace js-admin-select-pending', 'title' => __l('Inactive'))); ?>
    	<?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved','title' => __l('Active'))); ?>
    	<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit hor-mspace', 'label' => false, 'div' => false,'empty' => __l('-- More actions --'))); ?>
        </span>
      </div>
      <div class="span top-mspace pull-right">
        <div class="pull-right">
          <?php echo $this->element('paging_links'); ?>
        </div>
      </div>
	  </section>
    <div class="hide">
	    <?php echo $this->Form->submit('Submit'); ?>
    </div>
<?php
endif;
echo $this->Form->end();
?>
</div>
</div>
</div>