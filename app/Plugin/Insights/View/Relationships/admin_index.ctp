<?php /* SVN: $Id: $ */ ?>
<div class="userRelationships index">
  <section class="page-header no-mar ver-space mspace">
    <div class="top-pattern-contest  container-fluid space">
	  <ul class="row no-mar mob-c unstyled top-mspace">
	  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Active) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar" title="<?php echo __l('Active');?>">
		<?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-ok-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Active').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($approved,false).'</span>', array('controller'=>'relationships','action'=>'index','filter_id' => ConstMoreAction::Active), array('class' => 'blackc', 'escape' => false));?></li>
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar" title="<?php echo __l('Inactive');?>">
		<?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-ban-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Inactive').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pending,false).'</span>', array('controller'=>'relationships','action'=>'index','filter_id' => ConstMoreAction::Inactive), array('class' => 'blackc', 'escape' => false));?></li>    
		<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
	    <li class="span dc no-mar" title="<?php echo __l('All');?>">
	    <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('All').'</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pending + $approved,false).'</span>', array('controller'=>'relationships','action'=>'index'), array('class' => 'blackc', 'escape' => false));?></li>
      </ul>
	</div>
  </section>
  <ul class="nav nav-tabs mspace top-space">
    <li class="active"><a class="blackc" href="#"><i class="icon-th-list blackc"></i><?php echo __l('List'); ?></a></li>
    <li><?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add'), array('action' => 'add'),array('class' => 'blackc', 'title' =>  __l('Add'), 'escape' => false));?></li>
  </ul>
  <section class="space clearfix">
    <div class="pull-left hor-space"><?php echo $this->element('paging_counter');?></div>
  </section>
  <?php
    echo $this->Form->create('Relationship' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax'));
    echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url));
  ?>
  <section class="space">
    <table class="table table-striped table-bordered table-condensed table-hover">
      <thead>
        <tr>
          <th class="select span1 dc"><?php echo __l('Select'); ?></th>
          <th class="dc"><?php echo __l('Actions');?></th>
          <th class="dl"><div><?php echo $this->Paginator->sort('relationship', __l('Relationship'));?> </div></th>
        </tr>
      </thead>
      <tbody>
    <?php
    if (!empty($userRelationships)):
    foreach ($userRelationships as $userRelationship):
      if($userRelationship['Relationship']['is_active']):
        $status_class = 'js-checkbox-active';
        $disabled = '';
      else:
        $status_class = 'js-checkbox-inactive';
        $disabled = 'class="disabled"';
      endif;
    ?>
      <tr <?php echo $disabled; ?>>
        <td  class="select dc">
          <?php echo $this->Form->input('Relationship.'.$userRelationship['Relationship']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userRelationship['Relationship']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
        </td>
        <td class="span1 dc">
          <div class="dropdown top-space">
            <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog greenc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
            <ul class="unstyled dropdown-menu dl arrow clearfix">
              <li><?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array( 'action'=>'edit', $userRelationship['Relationship']['id']), array('class' => '','escape'=>false, 'title' => __l('Edit')));?></li>
              <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete',$userRelationship['Relationship']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm ', 'escape'=>false,'title' => __l('Delete')));?></li>
              <?php echo $this->Layout->adminRowActions($userRelationship['Relationship']['id']);  ?>
            </ul>
          </div>
        </td>
        <td><?php echo $this->Html->cText($userRelationship['Relationship']['relationship']);?></td>
      </tr>
    <?php
      endforeach;
    else:
    ?>
      <tr>
        <td colspan="6" class="notice space"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Relationships'));?></td>
      </tr>
    <?php
    endif;
    ?>
      </tbody>
    </table>
  </section>
  <section class="clearfix hor-mspace bot-space">
    <?php if (!empty($userRelationships)): ?>
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
        <?php echo $this->Form->end();  ?>
      </div>
      <div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
    <?php endif; ?>
  </section>
</div>
