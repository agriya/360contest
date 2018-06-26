<div class="submissions index">
<div class="actions">
    <ul>
        <li><?php echo $this->Html->link(__l('Back to Index'), array('controller' => 'cforms', 'action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__l('Export Records'), array('controller' => 'submissions', 'action' => 'export', $this->request->params['pass'][0])); ?></li>
    </ul>
</div>
<p>
<?php
echo $this->Paginator->counter(array(
'format' => __l('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $this->Paginator->sort('id');?></th>
	<th><?php echo $this->Paginator->sort('cform_id');?></th>
	<th><?php echo $this->Paginator->sort('created');?></th>
	<th><?php echo $this->Paginator->sort('ip');?></th>
	<th class="actions"><?php echo __l('Actions');?></th>
</tr>
<?php
$i = 0;
foreach ($submissions as $submission):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $submission['Submission']['id']; ?>
		</td>
		<td>
			<?php echo $this->Html->link($submission['Cform']['name'], array('controller' => 'cforms', 'action' => 'view', $submission['Cform']['id'])); ?>
		</td>
		<td>
			<?php echo $submission['Submission']['created']; ?>
		</td>
		<td>
			<?php echo $submission['Submission']['ip']; ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__l('View'), array('action' => 'view', $submission['Submission']['id'])); ?>
			<?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $submission['Submission']['id'])); ?>
			<?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $submission['Submission']['id']), null, sprintf(__l('Are you sure you want to delete # %s?'), $submission['Submission']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<div class="paging">
	<?php echo $this->Paginator->prev('<< '.__l('previous'), array(), null, array('class'=>'disabled'));?>
 | 	<?php echo $this->Paginator->numbers();?>
	<?php echo $this->Paginator->next(__l('next').' >>', array(), null, array('class' => 'disabled'));?>
</div>