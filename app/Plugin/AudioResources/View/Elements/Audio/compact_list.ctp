<?php Configure::write('highperformance.cuids', Set::merge(Configure::read('highperformance.cuids') , $contestUser['ContestUser']['id'])); ?>
<?php
	if(!empty($contestUser['Attachment'][0]) && !empty($contestUser['AudioUpload'][0])):
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
		if (!empty($contestUser['ContestUser']['admin_suspend'])) {
			$entry_flag = 0;
		}
		$status_class = '';
		if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated || $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
			$status_class='picure-img-block';
		}
		$blind_flag = 0;
?>
<span class="label text-14 count audio-count pa hor-mspace label-important"><?php echo $this->Html->cInt($contestUser['ContestUser']['message_count']);?></span>
<?php
	if (!empty($contestUser['Contest']['is_blind']) && empty($contestUser['Contest']['winner_user_id'])) {
		$blind_flag = 1;
		if ($this->Auth->sessionValid() && ($contestUser['ContestUser']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id'))) {
			$blind_flag = 0;
		}
	}
?>
<?php if (empty($blind_flag)) { ?>
	<span class ="strip-<?php echo $contestUser['ContestUserStatus']['slug'];?>"><?php echo $this->Html->cText($contestUser['ContestUserStatus']['name']);?></span>
<?php } else { ?>
	<span class ="strip-hidden"><?php echo $this->Html->cText($contestUser['ContestUserStatus']['name']);?></span>
<?php } ?>
<?php
	if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
		echo $this->Html->Image('participant-bg.png',array('width' => '250','height' =>'250', 'class' => 'js-entry'));
	} elseif(!empty($blind_flag)) {
		echo $this->Html->Image('participant-bg.png',array('width' => '250','height' =>'250', 'class' => 'js-entry'));
	} else {
		if (!isset($link)) {
			$link = true;
		}
		if($contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]['upload_status_id'] == ConstUploadStatus::Processing) {
				$audio_url = 'video-processing.png';
			} 
			if($link && !empty($contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]) && !empty($contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]['soundcloud_audio_id']) && $contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]['upload_status_id'] == ConstUploadStatus::Success) {  
				echo $this->requestAction(array('controller' => 'audio_uploads', 'action' => 'getIFrameTrack', 'admin' => false, $contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]['soundcloud_audio_id'], '144', '195', $contestUser['Contest']['slug'],  $contestUser['ContestUser']['entry_no'], $page));   
				echo $this->Html->Image('dummy-image.jpg',array('width' => '0','height' =>'0', 'class' => 'js-entry hidden')); 
			} else if(empty($contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]['soundcloud_audio_id']) || $contestUser['AudioUpload'][(count($contestUser['AudioUpload'])-1)]['upload_status_id'] == ConstUploadStatus::Failure) {     
			?>
                                   
			<p class="contest-content no-mar dc textb">Track has been removed. It may be due to Copyright issue or admin removed your track in SoundCloud site.</p>
          <?php 
		  	echo $this->Html->Image('dummy-image.jpg',array('width' => '0','height' =>'0', 'class' => 'js-entry hidden'));
			}else{
				echo $this->Html->image($audio_url, array('height' => 200, 'width' => 220, 'alt' => sprintf(__l('[Image: %s]'), $contestUser['User']['username']), 'title' => $contestUser['User']['username'], 'escape' => false, 'class' => 'js-entry'));
			}
			
	}
