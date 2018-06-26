<?php
	$class = 'node-body';
	if(!empty($this->request->params['named']['slug']) && $this->request->params['named']['slug'] == 'steps') {
		$class = 'clearfix';
	}
?>

<div class="<?php echo $class; ?>"> <?php echo $this->Layout->node('body'); ?> </div>
