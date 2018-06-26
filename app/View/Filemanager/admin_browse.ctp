<div class="filemanager folder">
	<div class="clearfix">
		<ul class="grid_right file-list clearfix">
			<li class="grid_left"><?php echo $this->Html->link(__l('Upload here'), array('controller' => 'filemanagers', 'action' => 'upload', '?path='. $path), array('class' => 'upload')); ?></li>
			<li class="grid_left"><?php echo $this->Html->link(__l('Create directory'), array('controller' => 'filemanagers', 'action' => 'create_directory', '?path='. $path), array('class' => 'directory')); ?></li>
			<li class="grid_left"><?php echo $this->Html->link(__l('Create file'), array('controller' => 'filemanagers', 'action' => 'create_file', '?path='. $path), array('class' => 'file')); ?></li>
		</ul>

		<div class=" grid_left">
<?php
echo __l('You are here:') . ' ';
$breadcrumb = $this->Filemanager->breadcrumb($path);
foreach ($breadcrumb AS $pathname => $p) {
echo $this->Filemanager->linkDirectory($pathname, $p);
echo DS;
}
?>
		</div>
	</div>
	<table cellpadding="0" cellspacing="0" class="list">
<?php
$tableHeaders =  $this->Html->tableHeaders(array(
'',
__l('Directory content'),
__l('Actions'),
));
echo $tableHeaders;

// directories
$rows = array();
foreach ($content['0'] AS $directory) {
$actions = $this->Filemanager->linkDirectory(__l('Open'), $path.$directory.DS);
if ($this->Filemanager->inPath($deletablePaths, $path.$directory)) {
$actions .= ' ' . $this->Filemanager->link(__l('Delete'), array(
'controller' => 'filemanagers',
'action' => 'delete_directory',
), $path.$directory);
}
$rows[] = array(
$this->Html->image('/img/icons/folder.png'),
$this->Filemanager->linkDirectory($directory, $path.$directory.DS),
$actions,
);
}
echo $this->Html->tableCells($rows, array('class' => 'directory'), array('class' => 'directory'));

// files
$rows = array();
foreach ($content['1'] AS $file) {
$actions = $this->Filemanager->link(__l('Edit'), array('controller' => 'filemanagers', 'action' => 'editfile'), $path.$file);
if ($this->Filemanager->inPath($deletablePaths, $path.$file)) {
$actions .= $this->Filemanager->link(__l('Delete'), array(
'controller' => 'filemanagers',
'action' => 'delete_file',
), $path.$file);
}
$rows[] = array(
$this->Html->image('/img/icons/'.$this->Filemanager->filename2icon($file)),
$this->Filemanager->linkFile($file, $path.$file),
$actions,
);
}
echo $this->Html->tableCells($rows, array('class' => 'file'), array('class' => 'file'));
?>
	</table>

</div>