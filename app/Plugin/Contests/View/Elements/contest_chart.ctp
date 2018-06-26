<?php
    echo $this->requestAction(array('controller' => 'contest_charts', 'action' => 'chart_transactions', 'is_ajax_load' => 1), array('return'));
?>