<?php
	echo $this->requestAction(array('controller' => 'contest_types', 'action' => 'index'), array('named' => array('type' => 'contest_type_browse', 'contest_status' => $this->request->params['named']['status'], 'contest_type_id' => !empty($this->request->params['named']['contest_type_id']) ? $this->request->params['named']['contest_type_id'] : ''), 'return'));
?>