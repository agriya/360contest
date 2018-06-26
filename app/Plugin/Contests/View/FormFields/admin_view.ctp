<div class="formFields view">
<h2><?php echo __l('FormField');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Label'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['label']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Length'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['length']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Null'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['null']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Default'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['default']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Cform'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($formField['Cform']['name'], array('controller' => 'cforms', 'action' => 'view', $formField['Cform']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Required'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $formField['FormField']['required']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__l('Edit FormField'), array('action' => 'edit', $formField['FormField']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__l('Delete FormField'), array('action' => 'delete', $formField['FormField']['id']), null, sprintf(__l('Are you sure you want to delete # %s?'), $formField['FormField']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__l('List FormFields'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__l('New FormField'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__l('List Cforms'), array('controller' => 'cforms', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__l('New Cform'), array('controller' => 'cforms', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__l('List Validation Rules'), array('controller' => 'validation_rules', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__l('New Validation Rule'), array('controller' => 'validation_rules', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __l('Related Validation Rules');?></h3>
	<?php if (!empty($formField['ValidationRule'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __l('Id'); ?></th>
		<th><?php echo __l('Rule'); ?></th>
		<th><?php echo __l('Message'); ?></th>
		<th class="actions"><?php echo __l('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($formField['ValidationRule'] as $validationRule):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $validationRule['id'];?></td>
			<td><?php echo $validationRule['rule'];?></td>
			<td><?php echo $validationRule['message'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__l('View'), array('controller' => 'validation_rules', 'action' => 'view', $validationRule['id'])); ?>
				<?php echo $this->Html->link(__l('Edit'), array('controller' => 'validation_rules', 'action' => 'edit', $validationRule['id'])); ?>
				<?php echo $this->Html->link(__l('Delete'), array('controller' => 'validation_rules', 'action' => 'delete', $validationRule['id']), null, sprintf(__l('Are you sure you want to delete # %s?'), $validationRule['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__l('New Validation Rule'), array('controller' => 'validation_rules', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
