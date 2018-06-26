<?php /* SVN: $Id: admin_index.ctp 69757 2011-10-29 12:35:25Z josephine_065at09 $ */ ?>
<?php
  if(!empty($this->request->params['isAjax'])):
    echo $this->element('flash_message');
  endif;
?>
<div class="affiliateCashWithdrawals index js-response">
  <?php echo $this->Form->create('AffiliateCashWithdrawal' , array('class' => 'normal','action' => 'pay_to_user')); ?>
  <table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
      <th><div><?php echo $this->Paginator->sort('User.username', __l('User'));?></div></th>
      <th><div><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.amount', __l('Amount')).' ('.Configure::read('site.currency').')';?> </div></th>
      <th class="dl"><?php echo __l('Gateway');?></th>
      <th><div><?php echo $this->Paginator->sort('User.commission_paid_amount', __l('Paid Amount'));?></div></th>
    </tr>
    <?php
      if (!empty($affiliateCashWithdrawals)):
        $i = 0;
        foreach ($affiliateCashWithdrawals as $affiliateCashWithdrawal):
          $i++;
    ?>
    <tr>
      <td class="dl">
        <div class="paypal-status-info">
          <?php
            foreach($affiliateCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
              if(!empty($moneyTransferAccount['PaymentGateway'])):
          ?>
            <span class="grid_right"><?php echo $this->Html->cText($moneyTransferAccount['PaymentGateway']['display_name']);?></span>
          <?php
              endif;
            endforeach;
          ?>
          <?php echo $this->Form->input('AffiliateCashWithdrawal.'.($i-1).'.id', array('type' => 'hidden', 'value' => $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'label' => false)); ?>
          <?php echo $this->Html->getUserAvatarLink($affiliateCashWithdrawal['User'], 'micro_thumb', true, '', 'admin');  ?>
          <?php echo $this->Html->getUserLink($affiliateCashWithdrawal['User']);?>
        </div>
      </td>
      <td class="dl"><?php echo $this->Html->cCurrency($affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount']);?></td>
      <td class="dl">
        <?php echo $this->Form->input('AffiliateCashWithdrawal.'.($i-1).'.gateways',array('type' => 'select', 'options' => $affiliateCashWithdrawal['paymentways'], 'label' => false, 'class' => "js-payment-gateway_select {container:'js-info-".($i-1)."-container'}")); ?>
        <div class="<?php echo "js-info-".($i-1)."-container"; ?>">
          <?php echo $this->Form->input('AffiliateCashWithdrawal.'.($i-1).'.info',array('type' => 'textarea', 'label' => false, 'info' => 'Info for Paid')); ?>
        </div>
      </td>
      <td class="dr"><?php echo $this->Html->siteCurrencyFormat($affiliateCashWithdrawal['User']['commission_paid_amount']); ?></td>
    </tr>
    <?php
        endforeach;
      else:
    ?>
    <tr>
      <td colspan="8" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Affiliate Cash Withdrawals'));?></td>
    </tr>
    <?php
      endif;
    ?>
  </table>
  <?php echo $this->Form->submit(__l('Proceed')); ?>
  <?php echo $this->Form->end(); ?>
</div>