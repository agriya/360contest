<div class ='js-response'>
	<div class="modal-header">
        <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 id="js-modal-heading"><?php echo __l('Add New Field'); ?></h2>
    </div>
	<div class="clearfix main-section top-space">	
 <?php echo $this->Html->scriptBlock('base = "' . $this->base. '";'); ?>
<?php echo $this->Form->create('FormField' ,array('class' => 'form-horizontal js-modal-form'));
	echo $this->Form->hidden('contest_type_id');
	echo $this->Form->hidden('form_field_group_id');
	echo $this->Form->input('label');
	echo $this->Form->input('display_text');
	echo $this->Form->input('type', array('class' => 'js-field-type')); 	
	?>
	<div class ="js-options-show hide form-add-field">
		<?php echo $this->Form->input('options', array('type' => 'text', 'info' => __l('Comma separated. To include comma, escape it with \ (e.g., Option with \,)'))); ?>
	</div>
	<?php
	echo $this->Form->input('info');
	echo $this->Form->input('required');
	echo $this->Form->input('is_active',array('label'=>'Active?'));?>
        <div class="submit-block clearfix">
            <?php  echo $this->Form->submit('Submit');?>
        </div>
    <?php
	 echo $this->Form->end();?>
  </div>
</div>