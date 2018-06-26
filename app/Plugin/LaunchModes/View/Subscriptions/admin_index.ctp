<div class="projectRatings index js-response">
<section class="no-mar ver-space mspace top-pattern sep-bot">
	<ul class="row no-mar mob-c unstyled top-mspace">
		<?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Admin) ? 'pinkc' : 'blackc';; ?>
		<?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstMoreAction::Admin) ? 'pinkc' : 'grayc'; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-user no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Admin') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($admin_count, false).'</span>', array('controller' => 'users', 'action' => 'index', 'main_filter_id' => ConstMoreAction::Admin), array('title' => __l('Admin'), 'escape' => false)); ?></li>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-eye-open no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Active') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($approved, false).'</span>', array('controller' => 'users', 'action' => 'index', 'filter_id' => ConstMoreAction::Active), array('title' => __l('Active'),'escape' => false)); ?> </li>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-eye-close no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Inactive') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pending, false).'</span>', array('controller' => 'users', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive), array('title' => __l('Inactive'),'escape' => false)); ?> </li>
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
		<li class="span dc no-mar"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Total') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($approved+$pending, false).'</span>', array('controller' => 'users', 'action' => 'index'), array('title' => __l('Total'),'escape' => false)); ?> </li>
	</ul>
</section>
<section class="page-header no-mar ver-space mspace">
<ul class="row no-mar mob-c unstyled top-mspace">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? 'pinkc' : 'grayc'; ?>
	<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrelaunchSubscribed) ? 'pinkc' : 'blackc';; ?>
	<li class="span dc no-mar" title="<?php echo __l('Subscribed for Pre-launch');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-plane no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">'.__l('Subscribed for Pre-launch').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($prelaunch_subscribed, false).'</span>', array('controller' => 'subscriptions', 'action' => 'index', 'filter_id' => ConstMoreAction::PrelaunchSubscribed), array('escape' => false, 'class'=>"blackc")); ?>
	</li>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? 'pinkc' : 'grayc'; ?>
	<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::PrivateBetaSubscribed) ? 'pinkc' : 'blackc';; ?>
	<li class="span dc no-mar" title="<?php echo __l('Subscribed for Private Beta');?>">
	<?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-list-alt no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Subscribed for Private Beta').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($privatebeta_subscribed, false).'</span>', array('controller' => 'subscriptions', 'action' => 'index', 'filter_id' => ConstMoreAction::PrivateBetaSubscribed), array('escape' => false, 'class'=>"blackc")); ?></li>
