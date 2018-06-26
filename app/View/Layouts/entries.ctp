<!DOCTYPE html>
<html lang="<?php echo isset($_COOKIE['CakeCookie']['user_language']) ?  strtolower($_COOKIE['CakeCookie']['user_language']) : strtolower(Configure::read('site.language')); ?>">
<head>
<?php echo $this->Html->charset(), "\n";?>
<?php
    if (!empty($meta_for_layout['keywords'])):
        echo $this->Html->meta('keywords', $meta_for_layout['keywords']), "\n";
    endif;
    if (!empty($meta_for_layout['description'])):
        echo $this->Html->meta('description', $meta_for_layout['description']), "\n";
    endif;
?>
<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
<!--[if lt IE 9]>
    <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.1/html5shiv.js"></script>
<![endif]-->
<title><?php echo Configure::read('site.name') . ' | ' . $title_for_layout; ?></title>
<?php echo $this->Html->meta('icon'), "\n"; ?>
<link rel="apple-touch-icon" href="<?php echo Router::url('/'); ?>apple-touch-icon.png">
<link rel="apple-touch-icon" sizes="72x72" href="<?php echo Router::url('/'); ?>apple-touch-icon-72x72.png" />
<link rel="apple-touch-icon" sizes="114x114" href="<?php echo Router::url('/'); ?>apple-touch-icon-114x114.png" />
<?php
echo $this->Html->css('default.cache.'.Configure::read('site.version'), null, array('inline' => true));
echo $this->Layout->js();
$js_inline = "document.documentElement.className = 'js';";
$js_inline .= "(function() {";
$js_inline .= "var js = document.createElement('script'); js.type = 'text/javascript'; js.async = true;";
$js_inline .= "js.src = \"" . $this->Html->assetUrl('default.cache.'.Configure::read('site.version'), array('pathPrefix' => JS_URL, 'ext' => '.js')) . "\";";
$js_inline .= "var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(js, s);";
$js_inline .= "})();";
echo $this->Javascript->codeBlock($js_inline, array('inline' => true)); ?>
<!--[if IE 7]>
    <?php echo $this->Html->css('font-awesome-ie7.css', null, array('inline' => true)); ?>
<![endif]-->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="//fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css" />
<?php
// For other than Facebook (facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)), wrap it in comments for XHTML validation...
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
    echo '<!--', "\n";
endif;
?>
<meta content="<?php echo Configure::read('facebook.fb_app_id');?>" property="og:app_id" />
<meta content="<?php echo Configure::read('facebook.fb_app_id');?>" property="fb:app_id" />
<?php if (!empty($meta_for_layout['title'])) { ?>
<meta property="og:title" content="<?php echo $meta_for_layout['title'];?>"/>
<?php } ?>
<meta property="og:site_name" content="<?php echo Configure::read('site.name'); ?>"/>
<meta property="og:image" content="<?php echo $this->Html->assetUrl('logo.png', array('pathPrefix' => IMAGES_URL));?>"/>
<?php
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
    echo '-->', "\n";
endif;
?>
<?php echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));?>
<?php echo $scripts_for_layout; ?>
</head>
<body>
<div id="<?php echo $this->Html->getUniquePageId();?>" class="content entry-content">
<div class="wrapper">

<?php echo $content_for_layout; ?>
<div class="footer-push"></div>
</div>

 <footer id="footer ">
    <div class="sep-top space thumbnail">
      <div class="container">
        <div class="row top-mspace top-space">
          <div class="span20">
		  <div class="clearfix"> <?php echo $this->Layout->menu('footer1'); ?>
            <p class="span no-mar">&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), Router::url('/',true), array('class' => 'site-name textb', 'title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
			<p class="powered clearfix span sfont no-mar"><span class="pull-left"><a href="http://360contest.dev.agriya.com/" title="<?php echo __l('Powered by ') . Configure::read('site.name');?>" target="_blank" class="powered"><?php echo __l('Powered by ') . Configure::read('site.name');?></a></span> <span class="made-in pull-left">, <?php echo __l('made in'); ?></span> <?php echo $this->Html->link(__l('Agriya Web Development'), 'http://www.agriya.com/', array('target' => '_blank', 'title' => __l('Agriya Web Development'), 'class' => 'company pull-left'));?> <span class="pull-left"><?php echo Configure::read('site.version');?></span></p>
            <p class="span" id="cssilize"><?php echo $this->Html->link(__l('CSSilized by CSSilize, PSD to XHTML Conversion'), 'http://www.cssilize.com/', array('target' => '_blank', 'title' => __l('CSSilized by CSSilize, PSD to XHTML Conversion')));?></p>
          </div></div>
          <ul class="unstyled pull-right">
            <li class="pull-left"><a title="Facebook" href="<?php echo Configure::read('facebook.site_facebook_url'); ?>"><i class="icon-facebook-sign graylight no-pad text-24"></i></a></li>
            <li class="pull-left"><a title="Twitter" href="<?php echo Configure::read('twitter.site_twitter_url'); ?>"><i class="icon-twitter-sign no-pad graylight text-24"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</div>
</body>
</html>
