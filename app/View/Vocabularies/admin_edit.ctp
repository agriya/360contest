<div class="hor-space">
<div class="vocabularies form thumbnail">
	<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Vocabularies'), array('action' => 'index'),array('title' => __l('Vocabularies')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Vocabulary'));?></li>
    </ul>
	<?php echo $this->Form->create('Vocabulary', array('class' => 'form-large-fields form-horizontal', 'action' => 'edit'));?>
		<fieldset>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('title');
				echo $this->Form->input('alias', array('class' => 'slug'));
				echo $this->Form->input('Type.Type');
			?>
		</fieldset>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Save')); ?>
				<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'),array('class'=>'btn hor-smspace')); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
</div>