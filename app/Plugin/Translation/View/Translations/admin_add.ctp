<?php /* SVN: $Id: admin_add.ctp 68881 2011-10-13 09:47:54Z josephine_065at09 $ */ ?>
<div class="hor-space">
<div class="translations form thumbnail">
	<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Translation'), array('action' => 'index'),array('title' => __l('Translation')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('Translation'));?></li>
    </ul>
	<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal'));?>
  <fieldset>
    <div class="padd-bg-tl">
      <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
      </div>
    </div>
    <div class="padd-center">
			<?php
        echo $this->Form->input('from_language', array('value' => __l('English'), 'disabled' => true));
        echo $this->Form->input('language_id', array('label' => __l('To Language')));
      ?>
      <?php
				if(Configure::read('google.translation_api_key')):
					$disabled = false;
				else:
					$disabled = true;
				endif; 
			?>
      <div class="clearfix translation-index-block">
        <div class="translation-left-block grid_left span10">
          <div class="clearfix">
						<?php
              echo $this->Form->submit('Manual Translate', array('name' => 'data[Translation][manualTranslate]'));
            ?>
          </div>
          <span class="info"><?php echo '<i class="icon-info-sign"></i>'.__l('It will only populate site labels for selected new language. You need to manually enter all the equivalent translated labels.');?> </span> </div>
        <div class="translation-right-block grid_left span12">
          <div class="clearfix"> <?php echo $this->Form->submit('Google Translate', array('name' => 'data[Translation][googleTranslate]', 'disabled' => $disabled));	?> </div>
          <div class="offset4"><?php echo '<i class="icon-info-sign"></i>'.__l('It will automatically translate site labels into selected language with Google. You may then edit necessary labels.');?> </div>
          <?php if(!Configure::read('google.translation_api_key')): ?>
          <div class="offset4">
            <?php echo '<i class="icon-warning-sign"></i>'.__l('Google Translate service is currently a paid service and you\'d need API key to use it.');?>
            <?php echo __l('Please enter Google Translate API key in ');
			  echo $this->Html->link(__l('Settings'), array('controller' => 'settings', 'action' => 'plugin_settings', 'Translation'), array('title' => __l('Settings'))). __l(' page');?> 
			  </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="padd-bg-bl">
      <div class="padd-bg-br">
        <div class="padd-bg-bmid"></div>
      </div>
    </div>
  </fieldset>
  <?php echo $this->Form->end();?>
</div>
</div>