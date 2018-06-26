<?php
    echo $this->requestAction(array('controller' => 'contest_types', 'action' => 'view', $this->request->data['Contest']['contest_type_id']), array('return'));
?>