<?php /* SVN: $Id: admin_add.ctp 196 2009-05-25 14:59:50Z siva_43ag07 $ */ ?>
<div class="hor-space">
<div class="translations form thumbnail">
		<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Translation'), array('action' => 'index'),array('title' => __l('Translation')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Add %s'), __l('New Language Variable'));?></li>
    </ul>
	<?php echo $this->Form->create('Translation', array('class' => 'form-horizontal', 'action' => 'add_text')); ?>
  <fieldset>
    <div class="padd-bg-tl">
      <div class="padd-bg-tr">
        <div class="padd-bg-tmid"></div>
      </div>
    </div>
    <div class="padd-center">
			<?php 
				echo $this->Form->input('Translation.name', array('label' => __l('Original')));
    		foreach ($languages as $lang_id => $lang_name) :
    	?>
      <h4 class="language-text-block"><?php echo $lang_name;?></h4>
      <?php
					echo $this->Form->input('Translation.'.$lang_id.'.lang_text');
				endforeach;
    	?>
    </div>
    <div class="padd-bg-bl">
      <div class="padd-bg-br">
        <div class="padd-bg-bmid"></div>
      </div>
    </div>
  </fieldset>
  <div class="submit-block  clearfix">
    <?php
			echo $this->Form->submit(__l('Add'));
		?>
  </div>
  <?php
    echo $this->Form->end();
  ?>
</div>
</div>