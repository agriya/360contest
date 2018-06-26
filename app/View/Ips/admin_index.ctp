<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('Ip', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb"><?php echo __l('Search');?></button>
        <?php echo $this->Form->end(); ?>
      </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('Ip' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
	<thead class="yellow-bg">
        <tr class="sep-top sep-bot">
          <th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
          <th rowspan="2" class="sep-right dc"><?php echo __l('Actions');?></th>
          <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created',__l('Created'));?></div></th>
          <th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('ip',__l('IP'));?></div></th>
          <th colspan="5" class="sep-right dc"><?php echo __l('Auto detected'); ?></th>
        </tr>
        <tr>
          <th class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('City.name',__l('City'));?></div></th>
          <th class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('State.name',__l('State'));?></div></th>
          <th class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('Country.name',__l('Country'));?></div></th>
          <th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('latitude',__l('Latitude'));?></div></th>
          <th class="sep-right dr"><div class="js-pagination"><?php echo $this->Paginator->sort('longitude',__l('Longitude'));?></div></th>
        </tr>
	</thead>
	<tbody>
<?php
if (!empty($ips)):
$i = 0;
foreach ($ips as $ip):
	$status_class = 'js-checkbox-deactiveusers';
?>
	<tr>
		<td class="dc span1">
			<?php echo $this->Form->input('Ip.'.$ip['Ip']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$ip['Ip']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?>
        </td>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
                <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $ip['Ip']['id']), array('class' => 'delete js-confirm js-no-pjax','escape'=> false, 'title' => __l('Delete')));?> <?php echo $this->Layout->adminRowActions($ip['Ip']['id']);?> </li>		       
            </ul>
            </div>
         </td>
		<td class="dc"><?php echo $this->Html->cDateTime($ip['Ip']['created']);?></td>
		<td class="dl"><?php echo  $this->Html->link($ip['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $ip['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$ip['Ip']['ip'], 'escape' => false));?>
<?php if (!empty($ip['Ip']['user_agent'])) { ?>
        <span class="info chart-info js-tooltip grid_right" title="<?php echo $ip['Ip']['user_agent'];?>"><i class="icon-info-sign"></i></span>
<?php } ?>
      </td>
      <td class="dl"><?php echo $this->Html->cText($ip['City']['name']);?></td>
      <td class="dl"><?php echo $this->Html->cText($ip['State']['name']);?></td>
      <td class="dl"><?php echo $this->Html->cText($ip['Country']['name']);?></td>
      <td class="dr"><?php echo $this->Html->cFloat($ip['Ip']['latitude']);?></td>
      <td class="dr"><?php echo $this->Html->cFloat($ip['Ip']['longitude']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Ips'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($ips)):
?>
  <section class="clearfix">
	<div class="span top-mspace pull-left"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	 <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?> 
		 <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?> 
        <span class="hor-mspace">
        	<?php echo $this->Form->input('more_action_id', array('options' => $moreActions,'class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false, 'empty' => __l('-- More actions --'))); ?> 
        </span>
    </div>
    <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
      </div>
    </div>
	</section>
    <div class="hide">
	    <?php echo $this->Form->submit('Submit'); ?>
    </div>
<?php
endif;
echo $this->Form->end();
?>
</div>
</div>
</div>