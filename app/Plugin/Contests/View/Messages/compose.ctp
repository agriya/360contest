<div class="messages index">
<?php
// Compose message block of contest user view page
if(!empty($this->request->params['named']['contest_type'])){ ?>

		<h3 class="graylight sep-bot bot-space"><?php echo __l('Post Comment') ;?></h3><?php
		$redirect = Router::url(array('controller'=>'contest_users','action'=>'view',$contest['Contest']['slug'],'entry'=>$this->request->params['named']['contest_type']),true);
		echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'compose hor-space normal  top-space top-mspace', 'enctype' => 'multipart/form-data'));
		 ?>
			<?php
					echo $this->Form->input('contest_id', array('type' => 'hidden','value'=>$this->request->params['named']['contest_id']));
					if(!empty($contest['Contest']['user_id']) && ($contest['Contest']['user_id']==$this->Auth->user('id'))){
						echo $this->Form->input('to', array('options' => $select_array, 'label'=>false));
					}else{
						echo $this->Form->input('to', array('type' => 'hidden'));
					}
					echo $this->Form->input('message_type', array('type' => 'hidden','value'=>'1'));
					echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
					echo $this->Form->input('type', array('type' => 'hidden'));
					echo $this->Form->input('message', array('type' => 'textarea', 'class'=>" js-show-submit-block span9 no-pad no-round", 'label'=>false));
					echo $this->Form->input('root', array('type' => 'hidden'));
					echo $this->Form->input('m_path', array('type' => 'hidden'));
					echo $this->Form->input('redirect_url', array('type' => 'hidden','value'=>$redirect));
				?>
		<div class="clearfix ">
		<div class="js-add-block hide">
			<?php
          		if(!empty($contest['Contest']['user_id']) && ($contest['Contest']['user_id']==$this->Auth->user('id'))){
          				echo $this->Form->input('is_private', array('type' => 'hidden'));
					}else{?>
				
						<?php echo $this->Form->input('is_private', array('label'=>__l('Private')));?>
					<?php }
				?>
				<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Send'), array('class' => 'js-without-subject span')); ?>
		</div>
		</div>
		<?php echo $this->Form->end(); ?>
		<?php
}
elseif(empty($this->request->params['named'])){ ?>
	<h2 class="title"><?php echo __l('Post Comment') ;?></h2><?php
		$redirect = Router::url(array('controller'=>'messages','action'=>'index'),true);
		echo $this->Form->create('Message', array('action' => 'compose', 'class' => ' normal hor-space', 'enctype' => 'multipart/form-data'));
		 ?>

				<?php
					echo $this->Form->input('to', array('type' => 'hidden'));
					echo $this->Form->input('message_type', array('type' => 'hidden','value'=>'1'));
					echo $this->Form->input('type', array('type' => 'hidden'));
					echo $this->Form->autocomplete('to', array('type' => 'text', 'id' => 'message-to', 'acFieldKey' => 'User.id', 'acFields' => array('User.username'), 'acSearchFieldNames' => array('User.username'), 'maxlength' => '255'));
					echo $this->Form->input('message', array('type' => 'textarea', 'class'=>" js-show-submit-block span18 no-pad no-round", 'label'=>false));
					echo $this->Form->input('root', array('type' => 'hidden'));
					echo $this->Form->input('is_private', array('type' => 'hidden','value'=>'1'));
					echo $this->Form->input('redirect_url', array('type' => 'hidden','value'=>$redirect));
				?>

		<div class="submit-block clearfix js-add-block hide">
			<div class="span">
			<?php echo $this->Form->submit(__l('Send'), array('class' => 'js-without-subject span')); ?></div>
			<div class="cancel-block span top-smspace hor-space"><?php echo $this->Html->link(__l('Cancel'), array('controller' => 'messages', 'action' => 'index') , array('title' => __l('Cancel'), 'class' => 'span')); ?></div>
		</div>
		<?php echo $this->Form->end(); ?>
		<?php
}
else{
	if(!empty($contest['Contest']['slug'])){
		$redirect = Router::url(array('controller'=>'contests','action'=>'view',$contest['Contest']['slug']),true);
	}else{
		$redirect = Router::url(array('controller'=>'messages','action'=>'index'),true);
	}
	$message_class='js-add-block hide';
	if(empty($this->request->params['isAjax']) && empty($this->request->params['named']['contet_user_id'])):
		if(!empty($this->request->params['named']['reply_type']) && $this->request->params['named']['reply_type']=="quickreply" && empty($this->request->params['isAjax'])){ ?>
			<h2 class="title"><?php echo __l('Post Comment') . ' - ' . __l('Reply') ;?></h2>
		<?php }
		else{
		?>
    	<h3 class="graylight sep-bot bot-space"><?php echo __l('Post Comment') ;?></h3>
	<?php } endif; ?>
	<div class="js-colorbox-response top-space">
	<?php
	if(!empty($this->request->params['named']['reply_type'])and $this->request->params['named']['reply_type']=="quickreply"){?>
	<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'normal hor-space compose {"redirect_url":"'.$redirect.'"}', 'enctype' => 'multipart/form-data'));
	echo $this->Form->input('quickreply', array('type' => 'hidden','value'=>'quickreply'));
	echo $this->Form->input('entry', array('type' => 'hidden','value'=>(!empty($this->request->params['named']['entry']))?$this->request->params['named']['entry']:''));
	echo $this->Form->input('page', array('type' => 'hidden','value'=>(!empty($this->request->params['named']['page']))?$this->request->params['named']['page']:''));
	?>
	<?php }else{
	if(!empty($contest['Contest']['slug'])){
		$redirect = Router::url(array('controller'=>'contests','action'=>'view',$contest['Contest']['slug']),true);
	}else{
		$redirect = Router::url(array('controller'=>'messages','action'=>'index'),true);
	}
	?>

	<?php
	   echo $this->Form->create('Message', array('action' => 'compose', 'class' => ' normal hor-space compose message-compose {"redirect_url":"'.$redirect.'"}', 'enctype' => 'multipart/form-data'));
	?>
	<?php }?>

				<?php
					if(!empty($this->request->params['named']['reply_type']) && $this->request->params['named']['reply_type']=="quickreply" && empty($this->request->params['isAjax'])) { ?>
					<div class="clearfix input">
						<span class="span5  from-left omega alpha">
						   <?php 	echo __l('To:'); ?>
						</span>
						  <span class="span10 omega alpha">
								<?php echo !empty($this->request->data['Message']['to']) ? $this->Html->link($this->Html->cText($this->request->data['Message']['to']), array('controller'=> 'users', 'action' => 'view', $this->request->data['Message']['to']), array('title' => $this->Html->cText($this->request->data['Message']['to'],false),'escape' => false)) : ''; ?>
						</span>
					</div>
					<?php if(!empty($contest['Contest']['name'])){?>
					<div class="clearfix input">
						<span class="span5  from-left omega alpha">
						   <?php 	echo __l('Contest:'); ?>
						</span>
						  <span class="span10 omega alpha">
								<?php echo !empty($contest['Contest']['name']) ? $this->Html->link($this->Html->cText($contest['Contest']['name']), array('controller'=> 'contests', 'action' => 'view', $contest['Contest']['slug']), array('title' => $this->Html->cText($contest['Contest']['name'],false),'escape' => false)) : ''; ?>
						</span>
					</div>
					<?php } ?>
					<div class="clearfix input">
						<span class="span5  from-left omega alpha">
						   <?php 	echo __l('Message:'); ?>
						</span>
						  <span class="span10 omega alpha">
								<?php echo $this->request->data['Message']['message_reply']; ?>
						</span>
					</div>
					<?php }
				echo $this->Form->input('contest_id', array('type' => 'hidden'));
				echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
				echo $this->Form->input('type', array('type' => 'hidden'));
				if(!empty($this->request->params['named']['type'])):
					echo $this->Form->input('contest_status_id', array('type' => 'hidden','value'=>ConstMessageType::Conversation));
				endif;
				if(!empty($this->request->params['named']['contest_user_id'])):
					echo $this->Form->input('contest_user_id', array('type' => 'hidden','value'=>$this->request->params['named']['contest_user_id']));
					echo $this->Form->input('contest_status_id', array('type' => 'hidden','value'=>ConstMessageType::Conversation));
				endif;
				?>
				<?php
				if(!empty($contest['Contest']['user_id']) && ($contest['Contest']['user_id']==$this->Auth->user('id') && empty($this->request->params['named']['reply_type'])))
				{
					echo $this->Form->input('to', array('label' => false , 'options' => $select_array));
					echo $this->Form->input('message', array('type' => 'textarea', 'class'=>" js-show-submit-block span24 no-pad no-round", 'label'=>false));
				}
				else
				{
					
					echo $this->Form->input('to', array('type' => 'hidden'));
					if(!empty($this->request->params['named']['entry'])){
						echo $this->Form->input('message', array('type' => 'textarea', 'class'=>" js-show-submit-block span9 no-pad no-round", 'label'=>false));
					} else {
						echo $this->Form->input('message', array('type' => 'textarea', 'class'=>" js-show-submit-block span18 no-pad no-round", 'label'=>false));
					}
				}
				echo $this->Form->input('message_type', array('type' => 'hidden'));
				echo $this->Form->input('root', array('type' => 'hidden'));
				echo $this->Form->input('m_path', array('type' => 'hidden'));

				 ?>


	<div class="<?php echo $message_class;?>">
	<?php
		if((!empty($this->request->params['named']['reply_type'])and $this->request->params['named']['reply_type']=="quickreply") || (!empty($contest['Contest']['user_id']) && $contest['Contest']['user_id']==$this->Auth->user('id')))
				{
					echo $this->Form->input('is_private', array('type' => 'hidden'));
				}
				else
				{?>
					<div class="checkprivate"><?php echo $this->Form->input('is_private', array('label' => __l('Private')));?></div>
				<?php }
	?>
	<div class="submit-block clearfix">
	<div class="span">
	 <?php echo $this->Form->submit(__l('Send'), array('class' => 'js-without-subject span')); ?></div>
		<?php if(empty($this->request->params['named']['dispute_id']) and (empty($this->request->params['named']['reply_type'])or $this->request->params['named']['reply_type']!="quickreply") and empty($this->request->params['named']['user'])){?>
		  <?php }
		  if(!empty($this->request->params['named']['reply_type'])and $this->request->params['named']['reply_type']=="quickreply"){
			  $message_class = '';
			  if(!empty($this->request->params['isAjax'])){
				  $message_class ="js-toggle-show {'container':'js-quickreplydiv-".$this->request->data['Message']['parent_message_id']."'}";
			  }?>
		  <div class="cancel-link span top-smspace hor-space"><?php echo $this->Html->link(__l('Cancel'), $redirect , array("class" =>$message_class,'title' => __l('Cancel'))); ?></div>
		  <?php }else if(!empty($this->request->params['named']['user'])){ ?>
		  <?php } ?>

	</div>
	</div>

	<?php echo $this->Form->end(); ?>
	</div>
<?php }
?>
</div>