</ul>
</section>
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('Subscription', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb">Search</button>
        <?php echo $this->Form->end(); ?>
      </div>
      <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add') . '</span>', array('controller' => 'users', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add'),'escape' => false)); ?>
        </span> 
		<span class="hor-mspace "><?php
        	echo $this->Html->link('<span><i class="icon-download-alt"></i></span> <span class="pinkc">' . __l('Export') . '</span>', array_merge(array('controller' => 'subscriptions', 'action' => 'index', 'ext' => 'csv', 'admin' => true, $this->request->params['named']), $this->request->params['named']), array('title' => __l('Export'), 'class' => 'grayc js-no-pjax','escape' => false)); ?>
		</span>
      </div>
    </div>
  </div>
  <?php echo $this->Form->create('Subscription' , array('class' => 'clearfix no-mar','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section class="space">
    <table class="table table-striped table-bordered table-condensed table-hover no-mar">
      <tr>
      <th class="select dc"><?php echo __l('Select'); ?></th>
      <th class="dc"><?php echo __l('Actions');?></th>
      <th><div><?php echo $this->Paginator->sort('email', __l('Email'));?></div></th>
      <th class="dc"><?php echo $this->Paginator->sort('is_sent_private_beta_mail', __l('Invitation Sent')); ?></th>
      <th class="dc"><?php echo __l('Registered');?></th>
      <th class="dc"><?php echo __l('From Friends Invite');?></th>
      <th class="dc"><span class="clearfix"><?php echo __l('Invitation to Friends');?></span><br /><span class="clearfix"><?php echo __l('Registered');?>&nbsp;/&nbsp;<?php echo __l('Invited');?>&nbsp;/&nbsp;<?php echo __l('Allowed invitation');?></span></th>
      <th class="dc"><?php echo __l('Subscribed On');?></th>
      <th><?php echo $this->Paginator->sort('ip_id', __l('IP')); ?></th>
      </tr>
      <?php
        if (!empty($subscriptions)):
          foreach ($subscriptions as $subscription):
              $status_class = 'js-checkbox-active';
              $disabled = '';
      ?>
      <tr <?php echo $disabled; ?>>
      <td class="select dc">
      <?php echo $this->Form->input('Subscription.'.$subscription['Subscription']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$subscription['Subscription']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
      </td>
      <td class="span1 dc">
        <div class="dropdown top-space">
          <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
          <ul class="unstyled dropdown-menu dl arrow clearfix">
            <li>
              <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?>
            </li>
          <?php if(Configure::read('site.launch_mode') == 'Private Beta' && empty($subscription['Subscription']['is_sent_private_beta_mail']))   { ?>
            <li>
              <?php echo $this->Html->link('<i class="icon-envelope"></i>'.__l('Send Invitation Code'), Router::url(array('action'=>'send_invitation', $subscription['Subscription']['id']), true).'?r='.$this->request->url, array('escape'=>false, 'title' => __l('Send Invitation Code')));?>
            </li>
          <?php }  ?>
          </ul>
          <?php echo $this->Layout->adminRowActions($subscription['Subscription']['id']); ?>
      </td>
      <td><?php echo $this->Html->cText($subscription['Subscription']['email'],false);?></td>
      <td class="dc"><?php echo $this->Html->cBool($subscription['Subscription']['is_sent_private_beta_mail'],false);?></td>
      <?php if(!empty($subscription['User']['id'])) { ?>
      <td class="span4 dl">
        <div class="row-fluid">
          <div class="span dc"><?php echo $this->Html->getUserAvatarLink($subscription['User'], 'micro_thumb',true, '', 'admin');?><?php echo $this->Html->getUserLink($subscription['User']); ?></div>
          
        </div>
      </td>
      <?php } else { ?>
      <td class="dc"><?php echo $this->Html->cBool(($subscription['User']['id'])?'1':'0',false);?></td>
      <?php } ?>
	  
      <?php if(!empty($subscription['Subscription']['invite_user_id'])) { ?>
      <td class="span4 dl">
        <div class="row-fluid">
		
          <div class="span6"><?php echo $this->Html->getUserAvatarLink($subscription['InviteUser'], 'micro_thumb',true, '', 'admin');?></div>
          <div class="span12 vtop"><?php echo $this->Html->getUserLink($subscription['InviteUser']); ?></div>
        </div>
      </td>
      <?php } else { ?>
         <td class="dc"><?php echo __l('No');?></td>
      <?php } ?>
      <td class="dc">
      <?php
        $no_of_users_to_invite = Configure::read('site.no_of_users_to_invite');
        $no_of_users_to_invite = (!empty($no_of_users_to_invite))?$no_of_users_to_invite:'-';
        $invite_count = ($subscription['User']['invite_count'] == null)?'0':$subscription['User']['invite_count'];
        echo $this->Html->cText($this->App->getUserInvitedFriendsRegisteredCount($subscription['User']['id']). ' / ' . $invite_count . ' / ' .  $no_of_users_to_invite, false);
      ?>
      </td>
      <td class="dc"><?php echo $this->Html->cDateTimeHighlight($subscription['Subscription']['created']);?></td>
      <td class="dl">
        <?php if(!empty($subscription['Ip']['ip'])): ?>
        <?php echo  $this->Html->link($subscription['Ip']['ip'], array('controller' => 'subscriptions', 'action' => 'whois', $subscription['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'class' => 'js-no-pjax', 'title' => 'whois '.$subscription['Ip']['ip'], 'escape' => false));
        ?>
        <p>
        <?php
        if(!empty($subscription['Ip']['Country'])):
        ?>
        <span class="flags flag-<?php echo strtolower($subscription['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $subscription['Ip']['Country']['name']; ?>">
        <?php echo $subscription['Ip']['Country']['name']; ?>
        </span>
        <?php
        endif;
        if(!empty($subscription['Ip']['City'])):
        ?>
        <span>   <?php echo $subscription['Ip']['City']['name']; ?>  </span>
        <?php endif; ?>
        </p>
        <?php else: ?>
        <?php echo __l('n/a'); ?>
        <?php endif; ?>
      </td>
    </tr>
      <?php
      endforeach;
      else:
      ?>
    <tr>
      <td colspan="5" class="notice space"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Users'));?></td>
    </tr>
      <?php
      endif;
      ?>
  </table>
</section>
<section class="clearfix hor-mspace bot-space">
    <?php if (!empty($subscriptions)): ?>
          <div class="admin-select-block pull-left">
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
          </div>
          <div class="admin-checkbox-button pull-left hor-space">
            <div class="input select">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
          </div>
          <div class="pull-right">
            <?php echo $this->element('paging_links'); ?>
          </div>
      <div class="hide"><?php echo $this->Form->submit('Submit');  ?></div>
</section>
    <?php endif; ?>
  <?php echo $this->Form->end(); ?>
</div>