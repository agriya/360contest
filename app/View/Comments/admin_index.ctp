<div class="comments index">
  <div class="clearfix">
    <ul class="filter-list-block clearfix">
<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Publish) ? 'active-filter' : null; ?>
      <li class="green <?php echo $class; ?>"><?php echo $this->Html->link($this->Html->cInt($publish, false). '<span>' . __l('Publish') . '</span>', array('controller' => 'comments', 'action' => 'index', 'filter_id' => ConstMoreAction::Publish), array('title' => __l('Publish'),'escape' => false)); ?></li>
<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Unpublish) ? 'active-filter' : null; ?>
      <li class="green <?php echo $class; ?>"><?php echo $this->Html->link($this->Html->cInt($unpublish, false). '<span>' . __l('Unpublish') . '</span>', array('controller' => 'comments', 'action' => 'index', 'filter_id' => ConstMoreAction::Unpublish), array('title' => __l('Unpublish'),'escape' => false)); ?></li>
<?php $class = (empty($this->request->params['named']['filter_id']) && empty($this->request->params['named']['main_filter_id'])) ? 'active-filter' : null; ?>
      <li class="black <?php echo $class; ?>"><?php echo $this->Html->link($this->Html->cInt($publish + $unpublish, false). '<span>' . __l('Total') . '</span>', array('controller' => 'comments', 'action' => 'index'), array('title' => __l('Total'),'escape' => false)); ?></li>
    </ul>
  </div>
  <div class="clearfix">
    <div class="grid_left"> <?php echo $this->element('paging_counter');?> </div>
  </div>
<?php echo $this->Form->create('Comment', array('class' => 'normal', 'url' => array('controller' => 'comments', 'action' => 'update'))); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <table class="list">
    <tr>
      <th><?php echo __l('Select'); ?></th>
      <th class="actions"><?php echo __l('Actions'); ?></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('email', __l('Email')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('Node.title', __l('Node')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('comment', __l('Comment')); ?></div></th>
      <th><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted On')); ?></div></th>
    </tr>
<?php
	if (!empty($comments)):
		$i = 0;
		foreach ($comments AS $comment) {
		$i=0;
		if ($i++ % 2 == 0):
		$class = "altrow";
	endif;
?>
    <tr class="<?php echo $class;?>">
      <td class="select"><?php echo $this->Form->input('Comment.' . $comment['Comment']['id'] . '.id', array('type' => 'checkbox', 'id' => "admin_checkbox_" . $comment['Comment']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
      <td  class="actions"><div class="action-block"> <span class="action-information-block"> <span class="action-left-block">&nbsp; </span> <span class="action-center-block"> <span class="action-info"> <?php echo __l('Action');?> </span> </span> </span>
          <div class="action-inner-block">
            <div class="action-inner-left-block">
              <ul class="action-link clearfix">
                <li><?php echo $this->Html->link(__l('Edit'), array('controller' => 'comments', 'action' => 'edit', $comment['Comment']['id']), array('class' => 'edit', 'title' => __l('Edit')));?></li>
                <li><?php echo $this->Html->link(__l('Delete'), array('controller' => 'comments', 'action' => 'delete', $comment['Comment']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></li>
              </ul>
            </div>
            <div class="action-bottom-block"></div>
          </div>
        </div></td>
      <td><?php echo $this->Html->cText($comment['Comment']['name']);?></td>
      <td><?php echo $this->Html->cText($comment['Comment']['email']);?></td>
      <td><?php echo $this->Html->link($comment['Node']['title'], array('admin' => false, 'controller' => 'nodes', 'action' => 'view', 'type' => $comment['Node']['type'], 'slug' => $comment['Node']['slug']));?></td>
      <td><?php echo $this->Html->cText($comment['Comment']['body']);?></td>
      <td><?php echo $this->Html->cDateTimeHighlight($comment['Comment']['created']);?></td>
    </tr>
<?php
		}
	else:
?>
    <tr>
      <td colspan="5" class="notice"><?php echo sprintf(__l('No %s available'), __l('comments'));?></td>
    </tr>
<?php
	endif;
?>
  </table>
  <div class="clearfix">
    <div class="grid_left admin-select-block">
      <div class="js-pagination"> <?php echo __l('Select:'); ?> <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?> <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?> </div>
      <div class="admin-checkbox-button"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?></div>
    </div>
    <div class="js-pagination grid_right"> <?php echo $this->element('paging_links'); ?> </div>
  </div>
  <div class="hide"> <?php echo $this->Form->submit('Submit'); ?> </div>
<?php echo $this->Form->end(); ?> 
  </div>
