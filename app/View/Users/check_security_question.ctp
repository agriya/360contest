<div class="sign-up span15 offset5 clearfix">
<div class="page-header">
<h2><?php echo __l('Security Question'); ?></h2>
</div>
<?php
  echo $this->Form->create('User', array('action' => 'reset/'.$user_id.'/'.$hash ,'class' => 'form-horizontal'));
  echo $this->Form->input('user_id', array('type' => 'hidden'));
  echo $this->Form->input('hash', array('type' => 'hidden'));
  if(isPluginEnabled('SecurityQuestions')) {
  echo $this->Form->input('security_answer', array('label' => $security_questions['SecurityQuestion']['name'], 'id' => 'security_answer', 'autocomplete' => 'off'));
  }
  ?>
  <div class="form-actions">
  <?php echo $this->Form->submit(__l('Submit')); ?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>