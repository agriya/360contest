<div class="container-fluid thumbnail hor-space  dc">
	<div class="row ver-smspace">
	  <h1 class="pull-left ver-smspace text-16"> <?php echo $this->Html->link(('<span>'.Configure::read('site.name') . ' <small class="blackc text-14 textb"> Admin</small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false, 'class' => 'brand blackc text-16 fextb js-no-pjax', 'title' => (Configure::read('site.name').' '.'Admin')));?></h1>
	  <div class="pull-right ver-smspace mob-clr">
		<ul class="unstyled span no-mar">
			<?php
			$class = 'hide';
			if((($this->request->params['controller']=='users')&&($this->request->params['action']=='admin_stats'))||(($this->request->params['controller']=='google_analytics')&&($this->request->params['action']=='admin_analytics_chart'))) { $class = ''; }?>
			<li class="span js-live-tour-link <?php echo $class; ?>"><a href="#" class="bootstro-goto bootstro js-no-pjax" data-bootstro-step="0" data-bootstro-title="Live Tour"data-bootstro-content="Look out for a Live Tour link in the top of page for live demo of product" data-bootstro-placement="bottom" escape="false"><?php echo __l('Live Tour'); ?></a></li>
			<li class="span pull-left"> <?php echo $this->Html->link(__l('View Site'), Router::url('/', true),array('title' => __l('Visit website'), 'escape' => false, 'class' => "blackc")); ?></li>
			<?php $class = (($this->request->params['controller'] == 'nodes') && ($this->request->params['action'] == 'admin_tools')) ? 'view-site' : null;?>
			<li class="span pull-left">
			<?php  echo $this->Html->link(__l('Tools'), array('controller' => 'nodes', 'action' => 'tools', 'admin' => true),array('class' => 'bootstro','data-bootstro-step'=>'11' ,'data-bootstro-title'=>'Tools' , 'data-bootstro-content'=>__l("For manually trigger the corn to update the contest status, also to update daily status."), 'data-bootstro-placement'=>'bottom', 'escape'=>false));?>
			</li>
			<?php $class = (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'admin_diagnostics')) ? 'view-site' : null;?>
			<li class="span pull-left">
			<?php  echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true),array('title' => __l('Diagnostics')));?>
			</li>
			<?php $class = (($this->request->params['controller'] == 'user_profiles') && ($this->request->params['action'] == 'edit')) ? 'view-site' : null;?>
			<li class="span pull-left">
			<?php  echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id'), 'admin' => true), array('title' => __l('My Account')));?>
			</li>
			<?php $class = (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'change_password')) ? 'view-site' : null;?>
			<li class="span pull-left">
			<?php  echo $this->Html->link(__l('Change Password'), array('controller' => 'users', 'action' => 'change_password', 'admin' => true),array('title' => __l('Change Password')));?>
			</li>
			<?php $class = (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'logout')) ? 'view-site' : null;?>
			<li class="span pull-left"> <?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'),array('class' => 'js-no-pjax', 'title' => __l('Logout')));?></li>
		</ul>
	  </div>
	</div>
</div>