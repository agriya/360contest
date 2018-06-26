<?php
	if (!empty($contestUser['MessageContent']['text_resource'])){
			$text_entry = $this->Html->cText(substr($contestUser['MessageContent']['text_resource'], 0, round(strlen($contestUser['MessageContent']['text_resource'])/2)));
			echo $this->Html->link($text_entry ,array('controller' => 'contest_users', 'action' => 'view' ,$contestUser['Contest']['slug'],'entry' => $contestUser['ContestUser']['entry_no']),array('escape' => false, 'class' => 'blackc text-message-entry text-10 htruncate-ml3 sep'));
	}
?>