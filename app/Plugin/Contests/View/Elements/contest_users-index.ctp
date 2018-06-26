<?php
    echo $this->requestAction(array('controller' => 'contest_users', 'action' => 'index'), array('named' =>array('contest' => $slug),'return'));
?>