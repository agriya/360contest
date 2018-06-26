<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="pricingDays form thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Contest Day'), array('action' => 'index'),array('title' => __l('Contest Day')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Contest Day'));?></li>
    </ul>


<?php echo $this->Form->create('PricingDay', array('class' => 'form-horizontal'));?>
	<?php
		echo $this->Form->input('no_of_days', array('type' => 'text','label'=>'No of Days'));		
		echo $this->Form->input('global_price', array('type' => 'text', 'label' => 'Global Price'.' ('.Configure::read('site.currency').')'));
	?>
<div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Add'));?>
</div>
    <?php echo $this->Form->end();?>
</div>
</div>