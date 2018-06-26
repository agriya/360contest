<?php if (!empty($types_for_layout[$this->Layout->node('type')])): ?>
<div class="node-more-info">
  <?php
		$type = $types_for_layout[$this->Layout->node('type')];

		if (is_array($this->Layout->node['Taxonomy']) && count($this->Layout->node['Taxonomy']) > 0) {
			$nodeTerms = Set::combine($this->Layout->node, 'Taxonomy.{n}.Term.slug', 'Taxonomy.{n}.Term.title');
			$nodeTermLinks = array();
			if (count($nodeTerms) > 0) {
				foreach ($nodeTerms AS $termSlug => $termTitle) {
					$nodeTermLinks[] = $this->Html->link($termTitle, array(
						'controller' => 'nodes',
						'action' => 'term',
						'type' => $this->Layout->node('type'),
						'slug' => $termSlug,
					));
				}
				echo __l('Posted in') . ' ' . implode(', ', $nodeTermLinks);
			}
		}
		if ($this->request->params['action'] != 'view' && $type['Type']['comment_status']) {
			if (isset($nodeTerms) && count($nodeTerms) > 0) {
				echo ' | ';
			}
			$commentCount = '';
			if ($this->Layout->node('comment_count') == 0) {
				$commentCount = __l('Leave a comment');
			} elseif ($this->Layout->node('comment_count') == 1) {
				$commentCount = $this->Layout->node('comment_count') . ' ' . __l('Comment');
			} else {
				$commentCount = $this->Layout->node('comment_count') . ' ' . __l('Comments');
			}
			echo $this->Html->link($commentCount, Router::url($this->Layout->node('url'), true) . '#comments');
		}
	?>
</div>
<?php endif; ?>