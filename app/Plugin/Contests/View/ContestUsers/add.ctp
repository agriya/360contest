<?php /* SVN: $Id: $ */ ?>
  <div class="contestUsers contestUsers-add form js-responses">
    <?php echo $this->element('contest_view_header', array('contest' => $contest, 'f' => 'contest_users', 'cache' => array('config' => 'sec')));?>
	<div class="span18 clearix no-mar">
	<?php
		if($contest['Contest']['resource_id'] == ConstResource::Video) {
			$form_id = (Configure::read('hoster_type')=='direct') ? 'fileupload' : 'js-normal-fileupload';
			echo $this->Form->create('ContestUser', array('class' => 'form-horizontal {is_required:"true"} js-upload', 'id' => $form_id, 'enctype' => 'multipart/form-data'));
		}elseif($contest['Contest']['resource_id'] == ConstResource::Audio) {
			$form_id = 'js-normal-fileupload';
			echo $this->Form->create('ContestUser', array('class' => 'form-horizontal {is_required:"true"} js-upload', 'id' => $form_id, 'enctype' => 'multipart/form-data'));
		} else {
			echo $this->Form->create('ContestUser', array('class' => 'form-horizontal {is_required:"true"} js-upload', 'enctype' => 'multipart/form-data'));
		}
	?>
      <div class="top-space">
        <div class="js-validation-part">
		<div class="thumbnail-block clearfix">
          <?php
			if($contest['Contest']['resource_id'] == ConstResource::Image) { ?>
            <?php
				echo $this->Form->uploader('Attachment.filename', array('type' => 'file', 'uController' => 'contest_users', 'uRedirectURL' => array('controller' => 'contest_users', 'action' => 'update', 'admin' => false), 'uId' => 'contestUserID', 'uFiletype' => Configure::read('contestuser.file.allowedExt'),'uFilesize' => higher_to_bytes(Configure::read('contestuser.file.allowedSize'),Configure::read('contestuser.file.allowedSizeUnits')), 'uFilecount' => 1));
			?>
            <?php
				if($contest['Contest']['resource_id'] == ConstResource::Image) { 
					$allowedExt = implode(', ', Configure::read('contestuser.file.allowedExt'));
					$allowedSize = Configure::read('contestuser.file.allowedSize').Configure::read('contestuser.file.allowedSizeUnits');
				}elseif($contest['Contest']['resource_id'] == ConstResource::Video){
					$allowedExt = implode(', ', Configure::read('contestuser.video_file.allowedExt'));
					$allowedSize = Configure::read('contestuser.video_file.allowedSize').Configure::read('contestuser.video_file.allowedSizeUnits');
				} elseif($contest['Contest']['resource_id'] == ConstResource::Audio){
					$allowedExt = implode(', ', Configure::read('contestuser.audio_file.allowedExt'));
					$allowedSize = Configure::read('contestuser.audio.allowedSize').Configure::read('contestuser.audio_file.allowedSizeUnits');
				}
			if($contest['Contest']['resource_id'] == ConstResource::Image || $contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio) { ?>
			<p class="info"><?php echo sprintf(__l('File type can be %s.'), $allowedExt);?></p>
			 <p class="info"><?php echo sprintf(__l('Max.Allowed size %s.'), $allowedSize);?></p>
			 <?php
			} ?>
			 <?php
			} ?>
			
		  </div>
          <?php
			echo $this->Form->input('Contest.slug', array('type' => 'hidden'));
			echo $this->Form->input('description', array('label' => __l('Comment'), 'class' => 'span10'));
			echo $this->Form->input('copyright_note', array('class' => 'span10'));
			if($contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio) {
				if($contest['Contest']['resource_id'] == ConstResource::Video){
					$allowedExt = implode(', ', Configure::read('contestuser.video_file.allowedExt'));
					$allowedSize = Configure::read('contestuser.video_file.allowedSize').Configure::read('contestuser.video_file.allowedSizeUnits');
				} elseif($contest['Contest']['resource_id'] == ConstResource::Audio){
					$allowedExt = implode(', ', Configure::read('contestuser.audio_file.allowedExt'));
					$allowedSize = Configure::read('contestuser.audio_file.allowedSize').Configure::read('contestuser.audio_file.allowedSizeUnits');
				}
			?>
          <!-- The fileinput-button span is used to style the file input field as button -->
          <div class="input file required">
            <label for="ContestUserTitle">
            <?php  echo __l('File'); ?>
            </label>
            <span class="space hor-mspace">
			  <span class="btn btn-success fileinput-button"> <span>
              <?php  echo __l('Add files...'); ?>
              </span>
              <?php if($contest['Contest']['resource_id'] == ConstResource::Video && Configure::read('hoster_type') == 'direct') { ?>
              <input type="file" name="file_data" id="browseFile">
              <?php } else { 
			  
			  	if($contest['Contest']['resource_id'] == ConstResource::Image) { 
					$allowedExt = implode(', ', Configure::read('contestuser.file.allowedExt'));
					$allowedSize = Configure::read('contestuser.file.allowedSize').Configure::read('contestuser.file.allowedSizeUnits');
				}elseif($contest['Contest']['resource_id'] == ConstResource::Video){
					$allowedExt = implode(', ', Configure::read('contestuser.video_file.allowedExt'));
					$allowedSize = Configure::read('contestuser.video_file.allowedSize').Configure::read('contestuser.video_file.allowedSizeUnits');
				} elseif($contest['Contest']['resource_id'] == ConstResource::Audio){
					$allowedExt = implode(', ', Configure::read('contestuser.audio_file.allowedExt'));
					$allowedSize = Configure::read('contestuser.audio.allowedSize').Configure::read('contestuser.audio_file.allowedSizeUnits');
				}
			  
			  ?>
              	<?php if($contest['Contest']['resource_id'] == ConstResource::Video){ ?>
             		 <?php echo $this->Form->input('Attachment.video', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'fileUpload', 'multiple' => 'multiple')); ?>
              	 <?php }elseif($contest['Contest']['resource_id'] == ConstResource::Audio){ ?>
                 	<?php echo $this->Form->input('Attachment.audio', array('type' => 'file', 'label' => false, 'div' => false, 'class' => 'fileUpload', 'multiple' => 'multiple')); ?>
                 <?php } ?>
              <?php } ?>
			  
              </span>
			</span>
			<p class="info"><?php echo sprintf(__l('File type can be %s.'), $allowedExt);?></p>
            <p class="info"><?php echo sprintf(__l('Max.Allowed size %s.'), $allowedSize);?></p>
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
			echo $this->Form->input('current_url', array('type' => 'hidden', 'id' => 'current_url', 'value' => $this->here));
		  ?>
          <!-- The table listing the files available for upload/download -->
          <div class="time-desc datepicker-container clearfix">
            <table role="presentation" class="table table-striped js-template-upload" >
              <tbody class="files">
              </tbody>
            </table>
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
			}else if($contest['Contest']['resource_id'] == ConstResource::Text){ ?>
			<div class="input textarea required">
			  <label for="MessageContentTextResource"><?php echo __l('Entry');?></label>
			<?php
		  		echo $this->Form->input('MessageContent.text_resource', array('label' => false, 'div' => 'clearfix editor', 'class' => 'span14 js-editor', 'type' => 'textarea', 'value' => ' '));?>
		  	</div>
			<?php }
		  ?>
        </div>
      </div>
    <div class="submit-block clearfix">
		<?php if($contest['Contest']['resource_id'] == ConstResource::Video || $contest['Contest']['resource_id'] == ConstResource::Audio) { ?>
			<div class="fileupload-buttonbar submit ">
				<button class="btn btn-primary start" disabled type="submit"><span><?php echo __l('Upload'); ?></span></button>
			</div>
		<?php } else { ?>
			<?php echo $this->Form->submit(__l('Submit'), array('class' => 'btn btn-primary start no-mar')); ?>
		<?php } ?>
	</div>
    <?php echo $this->Form->end();?>
	</div>
	<div class="well pull-right text-20 top-mspace no-pad">
			<dl class="price-list clearfix mspace no-mar">
			  <dt class="span3 no-mar"><?php echo __l('Site Fee:') . ' ' ;?></dt>
			  <dd class="span no-mar"><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['site_commision']);?></dd>
			</dl>
			<dl class="price-list clearfix mspace no-mar">
			  <dt class="span3 no-mar"><?php echo __l('Net Prize:') . ' '; ?></dt>
			  <dd class="span  no-mar net-price"><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['prize'] - $contest['Contest']['site_commision'])?></dd>
			</dl>
		  </div>
	</div>
<div id="fb-root"></div>
<div class="modal hide fade" id="js-ajax-modal">
  <div class="modal-body">
  	<div class="dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
	<span class="loading grayc">Loading....</span></div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
  </div>
</div>