<div class="js-response">
<div class="container-fluid">
  <div class="row sep-bot bot-mspace">
  <div class="space">
	 <div class="alert no-mar"><?php echo __l('Warning! Please edit with caution.'); ?></div></div>
	<div class="alert alert-info"><?php echo __l('Terminologies used in this CMS are synonymous with Drupal'); ?></div>
    <div class="grayc">
      	 <?php echo $this->element('admin/nodes_filter'); ?> 
	 </div>
  </div>
	
  <div class="tab-pane active in no-mar" id="learning">
 
<?php echo $this->Form->create('Node', array('class'=>'normal','url' => array('controller' => 'nodes','action' => 'update'))); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <table class="table table-striped table-hover">
    <thead class="yellow-bg">
		<tr class="sep-top sep-bot">
      <th><?php echo __l('Select'); ?></th>
      <th class="actions"><?php echo __l('Actions'); ?></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('type', __l('Type')); ?></div></th>
      <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('status', __l('Status')); ?></div></th>
    </tr>
	</thead>
	<tbody>
<?php
	if (!empty($nodes)):
		$rows = array();
		$i = 0;
		foreach ($nodes AS $node) {
			$i=0;
			if ($i++ % 2 == 0):
			$class = "altrow";
	endif;
?>
    <tr class="<?php echo $class;?>">
      <td class="dc span1"><?php echo $this->Form->input('Node.' . $node['Node']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $node['Node']['id'], 'label' => false,'class' => 'js-checkbox-list')); ?></td>
      <td  class="dc span1">
        	<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
              <ul class="dropdown-menu dl arrow">
                <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('controller' => 'nodes', 'action' => 'edit', $node['Node']['id']), array('class' => 'edit', 'escape' => false, 'title' => __l('Edit')));?></li>
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('controller' => 'nodes', 'action' => 'delete', $node['Node']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape' => false, 'title' => __l('Delete')));?></li>
              </ul>          
        </div></td>
      <td><?php echo $this->Html->link($node['Node']['title'], array('controller' => 'nodes', 'action' => 'view', 'type' => $node['Node']['type'], 'slug' => $node['Node']['slug'], 'admin' => false), array('title' => $node['Node']['title']));?></td>
      <td><?php echo $node['Node']['type'];?></td>
      <td class="dc <?php echo (!empty($node['Node']['status'])) ? 'admin-status-1' : 'admin-status-0'; ?>"><?php echo $this->Html->link($this->Layout->status($node['Node']['status']), array('controller' => 'nodes', 'action' => 'update_status', $node['Node']['id'], 'status' => ($node['Node']['status'] == 1) ? 'inactive' : 'active'), array('class' => 'js-confirm', 'title' => $this->Html->cText($node['Node']['title'], false), 'escape' => false));?> </td>
    </tr>
<?php
		}
	else:
?>
    <tr>
      <td colspan="5" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('contents'));?></td>
    </tr>
<?php
	endif;
?>
</tbody>
  </table>

 <?php
if (!empty($nodes)):
?>
  <section class="clearfix">
  <div class="span top-mspace pull-left"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
    		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
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