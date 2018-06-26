<?php 
	$contestUser['Attachment'][0] = !empty($contestUser['Attachment'][0]) ? $contestUser['Attachment'][0] : array();
	echo $this->Html->link($this->Html->showImage('ContestUser', $contestUser['Attachment'][0], array('dimension' => 'small_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $contestUser['User']['username']), 'title' => $contestUser['User']['username'])), array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'page' => $page), array('escape' => false));
?>