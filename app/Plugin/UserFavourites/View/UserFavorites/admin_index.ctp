<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="js-response">
<div class="sep-bot"></div>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
		<?php if (!(isset($this->request->params['isAjax']) && $this->request->params['isAjax'] == 1)): ?>
			<?php echo $this->Form->create('UserFavorite' , array('type' => 'get', 'class' => 'form-search no-mar dc','action' => 'index')); ?> 
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => "input-medium hor-smspace search-query span4")); ?> 
			<button type="submit" class="btn btn-success textb">Search</button>
            <?php echo $this->Form->end(); ?>
		<?php endif; ?>
	  </div>
	</div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
  <?php echo $this->Form->create('UserFavorite' , array('class' => 'normal','action' => 'update')); ?> <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <table class="table table-striped table-hover">
	<thead class="yellow-bg">
      <tr class="sep-top sep-bot">
		  <th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		  <th class="sep-right dc"><?php echo __l('Actions');?></th>
		  <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Added on'));?></div></th>
		  <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.title', __l('User'));?></div></th>
		  <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Followed User'));?></div></th>
		  <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('ip', __l('IP'));?></div></th>
	  </tr>
	</thead>
	<tbody>
    <?php if (!empty($userFavorites)):
	  foreach ($userFavorites as $userFavorite):	?>
		<tr>
			<td class="dc span1"><?php echo $this->Form->input('UserFavorite.'.$userFavorite['UserFavorite']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userFavorite['UserFavorite']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
			<td class="dc span1">
			  <div class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
				<ul class="dropdown-menu dl arrow">
                  <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $userFavorite['UserFavorite']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape'=>false,'title' => __l('Delete')));?> <?php echo $this->Layout->adminRowActions($userFavorite['UserFavorite']['id']);?> </li>
                </ul>
        	  </div>
			</td>
			<td class="dc"><?php echo $this->Html->cDateTimeHighlight($userFavorite['UserFavorite']['created']);?></td>
			<td><?php echo $this->Html->getUserAvatarLink($userFavorite['User'], 'micro_thumb',true);?> <?php echo $this->Html->link($this->Html->cText($userFavorite['User']['username']), array('controller'=> 'users', 'action'=>'view', $userFavorite['User']['username'], 'admin' => false), array('escape' => false));?> </td>
			<td><?php echo $this->Html->getUserAvatarLink($userFavorite['FavoriteUser'], 'micro_thumb',true);?> <?php echo $this->Html->link($this->Html->cText($userFavorite['FavoriteUser']['username']), array('controller'=> 'users', 'action'=>'view', $userFavorite['FavoriteUser']['username'], 'admin' => false), array('escape' => false));?> </td>
			<td>
			  <?php if(!empty($userFavorite['Ip']['ip'])): ?>
				<span class="show">
				  <?php echo  $this->Html->link($userFavorite['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userFavorite['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$userFavorite['Ip']['ip'], 'escape' => false));?>
				</span>
				<?php if(!empty($userFavorite['Ip']['Country'])):?>
					<span class="flags flag-<?php echo strtolower($userFavorite['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $userFavorite['Ip']['Country']['name']; ?>">
					<?php echo $userFavorite['Ip']['Country']['name']; ?> </span>
					<?php endif;
					if(!empty($userFavorite['Ip']['City'])):?>
          				<span><?php echo $userFavorite['Ip']['City']['name']; ?></span>
					<?php endif; ?>
			  <?php else: ?>
        		<?php echo __l('N/A'); ?>
			  <?php endif; ?>
			</td>
		  </tr>
		<?php endforeach;
	  else:?>
		  <tr>
			<td colspan="6"><p class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('user followers'));?></p></td>
		  </tr>
      <?php endif;?>
	</tbody>
  </table>
  <?php
		if (!empty($userFavorites)) :
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