<a href="#"><?php echo __l('Contests'); ?></a>
<ul>
	<li><?php echo $this->Html->link(__l('Contests'), array('controller' => 'contests', 'action' => 'index', 'admin' => true), array('title' => __l('Contests'))); ?></li>
	 <li><?php echo $this->Html->link(__l('Contest Entires'), array('controller' => 'contest_users', 'action' => 'index', 'admin' => true), array('title' => __l('Contest Entires'))); ?></li>
</ul>

<a href="#"><?php echo __l('Contest Types'); ?></a>
<ul>
	<li><?php echo $this->Html->link(__l('Contest Templates'), array('controller' => 'contest_types', 'action' => 'index', 'type' => 'templates', 'admin' => true), array('title' => __l('Contest Types'))); ?></li>			
    <li><?php echo $this->Html->link(__l('Contest Types'), array('controller' => 'contest_types', 'action' => 'index', 'admin' => true), array('title' => __l('Contest Templates'))); ?></li>			    
    <li><?php echo $this->Html->link(__l('Validation Rules'), array('controller' => 'validation_rules', 'action' => 'index')); ?></li>
</ul>