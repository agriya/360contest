<?php /* SVN: $Id: $ */ ?>
<div class="top-pattern sep-bot">
  <div class="container space">
	<ul class="row no-mar mob-c unstyled space">
		<li class="span dc no-mar offset2 span5"><div class="span no-mar"> <span class="label label-inverse span1 dc space no-mar text-24">1</span></div><span class="text-24 textb grayc span dc space no-mar text-24"> Step1</span> </li>
		</li>
	
		<li class="span dc no-mar span5"><div class="span no-mar"> <span class="label label-inverse span1 dc space no-mar text-24">2</span></div><span class="text-24 textb grayc span dc space no-mar text-24 "> Step2</span> </li>
		</li>
		<li class="span dc no-mar span5"><div class="span no-mar"> <span class="label label-important span1 dc space no-mar text-24">3</span></div><span class="text-24 textb blackc span dc space no-mar text-24"> Step3</span> </li>
		</li>
	<ul>
</div>
 </div>
		<div class="contestTypes index">
					<div class="stage-inner-block">
						<h2 class="ver-mspace ver-space"><?php echo __l('Payment');?></h2>
						<div class="thumbnail sep space">
						<div class=" space">
						<?php echo $this->Form->create('Contest', array('action' => 'prizing_selection', 'class' => 'normal clearfix prizing-form js-submit-target payment-form'));?>
						<?php
								echo $this->Form->input('id');
							?>

							<div class="clearfix">
								<h3 class="textn"><?php echo sprintf(__l('Create a contest that attracts the right %s to your brief.'), Configure::read('contest.participant_alt_name_plural_caps'));?></h3>
								<span class="ver-space bot-space "><?php echo __l('We\'ve got the largest design community online so it\'s important to create a contest that attracts the kinds of designers you want to work on your brief.');?></span>
								<h3 class="top-space textn top-mspace"><?php echo __l('What contest package do you want?');?></h3>
								<span class="ver-space bot-space "><?php echo __l('All packages come with a 100% money-back guarantee and you own full copyright to the final work.');?></span>
							</div>
							<div class="span ver-space">
