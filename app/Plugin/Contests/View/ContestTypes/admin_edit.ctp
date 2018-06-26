<div class="hor-space">
<div class="cforms form thumbnail">
	<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Contest Type'), array('action' => 'index'),array('title' => __l('Contest Type')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l(' Edit %s'), __l('Contest Types'));?></li>
    </ul>
	<ul class="nav nav-tabs clearfix">
		<?php if($this->request->params['named']['type'] == 'overview'){ ?>
			<li class="active"><a href="#"><?php echo __l('Overview');?></a></li>
		<?php }else{ ?>
			<li class="step1">
				<?php echo $this->Html->link('Overview', array('admin' => true, 'controller' => 'contest_types', 'action' => 'edit', $this->request->data['ContestType']['id'],'type' => 'overview'));?>
			</li>
		<?php }?>
		<?php if($this->request->params['named']['type'] == 'form_fields'){ ?>
			<li class="active"><a href="#"><?php echo __l('Form Fields');?></a></li>
		<?php }else{ ?>
			<li class="step2">
				<?php echo $this->Html->link('Form Fields', array('admin' => true, 'controller' => 'contest_types', 'action' => 'edit', $this->request->data['ContestType']['id'],'type' => 'form_fields'));?>
			</li>
		<?php }?>
		<?php if (empty($this->request->data['ContestType']['is_template'])) {?>
		<li class="step3">
				<?php echo $this->Html->link('Pricing', array('admin' => true, 'controller' => 'contest_types', 'action' => 'pricing', $this->request->data['ContestType']['id']));?>
		</li>
		<li class="step4">
		<?php } else { ?>
		<li class="<?php if(!empty($this->request->data['ContestType']['is_template'])) {?>template-<?php }?>step3 step3">
		<?php }?>
				<?php echo $this->Html->link('Preview', array('admin' => true, 'controller' => 'contests', 'action' => 'add', 'contest_type_id'=>$this->request->data['ContestType']['id'],'type' => 'preview'));?>
		</li>
    </ul>
	<?php $form_class = '';
	if($this->request->params['named']['type'] != 'form_fields'){
		$form_class = 'form-horizontal';
	}?>
	<?php echo $this->Form->create('ContestType', array( 'url' => array('controller' => 'contest_types', 'action' => 'edit', 'type'=>$this->request->params['named']['type'],'admin'=>true),'class' => 'contest-type '.$form_class,'enctype' => 'multipart/form-data'));?>
	<?php if($this->request->params['named']['type'] == 'overview'){?>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('is_template', array('type' => 'hidden'));
		echo $this->Form->input('name', array('label'=>__l('Name')));
		echo $this->Form->input('description', array('label'=>__l('Description')));
		echo $this->Form->input('maximum_entries_allowed', array('type' => 'text', 'info' => __l('Leave blank for unlimited entries')));
		echo $this->Form->input('maximum_entries_allowed_per_user', array('type' => 'text', 'label' => __l('Maximum Entries Allowed Per User'), 'info' => __l('Leave blank for unlimited entries'), array('label'=>__l('Maximum Entries Allowed'))));
		echo $this->Form->input('minimum_prize',array('type' => 'text', 'info' => sprintf('%s %s',__l('Global'), Configure::read('contest.contest_type_minimum_prize')), 'label' => __l('Minimum Prize').' ('.Configure::read('site.currency').')'));
		if (empty($this->request->data['ContestType']['is_template'])):
			echo $this->Form->input('Attachment.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'),'class' =>'browse-field'));
			if(!empty($this->request->data['Attachment']['filename'])):
	?>
				<div class="offset4">
				   <span class="hor-smspace">
						<?php echo $this->Html->showImage('ContestType', $this->request->data['Attachment'], array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($this->request->data['ContestType']['name'], false)), 'title' => $this->Html->cText($this->request->data['ContestType']['name'], false), 'escape' => false)); ?>
					</span>
				</div>
		<?php
				endif;
			endif;
		?>
		<?php } ?>
		<?php if($this->request->params['named']['type'] == 'form_fields'){ ?>
 	    <div class="alert alert-info"><?php echo __l('Warning! Please edit with caution. Changes in the form fields affect the existing contest also.');?></div>
 	    <div class="alert alert-info"><?php echo sprintf(__l('Label is the text that appears in the form for %s. Display Text is the text that appears in contest view page.<br/>e.g., If Label is "Explain Your Preference", Display will be "(My) Preference" or so.'), Configure::read('contest.contest_holder_alt_name_singular_caps'));?></div>
		
		<div class="clearfix">
		<span class="pull-right">
		<?php
			echo $this->Html->link('<i class="icon-plus-sign pull-left top-smspace cur"></i> '.__l('Add New Group'), array('controller' => 'form_field_groups', 'action'=>'add', 'type_id' => $this->request->data['ContestType']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'no-under blackc js-no-pjax', 'escape' => false, 'title' => __l('Add New Group')))	;
		?>
		</span>
		</div>
		<div id="fields">
			<section class="no-pad no-mar">
				<div class="row-fluid">
					<?php $j = $k = $n = 0; ?>
					<div class="js-sortable-step">
						<ol class="unstyled no-pad no-mar">
							<li class="active">
								<section>
									<div class="accordion-inner no-bor">
										<div class="row-fluid bot-space">
											<section class="thumbnail no-pad no-mar">
												<?php if(empty($FormFieldGroups)) { ?>
												<div class="alert alert-error no-mar"><?php echo __l('No Groups Added.'); ?></div>
												<?php } ?>
												<div class="row-fluid">
													<div class="js-sortable-group ver-space">
														<?php foreach($FormFieldGroups as $temp_FormFieldGroup) { ?>
														<?php
														  $FormFieldGroup['FormFieldGroup'] = $temp_FormFieldGroup['FormFieldGroup'];
														  $FormFieldGroup['FormField'] = $temp_FormFieldGroup['FormField'];
														?>
														<ol class="unstyled no-pad no-mar">
														  <li class="active">
															<div class="js">
															  <div class="hide"><?php
																echo $this->Form->hidden('FormFieldGroup.'. $k .'.id', array('value' => $FormFieldGroup['FormFieldGroup']['id']));
																$k++;
															  ?>
															  </div>
															</div>
															<section class="dl cur containter-fluid accordion-toggle" data-toggle="collapse" data-target="<?php echo '.form-field-group-' . $FormFieldGroup['FormFieldGroup']['id'];?>">
															  <div class="row-fluid">
															  <div class="sep span24 no-mar">
																<div class="span1 dc pull-left sep-right top-space"><i class="icon-move text-16"></i></div>
																  <div class="span20 dl pull-left top-space">
																	<h5 class="hor-space pull-left"><?php echo $this->Html->cText($FormFieldGroup['FormFieldGroup']['name']);?><span class="sfont grayc"><?php echo !empty($FormFieldGroup['FormFieldGroup']['info']) ? ' - ' . $this->Html->cText($FormFieldGroup['FormFieldGroup']['info']) : ''; ?></span></h5>
																   </div>
																   <div class="span3 pull-right top-space">
																	<div class="dropdown pull-right hor-space">
																	  <a title="settings" class="btn btn-small text-16" data-toggle="dropdown" href="#"><i class="icon-cog"></i><span class="hide">Settings</span><i class="caret ver-smspace"></i></a>
																	  <ul class="unstyled dropdown-menu arrow arrow-right dl clearfix">
																		<?php if (!empty($FormFieldGroup['FormFieldGroup']['is_deletable'])) { ?>
																		  <li><?php echo '<span>' . $this->Html->link('<i class="icon-remove"></i> '.__l('Delete'), array('controller'=>'form_field_groups','action' => 'delete', $FormFieldGroup['FormFieldGroup']['id']), array('class' => 'js-confirm blackc', 'escape'=>false,'title' => __l('Delete'))) . '</span>'; ?></li>
																		<?php } ?>
																		<li class="hor-space"><span class="show hor-space accordion-toggle" data-toggle="expand" data-target="<?php echo '.form-field-group-' . $FormFieldGroup['FormFieldGroup']['id'];?>"><i class="icon-resize-vertical cur no-pad"></i><?php echo __l('Expand/Collapse');?></span></li>
																		<li>
																		<?php echo '<span>' . $this->Html->link('<i class="icon-plus-sign cur"></i> '.__l('Add New Field'), array('controller' => 'form_fields', 'action'=>'add', $this->request->data['ContestType']['id'],'group_id' => $FormFieldGroup['FormFieldGroup']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'no-under blackc js-no-pjax', 'escape' => false, 'title' => __l('Add New Field'))) . '</span>';?>
																		</li>
																		<li><?php echo '<span>' . $this->Html->link('<i class="icon-edit cur"></i> '.__l('Edit Group'), array('controller' => 'form_field_groups', 'action'=>'edit', $FormFieldGroup['FormFieldGroup']['id']),array('data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'class' => 'no-under blackc js-no-pjax', 'escape' => false, 'title' => __l('Edit Group'))) . '</span>';?></li>
																	  </ul>
																	</div>
																  </div>
																</div>
																</div>
															  </section>
															  <section class="collapse <?php echo 'form-field-group-' . $FormFieldGroup['FormFieldGroup']['id'];?> com-bg over-visible">
																<div class="accordion-inner no-bor js-sortable" id="sortable">
																  <?php if (!empty($FormFieldGroup['FormField'])) { ?>
																	<table class="table table-bordered table-striped table-condensed no-mar">
																	  <thead>
																		<?php echo $this->Html->tableHeaders(array(__l('Label'), __l('Display Text'), __l('Type'), __l('Info'), __l('Required'), __l('Active'),''));?>
																	  </thead>
																	  <tbody>
																		<?php
																		  if (!empty($FormFieldGroup['FormField'])) {
																			$i = 1;
																			foreach($FormFieldGroup['FormField'] as $key => $field) {
																			  echo $this->element('form_field_row', array('key' => $j, 'field' => $field, 'multiTypes' => $multiTypes, 'cache' => array('config' => 'sec')));
																			  $j++;
																			}
																		  } else {
																			echo sprintf(__l('No %s available'), __l('Fields'));
																		  }
																		?>
																	  </tbody>
																	</table>
																  <?php } ?>
																</div>
															  </section>
															</li>
														  </ol>
													  <?php } ?>
													</div>
												</div>
											</section>
										</div>
									</div>
								</section>
							</li>
						</ol>
					</div>
				</div>
			</section>
		</div>
		<?php } ?>
		<div class="clearfix submit-block">
			<div class="pull-left">
			<?php if($this->request->params['named']['type'] == 'form_fields'){ ?>
				<?php
					$redirect_url = Router::url(array(
					'controller' => 'form_fields',
					'action' => 'add',
					$this->request->data['ContestType']['id']
					), true);
				?>
		  <?php } ?>
			<div class="offset2">
				<div class="offset1 space">
					<?php echo $this->Form->submit('Submit',array('div'=>false));?>
				</div>
			</div>
		</div>	
	</div>
	<?php echo $this->Form->end();?>
</div>
<div class="modal hide fade" id="js-ajax-modal">
  <div class="modal-body"></div>
  <div class="modal-footer">
    <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
  </div>
</div>
</div>