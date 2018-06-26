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
<?php echo $this->fetch('seo_paging'); ?>
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
<?php if (Configure::read('facebook.fb_user_id')): ?>
  <meta property="fb:admins" content="<?php echo Configure::read('facebook.fb_user_id'); ?>"/>
<?php endif; ?>
<?php
if (strpos(env('HTTP_USER_AGENT'), 'facebookexternalhit')===false):
    echo '-->', "\n";
endif;
?>
<?php 
	//echo $this->element('site_tracker', array('cache' => array('config' => 'sec')));
	$response = Cms::dispatchEvent('View.IntegratedGoogleAnalytics.pushScript', $this);
    //echo !empty($response->data['content']) ? $response->data['content'] : '';
?>
<?php echo $scripts_for_layout; ?>
<?php
	if (env('HTTP_X_PJAX') != 'true') {
		//echo $this->fetch('highperformance');
	}
?>
</head>
<body>
<?php if(!empty($this->request->params['action'])&& ($this->request->params['action']=='home')):
$id= "index";
elseif($this->Html->getUniquePageId()=='contests-view'):
$id='contest-details';
else:
$id= $this->Html->getUniquePageId();
endif;?>
<div id="<?php echo $id;?>" class="content">

  <div class="wrapper">
  <?php
    $header_class = '';
    if ($this->Auth->sessionValid()) {
		if ($this->Auth->user('role_id') != ConstUserTypes::Admin) {
		  $header_class = 'fixed-nav-container';
		} elseif ($this->Auth->user('role_id') == ConstUserTypes::Admin) {
		  if ($this->request->url == '') {
		  $header_class = 'fixed-admin-home-nav-container';
		  } else {
		  $header_class = 'fixed-admin-nav-container';
		  }
		}
    }
  ?>
	<?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
	<div class="alab hide"> <?php //after login admin panel?>
		<div class="well no-mar no-pad adminc container-fluid useradminpannel">
			<div class="no-mar hor-space top-smspace dc clearfix">
				<h1 class="span8 no-pad">
<?php
				echo $this->Html->link((Configure::read('site.name').' '.'<span class="sfont"><small class="sfont textb"> Admin</small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false,'class' => 'brand text-16 textb js-no-pjax', 'title' => (Configure::read('site.name').' '.'Admin')));
?>
				</h1>
				<div class="pull-right mob-clr admin-header-right-menu">
					<ul class="unstyled span no-mar">
						<li class="span pull-left">
 <?php
						echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('class' => 'js-no-pjax blackc', 'title' => __l('My Account')));
?>
			            </li>
						<li class="span pull-left">
<?php
						echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'blackc js-no-pjax', 'title' => __l('Logout')));
?>
			            </li>
					</ul>
				</div>
				<div class="container con-height clearfix">
					<span class="grayc"><?php echo __l('You are logged in as Admin'); ?></span>
					<div class="alap hide"></div>
				</div>
          <!-- /.nav-collapse -->
        </div>
        </div>
	</div>
