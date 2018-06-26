<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="js-response">
<div class="sep-bot"></div>
  <div class="hor-space">
    <?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
      <div class="row sep-bot space bot-mspace">
		<div class="span  top-smspace dc grayc">
          <?php echo $this->element('paging_counter'); ?>
		</div>
      	<?php if(empty($this->request->params['named']['contestid']) && empty($this->request->params['named']['entryid'])){?>
          <div class="span pull-right grayc">
			<div class="span hor-mspace">
				<?php echo $this->Form->create('ContestUserFlag' , array('type' => 'get', 'class' => 'form-search no-mar dc','action' => 'index')); ?>
				<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => "input-medium hor-smspace search-query span4")); ?>
				<button type="submit" class="btn btn-success textb">Search</button>
				<?php echo $this->Form->end(); ?>
			</div>
		  </div>
		<?php } ?>
	  </div>
    <?php endif; ?>
    <div class="tab-pane active in no-mar" id="learning">
	  <?php echo $this->Form->create('ContestUserFlag' , array('class' => 'normal','action' => 'update')); ?>
      <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	  <table class="table table-striped table-hover list pictures1 {'minHeight':120, 'maxHeight':150, 'maxWidth':150}">
        <thead class="yellow-bg">
          <tr class="sep-top sep-bot">
			<?php if(empty($this->request->params['named']['contestid']) && empty($this->request->params['named']['entryid'])){?>
            <th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
			<?php } ?>
            <th class="sep-right dc"><?php echo __l('Actions');?></th>
			<th class="sep-right"><?php echo __l('Entry'); ?></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Entry Flagged By'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ContestUser.name', Configure::read('contest.participant_alt_name_singular_caps'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ContestUserFlagCategory.name', __l('Flag Category'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('message', __l('Message'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'));?></div></th>
            <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted on'));?></div></th>
          </tr>
		</thead>
	    <tbody>
        <?php
        if (!empty($contest_userFlags)):
		  foreach ($contest_userFlags as $contest_userFlag):?>
            <tr>
			  <?php if(empty($this->request->params['named']['contestid']) && empty($this->request->params['named']['entryid'])){?>
                <td class="dc span1"><?php echo $this->Form->input('ContestUserFlag.'.$contest_userFlag['ContestUserFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contest_userFlag['ContestUserFlag']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
			  <?php } ?>
              <td class="dc span1">
                <div class="dropdown">
				  <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
				  <ul class="dropdown-menu dl arrow">
                    <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $contest_userFlag['ContestUserFlag']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?></li>
					<li>
					<?php echo $this->Html->link('<i class="icon-phone blackc"></i>'.sprintf(('Contact %s'),Configure::read('contest.participant_alt_name_singular_caps')), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $contest_userFlag['ContestUser']['User']['username'],'page' => 'contest_user_flag', 'contest_id' => $contest_userFlag['ContestUser']['Contest']['id'], 'admin' => false), array('data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'title' => sprintf(('Contact %s'),Configure::read('contest.participant_alt_name_singular_caps')), 'class' => 'js-no-pjax', 'escape' => false));?>
					</li>
					<li>
					<?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Contact Entry Reporter'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $contest_userFlag['User']['username'],'page' => 'contest_user_flag', 'contest_id' => $contest_userFlag['ContestUser']['Contest']['id'], 'admin' => false), array('data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'title' => __l('Contact Entry Reporter'), 'class' => 'js-no-pjax', 'escape' => false));?>
					</li>
       			  </ul>
        		</div>
              </td>			
			  <td>
			  <?php 
					$zoom_class='gp-gallery-hover'; ?>
					 <div class="entry-img-block <?php echo $zoom_class;?>">
					<ul class="pictures thumbnails row clearfix contest-list no-mar ver-space {'minHeight':142, 'maxHeight':182, 'maxWidth':700, 'column':4}">
						 <?php	if (!empty($contest_userFlag['ContestUser']['Contest']['Resource']['name'])) {
						$contest_userFlag1['ContestUser'] = $contest_userFlag['ContestUser'];
						$contest_userFlag1['Attachment'] = $contest_userFlag['ContestUser']['Attachment'];
						$contest_userFlag1['ContestUserStatus'] = $contest_userFlag['ContestUser']['ContestUserStatus'];
						$contest_userFlag1['Contest'] = $contest_userFlag['ContestUser']['Contest'];
						$contest_userFlag1['User'] = $contest_userFlag['ContestUser']['User'];
						$plugin = $contest_userFlag['ContestUser']['Contest']['Resource']['name']."Resources";
        				if (isPluginEnabled($plugin )) {?>
					       <li class="span5 no-mar pr">
						   <div class="picture-img thumbnail sep-bot no-round" style="height: 122px; width: 162px;"> 
						<?php echo $this->element($contest_userFlag['ContestUser']['Contest']['Resource']['name'] . '/compact_list', array('dimension' => 'entry_big_thumb', 'contestUser' => $contest_userFlag1, 'cache' => array('config' => 'sec')),array('plugin' => $plugin)); ?></li>
					 <ul> </div>
						<?php } } ?>
                    </div>
                     </div>
			  </td>
              <td>
                <?php echo $this->Html->getUserAvatarLink($contest_userFlag['User'], 'micro_thumb',true);?>
                <?php echo $this->Html->link($this->Html->cText($contest_userFlag['User']['username']), array('controller'=> 'users', 'action'=>'view', $contest_userFlag['User']['username'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($contest_userFlag['User']['username'],false)));?>
              </td>
              <td>
				<?php $contest_userFlag['ContestUser']['User'] = !empty($contest_userFlag['ContestUser']['User']) ? $contest_userFlag['ContestUser']['User'] : array(); ?>
                <?php echo $this->Html->getUserAvatarLink($contest_userFlag['ContestUser']['User'], 'micro_thumb',true);?>
                <?php echo $this->Html->link($this->Html->cText($contest_userFlag['ContestUser']['User']['username']), array('controller'=> 'users', 'action'=>'view', $contest_userFlag['ContestUser']['User']['username'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($contest_userFlag['ContestUser']['User']['username'],false)));?>
              </td>
              <td><?php echo $this->Html->cText($contest_userFlag['ContestUserFlagCategory']['name']);?></td>
              <td><div class="htruncate-ml2 js-tooltip" title="<?php echo $contest_userFlag['ContestUserFlag']['message'];?>"><?php echo $contest_userFlag['ContestUserFlag']['message'];?></div></td>
              <td>
				<?php if(!empty($contest_userFlag['Ip']['ip'])): ?>
				  <span class="show">
					<?php echo  $this->Html->link($contest_userFlag['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $contest_userFlag['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$contest_userFlag['Ip']['ip'], 'escape' => false));	?>
				  </span>
				  <?php if(!empty($contest_userFlag['Ip']['Country'])):?>
					<span class="flags flag-<?php echo strtolower($contest_userFlag['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $contest_userFlag['Ip']['Country']['name']; ?>">
						<?php echo $contest_userFlag['Ip']['Country']['name']; ?>
					</span>
				  <?php endif; 
				  if(!empty($contest_userFlag['Ip']['City'])):?>             
					<span> 	<?php echo $contest_userFlag['Ip']['City']['name']; ?>    </span>
				  <?php endif; ?>
				<?php else: ?>
				  <?php echo __l('N/A'); ?>
			  <?php endif; ?> 
			</td>
            <td class="dc"><?php echo $this->Html->cDateTimeHighlight($contest_userFlag['ContestUserFlag']['created']);?></td>
          </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="9"  class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('entry flags'));?></td>
            </tr>
            <?php
        endif;
        ?>
	  </tbody>
    </table>
    <?php
    if (!empty($contest_userFlags)) :
        ?>
<section class="clearfix">
         <?php if(empty($this->request->params['named']['contestid']) && empty($this->request->params['named']['entryid'])){?>
		 <div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			
			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
		</div>
		<?php }?>
		<div class="span top-mspace pull-right">
			<div class="pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		</section>
		<div class="hide">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
    <?php 
	endif;
    echo $this->Form->end();
    ?>
  </div>
</div>
</div>