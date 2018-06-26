<div class="js-response">
<div class="span15">
  <h3 class="sep-bot ver-mspace ver-space textn"><?php echo $this->pageTitle;?></h3>
  <table class="table table-striped sep">
    <thead>
      <tr>
        <th><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Contest Title'));?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('actual_end_date', __l('Ends'));?></div></th>
        <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count', __l('Entries'));?></div></th>
        <th class="dr span2"><div class="js-pagination"><?php echo $this->Paginator->sort('prize', __l('Prize') . ' (' . Configure::read('site.currency') . ')');?></div></th>
      </tr>
    </thead>
    <tbody>
    <?php if (!empty($contests)){ 
			foreach ($contests as $contest){
	?>
      <tr class="<?php if(!empty($contest['Contest']['is_highlight'])){ echo 'highlight_contest'; }?>">
        <td><div class="thumbnail sep-bot pull-left"> <?php echo $this->Html->link($this->Html->showImage('ContestType', !empty($contest['ContestType']['Attachment'])?$contest['ContestType']['Attachment']:array(), array('dimension' => 'normal_thumb', 'alt' => sprintf(__l('[Image: %s]'), $this->Html->cText($contest['ContestType']['name'], false)), 'title' => $this->Html->cText($contest['ContestType']['name'], false))), array('controller' => 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin'=> false), array('escape' => false ));?></div>
          <div class="span">
            <h5 class="no-mar pull-left span3 htruncate"><?php echo $this->Html->link($this->Html->cText($contest['Contest']['name']), array('controller'=> 'contests', 'action' => 'view', $contest['Contest']['slug'], 'admin' => false), array('escape' => false, 'class'=>'js-tooltip','title' => $this->Html->cText($contest['Contest']['name'], false)));?></h5>
            <span class="label-category hor-space hor-mspace htruncate span2 js-tooltip" title="<?php echo $this->Html->cText($contest['ContestType']['name'],false);?>"><?php echo $this->Html->cText($contest['ContestType']['name'],false);?></span> <span class="help-inline"><?php echo __l('by').' '.$this->Html->getUserLink($contest['User']);?></span> </div>
            <?php $class = '';
				if($contest['ContestStatus']['id'] == ConstContestStatus::Open):
					$class = 'label-success';
				elseif($contest['ContestStatus']['id'] == ConstContestStatus::Completed):
					$class = 'label-complete';
				elseif($contest['ContestStatus']['id'] == ConstContestStatus::ChangeRequested):
					$class = 'label-warning';
				endif;
			 ?>
          <span class="label <?php echo $class; ?> hor-mspace pull-left"><?php echo $this->Html->cText($contest['ContestStatus']['name']);?></span> </td>
        <td class="dc"><?php echo ($contest['Contest']['actual_end_date']!='0000-00-00 00:00:00')? $this->Html->cDateTimeHighlight($contest['Contest']['actual_end_date']):'-';?></td>
        <td class="dc"><?php echo $this->Html->cInt($contest['Contest']['contest_user_count']);?></td>
        <td class="pinkc textb text-16 dr"><?php echo $this->Html->cCurrency($contest['Contest']['prize']);?></td>
      </tr>
      <?php }}
	 else{ ?>
	 <tr>
           <td colspan="10"><div class="thumbnail space dc grayc">
					<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Contests'));?></p>
					</div></td>
     </tr>
	 <?php
	 }
	 ?>
    </tbody>
  </table>
  <div class="browse-contests-but grid_left">
		<?php echo $this->Html->link(__l('Browse more contest'), array('controller' => 'contests', 'action' => 'browse', 'admin' => false), array('title' => __l('Browse more contest'), 'class' => 'btn offset5'));?>
    </div>
</div>
</div>