<h2 class="title bot-space">
<?php
	if($this->request->params['named']['type'] == 'request'){
		echo __l('Request for Change') ;
	}
	else{
		echo __l('Send Revised Entry') ;
	}
	?></h2>
	<?php
	if($contest['Contest']['contest_status_id'] == ConstContestStatus::ChangeRequested && ($contest['Contest']['winner_user_id'] != $this->Auth->user('id')) || $contest['Contest']['user_id'] == $this->Auth->user('id')){
		 echo $this->element('contest-request_change', array('cache' => array('config' => 'sec'))); 
	}
	?>
	<?php
        if (!empty($upload) && $contest['Contest']['resource_id'] == ConstResource::Video) {
		?><span class="span">
		<?php
            echo sprintf(__l('You already submitted revised entry. But the video upload is in-progress. Please %s to check status of video upload.'), $this->Html->link(__l('click here'), array('controller'=>'uploads', 'action'=>'check_status', $upload['Upload']['id']), array('title' => __l('Check Status'), 'class'=>'check-status')));
		?>
		</span>
		<?php
    	} else if (!empty($upload) && $contest['Contest']['resource_id'] == ConstResource::Audio) {
		?><span class="span">
		<?php
            echo sprintf(__l('You already submitted revised entry. But the audio upload is in-progress. Please %s to check status of Audio upload.'), $this->Html->link(__l('click here'), array('controller'=>'audio_uploads', 'action'=>'check_status', $upload['AudioUpload']['id']), array('title' => __l('Check Status'), 'class'=>'check-status')));
		?>
		</span>
		<?php
    	} else {
		$redirect = Router::url(array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'], '#Send_Revised_Entry'),true);
		if ($contest['Contest']['resource_id'] == ConstResource::Video) {
			$form_id = (Configure::read('hoster_type')=='direct') ? 'fileupload' : 'js-normal-fileupload';
			echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'normal {is_required:"true"} js-upload', 'id' => $form_id, 'enctype' => 'multipart/form-data'));
		} elseif($contest['Contest']['resource_id'] == ConstResource::Audio) {
			$form_id = (Configure::read('hoster_type')=='direct') ? 'fileupload' : 'js-normal-fileupload';
			echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'normal {is_required:"true"} js-upload', 'id' => $form_id, 'enctype' => 'multipart/form-data'));
		}else {
			echo $this->Form->create('Message', array('action' => 'compose', 'class' => 'compose normal  ', 'enctype' => 'multipart/form-data'));
		}
		 ?>
			<?php
					echo $this->Form->input('contest_id', array('type' => 'hidden','value'=>$this->request->params['named']['contest_id']));
					echo $this->Form->input('to', array('type' => 'hidden'));
					echo $this->Form->input('message_type', array('type' => 'hidden','value'=>'1'));
					echo $this->Form->input('request_type', array('type' => 'hidden','value'=>$this->request->params['named']['type']));
					echo $this->Form->input('parent_message_id', array('type' => 'hidden'));
					echo $this->Form->input('type', array('type' => 'hidden'));
					echo $this->Form->input('message', array('type' => 'textarea', 'class'=>"span15 no-pad no-round js-show-submit-block span22", 'label'=>false));
					echo $this->Form->input('root', array('type' => 'hidden'));
					echo $this->Form->input('m_path', array('type' => 'hidden'));
					echo $this->Form->input('contest_user_id', array('type' => 'hidden'));
					echo $this->Form->input('redirect_url', array('type' => 'hidden','value'=>$redirect));
					echo $this->Form->input('is_private', array('type' => 'hidden', 'value' => 1));
					if ($this->request->params['named']['type'] != 'request' && ($contest['Contest']['resource_id'] == ConstResource::Image || $contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio)) { ?>
						<div class="alert span20 alert-info">
							<?php
								if ($contest['Contest']['resource_id'] == ConstResource::Image) {
									echo sprintf(__l('File type can be %s.'), implode(', ', Configure::read('contestuser.file.allowedExt')));
									$allowedSize = Configure::read('contestuser.file.allowedSize').Configure::read('contestuser.file.allowedSizeUnits');
								} elseif ($contest['Contest']['resource_id'] == ConstResource::Video) {
									echo sprintf(__l('File type can be %s.'), implode(', ', Configure::read('contestuser.video_file.allowedExt')));
									$allowedSize = Configure::read('contestuser.video_file.allowedSize').Configure::read('contestuser.video_file.allowedSizeUnits');
								} elseif ($contest['Contest']['resource_id'] == ConstResource::Audio) {
									echo sprintf(__l('File type can be %s.'), implode(', ', Configure::read('contestuser.audio_file.allowedExt')));
									$allowedSize = Configure::read('contestuser.audio.allowedSize').Configure::read('contestuser.audio_file.allowedSizeUnits');
								}
							?>
                            <?php if(!empty($allowedSize)): ?>
                            	<p><?php echo sprintf(__l('Max.Allowed size  %s.'), $allowedSize); ?></p>
                            <?php endif; ?>
						</div>
					<?php }
					if(($contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio ) && $contest['Contest']['user_id'] != $this->Auth->user('id')) {
					$allowedExt = implode(', ', Configure::read('contestuser.video_file.allowedExt'));
					if($contest['Contest']['resource_id'] == ConstResource::Audio){
						$allowedExt = implode(', ', Configure::read('contestuser.audio_file.allowedExt'));
					}
					?>
					<!-- The fileinput-button span is used to style the file input field as button -->
					<div class="input file required">
 						<div class="time-desc datepicker-container clearfix">
 							<span class="btn btn-success fileinput-button">
 								<i class="icon-plus icon-white"></i>
 								<span><?php  echo __l('Add files...'); ?></span>
								<?php if(Configure::read('hoster_service') == 'vimeo' && Configure::read('hoster_type') == 'direct') { ?>
									<input type="file" name="file_data" id="browseFile">
								<?php } elseif($contest['Contest']['resource_id'] == ConstResource::Video) { ?>
									<?php echo $this->Form->input('Attachment.video', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'fileUpload', 'multiple' => 'multiple')); ?>
								<?php } elseif($contest['Contest']['resource_id'] == ConstResource::Audio) { ?>
									<?php echo $this->Form->input('Attachment.audio', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'fileUpload', 'multiple' => 'multiple')); ?>
								<?php } ?>
 							</span>
 						</div>
 					</div>
					<?php
						if($contest['Contest']['resource_id'] == ConstResource::Video){
							echo $this->Form->input('service', array('type' => 'hidden', 'id' => 'direct_service', 'value' => Configure::read('hoster_service')));
							echo $this->Form->input('service_type', array('type' => 'hidden', 'id' => 'service_type', 'value' => Configure::read('hoster_type')));
						}elseif($contest['Contest']['resource_id'] == ConstResource::Audio){
							echo $this->Form->input('service', array('type' => 'hidden', 'id' => 'direct_service', 'value' => Configure::read('hoster_audio_service')));
							echo $this->Form->input('service_type', array('type' => 'hidden', 'id' => 'service_type', 'value' => Configure::read('hoster_audio_type')));
						}
			
						echo $this->Form->input('fileType', array('type' => 'hidden', 'id' =>'allowedFileType', 'data-allowed-extensions' => $allowedExt));
						echo $this->Form->input('Contest.id', array('type' => 'hidden', 'value' => $contest['Contest']['id']));
						echo $this->Form->input('success_redirect_url', array('type' => 'hidden', 'id' => 'success_redirect_url', 'value' => Router::url(array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug']),true)));
						echo $this->Form->input('current_url', array('type' => 'hidden', 'value' => $this->here));
						echo $this->Form->input('revised', array('type' => 'hidden', 'value' => 1));
					?>
					<!-- The table listing the files available for upload/download -->
					<div class="time-desc datepicker-container clearfix">
						<table role="presentation" class="table table-striped js-template-upload"><tbody class="files"></tbody></table>
						<!-- The template to display files available for upload -->
						<script id="template-upload" type="text/x-tmpl">
						{% for (var i=0, file; file=o.files[i]; i++) { %}
							<tr class="template-upload fade">
								<td>
									<span class="preview"></span>
								</td>
								<td>
									<p class="name">{%=file.name%}</p>
									{% if (file.error) { %}
										<div><span class="label label-danger">Error</span> {%=file.error%}</div>
									{% } %}
								</td>
								<td>
									<p class="size">{%=o.formatFileSize(file.size)%}</p>
									{% if (!o.files.error) { %}
										<div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar bar-success" style="width:0%;"></div></div>
									{% } %}
								</td>
								<td>
									{% if (!o.files.error && !i && !o.options.autoUpload) { %}
										<button class="btn btn-primary start hide">
											<span>Start</span>
										</button>
									{% } %}
									{% if (!i) { %}
										<button class="btn btn-warning cancel js-upload-cancel">
											<span>Cancel</span>
										</button>
									{% } %}
								</td>
							</tr>
						{% } %}
						</script>
						<!-- The template to display files available for download -->
						<script id="template-download" type="text/x-tmpl">
						{% for (var i=0, file; file=o.files[i]; i++) { %}
							<tr class="template-download fade">
								<td>
									<span class="preview">
										{% if (file.thumbnailUrl) { %}
											<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
										{% } %}
									</span>
								</td>
								<td>
									<p class="name">
										{% if (file.url) { %}
											<a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
										{% } else { %}
											<span>{%=file.name%}</span>
										{% } %}
									</p>
									{% if (file.error) { %}
										<div><span class="label label-danger">Error</span> {%=file.error%}</div>
									{% } %}
								</td>
								<td>
									<span class="size">{%=o.formatFileSize(file.size)%}</span>
								</td>
								<td>
									{% if (file.deleteUrl) { %}
										<button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
											<i class="glyphicon glyphicon-trash"></i>
											<span>Delete</span>
										</button>
									{% } else { %}
										<button class="btn btn-warning cancel js-upload-cancel">
											<span>Cancel</span>
										</button>
									{% } %}
								</td>
							</tr>
						{% } %}
						</script>
					</div>
					<?php
				} else if($contest['Contest']['resource_id'] == ConstResource::Text && $contest['Contest']['user_id'] != $this->Auth->user('id')){
					echo $this->Form->input('MessageContent.text_resource', array('label' => __l('Entry'), 'class' => 'span15 js-editor', 'type' => 'textarea'));
				} else {
					echo $this->Form->input('Attachment.filename', array('type' => 'file', 'label' => '','size' => '33'));
				}
				?>
		<div class="clearfix">
		<div class="js-add-block hide">
				<div class="submit-block clearfix">
			<?php
			if($this->request->params['named']['type'] == 'request'){
				echo $this->Form->submit(__l('Request for Change'), array('class' => 'js-without-subject'));
			} else { ?>
				<div class="hide">
					<div><input type="submit" name="submit" class="btn btn-primary" id="js-save" value="Add" /></div>
				</div>
				<?php if($contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio) {?>
					<div class="fileupload-buttonbar submit">
						<button class="btn btn-primary start" type="submit"><span><?php echo __l('Upload'); ?></span></button>
					</div>
				<?php } else {
					echo $this->Form->submit(__l('Change Completed'), array('class' => 'btn btn-primary start js-without-subject'));
				}
			} ?>
			</div>
		</div>
		</div>
		<?php echo $this->Form->end(); ?>
    <?php } ?>