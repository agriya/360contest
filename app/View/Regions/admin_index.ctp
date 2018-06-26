<div class="regions index">
	<div class="clearfix">
		<div class="grid_left">
			<?php echo $this->element('paging_counter');?>
		</div>
		<div class="grid_right add-block">
			<?php echo $this->Html->link(__l('Add Region'), array('controller' => 'regions', 'action' => 'add'), array('class' => 'add', 'title' => __l('Add Region'))); ?>
		</div>
	</div>
	<table class="list">
		<tr>
			<th class="actions"><?php echo __l('Actions'); ?></th>
			<th><div class="js-pagination"><?php echo $this->Paginator->sort('title', __l('Title')); ?></div></th>
			<th><div class="js-pagination"><?php echo $this->Paginator->sort('alias', __l('Alias')); ?></div></th>
		</tr>
		<?php
			if (!empty($regions)):
				$i = 0;
				foreach ($regions AS $region) {
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
									<li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'regions', 'action' => 'edit', $region['Region']['id']), array('class' => 'edit', 'title' => __l('Edit')));?>
									</li>
									<li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'regions', 'action' => 'delete', $region['Region']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?>
									</li>
								</ul>
							</div>
							<div class="action-bottom-block"></div>
						</div>
					</div>
				</td>
				<td><?php echo $this->Html->cText($region['Region']['title']);?></td>
				<td><?php echo $this->Html->cText($region['Region']['alias']);?></td>
			</tr>
		<?php
				}
			else:
		?>
		<tr>
			<td colspan="5" class="notice"><?php echo sprintf(__l('No %s available'), __l('regions'));?></td>
		</tr>
		<?php
			endif;
		?>
    </table>
	<div class="clearfix">
		<div class="js-pagination grid_right">
			<?php echo $this->element('paging_links'); ?>
		</div>
	</div>
</div>