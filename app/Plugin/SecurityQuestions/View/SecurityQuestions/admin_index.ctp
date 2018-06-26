<section class="page-header no-mar ver-space mspace">
<ul class="filter-list-block unstyled row-fluid">
  <li class="pull-left dc hor-space">
  <?php echo $this->Html->link('<span class="show blackc"><span class="text-16 textb">'.$this->Html->cInt($approved,false).'</span></span><span class="label label-success">' .__l('Active'). '</span>', array('action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'pull-left no-under', 'escape' => false));?>
  </li>
  <li class="pull-left dc hor-space">
  <?php echo $this->Html->link('<span class="show blackc"><span class="text-16 textb">'.$this->Html->cInt($pending,false).'</span></span><span class="label label-important">' .__l('Inactive'). '</span>', array('action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'pull-left no-under', 'escape' => false));?>
  </li>
  <li class="pull-left dc hor-space"><?php echo $this->Html->link('<span class="show blackc"><span class="text-16 textb">'.$this->Html->cInt($pending + $approved,false).'</span></span><span class="label">' .__l('All'). '</span>', array('controller'=>'security_questions','action'=>'index'), array('class' => 'pull-left no-under', 'escape' => false));?></li>
 </ul>
</section>
<ul class="nav nav-tabs mspace top-space">
  <li class="active"><a class="blackc" href="#"><i class="icon-th-list blackc"></i><?php echo __l('List'); ?></a></li>
  <li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add'), array('action' => 'add'), array('class' => 'blackc', 'title' =>  __l('Add'), 'escape' => false));?></li>
</ul>
<section class="space clearfix">
    <div class="pull-left hor-space"><?php echo $this->element('paging_counter');?></div>
</section>
<?php echo $this->Form->create('SecurityQuestion', array('action' => 'update', 'method' => 'post')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section class="space">
  <table class="table table-striped table-bordered table-condensed table-hover no-mar">
    <tr>
      <th class="select span1 dc"><div><?php echo __l('Select'); ?></div> </th>
      <th class="dc"><div><?php echo __l('Actions'); ?></div> </th>
      <th class="dc"><div><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
      <th class="d1"><div><?php echo $this->Paginator->sort('name', __l('Question'));?></th>
    </tr>
    <?php foreach ($questions as $question): ?>
      <?php
		if($question['SecurityQuestion']['is_active'] == '1')  :
        $status_class = 'js-checkbox-active';
		$disabled = '';
		else:
          $status_class = 'js-checkbox-inactive';
          $disabled = 'class="disabled"';
          endif;
      ?>
      <tr <?php echo $disabled; ?>>
        <td class="select dc"><?php echo $this->Form->input('SecurityQuestion.'. $question['SecurityQuestion']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$question['SecurityQuestion']['id'], 'label' => false,  'class' => $status_class.' js-checkbox-list')); ?></td>
        <td class="span1 dc">
          <div class="dropdown top-space">
            <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
            <ul class="unstyled dropdown-menu dl arrow clearfix">
              <li><?php echo $this->Html->link('<i class="icon-edit"></i>' . __l('Edit'), array('action' => 'edit', $question['SecurityQuestion']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?></li>
              <?php echo $this->Layout->adminRowActions($question['SecurityQuestion']['id']);  ?>
            </ul>
          </div>
        </td>
        <td class="dc"><?php echo $this->Html->cDateTimeHighlight($question['SecurityQuestion']['created']);?></td>
        <td><?php echo $question['SecurityQuestion']['name']; ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</section>
<section class="clearfix hor-mspace bot-space">
  <?php if (!empty($questions)) : ?>
    <div class="admin-select-block pull-left">
      <?php echo __l('Select:'); ?>
      <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}', 'title' => __l('All'))); ?>
      <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}', 'title' => __l('None'))); ?>
      <?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}', 'title' => __l('Active'))); ?>
      <?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}', 'title' => __l('Inactive'))); ?>
    </div>
    <div class="admin-checkbox-button pull-left hor-space">
      <div class="input select">
        <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
      </div>
    </div>
    <div class="hide">
      <?php echo $this->Form->submit('Submit');  ?>
    </div>
    <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
  <?php endif; ?>
</section>
<?php echo $this->Form->end(); ?>