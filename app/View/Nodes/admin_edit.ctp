<div class="space">
<div class="nodes form thumbnail "> <?php echo $this->Form->create('Node', array('url' => array('controller' => 'nodes', 'action' => 'edit', $this->request->data['Node']['id'], 'admin' => true),'class' => 'form-horizontal form-large-fields'));?>
  <fieldset>
  <div class="panel-container">
    <div id="add_form" class="tab-pane fade in active">
      <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a data-toggle="tab" href="#node-main"><span><?php echo __l($type['Type']['title']); ?></span></a></li>
<?php if (count($taxonomy) > 0) { ?>
      <li><a data-toggle="tab" href="#node-terms"><span><?php echo __l('Terms'); ?></span></a></li>
<?php } ?>
<?php if ($type['Type']['comment_status'] != 0) { ?>
      <li><a data-toggle="tab" href="#node-comments"><span><?php echo __l('Comments'); ?></span></a></li>
<?php } ?>
      <li><a data-toggle="tab" href="#node-meta"><span><?php echo __l('SEO'); ?></span></a></li>
      <li><a data-toggle="tab" href="#node-publishing"><span><?php echo __l('Publishing'); ?></span></a></li>
<?php echo $this->Layout->adminTabs(); ?>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div id="node-main" class="tab-pane fade in active">
<?php
	echo $this->Form->input('id');
	echo $this->Form->input('parent_id', array('type' => 'select', 'options' => $nodes, 'empty' => __l('Please Select')));
	echo $this->Form->input('title');
	echo $this->Form->input('slug', array('class' => 'slug'));
	echo $this->Form->input('excerpt');?>
	<div class="required clearfix">
                <label class="pull-left" for="NodeBody"><?php echo __l('Body');?></label>
                <div class="input textarea span17 space">
                  <?php echo $this->Form->input('body', array('class' => 'pull-left', 'label' => false, 'div' => false)); ?>
                </div>
              </div>
    </div>
<?php if (count($taxonomy) > 0) { ?>
    <div id="node-terms" class="tab-pane fade">
<?php
	$taxonomyIds = Set::extract('/Taxonomy/id', $this->data);
	foreach ($taxonomy AS $vocabularyId => $taxonomyTree) {
		echo $this->Form->input('TaxonomyData.'.$vocabularyId, array(
			'label' => $vocabularies[$vocabularyId]['title'],
			'type' => 'select',
			'multiple' => true,
			'options' => $taxonomyTree,
			'value' => $taxonomyIds,
		));
	}
?>
    </div>
<?php } ?>
    <div id="node-meta" class="tab-pane fade"> <?php echo $this->Form->input('meta_keywords', array('label' => __l('Meta Keywords'), 'type' => 'text')); ?> <?php echo $this->Form->input('meta_description', array('label' => __l('Meta Description'), 'type' => 'textarea')); ?> </div>
    <div id="node-publishing" class="tab-pane fade"> <?php echo $this->Form->input('status', array('label' => __l('Published'))); ?>
     <div class="input clearfix hor-mspace end-date-time-block">
	 <div class="js-boostarp-datetime">
          	<div class="js-cake-date">
					<?php echo $this->Form->input('created', array('label' => __l('Created'),'empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
          	</div>
	</div>

	  </div>
    </div>
<?php echo $this->Layout->adminTabs(); ?>
    <div class="submit-block clearfix offset4">
<?php
		echo $this->Form->submit(__l('Apply'), array('name' => 'apply','div'=>false));
	echo $this->Form->submit(__l('Save'), array('name' => 'save','div'=>false));
?><?php echo $this->Html->link(__l('Cancel') , array('controller' => 'nodes', 'action' => 'index'),array('class' => 'btn hor-smspace'));?>
</div>
    </div>
	</div>
  </div>
  </fieldset>
<?php echo $this->Form->end(); ?>
  </div>
</div>