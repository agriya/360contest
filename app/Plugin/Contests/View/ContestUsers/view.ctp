<? /* SVN: $Id: $ */ ?>
<?php 
Configure::write('highperformance.cids', $contestUser['ContestUser']['contest_id']); ?>
<?php Configure::write('highperformance.cuids', $contestUser['ContestUser']['id']); ?>
<?php
$contest_flag = 1;
if(!empty($contestUser['Contest']['admin_suspend'])){
	$contest_flag = 0;
}
$entry_flag = 1;
if(!empty($contestUser['ContestUser']['admin_suspend'])){
	$entry_flag = 0;
}
 if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
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
<?php endif; 
		}?>
<header id="header">
  <div class="navbar no-mar">
	<div class="navbar-inner no-pad no-round">
	  <div class="container clearfix entry-contest-title">
		<h1 class="span top-space"><?php echo $this->Html->link($this->Html->image('logo.png', array('alt'=> '[Image: '.Configure::read('site.name').']')),  '/', array('escape' => false, 'class' => 'brand', 'title' => Configure::read('site.name')));?></h1>
		<h2 class="pull-left top-space top-smspace htruncate span9">
		  <?php	if(!empty($contest_flag)){
			echo $this->Html->link($this->Html->cText($contestUser['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug']),array('class'=> 'js-tooltip pinkc', 'data-placement' => 'bottom', 'title'=>$contestUser['Contest']['name'], 'escape' => false));
		  }	else {
			echo $this->Html->cText($contestUser['Contest']['name'], false);
		  }?>
		</h2>
		<?php echo $this->element('header-menu'); ?>
	  </div>
    </div>
  </div>
