<?php /* SVN: $Id: $ */ ?>
<div class="js-response">
<div class="container-fluid">
  <div class="container-fluid space sep-bot">
	<ul class="row no-mar mob-c unstyled  top-mspace">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstUploadStatus::Success) ? 'pinkc' : 'grayc'; ?>
			<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstUploadStatus::Success) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar">
          <?php echo $this->Html->link('<div class="span"> <span class="label label-important span1 dc space no-mar"><i class="icon-thumbs-up no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Success').'</span></div><span class="'.$count_class.' text-32 textb space ">'.$this->Html->cInt($success, false).'</span>', array('controller' => 'uploads', 'action' => 'index', 'filter_id' => ConstUploadStatus::Success),array('escape' => false, 'class'=>"blackc")); ?></li>
		  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstUploadStatus::Processing) ? 'pinkc' : 'grayc'; ?>
			<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstUploadStatus::Processing) ? 'pinkc' : 'blackc'; ?>
         <li class="span dc no-mar">
           <?php echo $this->Html->link('<div class="span"> <span class="label label-important span1 dc space no-mar"><i class="icon-spinner no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Processing').'</span></div><span class="'.$count_class.' text-32 textb space ">'.$this->Html->cInt($processing, false).'</span>', array('controller' => 'uploads', 'action' => 'index', 'filter_id' => ConstUploadStatus::Processing),array('escape' => false, 'class'=>"blackc")); ?></li>
		   <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstUploadStatus::Failure) ? 'pinkc' : 'grayc'; ?>
			<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstUploadStatus::Failure) ? 'pinkc' : 'blackc'; ?>
		 <li class="span dc no-mar">
           <?php echo $this->Html->link('<div class="span"> <span class="label label-important span1 dc space no-mar"><i class="icon-thumbs-down no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Failure').'</span></div><span class="'.$count_class.' text-32 textb space ">'.$this->Html->cInt($failure, false).'</span>', array('controller' => 'uploads', 'action' => 'index', 'filter_id' => ConstUploadStatus::Failure),array('escape' => false, 'class'=>"blackc")); ?></li>
		   <?php $class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'grayc'; ?>
			<?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
          <li class="span dc no-mar">
		    <?php echo $this->Html->link('<div class="span"> <span class="label label-important span1 dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('All').'</span></div><span class="'.$count_class.' text-32 textb space ">'.$this->Html->cInt($success+$processing+$failure, false).'</span>', array('controller' => 'uploads', 'action' => 'index'),array('escape' => false, 'class'=>"blackc")); ?></li>
	</ul>
  </div>
  <div class="row space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('ContestFlagCategory' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
	<thead class="yellow-bg">
		<tr>      
			<th class="actions"><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
			<th class="actions"><?php echo $this->Paginator->sort('User.username', __l('User'));?></th>
			<th class="actions"><?php echo $this->Paginator->sort('UploadService.name', __l('Hoster'));?></th>
			<th class="actions"><?php echo __l('Contest'); ?></th>
			<th class="actions"><?php echo $this->Paginator->sort('UploadStatus.name', __l('Status'));?></th>
		</tr>
	</thead>
<?php
if (!empty($uploads)):
foreach ($uploads as $upload):
?>
	<tr>
		<td class="dl"><?php echo $this->Html->cDateTimeHighlight($upload['Upload']['created']);?></td>
		<td class="dl">
		<?php echo $this->Html->link($this->Html->cText($upload['User']['username']), array('controller'=> 'users', 'action'=>'view', $upload['User']['username'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($upload['User']['username'],false)));?>
		</td>
		<td class="dl"><?php echo $this->Html->cText($upload['UploadService']['name']);?><?php echo '['.$this->Html->cText($upload['UploadServiceType']['name']).']';?></td>	
		<td class="dl">
		<?php echo $this->Html->link($this->Html->cText($upload['ContestUser']['Contest']['name']), array('controller'=> 'contests', 'action'=>'view', $upload['ContestUser']['Contest']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($upload['ContestUser']['Contest']['name'],false)));?>
		</td>
		<td class="dl">
			<?php echo $this->Html->cText($upload['UploadStatus']['name']);
			if(!empty($upload['Upload']['failure_message'])) { ?>
		        <span class="info chart-info js-tooltip hoster-info" title="<?php echo $this->Html->cText($upload['Upload']['failure_message'], false);?>"></span>
				<?php 
			} 
			if($upload['Upload']['upload_status_id'] == ConstUploadStatus::Processing) {
				echo "  " .  $this->Html->link(__l('Check Status'), array('controller'=>'uploads','action'=>'check_status', $upload['Upload']['id']),array('title' => __l('Click here to check upload status'), 'class'=>'js-tooltip'));
			} ?> 
        </td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="5" class="notice"><?php echo sprintf(__l('No %s available'), __l('uploads'));?></td>
	</tr>
<?php
endif;
?>
</table>
<?php
if (!empty($uploads)):
?>
  <section class="clearfix">
	<div class="span top-mspace pull-left space"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        <?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending','title' => __l('Inactive'))); ?>
        <?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved','title' => __l('Active'))); ?>
        <span class="hor-mspace">
        	<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false, 'empty' => __l('-- More actions --'))); ?>
        </span>
    </div>
    <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
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