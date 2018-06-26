<?php /* SVN: $Id: $ */ ?>
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
<div class="contests form container">	
    <div class="stage-inner-block ">
        <h2  class="ver-mspace ver-space sep-bot"><?php echo __l('Contest Brief - ').$this->Html->cText($contestTypes['ContestType']['name']);?></h2>
        <div class="thumbnail">
		<?php echo $this->Form->create('Contest', array('class' => 'form-horizontal contest-form top-mspace top-space  form-large-fields','enctype' => 'multipart/form-data'));?>
        <?php
           	echo $this->Form->input('contest_type_id', array('type' => 'hidden'));
        	echo $this->Form->input('resource_id', array('type' => 'hidden','value'=>$contestTypes['ContestType']['resource_id']));
        	echo $this->Form->input('name');
        	echo $this->Form->input('description'); ?>
            <div class="contest-add-block">
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
							<?php } 
								foreach($FormFieldGroup['FormField'] as $key => $FormField) {
											if ($FormField['type'] == 'multiselect') {
												$FormFieldGroup['FormField'][$key]['type'] = 'select';
												$FormFieldGroup['FormField'][$key]['multiple'] = 'multiple';
											}
								}?>
			<?php
					echo $this->Cakeform->insert($FormFieldGroup);
			?>
					</div>
				</div>
			<?php
				}					
            ?>						
            </div>
        <div class="submit-block clearfix">
            <?php echo $this->Form->submit(__l('Next'));?>
        </div>
        <?php echo $this->Form->end();?>
    </div></div>
    
</div>