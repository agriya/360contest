<?php if (!empty($messages)): ?>
	<ol class="unstyled">
		<?php
			$i = 0;
			foreach($messages as $message):
			   // if empty subject, showing with (no suject) as subject as like in gmail
				if (!$message['MessageContent']['subject']) :
					$message['MessageContent']['subject'] = '(no subject)';
				endif;
				$row_class = '';
				$message_class = "checkbox-message ";
				$is_read_class = "";
				$is_starred_class = "star";
				if ($message['Message']['is_read']) :
					$message_class .= " checkbox-read ";
					$is_read_class .= "grayc";
					$un_read_bg = ' un-read-bg';
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
				$path_class='';
				if(!empty($message['Message']['path'])){
					$path_count=explode('.',$message['Message']['path']);
					$path_class='path-' . count($path_count);
				}
				$row_class='class=" message-list-block clearfix '.$row_class . ' ' . $path_class . ' js-show-message clearfix {\'message_id\':\''. $message['Message']['id'] .'\',\'is_read\':\''. $message['Message']['is_read'] .'\'}"';
				$row_three_class='w-three';
				 if (!empty($message['MessageContent']['Attachment'])):
						$row_three_class.=' has-attachment';
				endif;
				$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id']);
		?>
		<li class="<?php echo $path_class . $un_read_bg; ?> ">
			<div <?php echo $row_class;?> >
			<div class="message-index-outer-block cur <?php echo $is_read_class;?>">
				              <?php
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
				<div class="pull-left span <?php  echo $is_read_class;?> ">
						<span class="pull-left  js-star-place<?php echo $message['Message']['id']; ?>">
						  <a href="<?php echo $star_url; ?>" class="grayc no-pad cur <?php echo $star_class; ?> text-20 js-star {'message_id':'<?php echo $message['Message']['id']; ?>'} "><span class="hide">Star</span></a> 
						  </span>
					<span class="user-name-block c1">
						<?php
							if ($message['Message']['is_sender'] == 1) :
								echo __l('To: ') . $this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false);
							elseif ($message['Message']['is_sender'] == 2) :
								echo $this->Html->link(__l('Me   : ') , $view_url);
							else:
								echo $this->Html->cText($this->Html->truncate($message['OtherUser']['username']), false);
							endif;
						?>
					</span>
				</div>
				<div class="pull-left htruncate span8 <?php echo $row_three_class;?>">
					<div class="replied-message-block clearfix <?php if(!empty($message['Message']['parent_message_id'])): ?>replied-message<?php endif; ?>"> 
						<?php if(!empty($message['Contest']['ContestStatus']['name'])):?>
							<div class="status-block pull-left">
								<div class="status-block-inner">
									<span title ="<?php echo $message['Contest']['ContestStatus']['name']; ?>" class="<?php echo  $message['Contest']['ContestStatus']['slug'];?>"> &nbsp;</span>
								</div>
							</div>
						<?php endif;?>
						<span class="textb"><?php echo $this->Html->cText($message['Contest']['name']);?></span>
					</div>
				</div>
				<div class="pull-left">
					<span><?php echo $this->Html->truncate($message['MessageContent']['message'], Configure::read('messages.content_length'),'.....');?></span>
				</div>
					<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
				<div class="message-date-block pull-right crop js-timestamp <?php echo $is_read_class;?>" title ="<?php echo $time_format;?>">
					<?php echo $message['Message']['created'];?>
				</div>
			</div>
			</div>
			<div class="hide <?php echo $path_class;?>  js-message-view<?php echo $message['Message']['id']; ?>">
			<div class="clearfix message-list-block current-content <?php echo $path_class;?>">
				<?php if(!empty($message['Contest']['ContestStatus'])){?>
				<div class="message-contest-name pull-left clearfix">
					<?php if(!empty($message['Contest']['ContestStatus']['slug'])){ ?>
						<div class="status-block pull-left">
							<div class="status-block-inner">
								<span class="<?php echo $message['Contest']['ContestStatus']['slug'];?>" title="<?php echo $message['Contest']['ContestStatus']['slug'];?>">&nbsp;</span>
							</div>
						</div>
					<?php } ?>
					<div class="pull-left">
						<?php echo $this->Html->link($message['Contest']['name'], array('controller' => 'contests', 'action' => 'view', $message['Contest']['slug']),array('title' =>$message['Contest']['name']));?>
					</div>
				</div>
				<div class=" pull-right">
					<?php if (isset($message['Message']['is_auto']) && $message['Message']['is_auto'] != 1): ?>
						<?php echo $this->Html->link(__l('Message Board'), array('controller' => 'messages', 'action' => 'index', 'contest_id'=>$message['Contest']['id']),array('title' => __l('Message Board')));?>
					<?php else: ?>
						<?php echo $this->Html->link(__l('Activities'), array('controller' => 'messages', 'action' => 'activities', 'contest_id'=>$message['Contest']['id']),array('title' => __l('Activities')));?>
					<?php endif; ?>
				</div>
				<?php } ?>
			</div>
			<div class="current-content current-content-inner  <?php echo $path_class;?>">
				<div class="reply-info-block clearfix">
                        <?php echo $this->Html->CText($message['MessageContent']['message']);?>
				</div>
				<div class="clearfix pull-right reply-block js-reply-hide<?php echo $message['Message']['id'];?>">
						<?php 
							if(empty($message['Message']['contest_status_id']) && $this->Auth->user('id') != $message['Message']['other_user_id']){
								echo $this->Html->link(__l('Reply'), array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'], 'reply', 'user' => $message['OtherUser']['username'], 'contest_id' => $message['Contest']['id'], 'reply_type' => 'quickreply','root'=>$message['Message']['root'],'message_type'=>'inbox','m_path'=>$message['Message']['materialized_path']), array("class" => "pull-right reply-block js-link js-no-pjax {'container':'js-quickreply-" . $message['Message']['id'] . "','responsecontainer':'js-quickreplydiv-".$message['Message']['id']."'}", 'title' => __l('Reply')));
							}
						?>
				</div>
			</div>
		</div>
		<div class="multisupporteds hide <?php echo $path_class;?> js-quickrepy js-quickreply-<?php echo $message['Message']['id'];?>  <?php echo $path_class;?>">
			<div class="quick-replay1 clearfix">
				<div class="js-quickreplydiv-<?php echo $message['Message']['id'];?>"></div>
			</div>
		</div>
		</li>
	<?php
		endforeach;
	?>
	</ol>
<?php endif; ?>