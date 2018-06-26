<div class="messages index js-responses">
	<h2 class="title"><?php echo __l('Compose') ;?></h2>
	<div class="js-colorbox-response">
		<?php
			if(!empty($this->request->data['Message']['page']) && $this->request->data['Message']['page']=='favorites') {
				$redirect = Router::url(array('controller'=>'users', 'action'=>'view', $this->Auth->user('username').'#followingParticipant') ,true);
			} else if(!empty($this->request->data['Message']['page']) && $this->request->data['Message']['page']=='top') {
				$redirect = Router::url(array('controller'=>'users', 'action'=>'index') ,true);
			} else if(!empty($this->request->data['Message']['page']) && $this->request->data['Message']['page']=='contest_flag') {
				$redirect = Router::url(array('controller'=>'contest_flags', 'action'=>'index', 'admin' => true) ,true);
			} else  {
				$redirect = Router::url(array('controller'=>'users', 'action'=>'view', $this->request->data['Message']['to']) ,true);
			}
		?>
		<?php echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'form-horizontal {"redirect_url":"'.$redirect.'"}', 'enctype' => 'multipart/form-data','url' => array('controller' => 'messages', 'action' => 'compose', 'type'=>'contact','to'=>$this->request->params['named']['to'],'admin'=>false))); ?>
		<div class="clearfix  input">
			<label class=""><?php 	echo __l('From'); ?></label>
			<label class="dl hor-space hor-smspace"><?php echo $this->Html->link($this->Html->cText($this->Auth->user('username')), array('controller'=> 'users', 'action' => 'view', $this->Auth->user('username')), array('title' => $this->Html->cText($this->Auth->user('username'),false),'escape' => false));?></label>
		</div>
		<div class="clearfix input">
			<label class="grid_5  from-left omega alpha"><?php 	echo __l('To'); ?></label>
			<label class="dl hor-space hor-smspace"><?php echo !empty($this->request->data['Message']['to']) ? $this->Html->link($this->Html->cText($this->request->data['Message']['to']), array('controller'=> 'users', 'action' => 'view', $this->request->data['Message']['to']), array('title' => $this->Html->cText($this->request->data['Message']['to'],false),'escape' => false)) : ''; ?></label>
		</div>
		<?php
			echo $this->Form->input('to', array('type' => 'hidden'));
			echo $this->Form->input('page', array('type' => 'hidden'));
			echo $this->Form->input('message_type', array('type' => 'hidden','value'=>'1'));
			echo $this->Form->input('redirect_url', array('type' => 'hidden','value'=>$redirect));
			if (!empty($this->request->params['named']['contest_id'])) {
				echo $this->Form->input('contest_id', array('type' => 'hidden', 'value'=>$this->request->params['named']['contest_id']));
			}
		?>
		<div class="message-block">
			<?php echo $this->Form->input('message', array('type' => 'textarea', 'class'=>" js-show-submit-block")); ?>
		</div>
		<div class="submit-block clearfix">
			<?php echo $this->Form->submit(__l('Send'), array('class' => 'js-without-subject')); ?>
			<?php if(!empty($this->request->params['named']['page']) && $this->request->params['named']['page'] == 'favorites'){ ?>
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'users', 'action' => 'view',$this->Auth->user('username')) , array('class' => 'js-cancel btn btn-small js-no-pjax', 'title' => __l('Cancel'))); ?>
			<?php } elseif(!empty($this->request->params['named']['page']) && $this->request->params['named']['page'] == 'top'){?>
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'users', 'action' => 'index') , array('class' => 'js-cancel btn btn-small js-no-pjax', 'title' => __l('Cancel'))); ?>
			<?php  } elseif(!empty($this->request->params['named']['page']) && $this->request->params['named']['page'] == 'contest_flag'){?>
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'contest_flags', 'action' => 'index', 'admin' => true) , array('class' => 'js-cancel btn btn-small js-no-pjax', 'title' => __l('Cancel'))); ?>
			<?php  } elseif(!empty($this->request->params['named']['page']) && $this->request->params['named']['page'] == 'contest_user_flag'){?>
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'contest_user_flags', 'action' => 'index', 'admin' => true) , array('class' => 'js-cancel btn btn-small js-no-pjax', 'title' => __l('Cancel'))); ?>
			<?php  } elseif(!empty($this->request->params['named']['page']) && $this->request->params['named']['page'] == 'user_flag'){?>
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'user_flags', 'action' => 'index', 'admin' => true) , array('class' => 'js-cancel btn btn-small js-no-pjax', 'title' => __l('Cancel'))); ?>
			<?php } else{ ?>
				<?php echo $this->Html->link(__l('Cancel'), array('controller' => 'users', 'action' => 'view',$this->request->data['Message']['to']) , array('class' => 'js-cancel btn btn-small', 'title' => __l('Cancel'))); ?>
			<?php } ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>