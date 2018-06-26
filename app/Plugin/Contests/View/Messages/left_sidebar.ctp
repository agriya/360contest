<div id="ajax-tab-container-inbox" class="tab-container pr">
<ul class="nav nav-tabs span no-mar no-bor tabs">
	<?php
		$inbox_count = '';
		if (!empty($inbox)):
			$inbox_count = '(' . $inbox . ')';
		endif;
	?>
	<li class="tab first-child span3  no-mar pr dc <?php echo (!empty($folder_type) && $folder_type == 'inbox') ? 'active' : 'inactive'; ?>">
		<?php echo $this->Html->link('<span class="show"> <i class="icon-inbox no-pad text-18"></i> <span class="label default whitec pa text-11 js-unread">'.$this->Html->cInt($inbox, false).'</span></span><span class="top-space no-mar text-13">'.__('Inbox').'</span>', array('controller' => 'messages', 'action' => 'inbox'),array('data-target' => '#msg-inbox', 'title' => __l('Inbox'), 'class' => 'clearfix grayc sep-right no-mar no-bor', 'escape' => false)); ?>
	</li>
	<li class="tab span3  no-mar pr dc <?php echo (!empty($folder_type) && $folder_type == 'sent') ? 'active' : 'inactive'; ?>">
		<?php echo $this->Html->link('<span class="show"> <i class="icon-reply no-pad text-18"></i> <span class="label label-inverse whitec pa text-11">'.$this->Html->cInt($sent, false).'</span></span><span class="top-space no-mar text-13">'.__('Replied').'</span>', array('controller' => 'messages', 'action' => 'sentmail'),array('data-target' => '#msg-replied', 'title' => __l('Replied'), 'class' => 'clearfix grayc sep-right no-mar no-bor', 'escape' => false)); ?>
	</li>
	<li class="tab span3  no-mar pr dc starred <?php echo (!empty($folder_type) && $folder_type == 'all' && !empty($is_starred)) ? 'active' : 'inactive'; ?>">
		<?php echo $this->Html->link('<span class="show"> <i class="icon-star no-pad text-18"></i> <span class="label label-info whitec pa text-11 js-starred-count">'.$this->Html->cInt($stared, false).'</span></span><span class="top-space no-mar text-13">'.__('Starred').'</span>', array('controller' => 'messages', 'action' => 'starred'),array('data-target' => '#msg-starred', 'title' => __l('Starred'), 'class' => 'clearfix grayc sep-right no-mar no-bor', 'escape' => false)); ?>
	</li>
	<li class="tab span3  no-mar pr dc <?php echo (!empty($folder_type) && $folder_type == 'all' && empty($is_starred)) ? 'active' : 'inactive'; ?>">
		<?php echo $this->Html->link('<span class="show"> <i class="icon-suitcase no-pad text-18"></i> <span class="label label-success whitec pa text-11">'.$this->Html->cInt($all, false).'</span></span><span class="top-space no-mar text-13">'.__('All').'</span>', array('controller' => 'messages', 'action' => 'all'),array('data-target' => '#msg-all', 'title' => __l('All'), 'class' => 'clearfix grayc sep-right no-mar no-bor', 'escape' => false)); ?>
	</li>
</ul>
</div>