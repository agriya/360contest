<div class="attachments form"> 
<?php echo $this->Form->create('Node', array('class' => 'normal', 'url' => array('controller' => 'attachments', 'action' => 'add'), 'type' => 'file')); ?>
  <fieldset>
<?php echo $this->Form->input('Node.file', array('label' => __l('Upload'), 'type' => 'file')); ?>
  </fieldset>
  <div class="submit-block clearfix"> 
<?php echo $this->Form->submit(__l('Save')); ?>
    <div class="cancel-block"> 
<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class' => 'cancel-link')); ?> 
    </div>
  </div>
</div>
