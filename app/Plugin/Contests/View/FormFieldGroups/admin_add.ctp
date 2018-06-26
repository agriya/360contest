<?php /* SVN: $Id: $ */ ?>
<div class="projectTypes form js-response-containter">
	<div class="modal-header">
        <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 id="js-modal-heading"><?php echo __l('Add New Group'); ?></h2>
    </div>
	<div class="clearfix main-section top-space">	
		<?php 
            $url = Router::url(array('controller'=>'resources','action'=>'edit', $this->request->data['FormFieldGroup']['contest_type_id']),true);
            echo $this->Form->create('FormFieldGroup', array('class' => 'form-horizontal js-modal-form {"responsecontainer":"js-response-containter","redirect_url":"'.$url.'"}'));
        ?>
        <fieldset>
        <?php
            echo $this->Form->hidden('contest_type_id');
            echo $this->Form->input('name');
            echo $this->Form->input('info');
			echo $this->Form->input('FormFieldGroup.is_deletable', array('type' => 'hidden', 'value' => 1));
        ?>
        </fieldset>
        <div class="form-actions">
            <?php echo $this->Form->submit(__l('Add'));?>
        </div>
        <?php echo $this->Form->end();?>
        </div>
    </div>