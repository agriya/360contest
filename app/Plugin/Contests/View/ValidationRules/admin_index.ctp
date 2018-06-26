<div class="validationRules index">
    <div class="clearfix">
        <p class="paging-count grid_left">
            <?php
            echo $this->Paginator->counter(array(
            'format' => __l('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
            ));
            ?>
        </p>
        <div class="grid_left">
            <?php echo $this->Form->create('ValidationRule', array('type' => 'get', 'class' => 'normal', 'action'=>'index')); ?>
            <?php echo $this->Form->input('q', array('label' => __l('Keyword')));
        	 echo $this->Form->input('type', array('type' => 'hidden')); ?>
           	<?php echo $this->Form->submit(__l('Search'));?>
        	<?php echo $this->Form->end(); ?>
    	</div>
	</div>
<?php
        echo $this->Form->create('ValidationRule' , array('action' => 'update','class'=>'normal'));?>
        <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<table class="list">
<tr>
	<th class="select"><?php echo __l('Select'); ?></th>
	<th class="actions"><?php echo __l('Actions');?></th>
	<th><?php echo $this->Paginator->sort('rule', __l('Rule'));?></th>
	<th><?php echo $this->Paginator->sort('message', __l('Message'));?></th>
</tr>
<?php
$i = 0;
foreach ($validationRules as $validationRule):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		 <td><?php echo $this->Form->input('ValidationRule.'.$validationRule['ValidationRule']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$validationRule['ValidationRule']['id'], 'label' => false)); ?></td>
		 		<td  class="actions">
			<div class="action-block">
				<span class="action-information-block">
					<span class="action-left-block">&nbsp;
					</span>
					<span class="action-center-block">
						<span class="action-info">
							<?php echo __l('Action');?>
						</span>
					</span>
				</span>
				<div class="action-inner-block">
					<div class="action-inner-left-block">
						<ul class="action-link clearfix">
							<li><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $validationRule['ValidationRule']['id']),array('class' => 'edit')); ?></li>
							<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $validationRule['ValidationRule']['id']),array('class' => 'delete')); ?>
                                 <?php echo $this->Layout->adminRowActions($validationRule['ValidationRule']['id']);?>
                             </li>
						</ul>
					</div>
					<div class="action-bottom-block"></div>
				</div>
			</div>
		 </td>
		<td><?php echo $validationRule['ValidationRule']['rule']; ?></td>
		<td><?php echo $validationRule['ValidationRule']['message']; ?></td>
	</tr>
<?php endforeach; ?>
</table>
</div>
<?php
if (!empty($validationRule)) { ?>
    <div class="clearfix">
        <div class="admin-select-block grid_left">
        	<div class="admin-checkbox-button">
                <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
            </div>
        </div>
    	<div class="js-pagination grid_right">
        	<?php
            echo $this->element('paging_links');
        	?>
    	</div>
	</div>
	<div class="hide">
		<?php echo $this->Form->submit('Submit'); ?>
	</div>
<?php
}
?>
 <?php echo $this->Form->end();?>