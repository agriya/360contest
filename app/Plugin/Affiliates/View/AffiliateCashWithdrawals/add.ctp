<?php /* SVN: $Id: $ */ ?>
<div class="affiliateCashWithdrawals form js-ajax-form-container">
  <div class="clearfix">
    <div class="pull-right">
      <?php echo $this->Html->link('<i class="icon-group"></i> ' . __l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'), array('escape' => false, 'class' => 'blackc', 'title' => __l('Affiliates'))); ?>
    </div>
  </div>
  <div class="user-edit-form-block">
    <?php
      if ($this->Auth->user('role_id') == ConstUserTypes::User) {
        $min = Configure::read('affiliate.payment_threshold_for_threshold_limit_reach');
        $cleared_amount = $logged_in_user['User']['commission_line_amount'];
        $transaction_fee = Configure::read('affiliate.site_commission_amount');
        $transaction_fee_type = Configure::read('affiliate.site_commission_type');
        if (!empty($transaction_fee)) {
          $transactions = ($transaction_fee_type == 'amount') ? $transaction_fee : $transaction_fee.'%';
          $transactions = '<br/>'.__l('Site Transaction Fee').': '.$this->Html->siteCurrencyFormat($this->Html->cCurrency($transactions, false));
        } else {
          $transactions = '';
        }
      }
    ?>
    <?php
      echo $this->Form->create('AffiliateCashWithdrawal', array('class' => "clearfix form-horizontal  js-ajax-form {container:'js-ajax-form-container',responsecontainer:'js-responses'}"));
      echo $this->Form->input('user_id', array('type' => 'hidden'));
    ?>
    <div class="pull-left">
      <?php echo $this->Form->input('amount',array('label' => __l('Amount'),'after' => Configure::read('site.currency') . '<span class="info grayc"><i class="grayc icon-info-sign"></i> ' . sprintf(__l('Minimum withdraw amount: %s <br/>  Total affiliate Commission amount earned: %s  %s'),$this->Html->siteCurrencyFormat($this->Html->cCurrency($min, false)), $this->Html->siteCurrencyFormat($this->Html->cCurrency($cleared_amount, false)), $transactions . '</span>')));?>
      <?php echo $this->Form->submit(__l('Request Withdraw'));?>
    </div>
    <?php echo $this->Form->end();?>
  </div>
</div>