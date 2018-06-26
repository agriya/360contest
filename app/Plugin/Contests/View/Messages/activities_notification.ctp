<div id="activities" class="js-response clearfix">
  <section>
    <?php if (!empty($messages)): ?>
      <?php $projectStatus = array();?>
      <article class="row span10">
        <ol class="unstyled discussion-list">
          <?php
            $i = 0;
            end($messages);
            $last = key($messages);
            reset($messages);
            foreach ($messages as $key=>$message): ?>
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
							<span class="open-status dc span2 grayc no-mar">
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
				</div>
			</li>
          <?php endforeach; ?>
        </ol>
      </article>
    <?php else : ?>
      <ol class="unstyled space no-mar no-pad">
        <li>
		 <div class="thumbnail space dc grayc">
		  <p class="ver-mspace top-space text-10"><?php echo __l('No activities available');?></p>
         </div>
		</li>
      </ol>
    <?php endif;?>
  </section>
  <?php if (!empty($messages)): ?>
    <section>
	<div class="pull-left space">
        <?php echo $this->Html->link(__l('See all activities'), array('controller' => 'messages', 'action' => 'activities', 'admin' => false), array('class' => 'linkc top-mspace','escape' => false));?>
      </div>
      <div class="pull-right space">
        <?php echo $this->Html->link(__l('Clear activities'), array('controller' => 'messages', 'action' => 'clear_activities', 'admin' => false, 'final_id' => $final_id['Message']['id']), array('class' => 'mspace js-no-pjax btn','escape' => false));?>
      </div>
    </section>
  <?php endif; ?>
</div>