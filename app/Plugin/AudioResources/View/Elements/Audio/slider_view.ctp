<?php
	echo $this->Html->link('', array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no'], 'page'=>$page, 'admin'=> false), array('escape' => false, 'class'=>'show  pa audio-entry' ));
	echo $this->requestAction(array('controller' => 'audio_uploads', 'action' => 'getIFrameTrack', $contestUser['AudioUpload'][0]['soundcloud_audio_id'], '80', '85')); 
 ?>