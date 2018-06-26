<div class="terms form">
    <?php echo $this->Form->create('Term', array('class' => 'form-large-fieldsform-horizontal', 'url' => array('controller' => 'terms', 'action' => 'add', $vocabulary['Vocabulary']['id']))); ?>
		<fieldset>
			<?php
				echo $this->Form->input('Taxonomy.parent_id', array('options' => $parentTree, 'empty' => true));
				echo $this->Form->input('title');
				echo $this->Form->input('slug', array('class' => 'slug'));
			?>
		</fieldset>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Save')); ?>
			<div class="cancel-block">
				<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', $vocabularyId)); ?>
			</div>
		</div>
	<?php echo $this->Form->end(); ?>
</div>