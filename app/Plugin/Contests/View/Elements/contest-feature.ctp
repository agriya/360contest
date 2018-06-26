<?php
  echo $this->requestAction(array('controller' => 'contests', 'action' => 'index'), array('named' =>array('type' => 'is_featured'),'return'));
?>