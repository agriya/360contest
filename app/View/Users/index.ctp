<div class="space">
<div class="users index js-response">
<?php
	echo $this->Form->create('User' , array('class' => 'normal top-space','action' => 'index'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<ol class="list top-participants-list unstyled space thumbnail">

<?php
if (!empty($users)):
$i = 0;
foreach ($users as $user):
	$class = null;
	$active_class = '';
	if ($i++ % 2 == 0):
		$class = "altrow";
	endif;
	?>
<?php
$avg_rating=$user['User']['average_rating'];
?>
             <li class="thumbnail  sep-bot mspace clearfix">
                 <div class="clearfix span">
    				<div class="span smspace">
						<?php $user['User']['UserAvatar'] = !empty($user['User']['UserAvatar']) ? $user['User']['UserAvatar'] : array(); ?>
    					<?php echo $this->Html->getUserAvatarLink($user['User'], 'small_thumb'); ?>
    				</div>
    				<div class="span">
						<h3 class="span"><?php echo $this->Html->link($this->Html->cText($user['User']['username'], false), array('controller' => 'users', 'action' => 'view', $user['User']['username'], 'admin' => false), array('title' => $user['User']['username'])); ?></h3>
						<?php
							$entry_count = 0;
							if (!empty($user['ContestUser'])):
								$entry_count = count($user['ContestUser']);
							endif;
						?>
						<?php if (empty($entry_count)) { ?>
							<span class="span"><?php echo __l('Following'); ?></span>
						<?php } else { ?>
							<span class="span"><?php echo sprintf(__l('Following. Submitted %s %s'), $entry_count, ($entry_count > 1) ? 'entries' : 'entry'); ?></span>
						<?php } ?>
					</div>
				</div>
            
			</li>
<?php
    endforeach;
else:
?>
	<li><div class="thumbnail space dc grayc">
		<p class="ver-mspace top-space text-16"><?php echo __l('No ') . $this->pageTitle . __l(' available');?></p>
	</div></li>
<?php
endif;
?>
</ol>
<div class="clearfix">
      <div class="pull-right">
        <?php if (!empty($users)) {
           echo $this->element('paging_links');
          }
        ?>
   </div>

</div>
<?php echo $this->Form->end();
?>
</div>
</div>
<div class="modal hide fade" id="js-ajax-modal">
  <div class="modal-body">
  	<div class="dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
	<span class="loading grayc">Loading....</span></div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
  </div>
</div>