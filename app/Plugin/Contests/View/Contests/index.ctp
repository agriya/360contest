<div>
<div class="clearfix">
<?php $class='';?>
        <?php if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'follower' && empty($this->request->params['named']['sort'])):?>
			<?php $class='ver-space'; ?>
		<?php elseif(empty($this->request->params['named']['status']) && empty($this->request->params['named']['sort'])): ?>
		   <?php $class='ver-space'; ?>
		<?php endif; ?>
<div class ="js-response-entries js-response js-entries clearfix" id="js-contest-index">
	<?php if(!$this->request->isAjax() || ($this->request->isAjax() && !empty($contest_type))): ?>
		<h2><?php echo __l('Contests'); if(!empty($contest_type)){ echo ' - '.$contest_type['ContestType']['name']; } ?></h2>
	<?php endif; ?>
	<div class="<?php echo empty($this->request->params['named']['type'])?'span18 ver-mspace':''; ?>">
	<table class="table table-striped sep table-hover">				  <thead>
					<tr>
					  <th><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Contest Title'), array('class' => 'js-no-pjax'));?></div></th>
					  <th class="dc"> <div class="js-pagination"><?php echo $this->Paginator->sort('actual_end_date', __l('Ends'), array('class' => 'js-no-pjax'));?></div></th>
					  <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count', __l('Entries'), array('class' => 'js-no-pjax'));?></div></th>
					  <th class="dc">
							<div class="js-pagination">
							 <?php echo $this->Paginator->sort('prize', __l('Prize') . ' (' . Configure::read('site.currency') . ')', array('class' => 'js-no-pjax'));?>
							</div>
					  </th>
					</tr>
				  </thead>
				  <tbody>
				  <?php
					if (!empty($contests)):
						foreach ($contests as $contest):?>
					<tr class="<?php if(!empty($contest['Contest']['is_highlight'])){ echo 'highlight_contest'; }?>">
					  <td><div class="clearfix"><div class="thumbnail pull-left"><?php echo $this->Html->link($this->Html->showImage('ContestType', !empty($contest['ContestType']['Attachment'])?$contest['ContestType']['Attachment']:array(), array('dimension' => 'browse_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($contest['ContestType']['name'], false)), 'title' => $this->Html->cText($contest['ContestType']['name'], false))), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin'=> false), array('escape' => false ));?>
					</div>
						<div class='pull-left <?php if(!empty($this->request->params['named']['user_id'])) { ?>span12<?php } else { ?> span9 <?php }?> no-mar top-space top-mspace'>
						<div class="span10">
							<h5 class="no-mar pull-left">
							<?php if(!empty($this->request->params['named']['user_id'])) { 
								$truncate_span = 'span7';
								} else { 
									$truncate_span = 'span6';
									}
							?>
							<?php echo $this->Html->link($this->Html->cText($contest['Contest']['name']), array('controller'=> 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin' => false), array('escape' => false, 'class' => 'js-tooltip no-mar htruncate '.$truncate_span, 'title' => $this->Html->cText($contest['Contest']['name'], false)));?></h5>
							<span class="label-category hor-space hor-mspace htruncate span2 js-tooltip" title="<?php echo $this->Html->cText($contest['ContestType']['name'],false);?>"><?php echo $this->Html->cText($contest['ContestType']['name'],false);?></span> </div>
							<div class="help-inline hor-space no-mar"><?php echo __l('by').' '.$this->Html->getUserLink($contest['User']);?></div>
						<div class="status-block status-block1 top-space">
						<span class="hor-mspace pull-left js-tooltip label <?php echo $contest['ContestStatus']['slug'];?>" title ="<?php echo  $this->Html->cText($contest['ContestStatus']['name'], false);?>"><?php echo  $this->Html->cText($contest['ContestStatus']['name'], false);?></span></div></div></div> 
						<div class="other-fee-block hor-space">
					<?php if ($contest['Contest']['resource_id'] == ConstResource::Image) { ?>
	                  <i class="icon-picture text-13" title ="<?php echo __l('Image Resource');?>"></i>
	                 <?php } ?>
	                 <?php if ($contest['Contest']['resource_id'] == ConstResource::Video) { ?>
	                  <i class="icon-facetime-video text-13" title ="<?php echo __l('Video Resource');?>"></i>
	                 <?php } ?>
                     <?php if ($contest['Contest']['resource_id'] == ConstResource::Audio) { ?>
	                  <i class="icon-volume-up text-13" title ="<?php echo __l('Audio Resource');?>"></i>
	                 <?php } ?>
                     <?php if ($contest['Contest']['resource_id'] == ConstResource::Text) { ?>
	                  <i class="icon-edit text-13" title ="<?php echo __l('Text Resource');?>"></i>
	                 <?php } ?>
					<?php if(!empty($contest['Contest']['is_private'])){?>
					<i class="icon-lock text-13" title ="<?php echo __l('Private');?>"></i>
					<?php } ?>
					<?php if(!empty($contest['Contest']['is_blind'])){?>
					<i class="icon-eye-close text-13" title ="<?php echo __l('Blind');?>"></i>
					<?php } ?>
					<?php if(!empty($contest['Contest']['is_featured'])){?>
					<i class="icon-star text-13" title ="<?php echo __l('Featured');?>"></i> 
					<?php } ?>
				 </div>
						</td>
					  <td class="dc"><?php echo ($contest['Contest']['actual_end_date']!='0000-00-00 00:00:00')? $this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']):'-';?></td>
					  <td class="dc"><?php echo $this->Html->cInt($contest['Contest']['contest_user_count']);?> </td>
					  <td class="pinkc textb text-16 dr"><?php echo $this->Html->cCurrency($contest['Contest']['prize']);?></td>
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

				  </tbody>
				</table>

				<?php if (!empty($contests)) :?>
					<div class="paging row offset8 js-pagination">  <?php echo $this->element('paging_links'); ?> </div>
				 <?php endif; ?>
	<?php if(isset($this->request->params['named']['status'])){ ?>
	</div>

	<div class="span6 pull-right ver-space">
				<div class="thumbnail clearfix">
					<h3><?php echo __l('Categories');?></h3>
					<?php echo $this->element('category-index');?>
				</div>
			<?php }?>
