<?php
	if(!empty($contet_user_id)){
	    echo $this->requestAction(array('controller' => 'messages', 'action' => 'index'), array('named' =>array('contest_id'=>$contest_id,'contet_user_id'=>$contet_user_id,'entry'=>$this->request->params['named']['entry'],'page'=>!empty($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1),'return'));
	}else{
		echo $this->requestAction(array('controller' => 'messages', 'action' => 'index'), array('named' =>array('contest_id'=>$contest_id),'return'));
	}
?>
