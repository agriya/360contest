<?php /* SVN: $Id: admin_add.ctp 6515 2010-06-02 10:45:44Z sreedevi_140ac10 $ */ ?>
<div class="userAddWalletAmounts form container-fluid">
	<div class="admin-center-block clearfix">
		<div class="hor-space">
			<div class="thumbnail">
				<?php echo $this->Form->create('UserAddWalletAmounts', array('action' => 'deduct_fund', 'class' => 'form-large-fields form-horizontal form-large-fields'));?>
				<fieldset>
				<?php
					if(Configure::read('site.currency_symbol_place') == 'left'):
						$currecncy_place = 'between';
					else:
						$currecncy_place = 'after';
					endif;
				?>
			 	<div class="textb mspace offset2">
					<?php echo __l('Available wallet amount: ');?><span class="textn"> <?php echo $this->Html->siteCurrencyFormat($user['User']['available_wallet_amount']); ?></span>
				</div>
				<?php
					echo $this->Form->input('Transaction.user_id', array('type' => 'hidden'));
					echo $this->Form->input('Transaction.amount', array('type' => 'text', 'label' => sprintf(__l('Amount (%s)'), Configure::read('site.currency'))));
					echo $this->Form->input('Transaction.description', array('type' => 'textarea'));
				?>
				</fieldset>
			  <div class="submit-block clearfix">
			  	<?php echo $this->Form->submit(__l('Deduct Fund'));?>
			  </div>
				<?php echo $this->Form->end();?>
			</div>
		</div>
	</div>
</div>