<div class="filemanager form">
	<div class="breadcrumb">
		<?php echo __l('You are here:') . ' ';

		$breadcrumb = $this->Filemanager->breadcrumb($path);
		foreach($breadcrumb AS $pathname => $p) {
		echo $this->Filemanager->linkDirectory($pathname, $p);
		echo DS;
		}
		?>
	</div>

<?php
echo $this->Form->create('Filemanager', array(
'type' => 'file',
'class' =>'normal',
'url' => $this->Html->url(array(
'controller' => 'filemanagers',
'action' => 'upload',
), true) . '?path=' . urlencode($path),
));
?>
	<fieldset>
		<?php echo $this->Form->input('Filemanager.file', array('type' => 'file')); ?>
	</fieldset>

	<div class="submit-block clearfix">
<?php
echo $this->Form->submit(__l('Upload')); ?>
<div class="cancel-block">
<?php
echo $this->Html->link(__l('Cancel'), array(
'action' => 'index',
), array(
'class' => '',
));
?>
	</div>
</div>
<?php
echo $this->Form->end(); ?>
</div>