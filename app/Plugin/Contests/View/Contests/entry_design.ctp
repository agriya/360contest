<div class="contestUsers form js-responses">
	<h1 class="bot-space bot-mspace"><?php echo __l("Upload Final Deliverables"); ?> </h1>
	<?php echo $this->Form->create('Contest', array('action' => 'entry_design', 'class' => 'normal', 'enctype' => 'multipart/form-data'));?>
	<div class="ver-space">
		<span class="alert alert-warning space"><?php echo __l('If more than one number of files means upload it as a zip.'); ?></span>
	</div>
	<div class="clearfix top-space top-mspace">
		<?php echo $this->Form->input('EntryAttachment.filename', array('type' => 'file','size' => '33', 'label' => false,'class' =>'browse-field', 'div' => false)); ?>
		</div>
  	<div class="submit-block clearfix  ver-space">
		<?php echo $this->Form->input("contest_id", array('type' => 'hidden', 'value'=> $contest_id))?>
		<?php echo $this->Form->input("contest_slug", array('type' => 'hidden', 'value'=> $slug))?>
		<?php echo $this->Form->submit(__l('Upload')); ?>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
