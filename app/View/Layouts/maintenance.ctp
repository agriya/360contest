<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(), "\n";?>
	<title><?php echo Configure::read('site.name');?> | <?php echo $this->Html->cText($title_for_layout, false);?></title>
	<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
	<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
	<![endif]-->
	<!--[if IE 7]>
		<?php echo $this->Html->css('font-awesome-ie7.css', null, array('inline' => true)); ?>
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
	<?php
		$this->loadHelper('Layout');
		$this->loadHelper('Javascript');
		echo $this->Html->meta('icon'), "\n";
	?>
	<link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
	<?php
		echo $this->Html->meta('keywords', !empty($meta_for_layout['keywords'])?$meta_for_layout['keywords']:''), "\n";
		echo $this->Html->meta('description', !empty($meta_for_layout['keywords'])?$meta_for_layout['description']:''), "\n";
		echo $this->Html->css('maintenance.cache.'.Configure::read('site.version'), null, array('inline' => true));
		echo $this->Layout->js();
		$js_inline = "document.documentElement.className = 'js';";
		$js_inline .= "(function() {";
		$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
		$js_inline .= "js.src = \"" . $this->Html->assetUrl('default.cache.'.Configure::read('site.version'), array('pathPrefix' => JS_URL, 'ext' => '.js')) . "\";";
		$js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
		$js_inline .= "})();";
		echo $this->Javascript->codeBlock($js_inline, array('inline' => true));
		echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
		echo $scripts_for_layout;
	?>
</head>
<body class="maintanace">
	<?php if ($this->Session->check('Message.error') || $this->Session->check('Message.success') || $this->Session->check('Message.flash')): ?>
		<div class="js-flash-message flash-message-block">
			<?php
				if ($this->Session->check('Message.error')):
					echo $this->Session->flash('error');
				endif;
				if ($this->Session->check('Message.success')):
					echo $this->Session->flash('success');
				endif;
				if ($this->Session->check('Message.flash')):
					echo $this->Session->flash();
				endif;
			?>
		</div>
	<?php endif; ?>
	<div id="<?php echo $this->Html->getUniquePageId();?>" class="content maintanace-page">
		<h1 class="dc"><?php echo $this->Html->link($this->Html->image('logo.png', array('alt'=> '[Image: '.Configure::read('site.name').']')), Router::url('/', true), array('escape' => false, 'class' => 'brand', 'title' => Configure::read('site.name')));?></h1>
	   <div class="maintanace-mode dc">
          <div class="maintanace-inner-mode">
			 <?php echo $content_for_layout; ?>
		 </div>

	</div>
	</div>
</body>
</html>