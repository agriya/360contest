<ul class="unstyled clearfix hor-space">
  <?php
    if (!empty($messages)) {
      foreach ($messages as $message):
  ?>
  <li class="top-space">
	<div class="span clearfix grayc hor-mspace">
		<div class="pull-left admin-activities">
		<?php 
		  echo $this->Html->displayActivities($message);
		  $time_format = date('Y-m-d\TH:i:sP', strtotime($message['Message']['created']));
		?> 
		<span class="js-timestamp" title="<?php echo $time_format;?>"><?php echo $message['Message']['created']; ?></span>
		</div>
		
	</div>
  </li>
  <?php
      endforeach;
    } else {
  ?>
  <li>
		<div class="thumbnail space dc grayc">
		<p class="ver-mspace top-space text-16"><?php echo __l('No activities found');?></p>
     </div>
  </li>
  <?php }  ?>
</ul>