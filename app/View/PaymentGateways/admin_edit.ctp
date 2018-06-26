<?php /* SVN: $Id: admin_edit.ctp 2895 2010-09-02 10:58:05Z sakthivel_135at10 $ */ ?>
<div class="hor-space">
<div class="paymentGateways form space thumbnail">
  <?php echo $this->Form->create('PaymentGateway', array('class' => 'form-horizontal space setting-add-form add-live-form  form-large-fields'));?>
  <ul class="breadcrumb">
  <li><?php echo $this->Html->link(__l('Payment Gateways'), array('action' => 'index'), array('title' => __l('Payment Gateways')));?><span class="divider">&raquo</span></li>
  <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Payment Gateway'));?></li>
  </ul>
  <ul class="nav nav-tabs">
  <li>
  <?php echo $this->Html->link('<i class="icon-th-list blackc"></i>'.__l('List'), array('action' => 'index'),array('class' => 'blackc', 'title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
  </li>
  <li class="active"><a class="blackc" href="#add_form"><i class="icon-edit"></i><?php echo __l('Edit');?></a></li>
  </ul>
  <div>
	<?php
		if(!empty($SudoPayGatewaySettings['sudopay_merchant_id']) && $id == ConstPaymentGateways::SudoPay) {
			echo $this->element('sudopay-info', array('cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
		}
	?>
  </div>
  <fieldset class="offset1">
    <?php
    echo $this->Form->input('id'); ?>
	<?php if ($this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet): ?>
		<div class="input checkbox mob-no-mar">
			<?php echo $this->Form->input('is_live_mode', array('type' => 'checkbox', 'label' => __l('Live Mode?'), 'info' => __l('On enabling this, live account will used instead of sandbox payment details. (Enable this, When site is in production stage)'), 'div' => false)); ?>
		</div>
	<?php endif; ?>
	<?php
    foreach($paymentGatewaySettings as $paymentGatewaySetting) {
      $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
	  if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_contest_listing'):
			$options['label'] = __l('Enable for Contest listing');
	  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup'):
			$options['label'] = __l('Enable for Signup');
	  elseif($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
			$options['label'] = __l('Enable for add to wallet');
	  endif;
      $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
      $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
      if($options['type'] == 'checkbox' && !empty($options['value'])):
      $options['checked'] = 'checked';
      else:
      $options['checked'] = '';
      endif;
      if($options['type'] == 'select'):
      $selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
      $paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
      if(!empty($selectOptions)):
        foreach($selectOptions as $key => $value):
        if(!empty($value)):
          $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
        endif;
        endforeach;
      endif;
      $options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
      endif;
      if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
      $options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
      else:
      $options['help'] = '';
      endif;
      if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_contest_listing' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_signup' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'is_enable_for_add_to_wallet'):
      echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options);
      endif;
    }
    if ($paymentGatewaySettings && $this->request->data['PaymentGateway']['id'] != ConstPaymentGateways::Wallet) {
    ?>
	<div class="clearfix">
		<div class="span12">
			<span class="show textb dr"><?php echo __l('Test Mode'); ?></label>
		</div>
		<div class="span12">
			<span class="show textb dr"><?php echo __l('Live Mode'); ?></label>
		</div>
	</div>
    <?php
    $j = $i = $z = $n = $x= 0;
    foreach($paymentGatewaySettings as $paymentGatewaySetting) {
      $options['type'] = $paymentGatewaySetting['PaymentGatewaySetting']['type'];
      $options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['test_mode_value'];
      $options['div'] = array('id' => "setting-{$paymentGatewaySetting['PaymentGatewaySetting']['name']}");
      if($options['type'] == 'checkbox' && $options['value']):
      $options['checked'] = 'checked';
      endif;
      if($options['type'] == 'select'):
            $selectOptions = explode(',', $paymentGatewaySetting['PaymentGatewaySetting']['options']);
            $paymentGatewaySetting['PaymentGatewaySetting']['options'] = array();
            if(!empty($selectOptions)):
              foreach($selectOptions as $key => $value):
                if(!empty($value)):
                  $paymentGatewaySetting['PaymentGatewaySetting']['options'][trim($value)] = trim($value);
                endif;
              endforeach;
            endif;
            $options['options'] = $paymentGatewaySetting['PaymentGatewaySetting']['options'];
          endif;
      $options['label'] = false;
      if (!empty($paymentGatewaySetting['PaymentGatewaySetting']['description']) && empty($options['after'])):
      $options['help'] = "{$paymentGatewaySetting['PaymentGatewaySetting']['description']}";
      else:
      $options['help'] = '';
      endif;
    ?>
      </fieldset>
      <?php if($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string' || $paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key'): ?>
	  <?php if($x == 0):?>
        <h3><?php echo __l('ZazPay API Details'); ?></h3>
      <?php endif;?>
		<div class="clearfix">
          <label class="pull-left">
			<?php
				if ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_merchant_id') {
					echo __l('Merchant ID in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_website_id') {
					echo __l('Website ID in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_secret_string') {
					echo __l('Secret Key in ZazPay');
				} elseif ($paymentGatewaySetting['PaymentGatewaySetting']['name'] == 'sudopay_api_key') {
					echo __l('API Key in ZazPay');
				}
			?>
		  </label>
          <div class="offset2 clearfix pull-left hor-space">
			<div class="pull-left hor-mspace hor-space">
				<?php echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.test_mode_value", $options); ?>
			</div>
			<div class="pull-left hor-mspace hor-space">
			  <?php
				$options['value'] = $paymentGatewaySetting['PaymentGatewaySetting']['live_mode_value'];
				echo $this->Form->input("PaymentGatewaySetting.{$paymentGatewaySetting['PaymentGatewaySetting']['id']}.live_mode_value", $options);
			  ?>
			</div>
          </div>
        </div>
      <?php $x++;?>
	  <?php endif; ?>
  <?php
      }
  }
  if ($this->request->data['PaymentGateway']['id'] == ConstPaymentGateways::SudoPay):
	  if(!empty($sudopayPaymentGateways)) {
  ?>
	  <div>
		<table class="table table-bordered table-striped table-condensed no-mar">
			<thead>
				<tr>
					<th><?php echo __l("Gateways"); ?></th>
					<th><?php echo __l("Payout Hold Period"); ?></th>
				</tr>
			</thead>
			 <tbody>
			 <?php
				foreach($sudopayPaymentGateways as $sudopayGateway) {
					$gateway_datails = unserialize($sudopayGateway['SudopayPaymentGateway']['sudopay_gateway_details']);
			 ?>
				<tr class="ui-state-default">
				   <td>
						<div class="span clearfix no-mar">
							<div class="hor-space">
							  <span class="show show"><?php echo $sudopayGateway['SudopayPaymentGateway']['sudopay_gateway_name']; ?></span>
								<span class="show top-smspace">
									<span class="span no-mar">
										<?php echo $this->Html->image($gateway_datails['thumb_url']); ?>
									</span>
							   </span>
							 </div>
						</div>
					</td>
					<td>
						<?php echo $this->Form->input("SudopayPaymentGateway.{$sudopayGateway['SudopayPaymentGateway']['id']}.days_after_amount_paid",array('label' => false, 'value' => $sudopayGateway['SudopayPaymentGateway']['days_after_amount_paid']));?>
					</td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	  </div>
	  <?php } ?>
  <?php endif; ?>
  <div class="offset4 space clearfix">
  <?php echo $this->Form->end(__l('Update'));?>
  </div>
</div>
</div>