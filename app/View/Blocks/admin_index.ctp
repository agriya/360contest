<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
   <div class="alert"><?php echo __l('Warning! Please edit with caution.'); ?></div>
    <div class="top-smspace grayc">
	<?php echo $this->element('paging_counter');?> 
	 </div>
	
	
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
<?php echo $this->Form->create('Block', array('class' => 'normal','url' => array('controller' => 'blocks','action' => 'update'))); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
 </div>
     
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
  <table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('Region.title', __l('Region')); ?></div></th>
      <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('status', __l('Status')); ?></div></th>
    </tr>
	</thead>
	<tbody>
<?php
	if (!empty($blocks)):
		$i = 0;
		foreach ($blocks AS $block) {
			$i=0;
			if ($i++ % 2 == 0):
				$class = "altrow";
			endif;
?>
    <tr class="<?php echo $class;?>">
      <td><?php echo $this->Html->cText($block['Block']['title']);?></td>
      <td><?php echo $block['Region']['title'];?></td>
      <td class="dc <?php echo (!empty($block['Block']['status'])) ? 'admin-status-1' : 'admin-status-0'; ?>"><?php echo $this->Html->link($this->Layout->status($block['Block']['status']), array('controller' => 'blocks', 'action' => 'update_status', $block['Block']['id'], 'status' => ($block['Block']['status'] == 1) ? 'inactive' : 'active'), array('class' => 'js-confirm', 'title' => $block['Block']['title'], 'escape' => false));?></td>
    </tr>
<?php
	}
	else:
?>
    <tr>
      <td colspan="5" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('blocks'));?></td>
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
<?php echo $this->Form->end(); ?> </div>