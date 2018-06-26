	<div class="top-space">
      <div class="row">
         
<?php if(!Configure::read('site.maintenance_mode')):?>
<h2 class="ver-space"><?php echo __l('Login');?></h2>
<section class="clearfix">
  <article class="span13">
  <?php if (Configure::read('facebook.is_enabled_facebook_connect')): ?>
  <div class="ver-space">
  <div class="row ver-space sep-bot">
    <div class="span5 login-block pr">
    <?php if (isPluginEnabled('SocialMarketing')) { ?>
    <span class="js-facepile-loader loader pull-left offset1 pa space"></span>
    <span id="js-facepile-section" class="{'fb_app_id':'<?php echo Configure::read('facebook.fb_app_id'); ?>'} sfont"></span>
    <?php } ?>
    &nbsp;
    </div>
    <div class="span7 pull-right login-twtface space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'facebook', 'admin' => false), true); ?>
    <?php echo $this->Html->link($this->Html->image('facebook.png', array('alt' => __l('Login with Facebook'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?>
    </div>
  </div>
  </div>
  <?php endif; ?>
  
    <?php if (Configure::read('twitter.is_enabled_twitter_connect')): ?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'twitter', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('twitter.png', array('alt' => __l('Login with Twitter'),'class'=>'img')), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif; ?>

  <?php if(Configure::read('linkedin.is_enabled_linkedin_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'linkedin', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-linkedin.png', array('alt' => __l('Login with LinkedIn'),'class'=>'img')), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif; ?>
  <?php if (Configure::read('yahoo.is_enabled_yahoo_connect')): ?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'yahoo', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-yahoo.png', array('alt' => __l('Login with Yahoo!'),'class'=>'img')), '#', array('escape' => false, 'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif;?>
  <?php if(Configure::read('google.is_enabled_google_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'google', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-google.png', array('alt' => __l('Login with Google'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
  <?php endif;?> 
  <?php if(Configure::read('googleplus.is_enabled_googleplus_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace sep-bot">
  <div class="span7 offset3 bot-space">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'googleplus', 'admin' => false), true); ?>
    <div class="row"><?php echo $this->Html->link($this->Html->image('login-googleplus.png', array('alt' => __l('Login with GooglePlus'),'class'=>'img bot-space')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></div>
  </div>
  </div>
  <?php endif;?>
  <?php if(Configure::read('openid.is_enabled_openid_connect')):?>
  <h4 class="dc pr  bot-space"><span class="space or-hor pa textb"><?php echo __l('Or');?></span></h4>
  <div class="row page-header space no-border ver-mspace mspace ">
  <div class="span7 offset3 ">
    <?php $url = Router::url(array('controller' => 'users', 'action' => 'login', 'type' => 'openid', 'admin' => false), true); ?>
    <p class="row"><?php echo $this->Html->link($this->Html->image('login-openid.png', array('alt' => __l('Login with OpenId'),'class'=>'img')), '#', array('escape' => false,'class' => "js-connect js-no-pjax {'url':'$url'}")); ?></p>
  </div>
  </div>
   <?php endif;?>
  </article>
  
  <h4 class="span ver-space  top-mspace pr"><span class="or-ver pa"><?php echo __l('Or');?></span></h4>
  <aside class="span10 sep-left pull-right mob-clr">
  <?php else:?>
  <h2 class="ver-space dl"><?php echo __l('Login');?></h2>
  <section class="clearfix">
  <?php endif;?>
  <?php echo $this->Form->create('User', array('action' => 'login','class' => 'form-horizontal ver-space form-login'));
  echo $this->Form->input(Configure::read('user.using_to_login'));
  echo $this->Form->input('passwd', array('label' => __l('Password')));?>
  <?php echo $this->Form->input('User.is_remember', array('type' => 'checkbox', 'label' => __l('Remember me on this computer.')));?>
  <p class="info">
  <?php echo $this->Html->link(__l('Forgot your password?') , array('controller' => 'users', 'action' => 'forgot_password', 'admin' => false),array('title' => __l('Forgot your password?'), 'class' => 'js-no-pjax')); ?>
  <?php if (!(!empty($this->request->params['prefix']) && $this->request->params['prefix'] == 'admin') && empty($this->request->params['requested'])):  ?> | <?php echo $this->Html->link(__l('Sign Up'), array('controller' => 'users', 'action' => 'register', 'type' => 'social', 'admin' => false), array('title' => __l('Signup')));?><?php endif; ?>
  <?php
  $f = (!empty($_GET['f'])) ? $_GET['f'] : ((!empty($this->request->data['User']['f'])) ? $this->request->data['User']['f'] : (($this->request->params['controller'] != 'users' && ($this->request->params['action'] != 'login' && $this->request->params['action'] != 'admin_login')) ? $this->request->url : ''));
  if (!empty($f)):
    echo $this->Form->input('f', array('type' => 'hidden', 'value' => $f));
  endif;
  ?>
  </p>
  <div class="no-bor">
  <?php echo $this->Form->submit(__l('Login'), array('class' => 'btn btn-sccuess')); ?>
  </div>
  <?php echo $this->Form->end(); ?>
  <?php if(!Configure::read('site.maintenance_mode')):?>
  </aside>
  <?php endif;?>
</section>
<div id="fb-root"></div>
		<div id="fb-root"></div>
   </div>
</div>