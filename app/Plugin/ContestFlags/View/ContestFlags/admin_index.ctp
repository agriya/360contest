<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="js-response">
<div class="sep-bot"></div>
  <div class="hor-space">
    <?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
      <div class="row sep-bot space bot-mspace">
        <div class="span  top-smspace dc grayc">
          <?php echo $this->element('paging_counter'); ?>
        </div>
        <div class="span pull-right grayc">
          <div class="span hor-mspace">
		    <?php if(empty($this->request->params['named']['contest'])){?>
				<?php echo $this->Form->create('ContestFlag' , array('type' => 'get', 'class' => 'form-search no-mar dc','action' => 'index')); ?>
				<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
				<button type="submit" class="btn btn-success textb"><?php echo __('Search');?></button>
				<?php echo $this->Form->end(); ?>
			<?php } ?>
		  </div>
		</div>
	  </div>
    <?php endif; ?>
  <div class="tab-pane active in no-mar" id="learning">
    <?php echo $this->Form->create('ContestFlag' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
	<table class="table table-striped table-hover">
	  <thead class="yellow-bg">
        <tr class="sep-top sep-bot">
			<?php if(empty($this->request->params['named']['contest'])){?>
            <th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
			<?php } ?>
            <th class="sep-right dc"><?php echo __l('Actions');?></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Contest Flagged by'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.name', __l('Contest'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ContestFlagCategory.name', __l('Flag Category'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('message', __l('Message'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('IP'));?></div></th>
            <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Posted on'));?></div></th>
        </tr>
	  </thead>
	  <tbody>
        <?php
        if (!empty($contestFlags)):
          foreach ($contestFlags as $contestFlag):
          ?>
            <tr>
			  <?php if(empty($this->request->params['named']['contest'])){?>
                    <td class="dc span1"><?php echo $this->Form->input('ContestFlag.'.$contestFlag['ContestFlag']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contestFlag['ContestFlag']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
					<?php } ?>
                    <td class="dc span1">
                      <div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
						<ul class="dropdown-menu dl arrow">
							<li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $contestFlag['ContestFlag']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?></li>
							<li>
							<?php echo $this->Html->link('<i class="icon-phone blackc"></i>'.__l('Contact Contest Holder'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $contestFlag['Contest']['User']['username'],'page' => 'contest_flag', 'contest_id' => $contestFlag['Contest']['id'], 'admin' => false), array('data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'title' => __l('Contact Contest Holder'), 'class' => 'js-no-pjax', 'escape' => false));?>
							</li>
							<li>
							<?php echo $this->Html->link('<i class="icon-user blackc"></i>'.__l('Contact Reporter'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $contestFlag['User']['username'],'page' => 'contest_flag', 'contest_id' => $contestFlag['Contest']['id'], 'admin' => false), array('data-toggle' =>'modal', 'data-target' => '#js-ajax-modal', 'class' => 'js-no-pjax', 'title' => __l('Contact Reporter'), 'escape' => false));?>
							</li>
       					</ul>
        			  </div>
                    </td>
                    <td>
                     <?php
                         echo $this->Html->getUserAvatarLink($contestFlag['User'], 'micro_thumb',true);?>
                        <?php echo $this->Html->link($this->Html->cText($contestFlag['User']['username']), array('controller'=> 'users', 'action'=>'view', $contestFlag['User']['username'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($contestFlag['User']['username'],false)));?>
                    </td>
                    <td>
					<div class="status-block"><div class="status-block-inner">
                       <?php if(!empty($contestFlag['Contest']['ContestStatus']['name'])){ 
						   $c = '';
						   if($contestFlag['Contest']['ContestStatus']['slug'] == 'pending-action-to-admin') {
							   $c = 's';
						   }?>
                         <span class="<?php echo $contestFlag['Contest']['ContestStatus']['slug'] . $c;?>" title="<?php echo $contestFlag['Contest']['ContestStatus']['name'];?>"> 
                           <?php echo  $this->Html->cText($contestFlag['Contest']['ContestStatus']['name']);?>
                         </span> </div>
                       <?php } else {?>
                         <div class="inactive"><?php echo __l('Inactive');?></div>
                       <?php } ?>
				       <?php echo $this->Html->link($this->Html->cText($contestFlag['Contest']['name']), array('controller'=> 'contests', 'action'=>'view', $contestFlag['Contest']['slug'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($contestFlag['Contest']['name'],false)));?>
                    </div>
					</td>
                    <td><?php echo $this->Html->cText($contestFlag['ContestFlagCategory']['name']);?></td>
                    <td><div class="htruncate-ml2 js-tooltip" title="<?php echo $contestFlag['ContestFlag']['message'];?>"><?php echo $contestFlag['ContestFlag']['message'];?></div></td>
                    <td>
					  <?php if(!empty($contestFlag['Ip']['ip'])): ?>	
					    <span class="show">
                            <?php echo  $this->Html->link($contestFlag['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $contestFlag['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$contestFlag['Ip']['ip'], 'escape' => false));								
							?>
						</span>
						<?php if(!empty($contestFlag['Ip']['Country'])):?>
                          <span class="flags flag-<?php echo strtolower($contestFlag['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $contestFlag['Ip']['Country']['name']; ?>">
							<?php echo $contestFlag['Ip']['Country']['name']; ?>
						  </span>
                        <?php endif; 
						if(!empty($contestFlag['Ip']['City'])):?>             
                            <span> 	<?php echo $contestFlag['Ip']['City']['name']; ?>    </span>
                        <?php endif; ?>
                      <?php else: ?>
							<?php echo __l('N/A'); ?>
					  <?php endif; ?> 
					</td>
                    <td class="dc"><?php echo $this->Html->cDateTimeHighlight($contestFlag['ContestFlag']['created']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="9" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Contest Flags'));?></td>
            </tr>
            <?php
        endif;
        ?>
	  </tbody>
    </table>
    <?php
    if (!empty($contestFlags)) :
        ?>
		<section class="clearfix">
       	<?php if(empty($this->request->params['named']['contest'])){?>
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
<div class="modal hide fade" id="js-ajax-modal">
  <div class="modal-body">
  	<div class="dc space"><?php echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loader]'), 'width' => 25, 'height' => 25)); ?>
	<span class="loading grayc">Loading....</span></div>
  </div>
  <div class="modal-footer">
    <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a>
  </div>
</div>