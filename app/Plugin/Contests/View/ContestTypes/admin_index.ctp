<div class="js-response">
<div class="top-pattern sep-bot"></div>
<?php if(isset($this->params['named']['type'])){ ?>
<div class="alert mspace alert-info"><?php echo __l('Template is mainly used to create common form fields to import while create contest type. Templates are not display in front end.'); ?></div>
<?php } ?>
<div class="hor-space">
  <div class="row sep-bot space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
        <?php echo $this->Form->create('ContestType', array('type' => 'get', 'class' => 'form-search no-mar dc', 'action'=>'index')); ?>
        <?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => 'input-medium hor-smspace search-query span4')); ?>
        <button type="submit" class="btn btn-success textb"><?php echo __l('Search');?></button>
        <?php echo $this->Form->end(); ?>
      </div>
    <div class="span dc pull-right  top-mspace">
    	<span class="hor-mspace">
			<?php
    		if(isset($this->params['named']['type'])){
    			echo $this->Html->link('<span><i class="icon-plus-sign grayc"></i></span>'.__l('Add'), array('action' => 'add', 'type' => $this->params['named']['type']), array('title' => __l('Add New Contest Template'), 'class' => 'add pinkc', 'escape' => false));
    		}
    		?>
        </span> 
    </div>
  </div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('ContestType' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
<thead class="yellow-bg">
 <tr class="sep-top sep-bot">
		<th rowspan="3" class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
		<th rowspan="3" class="sep-right dc"><?php echo __l('Actions'); ?></th>
		<th rowspan="3" class="sep-right dl"><div class="js-pagination"><?php echo $this->Paginator->sort('name', __l('Name')); ?></div></th>
        <th rowspan="3" class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('form_field_count', __l('Form Fields')); ?></div></th>
        <?php if (empty($this->request->params['named']['type'])): ?>
        	<th class="sep-right dc" colspan="<?php echo count($pricingPackages)+count($pricingDays);?>"><div class="js-pagination"><?php echo $this->Paginator->sort('', __l('Available Packages')); ?></div></th>
            <th class="sep-right dc" rowspan="3"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_user_count', __l('Contests Posted')); ?></div></th>
			<th class="sep-right dc" rowspan="3"><div class="js-pagination"><?php echo $this->Paginator->sort('contest_count', __l('Entries Posted')); ?></div></th>
			<th class="sep-right dr" rowspan="3"><div class="js-pagination"><?php echo $this->Paginator->sort('site_revenue', __l('Revenue ($)')); ?></div></th>
            </tr>
            <tr>
				<th class="sep-right dc" colspan="<?php echo count($pricingPackages);?>">
					<div class="js-pagination"><?php echo  sprintf(__l('Prize (%s) / Maximum entries'), Configure::read('site.currency')); ?></div>
				</th>
				<th class="sep-right dc" colspan='<?php echo count($pricingDays);?>'>
					<div class="js-pagination"><?php echo  sprintf(__l('Contest Days (%s)'), Configure::read('site.currency')); ?></div>
				</th>
			</tr>
            <tr>
				<?php 
                    if (!empty($pricingPackages)):
                        foreach ($pricingPackages as $pricingPackage):
                ?>
                <th class="sep-right dr"><div class="js-pagination"><?php echo $this->Html->cText($pricingPackage);?></div>
                </th>
                 <?php
                        endforeach;
                    endif;							
                ?>						
                <?php 
                    if (!empty($pricingDays)):
                        foreach ($pricingDays as $pricingDay):
                ?>
                <th class="sep-right dr"><div class="js-pagination"><?php echo $this->Html->cText($pricingDay);?></div>
                </th>
                 <?php
                        endforeach;
                    endif;							
                ?>
				</tr>
        <?php else: ?>
        </tr>
        <?php endif; ?>
	</tr>
	</thead>
	<tbody>
<?php
if (!empty($contestTypes)):
foreach ($contestTypes as $contestType):
	 if($contestType['ContestType']['is_active'])  :
			$status_class = 'js-checkbox-active';
		else:
			$status_class = 'js-checkbox-inactive';
		endif;
?>
	<tr>
    	
		<td class="dc span1"><?php echo $this->Form->input('ContestType.'.$contestType['ContestType']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$contestType['ContestType']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
		<td  class="dc span1">
        <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">		
              <li><?php echo $this->Html->link('<i class="icon-pencil"></i>'.__l('Overview'), array('action'=>'edit', $contestType['ContestType']['id'],'type' =>'overview'), array('class' => 'edit js-edit', 'escape'=> false, 'title' => __l('Overview')));?></li>
            <li><?php echo $this->Html->link('<i class="icon-tasks"></i>'.__l('Form Fields'), array('action'=>'edit', $contestType['ContestType']['id'],'type' =>'form_fields'), array('class' => 'form-fields js-edit', 'escape'=> false, 'title' => __l('Form Fields')));?></li>
            <?php if(empty($contestType['ContestType']['is_template'])): ?>		<li><?php echo $this->Html->link('<i class="icon-tasks"></i>'.__l('Pricing'), array('action'=>'pricing', $contestType['ContestType']['id']), array('class' => 'pricing','escape'=> false, 'title' => __l('Pricing')));?>
            </li>
            <?php endif; ?>
            <li><?php echo $this->Html->link('<i class="icon-zoom-in"></i>'.__l('Preview'), array('controller' => 'contests', 'action'=>'add', 'contest_type_id' => $contestType['ContestType']['id'], 'type' => 'preview'), array('class' => 'view', 'escape'=> false,'title' => __l('Preview')));?>
            </li>
            <li><?php echo $this->Layout->adminRowActions($contestType['ContestType']['id']);?></li>	
            <li class="divider"></li>						
               <li>
				<?php if(!empty($this->request->params['named']['type'])&& $this->request->params['named']['type']=='templates'):
                    echo $this->Html->link(($contestType['ContestType']['is_active'] ==1)?'<i class="icon-eye-close"></i>'. __l('Inactive'): '<i class="icon-eye-open"></i>'.__l('Active'), array('controller' => 'contest_types', 'action'=>'update_status', $contestType['ContestType']['id'],'status'=>($contestType['ContestType']['is_active'] ==1)? 'inactive': 'active','type'=>'templates'), array('class' => ($contestType['ContestType']['is_active'] ==1)? 'js-confirm js-no-pjax reject': 'js-confirm js-no-pjax active-link', 'title' => ($contestType['ContestType']['is_active'] ==1)? __l('Inactive'): __l('Active'), 'escape' => false));
                    else:
                    echo $this->Html->link(($contestType['ContestType']['is_active'] ==1)?'<i class="icon-eye-close"></i>'. __l('Inactive'): '<i class="icon-eye-open"></i>'.__l('Active'), array('controller' => 'contest_types', 'action'=>'update_status', $contestType['ContestType']['id'],'status'=>($contestType['ContestType']['is_active'] ==1)? 'inactive': 'active'), array('class' => ($contestType['ContestType']['is_active'] ==1)? 'js-confirm js-no-pjax reject': 'js-confirm js-no-pjax active-link', 'title' => ($contestType['ContestType']['is_active'] ==1)? __l('Inactive'): __l('Active'), 'escape' => false));
                    endif;?>
                </li>
                <li>
					<?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), array('action' => 'delete', $contestType['ContestType']['id']), array('class' => 'delete js-confirm js-no-pjax','escape'=>false, 'title' => __l('Delete')));?>
                 </li>
            </ul>
            </div>
         </td>
		<td class="dl">
			<?php echo $this->Html->cText($contestType['ContestType']['name']);?>
			<div><?php echo $this->Html->cText($contestType['Resource']['name']);?></div>
        </td>
        <td class="dc"><?php echo $this->Html->cText($contestType['ContestType']['form_field_count']);?></td>
        <?php if (empty($this->request->params['named']['type'])): ?>
		<?php 							
            if (!empty($contestTypesPricingPackageArr)):
                foreach ($contestTypesPricingPackageArr[$contestType['ContestType']['id']] as $key => $pricingPackage):	
        ?>
        <td class="dr">
            <?php echo $this->Html->cText($pricingPackage);?>
        </td>
         <?php									
                endforeach;
            endif;							
        ?>
        <?php 							
			if (!empty($contestTypesPricingDayArr)):
				foreach ($contestTypesPricingDayArr[$contestType['ContestType']['id']] as $key => $pricingDay):	
		?>
		<td class="dr">
			<?php echo $this->Html->cCurrency($pricingDay);?>
		</td>
		 <?php									
				endforeach;
			endif;							
		?>	
		<td class="dc"><?php echo $this->Html->cInt($contestType['ContestType']['contest_user_count']) ;?></td>
		<td class="dc"><?php echo $this->Html->cInt($contestType['ContestType']['contest_count']) ;?></td>
		<td class="dr"><?php echo $this->Html->cCurrency($contestType['ContestType']['site_revenue']) ;?></td>
		<?php endif; ?>
	</tr>
<?php
    endforeach;
else:
	$title = 'contest types';
	if(!empty($this->request->params['named']['type']) && $this->request->params['named']['type'] == 'templates'){
		$title = 'contest template';
	}

	?>
	<tr>
		<td colspan="15" class="notice"><?php echo sprintf(__l('No '.$title.' available'));?></td>
	</tr>
<?php
endif;
?>
</tbody>
</table>
<?php
if (!empty($contestTypes)):
?>
<section class="clearfix">
	<div class="span top-mspace pull-left"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all', 'title' => __l('All'))); ?>
		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none', 'title' => __l('None'))); ?>
        <?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending', 'title' => __l('Inactive'))); ?>
        <?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved', 'title' => __l('Active'))); ?>
    	<span class="hor-mspace">
        	<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false, 'empty' => __l('-- More actions --'))); ?>
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