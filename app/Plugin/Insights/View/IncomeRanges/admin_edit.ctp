<?php /* SVN: $Id: $ */ ?>
<div class="userIncomeRanges form">
  <?php echo $this->Form->create('IncomeRange', array('class' => 'form-horizontal space'));?>
    <ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Income Ranges'), array('action' => 'index'),array('title' => __l('Income Ranges')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo __l('Edit Income Range');?></li>
    </ul>
    <ul class="nav nav-tabs">
      <li><?php echo $this->Html->link('<i class="icon-th-list blackc"></i>'.__l('List'), array('action' => 'index'),array('class' => 'blackc', 'title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?></li>
      <li class="active"><a class="blackc" href="#add_form"><i class="icon-edit"></i><?php echo __l('Edit'); ?></a></li>
    </ul>
    <?php
      echo $this->Form->input('id');
      echo $this->Form->input('income');
      echo $this->Form->input('is_active',array('label'=>__l('Active')));
    ?>
    <div class="form-actions">
      <?php echo $this->Form->submit(__l('Update'));?>
    </div>
  <?php echo $this->Form->end();?>
</div>
