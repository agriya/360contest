<?php /* SVN: $Id: $ */ ?>
<div class="js-response">
<div class="sep-bot"></div>
  <div class="hor-space">
	<div class="row sep-bot space bot-mspace">
      <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
      </div>
	  <?php if (empty($this->request->params['named']['entryid'])) { ?>
        <div class="span pull-right grayc">
		  <div class="span hor-mspace">
            <?php echo $this->Form->create('ContestUserRating', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        	<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => "input-medium hor-smspace search-query span4")); ?>
        	<button type="submit" class="btn btn-success textb">Search</button>
        	<?php echo $this->Form->end(); ?>
          </div>
		</div>
	  <?php } ?>
    </div>
	<div class="tab-pane active in no-mar" id="learning">
	  <?php echo $this->Form->create('ContestUserRating' , array('action' => 'update','class'=>'normal'));?>
	  <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	  <table class="table table-striped table-hover list pictures {'minHeight':120, 'maxHeight':150, 'maxWidth':150}" start="">
		<thead class="yellow-bg">
          <tr class="sep-top sep-bot">
			<?php if (empty($this->request->params['named']['entryid'])) { ?>
				<th class="sep-right dc sep-left"><?php echo __l('Select');?></th>
			<?php } ?>
			<th class="sep-right dc"><?php echo __l('Actions');?></th>
			<th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('user_id', __l('User'));?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_id', __l('Contest'));?></div></th>
			<th class="sep-right"><?php echo __l('Entry');?></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('rating', __l('Rating'));?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ip_id', __l('IP'));?></div></th>
		  </tr>
		</thead>
		<tbody>
	<?php
	if (!empty($contestUserRatings)):
	foreach ($contestUserRatings as $contestUserRating):
		$active_class = '';
		$zoom_class = '';
		$status_class='';
		if($contestUserRating['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated) {
				$status_class=' eliminate-img';
		}
		if($contestUserRating['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn) {
			$status_class=' withdrawn';
		}
		$zoom_class=' gp-gallery-hover';
	?>
		<tr class="<?php echo $status_class;?>">
			<?php if (empty($this->request->params['named']['entryid'])) { ?>
				<td class="dc span1"><?php echo $this->Form->input('ContestUserRating.'.$contestUserRating['ContestUserRating']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contestUserRating['ContestUserRating']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
			<?php } ?>
			<td class="dc span1">
			  <div class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
				<ul class="dropdown-menu dl arrow">
				  <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('controller'=>'contest_user_ratings', 'action' => 'delete', $contestUserRating['ContestUserRating']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape' =>false, 'title' => __l('Delete')));?></li>
				</ul>
        	  </div>
			</td>		
			<td class="dc"><?php echo $this->Html->cDateTimeHighlight($contestUserRating['ContestUserRating']['created']);?></td>
			<td>
              <?php echo $this->Html->getUserAvatarLink($contestUserRating['User'], 'micro_thumb',true);?>
              <?php echo $this->Html->link($this->Html->cText($contestUserRating['User']['username'], false), array('controller'=>'users', 'action' => 'view', 'admin'=> false, $contestUserRating['User']['username']), array('title' => $this->Html->cText($contestUserRating['User']['username'], false)));?></td>			
			<td>
			<div class="status-block">
            <?php
                if(!empty($contestUserRating['ContestUser']['Contest']['ContestStatus']['name'])){ ?>
              <div class="status-block-inner"><span class="<?php echo $contestUserRating['ContestUser']['Contest']['ContestStatus']['slug'];?>" title="<?php echo $contestUserRating['ContestUser']['Contest']['ContestStatus']['name'];?>">
                     <?php echo  $this->Html->cText($contestUserRating['ContestUser']['Contest']['ContestStatus']['name'],false);?>
                </span></div>

             <?php } else {?>
			 <div class="inactive">
                    <?php echo __l('Inactive');?></div>
             <?php } ?>
            <?php echo $this->Html->link($this->Html->cText($contestUserRating['ContestUser']['Contest']['name'],false), array('controller'=>'contests', 'action' => 'view',$contestUserRating['ContestUser']['Contest']['slug'],'admin'=> false), array('title' => $this->Html->cText($contestUserRating['ContestUser']['Contest']['name'],false)));?>
			</div>
			</td>
			<?php $tmp_array['User']=$contestUserRating['ContestUser']['User'];
				$tmp_array['ContestUserStatus']=!empty($contestUserRating['ContestUser']['ContestUserStatus'])?$contestUserRating['ContestUser']['ContestUserStatus']:array();
				$tmp_array['ContestUser']=$contestUserRating['ContestUser'];
				$tmp_array['Contest']=!empty($contestUserRating['ContestUser']['Contest'])?$contestUserRating['ContestUser']['Contest']:array();
				$tmp_array['Attachment']=!empty($contestUserRating['ContestUser']['Attachment'])?$contestUserRating['ContestUser']['Attachment']:array();?>
			<td>
			<?php 
					$zoom_class='gp-gallery-hover'; ?>
					 <div class="entry-img-block <?php echo $zoom_class;?>">
					<ul class="pictures thumbnails row clearfix contest-list no-mar ver-space {'minHeight':142, 'maxHeight':182, 'maxWidth':700, 'column':4}">
						<?php $plugin =$contestUserRating['ContestUser']['Contest']['Resource']['name']."Resources";
        				if (isPluginEnabled($plugin )) {?>
					       <li class="span5 no-mar pr">
						   <div class="picture-img thumbnail sep-bot no-round" style="height: 122px; width: 162px;"> 
						<?php echo $this->element($contestUserRating['ContestUser']['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $tmp_array, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));?></li>
					 <ul> </div>
						<?php } ?>
                    </div>
                     </div>
            </td>
			<td>
            	<?php
					$avg_rating =0;
					if($contestUserRating['ContestUserRating']['rating'] !=0){
						$avg_rating = $contestUserRating['ContestUserRating']['rating'];
					}
					echo  $this->element('_star-rating', array('contest_user_id' => $contestUserRating['ContestUserRating']['contest_user_id'], 'current_rating' => round($avg_rating, 2), 'canRate' => false, 'cache' => array('config' => 'sec'), array('plugin' =>'EntryRatings')));
				?>
			</td>
			<td>
				<?php if(!empty($contestUserRating['Ip']['ip'])): ?>							  
				  <span class="show">
                    <?php echo  $this->Html->link($contestUserRating['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $contestUserRating['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$contestUserRating['Ip']['ip'], 'escape' => false));	?>
				  </span>
				  <?php if(!empty($contestUserRating['Ip']['Country'])):?>
                    <span class="flags flag-<?php echo strtolower($contestUserRating['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $contestUserRating['Ip']['Country']['name']; ?>">
					  <?php echo $contestUserRating['Ip']['Country']['name']; ?>
					</span>
                  <?php endif; 
				  if(!empty($contestUserRating['Ip']['City'])):?>             
                    <span> 	<?php echo $contestUserRating['Ip']['City']['name']; ?>    </span>
                  <?php endif; ?>
                <?php else: ?>
					<?php echo __l('N/A'); ?>
				<?php endif; ?> 
			</td>
		</tr>
	<?php
		endforeach;
	else:
	?>
		<tr>
			<td colspan="7" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('entry ratings'));?></td>
		</tr>
	<?php
	endif;
	?>
	</tbody>
	</table>
<?php
if (!empty($contestUserRatings)):?>
<section class="clearfix">
    <?php if (empty($this->request->params['named']['entryid'])) { ?>
		  <div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			
			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
		</div>
		<?php }?>
		<div class="span top-mspace pull-right">
			<div class="pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		</section>
		<div class="hide">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
    <?php 
	endif;
    echo $this->Form->end();
    ?>
  </div>
</div>
</div>
<div class="modal hide fade" id="js-ajax-modal">
	<div class="modal-body"></div>
	<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
</div>