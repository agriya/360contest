<div class="js-response">
<div class="hor-space">
  <div class="row space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('BannedIp', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb">Search</button>
        <?php echo $this->Form->end(); ?>
      </div>
      <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-plus-sign"></i></span> <span class="pinkc">' . __l('Add') . '</span>', array('controller' => 'banned_ips', 'action' => 'add'), array('class' => 'grayc','title'=>__l('Add'),'escape' => false)); ?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('BannedIp' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('BannedIp.address', __l('Victims'));?></div></th>
		<th rowspan="2" class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('BannedIp.reason', __l('Reason'));?></div></th>
		<th rowspan="2" class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('BannedIp.redirect', __l('Redirect to'));?></th>
		<th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('BannedIp.thetime', __l('Date Set'));?></div></th>
		<th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('BannedIp.timespan', __l('Expiry Date'));?></div></th>	
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($bannedIps)):
$i = 0;
foreach ($bannedIps as $bannedIp):
?>
	<tr>
		<td class="dc span1"><?php echo $this->Form->input('BannedIp.'.$bannedIp['BannedIp']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$bannedIp['BannedIp']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
		<td  class="dc span1">
        	<div class="dropdown"> <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
                      <ul class="dropdown-menu dl arrow">
                      
                      	 <li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $bannedIp['BannedIp']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape'=>false,'title' => __l('Delete')));?> </li>
                      </ul>
                    </div>
			 </td>
			 <td>
              		<?php
							if ($bannedIp['BannedIp']['referer_url']) :
							echo $bannedIp['BannedIp']['referer_url'];
							else:
							echo long2ip($bannedIp['BannedIp']['address']);
							if ($bannedIp['BannedIp']['range']) :
							echo ' - '.long2ip($bannedIp['BannedIp']['range']);
							endif;
							endif;
					?>
            </td>	
		<td class="dl"><?php echo $this->Html->cText($bannedIp['BannedIp']['reason']);?></td>
		<td class="dl"><?php echo $this->Html->cText($bannedIp['BannedIp']['redirect']);?></td>
		<td class="dc"><?php echo date('M d, Y h:i A', $bannedIp['BannedIp']['thetime']); ?></td>
		<td class="dc"><?php echo ($bannedIp['BannedIp']['timespan'] > 0) ? date('M d, Y h:i A', $bannedIp['BannedIp']['thetime']) : __l('Never');?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="11" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Banned IPs'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($bannedIps)):
?>
  <section class="clearfix">
		<div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			
			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
		</div>
		<div class="span top-mspace pull-right">
			<div class="pull-right">
				<?php echo $this->element('paging_links'); ?>
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