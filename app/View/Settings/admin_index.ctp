<ul class="unstyled clearfix row-fluid">
	<?php foreach ($setting_categories as $setting_category): ?>
		<li class="span12 no-mar bot-space">
			<div class="well mspace setting-category-<?php echo $setting_category['SettingCategory']['id']; ?>">
				<h3><?php echo $this->Html->link($this->Html->cText($setting_category['SettingCategory']['name'], false), array('controller' => 'settings', 'action' => 'edit', $setting_category['SettingCategory']['id']), array('title' => $setting_category['SettingCategory']['name'], 'escape' => false)); ?></h3>
				<div class="htruncate-ml2 js-tooltip sfont textn" title="<?php echo $this->Html->cText($setting_category['SettingCategory']['description'],false); ?>">
					<?php echo str_replace('##PAYMENT_SETTINGS_URL##', Router::url(array('controller' => 'payment_gateways', 'action' => 'index')), $setting_category['SettingCategory']['description']); ?>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
</ul>