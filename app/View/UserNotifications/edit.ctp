<?php /* SVN: $Id: $ */ ?>
<?php echo $this->Form->create('UserNotification', array('action' => 'edit', 'class' => 'normal'));?>
<div class="clearfix">
	<h2 class="ver-space ver-mspace span"><?php echo __l('Email Settings');?></h2>
	  <div class="ver-space">
		<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
	  </div>
</div>
	<?php
		if($this->Auth->user('role_id') == ConstUserTypes::Admin):
			echo $this->Form->input('id');
		endif;
	?>
	<table class="table table-striped table-hover sep">
		<tr>
				<th class="dl"><?php echo Configure::read('contest.participant_alt_name_singular_caps');?></th>
				<th class="dl"><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps');?></th>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_contest_canceled_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when a participated contest canceled')));?></td>
		   <td class="dl"><?php echo $this->Form->input('is_new_contest_entry_alert_to_contestholder', array('type'=>'checkbox','label' => __l('Send notification when a new entry posted to your contest')));?></td>
		</tr>
		<tr>
		     <td class="dl"><?php echo $this->Form->input('is_winner_selected_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when your entry was selected as won')));?></td>
			 <td class="dl"><?php echo $this->Form->input('is_request_refund_reject_alert_to_contestholder', array('type'=>'checkbox','label' => sprintf(__l('Send notification when request refund is asked by %s'), Configure::read('contest.participant_alt_name_plural_small'))));?></td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_contest_completed_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when a participated contest completed')));?></td>
           <td class="dl"><?php echo $this->Form->input('is_payment_pending_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when your contest is inactive due to pending payment')));?></td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_contest_amount_paid_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when you received prize amount for a contest')));?></td>
    	   <td class="dl"><?php echo $this->Form->input('is_activity_alert_to_contestholder', array('type'=>'checkbox','label' => __l('Send notification when a new activity posted to your projecrt')));?></td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_entry_eliminated_alert_to_participant', array('type'=>'checkbox','label' => sprintf(__l('Send notification when your entry was eliminated'))));?></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_entry_withdrawn_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when you withdrawn your entry')));?></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_entry_lost_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when your entry was lost')));?></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_entry_deleted_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when your entry was deleted')));?></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_cancel_withdraw_entry_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when cancel a withdrawn entry')));?></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		   <td class="dl"><?php echo $this->Form->input('is_eliminate_entry_cancel_alert_to_participant', array('type'=>'checkbox','label' => __l('Send notification when cancel an eliminated entry')));?></td>
		    <td>&nbsp;</td>
		</tr>
		<tr>
		   <td class="dl" colspan ="2"><?php echo $this->Form->input('is_notification_for_new_message', array('type'=>'checkbox','label' => __l('Send notification when you have contacted by other users')));?></td>
		</tr>
		<tr>
		   <td class="dl" colspan ="2"><?php echo $this->Form->input('is_contest_created_alert_to_participant', array('type'=>'checkbox','label' => sprintf(__l('Send notification whenever new contest posted'))));?></td>
		</tr>
		</table>
 	<div class="submit-block setting-submit-block clearfix span24 dc">
			<?php echo $this->Form->submit(__l('Update'));?>
		</div>
			<?php echo $this->Form->end();?>