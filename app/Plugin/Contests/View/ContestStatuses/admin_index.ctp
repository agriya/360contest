<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('ContestStatus', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb"><?php echo __('Search');?></button>
        <?php echo $this->Form->end(); ?>
      </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right "><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name'));?></div></th>
        <th rowspan="2" class="sep-right "><div class="js-pagination"><?php echo $this->Paginator->sort('message', __l('Message'));?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($contestStatuses)):
foreach ($contestStatuses as $contestStatus):
?>
	<tr>
    	
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">		
              <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('action' => 'edit', $contestStatus['ContestStatus']['id']), array('class' => 'edit js-edit', 'escape'=>false, 'title' => __l('Edit')));?>
				 <?php echo $this->Layout->adminRowActions($contestStatus['ContestStatus']['id']);?>
              </li>
            </ul>
            </div>
         </td>
		<td class="dl"><?php echo $this->Html->cText($contestStatus['ContestStatus']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($contestStatus['ContestStatus']['message']);?></td>
	</tr>
<?php
    endforeach;
else:
	?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Contest Statuses'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($contestStatuses)):
?>
    <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
      </div>
    </div>
<?php
endif;
?>
</div>
</div>
</div>