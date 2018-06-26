<?php /* SVN: $Id: $ */ ?>
<div class="contestTypes form js-response-containter">
  <div class="modal-header">
    <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2 id="js-modal-heading"><?php echo __l('Edit Group'); ?></h2>
  </div>
  <div class="clearfix main-section top-space">
  <?php
      $url = Router::url(array('controller'=>'contest_types','action'=>'edit', $this->request->data['FormFieldGroup']['contest_type_id']),true);
      echo $this->Form->create('FormFieldGroup', array('class' => 'space form-horizontal js-modal-form {"responsecontainer":"js-response-containter","redirect_url":"'.$url.'"}'));
    ?>
  <fieldset>
    <?php
      echo $this->Form->input('id');
      echo $this->Form->hidden('contest_type_id');
      echo $this->Form->input('name');
      echo $this->Form->input('info');
    ?>
  </fieldset>
  <div class="form-actions">
    <?php echo $this->Form->submit(__l('Update'));?>
  </div>
  <?php echo $this->Form->end();?>
  </div>
</div>