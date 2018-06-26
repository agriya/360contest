<?php
	if(!empty($contest_user_id)){
		echo $this->requestAction(array('controller' => 'messages', 'action' => 'activities'), array('named' =>array('contest_id'=>$contest_id,'contest_user_id'=>$contest_user_id,'type'=>'contest_user'),'return'));
	}
	else{
	     echo $this->requestAction(array('controller' => 'messages', 'action' => 'activities'), array('named' =>array('contest_id'=>$contest_id,'type'=>'contest_user'),'return'));
	}
?>
