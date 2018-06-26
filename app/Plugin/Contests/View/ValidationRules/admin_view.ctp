<div class="validationRules view">
<h2><?php  echo __l(('ValidationRule');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l(('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $validationRule['ValidationRule']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l(('Rule'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $validationRule['ValidationRule']['rule']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l(('Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $validationRule['ValidationRule']['message']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__l(('Edit ValidationRule'), array('action' => 'edit', $validationRule['ValidationRule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__l(('Delete ValidationRule'), array('action' => 'delete', $validationRule['ValidationRule']['id']), null, sprintf(__l(('Are you sure you want to delete # %s?'), $validationRule['ValidationRule']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__l(('List ValidationRules'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__l(('New ValidationRule'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__l(('List Form Fields'), array('controller' => 'form_fields', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__l(('New Form Field'), array('controller' => 'form_fields', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __l(('Related Form Fields');?></h3>
	<?php if (!empty($validationRule['FormField'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __l(('Id'); ?></th>
		<th><?php echo __l(('Name'); ?></th>
		<th><?php echo __l(('Label'); ?></th>
		<th><?php echo __l(('Type'); ?></th>
		<th><?php echo __l(('Length'); ?></th>
		<th><?php echo __l(('Null'); ?></th>
		<th><?php echo __l(('Default'); ?></th>
		<th><?php echo __l(('Cform Id'); ?></th>
		<th><?php echo __l(('Required'); ?></th>
		<th class="actions"><?php echo __l(('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($validationRule['FormField'] as $formField):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $formField['id'];?></td>
			<td><?php echo $formField['name'];?></td>
			<td><?php echo $formField['label'];?></td>
			<td><?php echo $formField['type'];?></td>
			<td><?php echo $formField['length'];?></td>
			<td><?php echo $formField['null'];?></td>
			<td><?php echo $formField['default'];?></td>
			<td><?php echo $formField['cform_id'];?></td>
			<td><?php echo $formField['required'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__l(('View'), array('controller' => 'form_fields', 'action' => 'view', $formField['id'])); ?>
				<?php echo $this->Html->link(__l(('Edit'), array('controller' => 'form_fields', 'action' => 'edit', $formField['id'])); ?>
				<?php echo $this->Html->link(__l(('Delete'), array('controller' => 'form_fields', 'action' => 'delete', $formField['id']), null, sprintf(__l(('Are you sure you want to delete # %s?'), $formField['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__l(('New Form Field'), array('controller' => 'form_fields', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
