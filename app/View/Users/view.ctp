<?php Configure::write('highperformance.uids', $user['User']['id']); ?>
<section class="js-user-view" data-user-id="<?php echo $user['User']['id']; ?>">
	<div class="row top-pattern sep-bot">
          <div class="bot-space container">
            <section id="user-details" class="row no-mar">
              <div class="ver-space row top-mspace follow"> 
              	<?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
					<div class="alu-f-<?php echo $user['User']['id'];?> hide"><?php //after login user follow ?>
						<?php echo $this->Html->link(__l('Follow'), array('controller' => 'user_favorites', 'action' => 'add', $user['User']['id'],'f' => $user['User']['username'], 'admin'=> false), array('class'=>'js-tooltip btn span2 no-mar top-mspace text-14 btn-success textb', 'title' => __l('Follow'),'escape' => false)); ?>
					</div>
					<div class="blu-f-<?php echo $user['User']['id'];?> hide"> <?php //before login  user follow ?>
						<?php  echo $this->Html->link(__l('Follow'), array('controller' => 'users', 'action' => 'login/?f='.$this->request->url), array('class' => 'js-tooltip btn span2 no-mar top-mspace text-14 btn-success textb js-no-pjax', 'escape' => false,'title'=>__l('Follow'))); ?>
					</div>
					<div class="alu-uf-<?php echo $user['User']['id'];?> hide"> <?php //after login  user unfollow ?>
						<?php echo $this->Html->link(__l('Following'), array('controller' => 'user_favorites', 'action' => 'delete', $user['User']['username'], 'admin'=> false), array('class'=>'btn span2 no-mar text-14 btn-success textb js-tooltip js-unfollow top-mspace','title' => __l('Unfollow'),'escape' => false)); ?>
					</div>
				<?php } else { ?>
				<?php
					$userid = $this->Auth->user('id');
					if($userid != $user['User']['id']){
						if (isPluginEnabled('UserFavourites')) {
							if (empty($userFavorite['FavoriteUser'])) :
								echo $this->Html->link(__l('Follow'), array('controller' => 'user_favorites', 'action' => 'add', $user['User']['id'],'f' => $user['User']['username'], 'admin'=> false), array('class'=>'js-tooltip btn span2 no-mar top-mspace text-14 btn-success textb', 'title' => __l('Follow'),'escape' => false));
							else:
								echo $this->Html->link(__l('Following'), array('controller' => 'user_favorites', 'action' => 'delete', $user['User']['username'], 'admin'=> false), array('class'=>'btn span2 no-mar text-14 btn-success textb js-tooltip js-unfollow top-mspace','title' => __l('Unfollow'),'escape' => false));
							endif;
						}
					}
				?>
				<?php } ?>
                <h2 class="text-32 hor-space span"><?php echo $user['User']['username'];?></h2>
              </div>
              <div class="row no-mar"> <span class="span ver-space no-mar"><p class="thumbnail sep-bot"> <?php
        					$current_user_details = array(
        						'username' => $user['User']['username'],
        						'id' =>  $user['User']['id'],
        						);
        					echo $this->Html->getUserAvatarLink($user['User'], 'small_big_thumb');
        				?> </p></span>
                <div class="span19 grayc row no-mar">
                  <div class="row ver-space ver-mspace">
                    <div class="span bot-space">
                      <p class="no-mar text-14"> <span><?php echo __l('Since:') . ' ';?></span> <span class="textb"><?php echo $this->Html->cDateTimeHighlight($user['User']['created']);?></span> </p>
                      <p class="no-mar text-14 ver-smspace"> 
                      	<span><?php echo __l('Last Activity:') . ' '; ?></span> 
                      	<span class="textb">
							 <?php 
                                if (!empty($user['User']['last_logged_in_time']) && $user['User']['last_logged_in_time'] != '0000-00-00 00:00:00') {
                                    echo $this->Html->cDateTimeHighlight($user['User']['last_logged_in_time']);
                                } else {
                                    echo '-';
                                }
                             ?>
                          </span>
                       </p>
					  	<?php if(!empty($user['UserProfile']['Country']['name'])){?>
	                      <p class="no-mar span4 htruncate js-tooltip" title="<?php echo $user['UserProfile']['State']['name'] . ', '.$user['UserProfile']['Country']['name'];?>"> 
                            <span class= "flags flag-<?php echo strtolower($user['UserProfile']['Country']['iso_alpha2']);?>" title="<?php echo $user['UserProfile']['Country']['name'];?>"><?php echo $user['UserProfile']['Country']['name'];?></span>
                         <em> 
                         	<?php 
							if(!empty($user['UserProfile']['State']['name'])){
							echo ' '.$this->Html->cText($user['UserProfile']['State']['name']);
							} 
							if(!empty($user['UserProfile']['Country']['name'])){
								echo ' '.$user['UserProfile']['Country']['name'];
							} ?>
                         </em>
						</p>
					 <?php } ?>
					 <?php
						if ($user['User']['id'] != $this->Auth->user('id')):
							echo $this->Html->link('<i class="icon-flag text-14"></i> '.__l('Report User'), array('controller'=>'user_flags','action' => 'add', $user['User']['id']), array('title' => __l('Report User'),'class' => 'pinkc js-no-pjax clearfix', 'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false));
						endif;
						?>
                    </div>
                    <?php if (isPluginEnabled('SocialMarketing')) {?>
                    <div class="pull-right ver-space top-mspace">
                      <ul class="unstyled row no-mar">
                      <?php 
							$badge = '';
							$icon = 'icon-remove';
							$default_class = 'default';
							$connected_class = '';
							if(!empty($user['User']['is_facebook_connected'])){
								$icon = 'icon-ok';
								$badge = 'badge-success';
								$default_class = '';
								$connected_class = 'blackc';
							}
						?>
                        <li class="span no-mar <?php echo $connected_class; ?>">
                          <div class="pull-left mob-clr">
                            <p class="textb no-mar"><?php echo __l('Facebook');?></p>
                            <span class="htruncate span2  no-mar js-tooltip" title="<?php echo $user['User']['fb_friends_count'] . ' ' . __l('friends');?>"><?php echo $user['User']['fb_friends_count'] . ' ' . __l('friends');?></span> </div>
                          <span class="label <?php echo $default_class; ?> span dc hor-smspace <?php echo $badge; ?>"><i class="<?php echo $icon; ?> text-14 whitec no-pad"></i></span> 
                        </li>
                       <?php 
							$badge = '';
							$icon = 'icon-remove';
							$default_class = 'default';
							$connected_class = '';
							if(!empty($user['User']['is_twitter_connected'])){
								$icon = 'icon-ok';
								$badge = 'badge-success';
								$default_class = '';
								$connected_class = 'blackc';
							}
						?>
                        <li class="span <?php echo $connected_class; ?>">
                          <div class="pull-left mob-clr">
                            <p class="textb no-mar"><?php echo __l('Twitter');?></p>
                            <span class="htruncate span2  no-mar js-tooltip" title="<?php echo $user['User']['twitter_followers_count'] . ' ' . __l('followers');?>"><?php echo $user['User']['twitter_followers_count'] . ' ' . __l('followers');?></span> </div>
                          <span class="label <?php echo $default_class; ?> span dc hor-smspace <?php echo $badge; ?>"><i class="<?php echo $icon; ?> text-14 whitec no-pad"></i></span> 
                        </li>
                        <?php 
							$badge = '';
							$icon = 'icon-remove';
							$default_class = 'default';
							$connected_class = '';
							if(!empty($user['User']['is_linkedin_connected'])){
								$icon = 'icon-ok';
								$badge = 'badge-success';
								$default_class = '';
								$connected_class = 'blackc';
							}
						?>
                        <li class="span <?php echo $connected_class; ?>">
                          <div class="pull-left mob-clr">
                            <p class="textb no-mar"><?php echo __l('Linkedin');?></p>
                            <span class="htruncate span2  no-mar js-tooltip" title="<?php echo $user['User']['linkedin_contacts_count'] . ' ' . __l('connections');?>"><?php echo $user['User']['linkedin_contacts_count'] . ' ' . __l('connections');?></span> </div>
                          <span class="label <?php echo $default_class; ?> span dc hor-smspace <?php echo $badge; ?>"><i class="<?php echo $icon; ?> text-14 whitec no-pad"></i></span>
                        </li>
                        <?php 
							$badge = '';
							$icon = 'icon-remove';
							$default_class = 'default';
							$connected_class = '';
							if(!empty($user['User']['is_google_connected'])){
								$icon = 'icon-ok';
								$badge = 'badge-success';
								$default_class = '';
								$connected_class = 'blackc';
							}
						?>
                        <li class="span <?php echo $connected_class; ?>">
                          <div class="pull-left mob-clr">
                            <p class="textb no-mar"><?php echo __l('Google');?></p>
                            <span  class="htruncate span2  no-mar js-tooltip" title="<?php echo $user['User']['google_contacts_count'] . ' ' . __l('contacts');?>"><?php echo $user['User']['google_contacts_count'] . ' ' . __l('contacts');?></span> </div>
                          <span class="label <?php echo $default_class; ?> span dc hor-smspace <?php echo $badge; ?>"><i class="<?php echo $icon; ?> text-14 whitec no-pad"></i></span>
                         </li>
                       <?php 
							$badge = '';
							$icon = 'icon-remove';
							$default_class = 'default';
							$connected_class = '';
							if(!empty($user['User']['is_yahoo_connected'])){
								$icon = 'icon-ok';
								$badge = 'badge-success';
								$default_class = '';
								$connected_class = 'blackc';
							}
						?> 
                        <li class="span <?php echo $connected_class; ?>">
                          <div class="pull-left mob-clr">
                            <p class="textb no-mar"><?php echo __l('Yahoo!');?></p>
                            <span class="htruncate span2  no-mar js-tooltip" title="<?php echo $user['User']['yahoo_contacts_count'] . ' ' . __l('contacts');?>"><?php echo $user['User']['yahoo_contacts_count'] . ' ' . __l('contacts');?></span> </div>
                          <span class="label <?php echo $default_class; ?> span dc hor-smspace <?php echo $badge; ?>"><i class="<?php echo $icon; ?> text-14 whitec no-pad"></i></span> 
                        </li>
                      </ul>
                    </div>
                    <?php } ?>
                  </div>
                  <div class="span row top-mspace top-space">
                    <div class="span5 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-bookmark no-pad text-24 whitec"></i></span>
                      <dl class="pull-left hor-mspace grayc">
                        <dt class="textn"><?php echo __l('Posted Contest');?></dt>
                        <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($user_contest_count);?></dd>
                      </dl>
                    </div>
                    <div class="span5 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-reorder no-pad text-24 whitec"></i></span>
                      <dl class="pull-left hor-mspace grayc">
                        <dt class="textn"><?php echo __l('Entries Posted');?></dt>
                        <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($user_entry_count);?></dd>
                      </dl>
                    </div>
                    <div class="span5 row no-mar"> <span class="label label-important space span1 dc"><i class="icon-trophy no-pad text-24 whitec"></i></span>
                      <dl class="pull-left hor-mspace grayc">
                        <dt class="textn"><?php echo __l('Contest Won');?></dt>
                        <dd class="blackc text-20 no-mar textb"><?php echo $this->Html->cInt($user_contest_won_count);?></dd>
                      </dl>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
<div class="container top-space">
  <div class="tabbable tab-container user-block"  id="ajax-tab-container-contest">
    <ul class="nav nav-tabs row top-space tabs">
	  <li class="tab textb grayc first-child"><em>&nbsp;</em><?php echo $this->Html->link(__l('Participated Entries').'<span class="label text-14 count hor-mspace label-important">'.$this->Html->cInt($user_entry_count, false).'</span>', array('controller' => 'contest_users', 'action' => 'index','type'=>'myparticipated', 'user_id' => $user['User']['id'],'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('Participated Entries'), 'data-toggle' => 'tab', 'data-target'=> '#participatedContest', 'escape' => false));?></li>
	  <li class="tab textb grayc"><em>&nbsp;</em><?php echo $this->Html->link(__l('Posted Contests').'<span class="label text-14 count hor-mspace label-important">'.$this->Html->cInt($user_contest_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'type' => 'my-contests', 'user_id' => $user['User']['id'], 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('Posted Contests'), 'data-toggle' => 'tab', 'data-target'=> '#postedContest', 'escape' => false));?></li>
	  <?php if(isPluginEnabled('ContestFollowers')): ?>
          <li class="tab textb grayc"><em>&nbsp;</em><?php echo $this->Html->link(__l('Following Contests').'<span class="label text-14 count hor-mspace label-important">'.$this->Html->cInt($contest_followed_count, false).'</span>', array('controller' => 'contests', 'action' => 'index', 'type'=>'follower', 'user_id' => $user['User']['id'], 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => __l('Following Contests'), 'data-toggle' => 'tab', 'data-target'=> '#followingContest', 'escape' => false));?></li>
     <?php endif; ?> 
      <?php if(isPluginEnabled('UserFavourites')): ?>
	  <li class="tab textb grayc"><em>&nbsp;</em><?php echo $this->Html->link(__l('Following Users').'<span class="label text-14 count hor-mspace label-important">'.$this->Html->cInt($user_followed_count, false).'</span>', array('controller' => 'users', 'action' => 'index','type'=>'favorites', 'user_id' => $user['User']['id'], 'admin' => false), array('class'=>'text-16 textb grayc js-no-pjax', 'title' => sprintf(__l('Following %s'),Configure::read('contest.participant_alt_name_plural_caps')), 'data-toggle' => 'tab', 'data-target'=> '#followingParticipant', 'escape' => false));?></li>
      <?php endif; ?> 
	</ul>
	<div class="tab-content panel-container">
		<div id="participatedContest" class="tab-pane in active"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
			<span class="loading grayc">Loading....</span></div></div>
		<div id="postedContest" class="hide"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'),  'width' => 25, 'height' => 25)); ?>
			<span class="loading grayc">Loading....</span></div></div>
           <?php if(isPluginEnabled('ContestFollowers')): ?>
            <div id="followingContest" class="hide"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
                <span class="loading grayc">Loading....</span></div>
            </div>
           <?php endif; ?>
           <?php if(isPluginEnabled('UserFavourites')): ?>
            <div id="followingParticipant" class="hide"><div class="offset10 span2 dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
                <span class="loading grayc">Loading....</span></div>
            </div>
           <?php endif; ?>
	</div>
  </div>
</div>
		<div class="modal hide fade" id="js-ajax-modal">
			<div class="modal-body"></div>
			<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a></div>
		</div>
    <?php if (Configure::read('widget.user_script')) { ?>
      <div class="dc clearfix bot-space">
      <?php echo Configure::read('widget.user_script'); ?>
      </div>
    <?php } ?>
</section>