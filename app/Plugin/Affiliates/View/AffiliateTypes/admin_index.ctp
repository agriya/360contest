<?php /* SVN: $Id: $ */ ?>
<div class="affiliateTypes index">
<h2><?php echo __l('Affiliate Types');?></h2>
<section>
  <div class="pull-left hor-space"><?php echo $this->element('paging_counter');?></div>
<section>
<table class="table table-striped table-bordered table-condensed table-hover no-mar">
  <tr>
    <th><?php echo __l('Actions');?></th>
    <th><?php echo $this->Paginator->sort('name', __l('Name'));?></th>
    <th><?php echo $this->Paginator->sort('commission', __l('Commission'));?></th>
    <th><?php echo __l('Commission Type');?></th>
    <th><?php echo $this->Paginator->sort('is_active', __l('Active?'));?></th>
  </tr>
<?php
if (!empty($affiliateTypes)):

$i = 0;
foreach ($affiliateTypes as $affiliateType):
  if ($i++ % 2 == 0) {
  if($affiliateType['AffiliateType']['is_active']):
    $status_class = 'js-checkbox-active';
  else:
    $status_class = 'js-checkbox-inactive';
  endif;
  }
?>
  <tr>
    <td class="dl"><span><?php echo $this->Html->link(__l('Edit'), array('action' => 'edit', $affiliateType['AffiliateType']['id']), array('class' => 'js-edit', 'title' => __l('Edit')));?></span></td>
    <td><?php echo $this->Html->cText($affiliateType['AffiliateType']['name']);?></td>
    <td><?php echo $this->Html->siteCurrencyFormat($affiliateType['AffiliateType']['commission']);?></td>
    <td><?php echo $this->Html->cText( $affiliateType['AffiliateCommissionType']['description'] . ' ('.$affiliateType['AffiliateCommissionType']['name'].')');?></td>
    <td><?php echo $this->Html->cBool($affiliateType['AffiliateType']['is_active']);?></td>
  </tr>
<?php
  endforeach;
else:
?>
  <tr>
    <td colspan="5" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('Affiliate Types'));?></td>
  </tr>
<?php
endif;
?>
</table>

</div>