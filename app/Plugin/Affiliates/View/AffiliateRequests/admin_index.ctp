<?php /* SVN: $Id: $ */ ?>
<div class="affiliateRequests index">
<section class="page-header no-mar ver-space mspace">
<div class="top-pattern-contest  container-fluid space">
  <ul class="row no-mar mob-c unstyled top-mspace">
  <?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Pending) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Pending) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Pending');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-off no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Pending') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($waiting_for_approval,false).'</span>', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Pending), array('class' => 'blackc', 'escape' => false));?>
  </li>
  <?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Accepted) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Accepted) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Approved');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-ok-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Approved') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($approved,false).'</span>', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Accepted), array('class' => 'blackc', 'escape' => false));?>
  </li>
  <?php $class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Rejected) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['main_filter_id']) && $this->request->params['named']['main_filter_id'] == ConstAffiliateRequests::Rejected) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Disapproved');?>">
  <?php echo $this->Html->link('<div class="span2 no-mar"> <span class="label label-important show dc space span1"><i class="icon-ban-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Disapproved') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($rejected,false).'</span>', array('controller'=>'affiliate_requests','action'=>'index','main_filter_id' => ConstAffiliateRequests::Rejected), array('class' => 'blackc', 'escape' => false));?>
  </li>
  <?php $class = (empty($this->request->params['named']['main_filter_id'])) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (empty($this->request->params['named']['main_filter_id'])) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('All');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('All') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($all,false).'</span>', array('controller'=>'affiliate_requests','action'=>'index'), array('class' => 'blackc', 'escape' => false));?>
  </li>
</ul>
</div>
</section>
<ul class="nav nav-tabs mspace top-space">
  <li class="active"><a class="blackc" href="#"><i class="icon-th-list blackc"></i><?php echo __l('List'); ?></a></li>
  <li>
  <?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__l('Add'), array('action' => 'add'),array('class' => 'blackc', 'title' =>  __l('Add'), 'escape' => false));?>
  </li>
</ul>
<section class="space clearfix">
  <div class="pull-left hor-space">
  <?php echo $this->element('paging_counter');?>
  </div>
    <div class="pull-right">
    <?php echo $this->Form->create('AffiliateRequest' , array('type' => 'get', 'class' => 'form-search no-mar','action' => 'index')); ?>
    <?php echo $this->Form->input('q', array('label' => false,' placeholder' => __l('Search'), 'class' => 'search-query mob-clr')); ?>
   <div class="hide">
     <?php echo $this->Form->submit(__l('Search'));?>
    </div>
    <?php echo $this->Form->end(); ?>
  </div>
</section>
<?php echo $this->Form->create('AffiliateRequest' , array('action' => 'update', 'class' => 'js-shift-click js-no-pjax')); ?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
<section class="space">
<table class="table table-striped table-bordered table-condensed table-hover no-mar">
<thead>
  <tr>
  <th class="select dc"><?php echo __l('Select');?></th>
  <th class="dc"><?php echo __l('Actions');?></th>
  <th class="dl"><?php echo $this->Paginator->sort('User.username', __l('User'));?></th>
  <th class="dl"><?php echo $this->Paginator->sort('site_name', __l('Site'));?></th>
  <th class="dl"><?php echo $this->Paginator->sort('site_url', __l('Site URL'));?></th>
  <th class="dl"><?php echo $this->Paginator->sort('site_category_id', __l('Site Category'));?></th>
  <th class="dl"><?php echo $this->Paginator->sort('why_do_you_want_affiliate', __l('Why Do You Want An Affiliate?'));?></th>
  <th class="dc"><?php echo $this->Paginator->sort('is_web_site_marketing', __l('Website Marketing?'));?></th>
  <th class="dc"><?php echo $this->Paginator->sort('is_search_engine_marketing', __l('Search Engine Marketing?'));?></th>
  <th class="dc"><?php echo $this->Paginator->sort('is_email_marketing', __l('Email Marketing?'));?></th>
   <th class="dl"><?php echo $this->Paginator->sort('special_promotional_method', __l('Promotional Method'));?></th>
  <th class="dc"><?php echo $this->Paginator->sort('is_approved', __l('Approved?'));?></th>
  </tr>
</thead>
<tbody>
<?php
if (!empty($affiliateRequests)):
$i=0;
foreach ($affiliateRequests as $affiliateRequest):
  if($affiliateRequest['AffiliateRequest']['is_approved']):
  $status_class = 'js-checkbox-active';
  $disabled = '';
  else:
  $status_class = 'js-checkbox-inactive';
  $disabled = 'class="disabled"';
  endif;
