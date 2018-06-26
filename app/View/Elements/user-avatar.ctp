<div class="top-pattern sep-bot">
<div class="container">
			<span class="span no-mar pr z-top"><p class="thumbnail sep-bot"> <?php
				$balance = $this->Html->getCurrUserInfo($this->Auth->user('id')); 
				$current_user_details = array(
											'username' => $balance['User']['username'],
											'id' =>  $balance['User']['id'],
											);
				echo $this->Html->getUserAvatarLink($balance['User'], 'small_big_thumb');
				?> </p>
			</span>
			<div class="span5 pr z-top">
			<p class="text-20 ver-smspace"> <?php echo $this->Html->getUserLinkCustom($balance['User'], 'grayc');?></p>
			<p class="no-mar text-14"> <span><?php echo __l('Joined:') . ' ';?></span> <span class="textb"><?php echo $this->Html->cDateTimeHighlight($balance['User']['created']);?></span> </p>
			</div>

			<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
				<div class="container space pr">
					<div class="span row no-mar top-space pa dashboard-post">
						<div class="span5 row no-mar"> 
						
							<span class="label label-important span1 dc space no-mar"><i class="icon-money no-pad text-24 ver-smspace" ></i></span>
							<dl class="pull-left hor-smspace grayc">
							  <dt class="textn"><?php echo __l('Avaliable balance');?></dt>
							  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->siteCurrencyFormat($balance['User']['available_wallet_amount']);?></dd>
							</dl>
						</div>
						<div class="span5 row no-mar"> 
							<span class="label label-important span1 dc space no-mar"><i class="icon-bookmark no-pad text-24 whitec"></i></span>
							<dl class="pull-left hor-smspace grayc">
							  <dt class="textn"><?php echo __l('Contest Posted');?></dt>
							  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($balance['User']['contest_count']);?></dd>
							</dl>
						</div>
						<div class="span5 row no-mar"> 
							<span class="label label-important span1 dc space no-mar"><i class="icon-reorder no-pad text-24 whitec"></i></span>
							<dl class="pull-left hor-smspace grayc">
							  <dt class="textn"><?php echo __l('Entry Posted');?></dt>
							  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($balance['User']['contest_user_count']);?></dd>
							</dl>
						</div>
						<div class="span5 row no-mar"> 
							<span class="label label-important span1 dc space no-mar"><i class="icon-ok no-pad text-24 whitec"></i></span>
							<dl class="pull-left hor-smspace grayc">
							  <dt class="textn"><?php echo __l('Following Contest');?></dt>
							  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($balance['User']['contest_follower_count']);?></dd>
							</dl>
						</div>
					</div>
				</div>
		</div>
</div>
<div class="clearfix top-space container">
  		<article class="view-block">
		  <div class="tabbable tab-container" id="ajax-tab-dashboard">
			<ul class="nav nav-tabs row top-space tabs">
			    <?php
			      $active_class = ($this->request->params['controller'] == 'contests' && $this->request->params['action'] == 'user_dashboard') ? ' active' : '';
			    ?>
			   <li class="tab <?php echo $active_class; ?>"> <?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard', 'from' => 'tab'),array('class'=>'text-16 textb grayc','title' => __l('Dashboard')));?> </li>			   
			   	<?php
			      $active_class = ($this->request->params['controller'] == 'contests' && $this->request->params['action'] == 'index') ? ' active' : '';
			    ?>
			  <li class="tab <?php echo $active_class; ?>">
			  <?php echo $this->Html->link(__l('My Contests'), array('controller' => 'contests', 'action' => 'index', 'type'=>'mycontest', 'filter_id'=>ConstContestStatus::Open, 'admin' => false),array('title' => __l('My Contests'), 'class' => 'text-16 textb grayc', 'escape' => false));?>
			  </li>
			  <?php
			      $active_class = ($this->request->params['controller'] == 'contest_users' && $this->request->params['action'] == 'index') ? ' active' : '';
			    ?>
			  <li class="tab <?php echo $active_class; ?>">
			  <?php echo $this->Html->link(__l('My Participations'), array('controller' => 'contest_users', 'action' => 'index', 'type'=>'myparticipation', 'filter_id'=>ConstContestUserStatus::Active, 'admin' => false),array('title' => __l('My Participations'), 'class' => 'text-16 textb grayc', 'escape' => false));?>
			  </li>
			  <?php
			      $active_class = ($this->request->params['controller'] == 'transactions' && $this->request->params['action'] == 'index') ? ' active' : '';
			    ?>
	          <li class="tab <?php echo $active_class; ?>">
			  <?php echo $this->Html->link(__l('Transactions'), array('controller' => 'transactions', 'action' => 'index'),array('title' => __l('Transactions'), 'class' => 'text-16 textb grayc', 'escape' => false));?>
			  </li>
		      <?php if (isPluginEnabled('Affiliates')): ?>
			  <?php
			      $active_class = (($this->request->params['controller'] == 'affiliates' || $this->request->params['controller'] == 'affiliate_cash_withdrawals') && $this->request->params['action'] == 'index') ? ' active' : '';
			  ?>
		      <li class="tab <?php echo $active_class; ?>">
			  <?php echo $this->Html->link(__l('Affiliates'), array('controller' => 'affiliates', 'action' => 'index'),array('title' => __l('Affiliates'), 'class' => 'text-16 textb grayc', 'escape' => false));?>
		      <?php endif; ?>
			</ul>
		  </div>
		</article>
</div>