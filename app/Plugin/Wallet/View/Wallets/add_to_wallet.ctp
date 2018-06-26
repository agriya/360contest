<?php /* SVN: $Id: $ */ ?>
<div class="clearfix">
<h2 class="ver-space ver-mspace span"><?php echo __l('Add Amount to Wallet');?></h2>
	  <div class="ver-space">
		<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
	  </div>
</div>
<div class="payments order add-wallet  js-responses js-main-order-block thumbnail sep">
	<?php
		if(isset($this->request->data['UserAddWalletAmount']['wallet']) && $this->request->data['UserAddWalletAmount']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
			echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
		} else {
	  ?>
	<div class="alert alert-info"><i class="icon-info-sign"></i>
		<?php echo __l('Your Current Available Balance:').' '. $this->Html->siteCurrencyFormat($user_info['User']['available_wallet_amount']);?>
	</div>
  
  <?php
		echo $this->Form->create('Wallet', array('controller' => 'wallets', 'action' => 'add_to_wallet', 'class' => 'form-horizontal js-submit-target payment-form'));
		if (!Configure::read('wallet.max_wallet_amount')):
			$max_amount = 'No limit';
		else:
			$max_amount = $this->Html->siteCurrencyFormat(Configure::read('wallet.max_wallet_amount'));
		endif;
		
		echo $this->Form->input('UserAddWalletAmount.amount', array('type' => 'text', 'label' => __l('Amount'), 'after' => Configure::read('site.currency') . '<span class="info"><span class="span top-smspace"><i class="icon-info-sign"></i></span><span class="span no-mar">' . sprintf(__l('Minimum Amount: %s <br/> Maximum Amount: %s'),$this->Html->siteCurrencyFormat(Configure::read('wallet.min_wallet_amount')), $max_amount) . '</span></span>'));
	?>
	<fieldset class="form-block">
		<legend><?php echo __l('Select Payment Type');?></legend>
		<?php echo $this->element('payment-get_gateways', array('model'=>'UserAddWalletAmount','type'=>'is_enable_for_add_to_wallet','is_enable_wallet'=>0, 'cache' => array('config' => 'sec')));?>
	</fieldset>
  <?php echo $this->Form->end();?>
  <?php } ?>
</div>