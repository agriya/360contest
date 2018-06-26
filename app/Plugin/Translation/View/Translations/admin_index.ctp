<div class="js-response">
<div class="top-pattern sep-bot"></div>
<?php
		if (empty($translations)):
	?>
  <div class="alert mspace alert-warning"> <?php echo __l('Sorry, in order to translate, default English strings should be extracted and available. Please contact support.');?> </div>
  <?php endif; ?>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span pull-right grayc">
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Make New Translation') . '</span>', array('controller' => 'translations', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Make New Translation'),'escape' => false)); ?>
            <?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add New Text') . '</span>', array('controller' => 'translations', 'action' => 'add_text'), array('class' => 'grayc','title'=>__l('Add New Text'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
       <th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Language');?></th>
      <th rowspan="2" class="sep-right dc"><?php echo __l('Verified');?></th>
      <th  rowspan="2" class="sep-right dc"><?php echo __l('Not Verified');?></th>
      <th rowspan="2" class="sep-right dc"><?php echo __l('Manage');?></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($translations)):
$i = 0;
foreach ($translations as $language_id => $translation):
?>
	<tr>
		<td class="dc"><?php echo $this->Html->cText($translation['name']);?></td>
      <td class="dc"><?php
					if($translation['verified']){
						echo $this->Html->link($translation['verified'], array('action' => 'manage', 'filter' => 'verified', 'language_id' => $language_id));
					} else {
						echo $this->Html->cText($translation['verified']);
					}
				?>
      </td>
      <td class="dc"><?php
					if($translation['not_verified']){
						echo $this->Html->link($translation['not_verified'], array('action' => 'manage', 'filter' => 'unverified', 'language_id' => $language_id));
					} else {
						echo $this->Html->cText($translation['not_verified']);
					}
				?>
      </td>
      <td class="dc"><span><?php echo $this->Html->link(__l('Manage'), array('action' => 'manage', 'language_id' => $language_id), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></span>
        <?php if($language_id != '42'): ?>
        <span><?php echo $this->Html->link(__l('Delete'), array('action' => 'index', 'remove_language_id' => $language_id), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete Translation')));?></span>
        <?php endif;?>
      </td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Translations'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
</div>
</div>
</div>