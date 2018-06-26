<div class="comment-form">
  <h3><?php echo __l('Add new comment'); ?></h3>
<?php
        $type = $types_for_layout[$node['Node']['type']];
		if ($this->request->params['controller'] == 'comments') {
            $nodeLink = $this->Html->link(__l('Go back to original post') . ': ' . $node['Node']['title'], $node['Node']['url']);
            echo $this->Html->tag('p', $nodeLink, array('class' => 'back'));
        }
        $formUrl = array('controller' => 'comments', 'action' => 'add', $node['Node']['id']);
        if (isset($parentId) && $parentId != null) {
            $formUrl[] = $parentId;
        }
        echo $this->Form->create('Comment', array('class' => 'normal', 'url' => $formUrl));
		if ($this->Session->check('Auth.User.id')) {
			echo $this->Form->input('Comment.name', array('label' => __l('Name'), 'value' => $this->Session->read('Auth.User.name'), 'readonly' => 'readonly'));
			echo $this->Form->input('Comment.email', array('label' => __l('Email'), 'value' => $this->Session->read('Auth.User.email'), 'readonly' => 'readonly'));
			echo $this->Form->input('Comment.website', array('label' => __l('Website'), 'value' => $this->Session->read('Auth.User.website'), 'readonly' => 'readonly'));
			echo $this->Form->input('Comment.body', array('label' => false));
		} else {
			echo $this->Form->input('Comment.name', array('label' => __l('Name')));
			echo $this->Form->input('Comment.email', array('label' => __l('Email')));
			echo $this->Form->input('Comment.website', array('label' => __l('Website')));
			echo $this->Form->input('Comment.body', array('label' => false));
		}
?>
  <div class="captcha-block clearfix js-captcha-container">
    <div class="captcha-left grid_left"> <?php echo $this->Html->image($this->Html->url(array('controller' => 'comments', 'action' => 'show_captcha', md5(uniqid(time()))), true), array('alt' => __l('[Image: CAPTCHA image. You will need to recognize the text in it; audible CAPTCHA available too.]'), 'title' => __l('CAPTCHA image'), 'class' => 'captcha-img'));?> </div>
    <div class="captcha-right grid_left"> <?php echo $this->Html->link(__l('Reload CAPTCHA'), '#', array('class' => 'js-captcha-reload captcha-reload', 'title' => __l('Reload CAPTCHA')));?>
      <div class="play-link"> <?php echo $this->Html->link(__l('Click to play'), Router::url('/', true)."flash/securimage/play.swf?audio=". $this->Html->url(array('controller' => 'comments', 'action'=>'captcha_play', 'comments'), true) ."&bgColor1=#777&bgColor2=#fff&iconColor=#000&roundedCorner=5&height=19&width=19&wmode=transparent", array('class' => 'js-captcha-play js-no-pjax')); ?> </div>
    </div>
  </div>
<?php echo $this->Form->input('Comment.captcha', array('label' => __l('Security Code'))); ?>
<?php
	echo $this->Form->end(__l('Post comment'));
?>
</div>
