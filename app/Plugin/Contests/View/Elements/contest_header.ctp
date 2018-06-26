<?php if($this->Auth->sessionValid()): ?>
<li class="dropdown">
	  <a><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps'); ?></a>
       <div class="sub-menu-block">
	   					<div class="user-menu-left">
							<div class="menu-right">
                 <div class="menu-head">
                  <h3><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps'); ?></h3>
            	</div>
				</div></div>
           	<div class="clearfix">
					<div class="submenu-left">
					<div class="submenu-right">

				<?php if(!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'contest_users' && $this->request->params['action'] == 'view'){
					$grid_5='grid_12';
					$grid_4='grid_12';
				}	
				else{
					$grid_5='grid_5';
					$grid_4='grid_4';
				}
	?>
            	<div class="balance-menu-inner-block balance-menu-inner-block1 clearfix">
                	 <div class="clearfix menu-left menu-left-block">
                          <h3 class="grid_left "><?php echo __l('My Contests')?></h3>
                          <span class="grid_left"><?php echo __l('(Manage your contests)');?></span>
                     </div>
                      <ul class="sub-menu omega alpha clearfix">
                            <li><?php echo $this->Html->link(__l('My Contests'), array('controller' => 'contests', 'action' => 'index', 'type' => 'mycontest','filter_id'=>ConstContestStatus::Open, 'admin' => false), array('title' => __l('My Contests')));?></li>
							<?php if (isPluginEnabled('UserFavourites')) { ?>
                      			<li><?php echo $this->Html->link(sprintf(__l('Followed %s'), Configure::read('contest.participant_alt_name_plural_caps')), array('controller' => 'users', 'action' => 'index', 'type'=> 'favorites','admin' => false ), array('title' => sprintf(__l('Followed %s'), Configure::read('contest.participant_alt_name_plural_caps'))));?></li>
							<?php } ?>
                      	    <li><?php echo $this->Html->link(sprintf(__l('Top %s'), Configure::read('contest.participant_alt_name_plural_caps')), array('controller' => 'users','action' => 'index'), array('title' => sprintf(__l('Top %s'), Configure::read('contest.participant_alt_name_plural_caps')))); ?></li>
                    </ul>
                    <div class="clearfix">
                         <div class="cancel-block compose-button grid_right">
                                <?php echo $this->Html->link(__l('Post Your Contest'), array('controller' => 'contest_types', 'action' => 'index'), array('title'=>__l('Post Your Contest'))); ?>
                        </div>
                    </div>
                  </div>
				  </div>
				  </div>
           	    </div>
        	
            <div class="submenu-bl">
                <div class="submenu-br">
                    <div class="submenu-bc">
                    </div>
                </div>
            </div>
	  </div>
	</li>
	<li class="dropdown">
	 <a><?php echo Configure::read('contest.participant_alt_name_singular_caps'); ?></a>
      <div class="sub-menu-block">
	  			<div class="user-menu-left">
							<div class="menu-right">
                 <div class="menu-head">
                    <h3><?php echo Configure::read('contest.participant_alt_name_singular_caps'); ?></h3>
            	   </div>
				   </div></div>
        
				<div class="clearfix">
					<div class="submenu-left">
					<div class="submenu-right">
			
            		<div class="balance-menu-inner-block balance-menu-inner-block1 clearfix">
                	    <div class="clearfix menu-left menu-left-block">
                             <h3 class="grid_left"><?php echo __l('My Participations')?></h3>
                             <span class="grid_left"><?php echo __l('(Your participations in contests)');?></span>
                         </div>
                        <ul class="sub-menu clearfix">
                	    	<li><?php echo $this->Html->link(__l('Browse Contests'), array('controller' => 'contests', 'action' => 'browse', 'admin' => false), array('title' => __l('Browse Contests')));?></li>
                			<li><?php echo $this->Html->link(__l('My Entries & Won Contests'), array('controller' => 'contest_users', 'action' => 'index', 'type' => 'myparticipation','filter_id'=>ConstContestUserStatus::Active,'admin' => false), array('title' => __l('My Entries & Won Contests')));?></li>
                            <?php if($this->Auth->user('id')):?>
							<?php if (isPluginEnabled('ContestFollowers')) { ?>
    	                    <li><?php echo $this->Html->link(__l('Followed Contests'), array('controller' => 'contests','action' => 'index','type'=>'follower'), array('title' => __l('Followed Contests'))); ?></li>
							<?php } ?>
    	                    <?php endif;?>
                        </ul>
                   </div>
				   </div>
				   </div>
            	  </div>
            
            	<div class="submenu-bl">
                    <div class="submenu-br">
                        <div class="submenu-bc">
                        </div>
                    </div>
                </div>
	   </div>
	</li>
<?php endif; ?>