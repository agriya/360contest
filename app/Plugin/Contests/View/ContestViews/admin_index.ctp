<?php /* SVN: $Id: admin_index.ctp 1279 2011-05-26 05:07:26Z siva_063at09 $ */ ?>
<div class="js-response">
<div class="sep-bot"></div>
  <div class="hor-space">
    <div class="row sep-bot space bot-mspace">
      <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
      </div>
	<?php if(empty($this->request->params['named']['contest'])){?>
	  <div class="span pull-right grayc">
        <div class="span hor-mspace">
			<?php echo $this->Form->create('ContestView' , array('type' => 'get', 'class' => 'form-search no-mar dc','action' => 'index')); ?>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => "input-medium hor-smspace search-query span4")); ?>
			<button type="submit" class="btn btn-success textb">Search</button>
			<?php echo $this->Form->end(); ?>
		</div>
	  </div>
	<?php } ?>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
    <?php echo $this->Form->create('ContestView' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <table class="table table-striped table-hover">
	  <thead class="yellow-bg">
        <tr class="sep-top sep-bot">
			<?php if(empty($this->request->params['named']['contest'])){?>
				<th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
			<?php } ?>
            <th class="sep-right dc"><?php echo __l('Actions');?></th>
            <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Viewed Time'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.name',__l('Contest'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username',__l('Viewed User'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip',__l('IP'));?></div></th>
        </tr>
	  </thead>
	  <tbody>
        <?php
        if (!empty($ContestViews)):
            foreach ($ContestViews as $contestView): ?>
                <tr>
					<?php if(empty($this->request->params['named']['contest'])){?>
					<td class="dc span1"><?php echo $this->Form->input('ContestView.'.$contestView['ContestView']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contestView['ContestView']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
					<?php } ?>
                    <td class="dc span1">
					  <div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
						<ul class="dropdown-menu dl arrow">
							<li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $contestView['ContestView']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?>
                                <?php echo $this->Layout->adminRowActions($contestView['ContestView']['id']);?>
                            </li>
                        </ul>
        			  </div>
					</td>
                    <td class="dc"><?php echo $this->Html->cDateTimeHighlight($contestView['ContestView']['created']);?></td>
                    <td>
					<div class="status-block"> <div class="status-block-inner">
						<span class="<?php echo $contestView['Contest']['ContestStatus']['slug']; ?>" title="<?php echo $contestView['Contest']['ContestStatus']['name']; ?>"><?php echo $contestView['Contest']['ContestStatus']['name']; ?></div>
						<?php echo $this->Html->link($this->Html->cText($contestView['Contest']['name']) , array('controller' => 'contests', 'action' => 'view', $contestView['Contest']['slug'], 'admin' => false) , array('escape' => false, 'title' => $contestView['Contest']['name'])); ?></span>
						</div>
					</td>
					<td>
						<?php 
							if(!empty($contestView['User'])){
								if(!empty($contestView['User']['username'])):
									echo $this->Html->getUserAvatarLink($contestView['User'], 'micro_thumb',true); echo " ";
									echo $this->Html->getUserLink($contestView['User']);
								else:
									echo __l('Guest');
								endif;
						}
					
						?>
					</td>
					<td>
						<?php if(!empty($contestView['Ip'])): ?>
							 <span class="show">
                            <?php
                               echo  $this->Html->link($contestView['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $contestView['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$contestView['Ip']['ip'], 'escape' => false)); ?>
							</span>
							<?php
                            if(!empty($contestView['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($contestView['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $contestView['Ip']['Country']['name']; ?>">
									<?php echo $contestView['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif;
							 if(!empty($contestView['Ip']['City'])):
                            ?>
                            <span> 	<?php echo $contestView['Ip']['City']['name']; ?>    </span>
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
                <td colspan="7" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('User Views'));?></td>
            </tr>
            <?php
        endif;
        ?>
	  </tbody>
    </table>
    <?php
    if (!empty($ContestViews)) :
        ?>
<section class="clearfix">
		<div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			
			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
		</div>
		<div class="span top-mspace pull-right">
			<div class="pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		</section>
		<div class="hide">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
    <?php endif;
    echo $this->Form->end();
    ?>
  </div>
</div>
</div>