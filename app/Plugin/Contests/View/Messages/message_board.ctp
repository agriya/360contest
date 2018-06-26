<?php if(empty($this->request->params['named']['entry'])){ ?>
<div class="js-response-message">
<section class="top-mspace top-space">
    <div class="sep-bot bot-space bot-mspace row">
      <h3 class="textn top-space pull-left"><?php echo __l('Project Discussion'); ?></h3>
      <?php
$contest_user_id=0;
if(!empty($this->request->params['named']['contet_user_id'])){
	$contest_user_id=$this->request->params['named']['contet_user_id'];
}?>
      <div class="btn-group pull-right">
        <button class="btn">
			<?php 
				if(empty($this->request->params['named']['filter'])):
					 echo __l('Sort by Ascending');
				else:
					if($this->request->params['named']['filter'] == 'freshness'):
						echo __l('Sort By Freshness');
					elseif($this->request->params['named']['filter'] == 'descending'):
						echo __l('Sort By Descending');
					elseif($this->request->params['named']['filter'] == 'ascending'):
						echo __l('Sort By Ascending');
					endif; 
				endif; 
			?>
        </button>
        <button class="btn dropdown-toggle sort-group" data-toggle="dropdown"><span class="caret"></span></button>
        <ul class="dropdown-menu arrow arrow-right">
          <li><?php echo $this->Html->link(__l('Sort By Freshness'), array('controller' => 'messages', 'action' => 'index', 'contest_id' => $contest['Contest']['id'],'contet_user_id'=>$contest_user_id, 'filter' => 'freshness', 'admin' => false, 'plugin' => 'contests'), array('class' => 'js-no-pjax js-message-link', 'title' => __l('Sort By Freshness')));?></li>
          <li><?php echo $this->Html->link(__l('Sort By Descending'), array('controller' => 'messages', 'action' => 'index', 'contest_id' => $contest['Contest']['id'],'contet_user_id'=>$contest_user_id, 'filter' => 'descending', 'admin' => false, 'plugin' => 'contests'), array('class' => 'js-no-pjax js-message-link', 'title' => __l('Sort By Descending')));?></li>
          <li><?php echo $this->Html->link(__l('Sort By Ascending'), array('controller' => 'messages', 'action' => 'index', 'contest_id' => $contest['Contest']['id'],'contet_user_id'=>$contest_user_id, 'filter' => 'ascending', 'admin' => false, 'plugin' => 'contests'), array('class' => 'js-no-pjax js-message-link', 'title' => __l('Sort By Ascending')));?></li>
        </ul>
      </div>
    </div>
	<div class="row top-mspace top-space text-14">
		<ol class="unstyled discussion-list">
		<?php
			if (!empty($messages)) :
				$i = 0;
				foreach($messages as $message):
		?>
		  <li class="row <?php if($message['Message']['depth'] == 0){ echo 'top-space top-mspace';} $i++;?>">
		   <?php
				$dimension='normal_thumb';
				if($message['Message']['depth'] == 0){
					$dimension='normal_thumb';
				}
				if(!empty($this->request->params['named']['contet_user_id'])){
					$dimension='small_thumb';
				}
			?>
			
			<?php if($message['Message']['depth'] == 0){?>
			<div class="thumbnail sep-bot pull-left hor-mspace"> <?php echo $this->Html->getUserAvatarLink($message['OtherUser'], $dimension,true); ?> </div>
					<div class="pull-right thumbnail span21 sep-bot pr discussion"> <i class="icon-caret-left pa text-32 cmd-left-ps whitec"></i>
			<?php  }else{  ?>
					<div class="discussion pull-right thumbnail span20 sep-bot <?php if($message['Contest']['user_id'] == $message['Message']['other_user_id']){ echo 'current-user'; } ?>">
					  <div class="thumbnail sep pull-left hor-mspace"> <?php echo $this->Html->getUserAvatarLink($message['OtherUser'], $dimension,true); ?> </div>
			 <?php } ?>         
			  <div class="<?php if($message['Message']['depth'] == 0){ echo 'span18';}else{ echo 'span15 no-mar';} ?>">
				<p> <?php echo $this->Html->getUserLinkCustom($message['OtherUser'], 'pinkc text-14 textb no-under');?>
				<?php if ($message['Message']['is_private']) { ?>
					<span class="label label-warning hor-mspace mspace js-tooltip" title="<?php echo __l('Private'); ?>"><?php echo __l('Private'); ?></span>
				<?php } ?>
				<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
				 <span class="js-timestamp" title="<?php echo $time_format;?>"> <?php echo $message['Message']['created'];?></span> </p>
				<p>
						<?php 
						if($this->Auth->user('id') && $this->Auth->user('role_id') == ConstUserTypes::Admin){
							echo $this->Html->CText($message['MessageContent']['message']);
						}else{ 
							if ($message['Message']['is_private'] && (!$this->Auth->user('id') || ($this->Auth->user('id') != $message['Message']['user_id'] && $this->Auth->user('id') != $message['Message']['other_user_id']))) { 
								echo '['.__l('Private Message').']';
							} else {
							echo "";
								echo $this->Html->CText($message['MessageContent']['message']);
							} 
						} ?>
				</p>
				<?php
					if(!empty($message['ContestUser']['copyright_note']) && ($this->Auth->user('id') && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $this->Auth->user('id') == $message['Message']['user_id'] || $this->Auth->user('id') == $message['Contest']['user_id']))){ ?>
				<p>
				<?php echo __l('Copyright Note: ');
					echo __l($message['ContestUser']['copyright_note']); ?>
				</p>						
				<?php } ?>
			  </div>
			   <?php
				$plugin = $message['Contest']['Resource']['name'] . 'Resources';				
				$withdrawn_flag = 0;
				$private_flag = 1;
				$blind_flag = 1;
				if($message['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn){
					$withdrawn_flag = 1;
				}
				if(!empty($message['Contest']['is_private']) && (!$this->Auth->sessionValid() || ($this->Auth->user('role_id') != ConstUserTypes::Admin && $this->Auth->user('id') != $message['ContestUser']['user_id'] && $this->Auth->user('id') != $message['Contest']['user_id']))) {
					$private_flag = 0;
				}
				if(!empty($message['Contest']['is_blind']) && (!$this->Auth->sessionValid() || ($this->Auth->user('role_id') != ConstUserTypes::Admin && $this->Auth->user('id') != $message['ContestUser']['user_id'] && $this->Auth->user('id') != $message['Contest']['user_id']))) {
					$blind_flag = 0;
				}
				if (isPluginEnabled($plugin) && (!empty($message['ContestUser']['Attachment'][0]) || !empty($message['MessageContent']['text_resource']) ) && empty($this->request->params['named']['contet_user_id']) && empty($withdrawn_flag) && !empty($private_flag) && !empty($blind_flag)): ?>
                  <div class="thumbnail dc span<?php if($message['Contest']['Resource']['id'] == ConstResource::Text){ echo '2';} ?> clearfix pull-right">
						<?php echo $this->element($message['Contest']['Resource']['name'].'/message_entry', array('contestUser' => $message,'type'=>'entry', 'cache' => array('config' => 'sec')),array('plugin' => $plugin)); ?>
					<span class="btn btn-mini show no-round <?php if($message['Contest']['Resource']['id'] == ConstResource::Text){ echo 'text-message-entry-btn pull-left';} ?>">Entry</span> 
			   </div>
			 <?php endif; ?>
			  <div class="span clearfix pull-right">
			 
			 <?php if(($this->Auth->user('id') == $message['Message']['other_user_id'] || $this->Auth->user('id') == $message['Message']['user_id']) && $message['Contest']['user_id'] == $message['Message']['other_user_id'] && !empty($message['MessageContent']['Attachment'])) { ?>
									<div class="ver-space no-mar pull-right">
											<?php		echo $this->Html->link('<i class="textb icon-download-alt"></i>'.__l('Download'), array('controller'=>'messages','action'=>'download',$message['MessageContent']['id'],$message['MessageContent']['Attachment'][0]['id']), array('class'=>'js-no-pjax download','title' => __l('Download'),'escape' => false)); ?>
									</div>
							<?php }?>
			 <div class="clearfix">
									<?php if($this->Auth->sessionValid() && ((empty($message['Message']['is_private']) && ($this->Auth->user('id') != $message['Message']['other_user_id'])) || (!empty($message['Message']['is_private']) && (($this->Auth->user('id') == $message['Message']['user_id']))))):?>
									<?php
									$depth_allowed = Configure::read('messages.thread_max_depth');
									if (empty($depth_allowed) || $message['Message']['depth'] < Configure::read('messages.thread_max_depth')) {?>
	




											<div class="clearfix hor-smspace dr reply-block js-reply-hide<?php echo $message['Message']['id'];?>">
													<?php 
														if($this->Auth->user('id') != $message['Message']['other_user_id'] && empty($message['Message']['is_activity'])) {
															echo $this->Html->link(__l('Reply'), array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'], 'reply', 'user' => $message['OtherUser']['username'], 'contest_id' => $message['Contest']['id'], 'reply_type' => 'quickreply','root'=>$message['Message']['root'],'message_type'=>'message_board','m_path'=>$message['Message']['materialized_path']), array("class" => "btn btn-small reply-block js-link js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-".$message['Message']['id']."'}", 'title' => __l('Reply')));
														}
													   ?>
													   <!--
													<?php echo $this->Html->link(__l('Reply'),array('controller'=>'messages','action'=>'compose',$message['Message']['id'],'reply','user'=>$message['OtherUser']['username'], 'contest_id' => $message['Contest']['id'], 'contest_user_id' => $contest_user_id, 'reply_type' => 'quickreply', 'root' => $message['Message']['root'], 'm_path' => $message['Message']['materialized_path'],'entry' => !empty($this->request->params['named']['entry'])?$this->request->params['named']['entry']:'','page' => !empty($this->request->params['named']['page'])?$this->request->params['named']['page']:''), array("class" =>"btn btn-mini btn-primary reply js-link js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-" . $message['Message']['id']."'}", 'title' => __l('Reply'))); ?>
													-->
											 </div>
											 <div class="space multisupporteds hide js-quickrepy js-quickreply-<?php echo $message['Message']['id'];?>">
												<div class="quick-replay1 clearfix">
													<div class="js-quickreplydiv-<?php echo $message['Message']['id'];?>"></div>
												</div>
											</div>
	
									<?php } else { ?>
									<div class="reply-block clearfix">
										<span class="btn btn-mini btn-primary reply-not-allow pull-right js-tooltip disabled" title = "<?php echo __l('Reply is disabled for this thread depth');?>"><?php echo __l('Reply');?></span>
									</div>
									<?php } ?>
						<?php endif; ?>
						</div>
						</div>
			</div>
			<div class="modal hide fade" style="z-index:999999" id="js-ajax-modal-<?php echo $message['Message']['id'];?>">
												<div class="modal-body"></div>
												<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
											 </div>
		  </li>
		   <?php
				endforeach;
			else: ?>
			<div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('discussions'));?></p>
					</div>
		<?php	endif;
				
		?>
		</ol>
	</div>
