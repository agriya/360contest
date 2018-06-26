<?php $this->Layout->setNode($node);  ?>
<div id="node-<?php echo $this->Layout->node('id'); ?>" class="node clearfix node-type-<?php echo $this->Layout->node('type'); ?>">
<?php if($this->Layout->node('slug') == 'steps') {?>
<ol class="banner-list clearfix">
<?php } ?>
<?php
$block_pages = array('steps','benefits');
if (!in_array($this->Layout->node('slug'), $block_pages)) {
?>
  <?php if(!empty($this->request->named['slug']) && ($this->request->named['slug'] != 'affiliate' && $this->request->named['slug'] != 'request-changes')){?>
  <h2 class="ver-mspace ver-space"><?php echo $this->Layout->node('title'); ?></h2>
    <?php } ?>
<?php } ?>
<?php
	if (!in_array($this->Layout->node('slug'), $block_pages)) {
		echo $this->Layout->nodeInfo();
	}
		echo $this->Layout->nodeBody();
	if (!in_array($this->Layout->node('slug'), $block_pages)) {
		echo $this->Layout->nodeMoreInfo();
	}
?>
<?php if($this->Layout->node('slug') == 'steps') {?>
</ol>
<?php } ?>
</div>
<?php if (!empty($types_for_layout[$this->Layout->node('type')])): ?>
<div id="comments" class="node-comments">
<?php
	if (!in_array($this->Layout->node('slug'), $block_pages)) {
		$type = $types_for_layout[$this->Layout->node('type')];
	if ($type['Type']['comment_status'] > 0 && $this->Layout->node('comment_status') > 0) {
		echo $this->element('comments', array('cache' => array('config' => 'sec')));
	}
	if ($type['Type']['comment_status'] == 2 && $this->Layout->node('comment_status') == 2) {
		echo $this->element('comments_form', array('cache' => array('config' => 'sec')));
	}
}
?>
</div>
<?php endif; ?>