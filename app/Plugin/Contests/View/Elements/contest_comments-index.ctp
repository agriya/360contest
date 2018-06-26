<?php
    echo $this->requestAction(array('controller' => 'contest_comments', 'action' => 'index', $contest['Contest']['id']), array('named' => array('key' => $contest['Contest']['id']),'return'));
?>
