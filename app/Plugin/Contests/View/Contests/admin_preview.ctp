<?php /* SVN: $Id: $ */ ?>
<div class="contests form thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Contest'), array('action' => 'index'),array('title' => __l('Contest')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Preview %s'), __l('Contest'));?></li>
    </ul>

	<ul class="nav nav-tabs">
        <li class="step1">
				<?php echo $this->Html->link('Overview', array('admin' => true, 'controller' => 'contest_types', 'action' => 'edit', $contestTypes['ContestType']['id'],'type' => 'overview'));?>
		</li>
		<li class="step2">
				<?php echo $this->Html->link('Form Fields', array('admin' => true, 'controller' => 'contest_types', 'action' => 'edit', $contestTypes['ContestType']['id'],'type' => 'form_fields'));?>
		</li>
		<?php if(empty($contestTypes['ContestType']['is_template'])) {?>
        <li class="step3">
				<?php echo $this->Html->link('Pricing', array('admin' => true, 'controller' => 'contest_types', 'action' => 'pricing', $contestTypes['ContestType']['id']));?>
		</li>
        <li class="active">
		<?php } else { ?>
		<li class="<?php if(!empty($contestTypes['ContestType']['is_template'])) {?>template-<?php }?>active">
		<?php }?>
		<a href="#"><?php echo __l('Preview');?></a></li>
    </ul>
	<div class="form-block1">
		<legend><h3><?php echo __l('Form Fields');?></h3></legend>
			<?php echo $this->Form->create('Contest', array('class' => 'form-horizontal contest-form form-large-fields'));?>

				<?php 
		foreach($FormFieldGroups as $FormFieldGroup) { 
	?>
			<div class="ver-space">
				<div class="space">
					<h4 class="ver-space bot-mspace sep-bot"><?php echo $FormFieldGroup['FormFieldGroup']['name']; ?></h4>
				<?php if (!empty($FormFieldGroup['FormFieldGroup']['info'])) { ?>
					<div class="alert alert-info clearfix">
						<?php echo $FormFieldGroup['FormFieldGroup']['info'];?>
					</div>
				<?php } ?>
	<?php
			echo $this->Cakeform->insert($FormFieldGroup);
	?>
			</div>
		</div>
	<?php
		}					
	?>
		<legend><h3><?php echo __l('Pricing');?></h3></legend>
		 <div class="alert alert-info">
    		<h4><?php echo sprintf(__l('Create a contest that attracts the right %s to your brief.'), Configure::read('contest.participant_alt_name_plural_caps'));?></h4>
    		<p><?php echo __l('We\'ve got the largest design community online so it\'s important to create a contest that attracts the kinds of designers you want to work on your brief.');?></p> </div>
    		<h4><?php echo __l('What contest package do you want?');?></h4>
    		<div class="alert alert-info"><?php echo __l('All packages come with a 100% money-back guarantee and you own full copyright to the final work.');?></div>
       <div class="span row-fluid">
	       		<?php foreach($contestType['PricingPackage'] as $contestTypePricingPackage): ?>

       <?php
    				$options = array($contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id'] => $this->Html->cText($contestTypePricingPackage['name'], false). ' - '.$this->Html->siteCurrencyFormat($contestTypePricingPackage['ContestTypesPricingPackage']['price']));?>
    				<div class="prizing-package radio no-mar hor-space span10">
    				<label  for="ContestPricingPackageId<?php echo $contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id']; ?>">
    				    <?php echo $this->Form->input('Contest.pricing_package_id', array('id' => 'ContestPricingPackageId', 'type'=>'radio', 'options' => $options ,'div'=>false, 'label' => false, 'legend' => false, 'value' => $contestTypePricingPackage['ContestTypesPricingPackage']['pricing_package_id'],'class'=>"js-prize-package {'prize':'" . $contestTypePricingPackage['ContestTypesPricingPackage']['price'] . "'}"));?>
                    </label>  <span class="help"> <?php echo $contestTypePricingPackage['description']; ?></span>
                    	<?php echo $contestTypePricingPackage['features']; ?>
                	</div>
                     
    		
    		<?php endforeach; ?>
			</div>
			<div class="clearfix"></div>
		    	<div class="payment-information payment-information1">
				<h4><?php echo __l('How quickly do you need to complete your contest?');?></h4>
    			<div class="prizing-package radio no-mar bot-space top-mspace">
    		<?php foreach($contestType['PricingDay'] as $key=>$contestTypePricingDay): ?>
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
    				echo $this->Form->input('Contest.pricing_day_id', array('id' => 'ContestPricingDayId', 'type'=>'radio', 'options' => $options ,'div'=>false, 'label' => false, 'legend' => false, 'value' => $contestTypePricingDay['ContestTypesPricingDay']['pricing_day_id'],'class' => "js-pricing-day {'price' : '" .  $prize . "'}"));
    				 ?>
    			</label>
    		<?php endforeach; 
				if(!empty($contestType['PricingDay'][0]['ContestTypesPricingDay'])){
					echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestType['PricingDay'][0]['ContestTypesPricingDay']['price']));
				}
			?>
    		</div>
    	</div>
		<div class="clearfix"></div>
    	<div class="payment-information payment-information1 top-space">
			<?php if(!empty($contestType['ContestType']['is_blind']) || !empty($contestType['ContestType']['is_private']) || !empty($contestType['ContestType']['is_featured'])) {?>
    		<h4><?php echo __l('Additional contest features');?></h4>
			<?php } ?>
    			<div class="prizing-package prizing-package2 admin-prizing space clearfix">
				<?php if(!empty($contestType['ContestType']['is_blind'])){?>
					<div class="clearfix">
					<?php echo $this->Form->input('Contest.blind_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'BlindFee','amount':'" . $contestType['ContestType']['blind_fee'] . "'}", 'label' => $this->Html->cText(__l('Blind Contest'). ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['blind_fee'], false) . ')', false),'info' => sprintf(__l('The %s who posted entries in your contest could see just their entries and can\'t see entries posted by other %s. This increase Creativity and competition between %s.'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small')))); ?>
					</div>
				<?php } ?>
				<?php if(!empty($contestType['ContestType']['is_private'])){?>
				<div class="clearfix">
					<?php echo $this->Form->input('Contest.private_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'PrivateFee','amount':'" . $contestType['ContestType']['private_fee'] . "'}", 'label' => $this->Html->cText(__l('Private Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['private_fee'], false) . ')', false), 'info' => sprintf(__l('Your contest will be presented just to registered and logged in %s (designers).'), Configure::read('contest.participant_alt_name_plural_small')))); ?>
				</div>
				<?php } ?>
				<?php if(!empty($contestType['ContestType']['is_featured'])){?>
				<div class="clearfix">
					<?php echo $this->Form->input('Contest.featured_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'FeaturedFee','amount':'" . $contestType['ContestType']['featured_fee'] ."'}", 'label' => $this->Html->cText(__l('Featured Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['featured_fee'], false) . ')', false), 'info' => __l('Your contest will be presented on the contest list before other contest which are not Featured.'))); ?>
				</div>
				<?php } ?>
  				<?php if(!empty($contestType['ContestType']['is_highlight'])){?>
  				<div class="clearfix">
  				<?php echo $this->Form->input('Contest.highlight_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-price-checkbox {'other_fee_name':'HighlightFee','amount':'" . $contestType['ContestType']['highlight_fee'] ."'}", 'label' => $this->Html->cText(__l('Highlight Contest') . ' (' . $this->Html->siteCurrencyFormat($contestType['ContestType']['highlight_fee'], false) . ')', false), 'info' => __l('Contest will be presented on the contest list with highlighting design.'))); ?>
  				</div>
  				<?php } ?>
  				<?php
				echo $this->Form->input('other_fee', array('type' => 'hidden', 'value' => 0,'readonly'=>'readonly'));
				if(!empty($contestType['PricingDay'][0]['ContestTypesPricingDay'])){
					echo $this->Form->input('days_complete', array('type' => 'hidden', 'value' => $contestType['PricingDay'][0]['ContestTypesPricingDay']['price'],'readonly'=>'readonly'));
				}
			?>
    		</div>
    	</div>
		</div>
	<?php echo $this->Form->end();?>
</div>