</section>
</div>
<?php } else {
$contest_user_id=0;
if(!empty($this->request->params['named']['contet_user_id'])){
	$contest_user_id=$this->request->params['named']['contet_user_id'];
}?>
<div class="js-response-message">
	 <div class="btn-group dr clearfix">
        <button class="btn">
			<?php 
				if(empty($this->request->params['named']['filter'])):
					 echo __l('Sort by Ascending');
				else:
					if($this->request->params['named']['filter'] == 'freshness'):
						echo __l('Sort By Freshness');
					elseif($this->request->params['named']['filter'] == 'descending'):
						echo __l('Sort By Descending');
					elseif($this->request->params['named']['filter'] == 'ascending'):
						echo __l('Sort By Ascending');
					endif; 
				endif; 
			?>
        </button>
        <button class="btn dropdown-toggle" data-toggle="dropdown"><span class="ver-smspace"> <span class="caret"></span> </span></button>
        <ul class="dropdown-menu arrow arrow-right dl">
          <li><?php echo $this->Html->link(__l('Sort By Freshness'), array('controller' => 'messages', 'action' => 'index', 'contest_id' => $contest['Contest']['id'],'contet_user_id'=>$contest_user_id, 'filter' => 'freshness', 'admin' => false, 'plugin' => 'contests', 'entry' => '1'), array('class' => 'js-no-pjax js-message-link', 'title' => __l('Sort By Freshness')));?></li>
          <li><?php echo $this->Html->link(__l('Sort By Descending'), array('controller' => 'messages', 'action' => 'index', 'contest_id' => $contest['Contest']['id'],'contet_user_id'=>$contest_user_id, 'filter' => 'descending', 'admin' => false, 'plugin' => 'contests', 'entry' => '1'), array('class' => 'js-no-pjax js-message-link', 'title' => __l('Sort By Descending')));?></li>
          <li><?php echo $this->Html->link(__l('Sort By Ascending'), array('controller' => 'messages', 'action' => 'index', 'contest_id' => $contest['Contest']['id'],'contet_user_id'=>$contest_user_id, 'filter' => 'ascending', 'admin' => false, 'plugin' => 'contests', 'entry' => '1'), array('class' => 'js-no-pjax js-message-link', 'title' => __l('Sort By Ascending')));?></li>
        </ul>
      </div>
		<ol class="unstyled discussion-list">
		<?php
			if (!empty($messages)) :
				$i = 0;
				foreach($messages as $message):
		?>
		  <li class="row <?php if($message['Message']['depth'] == 0){ echo 'top-mspace';} $i++;?>">
			<?php $dimension='normal_thumb';
			if($message['Message']['depth'] == 0){
				$dimension='normal_thumb';
			}
			if(!empty($this->request->params['named']['contet_user_id'])){
				$dimension='small_thumb';
			}?>
			<div class="space clearfix pull-right span8">
			<?php if($message['Message']['depth'] == 0){?>
				<div class="thumbnail-small sep-bot pull-left right-mspace"> <?php echo $this->Html->getUserAvatarLink($message['OtherUser'], $dimension,true); ?> </div>
				<div class="pull-right thumbnail discussion span6 sep-bot pr"> <i class="icon-caret-left pa text-32 cmd-left-ps whitec"></i>
			<?php  }else{  ?>
				<div class="pull-right discussion thumbnail span6 sep-bot current-user <?php if($message['Contest']['user_id'] == $message['Message']['other_user_id']){ echo 'current-user'; } ?>">
				<div class="thumbnail-small sep-bot pull-left hor-mspace"> <?php echo $this->Html->getUserAvatarLink($message['OtherUser'], $dimension,true); ?> </div>
			 <?php } ?>         
			 <div class="<?php if($message['Message']['depth'] == 0){ echo 'span5';}else{ echo 'span4 no-mar';} ?>">
				<p class="text-11 no-pad"> <?php echo $this->Html->getUserLinkCustom($message['OtherUser'], 'pinkc text-14 textb no-under');?>
					<?php if ($message['Message']['is_private']) { ?>
						<span class="label label-warning hor-mspace mspace js-tooltip" title="<?php echo __l('Private'); ?>"><?php echo __l('Private'); ?></span>
					<?php } ?>
					<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
					<span class="js-timestamp" title="<?php echo $time_format;?>"> <?php echo $message['Message']['created'];?></span> 
				</p>
				<p class="text-11 no-pad">
					<?php if($this->Auth->user('id') && $this->Auth->user('role_id') == ConstUserTypes::Admin){
						echo $this->Html->CText($message['MessageContent']['message']);
					}else{ 
						if ($message['Message']['is_private'] && (!$this->Auth->user('id') || ($this->Auth->user('id') != $message['Message']['user_id'] && $this->Auth->user('id') != $message['Message']['other_user_id']))) { 
							echo '['.__l('Private Message').']';
						} else {
							echo $this->Html->CText($message['MessageContent']['message']);
						} 
					} ?>
				</p>
			  </div>
			  
			  <?php	$plugin = $message['Contest']['Resource']['name'] . 'Resources';
			  $withdrawn_flag = 0;
			  $private_flag = 1;
			  $blind_flag = 1;
			  if($message['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn){
				$withdrawn_flag = 1;
			  }
				if(!empty($message['Contest']['is_private']) && (!$this->Auth->sessionValid() || ($this->Auth->user('role_id') != ConstUserTypes::Admin && $this->Auth->user('id') != $message['ContestUser']['user_id'] && $this->Auth->user('id') != $message['Contest']['user_id']))) {
					$private_flag = 0;
			  }
				if(!empty($message['Contest']['is_blind']) && (!$this->Auth->sessionValid() || ($this->Auth->user('role_id') != ConstUserTypes::Admin && $this->Auth->user('id') != $message['ContestUser']['user_id'] && $this->Auth->user('id') != $message['Contest']['user_id']))) {
					$blind_flag = 0;
			  }?>
			  <div class="pull-right entry-box-small">
				<?php if (isPluginEnabled($plugin) && (!empty($message['ContestUser']['Attachment'][0]) || !empty($message['MessageContent']['text_resource'])) && empty($this->request->params['named']['contet_user_id']) && empty($withdrawn_flag) && !empty($private_flag) && !empty($blind_flag)): ?>
					<?php echo $this->element($message['Contest']['Resource']['name'].'/message_entry', array('contestUser' => $message,'type'=>'entry', 'cache' => array('config' => 'sec')),array('plugin' => $plugin)); ?>
					<span class="btn btn-mini show no-round">Entry</span> 
				<?php endif; ?>
				<?php if($this->Auth->sessionValid() && ((empty($message['Message']['is_private']) && ($this->Auth->user('id') != $message['Message']['other_user_id'])) || (!empty($message['Message']['is_private']) && (($this->Auth->user('id') == $message['Message']['user_id']))))):
					$depth_allowed = Configure::read('messages.thread_max_depth');
					if (empty($depth_allowed) || $message['Message']['depth'] < Configure::read('messages.thread_max_depth')) { ?>
						<div class="clearfix ver-mspace dr<?php echo $message['Message']['id'];?>">
							<?php echo $this->Html->link(__l('Reply'),array('controller'=>'messages','action'=>'compose',$message['Message']['id'],'reply','user'=>$message['OtherUser']['username'], 'contest_id' => $message['Contest']['id'], 'contest_user_id' => $contest_user_id, 'reply_type' => 'quickreply', 'root' => $message['Message']['root'], 'm_path' => $message['Message']['materialized_path'],'entry' => !empty($this->request->params['named']['entry'])?$this->request->params['named']['entry']:'','page' => !empty($this->request->params['named']['page'])?$this->request->params['named']['page']:''), array("class" =>"btn btn-mini js-tooltip reply-block js-link js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-" . $message['Message']['id']."'}",  'title' => __l('Reply'))); ?>
						</div>						
					<?php } else { ?>
						<span class="btn btn-mini btn-primary reply-not-allow btn btn-mini show no-round js-tooltip disabled" title = "<?php echo __l('Reply is disabled for this thread depth');?>"><?php echo __l('Reply');?></span>
					<?php } ?>
				<?php endif; ?>
			  </div>			  
			</div>
			</div>
			<div class="quick-replay">
				<div class="js-quickreplydiv-<?php echo $message['Message']['id'];?>"></div>
			</div>
			<div class="modal hide fade" style="z-index:999999" id="js-ajax-modal-<?php echo $message['Message']['id'];?>">
				<div class="modal-body"></div>
				<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
			</div>
		  </li>
		   <?php
		endforeach;
	  else: ?>
					<div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('discussions'));?></p>
					</div>
	  <?php	endif;?>
	</ol>
<?php $flag=0;
				if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Open"){
				  if($message['Contest']['contest_status_id']==ConstContestStatus::Open){
				    $flag=1;
				  }
				}
				if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Judging"){
					if($message['Contest']['contest_status_id']==ConstContestStatus::Judging || $message['Contest']['contest_status_id']==ConstContestStatus::Open){
						$flag=1;
					}
				}
				if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="WinnerSelected"){
					if($message['Contest']['contest_status_id']<=ConstContestStatus::WinnerSelected || $message['Contest']['contest_status_id']==ConstContestStatus::Judging || $message['Contest']['contest_status_id']==ConstContestStatus::Open || $message['Contest']['contest_status_id']==ConstContestStatus::WinnerSelectedByAdmin){
						$flag=1;
					}
				}
				if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Completed"){
					if(($message['Contest']['contest_status_id']>=ConstContestStatus::Judging && $message['Contest']['contest_status_id']<=ConstContestStatus::Completed) || $message['Contest']['contest_status_id']==ConstContestStatus::Open){
						$flag=1;
					}
				}
				$contest_flag = 1;
				if(!empty($message['Contest']['admin_suspend'])){
					$contest_flag = 0;
				}
				if((($this->Auth->sessionValid() && !empty($flag))  || (!empty($message['Contest']['winner_user_id']) && $message['Contest']['winner_user_id'] == $this->Auth->user('id'))|| (($message['Contest']['user_id'] == $this->Auth->user('id')) &&  $message['Contest']['contest_status_id']<=ConstContestStatus::Completed)) && !empty($contest_flag)) {
					if($message['Contest']['user_id'] == $this->Auth->user('id')){
						$username=$message['User']['username'];
					}else{
						$username=$message['Contest']['User']['username'];
					}?>
					<div class="pull-left clearfix">
					<?php 
					echo $this->element('Contests.message-index',array('user'=>$username,'contest'=>$message['Contest'],'contest_user'=>$message['ContestUser'],'flag'=>$flag, 'cache' => array('config' => 'sec')));?>
					</div>
				<?php }?>
	</div>
<?php } ?>