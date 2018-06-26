<?php if (empty($this->request->params['prefix'])): ?>
<div class="clearfix">
<h2 class="ver-space ver-mspace span"><?php echo __l('Change Password'); ?></h2>
  <div class="ver-space">
	<?php echo $this->element('settings-menu', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  </div>
</div>
<?php endif; ?>
<div class="admin-center-block clearfix">
	<div class="hor-space">
		<div class="thumbnail sep">
		<?php
			echo $this->Form->create('User', array('action' => 'change_password' ,'class' => 'form-large-fields form-horizontal space'));
			if($this->Auth->user('role_id') == ConstUserTypes::Admin) :
		    	echo $this->Form->input('user_id', array('empty' => 'Select'));
		    endif;
		    if($this->Auth->user('role_id') != ConstUserTypes::Admin) :
		        echo $this->Form->input('user_id', array('type' => 'hidden'));
		    	echo $this->Form->input('old_password', array('type' => 'password','label' => __l('Old Password') ,'id' => 'old-password'));
		    endif;
		    echo $this->Form->input('passwd', array('type' => 'password','label' => __l('New Password') , 'id' => 'new-password'));
			echo $this->Form->input('confirm_password', array('type' => 'password', 'label' => __l('Confirm Password')));
		    ?>
		    <div class="submit-block clearfix">
		        <?php
		    	echo $this->Form->submit(__l('Change password'));
		        ?>
		    </div>
		    <?php echo $this->Form->end();?>
		</div>
	</div>
</div>