</header>
<section id="main" class="clearfix">
  <div class="main">
	<div class="top-pattern top-paternshadow">
	  <div class="container">
		<?php echo $this->Layout->sessionFlash(); ?>
		<div class="pull-right btn bot-round no-pad"><span title="View All" class="js-slider-show down-arrow">View All </span>
		<?php $page=1;
		if(!empty($this->request->params['named']['page'])){
		  $page=$this->request->params['named']['page'];
		}
		echo $this->element('entries-slider',array('contest_slug'=>$contestUser['Contest']['slug'],'entry'=>$contestUser['ContestUser']['entry_no'],'page'=>$page, 'cache' => array('config' => 'sec')));?>
	  </div>
	  <div class="top-space pull-left clearfix">
	    <div class="thumbnail-small sep-bot pull-left"> <?php echo $this->Html->getUserAvatarLink($contestUser['User'], 'normal_thumb',true); ?></div>
		<div class="pull-left clearfix space">
		  <div class="clearfix rating-flash-msg js-rating-display">
			<?php $status = 0;
			if ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open && !empty($contest_flag) && $contestUser['ContestUser']['contest_user_status_id'] != ConstContestUserStatus::Eliminated && $contestUser['ContestUser']['contest_user_status_id'] !=ConstContestUserStatus::Withdrawn) {
				$status = 1;
			}
			$avg_rating =0;
			if($contestUser['ContestUser']['contest_user_rating_count'] !=0){
				$avg_rating = $contestUser['ContestUser']['contest_user_total_ratings']/$contestUser['ContestUser']['contest_user_rating_count'];
			}
			if (isPluginEnabled('EntryRatings')) {
				echo ($this->Auth->sessionValid() && $contestUser['User']['id'] != $this->Auth->user('id') && empty($contestUser['ContestUserRating']) && !empty($status)) ? $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => true, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings')) : $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => false, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings'));
			}?>
		    <span class="span hor-space clearfix">
			  <?php if(isPluginEnabled('EntryFlags') && isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
				<div class="alcu-ra-<?php echo $contestUser['ContestUser']['id'];?> hide">
				  <?php echo $this->Html->link('<i class="icon-flag text-14 no-pad"></i><span class="grayc hor-smspace">'.__l('Report Abuse')."</span>", array('controller' => 'contest_user_flags', 'action' => 'add', $contestUser['ContestUser']['id'], $contestUser['Contest']['slug'],'entry'=>$this->request->params['named']['entry'],'page'=> !empty($this->request->params['named']['page'])?$this->request->params['named']['page']:''), array('class'=>'flag pinkc hor-space', 'title' => __l('Report Abuse'),'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false)); ?>
				</div>
				<div class="blcu-ra-<?php echo $contestUser['ContestUser']['id'];?> hide">
					<?php echo $this->Html->link('<i class="icon-flag text-14 no-pad"></i><span class="grayc hor-smspace">'.__l('Report Abuse')."</span>", array('controller' => 'users', 'action' => 'login?f='.$this->request->url), array('class'=>'flag pinkc hor-space', 'title' => __l('Report Abuse'), 'escape' => false)); ?>
				</div>
			  <?php } else { ?>
				<?php  $status = 0;
				if (in_array($contestUser['Contest']['contest_status_id'], array( ConstContestStatus::Open, ConstContestStatus::Judging)) &&  !empty($contest_flag) && $contestUser['ContestUser']['contest_user_status_id'] !=ConstContestUserStatus::Eliminated && $contestUser['ContestUser']['contest_user_status_id'] !=ConstContestUserStatus::Withdrawn && empty($blind_flag)) {
					$status = 1;
				}
				if($this->Auth->user('id')) {
				  if (isPluginEnabled('EntryFlags') && $this->Auth->user('id') != $contestUser['User']['id']  && !empty($contest_flag) && !empty($status)) {
					echo $this->Html->link('<i class="icon-flag text-14 no-pad"></i><span class="grayc hor-smspace">'.__l('Report Abuse')."</span>", array('controller' => 'contest_user_flags', 'action' => 'add', $contestUser['ContestUser']['id'], $contestUser['Contest']['slug'],'entry'=>$this->request->params['named']['entry'],'page'=> !empty($this->request->params['named']['page'])?$this->request->params['named']['page']:''), array('class'=>'flag pinkc hor-space', 'title' => __l('Report Abuse'),'data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'escape' => false));
				  }
				} else {
				  echo $this->Html->link('<i class="icon-flag text-14 no-pad"></i><span class="grayc hor-smspace">'.__l('Report Abuse')."</span>", array('controller' => 'users', 'action' => 'login?f='.$this->request->url), array('class'=>'flag pinkc hor-space', 'title' => __l('Report Abuse'), 'escape' => false));
				}
			  } ?>
			</span>
		  </div>
		  <div class="clearfix">
			<span class="span no-mar show"><span class="grayc"><i class="icon-trophy text-14 no-pad"></i></span><span> <?php echo __l('Entry #') . $this->Html->cInt($contestUser['ContestUser']['entry_no']) . __l(' from'); ?></span></span>
			<span class="span show hor-mspace">
			  <a href="#" title="<?php echo $contestUser['ContestUserStatus']['name']; ?>"><span><i class="icon-sign-blank <?php echo $contestUser['ContestUserStatus']['slug']; ?> text-14 no-pad"></i></span></a>
			  <?php if($this->Auth->user('role_id') == ConstUserTypes::Admin and $contestUser['ContestUser']['admin_suspend']): ?>
				<span title = "<?php echo __l('Admin Suspended'); ?>"><i class="icon-sign-blank suspended text-14 no-pad"></i></span>
			  <?php endif;?>
			  <span title = "<?php echo $contestUser['Contest']['ContestStatus']['name']; ?>"><i class="icon-sign-blank <?php echo $contestUser['Contest']['ContestStatus']['slug']; ?> text-14 no-pad"></i></span>
			  <?php echo $this->Html->link($this->Html->cText($contestUser['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $contestUser['Contest']['slug']),array('title'=>$contestUser['Contest']['name'], 'class' => "pinkc hor-smspace js-tooltip", 'escape' => false));?>
			</span>
		  </div>
	    </div>
	    <?php $redirect_url = "/contest/". $contestUser['Contest']['slug']."/#entries"; ?>
	    <div class="pull-left">
		  <?php if(isPluginEnabled('HighPerformance') && (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled'))) { ?>
			<div class="pull-left alcu-sw-<?php echo $contestUser['ContestUser']['id'];?> hide">
			  <?php echo $this->Html->link('<span><i class="text-14 icon-bookmark-empty"></i></span><span class="text-11 textb">'.__l('Select As Winner!').'</span>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'plugin' => 'contests'),true).'?r='.$this->request->url, array('class' => ' js-confirm js-no-pjax whitec btn btn-small btn-success top-smspace', 'title' => __l('Select As Winner!'), 'escape' => false)); ?>
			</div>
			<div class="pull-left alcu-w-<?php echo $contestUser['ContestUser']['id'];?> hide">
			  <?php echo $this->Html->link('<span><i class="pinkc text-14 icon-ban-circle"></i></span> <span>'.__l('Withdraw').'</span>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$redirect_url, array('class' => 'btn btn-small top-smspace js-confirm js-no-pjax', 'title' => __l('Withdraw'), 'escape' => false)); ?>
			</div>
			<div class="pull-left alcu-e-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<span><i class="pinkc text-14 icon-remove-circle"></i></span> <span>'.__l('Eliminate').'</span>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$this->request->url, array('class' => 'btn btn-small top-smspace js-confirm js-no-pjax', 'title' => __l('Eliminate'), 'escape' => false)); ?>
			</div>
			<div class="pull-left alcu-d-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<span><i class="pinkc text-14 icon-ok"></i></span> <span>'.__l('Download').'</span>', array('controller' => 'contests', 'action' => 'accept_as_completed', $contestUser['Contest']['id']), array('class'=>'btn btn-small top-smspace download1','escape' => false)); ?>
			</div>
			<div class="pull-left alcu-ued-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<span><i class="pinkc text-14 icon-ban-circle"></i></span> <span>'.__l('Upload Final Deliverables').'</span>', array('controller' => 'contests', 'action' => 'view',$contestUser['Contest']['slug'],"#Upload_Entry_Design"), array('class' => 'upload-link btn btn-small top-smspace', 'escape' => false, 'title' => __l('Upload Entry Design'))); ?>
			</div>
			<div class="pull-left alcu-ded-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<span><i class="pinkc text-14 icon-ok"></i></span> <span>'.__l('Download Entry Design').'</span>', array('controller' => 'contests', 'action' => 'download_entry', $contestUser['ContestUser']['contest_id'], $contestUser['Contest']['EntryAttachment']['id']), array('class' => 'btn btn-small top-smspace', 'escape' => false, 'title' => __l('Download Entry Design'))); ?>
			</div>
			<div class="pull-left alcu-arued-<?php echo $contestUser['ContestUser']['id'];?> hide">
				<?php echo $this->Html->link('<span><i class="pinkc text-14 icon-ban-circle"></i></span> <span>'.__l('Ask to resend final deliverables').'</span>', array('controller' => 'contests', 'action' => 'reupload_entry_design', $contestUser['ContestUser']['contest_id'],$contestUser['Contest']['slug']), array('class' => 'reupload-link btn btn-small top-smspace js-confirm js-no-pjax', 'escape' => false, 'title' => __l('Accept. Ask to resend final deliverables'))); ?>
			</div>
		  <?php } else { ?>
			<?php if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active){
			  if ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) {
				if(($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
					echo $this->Html->link('<span><i class="pinkc text-14 icon-ban-circle"></i></span> <span>'.__l('Withdraw').'</span>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Withdrawn, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$redirect_url, array('class' => 'btn btn-small hor-mspace top-smspace js-confirm js-no-pjax', 'title' => __l('Withdraw'), 'escape' => false));
				endif;
				if(($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin):
					echo $this->Html->link('<span><i class="pinkc text-14 icon-remove-circle"></i></span> <span>'.__l('Eliminate').'</span>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Eliminated, 'plugin' => 'contests', 'admin'=> false),true).'?r='.$this->request->url, array('class' => 'btn btn-small hor-mspace top-smspace js-confirm js-no-pjax', 'title' => __l('Eliminate'), 'escape' => false));
				endif;
			  }
			}
			if(($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed || ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::PaidToParticipant)) && !empty($contest_flag) && $this->Auth->sessionValid() && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id')) && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won) {
				echo $this->Html->link('<span><i class="pinkc text-14 icon-ok"></i></span> <span>'.__l('Download').'</span>', array('controller'=>'contest_users','action'=>'download',$contestUser['ContestUser']['id'],$contestUser['Attachment'][0]['id'],'admin'=>false), array('class'=>'btn btn-small hor-mspace top-smspace download1','escape' => false));
			}
			if (empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['ContestUser']['user_id'] == $this->Auth->user('id') && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed) {
				echo $this->Html->link('<span><i class="pinkc text-14 icon-ban-circle"></i></span> <span>'.__l('Upload Final Deliverables').'</span>', array('controller' => 'contests', 'action' => 'view',$contestUser['Contest']['slug'],"#Upload_Entry_Design"), array('class' => 'upload-link btn btn-small hor-mspace top-smspace', 'escape' => false, 'title' => __l('Upload Entry Design')));
			}
			if (!empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['Contest']['user_id'] == $this->Auth->user('id') && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed) {
				echo $this->Html->link('<span><i class="pinkc text-14 icon-ok"></i></span> <span>'.__l('Download Entry Design').'</span>', array('controller' => 'contests', 'action' => 'download_entry', $contestUser['ContestUser']['contest_id'], $contestUser['Contest']['EntryAttachment']['id']), array('class' => 'btn btn-small hor-mspace top-smspace', 'escape' => false, 'title' => __l('Download Entry Design')));
				echo $this->Html->link('<span><i class="pinkc text-14 icon-ban-circle"></i></span> <span>'.__l('Ask to resend final deliverables').'</span>', array('controller' => 'contests', 'action' => 'reupload_entry_design', $contestUser['ContestUser']['contest_id'],$contestUser['Contest']['slug']), array('class' => 'reupload-link btn btn-small hor-mspace top-smspace js-confirm js-no-pjax', 'escape' => false, 'title' => __l('Accept. Ask to resend final deliverables')));
			}
			if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) && !empty($contest_flag)) {
			  if(($contestUser['Contest']['user_id'] == $this->Auth->user('id') && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open ||	($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging && empty($contestUser['Contest']['is_pending_action_to_admin'])))) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
				echo $this->Html->link('<span><i class="text-14 icon-bookmark-empty"></i></span><span class="text-11 textb">'.__l('Select As Winner!').'</span>', Router::url(array('controller' => 'contest_users', 'action'=>'update_status', 'entry' => $contestUser['ContestUser']['id'], 'status' => ConstContestUserStatus::Won, 'plugin' => 'contests'),true).'?r='.$this->request->url, array('class' => ' js-confirm js-no-pjax whitec btn btn-small btn-success hor-mspace top-smspace', 'title' => __l('Select As Winner!'), 'escape' => false));
			  }
			}
			if (in_array($contest['Contest']['contest_status_id'], array(ConstContestStatus::ChangeCompleted,ConstContestStatus::WinnerSelected)) && empty($contest['Contest']['is_pending_action_to_admin'])) {
			  if(($contest['Contest']['user_id'] == $this->Auth->user('id') &&  empty($contest['Contest']['is_pending_action_to_admin'])) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {	?>
				<?php echo $this->Html->link('<span><i class="icon-paste blackc"></i></span><span class="text-11 textb">'.__l('Accept. Ask to send final deliverables').'</span>', Router::url(array('controller'=>'contests','action'=>'update','status_id'=>ConstContestStatus::FilesExpectation,$contest['Contest']['id']) ,true).'?r='.$this->request->url,array('title' => 'Accept. Ask to send final deliverables', 'class'=>'js-confirm js-no-pjax whitec btn btn-small btn-success top-smspace',  'escape' => false)); ?>
			  <?php	}
			}?>
		  <?php } ?>
		</div>
	  </div>
	  <div class="span24 bot-space no-mar " >
		<?php if(!empty($contestUser['ContestUser']['copyright_note']) && ($this->Auth->user('id') && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $this->Auth->user('id') == $contestUser['ContestUser']['user_id'] || $this->Auth->user('id') == $contestUser['Contest']['user_id']))){?>
		  <span class="textb"><?php echo __l('Copyright Note: ');?></span>
		  <span class="bot-space no-mar js-tooltip htruncate" title="<?php echo __l($contestUser['ContestUser']['copyright_note']); ?>">
			<?php echo __l($contestUser['ContestUser']['copyright_note']);?>
		  </span>
		<?php }?>
	  </div>
    </div>
  </div>
  <div class="js container">
    <div class="row top-mspace top-space">
	<!--Contest user view total block End-->
	  <?php $next_class= '';
	  $img_class= '';
	  if(empty($side_entries['next'])):
	    $next_class= " js-slider-show down-arrow";
		$img_class= "js-image-hover";
	  endif;?>
	  <div class="clearfix contests-user-view-block">
	    <div class="fade-outer-block clearfix">
		  <div class="span<?php if($contestUser['Contest']['Resource']['id'] == ConstResource::Text){ echo'13'; }else{ echo'14'; }?> bot-mspace thumbnail sep contest-user-img-block view-img-block js-slider-content pr <?php if($contestUser['Contest']['Resource']['id'] == ConstResource::Text){?> view-text-block <?php }?> ">
		    <?php if($contestUser['Contest']['user_id'] == $this->Auth->user('id') || $contestUser['ContestUser']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
			  $i = 0;
			  $j =0;
			  if($contestUser['Contest']['Resource']['id'] == ConstResource::Text){
			  	foreach($contestUser['TextResource'] as $message){
					if(!empty($message['MessageContent']['text_resource'])) {
					  $j++;
					}
				  }
			  }else{
			  	foreach($contestUser['Message'] as $message){
					if(!empty($message['MessageContent']['Attachment'])) {
					  $j++;
					}
				  }
			  }
			  
			  $revision_count = $j -1;
			  $k = $j;
			  $message = array();
			  $message_count = $revision_count;
			  foreach($contestUser['Message'] as $message){
				if(($contestUser['Contest']['Resource']['id'] != ConstResource::Text && !empty($message['MessageContent']['Attachment'])) || ($contestUser['Contest']['Resource']['id'] == ConstResource::Text && !empty($message['MessageContent']['text_resource']))) { 
				?>
				  <?php	$blind_prev_flag = 1;
				  if(!empty($contestUser['Contest']['is_blind']) && !empty($side_entries['prev'])) {
					$blind_prev_flag = 0;
					if($side_entries['prev']['ContestUser']['user_id'] == $this->Auth->user('id') ||  $contestUser['Contest']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || !empty($contestUser['Contest']['winner_user_id']) ) {
					  $blind_prev_flag = 1;
					}
				  }
				  if(!empty($side_entries['prev']) && !empty($blind_prev_flag) && ($i == 0)) { ?>
					<span class="prev-link"><?php echo $this->Html->link(__l('Prev'), array('controller' => 'contest_users', 'action' => 'view',$contestUser['Contest']['slug'],'entry'=>$side_entries['prev']['ContestUser']['entry_no'],'page' => !empty($this->request->params['named']['page'])?$this->request->params['named']['page']:''), array('title' => __l('Previous'),'escape' => false));?></span>
				  <?php	}?>
				  <div class="view-image mob-clr dl clearfix <?php echo $img_class; ?>">
					<?php $i++;

					$k--;
					$plugin =$contestUser['Contest']['Resource']['name']."Resources";
					$attachmentdata = array();
					if (isPluginEnabled($plugin )) {
					  $message['MessageContent']['User'] = $contestUser['User'];
					  if($revision_count >= 1){
						if($i == $j){ ?>
						  <h3 class ="<?php if($contestUser['Contest']['Resource']['id'] != ConstResource::Text){ echo 'pull-left span5';}?> dl"><?php echo __l('Original Entry'); ?></h3>
						  <?php	if($contestUser['Contest']['Resource']['name'] == "Video"){
							$attachmentdata['attachment'] = $contestUser['Upload'][0]['video_url'];
							if(!empty($contestUser['Upload'][0]['youtube_video_id'])){
							  $attachmentdata['type'] = "YouTube";
							  $attachmentdata['youtube_video_id'] = $contestUser['Upload'][0]['youtube_video_id'];
							} else if($contestUser['Upload'][0]['vimeo_video_id']){
							  $attachmentdata['type'] = "Vimeo";
							  $attachmentdata['vimeo_video_id'] = $contestUser['Upload'][0]['vimeo_video_id'];
							}
						  } elseif($contestUser['Contest']['Resource']['name'] == "Audio"){
								$attachmentdata['audio_id'] = $contestUser['AudioUpload'][0]['soundcloud_audio_id'];
						  } elseif($contestUser['Contest']['Resource']['name'] == "Text"){
								if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won){
									$attachmentdata = $message['MessageContent']['text_resource'];
								}else{
									$attachmentdata = substr($message['MessageContent']['text_resource'], 0, round(strlen($message['MessageContent']['text_resource'])/2)).'...';
								}
						  } else {
							$attachmentdata['attachment'] = $contestUser['Attachment'][0];
							$attachmentdata['name'] = $contestUser['User']['username'];
						  }?>
						  <span >
							<?php echo $this->element($contestUser['Contest']['Resource']['name'] . '/detail_view', array('contestUser' => $attachmentdata, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));?>
						  </span>
						<?php }else{ ?>
                        
						  <?php	if(($contestUser['Contest']['Resource']['name'] == "Video" || $contestUser['Contest']['Resource']['name'] == "Audio" || $contestUser['Contest']['Resource']['name'] == "Text" )){?>
							<h3 class ="<?php if($contestUser['Contest']['Resource']['id'] != ConstResource::Text){ echo 'pull-left span5';}?> dl"><?php echo __l('Revised Entry #') . $k; ?></h3>
							<?php if($contestUser['Contest']['Resource']['name'] == "Video"){
							  $attachmentdata['attachment'] = $contestUser['Upload'][1]['video_url'];
							  if(!empty($contestUser['Upload'][1]['youtube_video_id'])){
								$attachmentdata['type'] = "YouTube";
								$attachmentdata['youtube_video_id'] = $contestUser['Upload'][1]['youtube_video_id'];
							  } else if($contestUser['Upload'][1]['vimeo_video_id']){
								$attachmentdata['type'] = "Vimeo";
								$attachmentdata['vimeo_video_id'] = $contestUser['Upload'][1]['vimeo_video_id'];
							  }
							} elseif($contestUser['Contest']['Resource']['name'] == "Audio"){
								$attachmentdata['audio_id'] = $contestUser['AudioUpload'][$message_count]['soundcloud_audio_id'];
								$message_count--;
							} elseif($contestUser['Contest']['Resource']['name'] == "Text"){
								if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won){
									$attachmentdata = $message['MessageContent']['text_resource'];
								}else{
									$attachmentdata = substr($message['MessageContent']['text_resource'], 0, round(strlen($message['MessageContent']['text_resource'])/2)).'...';
								}
							} else {
								$attachmentdata['attachment'] = $contestUser['TextResource'][0]['MessageContent']['Attachment'][0];
								$attachmentdata['name'] = $contestUser['User']['username'];
							}
							echo $this->element($contestUser['Contest']['Resource']['name'] . '/detail_view', array('contestUser' => $attachmentdata, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));
						  }
						}
						if($i == 1){ ?>
							<span class ="pull-right span3"><?php echo __l('Revisions') . ' (' . $revision_count . ')'; ?></span>
						<?php }
					  } else { 
						if($contestUser['Contest']['Resource']['name'] == "Video"){
						  $attachmentdata['attachment'] = $contestUser['Upload'][0]['video_url'];
						  if(!empty($contestUser['Upload'][0]['youtube_video_id'])){
							$attachmentdata['type'] = "YouTube";
							$attachmentdata['youtube_video_id'] = $contestUser['Upload'][0]['youtube_video_id'];
						  } else if($contestUser['Upload'][0]['vimeo_video_id']){
							$attachmentdata['type'] = "Vimeo";
							$attachmentdata['vimeo_video_id'] = $contestUser['Upload'][0]['vimeo_video_id'];
						  }
						} elseif($contestUser['Contest']['Resource']['name'] == "Audio"){
							$attachmentdata['audio_id'] = $contestUser['AudioUpload'][0]['soundcloud_audio_id'];
						} elseif($contestUser['Contest']['Resource']['name'] == "Text"){
							if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won){
								$attachmentdata = $contestUser['TextResource'][0]['MessageContent']['text_resource'];
							}else{
								$attachmentdata = substr($contestUser['TextResource'][0]['MessageContent']['text_resource'], 0, round(strlen($contestUser['TextResource'][0]['MessageContent']['text_resource'])/2)).'...';
							}
						}else {
						  $attachmentdata['attachment'] = $contestUser['Attachment'][0];
						  $attachmentdata['name'] = $contestUser['User']['username'];
						}
						;echo $this->element($contestUser['Contest']['Resource']['name'] . '/detail_view', array('contestUser' => $attachmentdata, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));
					  }
					}
					if($i == $j){
					  if($contestUser['Contest']['resource_id'] == ConstResource::Image  || $contestUser['Contest']['resource_id'] == ConstResource::Text) { ?>
						<span class="js-flip js-flip-out flip-link <?php if($contestUser['Contest']['Resource']['id'] == ConstResource::Text){ echo'js-text-resource'; }?>"><?php echo __l('Flip');?></span>
					  <?php }
					} ?>
				  </div>
				  <?php	$blind_next_flag = 1;
				  if(!empty($contestUser['Contest']['is_blind']) && !empty($side_entries['next'])) {
					$blind_next_flag = 0;
					if($side_entries['next']['ContestUser']['user_id'] == $this->Auth->user('id') ||  $contestUser['Contest']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || !empty($contestUser['Contest']['winner_user_id'])) {
						$blind_next_flag = 1;
					}
				  }
				  if(!empty($side_entries['next']) && !empty($blind_next_flag)  && ($i == 1)) { ?>
					<span class="next-link"><?php echo $this->Html->link(__l('Next'), array('controller' => 'contest_users', 'action' => 'view',$contestUser['Contest']['slug'],'entry'=>$side_entries['next']['ContestUser']['entry_no'],'page'=>!empty($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1), array('title' => __l('Next'),'escape' => false));?></span>
				  <?php	}
				}
			  }
			} else {
			  $blind_prev_flag = 1;
			  if(!empty($contestUser['Contest']['is_blind']) && !empty($side_entries['prev'])) {
				$blind_prev_flag = 0;
				if($side_entries['prev']['ContestUser']['user_id'] == $this->Auth->user('id') ||  $contestUser['Contest']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || !empty($contestUser['Contest']['winner_user_id'])) {
				$blind_prev_flag = 1;
			  }
			}
			if(!empty($side_entries['prev']) && !empty($blind_prev_flag)) { ?>
			  <span class="prev-link"><?php echo $this->Html->link(__l('Prev'), array('controller' => 'contest_users', 'action' => 'view',$contestUser['Contest']['slug'],'entry'=>$side_entries['prev']['ContestUser']['entry_no']), array('title' => __l('Previous'),'escape' => false));?></span>
			<?php }	?>
			<div class="view-image <?php echo $img_class; ?>">
			  <?php	$plugin =$contestUser['Contest']['Resource']['name']."Resources";
			  if (isPluginEnabled($plugin )) {
				if($contestUser['Contest']['Resource']['name'] == "Video"){
 				  $attachmentdata['attachment'] = $contestUser['Upload'][0]['video_url'];
				  if(!empty($contestUser['Upload'][0]['youtube_video_id'])){
					$attachmentdata['type'] = "YouTube";
					$attachmentdata['youtube_video_id'] = $contestUser['Upload'][0]['youtube_video_id'];
				  } else if($contestUser['Upload'][0]['vimeo_video_id']){
					$attachmentdata['type'] = "Vimeo";
					$attachmentdata['vimeo_video_id'] = $contestUser['Upload'][0]['vimeo_video_id'];
				  }
				} elseif($contestUser['Contest']['Resource']['name'] == "Audio"){
					$attachmentdata['audio_id'] = $contestUser['AudioUpload'][0]['soundcloud_audio_id'];
				} elseif($contestUser['Contest']['Resource']['name'] == "Text"){
					if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won && $contestUser['Contest']['user_id'] == $this->Auth->user('id')){
						$attachmentdata = $contestUser['Message'][count($contestUser['Message']) - 1]['MessageContent']['text_resource'];
					}else{
						$attachmentdata = substr($contestUser['Message'][count($contestUser['Message']) - 1]['MessageContent']['text_resource'], 0, round(strlen($contestUser['Message'][count($contestUser['Message']) - 1]['MessageContent']['text_resource'])/2)).'...';
					}
				} else {
					$attachmentdata['attachment'] = $contestUser['Attachment'][0];
					$attachmentdata['name'] = $contestUser['User']['username'];
				}
				echo $this->element($contestUser['Contest']['Resource']['name'].'/detail_view', array('contestUser' => $attachmentdata, 'cache' => array('config' => 'sec')),array('plugin' => $plugin));
			  }?>
			  <?php if($contestUser['Contest']['resource_id'] == ConstResource::Image || $contestUser['Contest']['resource_id'] == ConstResource::Text) { ?>
				<span class="js-flip js-flip-out flip-link <?php if($contestUser['Contest']['Resource']['id'] == ConstResource::Text){ echo'js-text-resource'; }?>"><?php echo __l('Flip');?></span>
			  <?php } ?>
			</div>
			<?php $blind_next_flag = 1;
			if(!empty($contestUser['Contest']['is_blind']) && !empty($side_entries['next'])) {
			  $blind_next_flag = 0;
			  if($side_entries['next']['ContestUser']['user_id'] == $this->Auth->user('id') ||  $contestUser['Contest']['user_id'] == $this->Auth->user('id') || $this->Auth->user('role_id') == ConstUserTypes::Admin || !empty($contestUser['Contest']['winner_user_id'])) {
			    $blind_next_flag = 1;
			  }
			}
			if(!empty($side_entries['next']) && !empty($blind_next_flag)) { ?>
			  <span class="next-link"><?php echo $this->Html->link(__l('Next'), array('controller' => 'contest_users', 'action' => 'view',$contestUser['Contest']['slug'],'entry'=>$side_entries['next']['ContestUser']['entry_no']), array('title' => __l('Next'),'escape' => false));?></span>
			<?php }
		  }?>
		</div>
		<div class="span9 no-mar pull-right js-conversation-block entry-side2 contest-user-discussion">
		  <!--discuss activity main block start-->
		  <div class="js-view-side-block-inner main-inner">
			<section>
			  <div data-toggle="collapse" data-target=".message-collapse" class="bot-space sep-bot bot-mspace row">
				<h4 class="textn top-space pull-left cur js-entry-view-toggle down-arrow"> <span class="hor-mspace hor-space textb"><?php echo __l('Discussions') . ' (' .  $discussion_count . ')';?></span> </h4>
				</div>
				<div class="top-mspace top-space text-11 message-collapse collapse in over-hide ">

			    <?php if(isPluginEnabled('HighPerformance')&& (Configure::read('HtmlCache.is_htmlcache_enabled') || Configure::read('cloudflare.is_cloudflare_enabled')))  { ?>
				  <div class="alcd {'cid':'<?php echo Configure::read('highperformance.cids'); ?>', 'cuid': '<?php echo Configure::read('highperformance.cuids'); ?>', 'entry': '<?php echo $this->request->params['named']['entry']; ?>', 'page': '<?php echo !empty($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1; ?>'}"></div>
			    <?php } else {?>
				  <?php echo $this->element('Contests.message-discussions',array('contest_id'=>$contestUser['Contest']['id'],'contet_user_id'=>$contestUser['ContestUser']['id'],'entry'=>$this->request->params['named']['entry'],'page'=>!empty($this->request->params['named']['page']) ? $this->request->params['named']['page'] : 1, 'cache' => array('config' => 'sec')));?>
			    <?php } ?>
			    </div>
				
			</section>
			<section class="top-mspace top-space">
			    <div class="sep-bot bot-space bot-mspace row" data-target=".message-collapse1" data-toggle="collapse">
				  <h4 class="textn top-space pull-left cur js-entry-view-toggle down-arrow">
					<span class="hor-mspace hor-space textb"><?php echo __l('Activities');?></span>
				  </h4>
			    </div>
			    <div class="top-mspace text-11 message-collapse1 collapse in over-hide" id="activities">
				  <?php echo $this->element('Contests.activities',array('contest_id'=>$contestUser['Contest']['id'],'contest_user_id'=>$contestUser['ContestUser']['id'], 'cache' => array('config' => 'sec'))); ?>
			    </div>
			</section>
		  </div>
		  <!--discuss activity main block start-->
		  </div>
	    </div>
	  </div>
	  <!--Contest user view total block End-->
    </div>
  </div>
</section>
<?php $admin_class = '';
if($this->Auth->user('role_id') == ConstUserTypes::Admin){
	$admin_class = 'admin-overlay';
}?>
<div class="<?php echo $admin_class; ?> js-overlay "></div>
<div class="modal hide fade" id="js-ajax-modal">
	<div class="modal-body"></div>
	<div class="modal-footer"> <a href="#" class="btn" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
</div>