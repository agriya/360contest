<?php /* SVN: $Id: $ */ ?>
<div class="Roles form">
	<?php
		echo $this->Form->create('Role', array('url' => array('controller' => 'roles', 'action' => 'add','admin' => true),'class' => 'normal'));
		echo $this->Form->input('name');
		if (!empty($parent_id)):
			echo $this->Form->input('parent_id', array('type' => 'hidden', 'value' => $parent_id));
		endif;
	?>
    <div class="submit-block clearfix">
        <?php
            echo $this->Form->submit(__l('Add'));
        	if(!empty($this->request->params['requested'])) {
		    	echo $this->Form->submit(__l('Cancel'),array('class' => 'js-toggle-div {"divClass":"js-show-user-type-add"}'));
			}
			else {
		?>	
        		<div class="cancel-block">
                	<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'roles', 'action' => 'index'), array('class' => 'cancel-link','title' => __l('Cancel'), 'escape' => false)); ?>
                </div>
        <?php } ?>
    </div>
	<?php  echo $this->Form->end(); ?>
</div>