<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
	<div class="thumbnail sep">
		<div class="form-blocks  js-corner round-5">
<?php
	echo $this->Form->create('UploadHoster', array('action' => 'edit', 'class' => 'normal clearfix form-horizontal  form-large-fields'));
	foreach ($uploadServiceSettings as $uploadServiceSetting):
		$name = "UploadServiceSetting.{$uploadServiceSetting['UploadServiceSetting']['id']}.name";
		$options = array(
			'value' => $uploadServiceSetting['UploadServiceSetting']['value'],
			'div' => array('id' => "UploadServiceSetting-{$uploadServiceSetting['UploadServiceSetting']['name']}")
		);
		if (!empty($uploadServiceSetting['UploadServiceSetting']['description'])):
			$options['after'] = "<p class=\"setting-desc\">{$uploadServiceSetting['UploadServiceSetting']['description']}</p>";
		endif;
		$options['label'] = Inflector::humanize($uploadServiceSetting['UploadServiceSetting']['name']);
		echo $this->Form->input($name, $options);
		if($uploadServiceSetting['UploadServiceSetting']['name'] == 'vimeo_approved_domains'){?>
		<span class="help">
		<?php echo __('Comma seperated domains. Security feature, uploaded videos will only be viewed through these domains.'); ?></span>
<?php	}
	endforeach;
	echo $this->Form->input('upload_service_id', array('type' => 'hidden', 'value' => $uploadServiceSetting['UploadServiceSetting']['upload_service_id'])); ?>
			<div class="submit-block clearfix">
				<?php echo $this->Form->end('Update'); ?>
			</div>
		</div>
	</div>
</div>
