<?php
	if (!empty($reply)) {
		echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose', $reply, 'reply'), array('named' => array('contest_id' => $contest_id, 'user' => $user, 'type' => 'contact', 'reply_type' => 'quickreply'), 'return'));
	} else {
		if (!empty($user)) {
			echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose'), array('named' => array('contest_id' => $contest_id, 'user' => $user, 'type' => 'contact'), 'return'));
		} else {
			echo $this->requestAction(array('controller' => 'messages', 'action' => 'compose'), array('named' => array('contest_id' => $contest_id, 'type' => 'contact'), 'return'));
		}
	}
?>