<?php /* SVN: $Id: index.ctp 32471 2010-11-08 11:23:30Z aravindan_111act10 $ */ ?>
<?php 
$hide_class = 'hide';
if(!empty($this->request->data['Transaction']['filter']) && $this->request->data['Transaction']['filter'] == "custom"){
	$hide_class = '';
}
if(!isset($this->data['Transaction']['tab_check']) && !$isAjax): ?>
		<div class="bot-space">
				<div class="page-header no-mar clearfix">
				<div class="container">
					<h2 class="ver-space ver-mspace span"><?php echo __l('Transactions'); ?></h2></div>
					<?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
				</div>
				<?php if (isPluginEnabled('Wallet')) : ?>
					<div class="clearfix container">
						<div class="well clearfix">
							<div class="pull-left no-mar row"> 
								<h3><?php echo __l('Account Summary'); ?></h3>
							</div>
							<?php if (isPluginEnabled('Wallet')) : ?>  
								<div class="pull-right no-mar row">  
									<div class="hor-msapce textb span">
										<?php echo __l('Account Balance:');?>
										<span class="textn">
											<?php echo !empty($user)?$this->Html->siteCurrencyFormat($user['User']['available_wallet_amount']):'';?>
										</span>
									</div>
								</div>
							<?php  endif;  ?>
							<?php if (isPluginEnabled('Withdrawals') && isPluginEnabled('Wallet')) : ?> 
								<div class="pull-right no-mar row">
									<div class="hor-msapce textb">
										<?php echo __l('Withdraw Request:');?>
										<span class="textn"><?php echo $this->Html->siteCurrencyFormat($blocked_amount);?></span>
									</div>
								</div>
							<?php endif; ?>    
						</div>
					</div>
				<?php endif;?>
			<div class="container">
			<?php echo $this->Form->create('Transaction', array('action' => 'index' ,'class' => 'thumbnail sep js-ajax-form {"container":"js-responses", "transaction":"true"}')); ?>
			<div class="transaction-category hor-space">
					<?php echo $this->Form->input('filter', array('default' => __l('All'), 'type' => 'radio', 'options' => $filter, 'legend' => false, 'class' => 'js-transaction-filter js-no-pjax left-mspace no-mar')); ?>
				<div class="js-filter-window clearfix <?php echo $hide_class; ?>">
					<div class="clearfix transection-date-time-block pull-left">
						<div class="input date-time clearfix hor-mspace pull-left">
							<div class="js-boostarp-datetime">
								<div class="js-cake-date">
									<?php echo $this->Form->input('from_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'),'label' => __l('From'))); ?>
								</div>
							</div>
						</div>
						<div class="input date-time clearfix hor-mspace  pull-left">
							<div class="js-boostarp-datetime">
								<div class="js-cake-date">
									<?php echo $this->Form->input('to_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'),'label' => __l('To'))); ?>
								</div>
							</div>
						</div>
					</div>
					<?php echo $this->Form->input('tab_check', array('type' => 'hidden','value' => 'tab_check')); ?>
					<div class="submit-block clearfix">
						<?php echo $this->Form->submit(__l('Filter'));?>
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
			<?php endif; ?>
			<div class="transactions index js-response js-responses">
				<?php echo $this->element('paging_counter');?>
				<table class="table table-bordered table-striped table-condensed">
					<tr>
						<th class="dc"><div ><?php echo $this->Paginator->sort('created', __l('Date'));?></div></th>
						<th class="dl"><div ><?php echo $this->Paginator->sort('transaction_type_id', __l('Description'));?></div></th>
						<th class="dr"><div class="span2"><?php echo $this->Paginator->sort('amount', __l('Credit') . ' (' . Configure::read('site.currency') . ')');?></div></th>
						<th class="dr"><div class="debit round-3"><?php echo $this->Paginator->sort('amount', __l('Debit') . ' (' . Configure::read('site.currency') . ')');?></div></th>
					</tr>
					<?php if (!empty($transactions)):
						$i = 0;
						$j = 1;
						$total_credit=0;
						$total_debit=0;
						foreach ($transactions as $transaction):
							$class = null;
							if ($i++ % 2 == 0) {
								$class = ' class="altrow"';
							}
							$to= $this->Html->cDate($duration_to);
							$from=$this->Html->cDate($duration_from);?>
							<tr<?php echo $class;?>>
								<td class="dc"><?php echo $this->Html->cDateTime($transaction['Transaction']['created']);?></td>
								<td class="dl"><?php echo $this->Html->transactionDescription($transaction);?></td>
								<td class="dr">
									<?php $paypal_text = '';
									if($transaction['TransactionType']['is_credit']):
										$total_credit=$total_credit+$transaction['Transaction']['amount'];
										echo $this->Html->cCurrency($transaction['Transaction']['amount']) . ' ' . $paypal_text;
									else:
										echo '--';
									endif;?>
								</td>
								<td class="dr">
									<?php if($transaction['TransactionType']['is_credit']):
										echo '--';
									else:
										$total_debit=$total_debit+$transaction['Transaction']['amount'];
										echo $this->Html->cCurrency($transaction['Transaction']['amount']) . ' ' . $paypal_text;
									endif;?>
								</td>
							</tr>
							<?php $j++;
						endforeach;?>
						<tr>
							<td class="dr" colspan="2"><span class="total-info1"><?php echo __l('Total ');?></span><span class="grayc"><?php echo $from . ' ' . __l('to') . ' ' . $to; ?></span></td>
							<td class="dr credit-total"><?php echo $this->Html->cCurrency($total_credit_amount);?></td>
							<td class="dr debit-total"><?php echo $this->Html->cCurrency($total_debit_amount);?></td>
						</tr>
					<?php else:?>
						<tr class="">
							<td colspan="11"><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Transactions'));?></p>
					</div></td>
						</tr>
					<?php endif;?>
				</table>
				<?php if (!empty($transactions)) { ?>
					<div class="js-pagination pull-right">
						<?php echo $this->element('paging_links'); ?>
					</div>
				<?php } ?>
			</div>
		<?php if(empty($this->params['named']['stat']) && !isset($this->data['Transaction']['tab_check']) && !$isAjax): ?>
		</div>
	<?php endif; ?>
	</div>