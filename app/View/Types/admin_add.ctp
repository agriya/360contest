<div class="hor-space">
<div class="types form thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Content Type'), array('action' => 'index'),array('title' => __l('Content Type')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Content Type'));?></li>
    </ul>

	<?php echo $this->Form->create('Type', array('class' => 'form-large-fields form-horizontal'));?>
		<fieldset>
			<ul class="nav nav-tabs" id="myTab">
				<li class="active"><a data-toggle="tab" href="#type" class="js-no-pjax"><i class="icon-th-list blackc"></i><span><?php echo __l('Type'); ?></span></a></li>
				<li><a data-toggle="tab" href="#type-taxonomy" class="js-no-pjax"><i class="icon-plus-sign"></i><span><?php echo __l('Taxonomy'); ?></span></a></li>
				<?php echo $this->Layout->adminTabs(); ?>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div id="type" class="tab-pane fade in active">
					<?php
						echo $this->Form->input('title');
						echo $this->Form->input('alias', array('class' => 'slug'));
					?>
				</div>
				<div id="type-taxonomy" class="tab-pane fade">
					<?php echo $this->Form->input('Vocabulary.Vocabulary'); ?>
				</div>
				<?php echo $this->Layout->adminTabs(); ?>
		</fieldset>
			<div class="submit-block clearfix">
				<?php echo $this->Form->submit(__l('Save')); ?>
				<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'),array('class'=>'btn hor-smspace')); ?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>
</div>