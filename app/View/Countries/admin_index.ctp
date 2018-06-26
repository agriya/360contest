<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('Country', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb">Search</button>
        <?php echo $this->Form->end(); ?>
      </div>
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add') . '</span>', array('controller' => 'countries', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('Country' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('name');?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('fips_code');?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('iso_alpha2');?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('iso_alpha3');?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('iso_numeric');?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('capital');?></div></th>
        <th colspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Currency');?></div></th>
	</tr>
    <tr>
    	<th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('currency',__l('Name'));?></div></th>
        <th colspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('currency_code',__l('Code'));?></div></th>
      </tr>
	</thead>
	<tbody>
<?php
if (!empty($countries)):
$i = 0;
foreach ($countries as $country):
?>
	<tr>
    	
		<td class="dc span1"><?php echo $this->Form->input('Country.'.$country['Country']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$country['Country']['id'],'label' => false , 'class' => 'js-checkbox-list')); ?> </td>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
                <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('action'=>'edit', $country['Country']['id']), array('class' => 'edit js-edit', 'escape'=>false,'title' => __l('Edit')));?> </li>
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action'=>'delete', $country['Country']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape'=>false,'title' => __l('Delete')));?> <?php echo $this->Layout->adminRowActions($country['Country']['id']);?> </li>
            </ul>
            </div>
         </td>
		<td class="dl"><?php echo $this->Html->cText($country['Country']['name']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['fips_code']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['iso_alpha2']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['iso_alpha3']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['iso_numeric']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['capital']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['currencyname']);?></td>
        <td class="dc"><?php echo $this->Html->cText($country['Country']['currency']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Countries'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($countries)):
?>
  <section class="clearfix">
	<div class="span top-mspace pull-left"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all hor-mspace', 'title' => __l('All'))); ?>
    	<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
    	<span class="hor-mspace">
        	 <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false,'empty' => __l('-- More actions --'))); ?> 
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