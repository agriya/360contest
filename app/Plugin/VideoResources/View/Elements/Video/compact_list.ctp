<?php  
	Configure::write('highperformance.cuids', Set::merge(Configure::read('highperformance.cuids') , $contestUser['ContestUser']['id']));
?>
<?php
if(!empty($contestUser['Attachment'][0])):
  if (empty($page)) {
	$page = 1;
  }
  $avg_rating = 0;
  if ($contestUser['ContestUser']['contest_user_rating_count'] !=0 && $contestUser['ContestUser']['contest_user_total_ratings'] > 0) {
	$avg_rating = $contestUser['ContestUser']['contest_user_total_ratings']/$contestUser['ContestUser']['contest_user_rating_count'];
  }
  $contest_flag = 1;
  if(!empty($contestUser['Contest']['admin_suspend'])){
	$contest_flag = 0;
  }
  $entry_flag = 1;
  if(!empty($contestUser['ContestUser']['admin_suspend'])){
	$entry_flag = 0;
  }
  $status_class='';
  if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated || $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
	$status_class='picure-img-block';
  }
  if($contestUser['Contest']['resource_id'] == ConstResource::Video && !empty($contestUser['Upload'][0]) && $contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Processing) {
			$video_status = 'strip-inprocess';
		} else if($contestUser['Contest']['resource_id'] == ConstResource::Video && !empty($contestUser['Upload'][0]) && $contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Failure) {
			$video_status = 'strip-failed';
	}
