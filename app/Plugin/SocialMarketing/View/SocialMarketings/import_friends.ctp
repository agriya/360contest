<h2 class="ver-space ver-mspace"><?php echo $this->pageTitle; ?></h2>
<div class="thumbnail clearfix sep">
	<div class="clearfix space">
  	<div class="clearfix">
    <h4 >
     
        <span class="label span5 space dc text-12 share-follow <?php echo ($this->request->params['named']['type'] == 'facebook')? 'label-important' : ''; ?>"><?php echo __l('Facebook'); ?></span>
        <span class="label span5 space dc text-12 share-follow <?php echo ($this->request->params['named']['type'] == 'twitter') ? 'label-important' : ''; ?>"><?php echo __l('Twitter'); ?></span>
        <span class="label span5 space dc text-12 share-follow <?php echo ($this->request->params['named']['type'] == 'gmail')? 'label-important' : ''; ?>"><?php echo __l('Gmail'); ?></span>
        <span class="label span5 space dc text-12 share-follow <?php echo ($this->request->params['named']['type'] == 'yahoo')? 'label-important' : ''; ?>"><?php echo __l('Yahoo!'); ?></span>
    </h4>
  </div>
<?php $user = $this->Html->getCurrUserInfo($this->Auth->user('id'));?>
  	<div class="span23 space social-block">
    <div class="span" id="myTabContent">
      <?php if ($this->request->params['named']['type'] == 'facebook') { ?>
      <div id="facebook" class="loader fade in active" data-fb_app_id="<?php echo Configure::read('facebook.fb_app_id') ?>">
        <?php
          if (!empty($user['User']['facebook_access_token'])) {
            $replace_content = array(
            '##SITE_NAME##' => Configure::read('site.name'),
            '##REFERRAL_URL##' => Router::url('/', true). 'r:'.$this->Auth->user('username')
            );
            $share_content = strtr(Configure::read('invite.facebook'), $replace_content);
            $feed_url = 'https://www.facebook.com/dialog/apprequests?app_id=' . Configure::read('facebook.fb_app_id') . '&display=iframe&access_token=' . $user['User']['facebook_access_token'] . '&show_error=true&link=' . Router::url('/', true) . '&message=' . $share_content. '&data=' . $this->Auth->user('id') . '&redirect_uri=' . Router::url('/', true) . 'social_marketings/publish_success/invite';
        ?>
		<div id="js-fb-login-check" class="hide">
        <div class="span16">
          <iframe src="<?php echo $feed_url; ?>" height="500" width="500"  frameborder="0" scrolling="no"></iframe>
        </div>
        <div class="span5">
          <?php echo $this->element('follow-friends', array('type' => 'facebook', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
        </div>
		</div>
        <?php
          }
            $connect_url = Router::url(array(
            'controller' => 'social_marketings',
            'action' => 'import_friends',
            'type' => 'facebook',
            'import' => 'facebook',
            ), true);
        ?>
		<div id="js-fb-invite-friends-btn" class="hide">
			<div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Facebook because you haven't connected Facebook. Click the button below to connect.")?></div>
			<div class="dc"><div class="social-login-icon"><?php echo $this->Html->link($this->Html->image('find-friends-facebook.png', array('alt' => __l('Find Friends From Facebook'), 'class'=>'img js-connect {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'facebook'), array('title' => __('Find Friends From Facebook'),'escape' => false)); ?></div></div>
		</div>
      </div>
      <?php } elseif ($this->request->params['named']['type'] == 'twitter') { ?>
      <div id="twitter">
        <?php if (!empty($user['User']['is_twitter_connected'])) { ?>
        <?php
          $redirect_url = Router::url(array(
          'controller' => 'social_marketings',
          'action' => 'import_friends',
          'type' => 'gmail'
          ), true);
          $replace_content = array(
          "##SITE_NAME##"=> Configure::read('site.name'),
          "##REFERRAL_URL##"=>Router::url('/', true). 'r:'.$this->Auth->user('username')
          );
          $default_content = strtr(Configure::read('invite.twitter'), $replace_content);
        ?>
        <div class="span16">&nbsp;
			<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo Router::url('/', true); ?>" data-text="<?php echo $default_content;?>" data-size="large">Tweet</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
        </div>
        <div class="span5">
          <?php echo $this->element('follow-friends', array('type' => 'twitter', 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
        </div>
        <?php } else { ?>
        <?php
          $connect_url = Router::url(array(
          'controller' => 'social_marketings',
          'action' => 'import_friends',
          'type' => 'twitter',
          'import' => 'twitter',
          ), true);
        ?>
        <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Twitter because you haven't connected Twitter. Click the button below to connect.")?></div>
        <div class="dc"><div class="social-login-icon"><?php echo $this->Html->link($this->Html->image('find-friends-twitter.png', array('alt' => __l('Find Friends From Twitter'), 'class'=>'img js-connect {"url":"' . $connect_url . '"}')), $connect_url, array('title' => __l('Find Friends From Twitter'), 'escape' => false)); ?></div></div>
        <?php } ?>
      </div>
      <?php } elseif ($this->request->params['named']['type'] == 'gmail') { ?>
      <div id="gmail">
        <?php if (!empty($user['User']['is_google_connected'])) { ?>
        <?php  echo $this->element('contacts-index', array('type' => 'gmail')); ?>
        <?php } else { ?>
        <?php
          $connect_url = Router::url(array(
          'controller' => 'social_marketings',
          'action' => 'import_friends',
          'type' => $this->request->params['named']['type'],
          'import' => 'google',
          ), true);
        ?>
        <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Gmail because you haven't connected Gmail. Click the button below to connect.")?></div>
        <div class="dc"><div class="social-login-icon"><?php echo $this->Html->link($this->Html->image('find-friends-gmail.png', array('alt' => __l('Find Friends From Gmail'), 'class'=>'img js-connect {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'google'), array('title' => __('Find Friends From Gmail'), 'escape' => false)); ?></div></div>
        <?php } ?>
      </div>
      <?php } elseif ($this->request->params['named']['type'] == 'yahoo') { ?>
      <div id="yahoo">
        <?php if (!empty($user['User']['is_yahoo_connected'])) { ?>
        <?php  echo $this->element('contacts-index', array('type' => 'yahoo')); ?>
        <?php } else { ?>
        <?php
          $connect_url = Router::url(array(
          'controller' => 'social_marketings',
          'action' => 'import_friends',
          'type' => $this->request->params['named']['type'],
          'import' => 'yahoo',
          ), true);
          $connect_url.= '?r=' . $this->request->url;
        ?>
        <div class="alert alert-info"><?php echo __l("We couldn't find any of your friends from Yahoo! because you haven't connected Yahoo. Click the button below to connect.")?></div>
        <div class="dc"><div class="social-login-icon"><?php echo $this->Html->link($this->Html->image('find-friends-yahoo.png', array('alt' => __l('Find Friends From Yahoo!'), 'class'=>'img js-connect {"url":"'.$connect_url.'"}')), array('controller' => 'social_marketings', 'action' => 'import_friends', 'type' => $this->request->params['named']['type'], 'import' => 'yahoo'), array('title' => __('Find Friends From Yahoo'), 'escape' => false)); ?></div></div>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </div>
	  <div class="span2 pull-right space">
    <?php
      if ($this->request->params['named']['type'] == 'yahoo') {
        echo $this->Html->link(__l('Done'), array('controller' => 'users', 'action' => 'dashboard'), array('title' => __l('Done'), 'class' => 'btn pull-right js-tooltip mspace'));
      } else {
        echo $this->Html->link(__l('Skip') . ' >>', array('controller' => 'social_marketings', 'action' => 'import_friends',  'type' => $next_action), array('title' => 'Skip', 'class' => 'grayc skip pull-right mspace'));
      }
    ?>
  </div>
  </div>
</div>