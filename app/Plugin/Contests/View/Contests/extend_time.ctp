<?php /* SVN: $Id: $ */ ?>
<?php echo $this->element('contest_view_header', array('contest' => $contest, 'page' => __l('Extend Time'), 'cache' => array('config' => 'sec')));?>
<div class="contests form top-space">
  <div class="stage-inner-block">
    <?php echo $this->Form->create('Contest', array('action' => 'extend_time', 'class' => 'normal clearfix prizing-form js-submit-target payment-form'));?>
    <?php
			echo $this->Form->input('id');
		?>
    <div class="payment-information payment-information1">
      <h3><?php echo __l('How quickly do you need to complete your contest?');?></h3>
      <div class="prizing-package">
	    <div class="span24 ver-space row-fluid">
        <?php 
			$pricing_day_count = count($contestType['PricingDay']);
			$i=1;
			foreach($contestType['PricingDay'] as $key=>$contestTypePricingDay): ?>
			<div class="pull-left">			
				<label  for="ContestPricingDayId<?php echo $contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id']; ?>">
			<?php
			$day_label = ($contestTypePricingDay['no_of_days'] >1)?__l('days'): __l('day');
			if($contestTypePricingDay['ContestTypesPricingDay']['price'] > 0){
				$label = sprintf('%s %s %s (%s)',__l('In'), $contestTypePricingDay['no_of_days'], $day_label, $this->Html->siteCurrencyFormat($contestTypePricingDay['ContestTypesPricingDay']['price'], false));
			} else{
				$label = sprintf('%s %s %s (%s)',__l('Standard'), $contestTypePricingDay['no_of_days'],  $day_label, __l('FREE'));
			}
			$options = array($contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'] => $label);
			$prize=$contestTypePricingDay['ContestTypesPricingDay']['price'];
			echo $this->Form->input('Contest.pricing_day_id', array('id' => 'ContestPricingDayId', 'type'=>'radio', 'options' => $options ,'div'=>false, 'label' => false, 'legend' => false, 'value' => $contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'],'class' => "js-pricing-day-extend {'price' : '" .  $prize . "'}"));
			if($i==$pricing_day_count){
				echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestTypePricingDay['ContestTypesPricingDay']['price'],'readonly'=>'readonly'));
			}
			$i++;
		?>
        </label>
		</div>
        <?php endforeach; ?>
		<?php
		if(!empty($contestType['PricingDay'][0]['ContestTypesPricingDay'])){
			echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestType['PricingDay'][0]['ContestTypesPricingDay']['price'],'readonly'=>'readonly'));
		}
		?>
		</div>
      </div>
    </div>
	<div class="payments contest fee clearfix">
		<h3 class="ver-space ver-mspace textn"><?php echo __l('Total Costs:') . ' ' ;?> <span class="pinkc"><?php echo Configure::read('site.currency');?></span><span class="js-total-prize pinkc"></span></h3>
	</div>
    <div class="payment-information js-extendtime-payment-block hide">
      <?php 	$currency_code = Configure::read('site.currency_id');?>
      <fieldset class="form-block">
	  <legend><?php echo __l('Select Payment Type');?></legend>
      <?php  echo $this->element('payment-get_gateways', array('model'=>'Contest','type'=>'is_enable_for_contest_listing','is_enable_wallet'=>1, 'cache' => array('config' => 'sec')));?>
	  </fieldset>
    </div>
	<div class="payment-information js-extendtime-normal-block hide">
      <?php echo $this->Form->submit(__l('Submit'), array('class' => 'js-no-pjax btn btn-module', 'div' => false)); ?>
    </div>
    <?php echo $this->Form->end();?> </div>
</div>