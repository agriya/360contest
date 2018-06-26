<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contests index js-response">
<div class="container"><h2 class="ver-space ver-mspace">
	<?php
		if(empty($this->pageTitle)):
			echo __l('Contests ');
		else:
		 echo $this->pageTitle;
		endif;
	?>
</h2></div>
<?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
<div class="container">
<div class="clearfix contest-entry-view-block offset4">
<?php echo $this->element('entry-status-chart', array('is_admin' => 0, 'cache' => array('config' => 'sec')));?>
</div>
	<?php
		echo $this->Form->create('ContestUser' , array('class' => 'normal','action' => 'moreaction_update_status'));
		echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
	?>
	<?php echo $this->element('paging_counter'); ?>
	<?php
		$view_count_url = Router::url(array(
			'controller' => 'contest_users',
			'action' => 'update_view_count',
		), true);
	?>
	<table class="table table-striped table-hover {'model':'contest_user','url':'<?php echo $view_count_url; ?>', 'minHeight':120, 'maxHeight':150, 'maxWidth':150}">
		<tr>
			<th class="actions"><?php echo __l('Actions');?></th>
			<th><?php echo __l('Entry');?></th>
			<?php if($this->request->params['named']['type'] == 'contest_holder'):?>
 	  	    <th><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', Configure::read('contest.participant_alt_name_singular_caps').' '.__l('Name'));?></div></th>
 	  	    <?php endif;?>
			<th><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.name', __l('Contest'));?></div></th>
			<th class="dl"><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps');?></th>
			<th><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
			<?php if (isPluginEnabled('EntryRatings')) { ?>
			<th><?php echo  __l('Rating');?></th>
			<?php } ?>
			<th><?php echo  __l('View Count');?></th>
			<th><?php echo  __l('Message Count');?></th>
			<?php if(!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstContestStatus::PaidToParticipant)) {?>
			<th><?php echo  __l('Earned Amount');?></th>
			<?php } ?>
		</tr>
	<?php
	if (!empty($contestUsers)):

	$i = 0;
	foreach ($contestUsers as $contestUser):
	 $class = null;
		if ($i++ % 2 == 0) {
			$class = "altrow";
		}
		$status_class='';
		if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
				$status_class='eliminate-img';
		}
		if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
			$status_class='withdrawn';
		}
		$zoom_class='gp-gallery-hover';
	?>
		<tr class="<?php echo $class;?>">
				<td class="actions dc">
					<?php if (!empty($contestUser['ContestUser']['admin_suspend'])): ?>
						<span class="round-3 entry-suspended"><?php echo __l('Suspended by Admin'); ?></span>
					<?php endif; ?>
					<?php
						$entry_flag = 1;
						$contest_flag = 1;
						if(!empty($contestUser['ContestUser']['admin_suspend'])){
							$entry_flag = 0;
						}
						if(!empty($contestUser['Contest']['admin_suspend'])){
							$contest_flag = 0;
						}
						if (!empty($entry_flag) && !empty($contest_flag)) {
					?>



					<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
						<ul class="dropdown-menu dl arrow">
							<?php
                    		$flag_class = 0;
                    		$line_class = 'line-class';
							$flag=0;
							if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Open"){
								if($contestUser['Contest']['contest_status_id']==ConstContestStatus::Open){
									$flag=1;
								}
							}
							if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Judging"){
								if($contestUser['Contest']['contest_status_id']==ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id']==ConstContestStatus::Open){
									$flag=1;
								}
							}
							if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="WinnerSelected"){
								if($contestUser['Contest']['contest_status_id']<=ConstContestStatus::WinnerSelected || $contestUser['Contest']['contest_status_id']==ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id']==ConstContestStatus::Open || $contestUser['Contest']['contest_status_id']==ConstContestStatus::WinnerSelectedByAdmin){
									$flag=1;
								}
							}
							if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Completed"){
								if(($contestUser['Contest']['contest_status_id']>=ConstContestStatus::Judging && $contestUser['Contest']['contest_status_id']<=ConstContestStatus::Completed) || $contestUser['Contest']['contest_status_id']==ConstContestStatus::Open){
									$flag=1;
								}
							}
							 if($contestUser['ContestUser']['contest_user_status_id'] != ConstContestUserStatus::Won){
								?>
							<li><?php
                            $flag_class = 1;
                            echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete') , array('action' => 'delete', $contestUser['ContestUser']['id']) , array('class' => 'delete js-confirm', 'title' => __l('Delete'), 'escape' => false)); ?><?php echo $this->Layout->adminRowActions($contestUser['ContestUser']['id']); ?></li>
							<?php
							 }
							?>
	                      	<?php if ($this->request->params['named']['type'] == 'contest_holder'):?>
									<?php if(($contestUser['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending)||($contestUser['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval)):?>
        								<?php if(($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
                                        ?>
                                        <li>
                                        <?php
                                            $flag_class = 1;
                                            echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Eliminate This Entry'), Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated),true).'?r='.$this->request->url, array('class' => 'eliminate js-confirm', 'title' => __l('Eliminate This Entry'), 'escape' => false));
                                        ?>
                                        </li>
                                    <?php endif;
        						endif;
        						elseif($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active):?>
                                <li>
                                <?php
                                    $flag_class = 1;
                                    echo $this->Html->link('<i class="icon-repeat blackc"></i>'.__l('Withdraw This Entry'), Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn),true).'?r='.$this->request->url, array('class' => 'withdraw js-confirm', 'title' => __l('Withdraw This Entry'), 'escape' => false));
                                ?>
                                </li>
                              	<?php  endif;
								if(!empty($contest_flag) && (!empty($flag) || (!empty($contestUser['Contest']['winner_user_id']) && $contestUser['Contest']['winner_user_id'] == $this->Auth->user('id')))) {?>
									<li>
									<?php $flag_class = 1;
                                    echo $this->Html->link('<i class="icon-phone blackc"></i>'.sprintf(__l('Contact %s'), Configure::read('contest.contest_holder_alt_name_singular_caps')), array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'], '#message-board'), array('class' => 'contact-holder js-no-pjax', 'escape' => false)); ?>
									</li>
								<?php }?>
								<?php if (empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation && $contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) { ?>
									<li><?php echo $this->Html->link('<i class="icon-upload blackc"></i>'.__l('Upload Final Deliverables'), array('controller' => 'contests', 'action' => 'view',$contestUser['Contest']['slug'],"#Upload_Entry_Design"), array('class' => 'upload-link js-no-pjax', 'escape' => false, 'title' => __l('Upload Entry Design'), 'escape' => false)); ?></li>
								<?php } ?>
							<?php if($contestUser['Contest']['contest_status_id'] == ConstContestStatus::ChangeRequested && $contestUser['ContestUserStatus']['id'] != ConstContestUserStatus::Lost): ?>
                				<li><?php echo $this->Html->link('<i class="icon-refresh blackc"></i>'.__l('Send Revised Entry'),array('controller'=>'contests','action'=>'view',$contestUser['Contest']['slug'],'#Send_Revised_Entry'),array('class'=>'revised-entry js-no-pjax', 'title' => __l('Send Revised Entry'), 'escape' => false));?></li>
                			   <?php endif;?>

                                  <?php if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) {?>
                                    <li>
                			          <?php $flag_class = 1;
                                      echo $this->Html->link('<i class="icon-upload blackc"></i>'.__l('Cancel Withdrawn'), Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Active, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$this->request->url, array('class' => 'js-confirm withdraw js-no-pjax', 'title' => __l('Cancel Withdrawn'), 'escape' => false));?>
									</li>
                       			<?php }?>
                       <?php 
                            $plugin = $contestUser['Contest']['Resource']['name'] . 'Resources';
                            if (isPluginEnabled($plugin) && $contestUser['Contest']['resource_id'] == ConstResource::Video && $contestUser['Upload'][0]['upload_status_id'] == ConstUploadStatus::Processing) { ?>
                                <li><?php echo $this->Html->link('<i class="icon-refresh blackc"></i>'.__l('Check Status'), array('controller' => 'uploads', 'action' => 'check_status', $contestUser['Upload'][0]['id']),array('title' => __l('Check Status'), 'escape' => false, 'class'=>'js-confirm check-status'));?></li>
                        <?php } else if (isPluginEnabled($plugin) && $contestUser['Contest']['resource_id'] == ConstResource::Audio && $contestUser['AudioUpload'][(count($contestUser['AudioUpload']) -1)]['upload_status_id'] == ConstUploadStatus::Processing) { ?>
                                <li><?php echo $this->Html->link('<i class="icon-refresh blackc"></i>'.__l('Check Status'), array('controller' => 'audio_uploads', 'action' => 'check_status', $contestUser['AudioUpload'][(count($contestUser['AudioUpload']) -1)]['id']),array('title' => __l('Check Status'), 'escape' => false, 'class'=>'js-confirm check-status'));?></li>
                        <?php } ?>
						 <?php if(!empty($contest_flag)){
                         if(!empty($flag_class)){
                            $line_class = '';
                        } ?>

							<li  class="sep-top"><?php echo $this->Html->link('<i class="icon-list blackc"></i>'.__l('Entries (' . $contestUser['Contest']['contest_user_count'] . ')') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#entries', 'admin' => false) , array('title' => __l('Entries (' . $contestUser['Contest']['contest_user_count'] . ')'), 'escape' => false)); ?></li>
							<li><?php echo $this->Html->link('<i class="icon-group blackc"></i>'.__l('Followers (' . $contestUser['Contest']['contest_follower_count'] . ')') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#followers', 'admin' => false) , array('title' => __l('Followers (' . $contestUser['Contest']['contest_follower_count'] . ')'), 'escape' => false)); ?></li>
							<li><?php echo $this->Html->link('<i class="icon-user blackc"></i>'.Configure::read('contest.participant_alt_name_plural_caps') . ' (' . $contestUser['Contest']['partcipant_count'] . ')', array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#participants', 'admin' => false) , array('escape' => false, 'title' => Configure::read('contest.participant_alt_name_plural_caps') . ' (' . $contestUser['Contest']['partcipant_count'] . ')')); ?></li>
							<li><?php echo $this->Html->link('<i class="icon-time blackc"></i>'.__l('Activities') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#activities', 'admin' => false) , array('title' => __l('Activities'), 'escape' => false)); ?></li>
							<li><?php echo $this->Html->link('<i class="icon-comments blackc"></i>'.__l('Discussions (' . $contestUser['ContestUser']['message_count'] . ')') , array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'] . '#message-board', 'admin' => false) , array('title' => __l('Discussions (' . $contestUser['ContestUser']['message_count'] . ')'), 'escape' => false)); ?></li>

						<?php } ?>
						</ul>
					</div>
			<?php
				} else {
					echo '-';
				}
			?>
			</td>
			<td>
				<div class="clearfix <?php echo $status_class; ?> ">
                    <div class="entry-img-block <?php echo $zoom_class;?>">
					<ul class="pictures thumbnails row clearfix contest-list no-mar ver-space {'minHeight':142, 'maxHeight':182, 'maxWidth':700, 'column':4}">
						<?php
						$plugin =$contestUser['Contest']['Resource']['name']."Resources";
        				if (isPluginEnabled($plugin )) {?>
					       <li class="span5 no-mar pr">
						   <div class="picture-img thumbnail sep-bot no-round" style="height: 122px; width: 162px;">
				<?php echo $this->element($contestUser['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $contestUser, 'cache' => array('config' => 'sec')),array('plugin' => $plugin ));?></li>
			 <ul> </div>
						<?php }?>
                    </div>
                     </div>
            </td>
				<?php if($this->request->params['named']['type'] == 'contest_holder'):?>
			<td><?php echo $this->Html->link($this->Html->cText($contestUser['User']['username']), array('controller'=> 'users', 'action' => 'view', $contestUser['User']['username'], 'admin' => false), array('escape' => false));?>
            <?php echo $this->Html->getUserAvatarLink($contestUser['User'], 'micro_thumb',true);?>
            </td>
			<?php endif;?>
			<td>
            <div class="status-block grid_left"><div class="status-block-inner">
				<span class="<?php echo $contestUser['Contest']['ContestStatus']['slug']; ?>" title="<?php echo $contestUser['Contest']['ContestStatus']['name']; ?>"><?php echo $contestUser['Contest']['ContestStatus']['name']; ?></span>
			</div></div>
			<div class="status-block"><div class="status-block-inner">
			<?php
				if($contestUser['ContestUser']['admin_suspend']):
					echo '<span class="suspended round-5" title="'.__l('Admin Suspended').'">'.__l('Admin Suspended').'</span>';
				endif;
			?>
			</div></div>
                 <?php
				 if (!empty($contest_flag)) {
					echo $this->Html->link($this->Html->cText($contestUser['Contest']['name']), array('controller'=> 'contests', 'action' => 'view', $contestUser['Contest']['slug'], 'admin' => false), array('escape' => false));
				 } else {
					 echo $this->Html->cText($contestUser['Contest']['name']);
				 }
				 ?>
            </td>
			 <td class="dl">
					<?php echo $this->Html->getUserAvatarLink($contestUser['Contest']['User'], 'micro_thumb',true);
					echo $this->Html->getUserLink($contestUser['Contest']['User']); ?>
			</td>
			<td class="dc"><?php echo  $this->Html->cDateTimeHighlight($contestUser['ContestUser']['created']);?> </td>
			<?php if (isPluginEnabled('EntryRatings')) { ?>
			<td><?php $avg_rating =0;
				 if($contestUser['ContestUser']['contest_user_rating_count'] !=0){
					$avg_rating = $contestUser['ContestUser']['contest_user_total_ratings']/$contestUser['ContestUser']['contest_user_rating_count'];
					}
					echo  $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => false, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings')); ?>
			</td>
			<?php } ?>
         <td class="dc js-view-count-contest_user-id js-view-count-contest_user-id-<?php echo $contestUser['ContestUser']['id']; ?> {'id':'<?php echo $contestUser['ContestUser']['id']; ?>'}"><?php echo $this->Html->cInt($contestUser['ContestUser']['contest_user_view_count'],false);?></td>
         <td class="dc">
			<?php if(!empty($contest_flag)){
						echo $this->Html->link(__l($contestUser['ContestUser']['message_count']), array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug'].'#message-board', 'admin' => false),array('title' => __l('Messages ('.$contestUser['ContestUser']['message_count'].')')));
					}
					else{
						echo $contestUser['ContestUser']['message_count'];
					}?>
		</td>
		<?php if(!empty($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstContestStatus::PaidToParticipant)) {?>
			<td><?php echo $this->Html->cCurrency($contestUser['Contest']['prize'] - $contestUser['Contest']['site_commision']);?></td>
			<?php } ?>
        </tr>
	<?php
		endforeach;
	else:
	?>
		<tr>
		  <td colspan="8">
			<ol class="unstyled">
			  <li>
				<div class="thumbnail space dc grayc">
			  	  <p class="ver-mspace top-space text-16">><?php echo sprintf(__l('No %s available'), __l('entries'));?></p>
				</div>
			  </li>
			</ol>
		  </td>
		</tr>
	<?php
	endif;
	?>
	</table>
         <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
      </div>
    </div>
	<?php echo $this->Form->end(); ?>
</div>
</div>