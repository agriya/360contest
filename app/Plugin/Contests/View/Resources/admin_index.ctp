<div class="alert alert-info mspace"><?php echo __l('Resource can be Image, Audio, Video and Text. With "Image", only image specific contests can be created. Only purchased, "Resources" will be listed, additional "Resources" can be bought from Agriya as plugins.') ?></div>
<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<table class="table table-striped table-hover">
<thead class="yellw-bg">
 <tr class="sep-top sep-bot">
		<th class="actions sep-right"><?php echo __l('Actions');?></th>
		<th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name'));?></div></th>
        <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('description', __l('Description'));?></div></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_count', __l('Contests Posted'));?></div></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count', __l('Entries Posted'));?></div></th>
		<th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('revenue', __l('Revenue') . ' ('.Configure::read('site.currency').')');?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($resources)):
$i = 0;
foreach ($resources as $resource):
?>
	<tr>
		<td  class="dc span1">
			<div class="dropdown">
				<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
				<ul class="dropdown-menu dl arrow">
					<li><?php echo $this->Html->link(__l('Contest Types'), array('controller' => 'contest_types', 'action' => 'index', $resource['Resource']['id']), array('class' => 'edit js-edit', 'title' => __l('Contest types')));
							?>
					 </li>
					 <li>
						<?php echo $this->Html->link(__l('Add Contest Type'), array('controller' => 'contest_types', 'action'=>'add', $resource['Resource']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit'), 'escape' => false));?>
					 </li>
				</ul>
            </div>
		 </td>
		<td class="dc"><?php echo $this->Html->cDateTime($resource['Resource']['created']);?></td>
		<td class="dl"><?php echo $this->Html->cText($resource['Resource']['name']);?></td>
		<td class="dl"><?php echo $this->Html->cText($resource['Resource']['description']);?></td>
		<td class="dl"><?php echo $this->Html->cText($resource['Resource']['contest_count']);?></td>
		<td class="dl"><?php echo $this->Html->cText($resource['Resource']['contest_user_count']);?></td>
		<td class="dl"><?php echo $this->Html->cText($resource['Resource']['revenue']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Resources'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($resources)):
?>
    <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
      </div>
    </div>
    <div class="hide">
	    <?php echo $this->Form->submit('Submit'); ?>
    </div>
<?php
endif;
?>
</div>
</div>
</div>