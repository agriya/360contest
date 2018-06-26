<?php
	echo $this->element('admin_panel_contest_view', array('controller' => 'contests', 'action' => 'index', 'contest' =>$contest), array('plugin' => 'Contests'));
?>