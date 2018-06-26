		<?php if(!empty($this->request->params['plugin']) && $this->request->params['plugin'] != 'extensions') { ?>
			  <div class="alert mspace"><?php echo $this->Html->cText(Inflector::humanize(ucfirst($this->request->params['plugin']))).__l(' plugin is currently enabled. You can disable it from ') . ' ' . $this->Html->link(__l('plugins'), array('controller' => 'extensions_plugins'), array('title' => __l('plugins'), 'class' => 'plugin'));  ?>.</div>
			<?php } ?>
			<?php if (!empty($this->request->params['controller']) && $this->request->params['controller'] == 'settings' && ((!empty($this->request->data['Setting']['setting_category_id'])) && ($this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Contests || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Wallet || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Withdrawals || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::HighPerformance || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::SocialMarketing || $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Affiliates))) {
			  $enable_text = 'enabled';
			  $disable_text = 'disable';
			  if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Wallet) {
				if (!isPluginEnabled('Wallet')) {
				  $enable_text = 'disabled';
				  $disable_text = 'enable';
				}
				$plugin_name = 'Wallet';
			  }
			  if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Contests) {
				if(!isPluginEnabled('Contests')) {
				  $enable_text = 'disabled';
				  $disable_text = 'enable';
				}
				$plugin_name = 'Contests';
			  }
			  if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Withdrawals) {
				if(!isPluginEnabled('Withdrawals')) {
				  $enable_text = 'disabled';
				  $disable_text = 'enable';
				}
				$plugin_name = 'Withdrawals';
			  }
			  if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::HighPerformance) {
				if(!isPluginEnabled('HighPerformance')) {
				  $enable_text = 'disabled';
				  $disable_text = 'enable';
				}
				$plugin_name = 'HighPerformance';
			  }
			  if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::SocialMarketing) {
				if(!isPluginEnabled('SocialMarketing')) {
				  $enable_text = 'disabled';
				  $disable_text = 'enable';
				}
				$plugin_name = 'SocialMarketing';
			  }
			  if(!empty($this->request->data['Setting']['setting_category_id']) && $this->request->data['Setting']['setting_category_id'] == ConstPluginSettingCategories::Affiliates) {
				if(!isPluginEnabled('Affiliates')) {
				  $enable_text = 'disabled';
				  $disable_text = 'enable';
				}
				$plugin_name = 'Affiliates';
			  }?>
			  <div class="hor-space">
			  <div class="alert alert-info page-info plugins-info mspace">

				<?php echo $this->Html->cText(Inflector::humanize(ucfirst($plugin_name))).__l(' plugin is currently '.$enable_text.'. You can '.$disable_text.' it from ') . ' ' . $this->Html->link(__l('plugins'), array('controller' => 'extensions_plugins'), array('title' => __l('plugins'), 'class' => 'plugin'));  ?>.
			  </div>
			  </div>
			<?php }	?>
		<?php if (($this->request->params['controller'] == 'users' && ($this->request->params['action'] == 'admin_stats' || $this->request->params['action'] == 'admin_demographic_stats'))) {
			  echo $content_for_layout;
			} else {?>
			  <article id="user-dashboard">
			  <?php $diagnostics_menu = array('devs', 'authorizenet_docapture_logs', 'adaptive_transaction_logs', 'search_logs');
			  $links_menu = array('links');
			  if(isset($plugin_name) && !empty($plugin_name)){
				if (!empty($plugins[$plugin_name]['icon'])):
					 if (!in_array($plugins[$plugin_name]['icon'], $image_plugin_icons)):
						$pluginImage = $this->Html->image('plugin-icons/' . $plugins[$plugin_name]['icon'] . '.png', array('title' => $plugin_name, 'class' => 'js-tooltip space', 'width'=>32, 'height'=>32));
					 else:
						$pluginImage = '<i class="icon-'.$plugins[$plugin_name]['icon'].' text-46 js-tooltip" title="'.$plugin_name.'"></i>';
					endif;
				endif;
			  } else if ($this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_diagnostics') {
				$class = "diagnostics-title";
			  } elseif ($this->request->params['controller'] == 'user_profiles' || $this->request->params['controller'] == 'user_add_wallet_amounts') {
				$class = "users-title";
			  } elseif (in_array($this->request->params['controller'], $diagnostics_menu)) {
				$class = "diagnostics-title";
			  } elseif (in_array($this->request->params['controller'], $links_menu)) {
				$class = "cms-title";
			  } elseif ($this->request->params['controller'] == 'settings') {
                $class = "icon-cogs";
              } else {
				$class = Configure::read('admin_icon_class');
			  }
			  ?>
			  <div class="container-fluid">
				<div class="tabbable">
				  <div class="row no-mar">
				  	<h4 class="bot-mspace text-32 span ver-space">
						<?php
						  if (!empty($pluginImage) && !empty($plugin_name)) {
							echo $pluginImage;
						  } else {
						?>
							<i class="<?php echo $class;?> no-bg yop-mspace"></i>
                        <?php }
						  if($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'index' || $this->request->params['controller'] == 'entry_flag_categories' && $this->request->params['action'] == 'index') {
							echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings')));
						  } elseif ($this->request->params['controller'] == 'settings' && $this->request->params['action'] == 'admin_edit') {
							if(!empty($setting_categories['SettingCategory'])) {
							  echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'index'), array('title' => __l('Back to Settings'))) . ' &raquo; ' . $setting_categories['SettingCategory']['name'];
							}
						  } elseif (in_array( $this->request->params['controller'], $diagnostics_menu) || $this->request->params['controller'] == 'users' && $this->request->params['action'] == 'admin_logs') {
							echo $this->Html->link(__l('Diagnostics'), array('controller' => 'users', 'action' => 'diagnostics', 'admin' => true), array('title' => __l('Diagnostics'))) . ' &raquo; ' . $this->pageTitle;
						  } else {
							echo $this->Html->cText($this->pageTitle);
						  }?>
					</h4>
					<?php if (in_array($this->request->params['controller'], array('settings', 'payment_gateways', 'blocks', 'menus', 'links', 'extensions_themes', 'extensions_plugins'))) { ?>
						<span class="pull-right grayc top-space hor-mspace">
						  <?php echo __l('To reflect changes, you need to') . ' ' . $this->Html->link(__l('clear cache'), array('controller' => 'devs', 'action' => 'clear_cache', '?f=' . $this->request->url), array('title' => __l('clear cache'), 'class' => 'js-confirm js-no-pjax'));  ?>.
						</span>
					  <?php } ?>
				  </div>
				</div>
			  </div>
			  <div class="admin-center-block clearfix">

				<?php echo $content_for_layout;  ?>
			  </div>
			  </article>
			<?php } ?>