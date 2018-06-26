<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="userFavorites index js-response">
  <h2><?php echo $this->pageTitle;?></h2>
  <?php echo $this->element('paging_counter');?>
	<?php echo $this->Form->create('UserFavorite' , array('class' => 'normal','action' => 'update')); ?>
	<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
  <table class="table">
    <tr>
      <th class="actions"><?php echo __l('Actions');?></th>
      <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Added on'));?></div></th>
      <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('FavoriteUser.username', Configure::read('contest.participant_alt_name_singular_caps'));?></div></th>
      <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('FavoriteUser.contest_user_count', __l('No. of Entries'));?></div></th>
      <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('FavoriteUser.contest_user_won_count', __l('Won Contests'));?></div></th>
      <?php if (isPluginEnabled('EntryRatings')) { ?>
      <th class="dl"><div><?php echo __l('Avg Rating'); ?></div></th>
      <?php } ?>
    </tr>
    <?php
			if (!empty($userFavorites)):
				$i = 0;
				foreach ($userFavorites as $userFavorite):
					$class = null;
					if ($i++ % 2 == 0) :
						$class = ' class="altrow"';
					endif;
				$avg_rating=!empty($userFavorite['UserFavorite']['average_rating'])?$userFavorite['UserFavorite']['average_rating']:'';
		?>
    <tr<?php echo $class;?>>
      <td class="actions"><div class="action-block"> <span class="action-information-block"> <span class="action-left-block">&nbsp; </span> <span class="action-center-block"> <span class="action-info"> <?php echo __l('Action');?> </span> </span> </span>
          <div class="action-inner-block">
            <div class="action-inner-left-block">
              <ul class="action-link clearfix">
                <li> <?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userFavorite['UserFavorite']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?> </li>
                <li> <?php echo $this->Html->link(__l('Contact').' '.Configure::read('contest.participant_alt_name_singular_caps'), array('controller'=>'messages','action'=>'compose','type' => 'contact','to' => $userFavorite['FavoriteUser']['username']), array('class' => 'contact-winner','title' => __l('Contact').' '.Configure::read('contest.participant_alt_name_singular_caps')));?> </li>
              </ul>
            </div>
            <div class="action-bottom-block"></div>
          </div>
        </div></td>
      <td class="dc"><?php echo $this->Html->cDateTimeHighlight($userFavorite['UserFavorite']['created']);?></td>
      <td class="dl">
				<?php 
					echo $this->Html->getUserAvatarLink($userFavorite['FavoriteUser'], 'micro_thumb',true);
					echo $this->Html->link($this->Html->cText($userFavorite['FavoriteUser']['username']), array('controller'=> 'users', 'action'=>'view', $userFavorite['FavoriteUser']['username'], 'admin' => false), array('escape' => false,'title'=>$this->Html->cText($userFavorite['FavoriteUser']['username'],false)));
				?>
      </td>
      <td class="dc"><?php echo $this->Html->cInt($userFavorite['FavoriteUser']['contest_user_count']);?> </td>
      <td class="dc"><?php echo $this->Html->cInt($userFavorite['FavoriteUser']['contest_user_won_count']);?> </td>
      <?php if (isPluginEnabled('EntryRatings')) { ?>
      <td class="dc"><?php echo $this->element('_star-rating', array('contest_user_id' => $userFavorite['UserFavorite']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => false, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings')); ?> </td>
      <?php } ?>
    </tr>
    <?php
				endforeach;
			else:
		?>
    <tr>
      <td colspan="6">
		<ol class="list top-participants-list unstyled space thumbnail">
			<li>
				<div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No Followed %s available'), Configure::read('contest.participant_alt_name_plural_caps'));?></p>
				</div>
			</li>
		</ol>
      </td>
    </tr>
    <?php
			endif;
		?>
  </table>
  <?php if (!empty($userFavorites)) : ?>
  <div class="clearfix">
    <div class="js-pagination grid_right"> <?php echo $this->element('paging_links'); ?> </div>
  </div>
  <div class="hide"> <?php echo $this->Form->submit('Submit');  ?> </div>
  <?php endif; ?>
  <?php echo $this->Form->end(); ?>
</div>