<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contestUsers index js-response js-response-entries">
	<div class="row no-mar">
	  <ul class="nav nav-pills pull-left no-mar">
		<li><a href="#" class="graylight">Show</a></li>
		<?php $stat_class = (empty($this->request->params['named']['view_type'])) ? 'active whitec' : null; ?>
		<li class="round-5 js-pagination grid_left <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('All'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'admin' => false, 'plugin' => 'contests'), array('class' => 'graylight js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('All')));?></li>
		<?php $stat_class = (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'open') ? 'active' : null; ?>
		<li class="round-5 js-pagination grid_left <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('All active'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'view_type' => 'open', 'admin' => false, 'plugin' => 'contests'), array('class' => 'graylight js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('All active')));?></li>
		<?php if (isPluginEnabled('EntryRatings')) { ?>
		<?php $stat_class = (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'unrated') ? 'active' : null; ?>
		<li class="round-5 js-pagination grid_left <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('Unrated'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'view_type' => 'unrated', 'admin' => false, 'plugin' => 'contests'), array('class' => 'graylight js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('Unrated')));?></li>
		<?php $stat_class = (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'rated') ? 'active' : null; ?>
		<li class="round-5 js-pagination grid_left <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('Rated'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'view_type' => 'rated', 'admin' => false, 'plugin' => 'contests'), array('class' => 'graylight js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('Rated')));?></li>
		<?php } ?>
		<?php $stat_class = (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'eliminated') ? 'active' : null; ?>
		<li class="round-5 js-pagination grid_left <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('Eliminated'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'view_type' => 'eliminated', 'admin' => false, 'plugin' => 'contests'), array('class' => 'graylight js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('Eliminated')));?></li>
		<?php $stat_class = (!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'withdrawn') ? 'active' : null; ?>
		<li class="round-5 js-pagination grid_left <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('Withdrawn'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'view_type' => 'withdrawn', 'admin' => false, 'plugin' => 'contests'), array('class' => 'graylight js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('Withdrawn')));?></li>
	  </ul>
	  <div class="btn-group pull-right hor-space hor-smspace">
	<?php
		$view_type = '';
		if(isset($this->request->params['named']['view_type']))
		{
			$view_type = $this->request->params['named']['view_type'];
		}
		if(!empty($this->request->params['named']['filter'])):
			$sortby=$this->request->params['named']['filter'];
		else:
			$sortby="time";
         endif;
		if(!empty($sortby)):
			if($sortby=='rating' && isPluginEnabled('EntryRatings')) {
				  $sortto="Sort By Rating";
			}
			elseif($sortby=='time') {
				$sortto="Sort By Time";
			}
		endif;
	?>
		<button class="btn"><?php echo $sortto; ?></button>
		<button data-toggle="dropdown" class="btn sort-group dropdown-toggle"><span class="caret"></span></button>
		<ul class="dropdown-menu arrow arrow-right">
		<?php if (isPluginEnabled('EntryRatings')) { ?>
		<?php $stat_class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'rating') ? 'active' : null; ?>
		<li class="js-pagination <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('Sort By Rating'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'filter' => 'rating','view_type' => $view_type, 'admin' => false, 'plugin' => 'contests'), array('class' => 'js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('By Rating'), 'tabindex' => '-1'));?></li>
		<?php } ?>
		<?php $stat_class = ((empty($this->request->params['named']['filter'])) || !empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'time') ? 'active' : null; ?>
		<li class="js-pagination filter-block <?php echo $stat_class; ?>"><?php echo $this->Html->link(__l('Sort By Time'), array('controller' => 'contest_users', 'action' => 'index', 'contest' => $contest['Contest']['slug'], 'filter' => 'time', 'view_type' => $view_type,'admin' => false, 'plugin' => 'contests'), array('class' => 'js-no-pjax js-entries-link ' . $stat_class, 'title' => __l('By Time'), 'tabindex' => '-1'));?></li>
		</ul>
	  </div>
	</div>
	<ul class="pictures unstyled row clearfix contest-list no-mar ver-space {'minHeight':144, 'maxHeight':150, 'maxWidth':700, 'column':3}">
		<?php
	       if(!empty($winner_entry_array)){?>
		<li class="span5 pr gp-gallery-hover">
		<div class="picture-img thumbnail sep-bot no-round" style="height: 144px; width: 195px;">
			<?php
			$plugin = $winner_entry_array['Contest']['Resource']['name']."Resources";
				if (isPluginEnabled($plugin )) {
					echo $this->element($winner_entry_array['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $winner_entry_array, 'cache' => array('config' => 'sec')),array('plugin' => $plugin ));
				}?>
		</div>
		<div class="clearfix entries-user-details">
			<span class="entry-no grid_right"><?php echo '#'.$this->Html->link($this->Html->cInt($winner_entry_array['ContestUser']['entry_no'], false), array('controller' => 'contest_users', 'action' => 'view', $winner_entry_array['Contest']['slug'],  'entry' => $winner_entry_array['ContestUser']['entry_no'], 'plugin' => 'contests'));?></span>
		</div>
		</li>
		<?php } ?>

		<?php
  			if (!empty($contestUsers)):
				$i = 0;
				foreach ($contestUsers as $contestUser):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		$zoom_class = $status_class = $width = '';
		if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
				$status_class='eliminate-img';
		}
		if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
			$status_class='withdrawn';
			$width = '150';
		}
        $upload_status_class = '';
		if(!empty($contestUser['Upload']['upload_status_id']) && $contestUser['Upload']['upload_status_id'] == ConstUploadStatus::Processing) {
				$upload_status_class = 'in-process-img';
		}
		if(!empty($contestUser['Upload']['upload_status_id']) && $contestUser['Upload']['upload_status_id'] == ConstUploadStatus::Failure) {
				$upload_status_class = 'failed-img';
		}
		$zoom_class = 'gp-gallery-hover';
		$link = true;
		if($contest['Contest']['resource_id'] != ConstResource::Audio || ($contest['Contest']['resource_id'] == ConstResource::Audio &&!empty($contestUser['Attachment'][0]) && !empty($contestUser['AudioUpload'][0]))){
		?>
		<li class="span5 no-mar pr <?php echo $zoom_class . ' ' . $status_class . ' ' . $upload_status_class;?>"<?php if (!empty($width)): echo ' style="width:' . $width . 'px;"'; endif; ?>
		<?php if (!empty($height)): echo 'style="height:' . $height . 'px;"'; endif; ?>>
		<div class="picture-img thumbnail sep-bot no-round" style="height: 144px; width: 195px;">
			<?php
			$blind_flag = 1;
			if(!empty($contestUser['Contest']['is_blind']) && empty($contestUser['Contest']['winner_user_id'])){
				if($this->Auth->sessionValid() && ($contestUser['ContestUser']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id'))) {
					$blind_flag = 0;
				}
			}
	           $plugin = $contestUser['Contest']['Resource']['name']."Resources";
			if (isPluginEnabled($plugin )) {
				echo $this->element($contestUser['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $contestUser, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));

			}?>
		</div>
		<div class="clearfix entries-user-details">
			<span class="entry-no grid_right">
				<?php if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn || !empty($blind_flag)) {
					echo '#'.$this->Html->cInt($contestUser['ContestUser']['entry_no'], false);
				} else{
					 echo '#'.$this->Html->link($this->Html->cInt($contestUser['ContestUser']['entry_no'], false), array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'plugin' => 'contests'));
				}?>
			</span>
			<?php
				if (!empty($contestUser['Upload']['failure_message'])) {
					echo '<span>' . $contestUser['Upload']['failure_message'] . "</span>";
				}
			?>
		</div>
		</li>
<?php
		}
		endforeach;
	  endif;
?>
	</ul>
<?php
		if(empty($winner_entry_array) && empty($contestUsers)) {
?>
	<ol class = "unstyled">
		<li>
			<div class="thumbnail space dc grayc">
			  <p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('entries'));?></p>
			</div>
		</li>
	</ol>
<?php
	} 
?>
	<?php
		if (!empty($contestUsers)) { ?>
        <div class="grid_right clearfix js-pagination">
        <?php
			echo $this->element('paging_links');
			?>
		</div>
	 <?php	}
	?>
</div>
<div class="modal hide fade" id="js-ajax-modal">
    <div class="modal-body"></div>
	<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
</div>