<?php foreach($contestType['PricingPackage'] as $contestTypePricingPackage): ?>
<?php
$options = array($contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id'] => $this->Html->cText($contestTypePricingPackage['name'], false). ' - '.$this->Html->siteCurrencyFormat($contestTypePricingPackage['ContestTypesPricingPackage']['price']));?>
							
							
								<div class="span10 pull-left no-mar">
									<div class="clearfix">
										<label  class="textb" for="ContestPricingPackageId<?php echo $contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id']; ?>">
											<?php echo $this->Form->input('Contest.pricing_package_id', array('id' => 'ContestPricingPackageId', 'type'=>'radio', 'options' => $options ,'div'=>false, 'label' => false, 'legend' => false, 'value' => $contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id'],'class'=>"js-prize-package {'prize':'" . $contestTypePricingPackage['ContestTypesPricingPackage']['price'] . "'}"));?>

										</label>
									</div>
									<div class="payment-description">
										<?php echo $this->Html->cText($contestTypePricingPackage['description']); ?>
										<?php echo $contestTypePricingPackage['features']; ?>

									</div>
								</div>
	<?php endforeach; ?>
								<div class="span11 no-mar">
									<div class="clearfix">
										<label  class="textb" for="ContestPricingPackageId0">
	<?php $options = array('0' =>'Name your prize');?>

										<?php echo $this->Form->input('Contest.pricing_package_id', array('id' => 'ContestPricingPackageId', 'type'=>'radio', 'options' => $options, 'label' => false, 'legend' => false, 'value' => 0,'class'=>'js-name-prize hor-space'));?>

										</label>
										</div>
										<div class="clearfix">
										<div class="span10 offset1">
											<?php if(Configure::read('site.currency_symbol_place') == 'left'):
												$currecncy_place = 'before';
											else:
												$currecncy_place = 'after';
											endif;
											$contest_prize = $contestType['ContestType']['minimum_prize'];
											if(!empty($this->request->data['Contest']['prize'])){
												$contest_prize = $this->request->data['Contest']['prize'];
											}?>
										 <div class="input-prepend">
											  <span class="add-on pull-left"><?php echo Configure::read('site.currency');?></span>
											  <?php echo $this->Form->input('Contest.prize', array('label' => false,'type'=>'text','id'=>'ContestPrize' , 'value' => $contest_prize));?>
											  <span class="info no-mar">
											  <span><icon class="icon-info-sign"></i> </span><?php echo __l('Prize should not be less than'.' '.$this->Html->siteCurrencyFormat($contestType['ContestType']['minimum_prize'])); ?>
											  </span>
										</div>
										 <?php
										 echo $this->Form->input('total_with_out_days', array('value'=>$contestType['ContestType']['minimum_prize'],'type' => 'hidden','readonly'=>'readonly'));
										 ?>

									</div>
									</div>
									</div>
								</div>
								<div class="clearfix"></div>
						<?php if(count($contestType['PricingDay']) > 0) { ?>		
							<div class="clearfix ver-space">
								<h3 class="textn"><?php echo __l('How quickly do you need to complete your contest?');?></h3>
								<div class="clearfix">
								<div class="span24 ver-space row-fluid">
<?php 
$pricing_day_count = count($contestType['PricingDay']);
$i=1;
foreach($contestType['PricingDay'] as $key=>$contestTypePricingDay): ?>
<div class="pull-left">
									<label  class="textb" for="ContestPricingDayId<?php echo $contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id']; ?>">
									<?php
										$day_label = ($contestTypePricingDay['no_of_days'] >1)?__l('days'): __l('day');
										if($contestTypePricingDay['ContestTypesPricingDay']['price'] > 0){
											$label = sprintf('%s %s %s (%s)',__l('In'), $contestTypePricingDay['no_of_days'], $day_label, $this->Html->siteCurrencyFormat($contestTypePricingDay['ContestTypesPricingDay']['price'], false));
										} else{
											$label = sprintf('%s %s %s (%s)',__l('Standard'), $contestTypePricingDay['no_of_days'],  $day_label, __l('FREE'));
										}
										$options = array($contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'] => $label);
										$prize=$contestTypePricingDay['ContestTypesPricingDay']['price'];
										echo $this->Form->input('Contest.pricing_day_id', array('id' => 'ContestPricingDayId', 'type'=>'radio', 'options' => $options ,'div'=>false, 'label' => false, 'legend' => false, 'value' => $contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'],'class' => "js-pricing-day {'price' : '" .  $prize . "'}"));
										if($i==$pricing_day_count){
											echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestTypePricingDay['ContestTypesPricingDay']['price'],'readonly'=>'readonly'));
										}
										$i++;
										 ?>

									</label></div>
<?php endforeach; ?> </div>
								</div>
							</div>
							<?php } ?>
							<div class="payment-information  ver-mspace">
<?php if((!empty($contestType['ContestType']['is_blind']) && Configure::read('contest.is_enable_blind_fee') && Configure::read('contest.is_contest_holder_can_choose_blind_fee')) || !empty($contestType['ContestType']['is_highlight']) ||  (!empty($contestType['ContestType']['is_private']) && Configure::read('contest.is_enable_private_fee') && Configure::read('contest.is_contest_holder_can_choose_private_fee')) || (!empty($contestType['ContestType']['is_featured']) && Configure::read('contest.is_enable_featured_fee') && Configure::read('contest.is_contest_holder_can_choose_featured_fee'))) {?>
								<h3 class="textn bot-space"><?php echo __l('Additional contest features');?></h3>
<?php } ?>
								<div class="hor-mspace hor-space prizing-features clearfix">
<?php if(!empty($contestType['ContestType']['is_blind']) && Configure::read('contest.is_enable_blind_fee') && Configure::read('contest.is_contest_holder_can_choose_blind_fee')) {?>
									<div class="clearfix">
										<?php echo $this->Form->input('Contest.blind_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'BlindFee','amount':'" . $contestType['ContestType']['blind_fee'] . "'}", 'label' => $this->Html->cText(__l('Blind Contest'). ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['blind_fee'], false) . ')', false),'info' => '<span><icon class="icon-info-sign"></i> </span>'.sprintf(__l('The participants who posted entries in your contest could see just their entries and can\'t see entries posted by other participants. This increase Creativity and competition between participants.'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small')))); ?>

									</div>
<?php } ?>
<?php if(!empty($contestType['ContestType']['is_private']) && Configure::read('contest.is_enable_private_fee') && Configure::read('contest.is_contest_holder_can_choose_private_fee')){?>
									<div class="clearfix">
										<?php echo $this->Form->input('Contest.private_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'PrivateFee','amount':'" . $contestType['ContestType']['private_fee'] . "'}", 'label' => $this->Html->cText(__l('Private Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['private_fee'], false) . ')', false), 'info' => '<span><icon class="icon-info-sign"></i> </span>'.sprintf(__l('Your contest will be presented just to registered and logged in %s (designers).'), Configure::read('contest.participant_alt_name_plural_small')))); ?>

									</div>
<?php } ?>
<?php if(!empty($contestType['ContestType']['is_featured']) && Configure::read('contest.is_enable_featured_fee') && Configure::read('contest.is_contest_holder_can_choose_featured_fee')){?>
									<div class="clearfix">
										<?php echo $this->Form->input('Contest.featured_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'FeaturedFee','amount':'" . $contestType['ContestType']['featured_fee'] ."'}", 'label' => $this->Html->cText(__l('Featured Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['featured_fee'], false) . ')', false), 'info' => '<span><icon class="icon-info-sign"></i> </span>'.__l('Your contest will be presented on the contest list before other contest which are not Featured.'))); ?>

									</div>
									<?php } ?>
  									<?php if(!empty($contestType['ContestType']['is_highlight']) && Configure::read('contest.is_enable_highlight_fee') && Configure::read('contest.is_contest_holder_can_choose_highlight_fee')){?>
										<div class="clearfix">
										<?php echo $this->Form->input('Contest.highlight_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'HighlightFee','amount':'" . $contestType['ContestType']['highlight_fee'] . "'}", 'label' => $this->Html->cText(__l('Highlight Contest'). ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['highlight_fee'], false) . ')', false),'info' => '<span><icon class="icon-info-sign"></i> </span>'.sprintf(__l('Make Your contest visually stand out form the rest by highlighting your listing.'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small')))); ?>
		
										</div>
  								<?php } ?>
  								<?php
									echo $this->Form->input('other_fee', array('type' => 'hidden','readonly'=>'readonly'));
									if(!empty($contestType['PricingDay'][0]['ContestTypesPricingDay'])){
										echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestType['PricingDay'][0]['ContestTypesPricingDay']['price'],'readonly'=>'readonly'));
									}
								?>

								</div>
							</div>
							<div class="clearfix">
									<h3 class="ver-space ver-mspace textn"><?php echo __l('Total Costs: ');?><span class="pinkc"><?php echo Configure::read('site.currency');?></span><span class="js-total-prize pinkc"></span></h3>
								
							</div>
							
							<div class="clearfix">								
