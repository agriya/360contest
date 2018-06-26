<?php /* SVN: $Id: $ */ ?>
<div class="contestTypesPricingPackages form">
<?php echo $this->Form->create('ContestTypesPricingPackage', array('class' => 'form-large-fields form-horizontal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('contest_type_id');
		echo $this->Form->input('pricing_package_id');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Update'));?>
</div>