<?php /* SVN: $Id: admin_add.ctp 66983 2011-09-27 11:09:58Z josephine_065at09 $ */ ?>
<div class="space">
<div class="bannedIps form thumbnail">
  <div class="js-corner round-5" id="form-content"> <?php echo $this->Form->create('BannedIp', array('class' => 'form-large-fields form-horizontal add-live-form'));?>
  <ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Banned Ips'), array('action' => 'index'),array('title' => __l('Banned Ips')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Banned Ip'));?></li>
    </ul>
    <fieldset class="form-block round-5 space">
    <legend><h3><?php echo __l('Current User Information'); ?></h3></legend>
    <dl class="clearfix">
      <dt class="span5"><?php echo __l('Your IP: ');?></dt>
      <dd class=""><?php echo $ip;?></dd>
      <dt class="span5"><?php echo __l('Your Hostname: ');?></dt>
      <dd class=""><?php echo gethostbyaddr($ip);?></dd>
    </dl>
    <legend><h3><?php echo __l('Ban Type'); ?></h3></legend>
	<legend><h4><?php echo __l('Possibilities:'); ?></h4></legend>
    <div class="alert alert-success">
	<ul>
        <li><?php echo __l('- Single IP/Hostname: Fill in either a hostname or IP address in the first field.'); ?></li>
        <li><?php echo __l('- IP Range: Put the starting IP address in the left and the ending IP address in the right field.'); ?></li>
        <li><?php echo __l('- Referer block: To block google.com put google.com in the first field. To block google altogether.'); ?></li></ul>
    </div>
    <?php echo $this->Form->input('type_id', array('type' => 'radio', 'label' => __l('Select method'),'legend' => false));?> <?php echo $this->Form->input('address', array('label' => __l('Address/Range'))); ?> <?php echo $this->Form->input('range', array('info' => __l('(IP address, domain or hostname)'))); ?>
    <h3><?php echo __l('Ban Details'); ?></h3>
<?php
	echo $this->Form->input('reason', array('label' => __l('Reason'),'info' => __l('(optional, shown to victim)')));
	echo $this->Form->input('redirect', array('label' => __l('Redirect'),'info' => __l('(optional)')));
	echo $this->Form->input('duration_id', array('label' => __l('How long')));
	echo $this->Form->input('duration_time', array('info' => __l('Leave field empty when using permanent. Fill in a number higher than 0 when using another option!')));
?>
	<legend><h4><?php echo __l('Hints and tips:'); ?></h4></legend>
    <div class="alert alert-info">
      <ul>
        <li><?php echo __l('- Banning hosts in the 10.x.x.x / 169.254.x.x / 172.16.x.x or 192.168.x.x range probably won\'t work.'); ?></li>
        <li><?php echo __l('- Banning by internet hostname might work unexpectedly and resulting in banning multiple people from the same ISP!'); ?></li>
        <li><?php echo __l('- Wildcards on IP addresses are allowed. Block 84.234.*.* to block the whole 84.234.x.x range!'); ?></li>
        <li><?php echo __l('- Setting a ban on a range of IP addresses might work unexpected and can result in false positives!'); ?></li>
        <li><?php echo __l('- An IP address always contains 4 parts with numbers no higher than 254 separated by a dot!'); ?></li>
        <li><?php echo __l('- If a ban does not seem to work try to find out if the person you\'re trying to ban doesn\'t use <a href="http://en.wikipedia.org/wiki/DHCP" target="_blank" title="DHCP">DHCP.</a>'); ?></li>
      </ul>
    </div>
    </fieldset>
    <div class="clearfix form-actions"><div class="pull-left"> <?php echo $this->Form->submit(__l('Add'));?></div>
	<div class="hor-mspace hor-space pull-left"><?php echo $this->Html->link(__l('Cancel'), array('controller' => 'banned_ips', 'action' => 'index'), array( 'title' => __l('Cancel'), 'escape' => false,'class'=>'btn'));?> </div>
    </div>
<?php echo $this->Form->end(); ?> </div>
</div>
</div>