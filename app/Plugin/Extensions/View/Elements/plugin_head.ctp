<div class="<?php echo 'offset' . ($depth+1); ?> space">
  <div class="clearfix">
   <div class="clearfix">
	   <div class="pull-left plug-img dc space">
		<?php if (in_array($key, array_keys($image_title_icons))) { ?>
		  <?php echo $this->Html->image('plugin-icons/' . $image_title_icons[$key]. '.png'); ?>
		<?php } else if (in_array($key, array_keys($title_font_icon))) { ?> 
			<i class="<?php echo $title_font_icon[$key]; ?> text-46"></i>
		<?php } ?>
	  </div>
	  <div class="span21 top-space">
		<h4><?php echo $key; ?></h4>
	  <?php if (in_array($key, array_keys($title_description))): ?>
		  <div class="grayc top-space">
			 <?php echo $this->Html->cText($title_description[$key]); ?>
		  </div>
	  <?php endif; ?>
   </div>
  </div>
  <div class="sep-bot bot-space"></div>
</div>
</div>