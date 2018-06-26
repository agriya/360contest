<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="alert"><?php echo __l('Warning! Please edit with caution.'); ?></div>
		<div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<span><i class="icon-plus-sign"></i></span><?php echo $this->Html->link(' <span class="pinkc">' . __l('Add') . '</span>', array('action' => 'add'), array('class' => 'add pinkc','title'=>__l('Add Menu'),'escape' => false)); ?>
        </span> 
    </div>
	<div class="top-smspace grayc">
    <?php echo $this->element('paging_counter');?> 
	</div>
	 </div>
  <div class="tab-pane active in no-mar" id="learning">
  <table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
      <th class="actions"><?php echo __l('Actions'); ?></th>
      <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
      <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></div></th>
      <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('link_count', __l('Link Count')); ?></div></th>
    </tr>
<?php
	if (!empty($menus)):
		$i = 0;
		foreach ($menus AS $menu) {
			$i=0;
			if ($i++ % 2 == 0):
				$class = "altrow";
			endif;
?>
    <tr class="<?php echo $class;?>">
       <td  class="dc span1">
        	<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
              <ul class="dropdown-menu dl arrow">
                <li><?php echo $this->Html->link('<i class="icon-th-list blackc"></i>'.__l('View links'), array('controller' => 'links', 'action'=>'index', $menu['Menu']['id']), array('class' => 'view', 'title' => __l('View links'),'escape' => false));?> </li>
                <li><?php echo $this->Html->link('<i class="icon-pencil blackc"></i>'.__l('Edit'), array('controller' => 'menus', 'action'=>'edit', $menu['Menu']['id']), array('class' => 'edit', 'title' => __l('Edit'),'escape' => false));?> </li>
                <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('controller' => 'menus', 'action'=>'delete', $menu['Menu']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?> </li>
              </ul>
            </div>
            <div class="action-bottom-block"></div>
          </div>
        </div></td>
      <td><?php echo $this->Html->link($this->Html->cText($menu['Menu']['title'], false), array('controller' => 'links', 'action' => 'index', $menu['Menu']['id']), array('title' => $this->Html->cText($menu['Menu']['title'], false)));?></td>
      <td class="dl"><?php echo $this->Html->cText($menu['Menu']['alias'], false);?></td>
      <td class="dc"><?php echo $menu['Menu']['link_count'];?></td>
    </tr>
<?php
	}
else:
?>
    <tr>
      <td colspan="5" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('menus'));?></td>
    </tr>
<?php
endif;
?>
   </tbody>
</table>

