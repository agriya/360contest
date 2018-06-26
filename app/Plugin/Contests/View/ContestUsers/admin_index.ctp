	<?php /* SVN: $Id: $ */ ?>
<?php
$value = '';
if(!empty($username)){
	$value = $username;
}?>
<div class="js-response">
<div class="hor-space clearfix"><?php echo $this->element('entry-status-chart', array('is_admin' => 1, 'cache' => array('config' => 'sec'))); ?></div>
<div class="top-pattern sep-bot">
  <div class="container-fluid space">

	<?php if(empty($this->request->params['named']['contestid'])){?>
	<ul class="row no-mar mob-c unstyled top-mspace">
		<?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'flagged') ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'flagged') ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('System Flagged');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-flag no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('System Flagged').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($system_flagged_count, false).'</span>', array('controller' => 'contest_users', 'action' => 'index', 'type' =>'flagged'), array('escape' => false, 'class'=>"blackc")); ?>

		</li>
		<?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('User Flagged');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('user-flag.png', array('class' => 'img', 'alt' => __l('User Flagged'))).'</span> <span class="show  '.$class.' ">' . __l('User Flagged').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($user_flagged_count, false).'</span>', array('controller' => 'contest_users', 'action' => 'index','type'=>'user-flag'), array('escape' => false, 'class'=>"blackc")); ?>

		</li>
		<?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'suspended') ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'suspended') ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('Suspended');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-ban-circle no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Suspended').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($suspended_count, false).'</span>', array('controller' => 'contest_users', 'action' => 'index','type'=>'suspended'), array('escape' => false, 'class'=>"blackc")); ?>

		</li>
	</ul>
	<?php } ?>
  </div>
