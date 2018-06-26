<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="transactionTypes thumbnail">
	<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Transaction Types'), array('action' => 'index'),array('title' => __l('Transaction Type')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Transaction Type'));?></li>
    </ul>
<?php echo $this->Form->create('TransactionType', array('class' => 'form-large-fields form-horizontal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');?>
		<h3 class="bot-space"><?php echo $this->request->data['TransactionType']['name'];?></h3>
	<?php
		echo $this->Form->input('message',array('label'=>__l('Message'),'info' => $this->Html->cText($this->request->data['TransactionType']['transaction_variables'])));
	?>
	</fieldset>
	<div class="submit-block clearfix">
		<span>
			<?php echo $this->Form->submit(__l('Update'));?>
		</span>
		<span>
			<?php echo $this->Html->link(__l('Cancel') , array('action' => 'index'),array('class' => 'btn'));?>
		</span>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
</div>