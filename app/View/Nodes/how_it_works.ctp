<h2><?php echo $this->pageTitle; ?></h2>
<div class="overview-tl">
  <div class="overview-tr">
    <div class="overview-tc"> </div>
  </div>
</div>
<div class="overview-center clearfix">
  <h3><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps');?></h3>
</div>
<div class="overview-bl">
  <div class="overview-br">
    <div class="overview-bc"> </div>
  </div>
</div>
<div class="clearfix flow-chart">
  <ul class="flow-chart pull-left clearfix unstyled">
        <li class="payment-f">
            <div class="clearfix">
                <span class="payment-left"><span class="static-status"><?php echo __l('Payment Pending'); ?></span></span>
				<span class="info chart-info js-tooltip" title="<?php echo sprintf(__l('If %s doesn\'t pay in %s days contest will be deleted.'), Configure::read('contest.contest_holder_alt_name_singular_caps'), Configure::read('contest.contest_payment_pending_days_limit'));?>"><i class="icon-info-sign"></i></span>
            </div>
                <ul class="pending clearfix unstyled">
                    <li class="pending-f">
                      <div class="clearfix">
                        <span class="pending-approval"><span class="static-status"><?php echo __l('Pending Approval'); ?></span></span>
				        </div>
				        <ul class="rejected clerafix unstyled">
                            <li class="rejected-f">
								<div class="clearfix">
									<span class="rejected-1"><span class="static-status"><?php echo __l('Rejected'); ?></span></span>
									<span data-placement="bottom" class="info chart-info js-tooltip" title="<?php echo __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.');?>"><i class="icon-info-sign"></i></span>
								</div>
                            </li>
				        </ul>
				        <ul class="open clearfix unstyled">
                            <li>
                                <div class="clearfix open-f">
                                <span class="open-f"><span class="static-status"><?php echo __l('Open'); ?></span></span>
                                </div>
                                <div class="request-refund-block">
                				<ul class="request-refund clearfix unstyled">
                				  <li class="refund-l request-refund-f clearfix">
                                        <span class="request-refund"><span class="static-status"><?php echo __l('Request for Cancellation'); ?></span></span>
                                    </li>
                                    <li class="request-l clearfix">
										<div class="clearfix">
											<span class="canceled-admin"><span class="static-status"><?php echo __l('Canceled By Admin'); ?></span></span>
											<span data-placement="bottom" class="info chart-info js-tooltip" title="<?php echo __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.');?>"><i class="icon-info-sign"></i></span>
										</div>
                                    </li>
                				</ul>
                				</div>
                				<ul class="judging judging-request unstyled clearfix">
                                    <li class="judging-f">
                                    <div class="judging-l">
                                     <div class="judging-r">
                                        <div class="clearfix judging-block">
                                        <span class="judging contest-info pr"><span class="static-status"><?php echo __l('Judging'); ?></span>
										<span class="helptip js-tooltip pa contest-status-info " title="<?php echo __l('If').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').' '.sprintf(__l('doesn\'t select winner in %s days after contest end date, admin will be forced to select the winner.'), Configure::read('contest.judging_to_winner_selected_days'));?>"><i class="icon-info-sign"></i></span>
                                        </span>
                                        </div>
                                        <ul class="winner clearfix unstyled">
                                        <li>
                                            <div class="clearfix winner-select">
                                            <span class="winner-selected contest-info pr"><span class="static-status"><?php echo __l('Winner Selected'); ?></span>
											<span class="helptip js-tooltip pa contest-status-info" title="<?php echo __l('If').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').' '.sprintf(__l('doesn\'t moves contest to change requested or expecting delivery with in %s days , admin will be forced to complete the contest.'), Configure::read('contest.winner_selected_to_completed_days'));?>"><i class="icon-info-sign"></i></span>
                                        	</span>
											
                                        	</div>
                                        	<div class="clearfix changes-request-block">
                                            <ul class="changes-request unstyled">
                                                <li class="changes-f">
                                                    <span class="changes-request contest-info pr"><span class="static-status"><?php echo __l('Change Requested'); ?></span></span>
                                                </li>
                                                <li class="changes-completed ">
                                                  <span class="changes-completed contest-info pr"><span class="static-status"><?php echo __l('Change Completed'); ?></span>
													<span class=" js-tooltip pa contest-status-info" data-placement="left" title="<?php echo __l('If').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').' '.sprintf(__l('doesn\'t moves contest to change requested or completed with in %s days , admin will be forced to complete the contest.'), Configure::read('contest.change_completed_to_completed_days'));?>"><i class="icon-info-sign"></i></span>
                                    				</span>
													
                                                </li>
                                            </ul>
                                            </div>
                                            <div class="clearfix">
                                             <ul class="completed clearfix unstyled">
                                                 <li>
                                                 <div class="clearfix">
                                                    <span class="files-expectation pull-left"><span class="static-status"><?php echo __l('Expecting Deliv.'); ?></span></span>
                                                        </div>														
														<div class="clearfix completed-block">
                                                    <span class="complete">
													<span class="static-status"><?php echo __l('Completed'); ?></span><span data-placement="left" class="js-tooltip pa contest-status-info" title="<?php echo sprintf(__l('Prize amount - Site Commission will move to %s after certain days. The days depends on the gateways settings.'), Configure::read('contest.participant_alt_name_singular_small'));?>"><i class="icon-info-sign"></i></span></span>
                                                        
                                                        </div>
                                                        <ul class="paid-participant clearfix unstyled">
                                                           <li>
                                                               <div class="clearfix">
                                                                    <span class="paid-participant"><span class="static-status"><?php echo sprintf(__l('Paid To %s'), Configure::read('contest.participant_alt_name_singular_caps')); ?></span></span>
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
                                              <span class="winner-by-selected"><span class="static-status"><?php echo __l('Winner Selected by Admin'); ?></span></span>
                                            </li>
                                        </ul>
										<div class="clearfix pending-action-to-admin-block">
											<span class="pending-action-to-admin"><span class="static-status"><?php echo __l('Pending Action to Admin'); ?></span></span>
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
  <div class="entry-block"> <span class="entry-f"> <span class="static-status"><?php echo __l('Entry');?></span> </span> </div>
  <div class="development-block"> <span class="development-f"> <span class="static-status"><?php echo __l('Development');?></span> </span> </div>
