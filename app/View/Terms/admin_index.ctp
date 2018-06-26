<div class="terms index">
	<div class="clearfix">
		<div class="grid_right add-block">
			<?php echo $this->Html->link(__l('Add Term'), array('controller' => 'terms', 'action' => 'add', $vocabulary['Vocabulary']['id']), array('class' => 'add', 'title' => __l('Add Term'))); ?>
		</div>
	</div>
	<div class="page-info"><?php echo __l('Warning! Please edit with caution.'); ?></div>
	<table class="list">
		<tr>
			<th class="actions"><?php echo __l('Actions'); ?></th>
			<th><?php echo __l('Title'); ?></th>
			<th><?php echo __l('Slug'); ?></th>
		</tr>
		<?php
			if (!empty($termsTree)):
				$i = 0;
				foreach ($termsTree AS $id => $title) {
					$i=0;
					if ($i++ % 2 == 0):
						$class = "altrow";
					endif;
		?>
			<tr class="<?php echo $class;?>">
				<td  class="actions">
					<div class="action-block">
						<span class="action-information-block">
							<span class="action-left-block">&nbsp;
							</span>
							<span class="action-center-block">
								<span class="action-info">
									<?php echo __l('Action');?>
								</span>
							</span>
						</span>
						<div class="action-inner-block">
							<div class="action-inner-left-block">
								<ul class="action-link clearfix">
									<li><?php echo $this->Html->link(__l('Move Up'), array('controller' => 'terms', 'action' => 'moveup', $id, $vocabulary['Vocabulary']['id']), array('class' => 'move-up', 'title' => __l('Move Up')));?></li>
									<li><?php echo $this->Html->link(__l('Move Down'), array('controller' => 'terms', 'action' => 'movedown', $id, $vocabulary['Vocabulary']['id']), array('class' => 'move-down', 'title' => __l('Move Down')));?></li>
									<li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'terms', 'action' => 'edit', $id, $vocabulary['Vocabulary']['id']), array('class' => 'edit', 'title' => __l('Edit')));?></li>
									<li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'terms', 'action' => 'delete', $id, $vocabulary['Vocabulary']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></li>
								</ul>
							</div>
							<div class="action-bottom-block"></div>
						</div>
					</div>
				</td>
				<td><?php echo $this->Html->cText($title);?></td>
				<td><?php echo $this->Html->cText($terms[$id]['slug']);?></td>
			</tr>
		<?php
				}
			else:
		?>
		<tr>
			<td colspan="5" class="notice"><?php echo sprintf(__l('No %s available'), __l('terms'));?></td>
		</tr>
		<?php
			endif;
		?>
    </table>
</div>