?>
  <tr <?php echo $disabled;?>>
  <td class="select dc"><?php echo $this->Form->input('AffiliateRequest.'.$affiliateRequest['AffiliateRequest']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$affiliateRequest['AffiliateRequest']['id'], 'label' => false, 'class' => $status_class.' js-checkbox-list')); ?></td>
  <td class="span1 dc">
    <div class="dropdown top-space">
    <a href="#" title="Actions" data-toggle="dropdown" class="icon-cog blackc text-20 dropdown-toggle js-no-pjax"><span class="hide">Action</span></a>
    <ul class="unstyled dropdown-menu dl arrow clearfix">
     <li>
   <?php echo $this->Html->link('<i class="icon-edit"></i>'.__l('Edit'), array('action'=>'edit', $affiliateRequest['AffiliateRequest']['id']), array('class' => 'js-edit','escape'=>false, 'title' => __l('Edit')));?>
   </li>
   <li>
   <?php echo $this->Html->link('<i class="icon-remove"></i>'.__l('Delete'), Router::url(array('action'=>'delete', $affiliateRequest['AffiliateRequest']['id']),true).'?r='.$this->request->url, array('class' => 'js-confirm', 'escape'=>false,'title' => __l('Delete')));?>
   </li>
   <?php echo $this->Layout->adminRowActions($affiliateRequest['AffiliateRequest']['id']);  ?>
   </ul>
   </div>
  </td>
  <td class="span4">
    <div class="row-fluid">
    <div class="span6"><?php echo $this->Html->getUserAvatarLink($affiliateRequest['User'], 'medium_thumb', true); ?></div>
    <div class="span12 vtop hor-smspace"><?php echo $this->Html->getUserLink($affiliateRequest['User']); ?></div>
    </div>
  </td>
  <td class="dl"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['site_name']);?></td>
  <td class="dl">
    <?php echo $this->Html->link($affiliateRequest['AffiliateRequest']['site_url'], $affiliateRequest['AffiliateRequest']['site_url'], array('target' => '_blank'));?>
  </td>
  <td class="dl"><?php echo $this->Html->cText($affiliateRequest['SiteCategory']['name']);?></td>
  <td class="dl"><div class="htruncate-ml2 js-tooltip" title="<?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate'], false);?>"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['why_do_you_want_affiliate'], false);?></div></td>

  <td class="dc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_web_site_marketing']);?></td>
  <td class="dc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_search_engine_marketing']);?></td>
  <td class="dc"><?php echo $this->Html->cBool($affiliateRequest['AffiliateRequest']['is_email_marketing']);?></td>
  <td class="dl"><?php echo $this->Html->cText($affiliateRequest['AffiliateRequest']['special_promotional_method'],false);?></td>
  <td class="dc">
     <span>
    <?php if($affiliateRequest['AffiliateRequest']['is_approved'] == 0){
      echo __l('Waiting for Approval');
      } else if($affiliateRequest['AffiliateRequest']['is_approved'] == 1){
      echo __l('Approved');
      } else if($affiliateRequest['AffiliateRequest']['is_approved'] == 2){
      echo __l('Disapproved');
      }
    ?>
    </span>
  </td>
  </tr>
<?php
  endforeach;
else:
?>
  <tr>
  <td colspan="16" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo __l('No Affiliate Requests available');?></td>
  </tr>
<?php
endif;
?>
</tbody>
</table>
</section>
<section class="clearfix hor-mspace bot-space">
<?php
if (!empty($affiliateRequests)) :
  ?>
<div class="admin-select-block pull-left">
    <?php echo __l('Select:'); ?>
    <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-list"}','title' => __l('All'))); ?>
    <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-select js-no-pjax {"unchecked":"js-checkbox-list"}','title' => __l('None'))); ?>
    <?php echo $this->Html->link(__l('Disapprove'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-inactive","unchecked":"js-checkbox-active"}', 'title' => __l('Disapprove'))); ?>
    <?php echo $this->Html->link(__l('Approve'), '#', array('class' => 'js-select js-no-pjax {"checked":"js-checkbox-active","unchecked":"js-checkbox-inactive"}', 'title' => __l('Approve'))); ?>
</div>
<div class="admin-checkbox-button pull-left hor-space">
<div class="input select">
      <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
    </div>
    </div>
  <div class="hide">
    <?php echo $this->Form->submit('Submit');  ?>
  </div>
<div class="pull-right"><?php echo $this->element('paging_links'); ?></div>
</section>
<?php
endif;
echo $this->Form->end();
?>
</div>
