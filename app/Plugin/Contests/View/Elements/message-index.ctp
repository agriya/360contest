<?php
$emtry_view_flag = 1;
if(!empty($contest_user) && $contest_user['contest_user_status_id'] != ConstContestUserStatus::Won){
	$emtry_view_flag = 0;
}
if($emtry_view_flag || !empty($flag)){
	if (((($contest['contest_status_id'] == ConstContestStatus::WinnerSelected || $contest['contest_status_id'] == ConstContestStatus::ChangeCompleted) && $this->Auth->user('id') == $contest['user_id'] && !empty($emtry_view_flag )) || ($contest['contest_status_id'] == ConstContestStatus::ChangeRequested && $this->Auth->user('id') == $contest['winner_user_id']) && !empty($emtry_view_flag )) && empty($contest['is_pending_action_to_admin']) || $contest['contest_status_id'] == ConstContestStatus::FilesExpectation) { ?>
	<div id="ajax-tab-container-comment" class='tab-container pr'>
		<ul class="nav nav-tabs tabs">
				<?php if(!empty($contest_user)){ ?>
					<li class="tab first-child">
					<?php echo $this->Html->link(__l('Post comment'), array('controller'=>'messages','action'=>'compose','user' => $user,'contest_id'=>$contest['id'],'contest_type'=>$contest_user['entry_no'], 'admin' => false),array('class'=>'js-no-pjax', 'title' =>  __l('Post comment'),'data-target'=>'#post-comment', 'escape' => false)); ?>
					</li>
				<?php } else { ?>
					<?php if(!empty($this->request->params['named']['type'])) { ?>
						<li class="tab first-child">
						<?php echo $this->Html->link(__l('Post comment'), array('controller'=>'messages','action'=>'compose','user' => $user,'contest_id'=>$contest['id'],'contest_type'=>$this->request->params['named']['type'], 'admin' => false),array('class'=>'js-no-pjax', 'title' =>  __l('Post comment'),'data-target'=>'#post-comment', 'escape' => false)); ?>
						</li>
					<?php } else { ?>
						<li class="tab first-child">
						<?php echo $this->Html->link(__l('Post comment'), array('controller'=>'messages','action'=>'compose','user' => $user,'contest_id'=>$contest['id'], 'admin' => false),array('class'=>'js-no-pjax', 'title' =>  __l('Post comment'),'data-target'=>'#post-comment', 'escape' => false)); ?>
						</li>
					<?php } ?>
				<?php } ?>
				<?php if ($this->Auth->user('id') == $contest['user_id'] && ($contest['contest_status_id'] == ConstContestStatus::WinnerSelected || $contest['contest_status_id'] == ConstContestStatus::ChangeCompleted)) { ?>
					<li class="tab">
					<?php echo $this->Html->link(__l('Request for Change'), array('controller'=>'messages','action'=>'compose','user' => $user,'contest_id'=>$contest['id'], 'type' => 'request', 'admin' => false),array('class'=>'js-no-pjax', 'title' =>  __l('Request for Change'),'data-target'=>'#Request_for_Change', 'escape' => false)); ?>
					</li>
				<?php } ?>
				<?php if ($this->Auth->user('id') == $contest['winner_user_id'] && $contest['contest_status_id'] == ConstContestStatus::ChangeRequested) { ?>
					<li class="tab">
					<?php echo $this->Html->link(__l('Send Revised Entry'), array('controller'=>'messages','action'=>'compose','user' => $user,'contest_id'=>$contest['id'], 'type' => 'revised_entry', 'admin' => false),array('class'=>'js-no-pjax', 'title' =>  __l('Send Revised Entry'),'data-target'=>'#Send_Revised_Entry', 'escape' => false)); ?>
					</li>
				<?php } ?>
				<?php if ($contest['contest_status_id'] == ConstContestStatus::FilesExpectation && $this->Auth->user('id') == $contest['winner_user_id'] && empty($contest['is_uploaded_entry_design'])) { ?>
					<li class="tab">
					<?php echo $this->Html->link(__l('Upload Final Deliverables'), array('controller'=>'contests', 'action'=>'entry_design', $contest['id'], $contest['slug'], 'admin' => false),array('class'=>'js-no-pjax', 'title' =>  __l('Upload Entry Design'),'data-target'=>'#Upload_Entry_Design', 'escape' => false)); ?>
					</li>
				<?php } ?>
			</ul>
			<div class="tab-content panel-container">
				<div class="tab-pane fade in active" id="post-comment" style="display: block;">
				</div>
				<div class="tab-pane fade in active" id="Request_for_Change" style="display: block;"></div>
				<div class="tab-pane fade in active" id="Send_Revised_Entry" style="display: block;"></div>
				<div class="tab-pane fade in active" id="Upload_Entry_Design" style="display: block;"></div>
			</div>
		</div>
	<?php  } else { ?>
		<?php
			if(!empty($contest_user)){
				echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose'), array('named' =>array('user'=>$user, 'contest_id'=>$contest['id'],'contest_type'=>$contest_user['entry_no']),'return'));
			} else {
				if(!empty($this->request->params['named']['type'])) {
					echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose'), array('named' =>array('user'=>$user, 'contest_id'=>$contest['id'], 'type' => $this->request->params['named']['type'] ),'return'));
				} else {
					echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose'), array('named' =>array('user'=>$user, 'contest_id'=>$contest['id']),'return'));
				}
			}
		?>
	<?php } ?>
<?php } ?>
