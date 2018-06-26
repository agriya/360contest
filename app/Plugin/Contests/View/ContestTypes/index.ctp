<div class="top-pattern sep-bot">
  <div class="space container">
	<ul class="row no-mar mob-c unstyled space">
		<li class="span dc no-mar offset2 span5"><div class="span no-mar"> <span class="label label-important span1 dc space no-mar text-24">1</span></div><span class="text-24 textb blackc span dc space no-mar text-24"> Step1</span> </li>
		</li>
	
		<li class="span dc no-mar span5"><div class="span no-mar"> <span class="label label-inverse span1 dc space no-mar text-24">2</span></div><span class="text-24 textb grayc span dc space no-mar text-24 "> Step2</span> </li>
		</li>
		<li class="span dc no-mar span5"><div class="span no-mar"> <span class="label label-inverse span1 dc space no-mar text-24">3</span></div><span class="text-24 textb grayc span dc space no-mar text-24"> Step3</span> </li>
		</li>
	<ul>
</div>
</div>
	<div class="contestTypes index container">
		<div class="stage-inner-block">
		<h2 class="ver-mspace ver-space"><?php echo __l('What do you want to launch?');?></h2>
		<table class="table table-striped">
		<?php
		if (!empty($contestTypes)):
			$i = 0;
			foreach($contestTypes as $contestType):
				$class = null;
				if ($i++ % 2 == 0) {
					$class = 'altrow';
				}
			?>
			<tr> 
			<td id="blog-<?php echo $contestType['ContestType']['id'];?>" class=" mspace well clearfix">		
				<a href = "<?php echo Router::url(array('controller' => 'contests', 'action' => 'add', 'contest_type_id' => $contestType['ContestType']['id']));?>" class="clearfix " title = "<?php echo $contestType['ContestType']['name'];?>">
						<div class="mspace no-under bot-space clearfix">
						<div class="no-mar row">
						<div class="bot-mspace pull-left clearfix">
						<span class="no-mar span">
						<?php if ($contestType['ContestType']['resource_id'] == ConstResource::Image) { ?>
			                  <span class="js-tooltip" title ="<?php echo __l('Image Resource');?>"><i class="icon-picture grayc text-13"></i></span>
			            <?php } ?>
		                <?php if ($contestType['ContestType']['resource_id'] == ConstResource::Video) { ?>
							 <span class="js-tooltip" title ="<?php echo __l('Video Resource');?>"><i class="icon-facetime-video grayc text-13"></i></span>
	                    <?php } ?>
                         <?php if ($contestType['ContestType']['resource_id'] == ConstResource::Audio) { ?>
							 <span class="js-tooltip" title ="<?php echo __l('Audio Resource');?>"><i class="icon-volume-up grayc text-13"></i></span>
	                    <?php } ?>
                        <?php if ($contestType['ContestType']['resource_id'] == ConstResource::Text) { ?>
							 <span class="js-tooltip" title ="<?php echo __l('Text Resource');?>"><i class="icon-edit grayc text-13"></i></span>
	                    <?php } ?>
						</span>
						<h3 class="no-mar span pinkc no-under text-14">
							<?php echo $this->Html->cText($contestType['ContestType']['name']);?></i>
						</h3>
						</div>
						<span class="pull-right span3 currency-info  dr hide grayc no-mar">
						<?php echo '<i class="icon-tags pinkc"></i>'.__l('from') . ' ' . $this->Html->siteCurrencyFormat($contestType['ContestType']['minimum_prize']); ?>
						</span>
						</div>
						<div class="contest-type-description  top-smspace no-under grayc pull-left htruncate-ml2 js-tooltip" title="<?php echo $this->Html->cText($contestType['ContestType']['description'], false); ?>"><?php echo $this->Html->cText($contestType['ContestType']['description']); ?></div>
						</div>
				</a>
				</td>
			</tr>		
			<?php endforeach; ?>
			<?php else: ?>
				<tr>
					<td><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Contest Types'));?></p>
					</div></td>
				</tr>
		  <?php endif; ?>
		  </table>
		  <?php

		   if (!empty($contestTypes)) {?>
		   <div class="pull-right">
			   <?php echo $this->element('paging_links');?>
			   </div>
		  <?php  }
		  ?>
		</div>
	</div>