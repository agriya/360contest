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
	<thead class="yellow-bg">
        <tr class="sep-top sep-bot">
          <th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Actions');?></th>
          <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('name',__l('Name'));?></div></th>
          <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('message',__l('Message'));?></div></th>
          <th class="dc"><?php echo $this->Paginator->sort('is_credit',__l('Credit'));?></th>
        </tr>
	</thead>
	<tbody>
<?php
if (!empty($transactionTypes)):
$i = 0;
foreach ($transactionTypes as $transactionType):
?>
	<tr>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
               <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Edit'), array('action' => 'edit', $transactionType['TransactionType']['id']), array('class' => 'edit js-edit','escape'=> false, 'title' => __l('Edit')));?>
				<?php echo $this->Layout->adminRowActions($transactionType['TransactionType']['id']);?>	       
            </ul>
            </div>
         </td>
		<td class="dl"><?php echo $this->Html->cText($transactionType['TransactionType']['name']);?></td>
        <td class="dl"><?php echo $this->Html->cText($transactionType['TransactionType']['message']);?></td>
        <td class="dc"><?php echo $this->Html->cBool($transactionType['TransactionType']['is_credit']);?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Transaction Types'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($ips)):
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