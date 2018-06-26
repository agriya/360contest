<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contestUserRatings index">
<h2><?php echo __l('Contest User Ratings');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($contestUserRatings)):

$i = 0;
foreach ($contestUserRatings as $contestUserRating):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($contestUserRating['ContestUserRating']['id']);?></p>
		<p><?php echo $this->Html->cDateTime($contestUserRating['ContestUserRating']['created']);?></p>
		<p><?php echo $this->Html->cDateTime($contestUserRating['ContestUserRating']['modified']);?></p>
		<p><?php echo $this->Html->link($this->Html->cText($contestUserRating['User']['username']), array('controller'=> 'users', 'action' => 'view', $contestUserRating['User']['username']), array('escape' => false));?></p>
		<p><?php echo $this->Html->link($this->Html->cInt($contestUserRating['ContestUser']['id']), array('controller'=> 'contest_users', 'action' => 'view', $contestUserRating['ContestUser']['id']), array('escape' => false));?></p>
		<p><?php echo $this->Html->cInt($contestUserRating['ContestUserRating']['rating']);?></p>
		<p><?php echo $this->Html->link($this->Html->cInt($contestUserRating['Ip']['id']), array('controller'=> 'ips', 'action' => 'view', $contestUserRating['Ip']['id']), array('escape' => false));?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $contestUserRating['ContestUserRating']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $contestUserRating['ContestUserRating']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo sprintf(__l('No %s available'), __l('entry ratings'));?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($contestUserRatings)) {
    echo $this->element('paging_links');
}
?>
</div>
