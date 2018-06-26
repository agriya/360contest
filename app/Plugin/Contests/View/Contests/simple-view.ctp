<?php /* SVN: $Id: $ */ ?>
<div class="contests view">
	<div class="clearfix">
		<dl><?php $i = 0; $class = ' class="altrow"';?>		
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Enddate');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cDateTime($contest['Contest']['actual_end_date']);?></dd>		
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('User');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($contest['User']['username']);?></dd>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Contest Type');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($contest['ContestType']['name']);?></dd>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Contest Status');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($contest['ContestStatus']['name']);?></dd>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Pricing Package');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($contest['PricingPackage']['name']);?></dd>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Prize');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['prize']);?></dd>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __l('Description');?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($contest['Contest']['description']);?></dd>	
				<?php if(!empty($submission['SubmissionField'])): ?>
				<?php foreach($submission['SubmissionField'] as $submissionField): ?>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo $this->Html->cText(Inflector::humanize($submissionField['form_field']));?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($submissionField['response']);?></dd>		
				<?php endforeach; ?>
				<?php endif; ?>
			</dl>
	</div>	
</div>