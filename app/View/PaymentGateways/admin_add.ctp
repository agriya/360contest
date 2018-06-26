<?php /* SVN: $Id: $ */ ?>
<div class="paymentGateways form">
  <h2><?php echo __l('Add Payment Gateway');?></h2>
<?php echo $this->Form->create('PaymentGateway', array('class' => 'form-large-fields form-horizontal'));?>
  <fieldset>
<?php
	echo $this->Form->input('name');
	echo $this->Form->input('description');
	echo $this->Form->input('gateway_fees');
	echo $this->Form->input('is_test_mode', array('label' => __l('Test Mode')));
	echo $this->Form->input('is_active', array('label' => __l('Active')));
?>
  </fieldset>
<?php echo $this->Form->end(__l('Add'));?> </div>