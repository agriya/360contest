<?php
     echo $this->requestAction(array('controller' => 'contest_users', 'action' => 'index'), array('named' =>array('contest'=>$contest_slug,'type'=>'slider','entry'=>$entry,'page'=>$page),'return'));
?>
