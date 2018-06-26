<div class="js-response">
<div class="top-pattern">
  <div class="container-fluid space">
    <ul class="row no-mar mob-c unstyled top-mspace">
		<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Suspend) ? 'pinkc' : 'grayc';
			$action = (!empty($view))?'index/' . $view : 'index';
		?>
		<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Suspend) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar">
			<?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important span1 dc space show"><i class="icon-ban-circle no-pad text-24 whitec"></i></span> <span class="show '.$class.'">' .__l('Suspended') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($suspended, false).'</span>', array('controller' => 'messages', 'action' => $action, 'filter_id' => ConstMoreAction::Suspend), array('title' => __l('Suspended'), 'escape' => false, 'class'=>"blackc"));?>
		</li>
			<?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Flagged) ? 'pinkc' : 'grayc'; ?>
			<?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstMoreAction::Flagged) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar">
			<?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important span1 dc space show"><i class="icon-flag no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">' . __l('System Flagged') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($system_flagged, false).'</span>', array('controller' => 'messages', 'action' => $action, 'filter_id' => ConstMoreAction::Flagged), array('title' => __l('System Flagged'), 'escape' => false, 'class'=>"blackc"));?>	
		</li>
		<?php $class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'grayc'; ?>
		<?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
		<li class="span dc no-mar">
          <?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important span1 dc space show"><i class="icon-sitemap no-pad text-24 whitec"></i></span> <span class="show  '.$class.'">' . __l('Total') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($all, false).'</span>', array('controller' => 'messages', 'action' => $action), array('title' => __l('Total'), 'escape' => false, 'class'=>"blackc"));?></li>
	</ul>
  </div>
