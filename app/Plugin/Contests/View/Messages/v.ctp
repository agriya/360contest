<?php /* SVN: $Id: $ */ ?>

<div class="main-section js-corner round-5">
	<div class="mail-side-two">
		<?php
			echo $this->Form->create('Message', array('action' => 'move_to','class' => 'normal'));
			echo $this->Form->hidden('folder_type', array('value' => $folder_type,'name' => 'data[Message][folder_type]'));
			echo $this->Form->hidden('is_starred', array('value' => $is_starred,'name' => 'data[Message][is_starred]'));
			echo $this->Form->hidden("Message.Id." . $message['Message']['id'], array('value' => '1'));
		?>
    <div class="mail-main-curve top-space">
	 <?php if ($this->Auth->user('role_id') != ConstUserTypes::Admin) { ?>
		<div class="top-space clearfix">
			<div class="clearfix top-spce bot-space">
                <div class="cancel-block compose-button btn">
                    <?php
                       if (!empty($is_starred)) :
                       echo $this->Html->link(__l('Back to Starred') , array('controller' => 'messages','action' => 'starred'));
                       else :
                       echo $this->Html->link(__l('Back to ' . $back_link_msg) , array('controller' => 'messages','action' => $folder_type));
                       endif;
                    ?>
                 </div>
            </div>
    	</div>
		<?php }?>
         <div class="mail-body js-corner round-5">
				<?php 
                    if (!empty($all_parents)) :
                        foreach($all_parents as $parent_message) : ;?>
						<?php if($this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
                        <div class="send-info-block">
                        <div class="mail-sender-name pull-left">

                            <?php
								if($parent_message['Message']['is_starred']) {
									$star = 'unstar';
									$star_class = 'icon-star';
								} else {
									$star = 'star';
									$star_class = 'icon-star-empty';
								}
								$star_url = Router::url(array(
									'controller' => 'messages',
									'action' => 'star',
									$parent_message['Message']['id'],
									$star
								) , true);
                            ?>
						  <span class="pull-left  js-star-place<?php echo $parent_message['Message']['id']; ?>">
						  <a href="<?php echo $star_url; ?>" class="grayc no-pad cur <?php echo $star_class; ?> text-20 js-star {'message_id':'<?php echo $parent_message['Message']['id']; ?>'} "><span class="hide">Star</span></a> 
						  </span>
                        </div>
                        </div>
						<?php endif; ?>
                        <div class="js-show-mail-detail-div">
                        <div class="clearfix">
                            <p class="pull-left hor-mspace"><span class="show-details-left"></span> <?php
                                echo $this->Html->getUserLink($parent_message['OtherUser']); ?> 
                            <span class="to-address">
                                   <?php echo __l('to').' ';?><?php
			                  echo $this->Html->getUserLink($parent_message['User']); ?></span>
                                
                            </p>
                             <p class="pull-right to-address"> <?php
                                
                                echo ' '. __l('at').': ' . $this->Html->cDateTimeHighlight($parent_message['Message']['created']); ?>
                            </p>
                             <p><span class="show-details-left">
                            <?php
								if(!empty($parent_message['MessageContent']['subject'])){
									echo __l('subject').': '; ?> </span><?php
									echo $this->Html->cText($parent_message['MessageContent']['subject']); 
								}?>
                            </p>
                        </div>
                        </div>
               			<div class="well clearfix">
						<span class="c"><?php echo $this->Html->cHtml($parent_message['MessageContent']['message']); ?></span>
						</div>
                    <?php
                        endforeach;
                    endif; ?>
			     <div class="js-show-mail-detail-div show-mail clearfix">
					 <div>
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
						<?php if ($this->Auth->user('role_id') != ConstUserTypes::Admin) { ?>

						  <span class="pull-left  js-star-place<?php echo $message['Message']['id']; ?>">
						  <a href="<?php echo $star_url; ?>" class="grayc no-pad cur <?php echo $star_class; ?> text-20 js-star {'message_id':'<?php echo $message['Message']['id']; ?>'} "><span class="hide">Star</span></a> 
						  </span>
						<?php }?>
				 <?php if(!empty($message['MessageContent']['subject'])){?>
				 <h3 class="subject pull-left left-space"><?php echo $this->Html->cText($message['MessageContent']['subject']); ?></h3>
				 <?php } ?>
				 </div>
				 <div class="clearfix">
					 <p class="pull-left hor-mspace">
				<?php 
                    if ($message['Message']['is_sender'] == 0) : 
						$show_detail_to = $message['User'];?>
						<span class="show-details-left"><?php echo $this->Html->getUserLink($message['OtherUser']); ?></span>
                    <?php
                    else : 
						$show_detail_to = $message['OtherUser'];?>
						<span class="show-details-left"><?php echo $this->Html->getUserLink($message['User']); ?></span>
        			<?php 
                    endif; 
					if($message['Message']['other_user_id'] == 0){
						$show_detail_to = __l('All');
					} ?>
      				<span class="to-address"><?php echo __l('to');?> <?php echo $this->Html->getUserLink($show_detail_to); ?></span>
					 </p>
					 <?php  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created'])); ?>
					 <p class="to-address pull-right js-timestamp" title="<?php echo $time_format; ?>"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']); ?> (<?php echo $message['Message']['created']; ?>)</p>
				 </div>
				<div class="well">
					<?php echo nl2br($this->Html->cHtml($message['MessageContent']['message']));?>
				</div>
				<?php if(!empty($message['Message']['contest_id'])) {?>
				   <p class="clearfix">
                           <span class="pull-left">
                            <?php echo __l('Contest').': ';  ?></span>
                            <span class="hor-smspace"><?php echo $this->Html->link($this->Html->cText($message['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $message['Contest']['slug']), array('escape'=>false, 'title' => $this->Html->cText($message['Contest']['name'], false)));?>
                               </span>
                        </p>
				<?php } ?>	
				</div>
				<?php if(empty($message['Message']['contest_id']) || (!empty($message['Message']['contest_id']) && empty($message['Message']['contest_status_id']))) {?>
				<div class="clearfix message-button">
    				<div class="cancel-block compose-button">
        				<?php 
						echo $this->Html->link(__l('Reply'), array('controller' => 'messages', 'action' => 'compose', $message['Message']['id'], 'reply', 'user' => $message['OtherUser']['username'], 'contest_id' => $message['Contest']['id'], 'reply_type' => 'quickreply','root'=>$message['Message']['root'],'message_type'=>'inbox','m_path'=>$message['Message']['materialized_path']), array('title' => __l('Reply')));?>
                    </div>
				</div>
                <?php }
                ?>
       </div>
	   <?php if ($this->Auth->user('role_id') != ConstUserTypes::Admin) { ?>
        <div class="clearfix">
        	<div class="clearfix btn pull-right">
        		<div class="cancel-block compose-button ">
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
				</div>
			</div>
		</div>
		<?php }?>
     </div>
	<?php echo $this->Form->end(); ?>
</div>
</div>

