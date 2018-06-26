<?php
	echo $this->Html->scriptBlock('base = "' . $this->base. '";'); 
	echo $this->Form->create('FormField');
	echo $this->Form->hidden('id');
	echo $this->Form->hidden('form_field_group_id');
	echo $this->Form->input('depends_on', array('before' => 'If this field is only required based on the value of another field, enter the name of that field here, and the required value of that field below'));
	echo $this->Form->input('depends_value');
	echo $this->Form->input('ValidationRule'); 
	?>
    <div class="submit-block clearfix">
	<?php echo $this->Form->submit('Update'); ?>
	</div>
	<?php echo $this->Form->end(); ?>
