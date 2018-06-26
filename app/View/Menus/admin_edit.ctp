<div class="admin-center-block clearfix">
	<div class="hor-space">
		<div class="menus form thumbnail">
		<ul class="breadcrumb">
		      <li><?php echo $this->Html->link(__l('Menu'), array('action' => 'index'),array('title' => __l('Menu')));?><span class="divider">&raquo</span></li>
		      <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Menu'));?></li>
		    </ul>

		<?php echo $this->Form->create('Menu', array('url' => array('controller' => 'menus', 'action' => 'edit', 'admin' => true),'class' => 'form-horizontal')); ?>
				<fieldset>
					<div id="menu-basic" class="clearfix">
		<?php
			echo $this->Form->input('id');
			echo $this->Form->input('title');
			echo $this->Form->input('alias', array('class' => 'slug'));
		?>
					</div>
					<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Add')); ?>	
						<?php echo $this->Html->link(__l('Cancel') , array('controller' => 'menus', 'action' => 'index'),array('class' => 'btn hor-smspace'));?>

					</div>
				</fieldset>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>