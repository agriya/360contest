<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="contestStatuses form thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Contest Status '), array('action' => 'index'),array('title' => __l('Contest Status ')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l(' Edit %s'), __l('Contest Status '));?></li>
    </ul>
<?php echo $this->Form->create('ContestStatus', array('class' => 'form-horizontal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('message');
	?>
	</fieldset>
<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Update'));?>
</div>
<?php echo $this->Form->end();?>
</div>
</div>