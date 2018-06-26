<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contestTypesPricingPackages index">
<h2><?php echo __l('Contest Types Pricing Packages');?></h2>
<?php echo $this->element('paging_counter');?>
<ol class="list" start="<?php echo $this->Paginator->counter(array(
    'format' => '%start%'
));?>">
<?php
if (!empty($contestTypesPricingPackages)):

$i = 0;
foreach ($contestTypesPricingPackages as $contestTypesPricingPackage):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<li<?php echo $class;?>>
		<p><?php echo $this->Html->cInt($contestTypesPricingPackage['ContestTypesPricingPackage']['id']);?></p>
		<p><?php echo $this->Html->cDateTime($contestTypesPricingPackage['ContestTypesPricingPackage']['created']);?></p>
		<p><?php echo $this->Html->cDateTime($contestTypesPricingPackage['ContestTypesPricingPackage']['modified']);?></p>
		<p><?php echo $this->Html->link($this->Html->cText($contestTypesPricingPackage['ContestType']['name']), array('controller'=> 'contest_types', 'action' => 'view', $contestTypesPricingPackage['ContestType']['id']), array('escape' => false));?></p>
		<p><?php echo $this->Html->link($this->Html->cText($contestTypesPricingPackage['PricingPackage']['name']), array('controller'=> 'pricing_packages', 'action' => 'view', $contestTypesPricingPackage['PricingPackage']['id']), array('escape' => false));?></p>
		<p><?php echo $this->Html->cCurrency($contestTypesPricingPackage['ContestTypesPricingPackage']['price']);?></p>
		<div class="actions"><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $contestTypesPricingPackage['ContestTypesPricingPackage']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $this->Html->link(__l('Delete'), array('action'=>'delete', $contestTypesPricingPackage['ContestTypesPricingPackage']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></div>
	</li>
<?php
    endforeach;
else:
?>
	<li>
		<p class="notice"><?php echo sprintf(__l('No %s available'), __l('Contest Types Pricing Packages'));?></p>
	</li>
<?php
endif;
?>
</ol>

<?php
if (!empty($contestTypesPricingPackages)) {
    echo $this->element('paging_links');
}
?>
</div>
