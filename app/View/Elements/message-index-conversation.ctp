<?php
	echo $this->requestAction(array('controller' => 'messages', 'action' => 'index'), array('named' => array('request_id' => $request_id),'return'));
?>