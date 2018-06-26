<?php
	$url= array(
		'controller' => 'contests',
		'action' => 'index',
	);
	if (empty($this->request->params['named']['is_admin'])) {
		$url['type'] = 'mycontest';
	}
	else{
		$url['admin'] = true;
	}
?>
	<div class="clearfix flow-chart">
       <ul class="flow-chart pull-left clearfix unstyled">
        <li class="payment-f">
                <div class="clearfix">
                <span class="payment-left">
                   <?php
                     $url['filter_id'] = ConstContestStatus::PaymentPending;
    				 $key= ConstContestStatus::PaymentPending -1;
                     echo $this->Html->link(sprintf("%s", __l('Payment Pending').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'paument-pending','title' => __l('Payment Pending')));
                     $payment_pending_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                    ?>
                    </span>
					<span class="info chart-info js-tooltip" title="<?php echo sprintf(__l('If %s doesn\'t pay in %s days contest will be deleted.'), Configure::read('contest.contest_holder_alt_name_singular_caps'), Configure::read('contest.contest_payment_pending_days_limit'));?>"><i class="icon-info-sign"></i></span>
                    </div>

                <ul class="pending clearfix unstyled">
                    <li class="pending-f">
                      <div class="clearfix">
                        <span class="pending-approval">
                    	<?php
					       $url['filter_id'] = ConstContestStatus::PendingApproval;
					       $key= ConstContestStatus::PendingApproval -1;
					       echo $this->Html->link(sprintf("%s", __l('Pending Approval').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'pending-approval','title' => __l('Pending Approval')));
					       $pending_approval_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
				        ?>
				        </span>
				        </div>
				        <ul class="rejected clerafix unstyled">
                            <li class="rejected-f">
								<div class="clearfix">
									<span class="rejected-1">
									   <?php
										$url['filter_id'] = ConstContestStatus::Rejected;
										$key= ConstContestStatus::Rejected -1;
										echo $this->Html->link(sprintf("%s", __l('Rejected').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => '','title' => __l('Rejected')));
										$rejected_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
										?>
									</span>
									<span data-placement="bottom" class="info chart-info js-tooltip" title="<?php echo __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.');?>"><i class="icon-info-sign"></i></span>
								</div>
                            </li>
				        </ul>
				        <ul class="open clearfix unstyled">
                            <li>
                                <div class="clearfix open-f">
                                <span class="open-f">
                                <?php
                					$url['filter_id'] = ConstContestStatus::Open;
                					$key= ConstContestStatus::Open -1;
                					echo $this->Html->link(sprintf("%s", __l('Open').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'open','title' => __l('Open')));
                					$open_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                				?>
                				</span>
                                </div>
								<?php 
								$refund_request_count = 0;
								$cancel_byadmin_count = 0;
								$judging_class = "";
								if(Configure::read('contest.enable_request_for_cancellation')){
								$judging_class = "judging-request";?>
                                <div class="request-refund-block">
                				<ul class="request-refund clearfix unstyled">
                				  <li class="refund-l request-refund-f clearfix">
                                        <span class="request-refund">
                                        	<?php
                            					$url['filter_id'] = ConstContestStatus::RefundRequest;
                            					$key= ConstContestStatus::RefundRequest -1;
                            					echo $this->Html->link(sprintf("%s", __l('Request for Cancellation').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'canceled','title' => __l('Request for Cancellation')));
                            					$refund_request_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                            				?>
                        				</span>
                                    </li>
                                    <li class="request-l clearfix">
										<div class="clearfix">
											<span class="canceled-admin">
												<?php
													$url['filter_id'] = ConstContestStatus::CanceledByAdmin;
													$key= ConstContestStatus::CanceledByAdmin -1;
													echo $this->Html->link(sprintf("%s", __l('Canceled By Admin').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'canceled-by-admin','title' => __l('Canceled By Admin')));
													$cancel_byadmin_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
												?>
											</span>
											<span data-placement="bottom" class="info chart-info js-tooltip" title="<?php echo __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.');?>"><i class="icon-info-sign"></i></span>
										</div>
                                    </li>

                				</ul>
                				</div>
								<?php } ?>
                				<ul class="judging unstyled clearfix <?php echo $judging_class; ?>">
                                    <li class="judging-f">
                                    <div class="judging-l">
                                     <div class="judging-r">
                                        <div class="clearfix judging-block">
                                        <span class="judging contest-info pr">
                                    	<?php
                                            $url['filter_id'] = ConstContestStatus::Judging;
                        					$key= ConstContestStatus::Judging -1;
                                            echo $this->Html->link(sprintf("%s", __l('Judging').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'judging','title' => __l('Judging')));
                                            $judging_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                        ?>
										<span class="helptip js-tooltip pa contest-status-info " title="<?php echo __l('If').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').' '.sprintf(__l('doesn\'t select winner in %s days after contest end date, admin will be forced to select the winner.'), Configure::read('contest.judging_to_winner_selected_days'));?>"><i class="icon-info-sign"></i></span>
                                        </span>
										
                                        </div>
                                        <ul class="winner clearfix unstyled">
                                        <li>
                                            <div class="clearfix winner-select">
                                            <span class="winner-selected contest-info pr">
                                            <?php
                                				$url['filter_id'] = ConstContestStatus::WinnerSelected;
                                				$key= ConstContestStatus::WinnerSelected -1;
                                				echo $this->Html->link(sprintf("%s", __l('Winner Selected').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'winner-selected','title' => __l('Winner Selected')));
                                				$winner_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                        	?>
											<span class="helptip js-tooltip pa contest-status-info" title="<?php echo __l('If').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').' '.sprintf(__l('doesn\'t moves contest to change requested or expecting delivery with in %s days , admin will be forced to complete the contest.'), Configure::read('contest.winner_selected_to_completed_days'));?>"><i class="icon-info-sign"></i></span>
                                        	</span>
											
                                        	</div>
                                        	<div class="clearfix changes-request-block">
                                            <ul class="changes-request unstyled">
                                                <li class="changes-f">
                                                    <span class="changes-request contest-info pr">
                                                	<?php
                                    					$url['filter_id'] = ConstContestStatus::ChangeRequested;
                                    					$key= ConstContestStatus::ChangeRequested -1;
                                    					echo $this->Html->link(sprintf("%s", __l('Change Requested').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'change-requested','title' => __l('Change Requested')));
                                    					$change_requested_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                    				?>
                                    				</span>
                                                </li>
                                                <li class="changes-completed ">
                                                  <span class="changes-completed contest-info pr">
                                                	<?php
                                    					$url['filter_id'] = ConstContestStatus::ChangeCompleted;
                                    					$key= ConstContestStatus::ChangeCompleted -1;
                                    					echo $this->Html->link(sprintf("%s", __l('Change Completed').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'change-completed','title' => __l('Change Completed')));
                                    					$change_completed_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                    				?>
													<span class=" js-tooltip pa contest-status-info" data-placement="left" title="<?php echo __l('If').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').' '.sprintf(__l('doesn\'t moves contest to change requested or expecting delivery with in %s days , admin will be forced to complete the contest.'), Configure::read('contest.change_completed_to_completed_days'));?>"><i class="icon-info-sign"></i></span>
                                    				</span>
													
                                                </li>
                                            </ul>
                                            </div>
                                            <div class="clearfix">
                                             <ul class="completed clearfix unstyled">
                                                 <li>
                                                 <div class="clearfix">
                                                    <span class="files-expectation pull-left">
                                                    	<?php
                                                            $url['filter_id'] = ConstContestStatus::FilesExpectation;
                                        					$key= ConstContestStatus::FilesExpectation -1;
                                                            echo $this->Html->link(sprintf("%s", __l('Expecting Deliv.').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'Files Expectation', 'title' => __l('Expecting Deliverables')));
                                                            $completed_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                                        ?>
                                                        </span>
                                                        </div>														
														<div class="clearfix completed-block pr z-top">
                                                    <span class="complete">
                                                    	<?php
                                                            $url['filter_id'] = ConstContestStatus::Completed;
                                        					$key= ConstContestStatus::Completed -1;
                                                            echo $this->Html->link(sprintf("%s", __l('Completed').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'completed','title' => __l('Completed')));
                                                            $completed_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                                        ?>
                                                        <span data-placement="left" class="js-tooltip pa contest-status-info" title="<?php echo sprintf(__l('Prize amount - Site Commission will move to %s after certain days. The days depends on the gateways settings.'), Configure::read('contest.participant_alt_name_singular_small'));?>"><i class="icon-info-sign no-pad"></i></span>
                                                        </span>
                                                        </div>
                                                        <ul class="paid-participant clearfix unstyled">
                                                           <li>
                                                               <div class="clearfix">
                                                                    <span class="paid-participant">
                                                                        <?php
                                                                            $url['filter_id'] = ConstContestStatus::PaidToParticipant;
                                                                            $key= ConstContestStatus::PaidToParticipant -1;
                                                                            echo $this->Html->link(sprintf(__l('Paid To %s'), Configure::read('contest.participant_alt_name_singular_caps') . ' (' . $contest_statuses[$key]['contest_count'] . ')'), $url, array('class' => 'paid-to-participant','title' => sprintf(__l('Paid To %s'), Configure::read('contest.participant_alt_name_singular_caps'))));
                                                                            $paid_to_participant_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                                                        ?>
        															 </span>
    															 </div>
                                                                             </li>
                                                         </ul>
                                                    </li>
                                            </ul>
                                            </div>
                                        </li>
                                        </ul>
                                        <ul class="wenner-by-selected clearfix unstyled">
                                            <li class="clearfix">
                                              <span class="winner-by-selected">
                                                <?php
                                    				$url['filter_id'] = ConstContestStatus::WinnerSelectedByAdmin;
                                    				$key= ConstContestStatus::WinnerSelectedByAdmin -1;
                                    				echo $this->Html->link(sprintf("%s", __l('Winner Selected by Admin').' ('.$contest_statuses[$key]['contest_count'].')'), $url, array('class' => 'Winner-selected-by-Admin','title' => __l('Winner Selected by Admin')));
                                    				$winner_selectedBy_admin_count=$this->Html->cInt((!empty($contest_statuses[$key]['contest_count'])) ? $contest_statuses[$key]['contest_count'] : 0,false);
                                            	?>
                                        	</span>
                                            </li>
                                        </ul>
										<div class="clearfix pending-action-to-admin-block">
											<span class="pending-action-to-admin">
											<?php
												unset($url['filter_id']);
												$url['is_pending_action_to_admin'] = '1';
												echo $this->Html->link(sprintf("%s", __l('Pending Action to Admin').' ('.$pendingactiontoadmin_count.')'), $url, array('class' => 'pending-action-to-admin','title' => __l('Pending Action to Admin')));
											?></span>
                                        </div>
                                      </div>
                                      </div>
                                    </li>
                				</ul>


                           </li>
				        </ul>
                    </li>
                </ul>

        </li>
    </ul>

    <div class="entry-block">
    <?php
	       $entry_count=$payment_pending_count+$pending_approval_count+$rejected_count+$open_count+$refund_request_count+$cancel_byadmin_count
	       ?>
	       <span class="entry-f">
	        <?php if(!empty($this->request->params['named']['is_admin'])): ?>
	       <?php echo $this->Html->link(__l('Entry').' ('.$this->Html->cInt((!empty($entry_count)) ? $entry_count : 0,false).')', array('controller' => 'contests', 'action' => 'index','filter_id'=>'entry','admin'=>true), array('title' => __l('Entry')));
	       else:
	       echo $this->Html->link(__l('Entry').' ('.$this->Html->cInt((!empty($entry_count)) ? $entry_count : 0,false).')', array('controller' => 'contests', 'action' => 'index','type'=>'mycontest','filter_id'=>'entry'), array('title' => __l('Entry')));?>
        <?php endif;?>
           </span>
    </div>
    <div class="development-block">
    <?php $develop_count = $judging_count+$winner_count+$change_requested_count+$change_completed_count+$completed_count+$paid_to_participant_count+$winner_selectedBy_admin_count;?>
    	<span class="development-f">
    	 <?php if(!empty($this->request->params['named']['is_admin'])): ?>
         <?php echo $this->Html->link(__l('Development').' ('.$this->Html->cInt((!empty($develop_count)) ? $develop_count : 0,false).')', array('controller' => 'contests', 'action' => 'index','filter_id'=>'development','admin'=>true), array('title' => __l('Development')));
         else:
         echo $this->Html->link(__l('Development').' ('.$this->Html->cInt((!empty($develop_count)) ? $develop_count : 0,false).')', array('controller' => 'contests', 'action' => 'index','type'=>'mycontest','filter_id'=>'development'), array('title' => __l('Development'))); ?>
    <?php endif;?>
        </span>
    </div>

		 <?php
		if(!empty($contest_statuses)):
			$contest_percentage = '';
			$contest_stat = '';
			foreach($contest_statuses as $contest_status):
				$contest_percentage .= ($contest_percentage != '') ? ',' : '';
				$contest_stat .= $contest_status['ContestStatus']['name'];
				$all_contest_count= $this->Html->cInt((!empty($all_contest_count)) ? $all_contest_count : 0,false);
				$contest_percentage .= round((empty($contest_status['contest_count'])) ? 0 : ( ($contest_status['contest_count'] / $all_contest_count) * 100 ));
			endforeach;
		endif;
	?>
		<div class="pull-right flow-chart-block clearfix">
				<?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$contest_percentage.'&amp;chs=75x75&amp;chco=EDA710|4E8975|8CAE50|DF5958|AC725E|FD66B5|49A7FF|6DC699|B371AF|8B65D6|B99AFF|16A765|6094BD|A5A5A5&amp;chf=bg,s,FF000000'); ?>

        </div>
            <div class="all-block">
                <span class="all-f">
                 <?php if(!empty($this->request->params['named']['is_admin'])): ?>
                    <?php echo $this->Html->link(__l('All') . ' (' . $all_contest_count . ')', array('controller' => 'contests', 'action' => 'index','admin'=>true), array('title' => __l('All') . ' (' . $all_contest_count . ')'));
                    else:
                    echo $this->Html->link(__l('All') . ' (' . $all_contest_count . ')', array('controller' => 'contests', 'action' => 'index','type'=>'mycontest'), array('title' => __l('All') . ' (' . $all_contest_count . ')'));
                  endif;?>
                </span>
            </div>
        </div>