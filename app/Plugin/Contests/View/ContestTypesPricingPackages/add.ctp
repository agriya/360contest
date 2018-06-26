<?php /* SVN: $Id: $ */ ?>
<div class="contestTypesPricingPackages form">
<?php echo $this->Form->create('ContestTypesPricingPackage', array('class' => 'normal'));?>
	<fieldset>
		<legend><?php echo $this->Html->link(__l('Contest Types Pricing Packages'), array('action' => 'index'));?> &raquo; <?php echo __l('Add Contest Types Pricing Package');?></legend>
	<?php
		echo $this->Form->input('contest_type_id');
		echo $this->Form->input('pricing_package_id');
		echo $this->Form->input('price');
	?>
	</fieldset>
<?php echo $this->Form->end(__l('Add'));?>
</div>