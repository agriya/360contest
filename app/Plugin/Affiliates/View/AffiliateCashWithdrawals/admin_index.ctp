<div class="affiliateCashWithdrawals index js-response js-admin-index-autosubmit-over-block">
  <section class="page-header no-mar ver-space mspace">
  <div class="top-pattern-contest  container-fluid space">
  <ul class="row no-mar mob-c unstyled top-mspace">
  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Pending');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-off no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Pending') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pending,false).'</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Pending), array('class' => 'blackc', 'escape' => false));?></li>
  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Rejected) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Rejected) ? 'pinkc' : 'blackc'; ?>
    <li class="span dc no-mar" title="<?php echo __l('Rejected');?>">
	<?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-ban-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Rejected') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($rejected,false).'</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Rejected), array('class' => 'blackc', 'escape' => false));?></li>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) ? 'pinkc' : 'blackc'; ?>
    <li class="span dc no-mar" title="<?php echo __l('Success');?>">
	<?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class=" icon-thumbs-up no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Success') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($success,false).'</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index','filter_id' => ConstAffiliateCashWithdrawalStatus::Success), array('class' => 'blackc', 'escape' => false));?></li>  
	<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
   <li class="span dc no-mar" title="<?php echo __l('All');?>">
   <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('All') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($approved + $pending + $rejected + $success,false).'</span>', array('controller'=>'affiliate_cash_withdrawals','action'=>'index'), array('class' => 'blackc', 'escape' => false));?></li>
    </ul>
	</div>
  </section>
  <ul class="nav nav-tabs mspace top-space">
    <li class="active"><a class="blackc" href="#"><i class="icon-th-list blackc"></i><?php echo __l('List'); ?></a></li>
  </ul>
  <?php if($this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved): ?>
    <div class="alert alert-info"><?php echo __l('Following withdrawal request has been submitted to payment geteway API, These are waiting for IPN from the payment geteway API. Eiether it will move to Success or Failed'); ?></div>
  <?php endif; ?>
  <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 4):?>
    <div class="alert alert-info"><?php echo __l('Withdrawal fund frequest which were unable to process will be returned as failed. The amount requested will be automatically refunded to the user.');?></div>
  <?php endif;?>
  <section class="space clearfix">
    <div class="pull-left hor-space">
    <?php echo $this->element('paging_counter');?>
    </div>
  </section>
  <?php echo $this->Form->create('AffiliateCashWithdrawal' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
    <table class="table table-striped table-bordered table-condensed table-hover no-mar">
    <thead>
      <tr>
      <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending):?>
        <th class="select dc"><?php echo __l('Select'); ?></th>
      <?php endif; ?>
      <?php if (!empty($affiliateCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved)):?>
        <th class="dc"><?php echo __l('Action'); ?></th>
      <?php endif;?>
      <th class="dc"><div><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.created', __l('Requested On'));?></div></th>
      <th class="dl"><div><?php echo $this->Paginator->sort('User.username', __l('User'));?></div></th>
      <th class="dr"><div><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.amount', __l('Amount')).' ('.Configure::read('site.currency').')';?> </div></th>
      <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) { ?>
        <th class="dc"><div><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.modified', __l('Paid on'));?></div></th>
      <?php } ?>
      <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
        <th class="dc"><div><?php echo $this->Paginator->sort('AffiliateCashWithdrawal.name', __l('Status'));?></div></th>
      <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($affiliateCashWithdrawals)):
        foreach ($affiliateCashWithdrawals as $affiliateCashWithdrawal):
      ?>
      <tr>
      <?php if (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending):?>
        <td class="select dc"><?php echo $this->Form->input('AffiliateCashWithdrawal.'.$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'label' => false, 'class' => 'js-checkbox-list ' )); ?></td>
      <?php endif; ?>
      <?php if (!empty($affiliateCashWithdrawals) && (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Approved)):?>
        <td class="span1 dc">
        <div class="dropdown top-space">
          <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
          <ul class="unstyled dropdown-menu dl arrow clearfix">
          <li><?php echo $this->Html->link('<i class="icon-hdd"></i>'.__l('Move to success'), array('action' => 'move_to', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'type' => 'success'), array('escape'=>false,'title' => __l('Move to success')));?></li>
          <li><?php echo $this->Html->link('<i class="icon-remove-sign"></i>'.__l('Move to failed'), array('action' => 'move_to', $affiliateCashWithdrawal['AffiliateCashWithdrawal']['id'], 'type' => 'failed'), array('escape'=>false, 'title' => __l('Move to failed')));?></li>
          <?php echo $this->Layout->adminRowActions($affiliateCashWithdrawal['AffiliateCashWithdrawal']['id']);  ?>
          </ul>
        </div>
        </td>
      <?php endif;?>
      <td class="dc"><?php  echo $this->Html->cDateTimeHighlight($affiliateCashWithdrawal['AffiliateCashWithdrawal']['created']);  ?> </td>
      <td class="dl">
        <div class="clearfix">
        <?php echo $this->Html->showImage('UserAvatar', $affiliateCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($affiliateCashWithdrawal['User']['username'], false)));?>
        <?php echo $this->Html->link($this->Html->cText($affiliateCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $affiliateCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($affiliateCashWithdrawal['User']['username'],false),'escape' => false));?>
        <?php
          foreach($affiliateCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
          if(!empty($moneyTransferAccount['PaymentGateway'])):
        ?>
          <span class="label label-contest-status-2"><?php echo $this->Html->cText($moneyTransferAccount['PaymentGateway']['display_name']);?></span>
        <?php
          endif;
          endforeach;
        ?>
        </div>
      </td>
      <td class="dr"><?php echo $this->Html->cCurrency($affiliateCashWithdrawal['AffiliateCashWithdrawal']['amount']);?></td>
      <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Success) { ?>
        <td class="dc">  <?php  echo $this->Html->cDateTimeHighlight($affiliateCashWithdrawal['AffiliateCashWithdrawal']['modified']);  ?> </td>
      <?php } ?>
      <?php if(!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') { ?>
        <td class="dc">
        <?php
          if($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Pending):
          echo __l('Pending');
          elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Approved):
          echo __l('Approved');
          elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Rejected):
          echo __l('Rejected');
          elseif($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['id'] == ConstAffiliateCashWithdrawalStatus::Success):
          echo __l('Success');
          else:
          echo $this->Html->cText($affiliateCashWithdrawal['AffiliateCashWithdrawalStatus']['name']);
          endif;
        ?>
        </td>
      <?php } ?>
      </tr>
      <?php
        endforeach;
      else:
      ?>
      <tr>
      <td colspan="8" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Affiliate Cash Withdrawals'));?></td>
      </tr>
      <?php
      endif;
      ?>
    </tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
    <?php if (!empty($affiliateCashWithdrawals) && (empty($this->request->params['named']['filter_id']) || (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateCashWithdrawalStatus::Pending))):?>
    <div class="admin-select-block pull-left">
      <?php echo __l('Select:'); ?>
      <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
      <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
    </div>
    <div class="admin-checkbox-button pull-left hor-space">
      <div class="input select">
      <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
      </div>
    </div>
    <div class="hide">
      <?php echo $this->Form->submit('Submit');  ?>
    </div>
    <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
    <?php endif; ?>
  </section>
  <?php echo $this->Form->end(); ?>
</div>