</div>
<div class="hor-space">
<section class="top-space clearfix">
<div class="row top-space">
<div class="hor-smspace clearfix">
	  <div class="sep-bot grayc">
			<?php
			if(!empty($view)) {
				echo $this->Form->create('Message' , array('action' => 'admin_index/' . $view, 'type' => 'post', 'class' => 'normal no-mar clearfix '));
			} else {
					echo $this->Form->create('Message' , array('action' => 'admin_index', 'type' => 'post', 'class' => 'normal clearfix no-mar ')); //js-ajax-form
					}
					echo $this->Form->input('filter_id', array('type' =>'hidden'));
		?>
		<div class="hor-mspace hor-space">
		<div class="clearfix  pull-left message-date-picker">
				<div class="input date-time  clearfix ver-space ">
					<div class="js-boostarp-datetime">
          			<div class="js-cake-date ">
						<?php echo $this->Form->input('from_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'),'label' => __l('From'))); ?>
					</div>
					</div>
				</div>
				<div class="input date-time clearfix ver-space ">
				<div class="js-boostarp-datetime">
          		<div class="js-cake-date">
						<?php echo $this->Form->input('to_date', array('orderYear' => 'asc', 'type' => 'date', 'minYear' => date('Y')-5, 'maxYear' => date('Y') + 10, 'div' => false, 'empty' => __l('Please Select'),'label' => __l('To'))); ?>
					</div>
					</div>
				</div>
				</div>
			<div class="mapblock-info pull-left hor-mspace">
            	<?php
            	echo $this->Form->autocomplete('Message.username', array('label' => False,'placeholder' => 'From', 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'input-medium ver-smspace search-query span4'));
            	?>
           		<div class="autocompleteblock"></div>
            </div>
			
			
            <div class="mapblock-info pull-left hor-mspace">
            		<?php
            			echo $this->Form->autocomplete('Message.other_username', array('label' =>False,'placeholder' => 'To', 'acFieldKey' => 'Message.other_user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'input-medium ver-smspace search-query span4'));
            		?>
					<div class="autocompleteblock"></div>
            </div>
            
            
            <div class="mapblock-info pull-left hor-mspace">
            		<?php
            			echo $this->Form->autocomplete('Contest.name', array('label' => False,'placeholder' => 'Contest', 'acFieldKey' => 'Contest.id', 'acFields' => array('Contest.name'), 'acSearchFieldNames' => array('Contest.name'), 'maxlength' => '255', 'class' => 'input-medium ver-smspace search-query span4'));
            		?>
            		<div class="autocompleteblock"></div>
            </div>
            
			<div class="pull-left ver-smspace hor-space">
            <button type="submit" class="btn btn-success textb">Filter</button>
			</div>
			</div>
			    <?php 
    echo $this->Form->end();
    ?>
	</div>
	<div class="pull-left space grayc">
			 <?php echo $this->element('paging_counter'); ?>
		</div> 
	</div>
</section>
<div class="tab-pane active in no-mar" id="learning">
<?php echo $this->Form->create('Message' , array('class' => 'normal','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <table class="table table-striped table-hover">
    <thead class="yellow-bg">
      <tr class="sep-top sep-bot">
		<th class="sep-right dc sep-left"><?php echo __l('Select');?></th>
		<th class="sep-right dc"><?php echo __l('Action');?></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('MessageContent.message', __l('Message')); ?></div></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.name', __l('Contest')); ?></div></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('From')); ?></div></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('OtherUser.username', __l('To')); ?></div></th>
		<th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Message.created', __l('Date')); ?></div></th>
	  </tr>
	</thead>
	<tbody>
<?php
if (!empty($messages)) :
$i = 0;
foreach($messages as $message):
   // if empty subject, showing with (no suject) as subject as like in gmail
    if (!$message['MessageContent']['subject']) :
		$message['MessageContent']['subject'] = '(no subject)';
    endif;
	
	$message_class = "checkbox-message ";
	$row_class='';
	$is_read_class = "";
	
    if ($message['Message']['is_read']) :
        $message_class .= "js-checkbox-active";
    else :
        $message_class .= "js-checkbox-inactive";
        $is_read_class .= "unread-message-bold";
        $row_class=$row_class.' unread-row';
    endif;
	
	$row_three_class='w-three';
	 if (!empty($message['MessageContent']['Attachment'])):
			$row_three_class.=' has-attachment';
	endif;
	
	if($message['MessageContent']['admin_suspend']):
		$message_class.= ' js-checkbox-suspended';
	else:
		$message_class.= ' js-checkbox-unsuspended';
	endif;
	if($message['MessageContent']['is_system_flagged']):
		$message_class.= ' js-checkbox-flagged';
	else:
		$message_class.= ' js-checkbox-unflagged';
	endif;
	
		$view_url=array('controller' => 'messages','action' => 'v',$message['Message']['id'], 'admin' => false);
?>
    <tr>
	  <td class="dc span1">
			<?php echo $this->Form->input('Message.'.$message['MessageContent']['id'], array('type' => 'checkbox', 'id' => 'admin_checkbox_'.$message['Message']['id'], 'label' => false, 'class' => $message_class.' js-checkbox-list'));?>
		</td>
		
		<td class="dc span1">
		<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
		<?php $from = !empty($this->request->params['pass'][0])?$this->request->params['pass'][0]:''; ?>
            <ul class="dropdown-menu dl arrow">
			 <?php if($message['MessageContent']['admin_suspend']):?>
				<li><?php echo $this->Html->link('<i class="icon-plus-sign blackc"></i>' . __l('Unsuspend Message'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'unsuspend', 'from' => $from), array('class' => 'unsuspend js-confirm js-no-pjax', 'title' => __l('Unsuspend Message'),'escape' => false));?>
				</li>
			<?php else:?>
				<li><?php echo $this->Html->link('<i class="icon-minus-sign blackc"></i>' . __l('Suspend Message'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'suspend', 'from' => $from), array('class' => 'suspend js-confirm js-no-pjax', 'title' => __l('Suspend Message'),'escape' => false));?>
				</li>
			<?php endif;?>
			<?php 
				if($message['MessageContent']['is_system_flagged']):
					echo '<li>'.$this->Html->link('<i class="icon-remove blackc"></i>' . __l('Clear flag'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'deactivate', 'from' => $from), array('class' => 'clear-flag js-confirm js-no-pjax', 'title' => __l('Clear flag'),'escape' => false)).'</li>';
				else:
					echo '<li>'.$this->Html->link('<i class="icon-flag blackc"></i>' . __l('Flag'), array('action' => 'update_status', $message['MessageContent']['id'], 'flag' => 'active', 'from' => $from), array('class' => ' flag js-confirm js-no-pjax', 'title' => __l('Flag'),'escape' => false)).'</li>';
				endif;
			?>
			</ul>
          </div>
		</td>
        <td>
		<div class="status-block">
			<?php echo $this->Html->link($this->Html->truncate($this->Html->cText($message['MessageContent']['message'], false),Configure::read('messages.content_length'),'...') , $view_url, array('data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'class' => 'js-no-pjax', 'escape'=> false,'title' => __l('Message'))); ?>
			 <?php if($message['MessageContent']['admin_suspend']):
   					echo '<div class="clearfix top-smspace"><span class="label pull-left suspended" title="'.__l('Suspended').'">'.__l('Suspended').'</span></div>';
			endif;
  			if($message['MessageContent']['is_system_flagged']):
  				echo '<div class="clearfix top-smspace"><span class="label pull-left system-flagged" title="'.__l('System Flagged').'">'.__l('System Flagged').'</span></div>';
  			endif; ?>
		</div>
        </td>
		<td>
		<div class="status-block"> <div class="status-block-inner">
		  <?php if (!empty($message['Contest']['name'])): ?>
			<?php if(!empty($message['Contest']['ContestStatus']['name'])){ ?>
                <span class="<?php echo $message['Contest']['ContestStatus']['slug'];?>" title="<?php echo $message['Contest']['ContestStatus']['name'];?>">
                     <?php echo  $this->Html->cText($message['Contest']['ContestStatus']['name']);?>
                </span>
            <?php } else {?>
                <span class="inactive">
                    <?php echo __l('Inactive');?>
                </span>
            <?php } ?>
			</div>
			<?php
					echo $this->Html->link($message['Contest']['name'], array('controller' => 'contests', 'action' => 'view', $message['Contest']['slug'], 'admin' => false), array('title' => $this->Html->cText($message['Contest']['name'], false), 'escape' => false));
			?>
			<?php else: ?>
				<?php echo '-'; ?>
			<?php endif; ?>
			</div>
		</td>
		<td class="<?php  echo $is_read_class;?>">
				<?php echo $this->Html->getUserAvatarLink($message['User'], 'micro_thumb',true); ?>
				<?php echo $this->Html->getUserLink($message['User']); ?>
        </td>
		<td class=" <?php  echo $is_read_class;?>">
			<?php if(!empty($message['OtherUser']['id'])){
				echo $this->Html->getUserAvatarLink($message['OtherUser'], 'micro_thumb',true); echo " ";
				echo $this->Html->getUserLink($message['OtherUser']); 
			} else{
				echo __l('All');
			}?>
        </td>
		<td  class="<?php echo $is_read_class;?> dc"><?php echo $this->Html->cDateTimeHighlight($message['Message']['created']);?></td>
    </tr>
<?php
    endforeach;
else :
?>
<tr>
    <td colspan="8" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('messages')) ?></td>
</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($messages)):?>
<section class="clearfix">
<div class="span top-mspace pull-left">
		<span class="grayc"><?php echo __l('Select:'); ?></span>
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
			<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			<?php echo $this->Html->link(__l('Flagged'), '#', array('class' => 'hor-mspace js-admin-select-flagged', 'title' => __l('Flagged'))); ?>
			<?php echo $this->Html->link(__l('Unflagged'), '#', array('class' => 'js-admin-select-unflagged', 'title' => __l('Unflagged'))); ?>
			<?php echo $this->Html->link(__l('Suspended'), '#', array('class' => 'hor-mspace js-admin-select-suspended', 'title' => __l('Suspended'))); ?>
			<?php echo $this->Html->link(__l('Unsuspended'), '#', array('class' => 'js-admin-select-unsuspended', 'title' => __l('Unsuspended'))); ?>
    	<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit hor-mspace', 'label' => false, 'div' => false,'empty' => __l('-- More actions --'))); ?>
        </span>
      </div>
      <div class="span top-mspace pull-right">
        <div class="pull-right">
          <?php echo $this->element('paging_links'); ?>
        </div>
      </div>
	  </section>
		<div class="hide">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
    <?php endif;
    echo $this->Form->end();
    ?>
  </div>
</div>
<div class="modal hide fade" id="js-ajax-modal">
	<div class="modal-body"></div>
	<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
</div>