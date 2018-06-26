<?php /* SVN: $Id: $ */ ?>
<?php echo $this->element('contest_view_header', array('contest' => $contest, 'page' => __l('Upgrade Features'), 'cache' => array('config' => 'sec')));?>
<div class="contests form top-space">
  <div class="stage-inner-block">
    <?php echo $this->Form->create('Contest', array('action' => 'upgrade_features', 'class' => 'normal clearfix prizing-form js-submit-target payment-form'));?>
    <?php
		echo $this->Form->input('id');
	?>
    <div class="payment-information payment-information1">
      <?php if(!empty($contestType['ContestType']['is_blind']) || !empty($contestType['ContestType']['is_private']) || !empty($contestType['ContestType']['is_featured']) || !empty($contestType['ContestType']['is_highlight'])) {?>
      <h3><?php echo __l('Additional contest features');?></h3>
      <?php } ?>
      <div class="prizing-package prizing-package2 clearfix">
        <?php if(!empty($contestType['ContestType']['is_blind']) && Configure::read('contest.is_enable_blind_fee') && Configure::read('contest.is_contest_holder_can_choose_blind_fee') && empty($contest['Contest']['is_blind'])){?>
        <div class="clearfix"> <?php echo $this->Form->input('Contest.blind_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'BlindFee','amount':'" . $contestType['ContestType']['blind_fee'] . "'}", 'label' => $this->Html->cText(__l('Blind Contest'). ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['blind_fee'], false) . ')', false),'info' => sprintf(__l('The participants who posted entries in your contest could see just their entries and can\'t see entries posted by other participants. This increase Creativity and competition between participants.'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small')))); ?> </div>
        <?php } ?>
        <?php if(!empty($contestType['ContestType']['is_private']) && Configure::read('contest.is_enable_private_fee') && Configure::read('contest.is_contest_holder_can_choose_private_fee') && empty($contest['Contest']['is_private'])){?>
        <div class="clearfix"> <?php echo $this->Form->input('Contest.private_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'PrivateFee','amount':'" . $contestType['ContestType']['private_fee'] . "'}", 'label' => $this->Html->cText(__l('Private Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['private_fee'], false) . ')', false), 'info' => sprintf(__l('Your contest will be presented just to registered and logged in %s (designers).'), Configure::read('contest.participant_alt_name_plural_small')))); ?> </div>
        <?php } ?>
        <?php if(!empty($contestType['ContestType']['is_featured']) && Configure::read('contest.is_enable_featured_fee') && Configure::read('contest.is_contest_holder_can_choose_featured_fee') && empty($contest['Contest']['is_featured'])){?>
        <div class="clearfix"> <?php echo $this->Form->input('Contest.featured_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'FeaturedFee','amount':'" . $contestType['ContestType']['featured_fee'] ."'}", 'label' => $this->Html->cText(__l('Featured Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['featured_fee'], false) . ')', false), 'info' => __l('Your contest will be presented on the contest list before other contest which are not Featured.'))); ?> </div>
        <?php } ?>
		<?php if(!empty($contestType['ContestType']['is_highlight']) && Configure::read('contest.is_enable_highlight_fee') && Configure::read('contest.is_contest_holder_can_choose_highlight_fee') && empty($contest['Contest']['is_highlight'])){?>
        <div class="clearfix"> <?php echo $this->Form->input('Contest.highlight_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'HighlightFee','amount':'" . $contestType['ContestType']['highlight_fee'] ."'}", 'label' => $this->Html->cText(__l('Highlight Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['highlight_fee'], false) . ')', false), 'info' => __l('Make Your contest visually stand out form the rest by highlighting your listing.'))); ?> </div>
        <?php } ?>
		<?php
		echo $this->Form->input('other_fee', array('type' => 'hidden','readonly'=>'readonly'));
		if(!empty($contestType['PricingDay'][0]['ContestTypesPricingDay'])){
			echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestType['PricingDay'][0]['ContestTypesPricingDay']['price'],'readonly'=>'readonly'));
		}	
		?>
      </div>
    </div>
	<div class="payments contest fee clearfix">
		<h3 class="ver-space ver-mspace textn"><?php echo __l('Total Costs:') . ' ' ;?> <span class="pinkc"><?php echo Configure::read('site.currency');?></span><span class="js-total-prize pinkc"></span></h3>
	</div>
    <div class="payment-information">
      <?php 	$currency_code = Configure::read('site.currency_id');?>
      <fieldset class="form-block">
	  <legend><?php echo __l('Select Payment Type');?></legend>
      <?php  echo $this->element('payment-get_gateways', array('model'=>'Contest','type'=>'is_enable_for_contest_listing','is_enable_wallet'=>1, 'cache' => array('config' => 'sec')));?>
	  </fieldset>
    </div>
    <?php echo $this->Form->end();?> </div>
</div>