</div>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
	  <div class="span pull-right grayc">
        <div class="span hor-mspace">
	      <?php
			echo $this->Form->create('ContestUser', array('type' => 'post', 'class' => 'form-search no-mar dc', 'action' => 'index'));
			?>
			 <div class="input date-time clearfix hor-mspace">
            <div class="js-boostarp-datetime">
          <div class="js-cake-date">
                <?php echo $this->Form->input('ContestUser.from_date', array('label' => __l('From'), 'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
            </div>
			</div>
        </div>
        <div class="input date-time clearfix hor-mspace">
            <div class="js-boostarp-datetime">
          		<div class="js-cake-date">
                <?php echo $this->Form->input('ContestUser.to_date', array('label' => __l('To'),  'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
            </div>
			</div>
        </div>
		<?php
			echo $this->Form->autocomplete('User.username', array('value'=>$value, 'label' => __l('User') , 'acFieldKey' => 'ContestUser.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'input-medium ver-smspace search-query span4'));
			echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4'));?>
			<button type="submit" class="btn btn-success textb">Search</button>
			<?php echo $this->Form->end();
		  ?>
		</div>
	  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
	<?php
		echo $this->Form->create('ContestUser', array('action' => 'update', 'class' => 'normal'));
		echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
	?>
	<table class="table table-striped table-hover list pictures {'minHeight':120, 'maxHeight':150, 'maxWidth':150}">
	  <thead class="yellow-bg">
 		<tr class="sep-top sep-bot">
		  <?php if(empty($this->request->params['named']['contestid'])){?>
			<th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
			<?php } ?>
			<th class="sep-right dc"><?php echo __l('Actions'); ?></th>
			<th class="sep-right"><?php echo __l('Entry'); ?></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.name', __l('Contest')); ?></div></th>
			<?php if (isPluginEnabled('EntryRatings')) { ?>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_rating_count', __l('Average Rating')); ?></div></th>
			<?php } ?>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('description', __l('Message')); ?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', Configure::read('contest.contest_holder_alt_name_singular_caps')); ?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', Configure::read('contest.participant_alt_name_singular_caps')); ?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created')); ?></div></th>
		</tr>
	  </thead>
	  <tbody>
		<?php if (!empty($contestUsers)):
				foreach($contestUsers as $contestUser):
					$class = null;
					$active_class = '';
                    $upload_status_class = '';
					if ($contestUser['ContestUser']['contest_user_status_id']):
						$active_class = '';
					else:
						$active_class = ' inactive-record';
					endif;
					$status_class = '';
					if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
						$status_class = ' eliminate-img';
					}
					if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
						$status_class = ' withdrawn';
					}
                    if (isPluginEnabled('VideoResources') && !empty($contestUser['Upload']['upload_status_id']) &&  $contestUser['Upload']['upload_status_id'] == ConstUploadStatus::Processing) {
						$upload_status_class = ' in-process-img';
					}
					if (isPluginEnabled('VideoResources') && !empty($contestUser['Upload']['upload_status_id']) && $contestUser['Upload']['upload_status_id'] == ConstUploadStatus::Failure) {
						$upload_status_class = ' failed-img';
					}
		?>
		<tr class="<?php echo $active_class . $status_class . $upload_status_class; ?>">
		  <?php if(empty($this->request->params['named']['contestid'])){?>
			<td class="dc span1"><?php echo $this->Form->input('ContestUser.' . $contestUser['ContestUser']['id'] . '.id', array('type' => 'checkbox', 'id' => "admin_checkbox_" . $contestUser['ContestUser']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
			<?php } ?>
			<td class="dc span1">
			  <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
                <ul class="dropdown-menu dl arrow">
				  <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete') , array('action' => 'delete', $contestUser['ContestUser']['id']) , array('class' => 'delete js-confirm', 'title' => __l('Delete'),'escape' => false)); ?><?php echo $this->Layout->adminRowActions($contestUser['ContestUser']['id']); ?></li>
				  <?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active) { ?>
				    <li><?php echo $this->Html->link('<i class="icon-repeat blackc"></i>'.__l('Withdraw') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class' => 'withdraw js-confirm', 'title' => __l('Withdraw'),'escape' => false)); ?></li>
					<li><?php echo $this->Html->link('<i class="icon-minus-sign blackc"></i>'.__l('Eliminate') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class' => 'eliminate  js-confirm', 'title' => __l('Eliminate'),'escape' => false)); ?></li>
				  <?php } elseif ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && empty($contestUser['Contest']['winner_user_id'])) { ?>
					<li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Cancel Withdraw') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class'=>'withdraw js-confirm','title' => __l('Cancel Withdraw'),'escape' => false)); ?></li>
				  <?php } elseif ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated && empty($contestUser['Contest']['winner_user_id'])) { ?>
					<li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Cancel Eliminate') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class' => 'eliminate js-confirm','title' => __l('Cancel Eliminate'),'escape' => false)); ?></li>
				  <?php } ?>
  				  <?php if (in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::ChangeCompleted))) {
					if($contestUser['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelectedByAdmin || !empty($contestUser['Contest']['is_pending_action_to_admin'])) {?>
					  <li><?php echo $this->Html->link('<i class="icon-ok blackc"></i>'.__l('Accept and Mark as Completed'), Router::url(array('action' => 'update_status', $contestUser['Contest']['id'],ConstContestStatus::Completed),true).'?r='.$this->request->url, array('class' => 'completed js-confirm', 'title' => __l('Accept and Mark as Completed'),'escape' => false)); ?></li>
					<?php }
				  } ?>
				  <?php if(($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed)){?>
					<li><?php echo $this->Html->link('<i class="icon-remove-sign blackc"></i>'.__l('Change Status to Closed'), Router::url(array('action' => 'update_status', $contestUser['Contest']['id'],ConstContestStatus::PaidToParticipant),true).'?r='.$this->request->url, array('class' => 'paid-participant-link js-confirm', 'title' => __l('Change Status to Closed'),'escape' => false)); ?></li>
				  <?php } ?>
				  <?php if(in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::Judging,ConstContestStatus::Open))  && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active) { ?>
					<li><?php echo $this->Html->link('<i class="icon-trophy blackc"></i>'.__l('Select as winner') , Router::url(array('controller' => 'contests', 'action' => 'update', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'user_id' => $contestUser['ContestUser']['id']),true).'?r='.$this->request->url , array('class' => 'won js-confirm', 'title' => __l('Select as winner'),'escape' => false)); ?></li>
				  <?php } ?>
				  <?php if($contestUser['ContestUser']['is_system_flagged']):?>
					<li>	<?php echo $this->Html->link('<i class="icon-flag blackc"></i>'.__l('Clear system flag'), Router::url(array('action' => 'admin_update_status', $contestUser['ContestUser']['id'], 'status' => 'systemflag'),true).'?r='.$this->request->url, array('class' => 'js-confirm clear-flag', 'title' => __l('Clear system flag'),'escape' => false));?></li>
				  <?php else:?>
					<?php if($contestUser['ContestUser']['is_user_flagged']):?>
					  <li>	<?php echo $this->Html->link('<i class="icon-flag blackc"></i>'.__l('Clear user flag'), Router::url(array('action' => 'admin_update_status', $contestUser['ContestUser']['id'], 'status' => 'userflag'),true).'?r='.$this->request->url, array('class' => 'js-confirm clear-user-flag', 'title' => __l('Clear user flag'),'escape' => false));?></li>
					<?php endif;?>
					<li>	<?php echo $this->Html->link('<i class="icon-flag blackc"></i>'.__l('Flag'), Router::url(array('action' => 'admin_update_status', $contestUser['ContestUser']['id'], 'status' => 'flag'),true).'?r='.$this->request->url, array('class' => 'js-confirm flag', 'title' => __l('Flag'),'escape' => false));?>	</li>
				  <?php endif;?>
				  <?php if($contestUser['ContestUser']['admin_suspend']):?>
					<li><?php echo $this->Html->link('<i class="icon-plus blackc"></i>'.__l('Unsuspend'), Router::url(array('action' => 'admin_update_status', $contestUser['ContestUser']['id'], 'status' => 'unsuspend'),true).'?r='.$this->request->url, array('class' => 'js-confirm unsuspend', 'title' => __l('Unsuspend'),'escape' => false));?></li>
				  <?php else:?>
					<li>	<?php echo $this->Html->link('<i class="icon-ban-circle blackc"></i>'.__l('Suspend'), Router::url(array('action' => 'admin_update_status', $contestUser['ContestUser']['id'], 'status' => 'suspend'),true).'?r='.$this->request->url, array('class' => 'js-confirm suspend', 'title' => __l('Suspend'),'escape' => false));?></li>
				  <?php endif;?>
                  <?php
                    $plugin = $contestUser['Contest']['Resource']['name'] . 'Resources';
                    if (isPluginEnabled($plugin) && $contestUser['Contest']['resource_id'] == ConstResource::Video && $contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Processing) { ?>
                    <li><?php echo $this->Html->link(__l('Check Status'), array('controller'=>'uploads','action'=>'check_status',$contestUser['Upload']['id']),array('title' => __l('Check Status'), 'class'=>'check-status'));?></li>
                  <?php } ?>
				  <li class="sep-top"><?php echo $this->Html->link('<i class="icon-reorder blackc"></i>'.__l('Entries (' .$this->Html->cInt($contestUser['Contest']['contest_user_count'], false). ')') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#entries', 'admin' => false) , array('title' => __l('Entries (' . $this->Html->cInt($contestUser['Contest']['contest_user_count'], false) . ')'),'escape' => false)); ?></li>
				  <li><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Followers (' . $contestUser['Contest']['contest_follower_count'] . ')') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#followers', 'admin' => false) , array('title' => __l('Followers (' . $contestUser['Contest']['contest_follower_count'] . ')'),'escape' => false)); ?></li>
				  <li><?php echo $this->Html->link('<i class="icon-user blackc"></i>' . Configure::read('contest.participant_alt_name_plural_caps') . ' (' . $contestUser['Contest']['partcipant_count'] . ')', array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#participants', 'admin' => false) , array('escape' => false, 'title' => Configure::read('contest.participant_alt_name_plural_caps') . ' (' . $contestUser['Contest']['partcipant_count'] . ')')); ?></li>
				  <li><?php echo $this->Html->link('<i class="icon-link blackc"></i>'.__l('Activities') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#activities', 'admin' => false) , array('title' => __l('Activities'),'escape' => false)); ?></li>
				  <li><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Discussions (' . $contestUser['Contest']['message_count'] . ')') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#message-board', 'admin' => false) , array('title' => __l('Discussions (' . $contestUser['Contest']['message_count'] . ')'),'escape' => false)); ?></li>
				</ul>
			  </div>
			</td>
			<td>
			<?php $status_class='';
			if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
					$status_class='eliminate-img';
			}
			if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
				$status_class='withdrawn';
			}
			$zoom_class='gp-gallery-hover'; ?>
			<div class="clearfix ">
                    <div class="entry-img-block">
					<ol class="pictures thumbnails row clearfix contest-list no-mar ver-space {'minHeight':142, 'maxHeight':182, 'maxWidth':700, 'column':4}">
						<?php
						if (!empty($contestUser['Contest']['Resource']['name'])) {
						$plugin =$contestUser['Contest']['Resource']['name']."Resources";
        				if (isPluginEnabled($plugin )) {?>
					       <li class="span<?php if($contestUser['Contest']['resource_id'] != ConstResource::Audio){  if($contestUser['Contest']['resource_id'] == ConstResource::Text){ echo '6';}else{?>5<?php } }?> no-mar pr gp-gallery-hover">
						   <div class="picture-img thumbnail sep-bot no-round">
				<?php echo $this->element($contestUser['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $contestUser, 'cache' => array('config' => 'sec')),array('plugin' => $plugin ));?></li>
			 <ol> </div>
						<?php } }?>
                    </div>
                     </div>
			</td>
			<td>
			<div class="status-block span6">
				<div class="status-block-inner"><span class="<?php echo $contestUser['Contest']['ContestStatus']['slug']; ?>" title="<?php echo $contestUser['Contest']['ContestStatus']['name']; ?>"><?php echo $contestUser['Contest']['ContestStatus']['name']; ?></span></div>
				<?php echo $this->Html->link($this->Html->cText($contestUser['Contest']['name']) , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'], 'admin' => false) , array('escape' => false, 'class' => 'span3 htruncate js-tooltip', 'title' => $contestUser['Contest']['name'])); ?>
				<?php  if (isPluginEnabled('EntryFlags')) {
				if($contestUser['ContestUser']['is_user_flagged']){
				$user_flagged_count = count($contestUser['ContestUserFlag']);
				if($user_flagged_count >0){?>
				<div class="clearfix top-smspace">
					<?php echo $this->Html->link(__l('User Flagged') . ' (' . $user_flagged_count . ')', array('controller'=> 'contest_user_flags', 'action' => 'index', 'entry_id'=>$contestUser['ContestUser']['id'], 'admin' => true), array('escape' => false,'class'=>'label label-important user-flagged','title'=>__l('User Flagged') . ' (' . $user_flagged_count . ')'));?></div>
				<?php } } } ?>
				<?php
					if($contestUser['ContestUser']['admin_suspend']):
						echo '<div class="clearfix top-smspace" title="'.__l('Suspended').'"><span class="label pull-left suspended">'.__l('Suspended').'</span></div>';
					endif; ?>
					<?php
					if($contestUser['ContestUser']['is_system_flagged']):
						echo '<div class="clearfix top-smspace" title="'.__l('System Flagged').'"><span class="label system-flagged pull-left">'.__l('System Flagged').'</span></div>';
					endif;
				?>
				</div>
			</td>
			<?php if (isPluginEnabled('EntryRatings')) { ?>
			<td>
				<?php
					$avg_rating = 0;
					if (!empty($contestUser['ContestUser']['contest_user_rating_count'])) {
						$avg_rating = $contestUser['ContestUser']['contest_user_total_ratings'] / $contestUser['ContestUser']['contest_user_rating_count'];
					}
					echo $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['contest_owner_user_id'], 'current_rating' => round($avg_rating, 2) , 'canRate' => false, 'cache' => array('config' => 'sec')), array('plugin' => 'EntryRatings'));
				?>
			</td>
			<?php } ?>
			<td><div class="htruncate js-tooltip span3" data-placement="left" title="<?php echo $this->Html->cText($contestUser['ContestUser']['description'],false); ?>"><?php echo $this->Html->cText($contestUser['ContestUser']['description'],false); ?></div></td>
			<td><?php echo $this->Html->getUserAvatarLink($contestUser['Contest']['User'], 'micro_thumb', true); echo " ";echo $this->Html->getUserLink($contestUser['Contest']['User']); ?></td>
			<td><?php echo $this->Html->getUserAvatarLink($contestUser['User'], 'micro_thumb', true); echo " ";echo $this->Html->getUserLink($contestUser['User']); ?></td>
			<td class="dc"><?php echo $this->Html->cDateTimeHighlight($contestUser['ContestUser']['created']); ?></td>
		</tr>
	<?php
		endforeach;
	else:
	?>
	<tr><td colspan="7" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('entries')); ?></td></tr>
	<?php
	endif;
	?>
	</tbody>
	</table>
	<?php
	if (!empty($contestUsers)):
	if (empty($this->request->params['named']['contestid'])) {
	?>
	<section class="clearfix">
		<div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>

			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
		</div>
		<?php }?>
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