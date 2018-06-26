<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contestUsers contest-user-participants index js-response js-response-entries">
<ol class="clearfix participants-list unstyled">
<?php
if(!empty($contestUsers)):
$contest_user_arr=array();
foreach ($contestUsers as $contest_User){
		$contest_user_arr[$contest_User['ContestUser']['user_id']][]=$contest_User;
}
foreach ($contest_user_arr as $key=>$contest_users){ ?>
	<li class="clearfix">
		<div class="span4 participants-left-block">
			<?php echo $this->Html->getUserAvatarLink($contest_users[0]['User'], 'medium_thumb',true);?>
			<?php  echo $this->Html->getUserLink($contest_users[0]['User']); ?>
		</div>
		<div class="pull-left clearfix participants-right-block omega alpha js-participant-response">

		<ol class="pictures thumbnails pull-left row clearfix contest-list no-mar ver-space {'minHeight':95, 'maxHeight':100, 'maxWidth':750, 'column':2}">
	  <?php if (!empty($contestUsers)):
	   $i=0;
		foreach ($contest_users as $contestUser):
		  $plugin = $contestUser['Contest']['Resource']['name']."Resources";
			if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
			$status_class='eliminate-img';
			}else{
			$status_class='withdrawn';
			}
		  if (isPluginEnabled($plugin )):?>
		  <?php 
		  if($i < 2){
		  ?>
			<li class="span5 no-mar pr gp-gallery-hover <?php echo $status_class;?>">
			  <div class="picture-img thumbnail sep-bot no-round "> 
				<?php echo $this->element($contestUser['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $contestUser, 'cache' => array('config' => 'sec')),array('plugin' => $plugin ));?>
				
			  </div>
			   <div class="clearfix entries-user-details">
					<span class="entry-no pull-right"><?php if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
							echo '#'.$this->Html->cInt($contestUser['ContestUser']['entry_no'], false);
						} else{
							echo '#'.$this->Html->link($this->Html->cInt($contestUser['ContestUser']['entry_no'], false), array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'plugin' => 'contests'));
						}?></span>						
				</div>

            </li>
			<?php
			$i++;
			}
			?>
		  <?php endif;
		endforeach;
	  else:?>
		<li class="span5 pr gp-gallery-hover"><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('entries'));?></p>
					</div></li>
	  <?php endif; ?>
	</ol>


		 <?php 
		if(count($contest_users) > 2){ ?>
			<?php echo $this->Html->link(__l('Next'), array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contestUsers[0]['Contest']['slug'], 'type' => 'participant_slider', 'user_id' => $contest_users[0]['User']['id'],'page'=>2),array('class'=>'js-no-pjax js-participant-link next-user pull-right {"direction" : "rgt"}', 'title'=>'Next'));?>
		<?php }
		 ?>
	</div>
	</li>
<?php
}
else:?>
           <li class="notice-info">
		   <div class="thumbnail space dc grayc">
			<p class="ver-mspace top-space text-16"><?php echo __l('No').' '. Configure::read('contest.participant_alt_name_plural_caps').' '.__l('available');?></p>
			</div>
            </li>
            <?php
      endif;?>
</ol>
</div>
