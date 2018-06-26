<?php
  if(!empty($this->request->params['named']['type'])) {
    $type = $this->request->params['named']['type'];
  } else {
    $type = 'user_messages';
  }
?>
<div class="messages index js-response js-responses">
<section class="top-space clearfix">
<div class="row top-space">
<div class="hor-smspace clearfix">
	  <div class="sep-bot grayc">
			<?php
			if(!empty($view)) {
				echo $this->Form->create('Message' , array('action' => 'admin_activities/' . $view, 'type' => 'post', 'class' => 'normal no-mar clearfix '));
			} else {
					echo $this->Form->create('Message' , array('action' => 'admin_activities', 'type' => 'list', 'class' => 'normal clearfix no-mar ')); //js-ajax-form
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
			<div class="pull-left hor-mspace">
            	<?php
            	echo $this->Form->autocomplete('Message.username', array('label' => False,'placeholder' => 'User', 'acFieldKey' => 'Message.user_id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255', 'class' => 'input-medium ver-smspace search-query span4'));
            	?>
           		<div class="autocompleteblock"></div>
            </div>

            <div class="pull-left hor-mspace">
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
<div class="row-fluid">
<?php echo $this->Form->create('Message' , array('class' => 'js-shift-click js-no-pjax','action' => 'update')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section class="space">
<table class="table table-striped table-bordered table-condensed table-hover">
  <?php
    if (!empty($messages)) {
      foreach ($messages as $message):
?>
  <tr>
    <td>
		<div class="span clearfix grayc hor-mspace">
			<div class="pull-left admin-activities">
			<?php
				  echo $this->Html->displayActivities($message);
				  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
			?>
			<span class="js-timestamp" title="<?php echo $time_format;?>"><?php echo $message['Message']['created']; ?></span>
			</div>
			
		</div>
	</td>
  </tr>
  <?php
      endforeach;
    } else {
  ?>
  <tr>
    <td>
      <div class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo __l('No activities found');?></p>
	</td>
  </tr>
  <?php }  ?>
</table>
</section>
<section class="clearfix hor-mspace bot-space">
<?php
if (!empty($messages)):
    ?>
<div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
</section>
<?php
endif;
echo $this->Form->end();
?>
</div>
</div>
<div class="modal hide fade" id="js-ajax-modal">
  <div class="modal-header">
    <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h2><?php echo __l('Message'); ?></h2>
  </div>
  <div class="modal-body"></div>
  <div class="modal-footer">
    <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
  </div>
</div>