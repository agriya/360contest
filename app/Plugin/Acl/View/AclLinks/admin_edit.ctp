<?php /* SVN: $Id: $ */ ?>
<div class="aclLinks form">
	<?php
		echo $this->Form->create('AclLink', array('class' => 'normal'));
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('controller');
		echo $this->Form->input('action');
		echo $this->Form->input('named_key');
		echo $this->Form->input('named_value');
		echo $this->Form->input('pass_value'); ?>
        <div class="submit-block clearfix">
    	<?php
	       	echo $this->Form->submit(__l('Update'));
	    ?>
	   </div>
		<?php
		echo $this->Form->end();
    	?>
</div>