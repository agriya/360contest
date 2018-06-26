<?php

$js_class = '';
if($this->Auth->sessionValid()){
	$js_class = "js-star-rating";
}
$current_rating_percentage = $current_rating*20;
if(isPluginEnabled('HighPerformance')&& (isset($this->request->params['prefix']) && $this->request->params['prefix'] != 'admin') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
	<div class='span blcu-vr-<?php echo $contest_user_id;?> hide'>
		<ul class="no-mar span star-rating">
			<li class="current-rating" style="width:<?php echo $current_rating_percentage;?>%;" title="<?php echo $current_rating;?>/5 <?php echo __l('Stars');?>"><?php echo $current_rating;?>/5 <?php echo __l('Stars');?></li>
		</ul>
	</div>
	<div class='alcu-r-<?php echo $contest_user_id;?> hide'>
		<ul class="no-mar star-rating">
			<li class="current-rating" style="width:<?php echo $current_rating_percentage;?>%;" title="<?php echo $current_rating;?>/5 <?php echo __l('Stars');?>"><?php echo $current_rating;?>/5 <?php echo __l('Stars');?></li>
			<li><?php echo $this->Html->link('1', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 1, 'admin'=> false), array('class' => 'js-no-pjax one-star ' . $js_class, 'title' => __l('1 star out of 5')))?></li> 
			<li><?php echo $this->Html->link('2', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 2, 'admin'=> false), array('class' => 'js-no-pjax two-stars ' . $js_class, 'title' => __l('2 star out of 5')))?></li>
			<li><?php echo $this->Html->link('3', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 3, 'admin'=> false), array('class' => 'js-no-pjax three-stars ' . $js_class, 'title' => __l('3 star out of 5')))?></li>
			<li><?php echo $this->Html->link('4', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 4, 'admin'=> false), array('class' => 'js-no-pjax four-stars ' . $js_class, 'title' => __l('4 star out of 5')))?></li>
			<li><?php echo $this->Html->link('5', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 5, 'admin'=> false), array('class' => 'js-no-pjax five-stars ' . $js_class, 'title' => __l('5 star out of 5')))?></li>
		</ul>
	</div>
	<div class='alcu-vr-<?php echo $contest_user_id;?> hide'>
		<ul class="no-mar star-rating">
			<li class="current-rating" style="width:<?php echo $current_rating_percentage;?>%;" title="<?php echo $current_rating;?>/5 <?php echo __l('Stars');?>"><?php echo $current_rating;?>/5 <?php echo __l('Stars');?></li>
		</ul>
	</div>
<?php } else { ?>
<ul class="no-mar span star-rating">
	<li class="current-rating" style="width:<?php echo $current_rating_percentage;?>%;" title="<?php echo $current_rating;?>/5 <?php echo __l('Stars');?>"><?php echo $current_rating;?>/5 <?php echo __l('Stars');?></li>
<?php
	if ($canRate) :
?>
	<li><?php echo $this->Html->link('1', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 1, 'admin'=> false), array('class' => 'js-no-pjax one-star ' . $js_class, 'title' => __l('1 star out of 5')))?></li> 
    <li><?php echo $this->Html->link('2', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 2, 'admin'=> false), array('class' => 'js-no-pjax two-stars ' . $js_class, 'title' => __l('2 star out of 5')))?></li>
    <li><?php echo $this->Html->link('3', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 3, 'admin'=> false), array('class' => 'js-no-pjax three-stars ' . $js_class, 'title' => __l('3 star out of 5')))?></li>
    <li><?php echo $this->Html->link('4', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 4, 'admin'=> false), array('class' => 'js-no-pjax four-stars ' . $js_class, 'title' => __l('4 star out of 5')))?></li>
    <li><?php echo $this->Html->link('5', array('controller' => 'contest_user_ratings', 'action' => 'add', $contest_user_id, 5, 'admin'=> false), array('class' => 'js-no-pjax five-stars ' . $js_class, 'title' => __l('5 star out of 5')))?></li>
<?php
    endif;
?>
</ul>
<?php } ?>