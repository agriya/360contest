<?php /* SVN: $Id: $ */ ?>
<div class="contestTypesPricingPackages view">
<h2><?php echo __l('Contest Types Pricing Package');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Id');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cInt($contestTypesPricingPackage['ContestTypesPricingPackage']['id']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Created');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($contestTypesPricingPackage['ContestTypesPricingPackage']['created']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Modified');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($contestTypesPricingPackage['ContestTypesPricingPackage']['modified']);?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Contest Type');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($this->Html->cText($contestTypesPricingPackage['ContestType']['name']), array('controller' => 'contest_types', 'action' => 'view', $contestTypesPricingPackage['ContestType']['id']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Pricing Package');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->link($this->Html->cText($contestTypesPricingPackage['PricingPackage']['name']), array('controller' => 'pricing_packages', 'action' => 'view', $contestTypesPricingPackage['PricingPackage']['id']), array('escape' => false));?></dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Price');?></dt>
			<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cCurrency($contestTypesPricingPackage['ContestTypesPricingPackage']['price']);?></dd>
	</dl>
</div>