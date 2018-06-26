<?php
	if ((Configure::read('site.launch_mode') == 'Pre-launch' && $this->Auth->user('role_id') != ConstUserTypes::Admin) || (Configure::read('site.launch_mode') == 'Private Beta' && !$this->Auth->user('id'))) {
		echo $this->element('subscription-add', array('cache' => array('config' => 'sec')), array('plugin' => 'LaunchModes'));
	} else {
?>
        <div class="row top-pattern top-paternshadow bot-mspace">
          <h2 class="text-32 dc ver-space top-mspace"><?php echo __l('Best contest marketplace software from Agriya Labs');?></h2>
          <h5 class="text-20 dc pinkc ver-smspace bot-space"><?php echo __l('Launch your image, video, audio and text contests site. Crowdsource instantly.');?></h5>
        </div>
		<div class="clearfix container">
		    <div class="clearfix bot-space">
                <?php echo $this->Html->image('360contest-banner.jpg', array('alt'=> '[Image: Banner]', 'width' => '953' , 'height' => '456')); ?>
            </div>
            <div class="top-space dc clearfix"><?php echo $this->Html->link(__l('Get Started'), array('controller' => 'contest_types', 'action' => 'index', 'admin' => false), array('class'=>'btn btn-large text-24','title'=>__l('Get Started'))); ?></div>
        </div>
        <?php echo $this->element('agriya_advantages',array('cache' => array('config' => 'sec'))); ?>
<?php
	}
?>