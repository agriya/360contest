<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="contests form">
<?php if($this->Auth->user('role_id') != ConstUserTypes::Admin && $this->request->data['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending){?>
	<div class="top-pattern sep-bot">
		<div class="space container">
		<ul class="row no-mar mob-c unstyled space">
			<li class="span dc no-mar offset2 span5"><div class="span no-mar"> <span class="label label-inverse span1 dc space no-mar text-24">1</span></div><span class="text-24 textb grayc span dc space no-mar text-24"> Step1</span> </li>
			</li>

			<li class="span dc no-mar span5"><div class="span no-mar"> <span class="label label-important span1 dc space no-mar text-24">2</span></div><span class="text-24 textb blackc span dc space no-mar text-24 "> Step2</span> </li>
			</li>
			<li class="span dc no-mar span5"><div class="span no-mar"> <span class="label label-inverse span1 dc space no-mar text-24">3</span></div><span class="text-24 textb grayc span dc space no-mar text-24"> Step3</span> </li>
			</li>
		<ul>
		</div>
	</div>
<?php } ?>

<?php if(empty($this->request->params['admin'])){?>
<h2 class="space"><?php echo $this->pageTitle; ?></h2>
 
<?php } ?>
<?php echo $this->Form->create('Contest', array('class' => 'form-horizontal thumbnail form-large-fields contest-form','enctype' => 'multipart/form-data'));?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		if($this->Auth->user('role_id') == ConstUserTypes::Admin){
			echo $this->Form->input('contest_status_id', array('type' => 'select', 'empty' => __l('Please Select'), 'options' => $contest_statuses, 'label' => __l('Contest 
		Status')));
		echo $this->Form->input('existing_contest_status_id', array('type' => 'hidden', 'value' => $this->request->data['Contest']['contest_status_id'])); 
		}else{
		echo $this->Form->input('contest_status_id', array('type' => 'hidden')); 
		}?>
		<?php 
		if(in_array($this->request->data['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Open)) && ($this->Auth->user('role_id') == ConstUserTypes::Admin)):?>
			<div class="input  show">
			 <div class="js-boostarp-datetime">
         	 <div class="js-cake-date">
					<?php echo $this->Form->input('end_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'),'label' => __l('End Date'))); ?>
				</div>
			</div>
			</div>
			<?php echo $this->Form->input('is_pending_action_to_admin', array('label' => __l('Pending Action To Admin'))); ?>
		<?php endif; ?>
<?php	echo $this->Form->hidden('contest_type_id');
		echo $this->Form->hidden('submission_id');
	?>
	
    <?php
		foreach($contestType['FormField'] as $key => $FormField) {
			if (!empty($contest_media[$FormField['name']])) {
				$contestType['FormField'][$key]['Attachment'] = $contest_media[$FormField['name']]['Attachment'];
			}
		}
        
    ?>
	<?php 
		foreach($FormFieldGroups as $FormFieldGroup) { 
	?>
			<div class="ver-space">
				<div class="space">
					<h4 class="ver-space bot-mspace sep-bot"><?php echo $FormFieldGroup['FormFieldGroup']['name']; ?></h4>
				<?php if (!empty($FormFieldGroup['FormFieldGroup']['info'])) { ?>
					<div class="alert alert-info clearfix">
						<?php echo $FormFieldGroup['FormFieldGroup']['info'];?>
					</div>
				<?php } ?>
	<?php
			echo $this->Cakeform->insert($FormFieldGroup);
	?>
			</div>
		</div>
	<?php
		}					
	?>

	<?php if (in_array($this->request->data['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Open, ConstContestStatus::Judging))): ?>
	<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin){ ?>
	<div class="round-5 featured-block clearfix">
		<h3><?php echo __l('Additional Features'); ?></h3>
		<div class="clearfix">
		<?php	
			echo $this->Form->input('is_featured', array('label' => __l('Featured')));
			echo $this->Form->input('is_private', array('label' => __l('Private')));
			echo $this->Form->input('is_blind', array('label' => __l('Blind')));
			echo $this->Form->input('is_highlight', array('label' => __l('Highlight')));
		?>
		</div>
	</div>
	<?php }?>	
	<?php endif; ?>
	<div class="clearfix">
		<?php echo $this->Form->submit(__l('Update'));?>
	</div>
	<?php echo $this->Form->end();?>
</div>
</div>