<div class="js-response">
        <div class="bot-space">
          <div class="ver-space">
            <div class="page-header no-mar">
              <h2><?php echo __l("Messages");?></h2>
            </div>
            <section class="row thumbnail inbox-tab no-pad sep-bot no-mar">
              <?php echo $this->element('message_message-left_sidebar', array('cache' => array('config' => 'sec'))); ?>
              <div class="btn-group pull-right mspace">
                <button class="btn">Contests</button>
                <button data-toggle="dropdown" class="btn dropdown-toggle inbox-sort-group"> <span class="caret"></span> </button>
                <ul class="dropdown-menu arrow arrow-right inbox-menu">
					<li class="clearfix sep-bot">
							<span class="pull-left sep-right"><?php echo $this->Html->link(__l('All') , array('controller' => 'messages', 'action' => 'index', 'type'=>'all') );?></span>
							<span class="pull-left"><?php echo $this->Html->link(__l('Closed') , array('controller' => 'messages', 'action' => 'index', 'type'=>'closed') );?></span>
					</li>
					<?php foreach($contest_own as $contest_arr) { ?>
						<li class="sep-bot bot-space">
							<?php
								$out='';
								$out.='<span class="title-info">';
								$out.=$this->Html->cText($contest_arr['Contest']['name']);
								$out.='</span>';
								$out.='<span class="clearfix message-sub-info">';
								$out.='<span class="pull-left">';
								$out.='<span class="status-block pull-left">';
								$out.='<span class="status-block-inner">';
								$out.='<span class="';
								$out.=$contest_arr['ContestStatus']['slug'];
								$out.='">';
								$out.=' ';
								$out.='</span>';
								$out.='</span>';
								$out.='</span>';
								$out.='</span>';
								$out.='<span class="pull-left htruncate span4">';
								$out.=$contest_arr['ContestStatus']['name'];
								$out.='</span>';
								$out.='<span class="pull-right">';
								if($contest_arr['Contest']['user_id'] == $this->Auth->user('id')) {
								if(!empty($contest_arr['ContestUser'][0]['User'])){
									$out.=$this->Html->getUserAvatarLink($contest_arr['ContestUser'][0]['User'], 'micro_thumb',false);
									$out.=$contest_arr['ContestUser'][0]['User']['username'];
								}
								}else{
									$out.=$this->Html->getUserAvatarLink($contest_arr['User'], 'micro_thumb',false);
									$out.=$contest_arr['User']['username'];
								}
								$out.='</span>';
								$out.='</span>';
								echo $this->Html->link($out , array('controller' => 'messages', 'action' => 'index', 'type' => 'contest', 'contest_id'=>$contest_arr['Contest']['id']),array('escape'=>false));
							?>
						</li>
					<?php } ?>
                </ul>
              </div>
            </section>
            <div class="tab-content row no-mar panel-container">
              <!--inbox start-->
              <div class="tab-pane active" id="msg-inbox">
                <section class="clearfix">
                  <ol class="unstyled no-pad sep-bot nomar">
				  	<?php
						if (!empty($messages)) {
							$i = 0;
							foreach($messages as $message):
								// if empty subject, showing with (no suject) as subject as like in gmail
								if (!$message['MessageContent']['subject']) :
									$message['MessageContent']['subject'] = '(no subject)';
								endif;
								$row_three_class = '';
								if ($i++ % 2 == 0) :
									$row_class = 'row';
								else :
									$row_class = 'altrow';
								endif;
								$message_class = "checkbox-message ";
								$is_read_class = "";
								$is_starred_class = "star";
								if ($message['Message']['is_read']) :
									$message_class .= " checkbox-read ";
									$is_read_class .= "grayc";
									$un_read_bg = 'un-read-bg';
								else :
									$message_class .= " checkbox-unread ";
									$row_class=$row_class.' unread-row';
									$un_read_bg = '';
								endif;
								if ($message['Message']['is_starred']):
									$message_class .= " checkbox-starred ";
									$is_starred_class = "star-select";
								else:
									$message_class .= " checkbox-unstarred ";
								endif;
								$row_class_new='class="clearfix ver-space no-bor sep-right sep-left sep-top cur thumbnail js-show-message show-message-block clearfix {\'message_id\':\''. $message['Message']['id'] .'\',\'is_read\':\''. $message['Message']['is_read'] .'\'}"';
								$row_class='class="no-pad message-list-block clearfix '.$row_class. '"';

								 if (!empty($message['MessageContent']['Attachment'])):
										$row_three_class.=' has-attachment';
								endif;
								$view_url=array('controller' => 'messages','action' => 'v', $message['Message']['id']);
								if($message['Message']['is_starred']) {
									$star = 'unstar';
									$star_class = 'icon-star';
								} else {
									$star = 'star';
									$star_class = 'icon-star-empty';
								}
								$star_url = Router::url(array(
									'controller' => 'messages',
									'action' => 'star',
									$message['Message']['id'],
									$star
								) , true);
					?>
                    <li class="<?php echo $un_read_bg; ?> unread-row thumbnail no-pad">
                        <section class="js-show-message <?php echo $is_read_class;?> clearfix ver-space no-bor sep-right sep-left sep-top cur {'message_id':'<?php echo $message['Message']['id']; ?>','is_read':'<?php echo $message['Message']['is_read']; ?>'}">
                          <div class="span over-hide hor-smspace top-space <?php echo $row_three_class;?>">
						  <span class="pull-left  js-star-place<?php echo $message['Message']['id']; ?>">
						  <a href="<?php echo $star_url; ?>" class="grayc no-pad cur <?php echo $star_class; ?> text-20 js-star {'message_id':'<?php echo $message['Message']['id']; ?>'} "><span class="hide">Star</span></a> 
						  </span>
						  <span class="text-14 pull-left clearfix show textb pinkc htruncate span3">
						  <?php
							if ($message['Message']['is_sender'] == 1) :
								if($message['Message']['other_user_id'] == 0){
									$user_name = __l('All');
								}
								else{
									$user_name = $message['OtherUser']['username'];
								}
								echo __l('To: ') . $this->Html->cText($this->Html->truncate($user_name), false);
							elseif ($message['Message']['is_sender'] == 2) :
								echo $this->Html->link(__l('Me   : ') , $view_url);
							else: ?>
							<span class="pull-left show js-tooltip" title="<?php echo $message['OtherUser']['username'];?>"> 
							<?php echo $this->Html->getUserAvatarLink($message['OtherUser'], 'small_thumb',false); ?>
							</span> 
							<span class="pull-left top-smspace show htruncate span2">
							<?php echo $this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false); ?>
							<?php endif; ?></span>
						  </span></div>
						  <section>
                          <div class="span7 top-smspace"> 
						  	<?php if(!empty($message['Contest']['ContestStatus']['name'])):?>
							<div class="status-block">
								<div class="status-block-inner">
									<span title ="<?php echo $message['Contest']['ContestStatus']['name']; ?>" class="<?php echo  $message['Contest']['ContestStatus']['slug'];?>"><?php echo $message['Contest']['ContestStatus']['name']; ?></span>
								</div>
							</div>
						   <?php endif;?>
						  <span class="textb htruncate span6 no-mar js-tooltip" title="<?php echo $this->Html->cText($message['Contest']['name'], false);?>"><?php echo $this->Html->cText($message['Contest']['name']);?></span> </div>
                          <div class="span9 top-smspace over-hide"> <span><?php echo $this->Html->truncate($this->Html->cText($message['MessageContent']['message'], false), Configure::read('messages.content_length'),'.....');?></span></div>
						  <?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
                          <div class="dr span4 top-smspace over-hide pull-right"><span class="hor-space js-timestamp" title ="<?php echo $time_format;?>"><?php echo $message['Message']['created'] ;?></span></div></section>
                        </section>
                        <section class="message-collapse js-message-view<?php echo $message['Message']['id']; ?>  sep-right sep-left hide over-hide">
                          <div class="space  no-pad thumbnail sep-left sep-right sep-bot sep-top">
                            <div class="clearfix bot-space">
                              <div class="pull-left span18 no-mar">
								<div class="pull-left"> 						  	
									<?php if(!empty($message['Contest']['ContestStatus']['name'])):?>
									<div class="status-block">
										<div class="status-block-inner">
											<span title ="<?php echo $message['Contest']['ContestStatus']['name']; ?>" class="<?php echo  $message['Contest']['ContestStatus']['slug'];?>"><?php echo $message['Contest']['ContestStatus']['name']; ?></span>
											<span><?php echo $message['Contest']['ContestStatus']['name']; ?></span> 
										</div>
									</div>
									<?php endif;?>
								</div>
                                <div class="pull-left textb no-mar js-tooltip htruncate span6" title="<?php echo $this->Html->cText($message['Contest']['name'], false);?>"><?php echo $this->Html->cText($message['Contest']['name']);?></div>
                              </div>
                              <div class="span4 dr pull-right over-hide">
							    <?php if (isset($message['Message']['is_auto']) && $message['Message']['is_auto'] != 1): ?>
									<?php echo $this->Html->link(__l('Message Board'), array('controller' => 'contests', 'action' => 'view',$message['Contest']['slug'],'#message-board'),array('class' => 'pinkc', 'title' => __l('Message Board')));?>
								<?php else: ?>
									<?php echo $this->Html->link(__l('Activities'), array('controller' => 'contests', 'action' => 'view',$message['Contest']['slug'],'#Activities'),array('class' => 'pinkc', 'title' => __l('Activities')));?>
								<?php endif; ?>
							  </div>
                            </div>
                            <div class="clearfix bot-space "><?php echo $this->Html->cText($message['MessageContent']['message']);?> </div>
                            <div class="clearfix hor-mspace dr"> 
							<?php 
							if($this->Auth->user('id') != $message['Message']['other_user_id'] && empty($message['Message']['is_activity'])) {
								echo $this->Html->link(__l('Reply'), array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'], 'reply', 'user' => $message['OtherUser']['username'], 'contest_id' => $message['Contest']['id'], 'reply_type' => 'quickreply','root'=>$message['Message']['root'],'message_type'=>'inbox','m_path'=>$message['Message']['materialized_path']), array("class" => "btn btn-small reply-block js-link js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-".$message['Message']['id']."'}", 'title' => __l('Reply')));
							}
						   ?>
							</div>
							<div class="space multisupporteds hide js-quickrepy js-quickreply-<?php echo $message['Message']['id'];?>">
								<div class="quick-replay1 clearfix">
									<div class="js-quickreplydiv-<?php echo $message['Message']['id'];?>"></div>
								</div>
							</div>
							<div class="hide js-conversation-<?php echo $message['Message']['id'];?>"></div>
                          </div>
                        </section>
                    </li>
              <?php
				endforeach;
					}
				else { ?>
        		<li>
						  <div class="thumbnail space dc grayc">
        <p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Messages'));?></p>
        <p class="bot-space"><?php echo sprintf(__l('Your %s will appear here'), __l('messages')); ?></p>
      </div>
				</li>
			  <?php } ?>
			</ol>
                </section>
                <section>
					<?php if (!empty($messages)) { ?>
							<div class=" mob-clr top-space show dc"> <div style="" class="paging offset9 top-space span show  clearfix js-pagination"> 
							<?php echo $this->element('paging_links'); ?>
							</div> </div>
					<?php } ?>
                </section>
              </div>
              <!--inbox End-->
              <!--replied start-->
              <div class="tab-pane fade in active" id="msg-replied"></div>
              <!--replied End-->
              <!--started start-->
              <div class="tab-pane fade in active" id="msg-starred"></div>
              <!--started End-->
              <!--All start-->
              <div class="tab-pane fade in active" id="msg-all"></div>
              <!--All End-->
            </div>
          </div>
        </div>
      </div>