<?php 	$currency_code = Configure::read('site.currency_id');?>
											<?php
				if (isset($this->request->data['Contest']['wallet']) && $this->request->data['Contest']['payment_gateway_id'] == ConstPaymentGateways::SudoPay && !empty($sudopay_gateway_settings) && $sudopay_gateway_settings['is_payment_via_api'] == ConstBrandType::VisibleBranding) {
						echo $this->element('sudopay_button', array('data' => $sudopay_data, 'cache' => array('config' => 'sec')), array('plugin' => 'Sudopay'));
				} else{
				 ?>
								<fieldset class="form-block">
	  <legend><?php echo __l('Select Payment Type');?></legend>
								<?php  echo $this->element('payment-get_gateways', array('model'=>'Contest','type'=>'is_enable_for_contest_listing','is_enable_wallet'=>1, 'cache' => array('config' => 'sec')));?>
								</fieldset>
								<?php } ?>
								<div class="ver-space">
								<?php 
								$datediff = floor((time() - strtotime($contest['Contest']['created']))/(60*60*24));
								if(Configure::read('contest.contest_payment_pending_days_limit') > $datediff){
									$payment_pending_days = Configure::read('contest.contest_payment_pending_days_limit') - $datediff ;
								}
								?>
								</div>
							</div>
							<?php echo $this->Form->end();?>				   
							</div>
						</div>
					</div></div>