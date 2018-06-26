<?php /* SVN: $Id: $ */ ?>
<div class="messages view">
<div class="main-content-block js-corner round-5">
<div class="mail-side-two">
	<?php
        echo $this->Form->create('Message', array('action' => 'move_to','class' => 'normal'));
        echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
        echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
        echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
    ?>
    <div class="mail-main-curve top-space">
			<h1>
			<?php
                if (!empty($is_starred)) :
                    echo $this->Html->link(__l('Back to Starred') , array('controller' => 'messages','action' => 'starred'));
                else :
                    echo $this->Html->link(__l('Back to ' . $back_link_msg) , array('controller' => 'messages','action' => $folder_type));
                endif;
            ?>
			</h1>
			<div class="message-block clearfix">
				<div class="message-block-left"  >
			<?php echo $this->Form->input('more_action_1', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action'));?>
			</div>
			<div class="message-block-right">
    			<?php
                    echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
                    echo $this->Form->submit(__l('Spam'), array('name' => 'data[Message][ReportSpam]'));
                    echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
                ?>
			</div>
        </div>
              <div class="mail-body js-corner round-5">

                    <?php
                    if (!empty($all_parents)) :
                        foreach($all_parents as $parent_message) : ?>
                        <div class="clearfix">
                        <div class="mail-sender-name">
                            <div class="view-star">
                            <?php
                                if ($parent_message['Message']['is_starred']) :
                                    $is_starred_class = "star";
                                else :
                                    $is_starred_class = "star-select";
                                endif;
                            ?>
                            <span class="<?php echo $is_starred_class; ?>">
                                <?php
                                if ($parent_message['Message']['is_starred']) :
                                    echo $this->Html->link(__l('Star') , array('controller' => 'messages','action' => 'star', $parent_message['Message']['id'],'star - select'
									) , array('class' => 'change-star-unstar'));
                                else :
                                    echo $this->Html->link(__l('star-select') , array('controller' => 'messages','action' => 'star',$parent_message['Message']['id'],'star') , array('class' => 'change-star-unstar'));
                                endif; ?>
            				</span>
    					 </div>

                        <span class="sender-name"><?php if ($parent_message['OtherUser']['email'] == $user_email) :
                                echo __l('me');
                            else :
                                echo $this->Html->cText($parent_message['OtherUser']['email']);
                            endif; ?>
                        </span>
                        to
                        <?php
                            if ($parent_message['User']['email'] == $user_email) :
                                echo __l('me');
                            else :
                                echo $this->Html->cText($parent_message['User']['email']);
                            endif; ?>
                        </div>
                        <div class="mail-date-time clearfix">
                        <p class=" <?php echo $parent_message['Message']['id'] ?>"><span class="js-show-mail-detail-span"><?php echo __l('show details'); ?></span>
						<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
                        <span class="sender-info"> <?php echo $this->Html->cDateTimeHighlight($parent_message['Message']['created']);?> (<span class ="js-timestamp" title="<?php echo $time_format;?>"><?php echo $parent_message['Message']['created']; ?></span>)</span></p>
                        </div>
                        </div>
                     <div class="mail-reply-button">
    					<?php
                            echo $this->Html->link($this->Html->image('reply-button.png') , array('controller' => 'messages', 'action' => 'compose',$parent_message['Message']['hash'],'reply') , null, array('inline' => false)); ?>
                        </div>
                        <div class="js-show-mail-detail-div" style="display:none;">
                            <p><span class="show-details-left"><?php
                                echo __l('from').': '; ?></span> <?php
                                echo __l($parent_message['OtherUser']['username']); ?> < <?php
                                echo $parent_message['OtherUser']['email']; ?> >
                            </p>
    						<p><span class="show-details-left">
                            <?php
                                echo __l('to').': '; ?></span> <?php
                                echo __l($parent_message['User']['username']); ?> < <?php
                                echo $parent_message['User']['email']; ?> >
                            </p>
                            <p><span class="show-details-left">
                            <?php
                                echo __l('date').': '; ?></span> <?php
                                echo $this->Html->cDateTimeHighlight($parent_message['Message']['created']);
                                echo __l('at').': ' . $this->Html->cDateTimeHighlight($parent_message['Message']['created']); ?>
                            </p>
    						<p><span class="show-details-left">
                            <?php
                                echo __l('subject').': '; ?> </span><?php
                                echo $this->Html->cText($parent_message['MessageContent']['subject']); ?>
                            </p>
                        </div>
                        <p><span class="c"><?php echo $this->Html->cHtml($parent_message['MessageContent']['message']); ?></span></p>
                    <?php
                        endforeach;
                    endif; ?>
                    <div class="clearfix">
                    <div class="mail-sender-name">
                    <div class="view-star">
                    <?php
                        $is_starred_class = "star";
                        if ($message['Message']['is_starred']) :
                            $is_starred_class = "star-select";
                        endif;
                        ?>
                        <span class="<?php echo $is_starred_class; ?>">
                            <?php
                                echo $this->Html->link(__l('Star') , array('controller' => 'messages','action' => 'star',$message['Message']['id'],$is_starred_class) , array('class' => 'change-star-unstar'));
                            ?>
    					</span>
                    </div>

				<?php if (($message['Message']['is_sender'] == 1) || ($message['Message']['is_sender'] == 2)) : ?>
                   <span class="sender-name"> <?php echo __l($message['User']['username']); ?> </span>
						<?php if (!empty($receiverNames)) :
                                echo __l('to'); ?> <?php echo __l($receiverNames);
                             endif; ?>
    					<?php
                        else :
                        ?>
                      <span class="sender-name">  <?php echo __l($message['OtherUser']['username']) ?></span>
    						<?php echo __l('to'); ?> <?php echo __l('me'); ?>, <?php echo $receiverNames; ?>
						<?php
                        endif; ?>
				</div>
					<?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
                <div class="mail-date-time">
                    <p class="<?php echo $message['Message']['id'] ?>"><span class="js-show-mail-detail-span"><?php echo __l('show details'); ?></span><span class="sender-info"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<span class ="js-timestamp" title="<?php echo $time_format;?>"><?php echo $message['Message']['created']; ?></span>)</span></p>
                </div>
                </div>
                <div class="mail-reply-button"><?php
                    echo $this->Html->link($this->Html->image('reply-button.png') , array('controller' => 'messages', 'action' => 'compose', $message['Message']['hash'],'reply') , null, array('inline' => false)); ?>
                </div>
                <div class="mail-content-curve-middle">
			   <div class="js-show-mail-detail-div" style="display:none;">
				<?php
                    if ($message['Message']['is_sender'] == 0) : ?>
                    	<p><span class="show-details-left"><?php echo __l('from').': ';  ?></span> <?php echo __l($message['OtherUser']['username']); ?> < <?php echo $message['OtherUser']['email']; ?> ></p>
                    <?php
                    else : ?>
                    	<p><span class="show-details-left"><?php echo __l('from').': ';  ?></span> <?php echo __l($message['User']['username']); ?> < <?php echo $message['User']['email']; ?> ></p>
        			<?php
                    endif; ?>
    				<p><span class="show-details-left"><?php echo __l('to').': ';  ?></span><?php echo __l($show_detail_to); ?></p>
					<p><span class="show-details-left"><?php echo __l('date').': ';  ?></span><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); echo __l('at') . $this->Html->cDateTimeHighlight($message['Message']['created']); ?> </p>
					<p><span class="show-details-left"><?php echo __l('subject').': ';  ?></span><?php echo $this->Html->cText($message['MessageContent']['subject']); ?> </p>
				</div>
                <p><?php  echo $this->Html->cHtml($message['MessageContent']['message']); ?></p>
				<p class="replay-forward-links">
				<?php
                    echo $this->Html->link(__l("Reply") , array('controller' => 'messages','action' => 'compose',$message['Message']['hash'],'reply') , null, array('inline' => false));
                    echo $this->Html->link(__l("Forward") , array('controller' => 'messages', 'action' => 'compose', $message['Message']['hash'],'forword') , null, null, true);
                ?>
				</p>
                <div class="download-block">
                <?php
                if (!empty($message['MessageContent']['Attachment'])) :
					?>
					<h4><?php echo count($message['MessageContent']['Attachment']).' '. __l('attachments');?></h4>
					<ul>
					<?php
                    foreach($message['MessageContent']['Attachment'] as $attachment) :
                ?>
					<li>
                	<span class="attachement"><?php echo $attachment['filename']; ?></span>
                	<span><?php echo bytes_to_higher($attachment['filesize']); ?></span>
                    <span><?php echo $this->Html->link(__l('Download') , array( 'action' => 'download', $message['Message']['hash'], $attachment['id'])); ?></span>
					</li>
                <?php
                    endforeach;
				?>
				</ul>
				<?php
                endif;
                ?>
                </div>
            </div>
       </div>
<span class="back-to-inbox">
    <?php
    if (!empty($is_starred)) :
        echo $this->Html->link('Back to Starred', array('controller' => 'messages','action' => 'starred'));
    else :
        echo $this->Html->link(__l('Back to ' . $back_link_msg) , array(
            'controller' => 'messages',
            'action' => $folder_type
        ));
    endif;
    ?>
</span>

        <div class="message-block clearfix">
        <div class="message-block-left" >
			<?php
            echo $this->Form->input('more_action_2', array('type' => 'select','options' => $mail_options,'label' => false,'class' => 'js-apply-message-action2' ));
            ?>
			</div>

        <div class="message-block-right">
        <?php
            echo $this->Form->submit(__l('Archive'), array('name' => 'data[Message][Archive]'));
            echo $this->Form->submit(__l('Spam'), array( 'name' => 'data[Message][ReportSpam]'));
            echo $this->Form->submit(__l('Delete'), array('name' => 'data[Message][Delete]'));
        ?>
        </div>
        </div>
	          
     </div>
	<?php echo $this->Form->end();
?>
</div>
</div>
</div>