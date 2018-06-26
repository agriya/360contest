<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
	<div class="thumbnail sep">
		<div class="form-blocks  js-corner round-5">
<?php
	echo $this->Form->create('AudioUploadHoster', array('action' => 'edit', 'class' => 'normal clearfix form-horizontal  form-large-fields'));
	foreach ($uploadServiceSettings as $uploadServiceSetting):
		$name = "AudioUploadServiceSetting.{$uploadServiceSetting['AudioUploadServiceSetting']['id']}.name";
		$options = array(
			'value' => $uploadServiceSetting['AudioUploadServiceSetting']['value'],
			'div' => array('id' => "AudioUploadServiceSetting-{$uploadServiceSetting['AudioUploadServiceSetting']['name']}")
		);
		if (!empty($uploadServiceSetting['AudioUploadServiceSetting']['description'])):
			$options['after'] = "<p class=\"setting-desc\">{$uploadServiceSetting['AudioUploadServiceSetting']['description']}</p>";
		endif;
		$options['label'] = Inflector::humanize($uploadServiceSetting['AudioUploadServiceSetting']['name']);
		echo $this->Form->input($name, $options);
		if($uploadServiceSetting['AudioUploadServiceSetting']['name'] == 'vimeo_approved_domains'){?>
		<span class="help">
		<?php echo __('Comma seperated domains. Security feature, uploaded videos will only be viewed through these domains.'); ?></span>
<?php	}
	endforeach;
	echo $this->Form->input('upload_service_id', array('type' => 'hidden', 'value' => $uploadServiceSetting['AudioUploadServiceSetting']['upload_service_id'])); ?>
			<div class="submit-block clearfix">
				<?php echo $this->Form->end('Update'); ?>
			</div>
		</div>
	</div>
</div>
