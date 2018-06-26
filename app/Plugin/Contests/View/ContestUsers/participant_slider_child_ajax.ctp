<?php
		if($this->request->params['paging']['ContestUser']['page'] > 1){ ?>
			<?php echo $this->Html->link(__l('Prev'), array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contestUsers[0]['Contest']['slug'], 'type' => 'participant_slider', 'user_id' => $contestUsers[0]['User']['id'],'page'=>$this->request->params['paging']['ContestUser']['page']-1),array('class'=>'hor-space js-no-pjax js-participant-link pull-left prev-user {"direction" : "lt"}', 'title'=>'Previous'));?>
		<?php } ?>
		<?php 
		$span_class = "pull-right";
		if($this->request->params['paging']['ContestUser']['pageCount'] > $this->request->params['paging']['ContestUser']['page']){ 
			$span_class = "pull-left";
		}
		?>
			<ul class="<?php echo $span_class;?> pictures thumbnails row clearfix contest-list no-mar ver-space {'minHeight':95, 'maxHeight':100, 'maxWidth':750, 'column':2}">
    			<?php
					$i=0;
					foreach($contestUsers as $contestUser) {
						$status_class='';
						$zoom_class='gp-gallery-hover';
						if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
							$status_class='eliminate-img';
						}else{
							$status_class='withdrawn';
						}
					if($i < 2){
				?>
				<li class="span5 no-mar pr gp-gallery-hover <?php echo $zoom_class . ' ' . $status_class;?>">
					<div class="picture-img thumbnail sep-bot no-round "> 
					<?php
						$plugin =$contestUser['Contest']['Resource']['name']."Resources";
        				if (isPluginEnabled($plugin)) {
							echo $this->element($contestUser['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $contestUser, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));

						}
					?>
					</div>
				<div class="clearfix entries-user-details">
					<span class="entry-no pull-right"><?php if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
							echo '#'.$this->Html->cInt($contestUser['ContestUser']['entry_no'], false);
						} else{
							echo '#'.$this->Html->link($this->Html->cInt($contestUser['ContestUser']['entry_no'], false), array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'plugin' => 'contests'));
						}?></span>						
				</div>
		</li>
			<?php }
				$i++;
				} ?>
		 </ul>
		 <?php
		if($this->request->params['paging']['ContestUser']['pageCount'] > $this->request->params['paging']['ContestUser']['page']){ ?>
			<?php echo $this->Html->link(__l('Next'), array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contestUsers[0]['Contest']['slug'], 'type' => 'participant_slider', 'user_id' => $contestUsers[0]['User']['id'],'page'=>$this->request->params['paging']['ContestUser']['page']+1),array('class'=>'js-no-pjax js-participant-link next-user pull-right {"direction" : "rgt"}', 'title'=>'Next'));?>
		<?php }
		 ?>