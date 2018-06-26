<div class="filemanager form">

	<div class="breadcrumb">
<?php
echo __l('You are here:') . ' ';
$breadcrumb = $this->Filemanager->breadcrumb($path);
foreach($breadcrumb AS $pathname => $p) {
echo $this->Filemanager->linkDirectory($pathname, $p);
echo DS;
}
	?>
	</div>

<?php
echo $this->Form->create('Filemanager', array(
'class'=>'normal',
'url' => $this->Html->url(array(
'controller' => 'filemanagers',
'action' => 'create_file',
), true) . '?path=' . urlencode($path),
));
?>
	<fieldset>
<?php echo $this->Form->input('Filemanager.name', array('type' => 'text')); ?>
	</fieldset>

	<div class="submit-block clearfix">
<?php
echo $this->Form->end(__l('Create')); ?>
<div class="cancel-block clearfix">
<?php
echo $this->Html->link(__l('Cancel'), array(
'action' => 'index',
), array(
'class' => '',
));
?>
		</div>
	</div>
</div>