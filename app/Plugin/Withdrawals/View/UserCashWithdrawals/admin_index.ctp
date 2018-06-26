<?php /* SVN: $Id: admin_index.ctp 69575 2011-10-25 05:50:05Z sakthivel_135at10 $ */ ?>
  <section class="page-header no-mar ver-space">
  <div class="top-pattern-contest  container-fluid space">
  <ul class="row no-mar mob-c unstyled top-mspace">
  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Pending');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-off no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Pending') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pending,false).'</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Pending), array('class' => 'blackc', 'escape' => false));?></li>
  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Rejected) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Rejected) ? 'pinkc' : 'blackc'; ?>
    <li class="span dc no-mar" title="<?php echo __l('Rejected');?>">
	<?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-ban-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Rejected') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($rejected,false).'</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Rejected), array('class' => 'blackc', 'escape' => false));?></li>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Success) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Success) ? 'pinkc' : 'blackc'; ?>
    <li class="span dc no-mar" title="<?php echo __l('Success');?>">
	<?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class=" icon-thumbs-up no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Success') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($success,false).'</span>', array('controller'=>'user_cash_withdrawals','action'=>'index','filter_id' => ConstWithdrawalStatus::Success), array('class' => 'blackc', 'escape' => false));?></li>    
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') ? 'pinkc' : 'grayc'; ?>
    <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == 'all') ? 'pinkc' : 'blackc'; ?>
   <li class="span dc no-mar" title="<?php echo __l('All');?>">
   <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('All') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($approved + $pending + $rejected + $success,false).'</span>', array('controller'=>'user_cash_withdrawals','action'=>'index'), array('class' => 'blackc', 'escape' => false));?></li>
    </ul>
	</div>
  </section>
  <?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
    <div class="alert alert-info">
      <?php echo __l('Following withdrawal request has been submitted to payment gateway API, These are waiting for IPN from the payment gateway API. Either it will move to Success or Failed'); ?>
    </div>
  <?php endif; ?>
  <section class="space clearfix">
    <div class="pull-left hor-space">
      <?php echo $this->element('paging_counter');?>
    </div>
  </section>
  <?php echo $this->Form->create('UserCashWithdrawal' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <section class="space">
    <table class="table table-striped table-bordered table-condensed table-hover no-mar">
      <thead>
        <tr>
          <?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
            <th class="span2 dc"><?php echo __l('Select'); ?></th>
          <?php endif;?>
          <th class="dc"><?php echo __l('Actions'); ?></th>
          <th class="dl"><div><?php echo $this->Paginator->sort('User.username', __l('User'));?></div></th>
          <th class="dr"><div><?php echo $this->Paginator->sort('UserCashWithdrawal.amount', __l('Amount')).' ('.Configure::read('site.currency').')';?> </div></th>
          <?php if(empty($this->request->params['named']['filter_id'])) { ?>
            <th><div><?php echo $this->Paginator->sort('WithdrawalStatus.name', __l('Status'));?></div></th>
          <?php } ?>
          <th class="dr"><div><?php echo $this->Paginator->sort('UserCashWithdrawal.created', __l('Withdraw Requested Date'));?> </div></th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (!empty($userCashWithdrawals)):
            foreach ($userCashWithdrawals as $userCashWithdrawal):
        ?>
        <tr>
          <?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
            <td class="select dc">
              <?php echo $this->Form->input('UserCashWithdrawal.'.$userCashWithdrawal['UserCashWithdrawal']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userCashWithdrawal['UserCashWithdrawal']['id'], 'label' => false, 'class' => 'js-checkbox-list ' )); ?>
            </td>
          <?php endif;?>
          <td class="span1 dc">
            <div class="dropdown top-space">
              <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog greenc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
              <ul class="unstyled dropdown-menu dl arrow clearfix">
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>' . __l('Delete'), array('action' => 'delete', $userCashWithdrawal['UserCashWithdrawal']['id']), array('class' => 'js-confirm ', 'escape' => false, 'title' => __l('Delete')));?></li>
                <?php if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Approved): ?>
                  <li><?php echo $this->Html->link('<i class="icon-hdd"></i> ' . __l('Move to success'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'success'), array('escape' => false, 'title' => __l('Move to success')));?></li>
                  <li><?php echo $this->Html->link('<i class="icon-remove-sign"></i> ' . __l('Move to failed'), array('action' => 'move_to', $userCashWithdrawal['UserCashWithdrawal']['id'], 'type' => 'failed'), array('class' => '', 'escape' => false, 'title' => __l('Move to failed')));?></li>
                <?php endif;?>
                <?php echo $this->Layout->adminRowActions($userCashWithdrawal['UserCashWithdrawal']['id']);  ?>
              </ul>
            </div>
          </td>
          <td class="dl">
            <?php echo $this->Html->showImage('UserAvatar', $userCashWithdrawal['User']['UserAvatar'], array('dimension' => 'micro_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($userCashWithdrawal['User']['username'], false)), 'title' => $this->Html->cText($userCashWithdrawal['User']['username'], false)));?>
            <?php echo $this->Html->link($this->Html->cText($userCashWithdrawal['User']['username']), array('controller'=> 'users', 'action'=>'view', $userCashWithdrawal['User']['username'],'admin' => false), array('title'=>$this->Html->cText($userCashWithdrawal['User']['username'],false),'escape' => false));?>
            <?php
			  if($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending):
					foreach($userCashWithdrawal['User']['MoneyTransferAccount'] as $moneyTransferAccount):
					if(!empty($moneyTransferAccount['is_default'])):
				?>
				<?php
					endif;
				  endforeach;
			  endif;
            ?>
          </td>
          <td class="dr">
			<?php echo $this->Html->cCurrency($userCashWithdrawal['UserCashWithdrawal']['amount']);?>
			<?php if(!empty($userCashWithdrawal['UserCashWithdrawal']['remark'])): ?>
			<span class="js-tooltip" title="<?php echo $this->Html->cText($userCashWithdrawal['UserCashWithdrawal']['remark'], false); ?>"><i class="icon-question-sign"></i></span>
			<?php endif; ?>
		  </td>
          <?php if(empty($this->request->params['named']['filter_id'])) { ?>
            <td><?php echo $this->Html->cText($userCashWithdrawal['WithdrawalStatus']['name']);?></td>
          <?php } ?>
          <td class="dr span5"><?php echo $this->Html->cDate($userCashWithdrawal['UserCashWithdrawal']['created']);?></td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td colspan="8" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('User Cash Withdrawals'));?></td>
        </tr>
        <?php
          endif;
        ?>
      </tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
    <?php if (!empty($userCashWithdrawals)) { ?>
      <?php if(isset($this->request->params['named']['filter_id']) && ($this->request->params['named']['filter_id'] == ConstWithdrawalStatus::Pending)):?>
      <div class="span top-mspace pull-left">
		<span class="grayc"><?php echo __l('Select:'); ?></span>
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-no-pjax hor-mspace js-admin-select-all', 'title' => __l('All'))); ?>
    	<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-no-pjax js-admin-select-none','title' => __l('None'))); ?>
    	<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit hor-mspace', 'label' => false, 'div' => false,'empty' => __l('-- More actions --'))); ?>
        </span>
      </div>
        <div class="hide">
          <?php echo $this->Form->submit('Submit');  ?>
        </div>
      <?php endif; ?>
      <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
    <?php } ?>
  </section>
  <?php echo $this->Form->end(); ?>