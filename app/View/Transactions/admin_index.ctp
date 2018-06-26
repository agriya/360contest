<?php /* SVN: $Id: admin_index.ctp 2077 2010-04-20 10:42:36Z josephine_065at09 $ */ ?>
<?php $debit_total_amt = $credit_total_amt = 0;
$value = '';
if(!empty($username)){
	$value = $username;
}?>
<div class="clearfix">
<div class="js-response">
  <div class="top-pattern">
    <div class="container-fluid space">
	  <ul class="row no-mar mob-c unstyled top-mspace">
			  <?php $class = (empty($this->request->params['named']['filter'])) ? 'pinkc' : 'grayc'; ?>
			<li class="span dc no-mar filter-admin <?php echo !(!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'all') ? 'active' : ''; ?>"><?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-user no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' .__l('Admin') . '</span></div>', array('controller' => 'transactions', 'action' => 'index'), array('title' => __l('Admin'), 'escape' => false, 'class'=>"blackc")); ?></li>
			<?php $class = (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'all') ? 'pinkc' : 'grayc'; ?>
			<li class="span dc no-mar filter-all  <?php echo (!empty($this->request->params['named']['filter']) && $this->request->params['named']['filter'] == 'all') ? 'active' : ''; ?>"><?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' .__l('All') . '</span></div>', array('controller' => 'transactions', 'action' => 'index', 'filter' => 'all'), array('title' => __l('All'), 'escape' => false, 'class'=>"blackc")); ?></li>
	  </ul>
	</div>
  </div>
  <div class="hor-space">
    <div class="row space bot-mspace">
      <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
      </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
		<?php if (!empty($this->request->params['named']['filter'])): ?>
			<?php echo $this->Form->create('Transaction' , array('url' => array('controller' => 'transactions', 'action' => 'admin_index', 'filter' => $this->request->params['named']['filter']), 'type' => 'post', 'class' => 'form-search no-mar dc')); ?>
		<?php else: ?>
			<?php echo $this->Form->create('Transaction' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'form-search no-mar dc')); ?>
		<?php endif; ?>
		<?php echo $this->Form->autocomplete('User.username', array('value'=>$value,'label' => __l('User'), 'div' => array('class' => 'input'), 'acFieldKey' => 'Transaction.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'input-medium ver-smspace search-query span4')); ?>
		<div class="input date-time clearfix hor-mspace">
            <div class="js-boostarp-datetime">
			  <div class="js-cake-date">
                <?php echo $this->Form->input('from_date', array('label' => __l('From'), 'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
              </div>
			</div>
        </div>
        <div class="input date-time clearfix hor-mspace">
            <div class="js-boostarp-datetime">
          		<div class="js-cake-date">
                <?php echo $this->Form->input('to_date', array('label' => __l('To'),  'type' => 'date', 'orderYear' => 'asc', 'minYear' => date('Y')-10, 'maxYear' => date('Y'), 'div' => false, 'empty' => __l('Please Select'))); ?>
            </div>
			</div>
        </div>
		<button type="submit" class="btn btn-success textb hor-mspace">Filter</button>
		<?php echo $this->Form->end(); ?>
	  </div>
	  <?php if(!empty($transactions)) {?>
		<div class="span dc pull-right  top-mspace">
    	  <span class="hor-mspace">
			<i class="icon-download-alt grayc"></i><?php echo $this->Html->link(__l('Export'), array_merge(array('controller' => 'transactions', 'action' => 'index', 'ext' => 'csv', 'admin' => true), $this->request->params['named']), array('title' => __l('Export'), 'escape'=>false,'class' => 'js-no-pjax export pinkc')); ?>
		  </span>
        </div>
	  <?php } ?>
	</div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
	<table class="table table-striped table-hover">
	  <thead class="yellow-bg">
 		<tr class="sep-top sep-bot">
            <th class="sep-right dc sep-left"><div class="js-pagination"><?php echo $this->Paginator->sort('Transaction.created', __l('Date'), array('class' => 'js-no-pjax'));?></div></th>
			<?php if (!empty($this->request->params['named']['filter'])): ?>
	            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('User'), array('class' => 'js-no-pjax'));?></div></th>
			<?php endif; ?>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('TransactionType.name', __l('Description'), array('class' => 'js-no-pjax'));?></div></th>
			<th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('Transaction.amount', __l('Credit') . ' (' . Configure::read('site.currency') . ')', array('class' => 'js-no-pjax'));?></div></th>
			<th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('Transaction.amount', __l('Debit') . ' (' . Configure::read('site.currency') . ')', array('class' => 'js-no-pjax'));?></div></th>
        </tr>
	  </thead>
	  <tbody>
		<?php
		  if (!empty($transactions)):
			foreach ($transactions as $transaction):?>
		<tr>
			<td class="dc"><?php echo $this->Html->cDateTimeHighlight($transaction['Transaction']['created']);?></td>
			<?php if (!empty($this->request->params['named']['filter'])): ?>
				<td>
					<?php
					echo $this->Html->getUserAvatarLink($transaction['User'], 'micro_thumb',true);
					echo $this->Html->getUserLink($transaction['User']);
					?>
				</td>
			<?php endif; ?>
			<td>
				<?php
					if ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::AddFundToWallet) {
						echo $this->Html->cText($transaction['Transaction']['description']) . ' ' . __l('for') . ' ' . $this->Html->getUserLink($transaction['User']);
					} elseif ($transaction['Transaction']['transaction_type_id'] == ConstTransactionTypes::DeductFundFromWallet) {
						echo $this->Html->cText($transaction['Transaction']['description']) . ' ' . __l('from') . ' ' . $this->Html->getUserLink($transaction['User']);
					} else {
						echo $this->Html->transactionDescription($transaction, 1);
					}
				?>
			</td>
			<td class="dr">
				<?php
					if (!empty($transaction['TransactionType'][$credit_type])):
						echo $this->Html->cCurrency($transaction['Transaction']['amount']) . ' ';
					else:
						echo '--';
					endif;
				?>
			</td>
			<td class="dr">
				<?php
					if (!empty($transaction['TransactionType'][$credit_type])):
						echo '--';
					else:
						echo $this->Html->cCurrency($transaction['Transaction']['amount']) . ' ';
					endif;
				?>
			</td>
		</tr>
	<?php
			endforeach;
	?>
		<tr class="total-block">
			<td colspan="<?php echo !empty($this->request->params['named']['filter']) ? '3' : '2'; ?>" class="dr"><?php echo __l('Total');?></td>
			<td class="dr"><?php echo $this->Html->siteCurrencyFormat($total_credit_amount);?></td>
			<td class="dr"><?php echo $this->Html->siteCurrencyFormat($total_debit_amount);?></td>
		</tr>
	<?php
		else:
	?>
		<tr>
			<td colspan="11" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Transactions'));?></td>
		</tr>
	<?php
		endif;
	?>
	</tbody>
	</table>
	<?php if (!empty($transactions)) { ?>
	  <div class="span top-mspace pull-right">
        <div class="pull-right bot-space">
          <?php echo $this->element('paging_links'); ?>
        </div>
      </div>
	<?php } ?>
  </div>
</div>
</div>