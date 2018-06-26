<?php if ($this->request->params['action'] != 'show_header') { ?>
	<div id="js-head-menu" class="hide">
<?php } ?>
<div class="pull-right span no-mar  clearfix">
<ul class="unstyled space span hide" id="js-before-login-head-menu">
	  <li class="span ver-space "><?php echo $this->Html->link(__l('Login'), array('controller' => 'users', 'action' => 'login'), array('title' => __l('Login'), 'class' => 'grayc'));?></li>
	  <li class="span ver-space "><?php echo $this->Html->link(__l('Sign Up'), array('controller' => 'users', 'action' => 'register', 'admin' => false), array('title' => __l('Sign Up'), 'class' => 'grayc hor-space'));?></li>
</ul>
	<?php if($this->Auth->sessionValid() && $this->request->params['action'] == 'show_header'){ ?>
	<?php	$show_class=(empty($this->request->params['named']['entry']))?"show":"";
		?>
	<ul class="unstyled span no-mar user-side-menu clearfix">
		<?php $activities_count = $this->Html->getActivitiesCount($this->Auth->user('id')); ?>
		<li class="dc span hor-smspace ver-space dropdown notification">
		<?php $activiy_url = Router::url(array(
		'controller' => 'messages',
		'action' => 'activities',
		'type' => 'compact'
		), true); ?>
		<a class="top-mspace btn pr js-notification js-bottom-tooltip" data-target="#" data-toggle="dropdown" href="<?php echo $activiy_url; ?>" title="Activities"><span class="ver-smspace header-icon <?php echo $show_class; ?>"><i class="icon-globe hor-smspace no-pad"></i></span><span class="label label-warning pa count-label"><?php echo $this->Html->cInt($activities_count, false);?></span></a>

		<div class="dropdown-menu arrow arrow-right js-notification-list clearfix">
		  <div class="dc">
			<?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?></div>
		</div>
		</li>
<?php
	$message_count = $this->Html->getUserUnReadMessages($this->Auth->user('id'));
?><?php if(isPluginEnabled('Contests')){?>
			<li class="dc span hor-smspace ver-space ">
				<?php echo $this->Html->link('<span class="ver-smspace header-icon '.$show_class.'"><i class="icon-envelope hor-smspace no-pad"></i></span><span class="label label-success pa count-label js-unread">'.$this->Html->cInt($message_count, false).'</span>', array('controller' => 'messages', 'action' => 'index', 'admin' => false), array('title' => __l('Inbox'), 'label' => false, 'escape' => false, 'class' => 'top-mspace btn pr'));?>
			</li>
<?php } ?>
<li class="span no-mar clearfix ver-space ">
<div class="dropdown dc">
<div class="btn top-mspace js-bottom-tooltip" title="<?php echo $this->Auth->user('username');?>" data-toggle="dropdown" >
<span class="hor-smspace">
<?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id'));  echo $this->Html->getUserAvatarLink($user['User'], 'micro_thumb', false); ?>
</span>
<span class="caret"></span>
</div>

			  <ul class="dropdown-menu dl arrow arrow-right z-max-top">
			  <li><?php echo $this->Html->link(__l('Dashboard'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Dashboard'), 'escape' => false));?></li>
				<li><?php echo $this->Html->link(__l('Settings'), array('controller' => 'user_profiles', 'action' => 'edit'), array('title' => __l('Settings'), 'escape' => false));?></li>
				<?php if (isPluginEnabled('SocialMarketing')): ?>
				<li><?php echo $this->Html->link(__l('Find Friends'), array('controller' => 'social_marketings', 'action' => 'import_friends','type' => 'facebook'), array('title' => __l('Find Friends'), 'escape' => false));?></li>
				<?php endif; ?>
				<?php if(isPluginEnabled('LaunchModes') && Configure::read('site.launch_mode') == "Private Beta"):?>
		<li ><?php echo $this->Html->link(__l('Invite Friends'), array('controller' => 'subscriptions', 'action' => 'invite_friends'), array('title' => __l('Invite Friends'), 'escape' => false)); ?></li>
	  <?php endif;?>
				<li class="divider"></li>
				<li><?php echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'js-no-pjax', 'title' => __l('Logout'), 'escape' => false));?></li>
			  </ul>
			  </div>
			</li>
			</ul>
	<?php } ?>
<?php
	if (isPluginEnabled('Translation') && Configure::read('user.is_allow_user_to_switch_language')){
		$languages = $this->Html->getLanguage();
		if(Configure::read('user.is_allow_user_to_switch_language') && !empty($languages) && count($languages)>1){ 
?>
		<ul class="unstyled no-mar span">
			<li class="span pull-left hor-smspace ver-space mob-c">
				<div class="dropdown dc">
					<span class="top-mspace btn js-bottom-tooltip" data-toggle="dropdown" title="<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtoupper($_COOKIE['CakeCookie']['user_language']) : strtoupper(Configure::read('site.language')); ?>">
						<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtoupper($_COOKIE['CakeCookie']['user_language']) : strtoupper(Configure::read('site.language')); ?>
						<span class="caret"></span>
					</span>
					<ul class="dropdown-menu arrow arrow-right dl">
						<?php foreach($languages as $language_id => $language_name) { ?>
								<li><?php  echo $this->Html->link($language_name, '#', array('title' => $language_name, 'class'=>"js-lang-change" , 'data-lang_id' => $language_id, 'data-f' => $this->request->url));?></li>
						<?php } ?>
					</ul>
				</div>
			</li>
		</ul>
<?php
		}
	}
?>
 </div>
 <?php
	if ($this->request->params['action'] != 'show_header') {
		$script_url = Router::url(array(
			'controller' => 'users',
			'action' => 'show_header',
			'ext' => 'js',
			'admin' => false
		) , true) . '?u=' . $this->Auth->user('id');
		$js_inline = "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $script_url . "\";";
		$js_inline .= "var s = document.getElementById('js-head-menu'); s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
?>
<script type="text/javascript">
//<![CDATA[
function getCookie (c_name) {var c_value = document.cookie;var c_start = c_value.indexOf(" " + c_name + "=");if (c_start == -1) {c_start = c_value.indexOf(c_name + "=");}if (c_start == -1) {c_value = null;} else {c_start = c_value.indexOf("=", c_start) + 1;var c_end = c_value.indexOf(";", c_start);if (c_end == -1) {c_end = c_value.length;}c_value = unescape(c_value.substring(c_start,c_end));}return c_value;}if (getCookie('_gz')) {<?php echo $js_inline; ?>} else {document.getElementById('js-head-menu').className = '';document.getElementById('js-before-login-head-menu').className = 'unstyled space span mob-dc';}
//]]>
</script>
<?php
	}
?>
<?php if ($this->request->params['action'] != 'show_header') { ?>
	</div>
<?php } ?>