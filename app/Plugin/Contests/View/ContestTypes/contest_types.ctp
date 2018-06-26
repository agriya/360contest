
	<?php
if (!empty($contestTypes)):
		$i = 0;
		foreach($contestTypes as $contestType):
				$class = null;
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}

		?>
		<li>
		<?php echo $this->Html->cText($contestType['ContestType']['name'], false);?>
			</li>
		<?php endforeach; ?>
        <?php else: ?>
        	<li>
        		<p class="notice"><?php echo sprintf(__l('No %s available'), __l('contest types')); ?></p>
        	</li>
      <?php endif; ?>
