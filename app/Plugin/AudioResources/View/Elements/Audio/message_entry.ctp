<?php
	echo $this->Html->link('', array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'page'=>1, 'admin'=> false), array('escape' => false, 'class'=>'show  pa audio-message-entry' ));
echo $this->requestAction(array('controller' => 'audio_uploads', 'action' => 'getIFrameTrack', $contestUser['ContestUser']['Attachment'][0]['soundcloud_audio_id'], '52', '68')); 
?>