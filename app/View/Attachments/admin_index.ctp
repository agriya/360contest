<div class="attachments index">
  <div class="clearfix">
    <div class="grid_left"> <?php echo $this->element('paging_counter');?> </div>
    <div class="grid_right add-block"> <?php echo $this->Html->link(__l('Add Attachment'), array('controller' => 'attachments', 'action' => 'add'), array('class' => 'add', 'title' => __l('Add Attachment'))); ?> </div>
  </div>
  <table class="list">
    <tr>
      <th class="actions"><?php echo __l('Actions'); ?></th>
      <th><?php echo __l('Image'); ?></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('alias', __l('URL')); ?></div></th>
    </tr>
<?php
	if (!empty($attachments)):
		$i = 0;
		foreach ($attachments AS $attachment) {
			$i=0;
			if ($i++ % 2 == 0):
				$class = "altrow";
			endif;
?>
    <tr class="<?php echo $class;?>">
      <td  class="actions"><div class="action-block"> <span class="action-information-block"> <span class="action-left-block">&nbsp; </span> <span class="action-center-block"> <span class="action-info"> <?php echo __l('Action');?> </span> </span> </span>
          <div class="action-inner-block">
            <div class="action-inner-left-block">
              <ul class="action-link clearfix">
                <li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'attachments', 'action' => 'edit', $attachment['Node']['id']), array('class' => 'edit', 'title' => __l('Edit')));?> </li>
                <li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'attachments', 'action' => 'delete', $attachment['Node']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?> </li>
              </ul>
            </div>
            <div class="action-bottom-block"></div>
          </div>
        </div></td>
      <td><?php
						$mimeType = explode('/', $attachment['Node']['mime_type']);
						$mimeType = $mimeType['0'];
						if ($mimeType == 'image') {
							$thumbnail = $this->Html->link($this->Image->resize($attachment['Node']['path'], 100, 200), '#', array(
								'onclick' => "selectURL('".$attachment['Node']['slug']."');",
								'escape' => false,
							));
						} else {
							$thumbnail = $this->Html->image('/img/icons/page_white.png') . ' ' . $attachment['Node']['mime_type'] . ' (' . $this->Filemanager->filename2ext($attachment['Node']['slug']) . ')';
							$thumbnail = $this->Html->link($thumbnail, '#', array(
								'onclick' => "selectURL('".$attachment['Node']['slug']."', 0);",
								'escape' => false,
							));
						}
						echo $thumbnail;
					?>
      </td>
      <td><?php echo $this->Html->cText($attachment['Node']['title']);?></td>
      <td><?php echo $this->Html->link($this->Text->truncate(Router::url($attachment['Node']['path'], true), 20), $attachment['Node']['path']); ?></td>
    </tr>
<?php
		}
	else:
?>
    <tr>
      <td colspan="5" class="notice"><?php echo sprintf(__l('No %s available'), __l('content attachments'));?></td>
    </tr>
<?php
	endif;
?>
  </table>
  <div class="clearfix">
    <div class="js-pagination grid_right"> <?php echo $this->element('paging_links'); ?> </div>
  </div>
</div>
