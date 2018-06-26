<div class="js-response">
<div class="top-pattern sep-bot"></div>
 <div class="alert mspace alert-warning"><?php echo __l('Warning! Please edit with caution.'); ?></div>
<div class="container-fluid">
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
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add Content Type') . '</span>', array('controller' => 'types', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add Content Type'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
		<th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></div></th>
		<th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('description', __l('Description')); ?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($types)):
$i = 0;
foreach ($types AS $type):
?>
	<tr>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
               <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('controller' => 'types', 'action' => 'edit', $type['Type']['id']), array('class' => 'edit', 'escape'=>false, 'title' => __l('Edit')));?>
                </li>
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'types', 'action' => 'delete', $type['Type']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape'=>false, 'title' => __l('Delete')));?>
                </li>			       
            </ul>
            </div>
         </td>
		<td class="dl"><?php echo $this->Html->cText($type['Type']['title']);?></td>
		<td class="dl"><?php echo $this->Html->cText($type['Type']['alias']);?></td>
		<td class="dl"><?php echo $this->Html->cText($type['Type']['description']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('content types'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
    <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
      </div>
    </div>
</div>
</div>
</div>