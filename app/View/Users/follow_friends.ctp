<?php if (!empty($followFriends)): ?>
  <div class="js-response">
      <h3><?php echo __l('Follow Friends'); ?></h3>
  <div>
      <?php echo $this->Form->create('UserFavorite' , array('action' => 'add_multiple','class' => 'normal')); ?>
      <?php
        $url = Router::url(array(
          'controller' => 'social_marketings',
          'action' => 'import_friends',
          'type' => $this->request->params['named']['type']
        ), true);
      ?>
      <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url)); ?>
      <div>
        <?php foreach($followFriends as $followFriend) { ?>
          <div class="bot-space clearfix">
            <span class="pull-left ver-space"><?php echo $this->Form->input('UserFavorite.'.$followFriend['User']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$followFriend['User']['id'], 'div' => false, 'label' => false, 'class' => ' js-checkbox-list')); ?></span>
            <span class="pull-left top-space"><a href="#" title="<?php echo $followFriend['User']['username']; ?>" class="blackc no-mar  dropdown-toggle span show"><span class="pull-left  span  no-mar">
			<?php $followFriend['User']['UserAvatar'] = !empty($followFriend['User']['UserAvatar']) ? $followFriend['User']['UserAvatar'] : array(); ?>
    		<?php echo $this->Html->getUserAvatarLink($followFriend['User'], 'micro_thumb'); ?>			
			</span><span class="top-space  span  blackc  hor-mspace">
			<?php echo $this->Html->getUserLink($followFriend['User']); ?>	
			</span></a></span>
          </div>
        <?php } ?>
      </div>
      <div><?php echo $this->Form->submit(__l('Follow')); ?></div>
      <?php echo $this->Form->end(); ?>
      <div class="js-pagination pull-right top-space"><?php echo $this->element('paging_links'); ?></div>
    </div>
  </div>
<?php endif; ?>