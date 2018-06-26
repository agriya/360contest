<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
	<div class="accordion-admin-panel" id="js-admin-panel">
		<div class="clearfix js-admin-panel-head admin-panel-block">
			<div class="admin-panel-inner span3 pa accordion-heading no-mar no-bor clearfix box-head admin-panel-menu">
				<a data-toggle="collapse" data-parent="#accordion-admin-panel" href="#adminPanel" class="btn js-show-panel accordion-toggle span3 js-toggle-icon js-no-pjax blackc no-under clearfix"><i class="pull-right caret"></i><i class="icon-user"></i> <?php echo __l('Admin Panel'); ?></a>
			</div>
			<div class="accordion-body no-round no-bor collapse" id="adminPanel">
				<div id="ajax-tab-container-admin" class="accordion-inner thumbnail clearfix no-bor tab-container admin-panel-inner-block pr">
					<ul class="nav nav-tabs tabs clearfix">
						<li class="tab"><?php echo $this->Html->link(__l('Actions'), '#admin-actions',array('class' => 'js-no-pjax span2 js-no-pjax', 'title'=>__l('Actions'), 'data-toggle'=>'tab', 'rel' => 'address:/admin_actions')); ?></li>
						<li class="tab"><em></em><?php echo $this->Html->link(__l('Entries'), array('controller' => 'contest_users', 'action' => 'index', 'contestid'=>$contest['Contest']['slug'],'userview'=>true, 'admin' => true), array('title' => 'Entries admin', 'class' => ' js-no-pjax', 'data-target' => '#admin-entries-views', 'escape' => false)); ?></li>
						<?php if (isPluginEnabled('ContestFollowers')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(__l('Followers'), array('controller' => 'contest_followers', 'action' => 'index','contestid'=>$contest['Contest']['id'], 'admin' => true), array('title' => __l('Contest Follower'), 'class' => ' js-no-pjax', 'data-target' => '#admin-contest-followers', 'escape' => false));?></li>
						<?php } ?>
						<?php if (isPluginEnabled('EntryFlags')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(__l('Entry Flags'), array('controller' => 'contest_user_flags', 'action' => 'index','contestid'=>$contest['Contest']['id'], 'admin' => true), array('title' => __l('Entry Flags'), 'class' => ' js-no-pjax', 'data-target' => '#admin-entry-flags', 'escape' => false));?></li>
						<?php } ?>
						<?php if (isPluginEnabled('ContestFlags')) { ?>
						<li class="tab"><em></em><?php echo $this->Html->link(__l('Contest Flags'), array('controller' => 'contest_flags', 'action' => 'index','contest'=>$contest['Contest']['slug'], 'admin' => true),array('title' => __l('Contest Flags'), 'class' => ' js-no-pjax', 'data-target' => '#admin-contest-flags', 'escape' => false));?></li>
						<?php } ?>
						<li class="tab"><em></em><?php echo $this->Html->link(__l('Contest Views'), array('controller' => 'contest_views', 'action' => 'index','contest'=>$contest['Contest']['slug'], 'admin' => true),array('title' => __l('Contest Views'), 'class' => ' js-no-pjax', 'data-target' => '#admin-contest-views', 'escape' => false));?></li>
					</ul>
					<article class="panel-container clearfix pull-left">
					<div class="span24 tab-pane fade in active clearfix" id="admin-actions" style="display: block;">
						<ul class="unstyled clearfix">
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-edit"></i> '.__l('Edit'), array('controller'=>'contests','action' => 'edit', $contest['Contest']['id'], 'filter_id' => $contest['Contest']['contest_status_id'], 'admin'=>true), array('class' => 'btn blackc js-no-pjax','escape'=>false, 'title' => __l('Edit')));?></li>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove"></i> '.__l('Delete'), array('controller'=>'contests','action' => 'delete', $contest['Contest']['id'], 'admin'=>true), array('class' => 'btn blackc js-confirm', 'escape'=>false,'title' => __l('Delete')));?><?php echo $this->Layout->adminRowActions($contest['Contest']['id']);?></li>

							<?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval) {?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-flag"></i> '.__l('Reject'), Router::url(array('controller'=>'contests', 'action' => 'update_status', $contest['Contest']['id'], ConstContestStatus::Rejected, 'admin' => true), true).'?r='.$this->request->url, array('class' => 'btn blackc js-tooltip js-confirm','escape'=>false, 'title' => __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.')));?></li>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Change Status to Open'), Router::url(array('controller'=>'contests', 'action' => 'update_status', $contest['Contest']['id'], ConstContestStatus::Open, 'admin' => true), true).'?r='.$this->request->url, array('class' => 'btn blackc', 'escape'=>false, 'title' => __l('Change Status to Open')));?></li>
							<?php } ?>
							<?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::RefundRequest || ($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging )) {?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Cancel contest'), array('controller'=>'contests', 'action' => 'cancel_contest', $contest['Contest']['id'], 'admin'=>true), array('class' => 'btn blackc js-confirm js-tooltip', 'escape'=>false, 'title' => __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.')));?></li>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Reject request'),  Router::url(array('controller'=>'contests', 'action' => 'update_status', $contest['Contest']['id'], ConstContestStatus::Judging, 'type' => 'judging', 'admin' => true), true).'?r='.$this->request->url, array('class' => 'btn blackc', 'escape'=>false, 'title' => __l('Reject request')));?></li>
							<?php } ?>
							<?php if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::ChangeCompleted))) {?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Accept and Mark as Completed'),  Router::url(array('action' => 'update_status', $contest['Contest']['id'], ConstContestStatus::Completed, 'admin' => true),true).'?r='.$this->request->url, array('class' => 'btn blackc', 'escape' => false, 'title' => __l('Accept and Mark as Completed')));?></li>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Change Status to Paid To Participant'),  Router::url(array('action' => 'update_status', $contest['Contest']['id'],ConstContestStatus::PaidToParticipant, 'admin' => true),true).'?r='.$this->request->url, array('class' => 'btn blackc', 'escape'=>false, 'title' => __l('Change Status to Paid To Participant')));?></li>
							<?php } ?>
							<?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Judging))) { ?>
							<?php if (!empty($contest['Contest']['contest_user_count'])) { ?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Select Winner'),  array('controller' => 'contest_users', 'action' => 'index', 'contest_id' => $contest['Contest']['id'], 'type' => 'winner_select', 'filter_id' => 'winner', 'admin' => true), array('class' => 'btn blackc', 'escape' => false, 'title' => __l('Select Winner')));?></li>
							<?php } if ($contest['Contest']['contest_status_id'] == ConstContestStatus::Open) { ?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Change status to Pending Approval'),  Router::url(array('action' => 'update_status', $contest['Contest']['id'], ConstContestStatus::PendingApproval, 'admin' => true), true).'?r='.$this->request->url, array('class' => 'btn blackc', 'escape'=>false, 'title' => __l('Change status to Pending Approval')));?></li>
							<?php } ?>
							<?php } ?>
							<?php if($contest['Contest']['is_user_flagged']):?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Clear user flag'),  Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'userflag','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc js-no-pjax js-confirm clear-user-flag', 'escape'=>false, 'title' => __l('Clear user flag')));?></li>
							<?php endif;?>
							<?php if($contest['Contest']['is_system_flagged']):?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Clear system flag'),  Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'systemflag','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc js-no-pjax js-confirm clear-flag', 'escape'=>false, 'title' => __l('Clear system flag')));?></li>
							<?php else:?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Flag'), Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'flag','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc js-confirm js-no-pjax flag', 'escape'=>false, 'title' => __l('Flag')));?></li>
							<?php endif;?>
							<?php if($contest['Contest']['admin_suspend']):?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Unsuspend'), Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'unsuspend','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc js-confirm js-no-pjax unsuspend', 'escape'=>false, 'title' => __l('Unsuspend')));?></li>
							<?php else:?>
							<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="icon-remove-circle"></i> '.__l('Suspend'), Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'suspend','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc js-confirm js-no-pjax suspend', 'escape'=>false, 'title' => __l('Suspend')));?></li>
							<?php endif;?>
							<?php if(!empty($contestUser)){ ?>
							<?php if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active) { ?>
									<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="text-14 icon-ban-circle"></i>'.__l('Withdraw') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class' => 'btn blackc withdraw js-confirm js-no-pjax', 'title' => __l('Withdraw'), 'escape' => false)); ?></li>
									<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="text-14 icon-remove-circle"></i>'.__l('Eliminate') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class' => 'btn blackc eliminate  js-confirm js-no-pjax', 'title' => __l('Eliminate'), 'escape' => false)); ?></li>
							<?php } elseif ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && empty($contestUser['Contest']['winner_user_id'])) { ?>
									<li class="pull-left dc mspace"><?php echo $this->Html->link(__l('Cancel Withdraw') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class'=>'btn blackc withdraw js-confirm js-no-pjax','title' => __l('Cancel Withdraw'), 'escape' => false)); ?></li>
							<?php } elseif ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated && empty($contestUser['Contest']['winner_user_id'])) { ?>
									<li class="pull-left dc mspace"><?php echo $this->Html->link(__l('Cancel Eliminate') , Router::url(array('controller' => 'contest_users', 'action' => 'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin' => false),true).'?r='.$this->request->url , array('class' => 'btn blackc eliminate js-confirm js-no-pjax','title' => __l('Cancel Eliminate'), 'escape' => false)); ?></li>
							<?php } ?>
							<?php if (in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::ChangeCompleted))) {
										if($contestUser['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelectedByAdmin || !empty($contestUser['Contest']['is_pending_action_to_admin'])) {?>
										<li class="pull-left dc mspace"><?php echo $this->Html->link(__l('Accept and Mark as Completed'), Router::url(array('action' => 'update_status', $contestUser['Contest']['id'],ConstContestStatus::Completed),true).'?r='.$this->request->url, array('class' => 'btn blackc completed js-confirm js-no-pjax', 'title' => __l('Accept and Mark as Completed'), 'escape' => false)); ?></li>
							 <?php } } ?>
							 <?php if(($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed)){?>
										<li class="pull-left dc mspace"><?php echo $this->Html->link(__l('Change Status to Closed'), Router::url(array('action' => 'update_status', $contestUser['Contest']['id'], ConstContestStatus::PaidToParticipant,'admin' => true),true).'?r='.$this->request->url, array('class' => 'btn blackc paid-participant-link js-confirm js-no-pjax', 'title' => __l('Change Status to Closed'), 'escape' => false)); ?></li>
									<?php } ?>
							  <?php if(in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::Judging,ConstContestStatus::Open))  && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active) { ?>
									<li class="pull-left dc mspace"><?php echo $this->Html->link('<i class="text-14 icon-bookmark-empty"></i>'.__l('Select as winner') , array('controller' => 'contests', 'action' => 'update', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'user_id' => $contestUser['ContestUser']['id']) , array('class' => 'btn blackc won js-confirm js-no-pjax', 'title' => __l('Select as winner'), 'escape' => false)); ?></li>
							   <?php } ?>
							<?php } ?>
						</ul>
						<?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Judging,ConstContestStatus::Open))) { ?>
						  <?php if((!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_blind'])) || (!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_private'])) || (!empty($contest['ContestType']['is_featured']) && empty($contest['Contest']['is_featured'])) || (!empty($contest['ContestType']['is_highlight']) && empty($contest['Contest']['is_highlight']))) {?>
						  <div class="span space no-mar">
							<h4 class="ver-space dl"><?php echo __l('Additional Features'); ?></h4>
							<ul class="unstyled inline clearfix">
							  <?php if(!empty($contest['ContestType']['is_featured']) && empty($contest['Contest']['is_featured'])) {?>
							  <li><?php echo $this->Html->link('<i title="'. __l('Featuted') .'" class="icon-star text-13"></i> ' . __l('Featuted'), Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'featured','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc featured js-no-pjax', 'title' => __l('Featuted'), 'escape' => false))  . '<span class="js-tooltip" title="' . __l('Fee') . ': ' . $this->Html->siteCurrencyFormat($contest['ContestType']['featured_fee'], false) .'"><i class="icon-info-sign"></i></span>';?></li>
							  <?php }?>
							  <?php if(!empty($contest['ContestType']['is_blind']) && empty($contest['Contest']['is_blind'])) {?>
							  <li><?php echo $this->Html->link('<i title="'. __l('Blind') .'" class="icon-eye-close text-13"></i> ' . __l('Blind'), Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'blind','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc blind js-no-pjax', 'title' => __l('Blind'), 'escape' => false))  . '<span class="js-tooltip" title="' . __l('Fee') . ': ' . $this->Html->siteCurrencyFormat($contest['ContestType']['blind_fee'], false) .'"><i class="icon-info-sign"></i></span>';?></li>
							  <?php }?>
							  <?php if(!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_private'])) {?>
							  <li><?php echo $this->Html->link('<i title="'. __l('Private') .'" class="icon-lock text-13"></i> ' . __l('Private'), Router::url(array('action' => 'update_status',  $contest['Contest']['id'], 'status' => 'private','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc private js-no-pjax', 'title' => __l('Private'), 'escape' => false)) . '<span class="js-tooltip" title="' . __l('Fee') . ': ' . $this->Html->siteCurrencyFormat($contest['ContestType']['private_fee'], false) .'"><i class="icon-info-sign"></i></span>';?></li>
							  <?php }?>
								<?php if(!empty($contest['ContestType']['is_highlight']) && empty($contest['Contest']['is_highlight'])) {?>
									<li><?php echo $this->Html->link('<i title="'. __l('Highlight') .'" class="icon-signal text-13"></i> ' . __l('Highlight'), Router::url(array('action' => 'update_status', $contest['Contest']['id'], 'status' => 'highlight','admin'=>true),true).'?r='.$this->request->url, array('class' => 'btn blackc highlight js-no-pjax', 'title' => __l('Highlight'), 'escape' => false)) . '<span class="js-tooltip" title="' . __l('Fee') . ': ' . $this->Html->siteCurrencyFormat($contest['ContestType']['highlight_fee'], false) .'"><i class="icon-info-sign"></i></span>';?></li>
							  <?php }?>
							</ul>
						  </div>
						  <?php } ?>
						  <?php } ?>
					</div>
					<div class="tab-pane fade in active span23" id="admin-entries-views" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-contest-followers" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-entry-flags" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-contest-flags" style="display: block;"></div>
					<div class="tab-pane fade in active span23" id="admin-contest-views" style="display: block;"></div>
					</article>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>