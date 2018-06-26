<div class="clearfix">
  <table class="table table-striped table-bordered table-condensed">
   <thead>
    <tr>
      <th class="dc" colspan="2"></th>
      <th class="dr span5"><?php echo __l('Min');?></th>
      <th class="dr span5"><?php echo __l('Max');?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td class="dr" rowspan="3"><?php echo __l('Offered');?></td>
      <td class="dr"><?php echo __l('Creation Cost').' ('.Configure::read('site.currency').')';?></td>
      <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['creation_cost']['min']);?></td>
      <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['creation_cost']['max']);?></td>
    </tr>
	<tr>
      <td class="dr"><?php echo __l('Prize').' ('.Configure::read('site.currency').')';?></td>
      <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['prize']['min']);?></td>
      <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['prize']['max']);?></td>
    </tr>
     <tr>
      <td class="dr"><?php echo __l('Site Commission').' ('.Configure::read('site.currency').')';?></td>
      <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['site_commision']['min']);?></td>
      <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['site_commision']['max']);?></td>
    </tr>
   </tbody>
  </table>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th class="dc"></th>
        <th class="dr span5"><?php echo __l('Number');?></th>
        <th class="dr span5"><?php echo __l('Gross Profit') .' ('.Configure::read('site.currency').')';?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="dr"><?php echo __l('Total Profit (Including all fees without exceptions)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['total_profit']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['total_profit']['gross_profit']);?></td>
      </tr>
	  <tr>
        <td class="dr"><?php echo __l('Wait To Be Paid to Participants');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['waiting_to_be_paid_to_participants']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['waiting_to_be_paid_to_participants']['gross_profit']);?></td>
      </tr>
    </tbody>
  </table>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th class="dc"></th>
        <th class="dr span5"><?php echo __l('Number');?></th>
        <th class="dr span5"><?php echo __l('Gross Profit') .' ('.Configure::read('site.currency').')';?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="dr"><?php echo __l('Posted Contests (Including all fees except Membership fee)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['posted_contest_total_amount']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['posted_contest_total_amount']['gross_profit']);?></td>
      </tr>
	  <tr>
        <td class="dr"><?php echo __l('Paid To Participants');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['paid_to_participants']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['paid_to_participants']['gross_profit']);?></td>
      </tr>
	  <tr>
        <td class="dr" colspan="2"><?php echo __l('Total') .' ('.Configure::read('site.currency').')';?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['posted_contest_total_amount']['gross_profit'] + $contests_stats['paid_to_participants']['gross_profit']);?></td>
      </tr>
    </tbody>
  </table>
  <table class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th class="dc"></th>
        <th class="dr span5"><?php echo __l('Number');?></th>
        <th class="dr span5"><?php echo __l('Gross Profit') .' ('.Configure::read('site.currency').')';?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="dr"><?php echo __l('Membership Fee (from all users)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['membership_fee']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['membership_fee']['gross_profit']);?></td>
      </tr>
	  <?php 
		$price_packages_total_amount = 0;
		if(!empty($price_packages)) {
			foreach($price_packages As $price_package) { 
	  ?>	
			<tr>
				<td class="dr"><?php echo sprintf(__l('%s Packages Participant Commision'), $price_package['PricingPackage']['name']);?></td>
				<td class="dr span5"><?php echo $this->Html->cInt($contests_stats[$price_package['PricingPackage']['name']]['count']);?></td>
				<td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats[$price_package['PricingPackage']['name']]['gross_profit']);?></td>
			</tr>
	  <?php 
			$price_packages_total_amount = $price_packages_total_amount + $contests_stats[$price_package['PricingPackage']['name']]['gross_profit'];
			} 
		}
	  ?>
	  <tr>
        <td class="dr"><?php echo __l('Blind Contest Fee (from Contest Holders)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['blind_contest_fee']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['blind_contest_fee']['gross_profit']);?></td>
      </tr>
	  <tr>
        <td class="dr"><?php echo __l('Private Contest Fee (from Contest Holders)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['private_contest_fee']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['private_contest_fee']['gross_profit']);?></td>
      </tr>
	  <tr>
        <td class="dr"><?php echo __l('Featured Contest Fee (from Contest Holders)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['featured_contest_fee']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['featured_contest_fee']['gross_profit']);?></td>
      </tr>
	  <tr>
        <td class="dr"><?php echo __l('Highlight Contest Fee (from Contest Holders)');?></td>
        <td class="dr span5"><?php echo $this->Html->cInt($contests_stats['highlight_contest_fee']['count']);?></td>
        <td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats['highlight_contest_fee']['gross_profit']);?></td>
      </tr>
	  <?php 
		$price_days_total_amount = 0;
		if(!empty($pricing_days)) {
			foreach($pricing_days As $pricing_day) { 
	  ?>	
			<tr>
				<td class="dr"><?php echo sprintf(__l('%s Fee (from Contest Holders)'), $pricing_day['PricingDay']['no_of_days'] . ' Days');?></td>
				<td class="dr span5"><?php echo $this->Html->cInt($contests_stats[$pricing_day['PricingDay']['no_of_days'] . ' Days']['count']);?></td>
				<td class="dr span5"><?php echo $this->Html->cCurrency($contests_stats[$pricing_day['PricingDay']['no_of_days'] . ' Days']['gross_profit']);?></td>
			</tr>
	  <?php 
			$price_days_total_amount = $price_days_total_amount + $contests_stats[$pricing_day['PricingDay']['no_of_days'] . ' Days']['gross_profit'];
			} 
		}
	  ?>
	  <tr>
        <td class="dr" colspan="2"><?php echo __l('Total') .' ('.Configure::read('site.currency').')';?></td>
        <td class="dr"><?php echo $this->Html->cCurrency($contests_stats['membership_fee']['gross_profit'] + $price_packages_total_amount + $contests_stats['highlight_contest_fee']['gross_profit'] + $contests_stats['featured_contest_fee']['gross_profit'] + $contests_stats['private_contest_fee']['gross_profit'] + $contests_stats['blind_contest_fee']['gross_profit'] + $price_days_total_amount);?></td>
      </tr>
    </tbody>
  </table>
</div>