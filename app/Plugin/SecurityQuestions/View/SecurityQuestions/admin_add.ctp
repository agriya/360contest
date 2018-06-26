<?php /* SVN: $Id: admin_add.ctp 2894 2010-09-02 10:01:36Z sakthivel_135at10 $ */ ?>
<div class="projects form space">
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Security Questions'), array('action' => 'index'), array('title' => __l('Security Questions')));?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo sprintf(__l('Add %s'), __l('Security Question'));?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li><?php echo $this->Html->link('<i class="icon-th-list blackc"></i>'.__l('List'), array('action' => 'index'),array('class' => 'blackc', 'title' =>  __l('List'), 'data-target'=>'#list_form', 'escape' => false));?></li>
    <li class="active"><a class="blackc" href="#add_form"><i class="icon-plus-sign"></i><?php echo __l('Add'); ?></a></li>
  </ul>
  <?php echo $this->Form->create('SecurityQuestion', array('class' => 'form-horizontal')); ?>
  <?php echo $this->Form->input('name', array('label' => __l('Question'))); ?>
  <?php echo $this->Form->input('is_active', array('label' => __l('Active?'))); ?>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Add'));?>
  </div>
  <?php echo $this->Form->end();?>
</div>