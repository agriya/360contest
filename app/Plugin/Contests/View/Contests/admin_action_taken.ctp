<section class="thumbnail no-pad top-mspace sep">
            <div class="no-mar no-bor clearfix box-head space sep-bot">
              <h5 class="pull-left"><i class="icon-user pinkc no-bg"></i> <?php echo __l('Actions to Be Taken'); ?></h5>
            </div>
            <section>
              <?php if(Configure::read('user.is_admin_activate_after_register')):?>
									<h6 class="space"><?php echo __l('Users');?></h6>
									<ul class="unstyled hor-space">
                <li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('Pending For Approval') . ' (' . $pending_for_approval_user_count. ')', array('controller'=> 'users', 'action' => 'index', 'filter_id' =>ConstMoreAction::Inactive, 'admin' => true),array('title'=>__l('Pending For Approval')));?></li>
									</ul>
							<?php endif; ?>
									<h6 class="hor-smspace"><?php echo __l('Contests');?></h6>
									<ul class="unstyled hor-space">
                <li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('Pending For Approval') . ' (' . $pending_for_approval_count. ')', array('controller'=> 'contests', 'action' => 'index', 'filter_id' =>ConstContestStatus::PendingApproval, 'admin' => true),array('title'=>__l('Pending For Approval')));?></li>
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('Pending Action to Admin') . ' (' . $pending_action_to_admin_count. ')', array('controller'=> 'contests', 'action' => 'index', 'is_pending_action_to_admin' => 1, 'admin' => true),array('title'=>__l('Pending Action to Admin')));?></li>
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('Request for Cancellation') . ' (' . $refund_request_count. ')', array('controller'=> 'contests', 'action' => 'index', 'filter_id' => ConstContestStatus::RefundRequest, 'admin' => true),array('title'=>__l('Request for Cancellation')));?></li>
									</ul>
							<?php if (isPluginEnabled('Wallet') && isPluginEnabled('Withdrawals')) { ?>
									<h6 class="hor-smspace"><?php echo __l('Withdraw Requests');?></h6>
									<ul class="unstyled hor-space">
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('Pending') . ' (' . $pending_withdraw_count. ')', array('controller'=> 'user_cash_withdrawals', 'action' => 'index', 'filter_id' =>ConstWithdrawalStatus::Pending, 'admin' => true),array('title'=>__l('Pending')));?></li>
									</ul>
							<?php } ?>
							<?php if (isPluginEnabled('ContestFlags')) { ?>
									<h6 class="hor-smspace"><?php echo __l('Flagged Contests');?></h6>
									<ul class="unstyled hor-space">
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('User') . ' (' . $contest_user_flagged_count. ')', array('controller'=> 'contests', 'action' => 'index', 'type' =>'user-flag','admin' => true),array('title'=>__l('User')));?></li>
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('System') . ' (' . $contest_system_flagged_count. ')', array('controller'=> 'contests', 'action' => 'index', 'type' =>'flagged', 'admin' => true),array('title'=>__l('System')));?></li>
									</ul>
							<?php } ?>
							<?php if (isPluginEnabled('EntryFlags')) { ?>
									<h6 class="hor-smspace"><?php echo __l('Flagged Entries');?></h6>
									<ul class="unstyled hor-space bot-mspace">
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('User') . ' (' . $contestuser_user_flagged_count. ')', array('controller'=> 'contest_users', 'action' => 'index', 'type' =>'user-flag',  'admin' => true),array('title'=>__l('User')));?></li>
										<li><i class="icon-angle-right blackc"></i><?php echo $this->Html->link(__l('System') . ' (' . $contestuser_system_flagged_count. ')', array('controller'=> 'contest_users', 'action' => 'index', 'type' =>'flagged', 'admin' => true),array('title'=>__l('System')));?></li>
									</ul>
							<?php } ?>
								</section>
          </section>

