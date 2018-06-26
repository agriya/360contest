<?php
  echo $this->requestAction(array('controller' => 'contests', 'action' => 'index'), array('named' =>array('type' => 'my-contests' , 'user_id' => $user['User']['id']),'return'));

?>
