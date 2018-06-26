<div class="js-response">
<div class="top-pattern sep-bot"></div>
 <div class="alert mspace alert-warning"><?php echo __l('Warning! Please edit with caution.'); ?></div>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add Vocabulary') . '</span>', array('controller' => 'vocabularies', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add Vocabulary'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Actions'); ?></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
		<th rowspan="2" class="sep-right dc"><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($vocabularies)):
$i = 0;
foreach ($vocabularies AS $vocabulary):
?>
	<tr>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
              <li><?php echo $this->Html->link('<i class="icon-eye-open"></i>'.__l('View Terms'), array('controller' => 'terms', 'action' => 'index', $vocabulary['Vocabulary']['id']), array('class' => 'view', 'escape'=>false, 'title' => __l('View Terms')));?></li>
            <li><?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move Up'), array('controller' => 'vocabularies', 'action' => 'moveup', $vocabulary['Vocabulary']['id']), array('class' => 'move-up', 'escape'=>false, 'title' => __l('Move Up')));?></li>
            <li><?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move Down'), array('controller' => 'vocabularies', 'action' => 'movedown', $vocabulary['Vocabulary']['id']), array('class' => 'move-down', 'escape'=>false, 'title' => __l('Move Down')));?></li>
            <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('controller' => 'vocabularies', 'action' => 'edit', $vocabulary['Vocabulary']['id']), array('class' => 'edit', 'escape'=>false, 'title' => __l('Edit')));?></li>
            <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'vocabularies', 'action' => 'delete', $vocabulary['Vocabulary']['id']), array('class' => 'delete js-confirm js-no-pjax',  'escape'=>false,'title' => __l('Delete')));?></li>			       
            </ul>
            </div>
         </td>
		<td class="dc"><?php echo $this->Html->cText($vocabulary['Vocabulary']['title']);?></td>
		<td class="dc"><?php echo $this->Html->cText($vocabulary['Vocabulary']['alias']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('vocabularies'));?></td>
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