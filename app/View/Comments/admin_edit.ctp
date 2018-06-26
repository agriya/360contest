<div class="comments form"> <?php echo $this->Form->create('Comment', array('class' => 'form-large-fields form-horizontal'));?>
  <fieldset>
  <?php
				echo $this->Form->input('id');
				echo $this->Form->input('body');
				echo $this->Form->input('name');
				echo $this->Form->input('email');
				echo $this->Form->input('website');
				echo $this->Form->input('status', array('label' => __l('Published')));
			?>
  </fieldset>
  <div class="submit-block clearfix"> <?php echo $this->Form->submit(__l('Save')); ?>
    <div class="cancel-block"> <?php echo $this->Html->link(__l('Cancel'), array('controller' => 'comments', 'action' => 'index'), array('class' => 'cancel-link', 'title' => __l('Cancel'))); ?> </div>
  </div>
  <?php echo $this->Form->end(); ?> </div>
