<span class="span2 htruncate-ml3 blackc">
<?php
	echo $this->Html->link($contestUser['TextResource']['0']['MessageContent']['text_resource'], array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'page' => $page), array('escape' => false));
	
 ?>
</span> 