<?php /* SVN: $Id: admin_add.ctp 63884 2011-08-22 09:47:12Z arovindhan_144at11 $ */ ?>
<div class="hor-space">
<div class="languages form thumbnail"> 
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Language'), array('action' => 'index'),array('title' => __l('Language')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Language'));?></li>
    </ul>
<?php echo $this->Form->create('Language', array('class' => 'form-large-fields form-horizontal'));?>
<?php
	echo $this->Form->input('name',array('label' => __l('Name')));
	echo $this->Form->input('iso2',array('label' => __l('Iso2')));
	echo $this->Form->input('iso3',array('label' => __l('Iso3')));
	echo $this->Form->input('is_active', array('label' => __l('Active')));
?>
  <div class="submit-block clearfix"> <?php echo $this->Form->submit(__l('Add'));?>
    <?php echo $this->Html->link(__l('Cancel') , array('controller' => 'languages', 'action' => 'index'),array('class' => 'btn'));?>
  </div>
<?php echo $this->Form->end(); ?> 
  </div>
  </div>
