<?php if(!isset($this->request->params['named']['type'])) { ?>
<?php if(empty($this->request->params['named']['contest_id']) && !isset($this->request->params['named']['page'])){ ?>
<div class="ver-space">
<h2><?php  echo __l('Activities'); ?></h2></div>
<?php } ?>
<div id="activities" class="tab-pane in no-mar js-response">
<ol class="unstyled <?php echo !empty($messages)?'activities-list':'';?>">
	<?php
    if (!empty($messages)) :
        foreach($messages as $message): ;
      		?>
			<?php
				$avatar_positioning_class = '';
				$avatar = array();
			?>
			<li class="bot-space">
				<div class="row no-mar">
					<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
					<span class="date-info text-14 blackc textb span3 no-mar js-timestamp" data-placement="right" data-toggle="popover" title ="<?php echo $time_format;?>">
						<?php echo $message['Message']['created'];?>
					</span>
                    <div class="thumbnail activity-content sep-bot offset1 space <?php echo !empty($this->request->params['named']['contest_id'])?'span13':'span19'; ?> mob-ps mob-mar pr ">
						<i class="icon-caret-left pa text-32 status-left-ps whitec"></i>
						<?php
						$other_status = array(ConstContestStatus::NewEntry, ConstContestStatus::Rated,ConstContestStatus::Conversation);
						if(!empty($message['ContestStatus']['name']) and (!in_array($message['Message']['contest_status_id'],$other_status))):?>
							<span class="open-status dc span2 hor-mspace">
								<?php echo $this->Html->cText($message['ContestStatus']['name']);?>
							</span>
						<?php
						elseif(in_array($message['Message']['contest_status_id'],$other_status)):
						    if($message['Message']['contest_status_id'] == ConstContestStatus::NewEntry){?>
								<span class="new-entry dc span2 hor-mspace"><?php echo $this->Html->cText('New Entry');?></span>
							<?php }
							if($message['Message']['contest_status_id'] == ConstContestStatus::Rated){?>
								<span class="rated dc span2 hor-mspace"><?php echo $this->Html->cText('Rated');?></span>
							<?php }
						endif;?>
						<?php echo $this->Html->displayActivities($message);?>
					</div>
				</div>
			</li>
			<?php
        endforeach; ?>
  
	 <?php 
		else :
	?>
	<li><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('activities'));?></p>
					</div></li>
	<?php
    endif;
    ?>
    </ol>
     <div class="clearfix">
   <div class="pull-right js-pagination">
	   <?php echo $this->element('paging_links'); ?>
	</div>
	</div>
</div>
<?php } else { ?>
<ol class="unstyled discussion-list">
	<?php
    if (!empty($messages)) :
        foreach($messages as $message): ;
      		?>
			<?php
				$avatar_positioning_class = '';
				$avatar = array();
			?>
			<li class="row top-mspace bot-space">
				<div class="thumbnail sep-bot clearfix mob-ps mob-mar pr">
                    <span class="dc span2 no-mar no-pad">
						<?php
						$other_status = array(ConstContestStatus::NewEntry, ConstContestStatus::Rated,ConstContestStatus::Conversation);
						if(!empty($message['ContestStatus']['name']) and (!in_array($message['Message']['contest_status_id'],$other_status))):?>
							<span class="open-status dc span2 grayc no-mar <?php echo $message['ContestStatus']['slug'];?>">
								<?php echo $this->Html->cText($message['ContestStatus']['name']);?>
							</span>
						<?php
						elseif(in_array($message['Message']['contest_status_id'],$other_status)):
						    if($message['Message']['contest_status_id'] == ConstContestStatus::NewEntry){?>
								<span class="new-entry dc span2 no-mar grayc"><?php echo $this->Html->cText('New Entry');?></span>
							<?php }
							if($message['Message']['contest_status_id'] == ConstContestStatus::Rated){?>
								<span class="rated dc span2 no-mar grayc"><?php echo $this->Html->cText('Rated');?></span>
							<?php }
						endif;?>
						<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
						<span class="date-info span no-mar pull-left js-timestamp" data-placement="right" data-toggle="popover" title ="<?php echo $time_format;?>">
							<?php echo $message['Message']['created'];?>
						</span>
					</span>
						<?php echo $this->Html->displayEntryActivities($message);?>
						<div class="activities-section2 grid_10 alpha omega">
							<?php if($message['OtherUser']['role_id']!= ConstUserTypes::Admin) { ?>
								<div class="avatar-right-container">
									<cite>
										<?php echo $this->Html->getUserAvatarLink($message['OtherUser']['id'], 'micro_thumb');  ?>
									</cite>
									<span><?php echo $this->Html->cText($message['OtherUser']['username'], false);?></span>
									<?php if($this->Auth->user('id')!=$message['OtherUser']['id']){?>
										<span><?php echo $this->Html->link(__l('Contact'),array('controller'=>'messages','action'=>'compose', 'user' => $message['OtherUser']['username'], 'contest_id'=>$message['Contest']['id'],'type'=>'contact'),array('target'=>'blank','title'=>__l('Contact')));?></span>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
				</div>
			</li>
			<?php
        endforeach; ?>
  
	 <?php 
		else :
	?>
	<li><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('activities'));?></p>
					</div></li>
	<?php
    endif;
    ?>
    </ol>
     <div class="clearfix">
   <div class="pull-right js-pagination">
	   <?php echo $this->element('paging_links'); ?>
	</div>
	</div>
<?php } ?>
