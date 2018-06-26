<?php /* SVN: $Id: $ */ ?>
<div class="affiliates index space">
  <div class="pull-right space">
    <?php echo $this->Html->link('<i class="icon-cog text-16"></i> '.__l('Affiliate  Requests'), array('controller' => 'affiliate_requests', 'action' => 'index'), array('class' => 'blackc','escape'=>false, 'title' => __l('Affiliate  Requests')));?>
	<?php if(isPluginEnabled('Withdrawals')) : ?>
    <?php echo $this->Html->link('<i class="icon-briefcase text-16"></i> '.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'), array('class' => 'blackc','escape'=>false, 'title' => __l('Affiliate Cash Withdrawal Requests')));?>
	<?php endif; ?>
    <?php echo $this->Html->link('<i class="icon-certificate text-16"></i> '.__l('Settings'), array('controller' => 'settings', 'action' => 'edit', 79), array('class' => 'blackc','escape'=>false, 'title' => __l('Settings')));?>
  </div>
  <?php echo $this->element('admin_affiliate_stat', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')), 'plugin' => 'Affiliates')); ?>
<h2><?php echo __l('Commission History');?></h2>
<section class="page-header no-mar ver-space">
<div class="top-pattern-contest  container-fluid space">
<ul class="row no-mar mob-c unstyled top-mspace">
  <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Pending) ? 'pinkc' : 'grayc'; ?>
  <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Pending) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Pending');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-off no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Pending') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pending,false).'</span>' , array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Pending), array('class' => 'blackc', 'escape' => false));?>
   </li>
   <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Canceled) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Canceled) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Canceled');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-ban-circle no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Canceled') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($canceled,false).'</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Canceled), array('class' => 'blackc', 'escape' => false));?>
   </li>
   <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::PipeLine) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::PipeLine) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Pipeline');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-reorder no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Pipeline') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($pipeline,false).'</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::PipeLine), array('class' => 'blackc', 'escape' => false));?>
   </li>
   <?php $class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Completed) ? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (!empty($this->request->params['named']['filter_id']) && $this->request->params['named']['filter_id'] == ConstAffiliateStatus::Completed) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('Completed');?>">
  <?php echo $this->Html->link('<div class="span2"> <span class="label label-important show dc space span1"><i class=" icon-thumbs-up no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('Completed') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($completed,false).'</span>', array('controller'=>'affiliates','action'=>'index','filter_id' => ConstAffiliateStatus::Completed), array('class' => 'blackc', 'escape' => false));?>
   </li>
   <?php $class = (empty($this->request->params['named']['filter_id']))? 'pinkc' : 'grayc'; ?>
   <?php $count_class = (empty($this->request->params['named']['filter_id'])) ? 'pinkc' : 'blackc'; ?>
  <li class="span dc no-mar" title="<?php echo __l('All');?>">
  <?php echo $this->Html->link('<div class="span"> <span class="label label-important show dc space no-mar"><i class="icon-sitemap no-pad text-24 whitec"></i></span><span class="show  '.$class.' ">' . __l('All') . '</span></div><span class="'.$count_class.' no-mar text-32 textb space span ">'.$this->Html->cInt($all,false).'</span>', array('controller'=>'affiliates','action'=>'index'), array('class' => 'blackc', 'escape' => false));?>
  </li>
</ul>
</div>
</section>
<section>
  <div class="pull-left hor-space"><?php echo $this->element('paging_counter');?></div>
</section>
<table class="table table-striped table-bordered table-condensed no-mar">
<thead>
  <tr>
    <th class="dc"><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
    <th class="dl"><?php echo $this->Paginator->sort('AffiliateUser.username', __l('Affiliate User'));?></th>
    <th class="dl"><?php echo $this->Paginator->sort('AffiliateType.name', __l('Type'));?></th>
    <th class="dl"><?php echo $this->Paginator->sort('AffiliateStatus.name', __l('Status'));?></th>
    <th class="dr"><?php echo $this->Paginator->sort('commission_amount', __l('Commission').' ('.Configure::read('site.currency').')');?></th>
  </tr>
  </thead>
  <tbody>
<?php
if (!empty($affiliates)):
foreach ($affiliates as $affiliate):
?>
  <tr>
    <td class="dc"> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
    <td class="dl"><?php echo $this->Html->link($this->Html->cText($affiliate['AffiliateUser']['username']), array('controller'=> 'users', 'action'=>'view', $affiliate['AffiliateUser']['username'], 'admin' => false), array('escape' => false));?></td>

    <td class="dl"> <?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?> </td>

    <td class="dl">
       <span>
       <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']);   ?>
       <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
           <?php echo '['.__l('Since').': '.$this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']). ']';?>
       <?php endif; ?>
      </span>
    </td>
    <td class="dr"><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
  </tr>
<?php
  endforeach;
else:
?>
  <tr>
    <td colspan="11" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Commission History'));?></td>
  </tr>
<?php
endif;
?>
</tbody>
</table>
<div class="clearfix">
<div class="pull-right bot-mspace ver-space">
<?php
if (!empty($affiliates)) {
  echo $this->element('paging_links');
}
?>
</div>
</div>
</div>