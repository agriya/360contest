<div class="attachments form"> 
<?php echo $this->Form->create('Node', array('class' => 'normal', 'url' => array('controller' => 'attachments', 'action' => 'edit'), 'type' => 'file')); ?>
  <fieldset>
  <div class="thumbnail">
<?php
	$fileType = explode('/', $this->request->data['Node']['mime_type']);
	$fileType = $fileType['0'];
	if ($fileType == 'image') {
		echo $this->Image->resize('/uploads/'.$this->request->data['Node']['slug'], 200, 300);
	} else {
		echo $this->Html->image('/img/icons/' . $this->Filemanager->mimeTypeToImage($this->request->data['Node']['mime_type'])) . ' ' . $this->request->data['Node']['mime_type'];
	}
?>
  </div>
<?php echo $this->Form->input('Node.file', array('label' => __l('Upload'), 'type' => 'file')); ?>
  </fieldset>
  <div class="submit-block clearfix"> 
<?php echo $this->Form->submit(__l('Save')); ?>
    <div class="cancel-block"> <?php echo $this->Html->link(__l('Cancel'), array('action' => 'index'), array('class' => 'cancel-link')); ?> </div>
  </div>
</div>
