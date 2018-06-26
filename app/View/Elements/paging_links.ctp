<div class="paging clearfix js-pagination">
  <?php
	$this->Paginator->options(array(
		'url' => array_merge(array(
			'controller' => $this->request->params['controller'],
			'action' => $this->request->params['action'],
		) , $this->request->params['pass'], $this->request->params['named'])
	));
	$model=Inflector::classify($this->request->params['controller']);
	$named=$this->request->params['named'];
	if(!empty($this->Paginator->params['paging'][$model]['nextPage'])){
		$named['page']=$this->Paginator->params['paging'][$model]['page']+1;
		echo $this->Html->meta('canonical',array_merge(array(
		   'controller' => $this->request->params['controller'],
		   'action' => $this->request->params['action'],
			) , $this->request->params['pass'], $named), array('inline'=>false, 'rel'=>'next', 'type'=>null, 'title'=>null, 'block'=>'seo_paging'));
	} 
	if(!empty($this->Paginator->params['paging'][$model]['prevPage'])){
		$named['page']=$this->Paginator->params['paging'][$model]['page']-1;
		echo $this->Html->meta('canonical',array_merge(array(
			'controller' => $this->request->params['controller'],
			'action' => $this->request->params['action'],
		) , $this->request->params['pass'], $named), array('inline'=>false, 'rel'=>'prev', 'type'=>null, 'title'=>null, 'block'=>'seo_paging'));
	}
	echo $this->Paginator->prev('&laquo; ' . __l('Prev') , array(
		'class' => 'prev js-no-pjax',
		'escape' => false
	) , null, array(
		'tag' => 'span',
		'escape' => false,
		'class' => 'prev js-no-pjax'
	)), "\n";

	echo $this->Paginator->numbers(array(
		'modulus' => 2,
		'first' => 2,
		'last' => 2,
		'ellipsis' => '<span class="ellipsis">&hellip;.</span>',
		'separator' => " \n",
		'before' => null,
		'after' => null,
		'escape' => false,
		'class' => 'js-no-pjax'
	));
	
	echo $this->Paginator->next(__l('Next') . ' &raquo;', array(
		'class' => 'next js-no-pjax',
		'escape' => false
	) , null, array(
		'tag' => 'span',
		'escape' => false,
		'class' => 'next js-no-pjax'
	)), "\n";

?>
</div>