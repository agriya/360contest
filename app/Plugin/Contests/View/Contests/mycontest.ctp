<div class="contests index js-response">
<div class="container"><h2 class="ver-space ver-mspace">
	<?php
		if(empty($this->pageTitle)):
			echo __l('Contests');
		else:
			echo $this->pageTitle;
		endif;
	?>
</h2></div>
<?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
<div class="container">
<?php echo $this->element('contest-status-chart', array('is_admin' => 0, 'cache' => array('config' => 'sec')));?>
  	 <?php
        	echo $this->Form->create('Contest' , array('class' => 'normal'));
        	echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
        ?>
<?php echo $this->element('paging_counter'); ?>
	<?php
		$view_count_url = Router::url(array(
			'controller' => 'contests',
			'action' => 'update_view_count',
		), true);
	?>
	<table class=" table table-striped sep list js-view-count-update {'model':'contest','url':'<?php echo $view_count_url; ?>'}">
		<tr>
			<?php if (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::Rejected)))){ ?>
		    <th class="actions"><?php echo __l('Action');?></th>
			<?php } ?>
			<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name'));?></div></th>
			<?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Open, ConstContestStatus::Rejected, ConstContestStatus::RefundRequest, ConstContestStatus::CanceledByAdmin, ConstContestStatus::Judging))):?>
			<th class="dc"><?php echo __l('Winner');?></th>
			<?php endif; ?>
			<?php if((!empty($this->request->params['named']['filter_id'])&& ($this->request->params['named']['filter_id']!= ConstContestStatus::PendingApproval && $this->request->params['named']['filter_id']!= ConstContestStatus::PaymentPending))&&(!empty($this->request->params['named']['filter_id'])&& ($this->request->params['named']['filter_id']!= ConstContestStatus::Rejected))):?>
			<th class="dc"><?php echo $this->Paginator->sort('actual_end_date', __l('Ends On'));?></th>
			<?php endif;?>
			<?php if(!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id']!=ConstContestStatus::PaymentPending)):?>
			<th class="dr"><?php echo $this->Paginator->sort(sprintf('%s ('.Configure::read('site.currency').')', __l('Prize'))); ?></th>
			<?php endif;?>
			<th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_view_count',__l('Views'));?></div></th>
			<?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval))):?>
			<th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count', __l('Entries'));?></div></th>
			<th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('message_count',__l('Messages'));?></div></th>
			<?php endif;?>
 	</tr>
	<?php
	if (!empty($contests)):
	$i = 0;
	foreach ($contests as $contest):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
		<?php $contest_flag = 1;
		$flag_class = 0;
		$line_class = 'line-class';
		if(!empty($contest['Contest']['admin_suspend'])){
			$contest_flag = 0;
		}?>
		<tr<?php echo $class;?>>
		<?php if (empty($this->request->params['named']['filter_id']) ||  !empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::Rejected))) { ?>
		<td  class="dc span1">
					<?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::Rejected) {
						echo '-';
					}else{ ?>
					

        	<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
              <ul class="dropdown-menu dl arrow">
                	                       <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending || $contest['Contest']['contest_status_id'] == ConstContestStatus::CanceledByAdmin) {
                           $flag_class = 1;?>
							<li>
								<?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $contest['Contest']['id'],'type'=> $this->request->params['named']['type'],'filter_id'=>$this->request->params['named']['filter_id']), array('class' => 'delete js-confirm js-no-pjax','escape'=>false, 'title' => __l('Delete'))); ?>
								<?php echo $this->Layout->adminRowActions($contest['Contest']['id']);?>
							</li>
							<?php } ?>
	                       <?php if(($contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending)||($contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval)):?>
							<li>
								<?php echo $this->Html->link('<i class="icon-pencil blackc"></i>'.__l('Edit'), array('controller'=>'contests','action'=>'edit', $contest['Contest']['id'], 'filter_id' => $contest['Contest']['contest_status_id']), array('class' => 'edit js-edit','escape'=>false, 'title' => __l('Edit')));?>
							</li>
							<?php $flag_class = 1;
                            endif;?>
							<?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation && $contest['Contest']['is_uploaded_entry_design']) { ?>
								<li><?php echo $this->Html->link('<i class="icon-ok blackc"></i>'.__l('Download and Accept as Completed'), array('controller' => 'contests', 'action' => 'accept_as_completed', $contest['Contest']['id']), array('class' => 'download js-no-pjax', 'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false, 'title' => __l('Accept as Completed')))?></li>
							<?php 
                            } ?>
							<?php if(($contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending) && !empty($contest_flag)):?>
							<li>
								<?php echo $this->Html->link('<i class="icon-money blackc"></i>'.__l('Pay'), array('controller'=>'contests','action'=>'prizing_selection',$contest['Contest']['id']), array('class'=>'pay-icon ','escape' => false,'title'=>__l('Pay')))?>
							</li>
							<?php $flag_class = 1;
                            endif;?>
							<?php if (!empty($contest['Contest']['is_uploaded_entry_design']) && ($contest['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation) && $contest['Contest']['user_id'] == $this->Auth->user('id')) { ?>
								<li><?php echo $this->Html->link('<i class="icon-retweet blackc"></i>'.__l('Ask to resend final deliverables'), array('controller' => 'contests', 'action' => 'reupload_entry_design', $contest['Contest']['id'],$contest['Contest']['slug']), array('class' => 'reupload-link js-confirm js-no-pjax', 'escape' => false, 'title' => __l('Ask to resend final deliverables')))?></li>
							<?php } ?>
							<?php if (!empty($contest['Contest']['is_uploaded_entry_design']) && (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Completed, ConstContestStatus::PaidToParticipant))) && $contest['Contest']['user_id'] == $this->Auth->user('id')) { ?>
								<li><?php echo $this->Html->link('<i class="icon-ok blackc"></i>'.__l('Download Entry Design'), array('controller' => 'contests', 'action' => 'download_entry', $contest['Contest']['id'],$contest['EntryAttachment']['id']), array('class' => 'reupload-link js-no-pjax', 'escape' => false, 'title' => __l('Download Entry Design')))?></li>
							<?php } ?>
                            <?php if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected)) && empty($contest['Contest']['is_pending_action_to_admin']) && !empty($contest_flag)) { ?>
							<li>
								<?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>'.__l('Request for change'), array('controller'=>'contests','action'=>'view',$contest['Contest']['slug'],'#Request_for_Change'), array('class'=>'request-change','escape' => false, 'title' => 'Request for change'))?>
							</li>
							<?php $flag_class = 1;
                            } ?>
							<?php
								if(Configure::read('contest.enable_request_for_cancellation_type')){
								$condition = true;
								if(Configure::read('ContestUser.request_refund_entry_limit') != '' && Configure::read('contest.enable_request_for_cancellation_type') == 'Entries'){
									$condition = ($contest['Contest']['contest_user_count'] <= Configure::read('ContestUser.request_refund_entry_limit'));
								}
								elseif(Configure::read('ContestUser.request_refund_entry_limit') != '' && Configure::read('contest.enable_request_for_cancellation_type') == 'Users'){
									$condition = ($contest['Contest']['partcipant_count'] <= Configure::read('ContestUser.request_refund_entry_limit'));
								}
								elseif(Configure::read('ContestUser.request_refund_entry_limit') != '' && Configure::read('contest.enable_request_for_cancellation_type') == 'Entries or Users'){
									$condition = (($contest['Contest']['partcipant_count'] <= Configure::read('ContestUser.request_refund_entry_limit')) || ($contest['Contest']['contest_user_count'] <= Configure::read('ContestUser.request_refund_entry_limit')));
								}
								if($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging && !empty($contest_flag) && empty($contest['Contest']['reason_for_cancelation']) && $condition){ ?>
							<li>
								<?php echo $this->Html->link('<i class="icon-undo blackc"></i>'.__l('Request for Cancellation'), array('controller'=>'contests','action'=>'request_refund',$contest['Contest']['id']), array('class'=>'request-refund ','escape' => false))?>
							</li>
							<?php $flag_class = 1;
                            } 
							}?>
							<?php if(($contest['Contest']['contest_status_id'] == ConstContestStatus::Open || ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging && empty($contest['Contest']['is_pending_action_to_admin']))) && ($contest['Contest']['contest_user_count']>0) && !empty($contest_flag)){	?>
							<li>
									<?php echo $this->Html->link('<i class="icon-thumbs-up blackc"></i>'.__l('Select Winner'), array('controller'=> 'contests', 'action' => 'view', $contest['Contest']['slug'].'#entries', 'admin' => false), array('class'=>'won', 'escape' => false)) ?>
								</li>
							<?php $flag_class = 1;
                            }?>
							<?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::Open && !empty($contest_flag)) {?>
							<?php if((!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_blind'])) || (!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_private'])) || (!empty($contest['ContestType']['is_featured']) && empty($contest['Contest']['is_featured'])) || (!empty($contest['ContestType']['is_highlight']) && empty($contest['Contest']['is_highlight']))) {?>
								<li>
									<?php echo $this->Html->link('<i class="icon-cog blackc"></i>'.__l('Upgrade Features'), array('controller'=> 'contests', 'action' => 'upgrade_features', $contest['Contest']['id'], 'admin' => false), array('title' => __l('Upgrade Features'), 'class'=>'upgrade', 'escape' => false)) ?>
								</li>
								<?php } ?>
							<?php }?>
							<?php if(($contest['Contest']['contest_status_id'] == ConstContestStatus::Open || $contest['Contest']['contest_status_id'] == ConstContestStatus::Judging)&& !empty($contest_flag)) {?>
								<li>
									<?php echo $this->Html->link('<i class="icon-time blackc"></i>'.__l('Extend Time'), array('controller'=> 'contests', 'action' => 'extend_time', $contest['Contest']['id'], 'admin' => false), array('title' => __l('Extend Time'), 'class'=>'time', 'escape' => false)) ?>
								</li>
							<?php }?>
                            <?php if(((!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] >=ConstContestStatus::WinnerSelected) ||($contest['Contest']['contest_status_id'] >=ConstContestStatus::WinnerSelected) && empty($contest['Contest']['is_pending_action_to_admin'])) && $contest['Contest']['contest_status_id'] != ConstContestStatus::Completed) { ?>
							<li>
								<?php echo $this->Html->link('<i class="icon-envelope blackc"></i>'.__l('Contact Winner'), Router::url('/', true) . 'contest/'.$contest['Contest']['slug'].'/type:winner#message-board', array('class' => 'won','escape'=>false)); ?>
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

							<?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::Open && isPluginEnabled('SocialMarketing')) {?>
							<li>
								<?php echo $this->Html->link('<i class="icon-share blackc"></i> '.__l('Share'), array('controller'=> 'social_marketings', 'action' => 'publish', $contest['Contest']['id'], 'type' => 'facebook', 'publish_action' => 'add', 'admin' => false), array('class' => 'share','title' => 'Share','escape'=>false)); ?>
							</li>
							<?php } ?>
 <?php if (!in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))) { ?>
							<li  class="sep-top"><?php echo $this->Html->link('<i class="icon-list blackc"></i>'.__l('Entries ('.$contest['Contest']['contest_user_count'].')'), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'].'#entries'),array('escape'=>false,'title' => __l('Entries ('.$contest['Contest']['contest_user_count'].')')));?></li>
							 <li><?php echo $this->Html->link('<i class="icon-group blackc"></i>'.__l('Followers ('.$contest['Contest']['contest_follower_count'].')'), array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#followers'),array('escape'=>false,'title' => __l('Followers ('.$contest['Contest']['contest_follower_count'].')')));?></li>
							 <li><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.Configure::read('contest.participant_alt_name_plural_caps').' ('.$contest['Contest']['partcipant_count'].')', array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#participants'),array('escape'=>false,'title' => Configure::read('contest.participant_alt_name_plural_caps').' ('.$contest['Contest']['partcipant_count'].')'));?></li>
							 <li><?php echo $this->Html->link('<i class="icon-time blackc"></i>'.__l('Activities'), array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#activities'),array('title' => __l('Activities'),'escape'=>false));?></li>
							 <li><?php echo $this->Html->link('<i class="icon-comments blackc"></i>'.__l('Discussions ('.$contest['Contest']['message_count'].')'), array('controller' => 'contests', 'action' => 'view',$contest['Contest']['slug'].'#message-board'),array('title' => __l('Discussions'),'escape'=>false));?></li>
							<?php } ?>				
              </ul>
			 					
        </div>		
			<?php } ?>
    		</td>
			<?php } ?>
			<td class="dl">
				<div class="status-block clearfix">
					<div class="status-block-inner">
						<?php if(!empty($contest['ContestStatus']['name'])) { ?>
							<?php
								$class = $contest['ContestStatus']['slug'];
								if ($contest['ContestStatus']['slug'] == 'pending-action-to-admin'):
									$class .= 's';
								endif;
							?>
							<span class="<?php echo $class;?>" title="<?php echo $contest['ContestStatus']['name'];?>"><?php echo  $this->Html->cText($contest['ContestStatus']['name']);?></span>
							<?php if(!empty($contest['Contest']['is_pending_action_to_admin'])){?>
								<span class="pending-action-to-admin" title="<?php echo __l('Pending Action to Admin'); ?>"><?php echo __l('Pending Action to Admin');?></span>
							<?php } ?>
						<?php } else {?>
							<span class="inactive"><?php echo __l('Inactive');?></span>
						<?php } ?>
					</div>
					<?php echo $this->Html->link($this->Html->cText($contest['Contest']['name'],false), array('controller'=> 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($contest['Contest']['name'],false)));?>
				</div>
				<div class="clearfix ver-smspace">
					<span class="label-category hor-space"><?php echo $this->Html->cText($contest['ContestType']['name']);?></span>
				</div>
				<div class="contest-title-margin">
					<div class="status-block grayc">
						<div class="other-fee-block">
							<?php if(!empty($contest['Contest']['is_private'])){?>
								<i class="icon-lock text-12" title="Private"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_blind'])){?>
								<i class="icon-eye-close text-12"  title="Blind"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_featured'])){?>
								<i class="icon-star text-12" title="Featured"></i>
							<?php } ?>
							<?php if(!empty($contest['Contest']['is_highlight'])){?>
								<i class="icon-signal text-12" title="Highlighted"></i>
							<?php } ?>
							<?php if(Configure::read('contest.enable_request_for_cancellation') && $contest['Contest']['contest_status_id'] == ConstContestStatus::Judging && $contest['Contest']['contest_user_count'] <= Configure::read('ContestUser.request_refund_entry_limit') && !empty($contest_flag) && !empty($contest['Contest']['reason_for_cancelation'])) { ?>
								<i class="icon-question-sign text-12 js-tooltip" title="<?php echo __l('You have already requested for cancellation. Admin rejected your request');?>"></i>
							<?php } ?>
						</div>
					</div>
				</div>
            </td>
			<?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Open, ConstContestStatus::Rejected, ConstContestStatus::RefundRequest, ConstContestStatus::CanceledByAdmin, ConstContestStatus::Judging))):?>
			<td class="dc">
				<?php
					if($contest['Contest']['contest_status_id'] >=ConstContestStatus::WinnerSelected) {
						echo $this->Html->getUserAvatarLink(!empty($contest['ContestUser'][0]['User'])?$contest['ContestUser'][0]['User']:array(), 'micro_thumb',true);
						echo $this->Html->getUserLink(!empty($contest['ContestUser'][0]['User'])?$contest['ContestUser'][0]['User']:array());
					} else {
						echo '-';
					}
					?>
			</td>
			<?php endif; ?>
             <?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array(ConstContestStatus::PendingApproval, ConstContestStatus::PaymentPending,ConstContestStatus::Rejected))): ?>
			<td class="dc">
				<?php if (!in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))) {
					if($contest['Contest']['actual_end_date'] == '0000-00-00 00:00:00') {
						 echo '-';
					}
					else{
					 echo $this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']);
					}
				 } else {
					 echo '-';
				 } ?>
				</td>
			<?php endif;?>
			<?php if(!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id']!=ConstContestStatus::PaymentPending)):?>
			<td class="dr"><?php echo $this->Html->cCurrency($contest['Contest']['prize']);?></td>
			<?php endif;?>
			<td class="dc js-view-count-contest-id js-view-count-contest-id-<?php echo $contest['Contest']['id']; ?> {'id':'<?php echo $contest['Contest']['id']; ?>'}"><?php echo $this->Html->cInt($contest['Contest']['contest_view_count']);?></td>
			<?php if (!empty($this->request->params['named']['filter_id']) && !in_array($this->request->params['named']['filter_id'], array('entry', ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval))):?>
			<td class="dc">
				<?php echo $this->Html->link(__l($contest['Contest']['contest_user_count']), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'].'#entries', 'admin' => false),array('title' => __l('Entries ('.$contest['Contest']['contest_user_count'].')')));?>
			</td>
			<td class="dc">
				<?php echo $this->Html->link(__l($contest['Contest']['message_count']), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'].'#message-board', 'admin' => false),array('title' => __l('Messages ('.$contest['Contest']['message_count'].')')));?>
			</td>
			<?php endif;?>
   		</tr>
	<?php
		endforeach;
	else:
	?>
		<tr>
			<td colspan="10"><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Contests'));?></p>
					</div></td>
		</tr>
	<?php
	endif;
	?>
	</table>
<div class="offset9  clearfix">
      <div class="js-pagination ">
        <?php if (!empty($contests)) {
           echo $this->element('paging_links');
          }
        ?>
   </div>

</div>
<?php
    echo $this->Form->end();
?>
</div>
</div>
<div class="modal hide fade" id="js-ajax-modal">
    <div class="modal-body"></div>
	<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
</div>
