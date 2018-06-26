<div class="js-response">
<div class="top-pattern sep-bot">
  <div class="container-fluid space">
	<ul class="row no-mar mob-c unstyled top-mspace">
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar">
        <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-eye-open no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Active').'</span></div><span class="'.$count_class.' no-mar text-32 textb space blackc span ">'.$this->Html->cInt($approved, false).'</span>', array('controller' => 'pricing_days', 'action' => 'index', 'filter_id' => ConstMoreAction::Active),array('escape' => false, 'class'=>"blackc")); ?>
         </li>
		 <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'blackc'; ?>
         <li class="span dc no-mar">
        <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-eye-close no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Inactive').'</span></div><span class="'.$count_class.' no-mar text-32 textb space blackc span ">'.$this->Html->cInt($pending, false).'</span>', array('controller' => 'pricing_days', 'action' => 'index', 'filter_id' => ConstMoreAction::Inactive),array('escape' => false, 'class'=>"blackc")); ?>
         </li>
		<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
          <li class="span dc no-mar">
        <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('All').'</span></div><span class="'.$count_class.' no-mar text-32 textb space blackc span ">'.$this->Html->cInt($approved + $pending, false).'</span>', array('controller' => 'pricing_days', 'action' => 'index'),array('escape' => false, 'class'=>"blackc")); ?>
         </li>
	</ul>
  </div>
</div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('PricingDay', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php 
			  echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); 
			  echo $this->Form->input('type', array('type' => 'hidden')); 
		?>
        <button type="submit" class="btn btn-success textb"><?php echo __l('Search');?></button>
        <?php echo $this->Form->end(); ?>
      </div>
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add') . '</span>', array('controller' => 'pricing_days', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('PricingDay' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('no_of_days', __l('No of Days'));?></div></th>        
		<th rowspan="2" class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('global_price',sprintf('%s ('.Configure::read('site.currency').')', __l('Global Price')));?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($pricingDays)):
$i = 0;
foreach ($pricingDays as $pricingDay):
	if($pricingDay['PricingDay']['is_active']):
	  $status_class = 'js-checkbox-active';
	  $disabled = '';
	else:
	  $status_class = 'js-checkbox-inactive';
	  $disabled = 'class="disabled"';
	endif;
?>
	<tr <?php echo $disabled; ?>>
    	
		<td class="dc span1">
			<?php echo $this->Form->input('PricingDay.'.$pricingDay['PricingDay']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$pricingDay['PricingDay']['id'], 'label' => false,'class' => $status_class.' js-checkbox-list')); ?>
        </td>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
               <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('action' => 'edit', $pricingDay['PricingDay']['id']), array('class' => 'edit js-edit', 'escape' => false, 'title' => __l('Edit')));?></li>
				<li>
					<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $pricingDay['PricingDay']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape' => false, 'title' => __l('Delete')));
					 ?>
					  <?php echo $this->Layout->adminRowActions($pricingDay['PricingDay']['id']);?>
				</li>
				<li>
				<?php echo $this->Html->link(($pricingDay['PricingDay']['is_active'] ==1)? '<i class="icon-eye-close"></i>'.__l('Inactive'): '<i class="icon-eye-open"></i>'.__l('Active'), array('controller' => 'pricing_days', 'action'=>'update_status', $pricingDay['PricingDay']['id'],'status'=>($pricingDay['PricingDay']['is_active'] ==1)? 'inactive': 'active'), array('class' => ($pricingDay['PricingDay']['is_active'] ==1)? 'js-confirm js-no-pjax reject': 'js-confirm js-no-pjax active-link', 'title' => ($pricingDay['PricingDay']['is_active'] ==1)? __l('Inactive'): 'Active', 'escape' => false));?>
				 </li>		       
            </ul>
            </div>
         </td>
		<td class="dc"><?php echo $this->Html->cDateTime($pricingDay['PricingDay']['created']);?></td>
		<td class="dc"><?php echo $this->Html->cText($pricingDay['PricingDay']['no_of_days']);?></td>		
		<td class="dr"><?php echo $this->Html->cCurrency($pricingDay['PricingDay']['global_price']);?></td>	
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('contest days'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($pricingDays)):
?>
<section class="clearfix">
	<div class="span top-mspace pull-left"> 
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