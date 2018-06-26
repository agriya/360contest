<?php
	$url= array(
		'controller' => 'contest_users',
		'action' => 'index',
	);
	if (empty($this->request->params['named']['is_admin'])) {
		$url['type'] = 'myparticipation';
	}
	else{
		$url['admin'] = true;
	}
?>
	<div class="clearfix flow-chart pull-left entry-flow-chart-block contest-flow-chart span">
		<ul class="grid_left flow-chart contest-chart unstyled">
			<li>
			<div class="clearfix">
                <span class="open-f">
				<?php
				
					$url['filter_id'] = ConstContestUserStatus::Active;
					$key= ConstContestUserStatus::Active -1;
					echo $this->Html->link(sprintf("%s", __l('Active').' ('.$contest_user_statuses[$key]['contest_count'].')'), $url, array('class' => 'active','title' => __l('Active')));
					$active_count=$this->Html->cInt((!empty($contest_user_statuses[$key]['contest_count'])) ? $contest_user_statuses[$key]['contest_count'] : 0,false);
						?>
                </span>
                </div>
    				<ul class="clearfix eliminated-f unstyled">
    					<li class="">

            			<span class="expired">
            				<?php
            					$url['filter_id'] = ConstContestUserStatus::Eliminated;
            					$key= ConstContestUserStatus::Eliminated -1;
            					echo $this->Html->link(sprintf("%s", __l('Eliminated').' ('.$contest_user_statuses[$key]['contest_count'].')'), $url, array('class' => 'eliminated','title' => __l('Eliminated')));
            					$eliminated_count=$this->Html->cInt((!empty($contest_user_statuses[$key]['contest_count'])) ? $contest_user_statuses[$key]['contest_count'] : 0,false);
            					?>
                        </span>

            			</li>
                    </ul>
                    <div class="clearfix">
                    <ul class="clearfix lost unstyled">
            			<li class="">
            	         <span class="canceled-admin">
            				<?php
            					$url['filter_id'] = ConstContestUserStatus::Lost;
            					$key= ConstContestUserStatus::Lost -1;
            					echo $this->Html->link(sprintf("%s", __l('Lost').' ('.$contest_user_statuses[$key]['contest_count'].')'), $url, array('class' => 'withdrawn','title' => __l('Lost')));
            					$lost_count=$this->Html->cInt((!empty($contest_user_statuses[$key]['contest_count'])) ? $contest_user_statuses[$key]['contest_count'] : 0,false);
            				?>
                        </span>

            			</li>
            			</ul>
            			</div>
            			  <div class="clearfix">
            				<ul class="clearfix won-f unstyled">
        					<li class="clearfix">
                            <div class="clearfix complete-f">
                              <span class="won-flow">
                				<?php
                                    $url['filter_id'] = ConstContestUserStatus::Won;
                					$key= ConstContestUserStatus::Won -1;
                                    echo $this->Html->link(sprintf("%s", __l('Won').' ('.$contest_user_statuses[$key]['contest_count'].')'), $url, array('class' => 'won','title' => __l('Won')));
                                    $won_count=$this->Html->cInt((!empty($contest_user_statuses[$key]['contest_count'])) ? $contest_user_statuses[$key]['contest_count'] : 0,false);
                                             ?>

                                 </span>
                                 </div>
                                <ul class="winner winner1 clearfix unstyled">
                                        <li>
                                           <ul class="changes-request changes-request1 unstyled">
                                                <li class="changes-f">
                                                    <span class="changes-request">
                                                	<?php
                                                	     if(!empty($this->request->params['named']['is_admin'])): 
                                                	     echo $this->Html->link(__l('Change Requested').' ('. $this->Html->cInt((!empty($change_requested_count)) ? $change_requested_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>ConstContestStatus::ChangeRequested,'admin'=>true), array('title' => __l('Change Requested')));
                                    				     else:
                                    				     echo $this->Html->link(__l('Change Requested').' ('. $this->Html->cInt((!empty($change_requested_count)) ? $change_requested_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>ConstContestStatus::ChangeRequested), array('title' => __l('Change Requested')));
                                    				     endif;
                                                         $change_requested_count = $this->Html->cInt((!empty($change_requested_count)) ? $change_requested_count : 0,false);
                                                         ?>
                                                        </span>
                                                </li>
                                                <li class="changes-completed changes-completed1">
                                                  <span class="changes-completed">
                                                	<?php if(!empty($this->request->params['named']['is_admin'])): 
                                                	  echo $this->Html->link(__l('Change Completed').' ('.$this->Html->cInt((!empty($change_completed_count)) ? $change_completed_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>ConstContestStatus::ChangeCompleted,'admin'=>true), array('title' => __l('Change Completed')));
                                                	  else:
                                                      echo $this->Html->link(__l('Change Completed').' ('.$this->Html->cInt((!empty($change_completed_count)) ? $change_completed_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>ConstContestStatus::ChangeCompleted), array('title' => __l('Change Completed')));
                                                      endif;
                                                      $change_completed_count = $this->Html->cInt((!empty($change_completed_count)) ? $change_completed_count : 0,false);
                                                       ?>
                                                      </span>
                                                  </li>
                                            </ul>
                                           <ul class="completed completed1 clearfix unstyled">
                                                 <li>
												 <div class="clearfix">
                                                    <span class="files-expectation pull-left">
                                                      <?php if(!empty($this->request->params['named']['is_admin'])): 
                                    				    echo $this->Html->link(__l('Expecting Deliv.').' ('. $this->Html->cInt((!empty($files_expectation_count)) ? $files_expectation_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>ConstContestStatus::FilesExpectation,'admin'=>true), array('title' => __l('Expecting Deliverables')));                                                    
                                    				    else:
                                    				    echo $this->Html->link(__l('Expecting Deliver').' ('. $this->Html->cInt((!empty($files_expectation_count)) ? $files_expectation_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>ConstContestStatus::FilesExpectation), array('title' => __l('Expecting Deliverables')));
                                    				    endif;
                                                        $files_expectation_count=$this->Html->cInt((!empty($files_expectation_count)) ? $files_expectation_count : 0,false);
                                                        ?></span>
                                                        </div>
												 
                                                 <div class="clearfix completed-block z-top">
                                                    <span class="complete">
                                                      <?php if(!empty($this->request->params['named']['is_admin'])): 
                                    				    echo $this->Html->link(__l('Completed').' ('. $this->Html->cInt((!empty($completed_count)) ? $completed_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>ConstContestStatus::Completed,'admin'=>true), array('title' => __l('Completed')));                                                    
                                    				    else:
                                    				    echo $this->Html->link(__l('Completed').' ('. $this->Html->cInt((!empty($completed_count)) ? $completed_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>ConstContestStatus::Completed), array('title' => __l('Completed')));
                                    				    endif;
                                                        $completed_count=$this->Html->cInt((!empty($completed_count)) ? $completed_count : 0,false)
                                                        ?></span>
                                                        </div>
                                                        <ul class="paid-participant paid-participant1 clearfix unstyled">
                                                           <li>
                                                            <span class="paid-participant">
                                                              <?php if(!empty($this->request->params['named']['is_admin'])): 
                                            				    echo $this->Html->link(__l('Closed').' ('. $this->Html->cInt((!empty($close_count)) ? $close_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>ConstContestStatus::PaidToParticipant, 'admin'=>true), array('title' => __l('Closed')));
                                            				    else:
                                            				    echo $this->Html->link(__l('Closed').' ('. $this->Html->cInt((!empty($close_count)) ? $close_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>ConstContestStatus::PaidToParticipant), array('title' => __l('Closed')));
                                            				    endif;
                                                                $close_count=$this->Html->cInt((!empty($close_count)) ? $close_count : 0,false);
                                                                                  ?>
                                                          </span>
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
                		       <span class="withdrawn">
                				<?php
                					$url['filter_id'] = ConstContestUserStatus::Withdrawn;
                					$key= ConstContestUserStatus::Withdrawn -1;
                					echo $this->Html->link(sprintf("%s", __l('Withdrawn').' ('.$contest_user_statuses[$key]['contest_count'].')'), $url, array('class' => 'withdrawn','title' => __l('Withdrawn')));
                					$withdrawn_count=$this->Html->cInt((!empty($contest_user_statuses[$key]['contest_count'])) ? $contest_user_statuses[$key]['contest_count'] : 0,false);
                   				?>
                              </span>
                        	</li>
                			</ul>
            			</div>
			</li>
 		</ul>
 		  <div class="entry-block">
	       <span class="entry-f">
        <?php
	        $entries_count=$active_count+$withdrawn_count+$lost_count+$eliminated_count;
	       $development_count=$won_count+$change_requested_count+$change_completed_count+$completed_count+$close_count;
	          ?>
            <?php if(!empty($this->request->params['named']['is_admin'])): 
                ?>
	       <?php echo $this->Html->link(__l('Entry').' ('.$this->Html->cInt((!empty($entries_count)) ? $entries_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>'entry','admin'=>true), array('title' => __l('Entry')));
	       else:
	       echo $this->Html->link(__l('Entry').' ('. $this->Html->cInt((!empty($entries_count)) ? $entries_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>'entry'), array('title' => __l('Entry')));?>
        <?php endif;?>
        </span>
         </div>
    <div class="development-block">
    	<span class="development-f">
		<?php if(!empty($this->request->params['named']['is_admin'])): ?>
	       <?php echo $this->Html->link(__l('Development').' ('.$this->Html->cInt((!empty($development_count)) ? $development_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>'development','admin'=>true), array('title' => __l('Development')));
	       else:
	       echo $this->Html->link(__l('Development').' ('.$this->Html->cInt((!empty($development_count)) ? $development_count : 0,false).')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation','filter_id'=>'development'), array('title' => __l('Development')));?>
        <?php endif;?>
        </span>
    	
    </div>
  <div class="grid_right flow-chart-block flow-chart-block1">
   <?php
        $all_entry_count= $this->Html->cInt((!empty($all_entry_count)) ? $all_entry_count : 0,false);
      	$contest_percentage = round((empty($active_count)) ? 0 : (($active_count / $all_entry_count) * 100));
        $contest_percentage .= ',' . round((empty($won_count)) ? 0 : (($won_count / $all_entry_count) * 100));
        $contest_percentage .= ',' . round((empty($lost_count)) ? 0 : (($lost_count / $all_entry_count) * 100));
	    $contest_percentage .= ',' . round((empty($withdrawn_count)) ? 0 : (($withdrawn_count / $all_entry_count) * 100));
	    $contest_percentage .= ',' . round((empty($eliminated_count)) ? 0 : (($eliminated_count / $all_entry_count) * 100));
        $contest_percentage .= ',' . round((empty($change_requested_count)) ? 0 : (($change_requested_count / $all_entry_count) * 100));
	    $contest_percentage .= ',' . round((empty($change_completed_count)) ? 0 : (($change_completed_count / $all_entry_count) * 100));
	    $contest_percentage .= ',' . round((empty($completed_count)) ? 0 : (($completed_count / $all_entry_count) * 100));
	    $contest_percentage .= ',' . round((empty($close_count)) ? 0 : (($close_count / $all_entry_count) * 100));
        ?>
			<?php echo $this->Html->image('http://chart.googleapis.com/chart?cht=p&amp;chd=t:'.$contest_percentage.'&amp;chs=80x80&amp;chco=8CAE50|527ECE|FD66B5|FFAD46|A5A5A5|8B65D6|B99AFF|16A765|6094BD&amp;chf=bg,s,FF000000'); ?>
		</div>
		<div class="all-block hor-smspace">
                <span class="all-f">
                 <?php if(!empty($this->request->params['named']['is_admin'])): ?>
                    <?php echo $this->Html->link(__l('All') . ' (' . $all_entry_count . ')', array('controller' => 'contest_users', 'action' => 'index','filter_id'=>'all','admin'=>true), array('title' => __l('All') . ' (' . $all_entry_count . ')'));
                    else:
                    echo $this->Html->link(__l('All') . ' (' . $all_entry_count . ')', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipation'), array('title' => __l('All') . ' (' . $all_entry_count . ')'));
                  endif;?>
                </span>
        </div>
		</div>
