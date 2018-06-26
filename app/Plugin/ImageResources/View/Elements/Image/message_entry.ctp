<?php
	if (!empty($contestUser['ContestUser']['Attachment'][0])){
		if($type == 'entry'){
			echo $this->Html->link($this->Html->showImage('ContestUser', $contestUser['ContestUser']['Attachment'][0], array('dimension' => 'slider_thumb', 'title' => '# ' . $contestUser['ContestUser']['entry_no'], 'escape' => false)),array('controller' => 'contest_users', 'action' => 'view' ,$contestUser['Contest']['slug'],'entry' => $contestUser['ContestUser']['entry_no']),array('escape' => false));
		}else{
			$image_url = substr(Router::url('/', true), 0, -1) . getImageUrl('ContestUser', $contestUser['MessageContent']['Attachment'][0], array('dimension' => 'very_big_thumb'));
			echo $this->Html->link($this->Html->showImage('ContestUser', $contestUser['MessageContent']['Attachment'][0], array('dimension' => 'medium_thumb', 'title' => '# ' . $contestUser['ContestUser']['entry_no'], 'escape' => false)),$image_url,array('class' => 'js-entry-colorbox', 'escape' => false));
		}
	}
?>