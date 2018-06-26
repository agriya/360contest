<?php /* SVN: $Id: $ */ ?>
<div class="userOpenids form">
<?php echo $this->Form->create('UserOpenid', array('class' => 'form-large-fields form-horizontal'));?>
	<fieldset>
 	<?php
		echo $this->Form->input('user_id');
		echo $this->Form->input('openid');
		echo $this->Form->input('verify',array('type' => 'checkbox'));
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>
