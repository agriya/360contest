 <?php
 Configure::write('highperformance.cids', $contest['Contest']['id']);
$contest_flag = 1;
if(!empty($contest['Contest']['admin_suspend'])){
	$contest_flag = 0;
}
 ?>
<div class="js-contest-view" data-contest-id="<?php echo $contest['Contest']['id']; ?>">
	  <div class="bot-space container">
		<section id="user-details" class="row no-mar">
			<div class="ver-space row top-mspace follow">
			  <?php if(isPluginEnabled('ContestFollowers') && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
				<div class="alc-f-<?php echo $contest['Contest']['id'];?> hide"><?php //after login user follow ?>
					<?php echo $this->Html->link(__l('Follow'), array('controller' => 'contest_followers', 'action' => 'add', $contest['Contest']['id'], 'admin'=> false), array('class'=>'top-mspace js-tooltip btn span2 no-mar text-14 btn-success textb','title' => __l('Follow'),'escape' => false)); ?>
				</div>
				<div class="aloc-f-<?php echo $contest['Contest']['id'];?> hide"> <?php //after login own user follow ?>
					<span class="disabled btn btn-module ver-mspace dc span2 text-14 btn-success textb no-mar js-tooltip" title="Reason: You can't follow your own contest">
						<?php  echo __l('Follow'); ?>
					</span>
				</div>
				<div class="blc-f-<?php echo $contest['Contest']['id'];?> hide"> <?php //before login  user follow ?>
					<?php  echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('class' => 'js-tooltip btn span2 no-mar text-14 btn-success textb js-no-pjax', 'escape' => false,'title'=>__l('Follow'))); ?>
				</div>
				<div class="alc-uf-<?php echo $contest['Contest']['id'];?> hide"> <?php //after login  user unfollow ?>
					<?php echo $this->Html->link(__l('Following'), array('controller' => 'contest_followers', 'action' => 'delete', $contest['Contest']['slug'], 'admin'=> false), array('class'=>'btn span2 no-mar text-14 btn-success textb js-tooltip js-unfollow','title' => __l('Unfollow'),'escape' => false)); ?>
				</div>
			  <?php } elseif(isPluginEnabled('ContestFollowers')) { ?>
				  <?php if($contest['User']['id'] == $this->Auth->user('id')) :?>
				  <span class="disabled btn btn-module ver-mspace dc span2 text-14 btn-success textb no-mar js-tooltip" title="Reason: You Can't follow your own contest"><?php  echo __l('Follow'); ?></span>
				  <?php else:
						$userid = $this->Auth->user('id');
						if($userid != $contest['User']['id']){
							$js_class = '';
							if($this->Auth->sessionValid()){
								$js_class = "js-like";
							}
							if (isPluginEnabled('ContestFollowers')) {
								if (empty($contest['ContestFollower'])) :
									echo $this->Html->link(__l('Follow'), array('controller' => 'contest_followers', 'action' => 'add', $contest['Contest']['id'], 'admin'=> false), array('class'=>'js-tooltip btn span2 no-mar text-14 btn-success textb','title' => __l('Follow'),'escape' => false));
								else:
									echo $this->Html->link(__l('Following'), array('controller' => 'contest_followers', 'action' => 'delete', $contest['Contest']['slug'], 'admin'=> false), array('class'=>'btn span2 no-mar text-14 btn-success textb js-tooltip js-unfollow', 'title' => __l('Unfollow'),'escape' => false));
								endif;
							}
						}
					endif;
					?>
				<?php } ?>
			  <h2 class="text-32 hor-space span20"><?php echo $this->Html->cText($contest['Contest']['name']) ;?></h2>
			</div>
			<div class="row top-space">
			<div class="row span24">
			  <div class="grayc bot-mspace bot-space row">
				<div class="thumbnail sep-bot pull-left"> <?php echo $this->Html->getUserAvatarLink($contest['User'], 'normal_thumb',true); ?> </div>
				<div class="span10 bot-space">
				  <p class="no-mar clearfix">
					<?php if(!empty($contest['Contest']['is_featured'])):?>
					<span class="pull-left" title="<?php echo __l('Featured'); ?>"><i class="icon-star text-14"></i></span>
					<?php
					 endif;
					 if(!empty($contest['Contest']['is_blind'])):
					?>
					<span class="pull-left" title="<?php echo __l('Blind'); ?>"><i class="icon-eye-close text-14"></i></span>
					<?php
					 endif;
					 if(!empty($contest['Contest']['is_private'])):
					 ?>
					<span class="pull-left" title="<?php echo __l('Private'); ?>"><i class="icon-lock text-14"></i></span>
					<?php  endif; ?>
					<?php if(!empty($contest['Contest']['is_highlight'])){?>
					 <span class="pull-left" title="<?php echo __l('Highlight'); ?>"><i class="icon-signal text-14" title="Highlighted"></i></span>
					 <?php } ?>
					 <span class="pull-left">
                     <?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
                        <span class="alc-ugf-<?php echo $contest['Contest']['id'];?> hide left-space pull-left">
                            <?php echo $this->Html->link('<i class="icon-cog text-14"></i> '.__l('Upgrade Features'), array('controller' => 'contests', 'action' => 'upgrade_features', $contest['Contest']['id'], 'admin' => false), array('title' => __l('Upgrade Features'), 'class' => 'upgrade_link round-3 pinkc', 'escape' => false));?>
                        </span>
                        <span class="alc-et-<?php echo $contest['Contest']['id'];?> hide left-space pull-left">
                            <?php echo $this->Html->link('<i class="icon-time text-14"></i> '.__l('Extend Time'), array('controller' => 'contests', 'action' => 'extend_time', $contest['Contest']['id'], 'admin' => false), array('title' => __l('Extend Time'), 'class' => 'upgrade_link round-3 pinkc', 'escape' => false));?>
                        </span>
					 <?php } else { ?>
                        <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::Open && ($contest['Contest']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin)) {?>
						<?php if((!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_blind'])) || (!empty($contest['ContestType']['is_private']) && empty($contest['Contest']['is_private'])) || (!empty($contest['ContestType']['is_featured']) && empty($contest['Contest']['is_featured'])) || (!empty($contest['ContestType']['is_highlight']) && empty($contest['Contest']['is_highlight']))) {?>
							<?php echo $this->Html->link('<i class="icon-cog text-14"></i> '.__l('Upgrade Features'), array('controller' => 'contests', 'action' => 'upgrade_features', $contest['Contest']['id'], 'admin' => false), array('title' => __l('Upgrade Features'), 'class' => 'upgrade_link round-3 pinkc', 'escape' => false));?>
						<?php } ?>
						<?php echo $this->Html->link('<i class="icon-time text-14"></i> '.__l('Extend Time'), array('controller' => 'contests', 'action' => 'extend_time', $contest['Contest']['id'], 'admin' => false), array('title' => __l('Extend Time'), 'class' => 'upgrade_link round-3 pinkc', 'escape' => false));?>
					   <?php } ?>
                     <?php } ?>
					 </span>
					<span>
					<?php if(isPluginEnabled('ContestFlags') && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
						<span class="alc-rf-<?php echo $contest['Contest']['id'];?> hide">
							<?php echo $this->Html->link('<i class="icon-flag text-14"></i> '.__l('Report Contest'), array('controller'=>'contest_flags','action' => 'add', $contest['Contest']['id'], 'plugin'=>'contests'), array('title' => __l('Report Contest'),'class' => 'pinkc js-no-pjax smspace', 'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false)); ?>
						</span>
					<?php } elseif(isPluginEnabled('ContestFlags')) { ?>
						<?php
						if ($contest['User']['id'] != $this->Auth->user('id')):
							echo $this->Html->link('<i class="icon-flag text-14"></i> '.__l('Report Contest'), array('controller'=>'contest_flags','action' => 'add', $contest['Contest']['id'], 'plugin'=>'contests'), array('title' => __l('Report Contest'),'class' => 'pinkc js-no-pjax smspace', 'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false));
						endif;
						?>
					<?php } ?>
					</span>
				  </p>
				  <p class="clearfix span no-mar"> <span><?php echo __l('Creator'); ?>: <?php echo $this->Html->link(__l($contest['User']['username']), array('controller'=>'users','action' => 'view', $contest['User']['username']), array('class' =>'grayc', 'title' => __l($contest['User']['username'])));?> </span> <span class="hor-space"> <?php echo __l('Category'); ?>: <span class="js-tooltip" title="<?php echo $this->Html->cText($contest['ContestType']['name'],false);?>"><?php echo $this->Html->cText($contest['ContestType']['name'],false);?></span></span></p>
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
							<li class="span no-mar left-space"><a href="http://pinterest.com/pin/create/button/?url=<?php echo $contest_url; ?>/&amp;description=<?php echo urlencode($contest_title); ?>&amp;media=" class="socialite pinterest-pinit blackc" count-layout="horizontal"></a></li>
							<li class="span no-mar left-space"><a href="https://plus.google.com/share?url=<?php echo $contest_url; ?>" class="socialite googleplus-one blackc" data-size="medium" data-href="<?php echo $contest_url; ?>" rel="nofollow" target="_blank"></a></li>
							
						</ul>
				  </div>
				</div>
			  </div>
			</div>
			</div>
		</section>
	  </div>
	  <div class="top-pattern hightlight-bar sep-bot ver-space affix-top js-affix-header" data-spy="affix" data-offset-top="208">
		<div class="clearfix container">
			<div class="span row no-mar top-space">
            <?php if (isPluginEnabled('ContestFollowers')): ?>
			  <div class="span5 row no-mar"> <span class="label label-important span1 dc space no-mar"><i class="icon-ok no-pad text-24 whitec"></i></span>
				<dl class="pull-left hor-smspace grayc">
				  <dt class="textn"><?php echo __l('Followers');?></dt>
				  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($contest['Contest']['contest_follower_count']);?></dd>
				</dl>
			  </div>
              <?php endif;?>
			  <div class="span5 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-trophy no-pad text-24 whitec"></i></span>
				<dl class="pull-left hor-smspace grayc">
				  <dt class="textn"><?php echo __l('Prize');?></dt>
				  <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['prize']);?></dd>
				</dl>
			  </div>
			  <div class="span6 row no-mar bot-space"> <span class="label label-important space span1 dc"><i class="icon-calendar no-pad text-24 whitec"></i></span>
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
			</div>
			<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
				<div class="alc-se-<?php echo $contest['Contest']['id'];?> hide"><?php //after login submit your work ?>
					<p class="ver-mspace hor-space pull-right"><?php echo $this->Html->link(__l('Submit your work'), array('controller' => 'contest_users', 'action' => 'add', $contest['Contest']['slug'], 'plugin' => 'contests'), array('class' => 'text-24 whitec textb btn btn-success btn-large'));?></p>
				</div>
			<?php } else { ?>
				<?php if($contest['Contest']['contest_status_id'] < ConstContestStatus::Judging && $contest['Contest']['user_id'] != $this->Auth->user('id') && (strtotime($contest['Contest']['actual_end_date']) -strtotime('now') > 0)) { ?>
					<p class="ver-mspace hor-space pull-right"><?php echo $this->Html->link(__l('Submit your work'), array('controller' => 'contest_users', 'action' => 'add', $contest['Contest']['slug'], 'plugin' => 'contests'), array('class' => 'text-24 whitec textb btn btn-success btn-large'));?></p>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
	<div class="top-space container">
	  <section id="contest" class="row no-mar">
		<article class="view-block">
		  <div class="tabbable tab-container" id="ajax-tab-container-contest">
			<ul class="nav nav-tabs row top-space tabs">
			<?php $activity_class = 'js-tab-disable';?>
			   <li class="tab first-child"> <?php echo $this->Html->link(__l('Activities'), array('controller' => 'messages', 'action' => 'activities', 'contest_id'=>$contest['Contest']['id']),array('class'=>'text-16 textb grayc js-no-pjax','title' => __l('Activities'), 'data-toggle' => 'tab', 'data-target' => '#activities', ));?> </li>
			  <li class="tab"><?php echo $this->Html->link(__l('Entries').'<span class="label default whitec text-14 hor-mspace">'.$this->Html->cInt($contest['Contest']['contest_user_count'],false).'</span>', array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contest['Contest']['slug'], 'view_type' => 'open'),array('title' => __l('Entries').' ('.$this->Html->cInt($contest['Contest']['contest_user_count'],false).')', 'data-toggle' => 'tab', 'data-target' => '#entries', 'class' => 'text-16 textb grayc js-no-pjax', 'escape' => false));?>
			  </li>
			  <?php if (isPluginEnabled('ContestFollowers')): ?>
			  <li class="tab">
				<?php echo $this->Html->link(__l('Followers') . ' <span class="label default whitec text-14 hor-mspace">'.$this->Html->cInt($contest['Contest']['contest_follower_count'],false).'</span>', array('controller' => 'contest_followers', 'action' => 'index_contest_follow','contest_id'=>$contest['Contest']['id']),array('title' => __l('Followers') . ' ('.$this->Html->cInt($contest['Contest']['contest_follower_count'],false).')', 'data-toggle' => 'tab', 'data-target' => '#followers', 'class' => 'text-16 textb grayc js-no-pjax', 'escape' => false));?>
			  </li>
			  <?php endif; ?>
			  <?php if($contest['Contest']['contest_status_id'] !=ConstContestStatus::PaymentPending || $contest['Contest']['contest_status_id'] !=ConstContestStatus::PendingApproval): ?>
			  <li class="tab">
				<?php echo $this->Html->link(Configure::read('contest.participant_alt_name_plural_caps').' <span class="label default whitec text-14 hor-mspace">'.$this->Html->cInt($contest['Contest']['partcipant_count'],false).'</span>', array('controller' => 'contest_users', 'action' => 'index', 'contest'=>$contest['Contest']['slug'],'contest_type'=>'participant'),array('title' => Configure::read('contest.participant_alt_name_plural_caps').' ('.$this->Html->cInt($contest['Contest']['partcipant_count'],false).')', 'data-toggle' => 'tab', 'data-target' => '#participants', 'class' => 'text-16 textb grayc js-no-pjax', 'escape' => false));?>
			 </li>
			  <?php endif; ?>
			  <li class="tab"> <?php echo $this->Html->link(__l('Brief'), '#brief', array('title' => __l('Brief'), 'class' => 'text-16 textb grayc js-no-pjax', 'data-toggle' => 'tab')); ?></li>
			</ul>
			<div class="tab-content panel-container">
			  <div id="activities" class="tab-pane in span19 no-mar">
				<div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
				<span class="loading grayc">Loading....</span></div>
			  </div>
			  <div id="entries" class="tab-pane active in span19 no-mar">
				<div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
				  <span class="loading grayc">Loading....</span></div>
			  </div>
			  <div id="followers" class="tab-pane  span19 no-mar">
				<div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
				<span class="loading grayc">Loading....</span></div>
			  </div>
			  <div id="participants" class="tab-pane  span19 no-mar">
				<div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
				<span class="loading grayc">Loading....</span></div>
			  </div>
			  <div id="brief" class="tab-pane  span19 no-mar">
				<?php
					if(!empty($contest['Submission']['SubmissionField'])) {
						$contest_view_class = '';
						if(count($contest['Submission']['SubmissionField']) >1){
							$contest_view_class = 'contest-view-list';
						}
					?>
					<div class="<?php echo $contest_view_class; ?> clearfix">
					  <div class="span18 omega alpha contest-description-block top-space">
						<h4><?php echo __l('Project Description:');?></h4>
						<?php echo $this->Html->cText($contest['Contest']['description']);?> </div>
							<?php $i = 0; $class = ' class="altrow"'; ?>
						<?php foreach($contest['Submission']['SubmissionField'] as $submissionField):
								$field_type = explode('_',$submissionField['form_field']);
								$div_class= '';
								$div_even = $i % 2;
								if($div_even == 0) {
									$div_class = 'span9 ';
								} else {
									$div_class = 'span9';
								}
						?>
						<div class="<?php echo $div_class;?> alpha omega contest-description-block  top-space">
						<h4><?php echo (!empty($submissionFieldDisplay[$submissionField['form_field']])) ? $this->Html->cText(Inflector::humanize($submissionFieldDisplay[$submissionField['form_field']])) : '';?>:</h4>
						<div class="description-info">
						<?php
							if (!empty($field_type[1]) && $field_type[1] != 'thumbnail' && empty($submissionField['response'])) {
								echo __l('None specified');
							} else {
								if (!empty($field_type[1]) && $field_type[1] == 'color') {
									$submissionField['response'] = trim($submissionField['response']);
									if(substr($submissionField['response'], -1) == ','){
										$submissionField['response'] = substr($submissionField['response'], 0, -1);
									}
									$values = explode(',', $submissionField['response']);
									$count = count($values);
									$i=1;
									foreach($values as $value) {
										$bgcolor = 'style=background:'.trim($value);
										if(!empty($bgcolor) && !empty($value)){
						 ?>
						 <div class="clearfix span2 pull-left">
						  <span class="color-code" <?php echo $bgcolor;?>></span><span>
						  <?php
							echo trim($value);
							if ($i<$count) {
								echo ',';
							}
						  ?>
						  </span>
						  </div>
						  <?php
										}
										$i++;
									}
								} elseif(!empty($field_type[1]) && $field_type[1] == 'thumbnail') {
									if (empty($submissionField['ContestCloneThumb'])){
										echo __l('None specified');
									} else {
										$regex = '/(?<!href=["\'])http:\/\//';
										$regex1 = '/(?<!href=["\'])https:\/\//';
										$display_url = preg_replace($regex, '', $submissionField['response']);
										$display_url = preg_replace($regex1, '', $display_url);
										$site_url = $submissionField['response'];
										if(!preg_match("/http:\/\//", $submissionField['response']) && !preg_match("/https:\/\//", $submissionField['response'])) {
											$site_url = 'http://' . $submissionField['response'];
										}
						  ?>
						  <div class="clone-block"> <?php echo $this->Html->link($this->Html->showImage('ContestCloneThumb', $submissionField['ContestCloneThumb'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($contest['Contest']['name'], false)), 'title' => $this->Html->cText($contest['Contest']['name'], false), 'escape' => false)), $site_url, array('target'=>'_blank','escape' => false)); ?>
							<p><?php echo $this->Html->link($display_url,$site_url, array('target'=>'_blank','escape' => false));?></p>
						  </div>
						  <?php
								}
							} elseif (!empty($field_type[1]) && $field_type[1] == 'file' && !empty($submissionField['response'])) {?>
						  <?php echo $this->Html->link($submissionField['SubmissionThumb']['filename'].'<i class="icon-download-alt hor-smspace"></i>', array('controller' => 'contests', 'action' => 'download', $submissionField['SubmissionThumb']['id'], $submissionField['id']), array('class' => 'download', 'escape' => false));?>
						  <?php if($submissionField['SubmissionThumb']['mimetype'] == 'image/jpeg' || $submissionField['SubmissionThumb']['mimetype'] == 'image/png' || $submissionField['SubmissionThumb']['mimetype'] == 'image/jpg' || $submissionField['SubmissionThumb']['mimetype'] == 'image/gif') { ?>
						  <p> <?php echo $this->Html->link($this->Html->showImage('SubmissionThumb', $submissionField['SubmissionThumb'], array('dimension' => 'big_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($contest['Contest']['name'], false)), 'title' => $this->Html->cText($contest['Contest']['name'], false), 'escape' => false)), array('controller' => 'contests', 'action' => 'download',  $submissionField['SubmissionThumb']['id'],$submissionField['id'], 'admin' => false), array('escape' => false));?> </p>
						  <?php }?>
						  <?php } elseif (!empty($field_type[1]) && $field_type[1] == 'date') {
									$convert_date = explode("\n", $submissionField['response']);
									$dateval = $convert_date[2].'-'.$convert_date[0].'-'.$convert_date[1];
									echo $this->Html->cDate($dateval);
								} elseif (!empty($field_type[1]) && $field_type[1] == 'datetime') {
									$convert_date = explode("\n", $submissionField['response']);
									$dateval = $convert_date[2].'-'.$convert_date[0].'-'.$convert_date[1].' '.$convert_date[3].':'.$convert_date[4].' '.$convert_date[5];
									echo $this->Html->cDateTime($dateval);
								} elseif (!empty($field_type[1]) && $field_type[1] == 'time') {
									$convert_date = explode("\n", $submissionField['response']);
									$dateval = $convert_date[0].':'.$convert_date[1].' '.$convert_date[2];
									echo $this->Html->cTime($dateval);
								} elseif (!empty($field_type[1]) && $field_type[1] == 'checkbox' || $field_type[1] == 'multiselect') {
									$convert_val = explode("\n", $submissionField['response']);
									$textval = implode("<br/>", $convert_val);
									echo $this->Html->cHtml($textval);
								}  elseif (!empty($field_type[1]) && $field_type[1] == 'slider') {
									if (!empty($submissionFieldOption[$submissionField['form_field']])) {
										$option_val = explode(',', $submissionFieldOption[$submissionField['form_field']]);
						  ?>
						 <div class="clearfix"> 
							<div id="slider" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" role="application">
							<span id="slider-min" class="show pull-left ver-mspace"><?php echo trim($option_val[0]); ?></span>
							<span id="slider-max" class="show pull-right ver-mspace"><?php echo trim($option_val[1]); ?></span> 
							<div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min" style="width: <?php echo $submissionField['response']; ?>%;"></div>
							<a class="ui-slider-handle ui-state-default ui-corner-all js-tooltip" href="#" style="left: <?php echo $submissionField['response']; ?>%;" title="<?php echo $submissionField['response']; ?>">
								<div id="tooltip"  class="textb label label-important" style="position: absolute; top: -25px; left: -1px; padding: 0px 5px; display: none;" ><?php echo $submissionField['response']; ?></div>
							</a>

							</div>
						  <?php
									}
								} else {
									echo $this->Html->cText($submissionField['response']);
								}
							}
						  ?>
						</div>
					  </div>
					  <?php endforeach; ?>
					</div>
					<?php } ?>
			  </div>
			  </div>
			  <div class="span5 pull-right">
				<h3 class="sep-bot bot-space ver-mspace textn"><?php echo __l('Contest Status'); ?></h3>
				<div class="accordion grayc" id="accordion2">
				<?php if(!in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::Rejected))){?>
				<?php
				if($contest['Contest']['contest_status_id'] == ConstContestStatus::Open): ?>
					<div class="accordion-group sep">
						<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-space blackc"><?php echo __l('Open'); ?></span> <?php echo (!empty($contest['Contest']['start_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['start_date']) : ''; ?></span></div>
						<div id="winnerselected" class="accordion-body collapse in">
						  <div class="accordion-inner row no-mar">
						  <span class="start-date"><?php echo  sprintf(__l('Opened on %s'), $this->Html->cDateTimeHighlight($contest['Contest']['start_date']));?></span>
						  </div>
						</div>
					  </div>
				<?php
				else: ?>
				 <div class="accordion-group no-bor">
					<div class="space sep-bot"> <span class="textb hor-smspace"><?php echo __l('Open'); ?> </span> 
					  
						<?php 
						if($contest['Contest']['start_date'] != null && $contest['Contest']['start_date'] != '0000-00-00 00:00:00') {
							$this->Html->cDateTimeHighlight($contest['Contest']['start_date']);
						} else {
							echo '--';
						}
						?></div></div>
				<?php endif; ?>
				 <?php }?>
				  <?php $flag_judging = 1;
					if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::ChangeRequested, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted, ConstContestStatus::Completed, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::PaidToParticipant))){
						if (strtotime($contest['Contest']['winner_selected_date']) < strtotime($contest['Contest']['actual_end_date'])) {
							$flag_judging = 0;
						}
					}
					if($flag_judging){
						if($contest['Contest']['contest_status_id'] == ConstContestStatus::Judging):
					?>
						<div class="accordion-group sep">
						<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-space blackc"><?php echo __l('Judging'); ?></span> <?php echo (!empty($contest['Contest']['judging_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['judging_date']) : ''; ?></span></div>
						<div id="winnerselected" class="accordion-body collapse in">
						  <div class="accordion-inner row no-mar">
						  <span class="start-date"><?php echo  sprintf(__l('Contest moved to judging on %s'), $this->Html->cDateTimeHighlight($contest['Contest']['judging_date']));?></span>
						  </div>
						</div>
					  </div>
				<?php  else: ?>
					  <div class="accordion-group no-bor">
						<div class="space sep-bot"><span class="textb hor-smspace"><?php echo __l('Judging'); ?></span> <?php echo (!empty($contest['Contest']['judging_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['judging_date']) : ''; ?></div>
					  </div>
				   <?php endif; ?>
				  <?php }?>
				  <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Judging,ConstContestStatus::WinnerSelected, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::ChangeRequested, ConstContestStatus::ChangeCompleted, ConstContestStatus::Completed, ConstContestStatus::WinnerSelectedByAdmin,ConstContestStatus::Open, ConstContestStatus::PaidToParticipant, ConstContestStatus::PendingApproval,ConstContestStatus::FilesExpectation))){?>
				  <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected, ConstContestStatus::WinnerSelectedByAdmin))): ?>
						<div class="accordion-group sep">
							<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-smspace blackc"><?php echo __l('Winner Selected'); ?></span> <?php echo (!empty($contest['Contest']['winner_selected_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['winner_selected_date']) : ''; ?></span></div>
							<div id="winnerselected" class="accordion-body collapse in">
							  <div class="accordion-inner row no-mar">
							    <div class="pull-left">
								
								<span class="clearfix span no-mar">
								  <?php echo $this->Html->link( $contest['WinnerUser']['username'], array('controller'=>'users','action' => 'view', $contest['WinnerUser']['username']), array('title' => __l($contest['WinnerUser']['username']), 'escape' => false, 'class' => 'grayc'));?>
								 <?php echo __l('selected by '); ?> 
								  <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelectedByAdmin){
								  ?>  <?php echo __l('Admin '); ?> 
								  <?php 
								  } else if($contest['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelected){
								 	echo $contest['User']['username'];
								  }
								  ?> <?php echo __l('as on '); ?><?php echo $this->Html->cDateTimeHighlight($contest['Contest']['winner_selected_date']); ?></span></div>
							  </div>
							</div>
						  </div>
				  <?php else: ?>
							<div class="accordion-group no-bor">
						<div class="space sep-bot"><span class="textb hor-smspace <?php echo !empty($contest['Contest']['winner_selected_date'])?'span':'';?>"><?php echo __l('Winner Selected'); ?></span> <?php echo (!empty($contest['Contest']['winner_selected_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['winner_selected_date']) : ''; ?></div>
					  </div>
				  <?php endif; ?>
				  <?php }?>

				   <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::ChangeRequested, ConstContestStatus::Open, ConstContestStatus::Judging, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::PendingApproval,ConstContestStatus::FilesExpectation))){?>
				   <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::ChangeRequested): ?>
							<div class="accordion-group sep">
							<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-space blackc"><?php echo __l('Change Requested'); ?></span> <?php echo (!empty($contest['Contest']['change_requested_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['change_requested_date']) : ''; ?></span></div>
							<div id="winnerselected" class="accordion-body collapse in">
							  <div class="accordion-inner row no-mar">
							  <span class="start-date"><?php echo __l('Requested to change some modifications on ').$this->Html->cDateTimeHighlight($contest['Contest']['change_requested_date']);?></span>
							  </div>
							</div>
						  </div>
				   <?php else: ?>
				   <div class="accordion-group no-bor">
						<div class="space sep-bot"><span class="textb hor-smspace"><?php echo __l('Change Requested'); ?></span> <?php echo (!empty($contest['Contest']['change_requested_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['change_requested_date']) : ''; ?></div>
					 </div>
				   <?php endif; ?>
				  <?php }?>
				   <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Open, ConstContestStatus::Judging, ConstContestStatus::ChangeRequested, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted,ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::PendingApproval,ConstContestStatus::FilesExpectation))){?>
				   <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::ChangeCompleted): ?>
						<div class="accordion-group sep">
						<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-space blackc"><?php echo __l('Change Completed'); ?></span> <?php echo (!empty($contest['Contest']['change_completed_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['change_completed_date']) : ''; ?></span></div>
						<div id="winnerselected" class="accordion-body collapse in">
						  <div class="accordion-inner row no-mar">
						  <span class="start-date"><?php echo __l('Marked requested changes as completed');?></span>
						  <?php echo $this->Html->cDateTimeHighlight($contest['Contest']['change_completed_date']);?>
						  </div>
						</div>
					  </div>
				   <?php else: ?>
				  
				   <div class="accordion-group no-bor">
						<div class="space sep-bot"><span class="textb hor-smspace"><?php echo __l('Change Completed'); ?></span> <?php echo (!empty($contest['Contest']['change_completed_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['change_completed_date']) : ''; ?></div>
					 </div>
				   <?php endif; ?>
				  <?php }?>
				   
				    <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::FilesExpectation): ?>
						<div class="accordion-group sep">
						<div class="accordion-heading"> <span class="thumbnail" ><span class=" text-14 textb hor-space blackc"><?php echo __l('Expecting Deliverables'); ?></span> <?php echo (!empty($contest['Contest']['files_expectation_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['files_expectation_date']) : ''; ?></span></div>
						<div id="winnerselected" class="accordion-body collapse in">
						  <div class="accordion-inner row no-mar">
						  <span class="start-date"><?php echo __l('Moved to Expecting Deliverables');?></span>
						  <?php echo $this->Html->cDateTimeHighlight($contest['Contest']['files_expectation_date']);?>
						  </div>
						</div>
					  </div>
				  <?php else: ?>
						<div class="accordion-group no-bor">
						<div class="space sep-bot">
							<span class="textb hor-smspace "><?php echo __l('Expecting Deliverables'); ?></span>
							<?php echo (!empty($contest['Contest']['files_expectation_date']) && $contest['Contest']['files_expectation_date'] != '0000-00-00 00:00:00') ? $this->Html->cDateTimeHighlight($contest['Contest']['files_expectation_date']) : ''; ?></div>
						  </div>
				 <?php endif; ?>
				 <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::Completed, ConstContestStatus::Open, ConstContestStatus::Judging, ConstContestStatus::ChangeRequested, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted, ConstContestStatus::WinnerSelectedByAdmin,ConstContestStatus::PaidToParticipant, ConstContestStatus::PendingApproval,ConstContestStatus::FilesExpectation))){?>
				   <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::Completed): ?>
							<div class="accordion-group sep">
							<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-space blackc"><?php echo __l('Completed'); ?></span> <?php echo (!empty($contest['Contest']['completed_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['completed_date']) : ''; ?></span></div>
							<div id="winnerselected" class="accordion-body collapse in">
							  <div class="accordion-inner row no-mar">
							  <span class="start-date"><?php echo __l('Completed on ').$this->Html->cDateTimeHighlight($contest['Contest']['completed_date']);?></span>
							  </div>
							</div>
						  </div>
				 <?php else: ?>
						<div class="accordion-group no-bor">
						<div class="space sep-bot">
							<span class="textb hor-smspace "><?php echo __l('Completed'); ?></span>
							<?php echo (!empty($contest['Contest']['completed_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['completed_date']) : ''; ?></div>
						  </div>
				 <?php endif; ?>
				   <?php }?>
				 <?php if(in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaidToParticipant, ConstContestStatus::Open, ConstContestStatus::Judging, ConstContestStatus::ChangeRequested, ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted, ConstContestStatus::Completed, ConstContestStatus::WinnerSelectedByAdmin, ConstContestStatus::PendingApproval,ConstContestStatus::FilesExpectation))){?>
				 <?php if($contest['Contest']['contest_status_id'] == ConstContestStatus::PaidToParticipant): ?>
						<div class="accordion-group sep">
						<div class="accordion-heading"> <span class="thumbnail" data-toggle="collapse" data-parent="#accordion2"><span class=" text-14 textb hor-space blackc"><?php echo __l('Closed'); ?></span> <?php echo (!empty($contest['Contest']['completed_date'])) ? $this->Html->cDateTimeHighlight($contest['Contest']['completed_date']) : ''; ?></span></div>
						<div id="winnerselected" class="accordion-body collapse in">
						  <div class="accordion-inner row no-mar">
						  <span class="start-date"><?php echo __l('Finished on ').$this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']);?></span>
						  </div>
						</div>
					  </div>
				 <?php else: ?>
						<div class="accordion-group no-bor">
							<div class="space  textb hor-smspace sep-bot"><?php echo __l('Closed'); ?></div>
						  </div>
				 <?php endif; ?>
				   <?php }?>
				</div>
			  </div>
			</div>
		</article>
	  </section>
	  <?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
			<div class="alcd {'cid':'<?php echo Configure::read('highperformance.cids'); ?>'}">

		   </div>
	  <?php } else {?>
		<section class="top-mspace top-space" id="message-board">
		<?php echo $this->element('Contests.message-discussions',array('contest_id'=>$contest['Contest']['id'], 'cache' => array('config' => 'sec'))); ?>
		</section>
	  <?php } ?>
			<?php
	$flag=0;
	if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Open"){
		if($contest['Contest']['contest_status_id']==ConstContestStatus::Open){
			$flag=1;
		}
	}
	if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Judging"){
		if($contest['Contest']['contest_status_id']==ConstContestStatus::Judging || $contest['Contest']['contest_status_id']==ConstContestStatus::Open){
			$flag=1;
		}
	}
	if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="WinnerSelected"){
		if($contest['Contest']['contest_status_id']<=ConstContestStatus::WinnerSelected || $contest['Contest']['contest_status_id']==ConstContestStatus::Judging || $contest['Contest']['contest_status_id']==ConstContestStatus::Open || $contest['Contest']['contest_status_id']==ConstContestStatus::WinnerSelectedByAdmin){
			$flag=1;
		}
	}
	if(Configure::read('messages.allow_all_users_to_comment_upto_status')=="Completed"){
		if(($contest['Contest']['contest_status_id']>=ConstContestStatus::Judging && $contest['Contest']['contest_status_id']<=ConstContestStatus::Completed) || $contest['Contest']['contest_status_id']==ConstContestStatus::Open){
			$flag=1;
		}
	}?>
	<?php if(!in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::PaymentPending, ConstContestStatus::PendingApproval, ConstContestStatus::Rejected))) { ?>
	<div id="message-section">
		<?php
		if((($this->Auth->sessionValid() && !empty($flag))  || (!empty($contest['Contest']['winner_user_id']) && $contest['Contest']['winner_user_id'] == $this->Auth->user('id'))|| (($contest['Contest']['user_id'] == $this->Auth->user('id')) &&  $contest['Contest']['contest_status_id']<=ConstContestStatus::Completed)) && !empty($contest_flag)) {
			if(!empty($this->request->params['named']['type'])){
				echo $this->element('Contests.message-index',array('user'=>$contest['User']['username'],'type' => $this->request->params['named']['type'],'contest' => $contest['Contest'],'flag'=>$flag, 'cache' => array('config' => 'sec')));
				} else {
					echo $this->element('Contests.message-index',array('user'=>$contest['User']['username'],'contest' => $contest['Contest'], 'cache' => array('config' => 'sec')));
				}
		} ?>
	</div>
	<?php }
?>
	</div>

  <div class="modal hide fade" id="js-ajax-modal">
    <div class="modal-body"></div>
	<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
</div>
<?php if($this->Auth->user('role_id') == ConstUserTypes::Admin): ?>
<div class="admin-tabs-block">
  <div class="admin-contest-view-block">
    <div id="admin-action">
    </div>
  </div>
</div>
<?php endif; ?>
    <?php if (Configure::read('widget.contest_script')) { ?>
      <div class="dc clearfix bot-space">
      <?php echo Configure::read('widget.contest_script'); ?>
      </div>
    <?php } ?>
 <div id="fb-root"></div>
</div>