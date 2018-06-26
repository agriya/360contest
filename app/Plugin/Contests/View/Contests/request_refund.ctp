<?php /* SVN: $Id: $ */ ?>
<div class="contests form">
<h2 class="ver-space ver-mspace"><?php echo $this->pageTitle;?></h2>
<div class="page-info alert alert-info"><?php echo __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.') ?></div><div class="thumbnail">
<?php echo $this->Form->create('Contest', array('class' => 'form-horizontal','action'=>'request_refund'));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('reason_for_cancelation', array('type' => 'textarea', 'label' => __l('Request for Cancellation')));
	?>
   <div class="submit-block clearfix">
        <?php echo $this->Form->submit(__l('Request'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
</div>