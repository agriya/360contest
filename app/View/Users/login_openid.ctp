		<h2 class="green-head"><?php echo __l('OpenID'); ?></h2>
		<div class="users form js-login-response ajax-login-block">
			<?php echo $this->Form->create('User', array('action' => 'login', 'class' => 'normal'));?>
			<?php
				if(!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin')):
					$this->Javascript->link('https://www.idselector.com/widget/button/1', false);
		            echo $this->Form->input('openid', array(
						'id' => 'register_openid_identifier',
		                'class' => 'bg-openid-input', 'label' => __l('OpenID'),
		                'id' => 'openid_identifier'
		            ));
					echo $this->Form->input('type', array('type' => 'hidden', 'value' => 'openid'));
				endif;
				echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.')));
			?>
			<div class="submit-block ">
				<?php
					$f = (!empty($_GET['f'])) ? $_GET['f'] : (!empty($this->request->data['User']['f']) ? $this->request->data['User']['f'] : (($this->request->url != 'admin/users/login' && $this->request->url != 'users/login') ? $this->request->url : ''));
            		if(!empty($f)) :
                        echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
                    endif;
					echo $this->Form->submit(__l('Submit'));
				?>
			</div>
		<?php echo $this->Form->end(); ?>