?>
<div class="caption hide clearfix">
	<div class="clearfix">
		<?php
			if(!empty($contestUser['ContestUser']['contest_user_status_id'])):
				if($this->Auth->user('id') != $contestUser['User']['id']) :
					$js_class = '';
					if ($this->Auth->sessionValid()) {
						$js_class = "js-like";
					}
					if (isPluginEnabled('UserFavourites') && !empty($contest_flag)) {
						if (empty($contestUser['User']['FavoriteUser'])) :
							echo $this->Html->link(__l('Follow'), array('controller' => 'user_favorites', 'action' => 'add', $contestUser['User']['id'], $contestUser['Contest']['slug'], 'admin'=> false), array('class'=>'text-14 btn btn-success textb ' . $js_class,'title' => __l('Follow'),'escape' => false));
						else:
							echo $this->Html->link(__l('Following'), array('controller' => 'user_favorites', 'action' => 'delete', $contestUser['User']['username'], 'admin'=> false), array('class'=>'btn span2 no-mar text-14 btn-success textb js-tooltip js-unfollow  ' . $js_class,'title' => __l('Unfollow'),'escape' => false));
						endif;
					}
					$js_class = '';
					if ($this->Auth->sessionValid()) {
						$js_class = "js-colorbox";
					}
				endif;
			endif;
		?>
		<?php echo $this->Html->getUserLinkCustom($contestUser['User'], 'hor-mspace pinkc textb');?>
		<?php if(empty($blind_flag)) { ?>
			<span class ="strip-<?php echo $contestUser['ContestUserStatus']['slug'];?>"><?php echo $this->Html->cText($contestUser['ContestUserStatus']['name']);?></span>
		<?php } ?>
		<?php if (empty($blind_flag)) { ?>
			<?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) { ?>
				<span class="eliminated-info" title="<?php echo __l('Eliminated');?>"></span>
			<?php } elseif ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) { ?>
				<span class="withdrawan-info" title="<?php echo __l('Withdrawn');?>"></span>
			<?php } ?>
		<?php } else { ?>
			<span class="blind-info" title="<?php echo __l('Blind');?>"></span>
		<?php } ?>
		<div class="js-rating-display span3 pull-right grayc dr">
			<?php
				$status = 0;
				if ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open &&  !empty($contest_flag) && $contestUser['ContestUser']['contest_user_status_id'] != ConstContestUserStatus::Eliminated && $contestUser['ContestUser']['contest_user_status_id'] !=ConstContestUserStatus::Withdrawn && empty($blind_flag)) {
					$status = 1;
				}
				if (isPluginEnabled('EntryRatings')) {
					echo ($this->Auth->sessionValid() && $contestUser['User']['id'] != $this->Auth->user('id') && empty($contestUser['ContestUserRating']) && !empty($status)) ? $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => true, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings')) : $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => false, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings'));
				}
			?>
		</div>
	</div>
	<div class="clearfix top-mspace">
		<div class="clearfix text-4 textb">
			<div class="status-block">
				<div class="status-block-inner">
					<span class ="<?php echo $contestUser['Contest']['ContestStatus']['slug'];?> js-tooltip" title="<?php echo  $this->Html->cText($contestUser['Contest']['ContestStatus']['name'], false);?>"><?php echo  $this->Html->cText($contestUser['Contest']['ContestStatus']['name']);?></span>
				</div>
			</div>
			<h4>
				<?php
					if (!empty($contest_flag)) {
						echo $this->Html->link($this->Html->cText($contestUser['Contest']['name'],false), array('controller'=> 'contests', 'action' => 'view', $contestUser['Contest']['slug'], 'admin' => false), array('escape' => false, 'class' => 'htruncate span5 js-tooltip', 'title' => $this->Html->cText($contestUser['Contest']['name'], false)));
					} else {
						echo $this->Html->cText($contestUser['Contest']['name'],false);
					}
				?>
			</h4>
		</div>
		<div class="user-right-block zoom-right-block">
			<?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation): ?>
				<div class="pull-left grayc dr">
					<?php
						if (empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) {
							echo $this->Html->link('<i class="icon-upload blackc text-16"></i>', array('controller' => 'contests', 'action' => 'view',$contestUser['Contest']['slug'],"#Upload_Entry_Design"), array('class' => 'js-tooltip upload-link', 'escape' => false, 'title' => __l('Upload Final Deliverables')));
						}
						if (!empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['Contest']['user_id'] == $this->Auth->user('id')) {
							echo $this->Html->link('<i class="icon-upload blackc text-16"></i>', array('controller' => 'contests', 'action' => 'reupload_entry_design', $contestUser['Contest']['id'],$contestUser['Contest']['slug']), array('class' => 'reupload-link js-tooltip', 'escape' => false, 'title' => __l('Ask to resend final deliverables')));
							echo $this->Html->link('<i class="icon-ok blackc text-16"></i>', array('controller' => 'contests', 'action' => 'accept_as_completed', $contestUser['Contest']['id']), array('class' => 'js-tooltip js-no-pjax upload-link',  "data-target" => "#js-ajax-modal", 'escape' => false, "data-toggle" => "modal" ,'title' => __l('Download and accept as completed')));
						}
					?>
				</div>
			<?php endif; ?>
			<?php
				if (in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::ChangeCompleted,ConstContestStatus::WinnerSelected)) && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won && empty($contestUser['Contest']['is_pending_action_to_admin'])) {
					if(($contestUser['Contest']['user_id'] == $this->Auth->user('id') &&  empty($contestUser['Contest']['is_pending_action_to_admin'])) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
			?>
			<div class="pull-left grayc">
				<?php echo $this->Html->link('<i class="icon-paste blackc text-16"></i>', Router::url(array('controller'=>'contests','action'=>'update','status_id'=>ConstContestStatus::FilesExpectation,$contestUser['Contest']['id']) ,true).'?r='.$this->request->url,array('title' => 'Accept. Ask to send final deliverables', 'class'=>'js-confirm js-tooltip js-no-pjax', 'escape' => false)); ?>
			</div>
			<?php
					}
				}
			?>
			<?php if((($contestUser['Contest']['contest_status_id'] == ConstContestStatus::PaidToParticipant || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed)) && !empty($contest_flag) && $this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id')) && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won) { ?>
				<div class="pull-left grayc">
					<?php echo $this->Html->link('<i class="icon-download blackc text-16"></i>', array('controller' => 'contests', 'action' => 'accept_as_completed', $contestUser['Contest']['id']), array('class'=>'js-no-pjax js-tooltip download download1','escape' => false , "data-target" => "#js-ajax-modal", 'escape' => false, "data-toggle" => "modal", 'title' => __l('Download')));?>
				</div>
			<?php } ?>
			<div class="pull-left grayc">
				<?php if(isPluginEnabled('EntryFlags') && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
					<div class="pull-left grayc">
						<div class="alcu-ra-<?php echo $contestUser['ContestUser']['id'];?> hide">
							<?php
								if ($contestUser['Contest']['user_id'] != $this->Auth->user('id') && empty($contestUser['Contest']['is_blind'])) {
									echo $this->Html->link('<i class="icon-flag blackc text-16"></i>', array('controller' => 'contest_user_flags', 'action' => 'add', $contestUser['ContestUser']['id'], $contestUser['Contest']['slug'], 'admin'=> false), array('class'=>'flag js-tooltip js-colorbox js-no-pjax',"data-target" => "#js-ajax-modal", "data-toggle" => "modal", 'title' => __l('Report abuse'),'escape' => false)); 
								}
							?>
						</div>
					</div>
				<?php } elseif(isPluginEnabled('EntryFlags')) { ?>
					<?php
						if(!empty($contestUser['ContestUser']['contest_user_status_id'])):
							if($this->Auth->user('id') != $contestUser['User']['id']) :
								$js_class = '';
								if ($this->Auth->sessionValid()) {
									$js_class = "js-like";
								}
								$js_class = '';
								if ($this->Auth->sessionValid()) {
									$js_class = "js-colorbox";
								}
								if (isPluginEnabled('EntryFlags')) {
									if ($contestUser['Contest']['user_id'] != $this->Auth->user('id') && empty($contestUser['Contest']['is_blind'])) {
										echo $this->Html->link('<i class="icon-flag blackc text-16"></i>', array('controller' => 'contest_user_flags', 'action' => 'add', $contestUser['ContestUser']['id'], $contestUser['Contest']['slug'], 'admin'=> false), array('class'=>'js-tooltip flag js-no-pjax ' . $js_class, 'title' => __l('Report abuse'),"data-target" => "#js-ajax-modal", "data-toggle" => "modal",'escape' => false));
									}
								}
							endif;
						endif;
					?>
				<?php } ?>
			</div>
		</div>
		<?php $redirect_url = "contest/".$contestUser['Contest']['slug']."/#entries"; ?>
		<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
			<div class="pull-left grayc dr">
				<div class="alcu-sw-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-trophy blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'won js-confirm hor-smspace js-tooltip js-no-pjax', 'title' => __l('Select as winner!'), 'escape' => false)); ?>
				</div>
			</div>
			<div class="pull-left grayc dr">
				<div class="alcu-w-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-repeat blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm  hor-smspace js-tooltip', 'title' => __l('Withdraw'), 'escape' => false)); ?>
				</div>
			</div>
			<div class="pull-left grayc dr">
				<div class="alcu-cw-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm  hor-smspace js-tooltip', 'title' => __l('Cancel withdrawn'), 'escape' => false)); ?>
				</div>
			</div>
			<div class="pull-left grayc dr">
				<div class="alcu-e-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-minus-sign blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'eliminate js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Eliminate'), 'escape' => false)); ?>
				</div>
			</div>
			<div class="pull-left grayc dr">
				<div class="alcu-ce-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'eliminate js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Cancel eliminate'), 'escape' => false)); ?>
				</div>
			</div>
			<div class="pull-left grayc dr">
				<div class="alcu-amc-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-ok blackc text-16"></i>', Router::url(array('controller'=>'contests','action'=>'update','status_id'=>ConstContestStatus::Completed,$contestUser['Contest']['id']) ,true).'?r='.$redirect_url,array('title' => 'Accept and mark as completed', 'class'=>'completd-link js-tooltip js-confirm js-no-pjax hor-smspace', 'escape' => false)); ?>
				</div>
			</div>
		<?php } else { ?>
			<?php if(!empty($contestUser['ContestUser']['contest_user_status_id']) && !empty($contest_flag)):?>
				<?php
					if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open )) {
						if (($contestUser['Contest']['user_id'] == $this->Auth->user('id') && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open ||   ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging && empty($contestUser['Contest']['is_pending_action_to_admin'])))) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
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
					if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && empty($contestUser['Contest']['winner_user_id'])) {
						if (($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
							echo $this->Html->link('<i class="icon-remove blackc text-16"></i>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false) ,true).'?r='.$redirect_url, array('class' => 'withdraw js-confirm js-no-pjax hor-smspace js-tooltip', 'title' => __l('Cancel withdrawn'), 'escape' => false));
						endif;
					}
				?>
			<?php endif;?>
		<?php } ?>
	</div>
	<div class="top-space">&nbsp;</div>
</div>
<?php endif; ?>