<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
<div class="alert"><?php echo __l('Warning! Please edit with caution.'); ?></div>
<div class="span pull-right grayc">
      <div class="span hor-mspace">
<?php echo $this->Form->create('Link', array('class'=>'normal','url' => array('controller' => 'links','action' => 'update'))); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
</div>
      <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add Link') . '</span>', array('controller' => 'links', 'action' => 'add', $menu['Menu']['id']), array('class' => 'grayc', 'title' => __l('Add Link'),'escape'=>false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
  <table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
      <th class="actions span1"><?php echo __l('Select'); ?></th>
      <th><?php echo __l('Actions'); ?></th>
      <th><?php echo __l('Title'); ?></th>
      <th class="dc"><?php echo __l('Status'); ?></th>
    </tr>
<?php
	if (!empty($linksTree)):
		$i = 0;
		foreach ($linksTree AS $linkId => $linkTitle) {
			$i=0;
			if ($i++ % 2 == 0):
				$class = "altrow";
			endif;
?>
    <tr class="<?php echo $class;?>">
      <td class="select"><?php echo $this->Form->input('Link. ' . $linkId . '.id', array('type' => 'checkbox', 'id' => "admin_checkbox_" . $linkId, 'label' => false,'class' => 'js-checkbox-list')); ?></td>
     <td  class="dc span1">
        	<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
                      <ul class="dropdown-menu dl arrow">
                <li><?php echo $this->Html->link('<i class="icon-arrow-up"></i>'.__l('Move up'), array('controller' => 'links', 'action'=>'moveup', $linkId), array('class' => 'move-up', 'title' => __l('Move up'),'escape' => false));?></li>
                <li><?php echo $this->Html->link('<i class="icon-arrow-down"></i>'.__l('Move down'), array('controller' => 'links', 'action'=>'movedown', $linkId), array('class' => 'move-down', 'title' => __l('Move down'),'escape' => false));?></li>
                <li><?php echo $this->Html->link('<i class="icon-pencil blackc"></i>'.__l('Edit'), array('controller' => 'links', 'action'=>'edit', $linkId), array('class' => 'edit', 'title' => __l('Edit'),'escape' => false));?></li>
                <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('controller' => 'links', 'action'=>'delete', $linkId), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?></li>
              </ul>
            </div>
            </td>
      <td><?php echo $this->Html->cText($linkTitle);?></td>
      <td class="dc <?php echo (!empty($linksStatus[$linkId])) ? 'admin-status-1' : 'admin-status-0'; ?>"><?php echo $this->Html->link($this->Layout->status($linksStatus[$linkId]), array('controller' => 'links', 'action' => 'update_status', $linkId, 'status' => ($linksStatus[$linkId] == 1) ? 'inactive': 'active', 'menu_id' => $menu['Menu']['id']), array('class' => 'js-confirm', 'title' => $this->Html->cText($linkTitle, false), 'escape' => false));?></td>
    </tr>
<?php
		}
	else:
?>
    <tr>
      <td colspan="5" class="notice"><?php echo __l('No links available');?></td>
    </tr>
<?php
	endif;
?>
  </tbody>
</table>
<section class="clearfix">
  <div class="span top-mspace pull-left"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
    		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        <span class="hor-mspace">
        	<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false, 'empty' => __l('-- More actions --'))); ?>
        </span>
    </div>
	</section>
  <div class="hide"> <?php echo $this->Form->submit('Submit'); ?> </div>
<?php echo $this->Form->end(); ?> 
  </div>
