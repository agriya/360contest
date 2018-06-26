<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="contestTypes form thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Contest Templates'), array('action' => 'index'),array('title' => __l('Contest Templates')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Contest Template'));?></li>
    </ul>
	<ul class="nav nav-tabs clearfix">
		<li class="step1 active"><a href="#"><?php echo __l('Overview');?></a></li>
		<li class="step2"><a href="#"><?php echo __l('Form Fields');?></a></li>
		<?php if(empty($this->request->params['named']['type']) || $this->request->params['named']['type'] != 'templates') { ?>
		<li class="step3"><a href="#"><?php echo __l('Pricing');?></a></li>
		<?php } ?>
		<li class="step4"><a href="#"><?php echo __l('Preview');?></a></li></a></li>
    </ul>
<?php echo $this->Form->create('ContestType', array('class' => 'form-horizontal form-large-fields', 'enctype' => 'multipart/form-data'));?>
	<fieldset class="form-block">
		<?php
			echo $this->Form->input('is_template', array('type' => 'hidden'));
			if(empty($this->request->params['named']['type']) || $this->request->params['named']['type'] != 'templates') { 
				echo $this->Form->input('resource_id', array('type' => 'hidden', 'default' => $resource_id));
			} else {
				echo $this->Form->input('resource_id', array('type' => 'select', 'label' => 'Resource',  'default' => ConstResource::Image));
			}
		?>
	</fieldset>
	<fieldset class="form-block">
		<h3 class="bot-mspace"><?php echo __l('General'); ?></h3>
		<?php
			echo $this->Form->input('name');
			echo $this->Form->input('description');
			echo $this->Form->input('maximum_entries_allowed', array('type' => 'text', 'info' => __l('Leave blank for unlimited entries')));
			echo $this->Form->input('maximum_entries_allowed_per_user', array('type' => 'text', 'label' => __l('Maximum Entries Allowed Per User Per Contest'), 'info' => __l('Leave blank for unlimited entries')));
			echo $this->Form->input('minimum_prize',array('type' => 'text', 'value'=>Configure::read('contest.contest_type_minimum_prize'), 'info' => sprintf('%s %s',__l('Global'), Configure::read('contest.contest_type_minimum_prize')), 'label' => 'Minimum Prize'.' ('.Configure::read('site.currency').')'));
			if (empty($this->request->data['ContestType']['is_template'])) { ?>
			<div class="required"><?php
				echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => 'Upload Photo','class' => 'browse-field')); ?>
			</div><?php
			}
		?>
	</fieldset>
	<?php if(empty($this->request->params['named']['type']) || $this->request->params['named']['type'] != 'templates') { ?>
	<fieldset class="form-block">
		<h3 class="bot-mspace"><?php echo __l('Templates'); ?></h3>
		<div class="alert alert-info"><?php echo __l('Optional. Choose readymade templates to autofill form fields in next step. You may edit those autofilled form fields.') ?></div>
		<?php
			if (empty($this->request->data['ContestType']['is_template'])) {
				echo $this->Form->input('template_id', array('label' => __l('Choose readymade template'), 'empty' => __l('Please Select')));
			}
		?>
	</fieldset>
	<?php } ?>
<div class="submit-block clearfix">
<?php echo $this->Form->submit(__l('Add'));?>
</div>
<?php echo $this->Form->end();?>
</div>
</div>