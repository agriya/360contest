<?php
if(isPluginEnabled('Contests')){
  echo $this->requestAction(array('controller' => 'contest_charts','action' => 'chart_contests', 'admin' => false), array('return'));
}
?>