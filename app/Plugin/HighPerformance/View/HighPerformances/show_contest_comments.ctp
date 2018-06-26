<?php if (!empty($contest_user_id)) { ?>
	<?php echo $this->element('Contests.message-discussions',array('contest_id'=>$contestUser['Contest']['id'],'contet_user_id'=>$contest_user_id,'entry'=>$entry,'page'=>$page, 'cache' => array('config' => 'sec')));?>
<?php } else { ?>
	<section class="top-mspace top-space">
		<?php echo $this->element('Contests.message-discussions',array('contest_id'=>$contest['Contest']['id'], 'cache' => array('config' => 'sec'))); ?>
	</section> &nbsp;
<?php } ?>