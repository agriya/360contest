<div class="hor-space">
<div class='thumbnail sep'>
    <?php
    	echo $this->Form->create('User', array('action' => 'send_mail', 'class' => 'form-large-fields form-horizontal space clearfix form-large-fields'));
		if(empty($this->request->params['named']['user'])){
    		echo $this->Form->input('bulk_mail_option_id', array('empty' => 'Select', 'label' => __l('Bulk Mail Option')));
		}
		echo $this->Form->autocomplete('send_to', array('id' => 'message-to',  'label'=> __l('Send To'), 'acFieldKey' => 'User.send_to_user_id',
										'acFields' => array('User.email'),
										'acSearchFieldNames' => array('User.email'),
										'maxlength' => '100', 'acMultiple' => true
									   ));
        echo $this->Form->input('subject',array('label' => __l('Subject')));
      	echo $this->Form->input('message', array('type' => 'textarea', 'label' => __l('Message'))); ?>
	<div class="submit-block clearfix">
		<?php echo $this->Form->submit(__l('Send')); ?>
	</div>
    <?php echo $this->Form->end(); ?>
</div>
</div>