<?php } else { ?>
  	<?php if($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
		<div class="well no-mar no-pad adminc container-fluid useradminpannel">
			<div class="no-mar hor-space top-smspace dc clearfix">
				<h1 class="span8 no-pad">
<?php
				echo $this->Html->link((Configure::read('site.name').' '.'<span class="sfont"><small class="sfont textb"> Admin</small></span>'), array('controller' => 'users', 'action' => 'stats', 'admin' => true), array('escape' => false,'class' => 'brand text-16 textb js-no-pjax', 'title' => (Configure::read('site.name').' '.'Admin')));
?>
				</h1>
				<div class="pull-right mob-clr admin-header-right-menu">
					<ul class="unstyled span no-mar">
						<li class="span pull-left">
 <?php
						echo $this->Html->link(__l('My Account'), array('controller' => 'user_profiles', 'action' => 'edit', $this->Auth->user('id')), array('class' => 'js-no-pjax blackc', 'title' => __l('My Account')));
?>
			            </li>
						<li class="span pull-left">
<?php
						echo $this->Html->link(__l('Logout'), array('controller' => 'users', 'action' => 'logout'), array('class' => 'blackc js-no-pjax', 'title' => __l('Logout')));
?>
			            </li>
					</ul>
				</div>
				<div class="container con-height clearfix">
					<span class="grayc"><?php echo __l('You are logged in as Admin'); ?></span>
					<div class="alap">
					<?php if ($this->request->params['controller']=='contests' && $this->request->params['action']=='view') {
					 echo $this->element('admin_panel_contest_view', array('controller' => 'contests', 'action' => 'index', 'contest' => $contest)); ?>
					<?php } else if ($this->request->params['controller']=='users' && $this->request->params['action']=='view'){
					 echo $this->element('admin_panel_user_view');
					 }
					?>
					</div>
				</div>
          <!-- /.nav-collapse -->
        </div>
        </div>
<?php endif; ?>
<?php } ?>
    <header id="header" class="<?php echo $header_class; ?>">
      <div class="navbar no-mar">
        <div class="navbar-inner no-pad no-round">
          <div class="container clearfix">
            <h1 class="span top-space"><?php echo $this->Html->link($this->Html->image('logo.png', array('alt'=> '[Image: '.Configure::read('site.name').']')),  '/', array('escape' => false, 'class' => 'brand', 'title' => Configure::read('site.name')));?></h1>
            <a data-target=".nav-collapse" data-toggle="collapse" class="btn btn-navbar hor-mspace"> <i class="icon-align-justify icon-24 blackc"></i></a>
            <div class="nav-collapse clearfix">
              <ul class="nav">
				<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'contest_types' && $this->request->params['action'] == 'index')|| ($this->request->params['controller'] == 'contests' && $this->request->params['action'] == 'add')||($this->request->params['controller'] == 'contests' && $this->request->params['action'] == 'prizing_selection')? 'active' : null; ?>
				<li class="dc sep-left pull-left js-post-your-contest <?php echo $class; ?>"> <?php echo $this->Html->link('<span class="show dc text-20"><i class="icon-plus-sign no-pad"></i></span><span class="show top-smspace">'.__l('Post Your Contest').'</span>', array('controller' => 'contest_types', 'action' => 'index', 'admin' => false), array('escape' => false, 'title'=>__l('Post Your Contest'), 'class' => 'clearfix dc')); ?></li>
				<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'contests' && $this->request->params['action'] == 'browse') ? 'active' : null; ?>
                <li class="dc sep-left pull-left js-browse-contest <?php echo $class; ?>">
				<?php echo $this->Html->link('<span class="show dc text-20"><i class="icon-trophy no-pad"></i></span><span class="show top-smspace">'.__l('Browse Contests').'</span>', array('controller' => 'contests', 'action' => 'browse', 'admin' => false), array('escape' => false, 'title'=>__l('Browse Contests'), 'class' => 'clearfix')); ?>
				</li>
				<?php $class = (!empty($this->request->params['controller']) && !empty($this->request->params['action']) && $this->request->params['controller'] == 'nodes' && $this->request->params['action'] == 'how_it_works') ? 'active' : null; ?>
                <li class="dc sep-left pull-left sep-right js-how-it-works <?php echo $class; ?>"> <?php echo $this->Html->link('<span class="show dc text-20"><i class="icon-question-sign no-pad"></i></span> <span class="show top-smspace">'.__l('How it Works').'</span>', array('controller'=> 'nodes', 'action'=>'how_it_works', 'admin' => false), array('escape' => false, 'title'=>__l('How it Works'), 'class' => 'clearfix')); ?></li>
              </ul>
               <?php echo $this->element('header-menu'); ?>
            </div>
          </div>
        </div>
      </div>
    </header>
	<section id="pjax-body">
	<?php 
	if (env('HTTP_X_PJAX') == 'true') {
		echo $this->fetch('highperformance'); 
	}
	?>
    <section id="main" class="clearfix main">
		<div class="<?php echo !(!empty($this->request->params['controller']) && !empty($this->request->params['action']) && (($this->request->params['controller'] == 'nodes') && ($this->request->params['action'] == 'home')) || (($this->request->params['controller'] == 'contest_types' || $this->request->params['controller'] == 'affiliates' || $this->request->params['controller'] == 'transactions' || $this->request->params['controller'] == 'contest_users' || $this->request->params['controller'] == 'affiliate_cash_withdrawals') && $this->request->params['action'] == 'index') || ($this->request->params['controller'] == 'contests' && ($this->request->params['action'] == 'add' || $this->request->params['action'] == 'view' || $this->request->params['action'] == 'index')) || ($this->request->params['controller'] == 'users' && ($this->request->params['action'] == 'view' || $this->request->params['action'] == 'dashboard')))?'container':'' ?>">
		  <?php echo $this->Layout->sessionFlash(); ?>
	      <?php echo $content_for_layout; ?>
    </section>
    </section>
    <div class="footer-push"></div>
  </div>

  <footer id="footer ">
      <?php if (Configure::read('widget.footer_script')) { ?>
      <div class="dc clearfix bot-space">
      <?php echo Configure::read('widget.footer_script'); ?>
      </div>
    <?php } ?>
    <div class="sep-top space thumbnail">
      <div class="container">
        <div class="row">
          <div class="span20">
		  <div class="clearfix"> <?php echo $this->Layout->menu('footer1'); ?>
            <p class="span no-mar ver-space">&copy;<?php echo date('Y');?> <?php echo $this->Html->link(Configure::read('site.name'), '/', array('class' => 'site-name textb', 'title' => Configure::read('site.name'), 'escape' => false));?>. <?php echo __l('All rights reserved');?>.</p>
			<p class="powered clearfix span sfont no-mar space"><span class="pull-left"><a href="http://360contest.dev.agriya.com/" title="<?php echo __l('Powered by ') . Configure::read('site.name');?>" target="_blank" class="powered"><?php echo __l('Powered by ') . Configure::read('site.name');?></a></span> <span class="made-in pull-left">, <?php echo __l('made in'); ?></span> <?php echo $this->Html->link(__l('Agriya Web Development'), 'http://www.agriya.com/', array('target' => '_blank', 'title' => __l('Agriya Web Development'), 'class' => 'company pull-left'));?> <span class="pull-left"><?php echo Configure::read('site.version');?></span></p>
            <p class="span no-mar ver-space" id="cssilize"><?php echo $this->Html->link(__l('CSSilized by CSSilize, PSD to XHTML Conversion'), 'http://www.cssilize.com/', array('target' => '_blank', 'title' => __l('CSSilized by CSSilize, PSD to XHTML Conversion')));?></p>
          </div></div>
          <ul class="unstyled pull-right">
            <li class="pull-left"><a title="Facebook" target = "_blank" href="<?php echo Configure::read('facebook.site_facebook_url'); ?>"><i class="icon-facebook-sign graylight no-pad text-24"></i></a></li>
            <li class="pull-left"><a title="Twitter" target = "_blank" href="<?php echo Configure::read('twitter.site_twitter_url'); ?>"><i class="icon-twitter-sign no-pad graylight text-24"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
</div>
</body>
</html>