?>
    <?php $blind_flag = 0; ?>
	<span class="label text-14 count pa hor-mspace label-important"><?php echo $this->Html->cInt($contestUser['ContestUser']['message_count']);?></span>
	<?php if (!empty($contestUser['Contest']['is_blind']) && empty($contestUser['Contest']['winner_user_id'])) {
	  $blind_flag = 1;
	  	if($contestUser['Contest']['resource_id'] == ConstResource::Video && !empty($contestUser['Upload'][0]) && ($contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Processing || $contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Failure)) {?>
			<span class="<?php echo $video_status;?>"></span>
            <?php
		}
	  if ($this->Auth->sessionValid() && ($contestUser['ContestUser']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id'))) {
		$blind_flag = 0;
	  }
	}?>
	<?php if(empty($blind_flag)) { ?>
          <span class ="strip-<?php echo $contestUser['ContestUserStatus']['slug'];?>"><?php echo $this->Html->cText($contestUser['ContestUserStatus']['name']);?></span>
    <?php } else { ?>
				<span class="blind-info" title="<?php echo __l('Blind');?>"></span>
	<?php } ?>
	<?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
          echo $this->Html->Image('participant-bg.png',array('width' => '250','height' =>'250', 'class' => 'js-entry'));
        } elseif(!empty($blind_flag)) {
          echo $this->Html->Image('participant-bg.png',array('width' => '250','height' =>'250', 'class' => 'js-entry'));
        } else {
			$link = true;
			if ((isset($contestUser['Upload']) && $contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Failure) || !isset($contestUser['Upload'])) {
				$link = false;
			}
			if(!empty($contestUser['Upload'][0]['youtube_video_id'])) {
				$video_id = $contestUser['Upload'][0]['youtube_video_id'];
				$video_url = $contestUser['Upload'][0]['youtube_thumbnail_url'];
			} else {
				$video_id = $contestUser['Upload'][0]['vimeo_thumbnail_url'];
				$video_url = $contestUser['Upload'][0]['vimeo_thumbnail_url'];
			} 
			if($contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Processing) {
				$video_url = 'video-processing.png';
			} elseif(empty($video_url)) {
				$video_url = 'no-video.png';
			}
			if($link) {      
				echo $this->Html->link($this->Html->image($video_url, array('dimension' => $dimension, 'alt' => sprintf(__l('[Image: %s]'), $contestUser['User']['username']), 'title' => $contestUser['User']['username'], 'escape' => false, 'class' => 'js-entry')),array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'page'=>$page, 'admin'=> false),array('escape' => false));                       
			} else {                            
				echo $this->Html->image($video_url, array('dimension' => $dimension, 'alt' => sprintf(__l('[Image: %s]'), $contestUser['User']['username']), 'title' => $contestUser['User']['username'], 'escape' => false, 'class' => 'js-entry'));
			}
			 ?>
			
	 <?php } ?>
	<div class="caption hide clearfix">
	  
		
		<div class="clearfix top-mspace">
  		  <div class="clearfix text-4 textb">
			<div class="status-block">
				<div class="status-block-inner">
			  <span class ="<?php echo $contestUser['Contest']['ContestStatus']['slug'];?> js-tooltip" title="<?php echo  $this->Html->cText($contestUser['Contest']['ContestStatus']['name'], false);?>"><?php echo  $this->Html->cText($contestUser['Contest']['ContestStatus']['name']);?></span></div></div>
			<h4><?php
			  if(!empty($contest_flag)){
				echo $this->Html->link($this->Html->cText($contestUser['Contest']['name'],false), array('controller'=> 'contests', 'action' => 'view', $contestUser['Contest']['slug'], 'admin' => false), array('escape' => false, 'class' => 'htruncate span5 js-tooltip', 'title' => $contestUser['Contest']['name']));
			  } else {
				echo $this->Html->cText($contestUser['Contest']['name'],false);
			  }?>
            </h4>
			</div>
		  
		  <?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation): ?>
			<div class="pull-left grayc dr">
			  <?php if (empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) {
				echo $this->Html->link('<i class="icon-upload blackc text-16"></i>', array('controller' => 'contests', 'action' => 'view',$contestUser['Contest']['slug'],"#Upload_Entry_Design"), array('class' => 'js-tooltip upload-link', 'escape' => false, 'title' => __l('Upload Final Deliverables')));
			  }
			  if (!empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['Contest']['user_id'] == $this->Auth->user('id')) {
				echo $this->Html->link('<i class="icon-upload blackc text-16"></i>', array('controller' => 'contests', 'action' => 'reupload_entry_design', $contestUser['Contest']['id'],$contestUser['Contest']['slug']), array('class' => 'reupload-link js-tooltip', 'escape' => false, 'title' => __l('Ask to resend final deliverables')));
				echo $this->Html->link('<i class="icon-ok blackc text-16"></i>', array('controller' => 'contests', 'action' => 'accept_as_completed', $contestUser['Contest']['id']), array('class' => 'js-tooltip js-no-pjax upload-link',  "data-target" => "#js-ajax-modal", 'escape' => false, "data-toggle" => "modal" ,'title' => __l('Download and accept as completed')));
			  }?>
			</div>
		  <?php endif; ?>
		 <?php
			if (in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::ChangeCompleted,ConstContestStatus::WinnerSelected)) && empty($contestUser['Contest']['is_pending_action_to_admin'])) {
				if(($contestUser['Contest']['user_id'] == $this->Auth->user('id') &&  empty($contestUser['Contest']['is_pending_action_to_admin'])) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
									?> 									
			<div class="pull-left grayc dr">
			  <?php 
				echo $this->Html->link('<i class="icon-paste blackc text-16"></i>', Router::url(array('controller'=>'contests','action'=>'update','status_id'=>ConstContestStatus::FilesExpectation,$contestUser['Contest']['id']) ,true).'?r='.$this->request->url,array('title' => 'Accept. Ask to send final deliverables', 'class'=>'js-confirm js-tooltip js-no-pjax', 'escape' => false));	
			  ?>
			</div>
		  <?php
						}
					  }							  
			?> 


		  <?php if((($contestUser['Contest']['contest_status_id'] == ConstContestStatus::PaidToParticipant || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed)) && !empty($contest_flag) && $this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id')) && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won) { ?>
			<div class="pull-left grayc dr">
			  <?php echo $this->Html->link('<i class="icon-download blackc text-16"></i>', array('controller' => 'contests', 'action' => 'accept_as_completed', $contestUser['Contest']['id']), array('class'=>'js-no-pjax js-tooltip download download1','escape' => false , "data-target" => "#js-ajax-modal", 'escape' => false, "data-toggle" => "modal", 'title' => __l('Download')));?>
			</div>
		  <?php } ?>
		  <div class="pull-left grayc dr">
			<?php if(isPluginEnabled('EntryFlags') && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
				<div class="pull-left grayc dr">
				<div class="alcu-ra-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php 
				if(($contestUser['Contest']['user_id'] != $this->Auth->user('id')) && empty($contestUser['Contest']['is_blind'])){
					 echo $this->Html->link('<i class="icon-flagaa blackc text-16"></i>', array('controller' => 'contest_user_flags', 'action' => 'add', $contestUser['ContestUser']['id'], $contestUser['Contest']['slug'], 'admin'=> false), array('class'=>'flag js-tooltip js-colorbox', 'title' => __l('Report abuse'),"data-target" => "#js-ajax-modal", 'escape' => false, "data-toggle" => "modal")); 
					} ?>
				</div>
				</div>
			<?php } elseif(isPluginEnabled('EntryFlags')) { ?>
				<?php if(!empty($contestUser['ContestUser']['contest_user_status_id'])):?>
				  <?php if($this->Auth->user('id') != $contestUser['User']['id']) :?>
					<?php $js_class = '';
					if($this->Auth->sessionValid()){
					  $js_class = "js-like";
					}
					$js_class = '';
					if($this->Auth->sessionValid()){
					  $js_class = "js-colorbox";
					}
					if (isPluginEnabled('EntryFlags')) {
					if($contestUser['Contest']['user_id'] != $this->Auth->user('id')&& empty($contestUser['Contest']['is_blind'])){
					  echo $this->Html->link('<i class="icon-flag blackc text-16"></i>', array('controller' => 'contest_user_flags', 'action' => 'add', $contestUser['ContestUser']['id'], $contestUser['Contest']['slug'], 'admin'=> false), array('class'=>'js-tooltip flag js-no-pjax ' . $js_class, 'title' => __l('Report abuse'),"data-target" => "#js-ajax-modal", "data-toggle" => "modal",'escape' => false));
					  }
					}?>
				  <?php endif; ?>
				<?php endif;?>
			<?php } ?>
		  </div>
		</div>
	  <div class="pull-left user-right-block zoom-right-block">
	  <div class="pull-left grayc">
		<?php
		$redirect_url = "contest/".$contestUser['Contest']['slug']."/#entries";
		?>
		<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
			<div class="pull-left grayc">
			<div class="alcu-sw-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<i class="icon-trophy blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'won js-confirm hor-smspace js-tooltip js-no-pjax', 'title' => __l('Select as winner!'), 'escape' => false)); ?>
			</div>
			</div>
			<div class="pull-left grayc">
			<div class="alcu-w-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<i class="icon-repeat blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm  hor-smspace js-tooltip', 'title' => __l('Withdraw'), 'escape' => false)); ?>
			</div>
			</div>
			<div class="pull-left grayc">
			<div class="alcu-cw-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm  hor-smspace js-tooltip', 'title' => __l('Cancel withdrawn'), 'escape' => false)); ?>
			</div>
			</div>
			<div class="pull-left grayc">
			<div class="alcu-e-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<i class="icon-minus-sign blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'eliminate js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Eliminate'), 'escape' => false)); ?>
			</div>
			</div>
			<div class="pull-left grayc">
			<div class="alcu-ce-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'eliminate js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Cancel eliminate'), 'escape' => false)); ?>
			</div>
			</div>
			<div class="pull-left grayc dr">
			<div class="alcu-amc-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<i class="icon-ok blackc text-16"></i>', Router::url(array('controller'=>'contests','action'=>'update','status_id'=>ConstContestStatus::Completed,$contestUser['Contest']['id']) ,true).'?r='.$redirect_url,array('title' => 'Accept and mark as completed', 'class'=>'completd-link js-tooltip js-confirm js-no-pjax hor-smspace', 'escape' => false)); ?>
			</div>
			</div>
		<?php } else {?>
			<?php if(!empty($contestUser['ContestUser']['contest_user_status_id']) && !empty($contest_flag)):?>
			  <?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open )) {
				if(($contestUser['Contest']['user_id'] == $this->Auth->user('id') && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open ||   ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging && empty($contestUser['Contest']['is_pending_action_to_admin'])))) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
				  echo $this->Html->link('<i class="icon-trophy blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'won js-confirm  js-no-pjax hor-smspace js-tooltip', 'title' => __l('Select as winner!'), 'escape' => false));
				}
			  }
			  if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active) {
				if ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) {
				  if(($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
					echo $this->Html->link('<i class="icon-repeat blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Withdraw'), 'escape' => false));
				  endif;
				  if(($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
					echo $this->Html->link('<i class="icon-minus-sign blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'eliminate js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Eliminate'), 'escape' => false));
				  endif;
				}
			  }
			  if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated && empty($contestUser['Contest']['winner_user_id'])) {
				if(($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
				  echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'eliminate js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Cancel eliminate'), 'escape' => false));
				endif;
			  }
			  if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && empty($contestUser['Contest']['winner_user_id'])){
				if(($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
				  echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Cancel withdrawn'), 'escape' => false));
				endif;
			  }?>
			<?php endif;?>
		<?php } ?>
	  </div>
	  </div>
	  </div>
	  </div>
	  <div class="top-space">&nbsp;</div>
	  </div>
<?php endif; ?>
