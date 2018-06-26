<div class="row-fluid ver-space js-cache-load-admin-user-activities">
 <?php $i=0; ?>
          <section class="span24 space" >
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#registration','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#a47ae2'}"><?php echo $user_reg_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph1c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_reg;?>"><?php echo $total_user_reg;?> </div>
								<div class="text-12 pull-right <?php if ($user_reg_data_per>0) {?> greenc <?php } else if($user_reg_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_reg_data_per;?>%</span>
									<?php if (!empty($user_reg_data_per)) {?>
										<i class="<?php if ($user_reg_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Registration'); ?>"><?php echo __l('User Registration'); ?></div>
						</div>
					</div>
				 </div>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#login','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#4986e7'}"><?php echo $user_log_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph2c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_login;?>"><?php echo $total_user_login;?> </div>
								<div class="text-12 pull-right <?php if ($user_log_data_per>0) {?> greenc <?php } else if($user_log_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_log_data_per;?>%</span>
									<?php if (!empty($user_log_data_per)) {?>
										<i class="<?php if ($user_log_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Logins'); ?>"><?php echo __l('User Logins'); ?></div>
						</div>
					</div>
				 </div>
				 <?php if (isPluginEnabled('UserFavourites')) {?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#login','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#f691b2'}"><?php echo $user_follow_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph3c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_follow;?>"><?php echo $total_user_follow;?> </div>
								<div class="text-12 pull-right <?php if ($user_follow_data_per>0) {?> greenc <?php } else if($user_follow_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_follow_data_per;?>%</span>
									<?php if (!empty($user_follow_data_per)) {?>
										<i class="<?php if ($user_follow_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Followers'); ?>"><?php echo __l('User Followers'); ?></div>
						</div>
					</div>
				 </div>
				 <?php }?>
				 <?php if (isPluginEnabled('Contests')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#pledges','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#cd74e6'}"><?php echo $contests_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph4c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_contests;?>"><?php echo $total_contests;?> </div>
								<div class="text-12 pull-right <?php if ($contests_data_per>0) {?> greenc <?php } else if($contests_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $contests_data_per;?>%</span>
									<?php if (!empty($contests_data_per)) {?>
										<i class="<?php if ($contests_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Contests'); ?>"><?php echo __l('Contests'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('Contests')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#pledges','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#ff7537'}"><?php echo $contest_entry_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph5c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_contest_entry;?>"><?php echo $total_contest_entry;?> </div>
								<div class="text-12 pull-right <?php if ($contest_entry_data_per>0) {?> greenc <?php } else if($contest_entry_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $contest_entry_data_per;?>%</span>
									<?php if (!empty($contest_entry_data_per)) {?>
										<i class="<?php if ($contest_entry_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Entries'); ?>"><?php echo __l('Entries'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('Contests')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#contestcomments','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#d06b64'}"><?php echo $contest_comments_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph6c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_contest_comment;?>"><?php echo $total_contest_comment;?> </div>
								<div class="text-12 pull-right <?php if ($contest_comments_data_per>0) {?> greenc <?php } else if($contest_comments_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $contest_comments_data_per;?>%</span>
									<?php if (!empty($contest_comments_data_per)) {?>
										<i class="<?php if ($contest_comments_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Contest Comments'); ?>"><?php echo __l('Contest Comments'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('EntryRatings')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#entryrating','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#ac725e'}"><?php echo $contest_rating_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph9c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_contest_ratings;?>"><?php echo $total_contest_ratings;?> </div>
								<div class="text-12 pull-right <?php if ($contest_rating_data_per>0) {?> greenc <?php } else if($contest_rating_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $contest_rating_data_per;?>%</span>
									<?php if (!empty($contest_rating_data_per)) {?>
										<i class="<?php if ($contest_rating_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Entry Ratings'); ?>"><?php echo __l('Entry Ratings'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <?php if (isPluginEnabled('ContestFollowers')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#contestfollowers','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#9fe1e7'}"><?php echo $contest_follower_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph10c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_contest_follower;?>"><?php echo $total_contest_follower;?> </div>
								<div class="text-12 pull-right <?php if ($contest_follower_data_per>0) {?> greenc <?php } else if($contest_follower_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $contest_follower_data_per;?>%</span>
									<?php if (!empty($contest_follower_data_per)) {?>
										<i class="<?php if ($contest_follower_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Contest Followers'); ?>"><?php echo __l('Contest Followers'); ?></div>
						</div>
					</div>
				 </div>
				 <?php }?>
				 <?php if (isPluginEnabled('ContestFlags')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#contestflag','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $contest_flag_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph11c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_contest_flag;?>"><?php echo $total_contest_flag;?> </div>
								<div class="text-12 pull-right <?php if ($contest_flag_data_per>0) {?> greenc <?php } else if($contest_flag_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $contest_flag_data_per;?>%</span>
									<?php if (!empty($contest_flag_data_per)) {?>
										<i class="<?php if ($contest_flag_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Contest Flags'); ?>"><?php echo __l('Contest Flags'); ?></div>
						</div>
					</div>
				 </div>
				 <?php }?>
				 <?php if (isPluginEnabled('EntryFlags')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#entryflag','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $entry_flag_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph11c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_entry_flag;?>"><?php echo $total_entry_flag;?> </div>
								<div class="text-12 pull-right <?php if ($entry_flag_data_per>0) {?> greenc <?php } else if($entry_flag_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $entry_flag_data_per;?>%</span>
									<?php if (!empty($entry_flag_data_per)) {?>
										<i class="<?php if ($entry_flag_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('Entry Flags'); ?>"><?php echo __l('Entry Flags'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				  <?php if (isPluginEnabled('UserFlags')) { ?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#userflag','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#b99aff'}"><?php echo $user_flag_data;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph11c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_user_flag;?>"><?php echo $total_user_flag;?> </div>
								<div class="text-12 pull-right <?php if ($user_flag_data_per>0) {?> greenc <?php } else if($user_flag_data_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $user_flag_data_per;?>%</span>
									<?php if (!empty($user_flag_data_per)) {?>
										<i class="<?php if ($user_flag_data_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>

							</div>
							<div class="span24 htruncate js-tooltip" title="<?php echo __l('User Flags'); ?>"><?php echo __l('User Flags'); ?></div>
						</div>
					</div>
				 </div>
				  <?php }?>
				 <div class="span8 thumbnail <?php if($i%3==0) {?> no-mar <?php } ?>"> <?php $i++;?>
					<div class="pull-right space "><?php if (isPluginEnabled('Insights')) {?><?php echo $this->Html->link('<i class="icon-share-alt blackc"></i>', array('controller' => 'insights','action' => 'index','#revenue','admin'=>true),array('escape'=> false));?><?php } ?></div>
					<div class="hor-space span clearfix">
						<div class="span5" style="display: none; visbility:hidden;">
							<span class="js-sparkline-chart {'colour':'#ffad46'}"><?php echo $revenue;?></span>
						</div>
						<div class="span17">
							<div class="span">
								<div class="text-24 pull-left graph12c htruncate js-tooltip span10 js-tooltip" title="<?php echo $total_revenue;?>"><?php echo $total_revenue;?></div>
								<div class="text-12 pull-right <?php if ($rev_per>0) {?> greenc <?php } else if($rev_per == 0) { ?> grayc <?php } else { ?> redc <?php } ?>">
									<span class="text-16  pull-left"><?php echo $rev_per;?>%</span>
									<?php if (!empty($rev_per)) {?>
										<i class="<?php if ($rev_per>0) {?> icon-arrow-up  <?php } else { ?> icon-arrow-down <?php } ?> text-16 pull-left"></i>
									<?php } ?>
								</div>
							</div>
                            <div class="span24 htruncate js-tooltip" title="<?php echo __l('Revenue').' ('.Configure::read('site.currency').')'; ?>"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')'; ?></div>
						</div>
					</div>
				 </div>
          </section>
        </div>