<div class="js-responses">
  <h2><?php echo $this->Html->cText($this->request->data['EmailTemplate']['name'], false); ?></h2>
<?php
	echo $this->Form->create('EmailTemplate', array('id' => 'EmailTemplateAdminEditForm'.$this->request->data['EmailTemplate']['id'], 'class' => 'form-large-fields form-horizontal thumbnail  js-insert js-ajax-form', 'action' => 'edit'));
	echo $this->Form->input('id');
	echo $this->Form->input('name', array('type' => 'hidden'));
	echo $this->Form->input('from', array('id' => 'EmailTemplateFrom'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
	echo $this->Form->input('reply_to', array('id' => 'EmailTemplateReplyTo'.$this->request->data['EmailTemplate']['id'], 'info' => __l('(eg. "displayname &lt;email address>")')));
	echo $this->Form->input('subject', array('class' => 'js-email-subject', 'id' => 'EmailTemplateSubject'.$this->request->data['EmailTemplate']['id']));
	echo $this->Form->input('email_content', array('class' => 'span14 hor-space','rows'=>'15'));
	echo $this->Form->input('email_html_content', array('class' => 'span14 hor-space','rows'=>'15')); ?>
		
  <div class="clearfix">
<?php
	echo $this->Form->submit(__l('Update'));
?>
  </div>
<?php
	echo $this->Form->end();
?>
</div>
