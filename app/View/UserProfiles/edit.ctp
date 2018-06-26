<?php if(empty($this->request->params['prefix'])){ ?>
	<div>
	<div>
<?php }else{
?>
	<div class="hor-space">
	<div class="thumbnail sep">
	<div class="form-blocks  js-corner round-5">
<?php } if(empty($this->request->params['prefix'])) :?>
        <h2 class="ver-space ver-mspace"><?php echo sprintf(__l('Edit Profile - %s'), $this->request->data['User']['username']); ?></h2>
		<div class="form-blocks  js-corner round-5 thumbnail sep">
<?php endif; ?>
<?php
  if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'user_profiles' && $this->request->params['action'] == 'edit'):
  $active ='active';
  else:
  $active =' ';
  endif;
 ?>

            <?php echo $this->Form->create('UserProfile', array('action' => 'edit', 'class' => 'form-large-fields form-horizontal  form-large-fields', 'enctype' => 'multipart/form-data'));?>
        	<fieldset>
          		<legend><?php echo __l('Personal Info');?></legend>
			<div class="span3 pull-right">
        	<div class="span thumbnail no-mar">
            <?php echo $this->Html->getUserAvatarLink($this->request->data['User'], 'big_thumb'); ?>
			<div class="span">

			<?php echo $this->Html->link(__l('Change Image'), array('controller' => 'user_profiles', 'action' => 'profile_image',$this->request->data['User']['id'], 'admin' => false)); ?>
			</div>
            </div>
			</div>
			<div class="span17  top-space">
        		<?php
                if($this->Auth->user('role_id') == ConstUserTypes::Admin):
                    echo $this->Form->input('User.id');
                endif;
                if($this->request->data['User']['role_id'] == ConstUserTypes::Admin):
                    echo $this->Form->input('User.username');
                endif;
                echo $this->Form->input('first_name', array('label' => __l('First Name')));
        		echo $this->Form->input('last_name', array('label' => __l('Last Name')));
        		echo $this->Form->input('middle_name', array('label' => __l('Middle Name')));
        		echo $this->Form->input('gender_id', array('empty' => __l('Please Select'), 'label' => __l('Gender')));?>
        		<div class="input <?php if($this->Auth->user('role_id') == ConstUserTypes::User) { echo 'required'; }?> end-date-time-block clearfix">
						 <div class="js-boostarp-datetime">
          					<div class="js-cake-date">
							<?php echo $this->Form->input('dob', array('label' => __l('DOB'),'empty' => __l('Please Select'), 'div' => false, 'minYear' => date('Y') - 100, 'maxYear' => date('Y'), 'orderYear' => 'asc')); ?>
          		        </div>
						</div>
                  </div>
            	<?php
				if($this->Auth->user('role_id') == ConstUserTypes::Admin) {
					echo $this->Form->input('User.email', array('label' => __l('Email')));
				}
				echo $this->Form->input('about_me', array('label' => __l('About Me')));
        		echo $this->Form->input('address', array('label' => __l('Address')));
        		echo $this->Form->autocomplete('City.name', array('label' => __l('City'), 'acFieldKey' => 'City.id', 'acFields' => array('City.name'), 'acSearchFieldNames' => array('City.name'), 'maxlength' => '255'));
        		echo $this->Form->autocomplete('State.name', array('label' => __l('State'), 'acFieldKey' => 'State.id', 'acFields' => array('State.name'), 'acSearchFieldNames' => array('State.name'), 'maxlength' => '255'));
        		echo $this->Form->input('country_id', array('empty' => __l('Please Select'), 'label' => __l('Country')));
                echo $this->Form->input('language_id', array('empty' => __l('Please Select'), 'label' => __l('Language')));
        		echo $this->Form->input('zip_code', array('type' => 'text', 'label' => __l('Zip Code')));
        		echo $this->Form->input('UserAvatar.filename', array('type' => 'file','size' => '33', 'label' => __l('Upload Photo'),'class' =>'browse-field bot-space'));
        	?>
			</div>
        	</fieldset>
			<?php
				$response = '';
				$response = Cms::dispatchEvent('View.UserProfile.additionalFields', $this, array(
					'data' => $this->request->data
				));
			?>
			<?php if(!empty($response->data['content'])):?>
			<fieldset>
				<div class="">
					<?php echo $response->data['content'];?>
				</div>
			</fieldset>
            <?php endif;?>
				<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
				<fieldset>
          		<legend><?php echo __l('Admin Actions'); ?></legend>
					<?php
						echo $this->Form->input('User.is_active', array('label' => __l('Active')));
						echo $this->Form->input('User.is_email_confirmed', array('label' => __l('Email Confirmed')));
					  ?>
					</fieldset>
				<?php endif; ?>
			<?php if(isPluginEnabled('SecurityQuestions') && $this->request->data['User']['security_question_id'] == 0 && $this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
				<?php if(empty($this->request->data['User']['is_openid_register']) && empty($this->request->data['User']['is_google_register']) && empty($this->request->data['User']['is_yahoo_register']) && empty($this->request->data['User']['is_facebook_register']) && empty($this->request->data['User']['is_twitter_register']) && empty($this->request->data['User']['is_linkedin_register']) && empty($this->request->data['User']['is_angellist_register']) && empty($this->request->data['User']['is_googleplus_register'])):?>
				  <fieldset>
					<legend><?php echo __l('Security Question'); ?></legend>
					<div class="alert alert-info clearfix">
					  <?php echo sprintf(__l('Setting a security question helps us to identify you as the owner of your %s account.'),Configure::read('site.name')); ?>
					</div>
					<div class="clearfix">
						<?php echo $this->Form->input('User.security_question_id',array('id'=>'js-security_question_id', 'empty' => __l('Please select questions')));
						echo $this->Form->input('User.security_answer', array('label' => __l('Answer')));?>
					</div>
				  </fieldset>
				<?php endif; ?>
			<?php endif; ?>
            <div class="clearfix">
            <?php echo $this->Form->submit(__l('Update')); ?>
            </div>
             <?php echo $this->Form->end(); ?>
<?php if($this->Auth->user('role_id') != ConstUserTypes::Admin): ?>
		</div>
      </div>
      </div>
<?php endif;?>
