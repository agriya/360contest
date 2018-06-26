<?php /* SVN: $Id: $ */ ?>
<div class="js-response">
<div class="sep-bot">
	<div class="container-fluid space">
	<?php echo $this->element('contest-status-chart', array('is_admin' => 1, 'cache' => array('config' => 'sec')));?>
	</div>
	<div class="top-pattern-contest  container-fluid space">
	<ul class="row no-mar mob-c unstyled top-mspace filter-list">
	  <?php if (!empty($this->request->params['named']['is_pending_action_to_admin'])) { ?>
		<?php if(empty($this->request->data['Contest']['filter_id']) || (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::Judging)) { ?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::Judging) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::Judging) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Judging');?>"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-legal no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Judging').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_judging_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::Judging,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>
		  </li>
		<?php } ?>
		<?php if(empty($this->request->data['Contest']['filter_id']) || (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::WinnerSelected)){ ?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelected) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelected) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Winner Selected');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-trophy no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">'.__l('Winner Selected').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_winner_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::WinnerSelected,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?></li>
		<?php } ?>
		<?php if(empty($this->request->data['Contest']['filter_id']) || (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin)){ ?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Winner Selected By Admin');?>"><?php echo $this->Html->link('<div class="span2 no-mar clearfix"> <span class="label label-important show dc space span1"><i class="icon-thumbs-up no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Winner Selected By Admin').'</span></div><span class="blackc no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_winner_selected_admin_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::WinnerSelectedByAdmin,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?></li>
		<?php } ?>
		<?php if(empty($this->request->data['Contest']['filter_id']) || (!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::ChangeCompleted)){ ?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::ChangeCompleted) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::ChangeCompleted) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Change Completed');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-ok no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">'.__l('Change Completed').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_change_completed_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::ChangeCompleted,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>

		  </li>
		<?php } ?>
		<?php if(empty($this->request->data['Contest']['filter_id'])){ ?>
		<?php $class = (!empty($this->request->params['named']['is_pending_action_to_admin'])) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['is_pending_action_to_admin'])) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('All');?>"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span>  <span class="show  '.$class.'">'.__l('All').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_all_completed_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>
		  </li>
		<?php }
	  } else { ?>
		<?php if(!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::Judging){?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::Judging) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::Judging) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Pending Action to Admin');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-trophy no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">'.__l('Pending Action to Admin').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_judging_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::Judging,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>
		  </li>
		<?php } ?>
		<?php if(!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::WinnerSelected){?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelected) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelected) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Pending Action to Admin');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-trophy no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">'.__l('Pending Action to Admin').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_winner_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::WinnerSelected,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>

		  </li>
		<?php } ?>
		<?php if(!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin){?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::WinnerSelectedByAdmin) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Pending Action to Admin');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-trophy no-pad text-24 whitec"></i></span>  <span class="show  '.$class.'">'.__l('Pending Action to Admin').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($pennding_action_winner_selected_admin_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::WinnerSelectedByAdmin,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>


		  </li>
		<?php } ?>
		<?php if(!empty($this->request->data['Contest']['filter_id']) && $this->request->data['Contest']['filter_id'] == ConstContestStatus::ChangeCompleted){?>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::ChangeCompleted) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::ChangeCompleted) ? 'pinkc' : 'blackc';; ?>
		  <li class="span dc no-mar" title="<?php echo __l('Pending Action to Admin');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-trophy no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Pending Action to Admin').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'. $this->Html->cInt($pennding_action_change_completed_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::ChangeCompleted,'is_pending_action_to_admin' => 1), array('escape' => false, 'class'=>"blackc")); ?>
		  </li>
		<?php } ?>
	  <?php } ?>
	  <?php $class = (!empty($this->request->params['named']['is_blind'])) ? 'pinkc' : 'grayc'; ?>
		<li class="span dc no-mar" title="<?php echo __l('Blind');?>">
		<?php $count_class = (!empty($this->request->params['named']['is_blind'])) ? 'pinkc' : 'blackc';; ?>
		<?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-eye-close no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Blind').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($blind_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','is_blind' => 1), array('escape' => false, 'class'=>"blackc")); ?>
		</li>
	  <?php $class = (!empty($this->request->params['named']['is_featured'])) ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['is_featured'])) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('Featured');?>"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-star no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Featured').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($featured_count, false).'</span> ', array('controller' => 'contests', 'action' => 'index', 'is_featured' => 1), array('escape' => false, 'class'=>"blackc")); ?>
		</li>
	  <?php $class = (!empty($this->request->params['named']['is_private'])) ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['is_private'])) ? 'pinkc' : 'blackc';; ?>
	  <li class="span dc no-mar" title="<?php echo __l('Private');?>"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-lock no-pad text-24 whitec"></i></span><span class="show  '.$class.'"> '.__l('Private').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($private_count, false).'</span> ', array('controller' => 'contests', 'action' => 'index','is_private' => 1), array('escape' => false, 'class'=>"blackc")); ?>
	  </li>
	  <?php $class = (!empty($this->request->params['named']['is_highlight'])) ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['is_highlight'])) ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('Highlight');?>"><?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-signal  no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Highlight').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($highlight_count, false).'</span> ', array('controller' => 'contests', 'action' => 'index','is_highlight' => 1), array('escape' => false, 'class'=>"blackc")); ?>

	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'flagged') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'flagged') ? 'pinkc' : 'blackc';; ?>
	  <li class="span dc no-mar" title="<?php echo __l('System Flagged');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-flag no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('System Flagged').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($system_flagged_count, false).'</span> ', array('controller' => 'contests', 'action' => 'index', 'type' =>'flagged'), array('escape' => false, 'class'=>"blackc")); ?>

	  </li>
	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'user-flag') ? 'pinkc' : 'blackc';; ?>
	 <li class="span dc no-mar" title="<?php echo __l('User Flagged');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('user-flag.png', array('class' => 'img', 'alt' => __l('User Flagged'))).'</span><span class="show  '.$class.'">'.__l('User Flagged').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($user_flagged_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','type'=>'user-flag'), array('escape' => false, 'class'=>"blackc")); ?>

	  </li>
	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'suspended') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'suspended') ? 'pinkc' : 'blackc';; ?>
	  <li class="span dc no-mar" title="<?php echo __l('Suspended');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-ban-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.'">'.__l('Suspended').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($suspended_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','type'=>'suspended'), array('escape' => false, 'class'=>"blackc")); ?>
	  </li>
	  <?php if (isPluginEnabled('ImageResources')): ?>
	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'image') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'image') ? 'pinkc' : 'blackc';; ?>
	   <li class="span dc no-mar" title="<?php echo __l('Image Resource');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('pic-icon-white.png', array('class' => 'img', 'alt' => __l('Image Resource'))).'</span><span class="show  '.$class.'">'.__l('Image Resource').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($image_resource_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','type'=>'image'), array('escape' => false, 'class'=>"blackc")); ?>
	  </li>
	  <?php endif; ?>
	  <?php if (isPluginEnabled('VideoResources')): ?>
	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'video') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'video') ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('Video Resource');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('video-icon-white.png', array('class' => 'img', 'alt' => __l('Video Resource'))).'</span><span class="show  '.$class.'">'.__l('Video Resource').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($video_resource_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','type'=>'video'), array('escape' => false, 'class'=>"blackc")); ?>
	  </li>
	  <?php endif; ?>
      <?php if (isPluginEnabled('AudioResources')): ?>
	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'audio') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'audio') ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('Audio Resource');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('audio-icon-white.png', array('class' => 'img', 'alt' => __l('Audio Resource'))).'</span><span class="show  '.$class.'">'.__l('Audio Resource').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($audio_resource_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','type'=>'audio'), array('escape' => false, 'class'=>"blackc")); ?>
	  </li>
	  <?php endif; ?>
      <?php if (isPluginEnabled('TextResources')): ?>
	  <?php $class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'text') ? 'pinkc' : 'grayc'; ?>
	  <?php $count_class = (!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'text') ? 'pinkc' : 'blackc';; ?>
		<li class="span dc no-mar" title="<?php echo __l('Text Resource');?>"><?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1">'.$this->Html->image('text-icon-white.png', array('class' => 'img', 'alt' => __l('Text Resource'))).'</span><span class="show  '.$class.'">'.__l('Text Resource').'</span> </div><span class="'.$count_class.' no-mar text-32 textb space span">'.$this->Html->cInt($text_resource_count, false).'</span>', array('controller' => 'contests', 'action' => 'index','type'=>'text'), array('escape' => false, 'class'=>"blackc")); ?>
	  </li>
	  <?php endif; ?>
	</ul>
  </div>
