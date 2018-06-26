<div class="js-response span24">
<?php if(!empty($this->request->params['named']['from']) && $this->request->params['named']['from'] != 'user_view'){ ?>
  <h3 class="sep-bot bot-space ver-mspace textn">
    <?php if(empty($this->pageTitle)):
	  echo __l('Participated Contests');
    else:
 	  echo $this->pageTitle;
	endif;?>
  </h3>
  <?php } ?>
	<ul class="pictures thumbnails row clearfix contest-list no-mar ver-space {'minHeight':95, 'maxHeight':100, 'maxWidth':800, 'column':4}">
	  <?php if (!empty($contestUsers)):
		foreach ($contestUsers as $contestUser):
		  $plugin = $contestUser['Contest']['Resource']['name']."Resources";
		  if (isPluginEnabled($plugin )):?>
			<li class="span5 no-mar pr gp-gallery-hover">
			  <div class="picture-img thumbnail sep-bot no-round "> 
				<?php echo $this->element($contestUser['Contest']['Resource']['name'].'/compact_list', array('dimension'=>'entry_big_thumb','contestUser' => $contestUser, 'cache' => array('config' => 'sec')),array('plugin' => $plugin ));?>
				
			  </div>
			   <span class="clearfix entries-user-details"><?php echo $this->Html->link('#' . $contestUser['ContestUser']['entry_no'], array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'], 'entry' => $contestUser['ContestUser']['entry_no']));?></span>

            </li>
		  <?php endif;
		endforeach;
	  else:?>
		<li class="span24 pr gp-gallery-hover"><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('entries'));?></p>
					</div></li>
	  <?php endif; ?>
	</li>
	</ul>
	<?php if (!empty($contestUsers)) :?>              
	  <div class="row ver-mspace ver-space">
		<div class="paging row offset8 js-pagination">  <?php echo $this->element('paging_links'); ?> </div>
	  </div>
	<?php endif; ?>
</div>