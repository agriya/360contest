<div class="cforms form">
	<?php echo $this->Form->create('ContestType', array('class' => 'normal contest-type'));?>
	<fieldset>
		<div class="contest-add-block">
			<?php echo $this->Cakeform->insert($contestType); ?>
		</div>
	</fieldset>
	<?php echo $this->Form->end();?>
</div>