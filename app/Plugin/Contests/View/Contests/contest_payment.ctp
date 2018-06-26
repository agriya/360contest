<?php /* SVN: $Id: pay_now.ctp 1960 2010-05-21 14:46:46Z jayashree_028ac09 $ */ ?>
<div class="payments contest fee">
<h2><?php echo __l('Step 1. What do you want launch?');?></h2>
<h2><?php echo __l('Step 2. Contest Brief');?></h2>
<h2><?php echo __l('Step 3. Payment');?></h2>
<h2><?php echo __l('Step 3. Payment');?></h2>
 <?php echo $this->Form->create('Contest', array('url' => array('controller' => 'contests', 'action' => 'contest_payment', $contest['Contest']['id']), 'class' => 'normal clearfix js-submit-target'));
 echo $this->Form->input('Contest.id',array('type'=>'hidden'));
 ?>
<dl class="payment-list round-5 clearfix"><?php $i = 0; $class = ' class="altrow"';?>
	<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Total Costs');?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->siteCurrencyFormat($total_amount);?></dd>
</dl>
<?php 	$currency_code = Configure::read('site.currency_id');?>
<div class="page-info"><?php echo __l('This payment transacts in '). Configure::read('site.currency').Configure::read('site.currency_code').__l('. Your total charge is ').$this->Html->siteCurrencyFormat($total_amount);?></div>
<fieldset class="form-block">
	<legend><?php echo __l('Select Payment Type');?></legend>
		<?php  echo $this->element('payment-get_gateways', array('model'=>'Contest','type'=>'is_enable_for_contest_listing','is_enable_wallet'=>1,'foreign_id' => $this->request->data['User']['id'], 'transaction_type' => ConstPaymentType::ContestFee,'cache' => array('config' => 'sec')));?>
	
</fieldset>
<?php echo $this->Form->end();?>
</div>