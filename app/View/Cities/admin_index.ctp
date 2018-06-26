<div class="js-response">
<div class="top-pattern">
  <div class="container-fluid space sep-bot">
	<ul class="row no-mar mob-c unstyled  top-mspace">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'grayc'; ?>
	<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar">
          <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-eye-open no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Approved').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($active, false).'</span>', array('controller' => 'cities', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('escape' => false, 'class'=>"blackc")); ?></li>
		  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'grayc'; ?>
		   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'blackc'; ?>
         <li class="span dc no-mar">
           <?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-eye-close no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Disapproved').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($inactive, false).'</span>', array('controller' => 'cities', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('escape' => false, 'class'=>"blackc")); ?></li>
		<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
          <li class="span dc no-mar">
		    <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Total').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($active + $inactive, false).'</span>', array('controller' => 'cities', 'action' => 'index'),array('escape' => false, 'class'=>"blackc")); ?></li>
	</ul>
  </div>
</div>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('City', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb">Search</button>
        <?php echo $this->Form->end(); ?>
      </div>
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add') . '</span>', array('controller' => 'cities', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('City' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('name');?></div></th>
        <th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('Country.name',__l('Country'), array('url'=>array('controller'=>'cities', 'action'=>'index')));?></div></th>	
		<th colspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('State.name',__l('State'), array('url'=>array('controller'=>'cities', 'action'=>'index')));?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($cities)):
$i = 0;
foreach ($cities as $city):
	if($city['City']['is_approved']):
		$status_class = 'js-checkbox-active';
		$disabled = '';
	else:
		$active_class = ' inactive-record';
		$status_class = 'js-checkbox-inactive';
		$disabled = 'class="disabled"';
	endif;
?>
	<tr <?php echo $disabled; ?>>
    	
		<td class="dc span1"><?php echo $this->Form->input('City.'.$city['City']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$city['City']['id'],'label' => false , 'class' => $status_class.' js-checkbox-list'));?></td>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
                <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('action'=>'edit', $city['City']['id']), array('class' => 'edit js-edit','escape'=>false, 'title' => __l('Edit')));?> </li>
              <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $city['City']['id']), array('class' => 'delete js-confirm js-no-pjax','escape'=>false, 'title' => __l('Delete')));?> </li>
              <li> <?php echo $this->Html->link(($city['City']['is_approved'] ==1)?'<i class="icon-thumbs-down"></i>'. __l('Disapproved'): '<i class="icon-thumbs-up"></i>'.__l('Approved'), array('controller' => 'cities', 'action'=>'update_status', $city['City']['id'],'status'=>($city['City']['is_approved'] ==1)? 'disapproved': 'approved'), array('class' => ($city['City']['is_approved'] ==1)? 'js-confirm js-no-pjax reject': 'js-confirm js-no-pjax active-link', 'title' => ($city['City']['is_approved'] ==1)? __l('Disapproved'): __l('Approved'), 'escape' => false));?> </li>					       
            </ul>
            </div>
         </td>
		<td><?php echo $this->Html->cText($city['City']['name'], false);?></td>	
		<td class="dl"><?php echo $this->Html->cText($city['Country']['name'], false);?></td>
		<td class="dl"><?php echo $this->Html->cText($city['State']['name'], false);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('cities'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($cities)):
?>
  <section class="clearfix">
	<div class="span top-mspace pull-left">
		<span class="grayc"><?php echo __l('Select:'); ?></span>
			<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Disapproved'), '#', array('class' => 'js-admin-select-pending','title' => __l('Disapproved'))); ?> 
	<?php echo $this->Html->link(__l('Approved'), '#', array('class' => 'js-admin-select-approved','title' => __l('Approved'))); ?>
		<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
	</div>
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