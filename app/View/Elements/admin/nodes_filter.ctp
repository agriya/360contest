<div class="top-pattern  sep-bot">
  <ul class="row no-mar mob-c unstyled top-mspace">
    <li class="span2 hor-mspace"><b><?php echo 'Type:'; ?></b></li>
	<?php $class = (!empty($this->request->params['named']['content_filter_id']) &&  empty($this->request->params['named']['filter_id']) && $this->request->params['named']['content_filter_id'] == constContentType::Page) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['content_filter_id']) &&  empty($this->request->params['named']['filter_id']) && $this->request->params['named']['content_filter_id'] == constContentType::Page) ? 'pinkc' : 'blackc'; ?>
    <li class="pull-left dc bot-mspace">
	<?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-book no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Page') . '</span></div>', array('controller' => 'nodes', 'action' => 'index', 'content_filter_id' => constContentType::Page), array('title' => __l('Page'),'escape' => false)); ?><span class="no-mar text-32 textb space span "><?php echo $this->Html->link($this->Html->cInt($content_type, false), array('controller' => 'nodes', 'action' => 'index', 'content_filter_id' => constContentType::Page), array('class'=>$count_class));?></span> 
	</li>
  </ul>
  <ul class="row no-mar mob-c unstyled top-mspace">
    <li class="span2"><b><?php echo 'Status:'; ?></b></li>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Publish) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Publish) ? 'pinkc' : 'blackc'; ?>
    <li class="pull-left dc hor-space">
	  <?php echo $this->Html->link('<div class="span no-mar"> <span class="label label-important show dc space no-mar"><i class="icon-eye-open no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Publish') . '</span></div>', array('controller' => 'nodes', 'action' => 'index', 'content_filter_id' => !empty($this->request->params['named']['content_filter_id'])?$this->request->params['named']['content_filter_id']:'', 'filter_id' => ConstMoreAction::Publish), array('title' => __l('Publish'),'escape' => false)); ?><span class="no-mar text-32 textb space span "><?php echo $this->Html->link($this->Html->cInt($publish, false), array('controller' => 'nodes', 'action' => 'index', 'content_filter_id' => ConstMoreAction::Publish), array('class'=>$count_class));?></span>
    </li>
	<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Unpublish) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Unpublish) ? 'pinkc' : 'blackc'; ?>
    <li class="pull-left dc hor-space">
		<?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-eye-close no-pad text-24 whitec"></i></span> <span class="show  '.$class.' ">' . __l('Unpublish') . '</span></div>', array('controller' => 'nodes', 'action' => 'index', 'content_filter_id' => !empty($this->request->params['named']['content_filter_id'])?$this->request->params['named']['content_filter_id']:'', 'filter_id' => ConstMoreAction::Unpublish), array('title' => __l('Unpublish'),'escape' => false)); ?><span class="no-mar text-32 textb space span "><?php echo $this->Html->link($this->Html->cInt($unpublish, false), array('controller' => 'nodes', 'action' => 'index', 'content_filter_id' => ConstMoreAction::Unpublish), array('class'=>$count_class));?></span>
    </li>
  </ul>
</div>
  <div class="row space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('Node' , array('url' => Router::url('/', true) . $this->request->url, 'class' => 'form-search no-mar')); ?>
        <?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'search-query mob-clr')); ?>
        <div class="hide">
      <?php echo $this->Form->submit(__l('Search'));?>
    </div>
        <?php echo $this->Form->end(); ?>
      </div>
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Create Content') . '</span>', array('controller' => 'nodes', 'action' => 'add', 'page'), array('class' => 'add pinkc','title'=>__l('Create Content'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>