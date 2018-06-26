<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="contestFollowers index js-response">
    <?php echo $this->Form->create('contestFollower' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <ul class="unstyled">
      <?php
        if (!empty($contestFollows)):
                $i = 0;
            foreach ($contestFollows as $contestFollower):
                $active_class = '';
               ?>
             <li class="thumbnail  sep-bot mspace clearfix">
                 <div class="clearfix span">
    				<div class="span smspace">
						<?php $contestFollower['User']['UserAvatar'] = !empty($contestFollower['User']['UserAvatar']) ? $contestFollower['User']['UserAvatar'] : array(); ?>
    					<?php echo $this->Html->getUserAvatarLink($contestFollower['User'], 'small_thumb'); ?>
    				</div>
    				<div class="span">
						<h3 class="span"><?php echo $this->Html->link($this->Html->cText($contestFollower['User']['username'], false), array('controller' => 'users', 'action' => 'view', $contestFollower['User']['username'], 'admin' => false), array('title' => $contestFollower['User']['username'])); ?></h3>
						<?php
							$entry_count = 0;
							if (!empty($contestFollower['User']['ContestUser'])):
								$entry_count = count($contestFollower['User']['ContestUser']);
							endif;
						?>
						<?php if (empty($entry_count)) { ?>
							<span class="span"><?php echo __l('Following only'); ?></span>
						<?php } else { ?>
							<span class="span"><?php echo sprintf(__l('Following and submitted %s %s'), $entry_count, ($entry_count > 1) ? 'entries' : 'entry'); ?></span>
						<?php } ?>
					</div>
				</div>
            
			</li>
                <?php
            endforeach;
        else:
            ?>
            <li>
				<div class="thumbnail space dc grayc">
				<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Contest Followers'));?></p>
				</div>
            </li>
            <?php
        endif;
        ?>
    </ul>
    <?php echo $this->Form->end(); ?>
</div>