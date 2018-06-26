<div class="side2 grid_6">
    <div class="category-block">
            <div class="menu-block-cr">
                <div class="menu-block-inner">
                    <h3><?php echo __l('Contest Types');?></h3>

	<ul class="categoy-list clearfix">
	<?php
if (!empty($contestTypes)):
		$i = 0;
		foreach($contestTypes as $contestType):
				$class = null;
			if ($i++ % 2 == 0) {
				$class = 'altrow';
			}

		?>
		<li class="list-row clearfix" id="blog-<?php echo $contestType['ContestType']['id'];?>">
			<?php echo $this->Html->link(htmlentities($contestType['ContestType']['name']), array('controller' => 'contests', 'action'=>'index', 'contest_type_id' => $contestType['ContestType']['id']), array('escape' => false, 'title' => $this->Html->cText($contestType['ContestType']['name'], false))); ?>
		</li>
		<?php endforeach; ?>
        <?php else: ?>
        	<li>
        		<p class="notice"><?php echo sprintf(__l('No %s available'), __l('contest types')); ?></p>
        	</li>
      <?php endif; ?>
      </ul>
      </div>
</div>
</div>
</div>