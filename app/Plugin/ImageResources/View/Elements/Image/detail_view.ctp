<?php
		if (!empty($contestUser)):
		echo $this->Html->showImage('ContestUser', $contestUser['attachment'], array('dimension' => 'very_big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $contestUser['name']), 'title' => $contestUser['name'], 'escape' => false, 'class' => 'js-image-attr'));
	endif;
	
	
?>