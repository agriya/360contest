<?php /* SVN: $Id: $ */ ?>
<div class="messages-settings">
    <h2 class="title"><?php echo __l('General Settings'); ?> </h2>
    <div id="message-settings">
        <?php
            echo $this->Form->create('Message', array('action' => 'settings', 'class' => 'normal  js-form-settings'));
            echo $this->Form->input('UserProfile.message_page_size');
            echo $this->Form->input('UserProfile.message_signature', array('type' => 'textarea'));
            echo $this->Form->submit(__l('Update'));
            echo $this->Form->end();
        ?>    
	</div>
</div>
