<div>
	<div class="clearfix">
		<?php 		
			if(!empty($is_allow_process)):
				if(!empty($this->request->data['ContestUser']['process']) && $this->request->data['ContestUser']['process'] == 'message'):
					echo $this->Form->create('ContestUser', array('action' => 'manage', 'class' => 'normal js-upload-form {is_required:"false"}', 'enctype' => 'multipart/form-data'));?>
					<div class="js-validation-part">
				<?php
				else:
						echo $this->Form->create('ContestUser', array('action' => 'manage', 'class' => 'normal comment-form'));
				endif;
				echo $this->Form->input('request_id', array('type' => 'hidden'));
				echo $this->Form->input('process', array('type' => 'hidden'));				
				if(!empty($this->request->data['ContestUser']['process']) && $this->request->data['ContestUser']['process'] == 'message'):
					$c_label = __l('Message');
					$page_info = __l('proceeds through this option to post your changes');
				else:
					$c_label = __l('Message');
					$page_info = __l('If you\'re satisifed with this'.' '. Configure::read('contest.participant_alt_name_singular_caps').' '. 'work, proceeds through this option to close the contest');
				endif; ?>
				<span class="info"><?php echo $page_info;?></span>
				<?php echo $this->Form->input('comments', array('type' => 'textarea', 'label' => $c_label));
				if(!empty($this->request->data['ContestUser']['process']) && $this->request->data['ContestUser']['process'] == 'message'){?>
				</div>
					<?php echo $this->Form->uploader('Attachment.filename', array('type'=>'file', 'uController' => 'contest_users', 'uRedirectURL' => array('controller' => 'contest_users', 'action' => 'update',  'admin' => false), 'uId' => 'contestUserID', 'uFiletype' => Configure::read('contestuser.file.allowedExt')));?>
					<?php }
					echo $this->Form->submit('submit');    	
					echo $this->Form->end();    ?>										
			<?php 
			endif;
		?>
	</div>
</div>