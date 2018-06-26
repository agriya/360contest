<div class="container top-space">
  <h2><?php echo __l('Contests');?></h2>
  <div class="tabbable tab-container"  id="ajax-tab-container-contest">
    <ul class="nav nav-tabs row top-space tabs">
	  <li class="tab textb grayc first-child"><em>&nbsp;</em><?php echo $this->Html->link(__l('Open'), array('controller' => 'contests', 'action' => 'index','status'=>'open', 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('Open'), 'data-toggle' => 'tab', 'data-target'=> '#Open'));?></li>
	  <li class="tab textb grayc"><em>&nbsp;</em><?php echo $this->Html->link(__l('Inprocess'), array('controller' => 'contests', 'action' => 'index','status'=>'inprocess', 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('Inprocess'), 'data-toggle' => 'tab', 'data-target'=> '#Inprocess'));?></li>
	  <li class="tab textb grayc"><em>&nbsp;</em><?php echo $this->Html->link(__l('Closed'), array('controller' => 'contests', 'action' => 'index','status'=>'closed', 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('Closed'), 'data-toggle' => 'tab', 'data-target'=> '#Closed'));?></li>
	  <li class="tab textb grayc"><em>&nbsp;</em><?php echo $this->Html->link(__l('All'), array('controller' => 'contests', 'action' => 'index','status'=>'all', 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('All'), 'data-toggle' => 'tab', 'data-target'=> '#All'));?></li>
	</ul>
	<div class="tab-content panel-container">
		<div id="Open" class="tab-pane in active"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
			<span class="loading grayc">Loading....</span></div></div>
		<div id="Inprocess" class="hide"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?>
			<span class="loading grayc">Loading....</span></div></div>
		<div id="Closed" class="hide"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
			<span class="loading grayc">Loading....</span></div></div>
		<div id="All" class="hide"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
			<span class="loading grayc">Loading....</span></div></div>
	</div>
  </div>
</div>
