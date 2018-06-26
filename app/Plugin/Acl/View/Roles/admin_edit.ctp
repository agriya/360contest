<?php /* SVN: $Id: $ */ ?>
<div class="Roles form">
	<?php 
		echo $this->Form->create('Role', array('class' => 'normal'));
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->end(__l('Update'));
	?>
</div>