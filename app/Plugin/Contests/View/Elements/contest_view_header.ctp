	<div class="bot-space">
	<section id="user-details" class="row no-mar">
	  <div class="ver-space row top-mspace follow">
      <?php if(isPluginEnabled('ContestFollowers')) :?>
		<?php if($contest['User']['id'] == $this->Auth->user('id')) :?>
		  <span class="disabled btn btn-module ver-mspace dc span2 text-14 btn-success textb no-mar js-tooltip" title="Reason: You Can't follow your own contest">Follow</span>
		  <?php else:
				$userid = $this->Auth->user('id');
				if($userid != $contest['User']['id']){
					$js_class = '';
					if($this->Auth->sessionValid()){
						$js_class = "js-like";
					}
						if (empty($contest['ContestFollower'])) :
							echo $this->Html->link(__l('Follow'), array('controller' => 'contest_followers', 'action' => 'add', $contest['Contest']['id'], 'admin'=> false), array('class'=>'js-tooltip btn span2 no-mar text-14 btn-success textb ' . $js_class,'title' => __l('Follow'),'escape' => false));
						else:
							echo $this->Html->link(__l('Following'), array('controller' => 'contest_followers', 'action' => 'delete', $contest['Contest']['id'], 'admin'=> false), array('class'=>'btn span2 no-mar text-14 btn-success textb js-tooltip js-unfollow ' . $js_class,'title' => __l('Unfollow'),'escape' => false));
						endif;
				}
			endif;
		?>
        <?php endif; ?>
		<h2 class="hor-space span pull-left"><span class="pull-left"><?php echo (isset($page))? $page : __l('Submit Your Work').' - ';?></span><?php echo $this->Html->link($this->Html->cText($contest['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug']), array('title' =>$this->Html->cText($contest['Contest']['name'], false), 'class' => 'span10 htruncate', 'escape' => false));?></h2>
	  </div>
	  <div class="row no-mar top-space">
		<div class="row span24">
		  <div class="grayc bot-mspace bot-space row">
		 <div class="thumbnail sep-bot pull-left">
		 <?php echo $this->Html->getUserAvatarLink($contest['User'], 'normal_thumb',true); ?> </div>
			<div class="span bot-space">
			<p class="no-mar">
				<?php if(!empty($contest['Contest']['is_featured'])):?>
				<span title="<?php echo __l('Featured'); ?>"><i class="icon-star text-14"></i></span>
				<?php
				 endif;
				 if(!empty($contest['Contest']['is_blind'])):
				?>
				<span title="<?php echo __l('Blind'); ?>"><i class="icon-eye-close text-14"></i></span>
				 <?php
				 endif;
				 if(!empty($contest['Contest']['is_private'])):
				 ?>
				<span title="<?php echo __l('Private'); ?>"><i class="icon-lock text-14"></i></span>
				<?php  endif; ?>
				<span>
				<?php if(!isset($f)){ 
					$f = '';
				}
				if ($contest['User']['id'] != $this->Auth->user('id')):
				echo $this->Html->link('<i class="icon-flag text-14"></i> '.__l('Report Contest'), array('controller'=>'contest_flags','action' => 'add', $contest['Contest']['id'], 'f' => $f, 'plugin'=>'contests'), array('title' => __l('Report Contest'),'class' => 'pinkc js-no-pjax', 'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false));
				endif;
				?></span>
			  </p>
			  <p> <span><?php echo __l('Creator'); ?>: <?php echo $this->Html->link(__l($contest['User']['username']), array('controller'=>'users','action' => 'view', $contest['User']['username']), array('class' =>'grayc', 'title' => __l($contest['User']['username'])));?> </span> <span class="hor-space"> <?php echo __l('Category'); ?>: <?php echo $this->Html->cText($contest['ContestType']['name'],false);?></span></p>
			</div>
			<div class="js-share {'img_url':'<?php echo Router::url('/', true) . 'img/logo.png'?>','url':'<?php echo Router::url(array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug']), true);?>','title':'<?php echo urlencode_rfc3986(htmlentities($contest['Contest']['name'], ENT_QUOTES),false);?>','id':'<?php echo $contest['Contest']['id'];?>'}">
				  <div class="pull-right span10 top-space js-init-share-<?php echo $contest['Contest']['id'];?>">
							<?php
								$contest_url = Router::url(array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug']), true);
								$contest_title = htmlentities($contest['Contest']['name'], ENT_QUOTES);
							?>

					<ul class="unstyled row no-mar  js-share">
							<li class="span no-mar"><a href="http://www.facebook.com/sharer.php?u=<?php echo $contest_url; ?>&amp;t=<?php echo urlencode($contest_title); ?>" class="socialite facebook-like blackc" data-href="<?php echo $contest_url; ?>" data-send="false" data-layout="button_count" data-width="60" data-show-faces="false" rel="nofollow" target="_blank"></a></li>
							<li class="span no-mar left-space"><a href="http://twitter.com/share" class="socialite twitter-share blackc" data-text="<?php echo $contest_title; ?>" data-url="<?php echo $contest_url; ?>" data-count="none" data-via="<?php echo Configure::read('twitter.username'); ?>" rel="nofollow" target="_blank"><span class="vhidden">
								<?php echo $this->Html->image('social-media.png', array('alt' => __l('[Image: Twitter]') ,)); ?></span></a></li>
							<li class="span no-mar left-space"><a href="http://pinterest.com/pin/create/button/?url=<?php echo $contest_url; ?>/&amp;media=&amp;description=<?php echo urlencode($contest_title); ?>" class="socialite pinterest-pinit blackc" count-layout="horizontal"></a></li>
							<li class="span no-mar left-space"><a href="https://plus.google.com/share?url=<?php echo $contest_url; ?>" class="socialite googleplus-one blackc" data-size="medium" data-href="<?php echo $contest_url; ?>" rel="nofollow" target="_blank"></a></li>
							
						</ul>
				  </div>
				</div>
		</div>
		</div>
		</div>
	</section>
	</div>
	<div class="top-pattern hightlight-bar sep-bot ver-space">
		<div class="clearfix">
			<div class="span row no-mar top-space">
			  <div class="span5 row no-mar"> <span class="label label-important span1 dc space no-mar"><i class="icon-ok no-pad text-24 whitec"></i></span>
				<dl class="pull-left hor-smspace grayc">
				  <dt class="textn"><?php echo __l('Followers');?></dt>
				  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($contest['Contest']['contest_follower_count']);?></dd>
				</dl>
			  </div>
			  <div class="span5 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-trophy no-pad text-24 whitec"></i></span>
				<dl class="pull-left hor-smspace grayc">
				  <dt class="textn"><?php echo __l('Prize');?></dt>
				  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['prize']);?></dd>
				</dl>
			  </div>
			  <div class="span6 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-calendar no-pad text-24 whitec"></i></span>
				<dl class="pull-left hor-smspace grayc">
				  <dt class="textn"><?php echo __l('Ends On');?></dt>
				  <dd class="blackc text-20 no-mar textb">
					<?php
					if($contest['Contest']['actual_end_date'] != null && $contest['Contest']['actual_end_date'] != '0000-00-00 00:00:00') {
						echo $this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']);
					}
					?>
				  </dd>
				</dl>
			  </div>
			  <div class="span5 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-file no-pad text-24 whitec"></i></span>
				<dl class="pull-left hor-smspace grayc">
				  <dt class="textn"><?php echo __l('Entries');?></dt>
				  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($contest['Contest']['contest_user_count']);?></dd>
				</dl>
			  </div>
			</div>
		</div>
	</div>