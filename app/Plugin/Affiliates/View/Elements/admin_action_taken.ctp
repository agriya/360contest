<ul class="unstyled">
  <li><b><?php echo __l('Affiliate Requests');?></b></li>
  <li><i class="icon-caret-right grayc"></i><?php echo $this->Html->link(__l('Pending') . ' (' . $waiting_for_approval. ')', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Pending), array('class' => 'grayc'));?></li>
  <li><b><?php echo __l('Affiliate Withdraw Requests');?></b></li>
  <li><i class="icon-caret-right grayc"></i><?php echo $this->Html->link(__l('Pending') . ' (' . $cash_withdrawal_waiting_for_approval. ')', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','main_filter_id' => ConstAffiliateRequests::Pending), array('class' => 'grayc'));?></li>
</ul>