<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="js-response">
<div class="sep-bot"></div>
  <div class="hor-space">
<?php if(empty($this->request->params['named']['contestid'])){?>
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
		<?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
			<?php echo $this->Form->create('ContestFollower' , array('type' => 'get', 'class' => 'form-search no-mar dc','action' => 'index')); ?>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => "input-medium hor-smspace search-query span4")); ?>
			<button type="submit" class="btn btn-success textb">Search</button>
			<?php echo $this->Form->end(); ?>
		<?php endif; ?>
      </div>
    </div>
  </div>
<?php }?>
<div class="tab-pane active in no-mar" id="learning">
    <?php echo $this->Form->create('contestFollower' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <table class="table table-striped table-hover">
	  <thead class="yellow-bg">
        <tr class="sep-top sep-bot">
			<?php if(empty($this->request->params['named']['contestid'])){?>
            <th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
			<?php } ?>
            <th class="sep-right dc"><?php echo __l('Actions');?></th>
			<th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('ContestFollower.created', __l('Added'));?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.slug', __l('Contest'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.title', __l('User'));?></div></th>
			<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ip', __l('IP'));?></div></th>
        </tr>
	  </thead>
	  <tbody>
        <?php
        if (!empty($contestFollowers)):
          foreach ($contestFollowers as $contestFollower):?>
             <tr>
				<?php if(empty($this->request->params['named']['contestid'])){?>
                    <td class="dc span1"><?php echo $this->Form->input('contestFollower.'.$contestFollower['ContestFollower']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contestFollower['ContestFollower']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
					<?php } ?>
                    <td class="dc span1">
                      <div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
						<ul class="dropdown-menu dl arrow">
                          <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('controller' => 'contest_followers', 'action' => 'delete', $contestFollower['ContestFollower']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?></li>
                   		</ul>
        			  </div>
                    </td>
					<td class="dc"><?php echo $this->Html->cDateTimeHighlight($contestFollower['ContestFollower']['created']);?></td>
					<td>
					<div class="status-block"> <div class="status-block-inner">
					                <span class="<?php echo $contestFollower['Contest']['ContestStatus']['slug'];?>" title="<?php echo $contestFollower['Contest']['ContestStatus']['name'];?>">
                     <?php echo  $this->Html->cText($contestFollower['Contest']['ContestStatus']['name']);?>
                </span>
					<?php echo $this->Html->link($this->Html->cText($contestFollower['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $contestFollower['Contest']['slug'], 'admin' => false), array('escape' => false, 'title' => $contestFollower['Contest']['name'])); ?>
					</div>
					</td>
                    <td>
					<span>
                    <?php
                      echo $this->Html->getUserAvatarLink($contestFollower['User'], 'micro_thumb',true);?>
					</span>
					<?php echo $this->Html->link($this->Html->cText($contestFollower['User']['username'], false), array('controller' => 'users', 'action' => 'view', $contestFollower['User']['username'], 'admin' => false), array('title' => $contestFollower['User']['username'])); ?></td>
					<td>
						<?php if(!empty($contestFollower['Ip']['ip'])): ?>
						  <span class="show">
							<?php echo  $this->Html->link($contestFollower['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $contestFollower['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$contestFollower['Ip']['ip'], 'escape' => false));
							?>
							</span>
							<?php
							if(!empty($contestFollower['Ip']['Country'])):
								?>
								<span class="flags flag-<?php echo strtolower($contestFollower['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $contestFollower['Ip']['Country']['name']; ?>">
									<?php echo $contestFollower['Ip']['Country']['name']; ?>
								</span>
								<?php
							endif;
							 if(!empty($contestFollower['Ip']['City'])):
							?>
							<span> 	<?php echo $contestFollower['Ip']['City']['name']; ?>    </span>
							<?php endif; ?>
						<?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>
					</td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4"><p class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Contest Followers'));?></p></td>
            </tr>
            <?php
        endif;
        ?>
	  </tbody>
    </table>
    <?php
    if (!empty($contestFollowers)) :
        ?>
	<section class="clearfix">
        <?php if(empty($this->request->params['named']['contestid'])){?>
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