<?php if (empty($this->request->params['isAjax'])) { ?>
<div class="span16">
  <div class="js-response ver-space">
<?php } ?>
    <h3><?php echo __l('Invite Friends'); ?></h3>
    <?php echo $this->Form->create('SocialContact' , array('class' => 'clearfix js-no-pjax js-shift-click', 'action' => 'update')); ?>
    <?php
      $url = Router::url(array(
      'controller' => 'social_marketings',
      'action' => 'import_friends',
      'type' => $this->request->params['named']['type']
      ), true);
    ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $url)); ?>
    <table class="table table-striped table-bordered table-condensed">
      <tr>
        <th><?php echo __l('Select'); ?></th>
        <th><?php echo __l('Contact Name'); ?></th>
        <th><?php echo __l('Contact E-mail'); ?></th>
      </tr>
      <?php if (!empty($inviteUsers)): ?>
      <?php foreach ($inviteUsers as $inviteUser): ?>
      <tr>
        <td class="dc"><?php echo $this->Form->input('SocialContact.' . $inviteUser['SocialContact']['id'] . '.id', array('type' => 'checkbox', 'id' => 'admin_checkbox_' . $inviteUser['SocialContact']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
        <td><?php echo $this->Html->cText($inviteUser['SocialContactDetail']['name']); ?></td>
        <td><?php echo $this->Html->cText($inviteUser['SocialContactDetail']['email']); ?></td>
      </tr>
      <?php endforeach; ?>
      <?php else: ?>
      <tr>
        <td class="notice space"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No contacts available'));?></td>
      </tr>
      <?php endif; ?>
    </table>
	<?php if (!empty($inviteUsers)): ?>
	<div class="pull-right js-pagination"><?php echo $this->element('paging_links'); ?></div>
	<?php endif; ?>
    <?php if (!empty($inviteUsers)) { ?>
    	<div class="submit-block clearfix hor-space"><?php echo $this->Form->submit(__l('Send')); ?></div>
    <?php } ?>
    <?php echo $this->Form->end(); ?>
<?php if (empty($this->request->params['isAjax'])) { ?>
  </div>
</div>
<div class="span5">
	<?php echo $this->element('follow-friends', array('type' => $this->request->params['named']['type'], 'cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
</div>
<?php } ?>