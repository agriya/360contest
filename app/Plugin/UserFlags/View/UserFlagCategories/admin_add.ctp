<?php /* SVN: $Id: admin_add.ctp 620 2009-07-14 14:04:22Z boopathi_23ag08 $ */ ?>
<div class="hor-space">
<div class="userFlagCategories form thumbnail">
	<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('User Flag Categories'), array('action' => 'index'),array('title' => __l('User Flag Categories')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('User Flag Categories'));?></li>
    </ul>
<?php echo $this->Form->create('UserFlagCategory', array('class' => 'form-horizontal'));?>

    	<?php echo $this->Form->input('name'); ?>
    	<?php echo $this->Form->input('is_active', array('type'=>'checkbox','label' =>__l('Active')));?>
	<div class="clearfix">
        <?php echo $this->Form->submit(__l('Add'));?>
    </div>
         <?php echo $this->Form->end();?>
</div>
</div>
