<?php /* SVN: $Id: $ */ ?>

<div class="js-response">
<div class="container-fluid">
  <div class = "js-payment-slider">
    <div class="alert js-payment-all hide"> <?php echo __l('Read the warning carefully and enable appropriate options for your website.');?> </div>
  </div>
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
	  <?php echo $this->element('paging_counter');?>
	</div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
    <table class="table table-striped table-hover">
      <thead class="yellow-bg">
        <tr class="sep-top sep-bot">
		  <th rowspan="3" class="sep-right dc sep-left"><?php echo __l('Actions');?></th>
		  <th rowspan="3" class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('display_name'));?></div></th>
		  <th colspan="5" class="dc sep-right"><?php echo __l('Settings');?></th>
		</tr>
        <tr>
		  <th rowspan="2" class="dc sep-right"><?php echo __l('Active');?></th>
		  <th colspan="3" class="dc sep-right"><?php echo __l('Where to use?');?></th>
		</tr>
		<tr>
		  <th class="dc sep-right"><?php echo __l('Wallet');?></th>
		  <th class="dc sep-right"><?php echo __l('Contest Listing');?></th>
		  <th class="dc sep-right"><?php echo __l('Signup');?></th>
		</tr>
	  </thead>
      <tbody>
<?php
			if (!empty($paymentGateways)):
				foreach ($paymentGateways as $paymentGateway):
					$status_class = null;
?>
    <tr>
      <td class="dc span1">
	    <div class="dropdown">
		  <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
          <ul class="dropdown-menu dl arrow">
              <li> <?php echo $this->Html->link('<i class="icon-pencil blackc"></i>'.__l('Edit Configuration'), array('action' => 'edit', $paymentGateway['PaymentGateway']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit Configuration'), 'escape' => false));?><?php echo $this->Layout->adminRowActions($paymentGateway['PaymentGateway']['id']);?> </li>
          </ul>
        </div>
	  </td>
      <td>
	  <?php echo $this->Html->cText($paymentGateway['PaymentGateway']['display_name']);
	  $FindReplace['##PAYMENT_GATEWAY_LINK##']=$this->Html->link( 'PayPal Website Payments Standard', 'https://www.paypal.com/webapps/mpp/paypal-payments-standard' );
		$pay_description = strtr($paymentGateway['PaymentGateway']['description'], $FindReplace);
		?> <span class="show"><?php echo $this->Html->cHtml($pay_description);?></span>
	  </td>
<?php
				$status_str = 0;
				$plugin_name = Inflector::camelize(strtolower($paymentGateway['PaymentGateway']['name']));
				if(!empty($paymentGateway['PaymentGateway']['is_active'])) {
					$status_str = 1;
				}
?>
      <td class="dc <?php echo "admin-status-".$status_str; ?> <?php echo ($paymentGateway['PaymentGateway']['is_active'] ==1 && isPluginEnabled($paymentGateway['PaymentGateway']['display_name']))? 'js-active-gateways': 'js-deactive-gateways'; ?> payment-<?php echo $paymentGateway['PaymentGateway']['id'];?>"><?php echo $this->Html->link(($paymentGateway['PaymentGateway']['is_active'] ==1)? '<i class="icon-ok text-16 top-space blackc"></i><span class="hide">Yes</span>': '<i class="icon-remove text-16 top-space blackc"></i><span class="hide">No</span>', array('action'=>'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::Active, ($paymentGateway['PaymentGateway']['is_active'] ==1)? 0: 1),array('escape' => false,'class'=>'js-no-pjax js-admin-update-status'));?></td>
<?php if($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::Wallet): ?>
      <td class="dc">--</td>
<?php endif; ?>
<?php
	$i=1;
	foreach($paymentGateway['PaymentGatewaySetting'] as $paymentGatewaySetting):
		if($paymentGatewaySetting['name'] == 'is_enable_for_signup'):
		$i++;
?>
      <td class="dc <?php echo "admin-status-".$paymentGatewaySetting['test_mode_value']?>"><?php echo $this->Html->link(($paymentGatewaySetting['test_mode_value'] ==1)? '<i class="icon-ok text-16 top-space blackc"></i><span class="hide">Yes</span>': '<i class="icon-remove text-16 top-space blackc"></i><span class="hide">No</span>', array('action'=>'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::Signup, ($paymentGatewaySetting['test_mode_value'] ==1)? 0: 1),array('escape' => false,'class'=>'js-admin-update-status js-no-pjax'));?></td>
<?php endif; ?>
<?php if($paymentGatewaySetting['name'] == 'is_enable_for_contest_listing'): $i++; ?>
      <td class="dc <?php echo "admin-status-".$paymentGatewaySetting['test_mode_value']?>"><?php echo $this->Html->link(($paymentGatewaySetting['test_mode_value'] ==1)? '<i class="icon-ok text-16 top-space blackc"></i><span class="hide">Yes</span>': '<i class="icon-remove text-16 top-space blackc"></i><span class="hide">No</span>', array('action'=>'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::ContestListing, ($paymentGatewaySetting['test_mode_value'] ==1)? 0: 1),array('escape' => false,'class'=>'js-admin-update-status js-no-pjax'));?></td>
<?php endif; ?>
<?php if($paymentGatewaySetting['name'] == 'is_enable_for_add_to_wallet'): $i++; ?>
      <td class="dc <?php echo "admin-status-".$paymentGatewaySetting['test_mode_value']?>"><?php
				echo $this->Html->link(($paymentGatewaySetting['test_mode_value'] ==1)? '<i class="icon-ok text-16 top-space blackc"></i><span class="hide">Yes</span>': '<i class="icon-remove text-16 top-space blackc"></i><span class="hide">No</span>', array('action'=>'update_status', $paymentGateway['PaymentGateway']['id'], ConstMoreAction::Wallet, ($paymentGatewaySetting['test_mode_value'] ==1)? 0: 1),array('escape' => false,'class'=>'js-admin-update-status js-no-pjax'));
?>
      </td>
<?php endif; ?>
<?php endforeach; ?>
<?php if($paymentGateway['PaymentGateway']['id'] == ConstPaymentGateways::Wallet): ?>
      <td class="dc">--</td>
<?php endif; ?>
    </tr>
<?php
endforeach;
else:
?>
    <tr>
      <td colspan="9" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Payment Gateways'));?></td>
    </tr>
<?php
endif;
?>
</tbody>
  </table>
<?php if (!empty($paymentGateways)): ?>
 <div class="span top-mspace pull-right">
        <div class="pull-right">
          <?php echo $this->element('paging_links'); ?>
        </div>
      </div>
<?php endif; ?>
</div>
</div>