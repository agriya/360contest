<?php $this->pageTitle = __l('Tools'); ?>

<div class="page-tools" id="js-confirm-message-block">
<div class="space">
  <div class="alert alert-info"><?php echo __l('When cron is not working, you may trigger it by clicking below link. For the processes that happen during a cron run, refer the ').$this->Html->link('product manual','http://dev1products.dev.agriya.com/doku.php?id=360Contest-install#manual_cron_update_process', array('target'=>'_blank'));?></div>


  <div><?php echo $this->Html->link(__l('Manually trigger cron to update contest status'), array('controller' => 'crons', 'action' => 'main', 'admin' => false,'?f=' . $this->request->url), array('class' => 'js-confirm js-no-pjax tools btn', 'title' => __l('You can use this to update contest status. This will be used in the scenario where cron is not working.'))); ?></div>
</div>
<div class="space">
  <div ><?php echo $this->Html->link(__l('Manually trigger cron to delete payment pending contests'), array('controller' => 'crons', 'action' => 'daily', 'admin' => false,'?f=' . $this->request->url), array('class' => 'js-confirm js-no-pjax tools btn ', 'title' => __l('You can use this to delete the payment pending contests'))); ?></div>
</div>