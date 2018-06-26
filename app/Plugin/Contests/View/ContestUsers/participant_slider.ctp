<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<?php
if (!empty($contestUsers)):
$i = 0;
if(empty($this->request->params['isAjax'])){
?>
<div class="slider-block">
              <div class="clearfix ">
                <div class="close-block clearfix well no-mar dl"><?php echo __l('All Entries') . ' (' . $contestUsers[0]['Contest']['contest_user_count'] . ')' ;?><span class="pull-right js-slider-close icon-remove top-smspace cur"></span> </div>
<div class="slider-inner-block">
                  <div class="slider-inner-block1 js-slider-width">
<?php } ?>
<div class ="js-entries">
<?php
if($this->request->params['paging']['ContestUser']['page'] > 1){ ?>
	<?php echo $this->Html->link(__l('Prev'), array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contestUsers[0]['Contest']['slug'], 'type' => 'slider','page'=>$this->request->params['paging']['ContestUser']['page']-1),array('class'=>'js-entries-link grid_left prev-user', 'title'=>'Previous'));?>
<?php } ?>
<ul class="clearfix participant-list pull-left">
<?php foreach ($contestUsers as $contestUser):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
	$status_class='';
	if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
			$status_class='eliminate-img';
	}
	if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
		$status_class='withdrawn';
	}
	$zoom_class='gp-gallery-hover';
	$active_class='';
	if(!empty($this->request->params['named']['entry']) && $this->request->params['named']['entry']==$contestUser['ContestUser']['entry_no']){
		$active_class='active';
	}
?>
	<li class="<?php echo $zoom_class . ' ' . $status_class . ' ' . $active_class;?>">
        <p class="dl <?php if($contestUser['Contest']['Resource']['id'] == ConstResource::Text){ echo 'no-mar';}?>"><?php 	 
		$blind_flag = 1;
		if(!empty($contestUser['Contest']['is_blind']) && empty($contestUser['Contest']['winner_user_id'])){
			if($this->Auth->sessionValid() && ($contestUser['ContestUser']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id'))) {
				$blind_flag = 0;
			}
		}else{
			$blind_flag = 0;
		}
		if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn  || !empty($blind_flag)) {
							echo $this->Html->cInt('#'.$contestUser['ContestUser']['entry_no'], false);
						} else{
							echo $this->Html->link('#'.$this->Html->cInt($contestUser['ContestUser']['entry_no'], false), array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'plugin' => 'contests'));
						}?></p>
		<?php
				$avg_rating =0;
				 if($contestUser['ContestUser']['contest_user_rating_count'] !=0 && $contestUser['ContestUser']['contest_user_total_ratings'] >0){
					$avg_rating = $contestUser['ContestUser']['contest_user_total_ratings']/$contestUser['ContestUser']['contest_user_rating_count'];
					}
			?>
		<?php 
		if(empty($contestUser['Attachment'][0])){
			$contestUser['Attachment'][0]='';
			}
		$plugin =$contestUser['Contest']['Resource']['name']."Resources";
		if (isPluginEnabled($plugin )) {
			if(!empty($blind_flag)) {
				echo $this->Html->Image('../Contests/img/participant-bg.png',array('width' => '250','height' =>'250', 'class' => 'js-entry'));
			}else{
				$plugin = $contestUser['Contest']['Resource']['name'] . 'Resources';
				?>
                <div class="clearfix  entry-list-index">
              <?php
				echo $this->element($contestUser['Contest']['Resource']['name'].'/slider_view', array('contestUser' => $contestUser,'page' => 
			$this->request->params['paging']['ContestUser']['page'],'hover_effect' => false, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));
				?>
                </div>
              <?php
			}
		}
		       ?>
		
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo sprintf(__l('No %s available'), __l('entries'));?></p>
	</li>
<?php
endif;
?>
</ul>
<?php 
if($this->request->params['paging']['ContestUser']['pageCount'] > $this->request->params['paging']['ContestUser']['page']){ ?>
	<?php echo $this->Html->link(__l('Next'), array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contestUsers[0]['Contest']['slug'], 'type' => 'slider','page'=>$this->request->params['paging']['ContestUser']['page']+1),array('class'=>'js-entries-link next-user grid_right', 'title'=>'Next'));?>
<?php }
 ?>
 <?php if(empty($this->request->params['isAjax'])) { ?>
</div>
</div>
</div>
</div>
</div>
<?php } ?>

