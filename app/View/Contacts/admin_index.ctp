<div class="js-response">
<div class="top-pattern sep-bot"></div>
<div class="container-fluid">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('Contact', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb">Search</button>
        <?php echo $this->Form->end(); ?>
      </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('Contact' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="2" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		<th rowspan="2" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		<th rowspan="2" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Created'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('user_id', __l('User'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('first_name', __l('First Name'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('email', __l('Email'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('subject', __l('Subject'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('message', __l('Message'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('telephone', __l('Telephone'));?></div></th>
        <th rowspan="2" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('ip', __l('IP'));?></div></th>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($contacts)):
$i = 0;
foreach ($contacts as $contact):
?>
	<tr>
    	
        
		<td class="dc span1"><?php echo $this->Form->input('Contact.'.$contact['Contact']['id'].'.id',array('type' => 'checkbox', 'id' => "admin_checkbox_".$contact['Contact']['id'],'label' => false , 'class' => 'js-checkbox-list')); ?> </td>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
                 <li><?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $contact['Contact']['id']), array('class' => 'delete js-confirm js-no-pjax', 'escape'=>false,'title' => __l('Delete')));?> <?php echo $this->Layout->adminRowActions($contact['Contact']['id']);?> </li>
            </ul>
            </div>
         </td>
        <td class="dc"><?php echo $this->Html->cDateTimeHighlight($contact['Contact']['created']);?></td>
		<td class="dc"><?php echo $this->Html->link($this->Html->cText($contact['User']['username']), array('controller'=> 'users', 'action' => 'view', $contact['User']['username'], 'admin' => false), array('escape' => false)); ?></td>
		<td class="dc"><?php echo $this->Html->cText($contact['Contact']['first_name']);?></td>
		<td class="dc"><?php echo $this->Html->cText($contact['Contact']['email']);?></td>
		<td class="dc">
		<?php
			if(!empty($contact['Contact']['subject'])):
				echo $this->Html->cText($contact['Contact']['subject']);
			else:
				echo $this->Html->cText($contact['ContactType']['name']);
			endif;
		?>
		</td>
		<td class="dc"><?php echo $this->Html->truncate($contact['Contact']['message']);?></td>
		<td class="dc"><?php echo !empty($contact['Contact']['telephone']) ? $this->Html->cText($contact['Contact']['telephone']) : '';?></td>
		<td class="dc">
					<?php echo $this->Html->cText($contact['Ip']['ip']);?>
                    <?php echo $this->Html->link(__l('whois'), array('controller' => 'users', 'action' => 'whois', $contact['Ip']['ip'], 'admin' => false), array('target' => '_blank', 'title' => __l('whois'), 'escape' => false));?></td>
	</tr>
<?php
    endforeach;
else:
?>
	<tr>
		<td colspan="15" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Contacts'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($contacts)):
?>
  <section class="clearfix">
	<div class="span top-mspace pull-left"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all hor-mspace', 'title' => __l('All'))); ?>
    	<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
    	<span class="hor-mspace">
        	 <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false,'empty' => __l('-- More actions --'))); ?> 
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