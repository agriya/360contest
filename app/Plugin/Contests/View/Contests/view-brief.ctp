<div class="clearfix contest-view-block">
         	<?php
                if(!empty($submission['SubmissionField'])): ?>
				<dl class="contest-view-list"><?php $i = 0; $class = ' class="altrow"';?>
				<?php foreach($submission['SubmissionField'] as $submissionField): ?>
				<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo $this->Html->cText(Inflector::humanize($submissionField['form_field']));?></dt>
					<dd<?php if ($i++ % 2 == 0) echo $class;?>><?php echo $this->Html->cText($submissionField['response']);?></dd>
				<?php endforeach; ?>
				</dl>
				<?php endif; ?>

	</div>