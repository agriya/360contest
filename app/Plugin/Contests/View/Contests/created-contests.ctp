<div class="createdcontests index">
<h2>
	<?php
		if(empty($this->pageTitle)):
			echo __l('Created Contests');
		else:
			echo $this->pageTitle;
		endif;
	?>
</h2>
<?php
	echo $this->Form->create('Contest' , array('class' => 'normal'));
 ?>
	<table class="list">
		<tr>
			<th><?php echo $this->Paginator->sort('name', __l('Contest Title'));?></th>
			<th><?php echo $this->Paginator->sort('actual_end_date', __l('Ends'));?></th>
			<th><?php echo __l('Entries count');?></th>
			<th><?php echo __l('Package');?></th>
	    </tr>
	<?php
	if (!empty($contests)):
	$i = 0;
	foreach ($contests as $contest):
 	$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
		<tr<?php echo $class;?>>
  			<td>
           	<div class="status-block">
            <span class =" <?php echo $contest['ContestStatus']['slug'];?>">
            <?php echo $this->Html->cText($contest['ContestStatus']['name']);?>
            </span>
            </div>
            <?php echo $this->Html->link($this->Html->cText($this->Html->truncate($contest['Contest']['name'],25),false), array('controller'=> 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin' => false), array('escape' => false));?>
            <div class="contest-type"><?php echo $this->Html->cText($contest['ContestType']['name']);?></div>
            </td>
  			<td><?php echo $this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']);?></td>
            <td><?php echo $this->Html->link($this->Html->cInt($contest['Contest']['contest_user_count'],false), array('controller' => 'contest_users', 'action' => 'index', 'type' =>'contest_holder','contest'=>$contest['Contest']['slug'],  'admin' => false), array('title' => __l('My Entries')));?></td>
            <td><?php echo $this->Html->cText($contest['PricingPackage']['name'],false);?></td>
            </tr>
	<?php
		endforeach;
	else:
	?>
		<tr>
			<td colspan="10" class="notice"><?php echo sprintf(__l('No %s available'), __l('contests'));?></td>
		</tr>
	<?php
	endif;
	?>
	</table>


<div class="clearfix">
       <div class="grid_right">
        <?php if (!empty($contests)) {
           echo $this->element('paging_links');
          }
        ?>
   </div>

</div>
<?php
    echo $this->Form->end();
?>
</div>