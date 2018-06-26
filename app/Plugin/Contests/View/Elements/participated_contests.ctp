<?php	
  echo $this->requestAction(array('controller' => 'contest_users', 'action' => 'index'), array('named' =>array('type' => 'myparticipated', 'user_id' => $user['User']['id']),'return'));

  
?>