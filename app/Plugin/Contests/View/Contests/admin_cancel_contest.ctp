<?php /* SVN: $Id: $ */ 
$refund_amount_detail = '';
if(!empty($contest['ContestType']['PricingDay'])){
	$pricing_day_amount = 0;
	foreach($contest['ContestType']['PricingDay'] as $pricing_day){
		if($contest['Contest']['pricing_day_id'] ==  $pricing_day['id']){
			if(!empty($pricing_day['ContestTypesPricingDay'])){
				$pricing_day_amount = $pricing_day['ContestTypesPricingDay']['price'];
			}else{
				$pricing_day_amount = $pricing_day['global_price'];
			}
		}
	}
	$refund_amount_detail.= $this->Html->siteCurrencyFormat($pricing_day_amount) . '  (' . $contest['ContestType']['PricingDay'][0]['no_of_days'] . 'days)';
}
$plus_symbol ='';
if(!empty($refund_amount_detail)){
	$plus_symbol ='+';
}
if(!empty($contest['Contest']['is_blind'])){
	$refund_amount_detail.= ' ' .$plus_symbol . ' ' . $this->Html->siteCurrencyFormat($contest['ContestType']['blind_fee']) . '  '  . '(Blind)';
}
if(!empty($contest['Contest']['is_private'])){
	$refund_amount_detail.= ' ' .$plus_symbol . ' ' . $this->Html->siteCurrencyFormat($contest['ContestType']['private_fee']) . '  '  . '(Private)';
}
if(!empty($contest['Contest']['is_featured'])){
	$refund_amount_detail.= ' ' .$plus_symbol . ' ' . $this->Html->siteCurrencyFormat($contest['ContestType']['featured_fee']) . '  '  . '(Featured)';
}
if(!empty($contest['Contest']['is_highlight'])){
  	$refund_amount_detail.= ' ' .$plus_symbol . ' ' . $this->Html->siteCurrencyFormat($contest['ContestType']['highlight_fee']) . ' ' . '(Highlight)';
}
?>
<div class="thumbnail space contests form">
<div class="offset1">
<div class="alert alert-info"><?php echo __l('Note: Initial Site Fee won\'t be refunded. Prize amount will be refunded to your wallet.') ?></div>
<div class="alert alert-info"><?php echo __l('Info: The site fee details get differ if we change the fee details in admin side after the contest add.') ?></div>
<div class="clearfix">
<dl class="sep-bot span12 hor-space hor-smspace">
	<dt class="pull-left textb span7"><?php echo __l('Amount Paid');?></dt><dd><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['creation_cost']) . __l(' (Prize + Site Fee)');?></dd>
	<dt class="pull-left textb span7 ver-space"><?php echo __l('Site Fee');?></dt><dd class="ver-space"><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['creation_cost'] - $contest['Contest']['prize']) . ' (' . $refund_amount_detail . ')' ;?></dd>
</dl>
</div>
<div class="clearfix">
<dl class="span12 space smspace">
	<dt class="pull-left textb span7"><?php echo __l('Refundable Amount');?></dt><dd class="pinkc textb"><?php echo $this->Html->siteCurrencyFormat($contest['Contest']['prize']);?></dd>
</dl>
</div>
<div class="clearfix space">
        <?php echo $this->Html->link(__l('Submit'), array('action' => 'update_status', $contest['Contest']['id'],ConstContestStatus::CanceledByAdmin), array('class' => 'js-confirm js-no-pjax btn btn-success hor-mspace', 'title' => __l('Submit'))); ?>
		<?php echo $this->Html->link(__l('Cancel'), array('action' => 'index', 'filter_id'=>ConstContestStatus::Open), array('class' => 'btn js-confirm js-no-pjax hor-mspace', 'title' => __l('Cancel'))); ?>
</div>
</div>
</div>