<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Cities'), array('action' => 'index'),array('title' => __l('Cities')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Edit %s'), __l('City'));?></li>
    </ul>
<?php echo $this->Form->create('City', array('class' => 'form-large-fields form-horizontal','action'=>'edit'));?>
<?php
    echo $this->Form->input('id');
    echo $this->Form->input('country_id', array('empty' => __l('Please Select'), 'label' => __l('Country')));
    echo $this->Form->input('state_id', array('empty' => __l('Please Select'), 'label' => __l('State')));
    echo $this->Form->input('name', array('label' => __l('Name')));
    echo $this->Form->input('is_approved', array('label' => __l('Approved?')));
?>
<div class="clearfix"> <?php echo $this->Form->submit(__l('Update'));?> </div>
<?php echo $this->Form->end();?>
</div>
</div>