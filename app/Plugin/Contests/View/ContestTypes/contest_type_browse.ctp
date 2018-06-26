		<ul class="unstyled top-mspace">
				<?php
				if (!empty($contestTypes)):?>
					<li <?php if (!empty($this->request->params['named']['contest_status']) && empty($this->request->params['named']['contest_type_id'])): ?> class="active hor-space"<?php else: ?> class="mspace"<?php endif; ?>><i class="icon-angle-right blackc"></i><?php echo $this->Html->link($this->Html->cText(__l('All Categories'), false) . ' (' . $this->Html->cInt((!empty($contests_all_count)) ? $contests_all_count : 0) . ')', array('controller'=> 'contests', 'action' => 'index', 'status' =>$this->request->params['named']['contest_status']), array('title' => $this->Html->cText(__l('All Categories'), false) . ' (' . $this->Html->cInt((!empty($contests_all_count)) ? $contests_all_count : 0, false) . ')', 'escape' => false,'class' => 'js-no-pjax js-entries-link js-tooltip'));?></li>
					<?php $i = 0;
					foreach($contestTypes as $contestType):
						$class = null;
						if ($i++ % 2 == 0) {
						$class = 'altrow';
						}
						?>
						<li <?php if ($contestType['ContestType']['id'] == $this->request->params['named']['contest_type_id']): ?> class="active mspace"<?php else: ?> class="hor-space no-mar js-tooltip clearfix" title="<?php echo $this->Html->cText($contestType['ContestType']['name'], false) . ' (' . $this->Html->cInt((!empty($contestType['ContestType']['count'])) ? $contestType['ContestType']['count'] : 0, false) . ')';?>" <?php endif; ?>>
                        	<i class="icon-angle-right blackc pull-left"></i>
							<?php echo $this->Html->link($this->Html->cText($contestType['ContestType']['name'], false) . ' (' . $this->Html->cInt((!empty($contestType['ContestType']['count'])) ? $contestType['ContestType']['count'] : 0) . ')', array('controller'=> 'contests', 'action' => 'index', 'contest_type_id' => $contestType['ContestType']['id'], 'status' => $this->request->params['named']['contest_status']), array('title' => $this->Html->cText($contestType['ContestType']['name'], false) . ' (' . $this->Html->cInt((!empty($contestType['ContestType']['count'])) ? $contestType['ContestType']['count'] : 0, false) . ')', 'escape' => false,'class' => 'js-no-pjax js-entries-link pull-left span4 no-mar')); ?>
						</li>
					<?php
					endforeach;
				else:
				?>
					<li><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Contest Types'));?></p>
					</div></li>
			<?php endif; ?>
			</ul>		
	