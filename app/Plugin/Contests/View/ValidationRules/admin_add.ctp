<div class="validationRules form">
 <?php echo $this->Form->create('ValidationRule', array( 'class' => 'form-horizontal')); ?>
    <?php
		echo $this->Form->input('rule');
		echo $this->Form->input('message');
	?>
    <div class="submit-block clearfix">
        <?php echo $this->Form->submit('Submit');?>
    </div>
<?php echo $this->Form->end();?>
</div>