<div class="admin-center-block clearfix">
	<div class="hor-space">
		<div class="menus form thumbnail"> 
		<ul class="breadcrumb">
		      <li><?php echo $this->Html->link(__l('Menu'), array('action' => 'index'),array('title' => __l('Menu')));?><span class="divider">&raquo</span></li>
		      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Menu'));?></li>
		    </ul>
			<?php echo $this->Form->create('Menu', array('url' => array('controller' => 'menus', 'action' => 'add','admin' => true),'class' => 'form-horizontal')); ?>
		  <fieldset>
		  <div id="menu-basic">
		<?php
			echo $this->Form->input('title');
			echo $this->Form->input('alias', array('class' => 'slug'));
		?>
		  </div>
		  <div class="submit-block clearfix">
		<?php
			echo $this->Form->submit(__l('Add'));
			if(!empty($this->request->params['requested'])) {
				echo $this->Form->submit(__l('Cancel'),array('class' => 'js-toggle-div {"divClass":"js-show-user-type-add"}'));
			} else {
		?>
		<?php echo $this->Html->link(__l('Cancel') , array('controller' => 'menus', 'action' => 'index'),array('class' => 'btn hor-smspace'));?>
		   
		<?php } ?>
		  </div>
		  </fieldset>
		<?php echo $this->Form->end(); ?> 
		 </div>
	</div>
 </div>