</div>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
		<?php echo $this->Form->create('Contest', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
		<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
		<button type="submit" class="btn btn-success textb">Search</button>
		<?php echo $this->Form->end(); ?>
	  </div>
	</div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
    <?php echo $this->Form->create('Contest' , array('action' => 'update','class'=>'normal'));?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<table class="table table-striped table-hover">
	  <thead class="yellow-bg">
 		<tr class="sep-top sep-bot">
		  <?php $rowspan=1;
		  if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaidToParticipant, ConstContestStatus::Completed,'development'))) {
			$rowspan=3;
		  } ?>
		  <th class="sep-right dc sep-left" rowspan="<?php echo $rowspan; ?>"><?php echo __l('Select');?></th>
		  <th class="sep-right dc" rowspan="<?php echo $rowspan; ?>"><?php echo __l('Actions');?></th>
		  <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name'));?></div></th>
		  <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted on'));?></div></th>
		  <?php if (empty($this->request->params['named']['filter_id'])):
		    $this->request->params['named']['filter_id'] = '';
		  endif;?>
		  <?php if(!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaymentPending))): ?>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><?php echo __l('Date'); ?><?php echo __l('Payment Pending') . '/' . __l('Auto Delete');?></th>
		  <?php endif;?>
		  <?php if ((!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))): ?>
		    <th class="sep-right dc" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo __l('Date'); ?><div><?php echo $this->Paginator->sort('Contest.start_date',__l('Start')); ?><?php echo '/'.$this->Paginator->sort('Contest.actual_end_date',__l('End')); ?></div></div></th>
		  <?php endif;?>
		  <?php if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::Judging, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted))):?>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><?php echo __l('Next Action To Admin'); ?></th>
		  <?php endif;?>
		  <?php if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::Completed))):?>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><?php echo __l('Date'); ?><?php echo __l('Completed') . '/' . __l('Paid to Participant');?></th>
		  <?php endif;?>
		  <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', Configure::read('contest.contest_holder_alt_name_singular_caps'));?></div></th>
		  <?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Open, ConstContestStatus::Rejected, ConstContestStatus::RefundRequest, ConstContestStatus::CanceledByAdmin, ConstContestStatus::Judging)) || !empty($this->request->params['named']['is_pending_action_to_admin'])):?>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Winner User'));?></div></th>
		  <?php endif;?>
		  <?php if ((!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry','development',ConstContestStatus::PaymentPending, ConstContestStatus::Completed, ConstContestStatus::PaidToParticipant))) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))){?>
		    <th class="sep-right dr" rowspan="<?php echo $rowspan; ?>"><?php echo  __l('Listing Fee'); echo ' ('.Configure::read('site.currency').')'; ?></th>
		  <?php } ?>
		  <?php if ((!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] != ConstContestStatus::PaymentPending || !empty($this->request->params['named']['is_pending_action_to_admin'])) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))): ?>
		    <th class="sep-right dr" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('prize', __l('Prize')); echo ' ('.Configure::read('site.currency').')'; ?></div></th>
		  <?php endif;?>
		  <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::RefundRequest) { ?>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('reason_for_cancelation', __l('Reason'));?></div></th>
		  <?php } ?>
		  <?php if ((!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval))) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))):?>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count', __l('Entries'));?></div></th>
		    <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('message_count',__l('Messages'));?></div></th>
		  <?php endif; ?>
		  <th class="sep-right" rowspan="<?php echo $rowspan; ?>"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_view_count', __l('Views'));?></div></th>
		  <?php if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaidToParticipant, ConstContestStatus::Completed,'development'))) { ?>
		    <th class="sep-right" colspan="3"><?php echo  __l('Total Amount');  ?></th>
		    <tr>
		      <th class="sep-right dr" colspan="2"><?php echo  __l('Prize'); echo ' ('.Configure::read('site.currency').')';?></th>
		      <th class="sep-right dr" colspan="1" rowspan="2"><?php echo  __l('Listing Fee'); echo ' ('.Configure::read('site.currency').')'; ?></th>
		    </tr>
		    <tr>
		      <th class="sep-right" colspan="1"><?php echo Configure::read('contest.participant_alt_name_singular_caps'); ?></th>
		      <th class="sep-right dr" colspan="1"><?php echo __l('Site Commission'); ?></th>
		    </tr>
		  <?php } ?>
	    </tr>
	  </thead>
	  <tbody>
	  <?php if (!empty($contests)):
		foreach ($contests as $contest):?>
		  <tr>
			<td class="dc span1"><?php echo $this->Form->input('Contest.'.$contest['Contest']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contest['Contest']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
			<td class="dc span1">
			  <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
                <ul class="dropdown-menu dl arrow span5">
			  	  <li>
					<?php echo $this->Html->link('<i class="icon-pencil blackc"></i>'.__l('Edit'), array('controller'=>'contests','action'=>'edit', $contest['Contest']['id'], 'filter_id' => $contest['Contest']['contest_status_id']), array('class' => 'edit js-edit', 'title' => __l('Edit'),'escape' => false));?>
				  </li>
				  <li>
				  	<?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $contest['Contest']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false)); ?>
				    <?php echo $this->Layout->adminRowActions($contest['Contest']['id']);?>
				  </li>
				  <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval) {?>
				    <li><?php echo $this->Html->link('<i class="icon-remove-sign blackc"></i>'.__l('Reject') . '<i class="icon-info-sign js-tooltip hor-mspace" title ="'. __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.') .'"></i>', array('action' => 'update_status', $contest['Contest']['id'],ConstContestStatus::Rejected), array('class' => 'reject js-confirm', 'title' => __l('Reject'),'escape'=>false)); ?></li>
					<li class="action-status-length"><?php echo $this->Html->link('<i class="icon-trophy blackc"></i>'.__l('Change Status to Open'), array('action' => 'update_status', $contest['Contest']['id'],ConstContestStatus::Open), array('class' => 'open-link js-confirm js-no-pjax', 'title' => __l('Change Status to Open'),'escape' => false)); ?></li>
				  <?php } ?>
				  <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::RefundRequest || ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging)) {?>
				    <li><?php echo $this->Html->link('<i class="icon-repeat blackc"></i>'.__l('Cancel contest'). '<i class="icon-info-sign js-tooltip hor-mspace" title ="'. __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.') .'"></i>', array('action' => 'cancel_contest', $contest['Contest']['id']), array('class' => 'cancel-link js-confirm', 'title' => __l('Cancel contest'),'escape'=>false)); ?></li>
				  <?php } ?>
				  <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::RefundRequest) {?>
				    <li><?php echo $this->Html->link('<i class="icon-remove-sign blackc"></i>'.__l('Reject request'), array('action' => 'update_status', $contest['Contest']['id'],ConstContestStatus::Judging,'type' => 'judging'), array('class' => 'open-link js-confirm js-no-pjax', 'title' => __l('Reject request'),'escape' => false)); ?></li>
				  <?php } ?>
				  <?php if(($contest['Contest']['contest_status_id'] == ConstContestStatus::Completed)){?>
					<li class="action-status-length"><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Change Status to Paid To Participant'), array('action' => 'update_status', $contest['Contest']['id'],ConstContestStatus::PaidToParticipant), array('class' => 'paid-participant-link js-confirm js-no-pjax', 'title' => __l('Change Status to Paid To Participant'),'escape' => false)); ?></li>
				  <?php } ?>
				  <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Judging)) && !empty($contest['Contest']['is_pending_action_to_admin'])) { ?>
					<?php if (!empty($contest['Contest']['contest_user_count'])) { ?>
						<li><?php echo $this->Html->link('<i class="icon-trophy blackc"></i>'.__l('Select Winner'), array('controller'=>'contest_users','action' => 'index', 'contest_id'=>$contest['Contest']['id'],'type'=>'winner_select','filter_id' => 'winner'), array('class'=>'won js-confirm js-no-pjax','title' => __l('Select Winner'),'escape' => false)); ?></li>
					<?php } if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Open) { ?>
						<li class="action-status-length"><?php echo $this->Html->link('<i class="icon-minus-sign blackc"></i>'.__l('Change status to Pending Approval'), array('action' => 'update_status', $contest['Contest']['id'], ConstContestStatus::PendingApproval), array('class' => 'open-link js-confirm js-no-pjax', 'title' => __l('Change status to Pending Approval'),'escape' => false)); ?></li>
					<?php } ?>
				  <?php } ?>
				  <?php if($contest['Contest']['is_user_flagged']):?>
				    <li><?php echo $this->Html->link('<i class="icon-flag blackc"></i>'.__l('Clear user flag'), array('action' => 'admin_update_status', $contest['Contest']['id'], 'status' => 'userflag'), array('class' => 'js-confirm clear-user-flag js-no-pjax', 'title' => __l('Clear user flag'),'escape' => false));?></li>
				  <?php endif;?>
				  <?php if($contest['Contest']['is_system_flagged']):?>
					<li><?php echo $this->Html->link('<i class="icon-flag blackc"></i>'.__l('Clear system flag'), array('action' => 'admin_update_status', $contest['Contest']['id'], 'status' => 'systemflag'), array('class' => 'js-confirm clear-flag', 'title' => __l('Clear system flag'),'escape' => false));?></li>
				  <?php else:?>
					<li><?php echo $this->Html->link('<i class="icon-flag blackc"></i>'.__l('Flag'), array('action' => 'admin_update_status', $contest['Contest']['id'], 'status' => 'flag'), array('class' => 'js-confirm flag js-no-pjax', 'title' => __l('Flag'),'escape' => false));?></li>
				  <?php endif;?>
				  <?php if($contest['Contest']['admin_suspend']):?>
					<li><?php echo $this->Html->link('<i class="icon-plus-sign blackc"></i>'.__l('Unsuspend'), array('action' => 'admin_update_status', $contest['Contest']['id'], 'status' => 'unsuspend'), array('class' => 'js-confirm unsuspend js-no-pjax', 'title' => __l('Unsuspend'),'escape' => false));?></li>
				  <?php else:?>
					<li><?php echo $this->Html->link('<i class="icon-minus-sign blackc"></i>'.__l('Suspend'), array('action' => 'admin_update_status', $contest['Contest']['id'], 'status' => 'suspend'), array('class' => 'js-confirm suspend js-no-pjax', 'title' => __l('Suspend'),'escape' => false));?></li>
				  <?php endif;?>
				  <?php if (!empty($contest['Contest']['is_uploaded_entry_design']) && ($contest['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation) && $contest['Contest']['user_id'] == $this->Auth->user('id')) { ?>
						<li><?php echo $this->Html->link('<i class="icon-retweet blackc"></i>'.__l('Ask to resend final deliverables'), array('controller' => 'contests', 'action' => 'reupload_entry_design', $contest['Contest']['id'],$contest['Contest']['slug']), array('class' => 'reupload-link js-confirm js-no-pjax', 'escape' => false, 'title' => __l('Reupload Entry Design')))?></li>
					<?php } ?>
					<?php if (!empty($contest['Contest']['is_uploaded_entry_design']) && ($contest['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation || $contest['Contest']['contest_status_id'] == ConstContestStatus::Completed) && $contest['Contest']['user_id'] == $this->Auth->user('id')) { ?>
						<li><?php echo $this->Html->link('<i class="icon-ok blackc"></i>'.__l('Download Entry Design'), array('controller' => 'contests', 'action' => 'download_entry', $contest['Contest']['id'],$contest['EntryAttachment']['slug']), array('class' => 'reupload-link js-no-pjax', 'escape' => false, 'title' => __l('Download Entry Design')))?></li>
					<?php } ?>
					<?php if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected)) && empty($contest['Contest']['is_pending_action_to_admin']) && !empty($contest_flag)) { ?>
					<li>
						<?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>'.__l('Request for change'), array('controller'=>'contests','action'=>'view',$contest['Contest']['slug'],'#Request_for_Change'), array('class'=>'request-change','escape' => false, 'title' => 'Request for change'))?>
					</li>
					<?php $flag_class = 1;
					} ?>
					<?php
					  if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::ChangeCompleted,ConstContestStatus::WinnerSelected)) && empty($contest['Contest']['is_pending_action_to_admin'])) {
						if(($contest['Contest']['user_id'] == $this->Auth->user('id') &&  empty($contest['Contest']['is_pending_action_to_admin'])) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
							?> <li>
							<?php
						  echo $this->Html->link('<i class="icon-paste blackc"></i>'.__l('Accept. Ask to send final deliverables'), Router::url(array('controller'=>'contests','action'=>'update','status_id'=>ConstContestStatus::FilesExpectation,$contest['Contest']['id']) ,true).'?r='.$this->request->url,array('title' => 'Accept. Ask to send final deliverables', 'class'=>'completd-link js-confirm js-no-pjax js-tooltip', 'escape' => false));
						  ?>
						  </li>
						  <?php
						}
					  }
					  ?>
				  <?php if (!in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))) { ?>
					<li class="sep-top"><?php echo $this->Html->link('<i class="icon-reorder blackc"></i>'.__l('Entries ('.$contest['Contest']['contest_user_count'].')'), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'].'#entries', 'admin' => false),array('title' => __l('Entries ('.$contest['Contest']['contest_user_count'].')'),'escape' => false));?></li>
					<li><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Followers ('.$contest['Contest']['contest_follower_count'].')'), array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#followers', 'admin' => false),array('title' => __l('Followers ('.$contest['Contest']['contest_follower_count'].')'),'escape' => false));?></li>
					<li><?php echo $this->Html->link('<i class="icon-trophy blackc"></i>'.Configure::read('contest.participant_alt_name_plural_caps').' ('.$contest['Contest']['partcipant_count'].')', array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#participants', 'admin' => false),array('escape' => false, 'title' => Configure::read('contest.participant_alt_name_plural_caps').' ('.$contest['Contest']['partcipant_count'].')'));?></li>
					<li><?php echo $this->Html->link('<i class="icon-link blackc"></i>'.__l('Activities'), array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#activities', 'admin' => false),array('title' => __l('Activities'),'escape' => false));?></li>
					<li><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Discussions ('.$contest['Contest']['message_count'].')'), array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#message-board', 'admin' => false),array('title' => __l('Discussions ('.$contest['Contest']['message_count'].')'),'escape' => false));?></li>
				  <?php } ?>
				</ul>
              </div>
			</td>
			<td>
				<div class="status-block clearfix span7 no-mar bot-space">
					<?php if (!empty($contest['ContestStatus']['name'])) { ?>
						<div class="status-block-inner">
							<span class="pull-left <?php echo $contest['ContestStatus']['slug'];?>" title="<?php echo $contest['ContestStatus']['name'];?>"><?php echo  $this->Html->cText($contest['ContestStatus']['name']);?></span>
						</div>
					<?php } else { ?>
						<span class="inactive"><?php echo __l('Inactive');?></span>
					<?php } ?>
					<?php if(!empty($contest['Contest']['is_pending_action_to_admin'])){?>
						<div class="status-block-inner"><span class="pull-left pending-action-to-admin" title="Pending Action to Admin"><?php echo __l('Pending Action to Admin');?></span></div>
					<?php } ?>
					<div class="clearfix span"><?php echo $this->Html->link($this->Html->cText($contest['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin' => false), array('class' =>'span6 js-tooltip no-mar htruncate', 'escape' => false, 'title' => $this->Html->cText($contest['Contest']['name'], false))); ?></div>
				</div>
				<div class="clearfix ver-smspace"><span class="label-category hor-space"><?php echo $this->Html->cText($contest['ContestType']['name']);?></span></div>
				<div class="contest-title-margin clearfix">
					<div class="status-block grayc">
						<div class="other-fee-block span no-mar">
							<?php if ($contest['Contest']['resource_id'] == ConstResource::Image) { ?>
								<i class="icon-picture text-13" title ="<?php echo __l('Image Resource');?>"></i>
							<?php } ?>
							<?php if ($contest['Contest']['resource_id'] == ConstResource::Video) { ?>
								<i class="icon-facetime-video text-13" title ="<?php echo __l('Video Resource');?>"></i>
							<?php } ?>
                            <?php if ($contest['Contest']['resource_id'] == ConstResource::Audio) { ?>
								<i class="icon-volume-up text-13" title ="<?php echo __l('Audio Resource');?>"></i>
							<?php } ?>
                             <?php if ($contest['Contest']['resource_id'] == ConstResource::Text) { ?>
								<i class="icon-edit text-13" title ="<?php echo __l('Text Resource');?>"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_private'])){?>
								<i class="icon-lock text-13" title ="<?php echo __l('Private');?>"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_blind'])){?>
								<i class="icon-eye-close text-13" title ="<?php echo __l('Blind');?>"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_featured'])){?>
								<i class="icon-star text-13" title ="<?php echo __l('Featured');?>"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_highlight'])){?>
								<i class="icon-signal text-12" title="Highlighted"></i>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php if ($contest['Contest']['is_user_flagged'] || $contest['Contest']['admin_suspend'] || $contest['Contest']['is_system_flagged']): ?>
					<div class="clearfix top-smspace">
						<?php
							if ($contest['Contest']['is_user_flagged']):
								$user_flagged_count = count($contest['ContestFlag']);
								if ($user_flagged_count > 0) {
									echo '<span class="label label-important pull-left hor-smspace" title="'.__l('System Flagged').'">' . $this->Html->link(__l('User Flagged') . ' (' . $user_flagged_count . ')', array('controller' => 'contest_flags', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'admin' => true), array('escape' => false, 'class' => 'whitec', 'title' => __l('User Flagged') . ' (' . $user_flagged_count . ')')) . '</span>';
								}
							endif;
							if ($contest['Contest']['is_system_flagged']):
								echo '<span class="label system-flagged pull-left" title="'.__l('System Flagged').'">'.__l('System Flagged').'</span>';
							endif;
							if ($contest['Contest']['admin_suspend']):
								echo '<span class="label pull-left suspended hor-smspace" title="'.__l('Suspended').'">'.__l('Suspended').'</span>';
							endif;
						?>
					</div>
				<?php endif; ?>
			</td>
			<td class="dc"><?php echo $this->Html->cDateTimeHighlight($contest['Contest']['created']);?></td>
				<?php if ((!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaymentPending))) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))): ?>
					<td>
					<?php
						$flag = 0;
						$currentDate = strtotime(date("Y-m-d"));
						$createdDate = strtotime(date('Y-m-d', strtotime($contest['Contest']['created'])));
						$start_date = $contest['Contest']['created'];
						$days = Configure::read('contest.contest_payment_pending_days_limit');
						$end_date =  date('Y-m-d H:i:s', strtotime($contest['Contest']['created'] . " +$days days"));
								if(Configure::read('contest.contest_payment_pending_days_limit') == 0){
									if($currentDate == $createdDate){
										$flag = 1;
										$end_time =  "11:59 PM";
									}
								}
						?>
							<?php
									$contest_progress_precentage = 0;
									$finished_class = '';
											$days_till_now = (strtotime(date("Y-m-d H:i:s")) - strtotime(date($start_date))) / (60 * 60 * 24);
											$total_days = (strtotime(date($end_date)) - strtotime(date($start_date))) / (60 * 60 * 24);
											if (($days_till_now > 0) && ($total_days > 0)) :
												$contest_progress_precentage = round((($days_till_now/$total_days) * 100));
											endif;
											if($contest_progress_precentage > 100) {
												$contest_progress_precentage = 100;
											}
											if($contest_progress_precentage == 100){
												$finished_class = 'status-finished';
											}

								?>
								<div class="progress">
									<div class="bar bar-success" title="<?php echo $contest_progress_precentage; ?>%" style="width: <?php echo $contest_progress_precentage; ?>%;"></div>
								</div>
								<p class="progress-value clearfix"><span class="progress-from"><?php echo $this->Html->cDateTimeHighlight($start_date);?></span><span class="progress-to pull-right"><?php
								if(empty($flag)){
									echo (!is_null($end_date))? $this->Html->cDateTimeHighlight($end_date): ' - ';
								}
								else{
									echo $end_time;
								}?></span></p>

						</td>
				<?php endif;?>
				<?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))): ?>
					<td>
						<?php if (!in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))) {
									if($contest['Contest']['actual_end_date'] == '0000-00-00 00:00:00'){
										echo "-";
									} else{?>
								<?php
									$contest_progress_precentage = 0;
									if(strtotime($contest['Contest']['start_date']) < strtotime(date('Y-m-d H:i:s'))) {
										if($contest['Contest']['actual_end_date'] !== null) {
											$days_till_now = (strtotime(date("Y-m-d H:i:s")) - strtotime(date($contest['Contest']['start_date']))) / (60 * 60 * 24);
											$total_days = (strtotime(date($contest['Contest']['actual_end_date'])) - strtotime(date($contest['Contest']['start_date']))) / (60 * 60 * 24);
											if (($days_till_now > 0) && ($total_days > 0)) :
												$contest_progress_precentage = round((($days_till_now/$total_days) * 100));
											endif;
											if($contest_progress_precentage > 100) {
												$contest_progress_precentage = 100;
											}
										} else {
											$contest_progress_precentage = 100;
										}
									}
								?>
								<div class="progress">
									<div class="bar bar-success" title="<?php echo $contest_progress_precentage; ?>%" style="width: <?php echo $contest_progress_precentage; ?>%;"></div>
								</div><p class="progress-value clearfix"><span class="progress-from"><?php echo $this->Html->cDateTimeHighlight($contest['Contest']['start_date']);?></span><span class="progress-to pull-right"><?php echo (!is_null($contest['Contest']['actual_end_date']))? $this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']): ' - ';?></span></p>
						<?php }
						} else { ?>
							<?php echo '-'; ?>
						<?php } ?>
					</td>
				<?php endif;?>
				<?php if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::Judging, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted))):
					$flag = 0;?>
					<td>
						<?php
						$currentDate = strtotime(date("Y-m-d"));
						if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Judging))) {
								$judgingDate = strtotime(date('Y-m-d', strtotime($contest['Contest']['judging_date'])));
								$start_date = $contest['Contest']['judging_date'];
								$days = Configure::read('contest.judging_to_winner_selected_days');
								$end_date =  date('Y-m-d H:i:s', strtotime($contest['Contest']['judging_date'] . " +$days days"));
								if(Configure::read('contest.judging_to_winner_selected_days') == 0){
									if($currentDate == $judgingDate){
										$flag = 1;
										$end_time =  "11:59 PM";
									}
								}
						}
						if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected))) {
								$winnerDate = strtotime(date('Y-m-d', strtotime($contest['Contest']['winner_selected_date'])));
								$start_date = $contest['Contest']['winner_selected_date'];
								$days = Configure::read('contest.winner_selected_to_completed_days');
								$end_date =  date('Y-m-d H:i:s', strtotime($contest['Contest']['winner_selected_date'] . " +$days days"));
								$days = Configure::read('contest.judging_to_winner_selected_days');
								if(Configure::read('contest.winner_selected_to_completed_days') == 0){
									if($currentDate == $winnerDate){
										$flag = 1;
										$end_time =  "11:59 PM";
									}
								}
						}
						if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::ChangeCompleted))) {
								$changeComplete = strtotime(date('Y-m-d', strtotime($contest['Contest']['change_completed_date'])));
								$start_date = $contest['Contest']['change_completed_date'];
								$days = Configure::read('contest.change_completed_to_completed_days');
								$end_date =  date('Y-m-d H:i:s', strtotime($contest['Contest']['change_completed_date'] . " +$days days"));
								if(Configure::read('contest.change_completed_to_completed_days') == 0){
									if($currentDate == $changeComplete){
										$flag = 1;
										$end_time =  "11:59 PM";
									}
								}
						}
						?>

								<?php
									$contest_progress_precentage = 0;
									$finished_class = '';
											$days_till_now = (strtotime(date("Y-m-d")) - strtotime(date($start_date))) / (60 * 60 * 24);
											$total_days = (strtotime(date($end_date) . "+1 day") - strtotime(date($start_date))) / (60 * 60 * 24);
											if (($days_till_now > 0) && ($total_days > 0)) :
												$contest_progress_precentage = round((($days_till_now/$total_days) * 100));
											endif;
											if($contest_progress_precentage > 100) {
												$contest_progress_precentage = 100;
											}
											if($contest_progress_precentage == 100){
												$finished_class = 'status-finished';
											}

								?>
								<div class="progress">
									<div class="bar bar-success" title="<?php echo $contest_progress_precentage; ?>%" style="width: <?php echo $contest_progress_precentage; ?>%;"></div>
								</div><p class="progress-value clearfix"><span class="progress-from"><?php echo $this->Html->cDateTimeHighlight($start_date);?></span><span class="progress-to pull-right"><?php
								if(empty($flag)){
									echo (!is_null($end_date))? $this->Html->cDateTimeHighlight($end_date): ' - ';
								}
								else{
									echo $end_time;
								}?></span></p>
					</td>
				<?php endif;?>
				<?php if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::Completed))):?>
					<td>
						<?php
						if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Completed))) {
								$currentDate = strtotime(date("Y-m-d"));
								$flag = 0;
								$Complete = strtotime(date('Y-m-d', strtotime($contest['Contest']['completed_date'])));
								$start_date = $contest['Contest']['completed_date'];
								$days = 0;
								if(!empty($contest['Contest']['sudopay_gateway_id'])) {
									$days = $sudopayPaymentGateway[$contest['Contest']['sudopay_gateway_id']];
								}
								$end_date =  date('Y-m-d H:i:s', strtotime($contest['Contest']['completed_date'] . " +$days days"));
								if($currentDate == $Complete){
									$flag = 1;
									$end_time =  "11:59 PM";
								}
						}
						?>
								<?php
									$contest_progress_precentage = 0;
											$days_till_now = (strtotime(date("Y-m-d")) - strtotime(date($start_date))) / (60 * 60 * 24);
											$total_days = (strtotime(date($end_date)) - strtotime(date($start_date))) / (60 * 60 * 24);
											if (($days_till_now > 0) && ($total_days > 0)) :
												$contest_progress_precentage = round((($days_till_now/$total_days) * 100));
											endif;
											if($contest_progress_precentage > 100) {
												$contest_progress_precentage = 100;
											}

								?>
								<div class="progress">
									<div class="bar bar-success" title="<?php echo $contest_progress_precentage; ?>%" style="width: <?php echo $contest_progress_precentage; ?>%;"></div>
								</div>
								<p class="progress-value clearfix"><span class="progress-from"><?php echo $this->Html->cDateTimeHighlight($start_date);?></span><span class="progress-to pull-right"><?php
								if($end_date == date("Y-m-d H:i:s")) {
									echo $end_time;
								}
								else{
									echo (!is_null($end_date))? $this->Html->cDateTimeHighlight($end_date): ' - ';
								};?></span></p>
					</td>
				<?php endif;?>
				<td>
					<?php
						echo $this->Html->getUserAvatarLink($contest['User'], 'micro_thumb',true); echo " ";
						echo $this->Html->getUserLink($contest['User']);
					?>
				</td>
				<?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Open, ConstContestStatus::Rejected, ConstContestStatus::RefundRequest, ConstContestStatus::CanceledByAdmin, ConstContestStatus::Judging)) || !empty($this->request->params['named']['is_pending_action_to_admin'])):?>
					<td>
						<?php
							 if ($contest['Contest']['contest_status_id'] >=ConstContestStatus::WinnerSelected && !empty($winnerUsers[$contest['Contest']['id']]['User'])) {
								echo $this->Html->getUserAvatarLink($winnerUsers[$contest['Contest']['id']]['User'], 'micro_thumb',true);
								echo $this->Html->getUserLink($winnerUsers[$contest['Contest']['id']]['User']);
							} else {
								echo '-';
							}
						?>
					</td>
				<?php endif; ?>
				<?php if ((!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry','development',ConstContestStatus::PaymentPending, ConstContestStatus::Completed, ConstContestStatus::PaidToParticipant))) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))){?>
					<td class="dr"><?php echo $this->Html->cCurrency($contest['Contest']['creation_cost'] - $contest['Contest']['prize']);?></td>
				<?php } ?>
				<?php if ((!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] != ConstContestStatus::PaymentPending || !empty($this->request->params['named']['is_pending_action_to_admin'])) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))): ?>
					<td class="dr"><?php if($contest['Contest']['contest_status_id'] != ConstContestStatus::PaymentPending || !empty($this->request->params['named']['is_pending_action_to_admin'])) { echo $this->Html->cCurrency($contest['Contest']['prize']); } else { echo '-';}?></td>
				<?php endif; ?>
				<?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstContestStatus::RefundRequest) { ?>
					<td><div class="htruncate-ml2 js-tooltip" title="<?php echo $this->Html->cText($contest['Contest']['reason_for_cancelation'], false); ?>"><?php echo $this->Html->cText($contest['Contest']['reason_for_cancelation'], false); ?></div></td>
				<?php }?>
				<?php if ((!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval))) || (empty($this->request->params['named']['filter_id'])) || (!empty($this->request->params['named']['is_blind'])) || (!empty($this->request->params['named']['is_featured'])) || (!empty($this->request->params['named']['is_private'])) || (!empty($this->request->params['named']['is_highlight'])) || (!empty($this->request->params['named']['type']))):?>
				<td class="dc">
					<?php echo $this->Html->link(__l($contest['Contest']['contest_user_count']), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'].'#entries', 'admin' => false),array('title' => sprintf(__l('Entries (%s)'), $contest['Contest']['contest_user_count'])));?>
				</td>
				<td class="dc">
					<?php echo $this->Html->link(__l($contest['Contest']['message_count']), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'].'#message-board', 'admin' => false),array('title' => sprintf(__l('Messages (%s)'), $contest['Contest']['message_count'])));?>
				</td>
				<?php endif; ?>
				<td class="dc">
					<?php echo $this->Html->link($this->html->cInt($contest['Contest']['contest_view_count'], false), array('controller' => 'contest_views', 'action' => 'index', 'contest' => $contest['Contest']['slug']),array('title' => sprintf(__l('Views (%s)'),$this->html->cInt($contest['Contest']['contest_view_count'], false))));?>
				</td>
				<?php if (!empty($this->request->params['named']['filter_id']) && in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PaidToParticipant, ConstContestStatus::Completed,'development'))) { ?>
					<td class="dr"><?php echo $this->Html->cCurrency($contest['Contest']['prize'] - $contest['Contest']['site_commision']);?></td>
					<td class="dr"><?php echo $this->Html->cCurrency($contest['Contest']['site_commision']);?></td>
					<td class="dr"><?php echo $this->Html->cCurrency($contest['Contest']['creation_cost'] - $contest['Contest']['prize']);?></td>
				<?php } ?>
			</tr>
		<?php
			endforeach;
			else:
		?>
			<tr>
				<td colspan="10" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('contests'));?></td>
			</tr>
		<?php
			endif;
		?>
	  </tbody>
	</table>
	<?php if (!empty($contests)):?>
		<section class="clearfix">
		<div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>

			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
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