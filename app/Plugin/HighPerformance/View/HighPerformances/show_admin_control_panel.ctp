<?php 
if(!empty($this->request->params['named']['view_type']) && $this->request->params['named']['view_type'] == 'contest') {
	echo $this->element('admin_panel_contest_view', array('controller' => 'contests', 'action' => 'index', 'contest' =>$contest), array('plugin' => 'Contests'));
} else {
	echo $this->element('admin_panel_user_view');
}
?>