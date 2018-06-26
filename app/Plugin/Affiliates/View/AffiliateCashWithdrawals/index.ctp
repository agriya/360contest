<?php /* SVN: $Id: index.ctp 1721 2010-04-17 11:06:44Z preethi_083at09 $ */ ?>
<div class="clearfix">
  <div class="container"><h2 class="ver-space ver-mspace"><?php echo __l('Affiliate Cash Withdrawal Requests');?></h2></div>
  <?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
</div>
<div class="container">
<div class="thumbnail main-section">
  <div class="userCashWithdrawals index js-response js-withdrawal_responses js-responses">
    <?php if(!empty($moneyTransferAccounts)) { ?>
      <?php echo $this->element('withdrawals-add'); ?>
    <?php } else { ?>
      <div class="alert alert-info"><b><?php echo $this->Html->link(__l('Your money transfer account is empty, so click here to update your money transfer account.'), array('controller' => 'money_transfer_accounts', 'action'=>'index'), array('title' => sprintf(__l('Edit %s'), __l('Money Transfer Account')))); ?></b></div>
    <?php } ?>
    <?php echo $this->element('paging_counter');?>
    <table class="table table-striped table-bordered table-condensed table-hover">
      <tr>
        <th><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.created', __l('Requested On'));?></th>
        <th class="dr"><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.amount', __l('Requested Amount').' ('.Configure::read('site.currency').')');?></th>
        <th><?php echo $this->Paginator->sort(__l('Transaction Fee ('.Configure::read('site.currency').')'));?></th>
        <th><?php echo $this->Paginator->sort(__l('Paid Amount (Requested Amount - Transaction Fee) ('.Configure::read('site.currency').')'));?></th>
        <th><?php echo $this->Paginator->sort('AffiliateCashWithdrawalStatus.name', __l('Status'));?></th>
      </tr>
      <?php
        if (!empty($userCashWithdrawals)):
          $i = 0;
          foreach ($userCashWithdrawals as $userCashWithdrawal):
            $i++;
      ?>
      <tr>
        <td><?php echo $this->Html->cDateTime($userCashWithdrawal['AffiliateCashWithdrawal']['created']);?></td>
        <td class="dr"><?php echo $userCashWithdrawal['AffiliateCashWithdrawal']['amount'];?></td>
        <td><?php echo  $this->Html->cCurrency($userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount']);?></td>
        <td>
          <?php
            if($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] != ConstAffiliateCashWithdrawalStatus::Rejected)
              echo $this->Html->cCurrency(($userCashWithdrawal['AffiliateCashWithdrawal']['amount'] - $userCashWithdrawal['AffiliateCashWithdrawal']['commission_amount']));
            else
              echo '--';
          ?>
        </td>
        <td>
          <?php
            if($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
              echo __l('Pending');
            elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
              echo __l('Under Process');
            elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
              echo __l('Rejected');
            elseif($userCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
               echo __l('Success');
            else:
              echo $this->Html->cText($userCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
            endif;
          ?>
        </td>
      </tr>
      <?php
          endforeach;
        else:
      ?>
      <tr>
        <td colspan="8">
		<div class="thumbnail space dc grayc">
        <p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Affiliate Cash Withdrawals'));?></p>
      </div>
		</td>
      </tr>
      <?php endif; ?>
    </table>
    <?php if (!empty($userCashWithdrawals)) { ?>
      <div class="clearfix"><div class="pull-right js-pagination js-no-pjax"> <?php echo $this->element('paging_links'); ?> </div></div>
    <?php } ?>
  </div>
</div>
</div>