</div>
<div class="clearfix">
  <dl class="how-list clearfix">
    <dt class="grid_left"><?php echo __l('Site Fee:');?></dt>
    <dd><?php echo __l('As per the Contest Rule.');?></dd>
  </dl>
</div>
<div class="overview-tl">
  <div class="overview-tr">
    <div class="overview-tc"> </div>
  </div>
</div>
<div class="overview-center clearfix">
  <h3><?php echo Configure::read('contest.participant_alt_name_singular_caps');?></h3>
</div>
<div class="overview-bl">
  <div class="overview-br">
    <div class="overview-bc"> </div>
  </div>
</div>
<div class="clearfix flow-chart entry-flow-chart-block contest-flow-chart">
  <ul class="grid_left flow-chart contest-chart unstyled">
			<li>
			<div class="clearfix">
                <span class="open-f"><span class="static-status"><?php echo __l('Active'); ?></span></span>
                </div>
    				<ul class="clearfix eliminated-f unstyled">
    					<li class="">
            			<span class="expired"><span class="static-status"><?php echo __l('Eliminated'); ?></span></span>
            			</li>
                    </ul>
                    <div class="clearfix">
                    <ul class="clearfix lost unstyled">
            			<li class="">
            	         <span class="canceled-admin"><span class="static-status"><?php echo __l('Lost'); ?></span></span>
            			</li>
            			</ul>
            			</div>
            			  <div class="clearfix">
            				<ul class="clearfix won-f unstyled">
        					<li class="clearfix">
                            <div class="clearfix complete-f">
                              <span class="won-flow"><span class="static-status"><?php echo __l('Won'); ?></span></span>
                                 </div>
                                <ul class="winner winner1 clearfix unstyled">
                                        <li>
                                           <ul class="changes-request changes-request1 unstyled">
                                                <li class="changes-f">
                                                    <span class="changes-request"><span class="static-status"><?php echo __l('Change Requested'); ?></span></span>
                                                </li>
                                                <li class="changes-completed changes-completed1">
                                                  <span class="changes-completed"><span class="static-status"><?php echo __l('Change Completed'); ?></span></span>
                                                  </li>
                                            </ul>
                                           <ul class="completed completed1 clearfix unstyled">
                                                 <li>
												 <div class="clearfix">
                                                    <span class="files-expectation pull-left"><span class="static-status"><?php echo __l('Expecting Deliv.'); ?></span></span>
                                                        </div>												 
                                                 <div class="clearfix completed-block">
                                                    <span class="complete"><span class="static-status"><?php echo __l('Completed'); ?></span></span>
                                                        </div>
                                                        <ul class="paid-participant paid-participant1 clearfix unstyled">
                                                           <li>
                                                            <span class="paid-participant"><span class="static-status"><?php echo __l('Closed'); ?></span></span>
                                                            </li>
                                                         </ul>
                                                    </li>
                                            </ul>
                                        </li>
                                       </ul>
                                </li>
                        </ul>
                        </div>
                        <div class="clearfix">
                			<ul class="withdrawn-f unstyled">
                		    <li class="">
                		       <span class="withdrawn"><span class="static-status"><?php echo __l('Withdrawn'); ?></span></span>
                        	</li>
                			</ul>
            			</div>
			</li>
 		</ul>
  <div class="entry-block"> <span class="entry-f"> <span class="static-status"><?php echo __l('Entry');?></span> </span> </div>
  <div class="development-block"> <span class="development-f"> <span class="static-status"><?php echo __l('Development');?></span> </span> </div>
</div>
<dl class="how-list clearfix">
  <dt class="grid_left"><?php echo sprintf(__l('%s Commission:'), Configure::read('contest.participant_alt_name_singular_caps'));?></dt>
  <dd><?php echo __l('As per the Contest Rule.');?></dd>
</dl>