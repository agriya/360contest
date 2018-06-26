<?php /* SVN: $Id: $ */ ?>

<div class="paymentGatewaySettings index">
  <h2><?php echo __l('Payment Gateway Settings');?></h2>
  <?php echo $this->element('paging_counter');?>
  <table class="list">
    <tr>
      <th class="actions"><?php echo __l('Actions');?></th>
      <th><?php echo $this->Paginator->sort('payment_gateway_id');?></th>
      <th><?php echo $this->Paginator->sort('name');?></th>
      <th><?php echo $this->Paginator->sort('value');?></th>
      <th><?php echo $this->Paginator->sort('description');?></th>
    </tr>
<?php
	if (!empty($paymentGatewaySettings)):
		$i = 0;
		foreach ($paymentGatewaySettings as $paymentGatewaySetting):
			$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
?>
    <tr<?php echo $class;?>>
      <td class="actions"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $paymentGatewaySetting['PaymentGatewaySetting']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span> <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $paymentGatewaySetting['PaymentGatewaySetting']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></span> <?php echo $this->Layout->adminRowActions($paymentGatewaySetting['PaymentGatewaySetting']['id']);?> </td>
      <td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGateway']['display_name']);?></td>
      <td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['name']);?></td>
      <td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['value']);?></td>
      <td><?php echo $this->Html->cText($paymentGatewaySetting['PaymentGatewaySetting']['description']);?></td>
    </tr>
<?php
endforeach;
else:
?>
    <tr>
      <td colspan="5" class="notice"><?php echo sprintf(__l('No %s available'), __l('Payment Gateway Settings'));?></td>
    </tr>
<?php
endif;
?>
  </table>
<?php
if (!empty($paymentGatewaySettings)) {
	echo $this->element('paging_links');
}
?>
</div>
