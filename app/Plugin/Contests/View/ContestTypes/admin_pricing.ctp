<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="contestTypes form js-response space">
	<ul class="nav nav-tabs">
        <li class="step1">
				<?php echo $this->Html->link('Overview', array('admin' => true, 'controller' => 'contest_types', 'action' => 'edit', $this->request->data['ContestType']['id'],'type' => 'overview'));?>
		</li>
		<li class="step2">
				<?php echo $this->Html->link('Form Fields', array('admin' => true, 'controller' => 'contest_types', 'action' => 'edit', $this->request->data['ContestType']['id'],'type' => 'form_fields'));?>
		</li>
        <li class="active"><a href="#"><?php echo __l('Pricing');?></a></li>
        <li class="step4">
				<?php echo $this->Html->link('Preview', array('admin' => true, 'controller' => 'contests', 'action' => 'add', 'contest_type_id'=>$this->request->data['ContestType']['id'],'type' => 'preview'));?>
		</li>
    </ul>
	<div>
<?php echo $this->Form->create('ContestType', array('action' => 'pricing', 'class' => 'form-horizontal'));?>
		<?php echo $this->Form->input('id'); ?>
        <div class="clearfix contest-price-section">
           <div class="well"><h3 class="contest-price pull-left">
                <?php echo __l('Contest Prize') ?>
    		</h3> <span class="pull-right"><?php echo $this->Html->link('<i class="icon-th-list grayc"></i>'.__('Global List'), array('controller'=> 'pricing_packages', 'action' => 'index'), array('class'=>'global-list space pinkc', 'title' => __l('Global List'), 'escape' => false , 'title'=>'Global List'));?>
			<?php echo $this->Html->link('<i class="icon-plus-sign grayc"></i>'.__l('Add'), array('controller'=> 'pricing_packages', 'action' => 'add'), array('class'=>'add pinkc', 'title' => __l('Add'), 'escape' => false, 'title'=>'Add'));?></span>
			</div>
			<p class="round-5 grid_right global-configurations"><span class="configurations-arrow"></span><span class="round-5 content"><?php echo __l('To edit or add package name and global configurations'); ?></span></p>
		</div>
		<div class="alert alert-info"><?php echo __l('Choose the Prize Packages applicable for this contest type. You can
override the details here and this will be final') ?>.</div>

		<table class="table table-striped table-bordered table-condensed table-hover">
			<tr>
				<th><?php echo __l('Package');?></th>
				<th><?php echo __l('Prize').' ('.Configure::read('site.currency').')';?></th>
				<th><?php echo __l('Site Fee/').' '.Configure::read('contest.participant_alt_name_singular_caps').' '.__l('Commission'). ' ('.'%'.')';?></th>
				<th><?php echo __l('Maximum Entries Allowed');?></th>
			</tr>
			<?php
				foreach($pricingPackages as $pricingPackage):
				$contestTypesPricingPackageId = '';
				if (empty($contestType['PricingPackage']) && empty($this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']])) {
					$class = $disabled = 'disabled';
					$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['is_checked'] = 0;
					$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['price'] = $pricingPackage['PricingPackage']['global_price'];
					$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['participant_commision'] = $pricingPackage['PricingPackage']['participant_commision'];
					$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = $pricingPackage['PricingPackage']['maximum_entry_allowed'];
				} elseif (empty($this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]) && !empty($contestType['PricingPackage'])) {
					foreach($contestType['PricingPackage'] as $contestTypePricingPackage) {
						$class = $disabled = '';
						if ($contestTypePricingPackage['id'] == $pricingPackage['PricingPackage']['id']) {
							$contestTypesPricingPackageId = $contestTypePricingPackage['ContestTypesPricingPackage']['id'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['is_checked'] = 1;
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['price'] = $contestTypePricingPackage['ContestTypesPricingPackage']['price'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['participant_commision'] = $contestTypePricingPackage['ContestTypesPricingPackage']['participant_commision'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = $contestTypePricingPackage['ContestTypesPricingPackage']['maximum_entry_allowed'];
							break;
						} else {
							$class = $disabled = 'disabled';
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['participant_commision'] = $pricingPackage['PricingPackage']['participant_commision'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['price'] = $pricingPackage['PricingPackage']['global_price'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = $pricingPackage['PricingPackage']['maximum_entry_allowed'];
						}
					}
				}  elseif (!empty($this->request->data['PricingPackage'])) {
					if (empty($this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['id'])) {
						$class = $disabled = '';
						if (empty($this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['is_checked'])) {
							$class = $disabled = 'disabled';
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['price'] = $pricingPackage['PricingPackage']['global_price'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['participant_commision'] = $pricingPackage['PricingPackage']['participant_commision'];
							$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = $pricingPackage['PricingPackage']['maximum_entry_allowed'];
						}
					} else {
						foreach($this->request->data['PricingPackage'] as $contestTypePricingPackage) {
							$class = $disabled = '';
							if ($contestTypePricingPackage['id'] == $pricingPackage['PricingPackage']['id']) {
								$contestTypesPricingPackageId = $contestTypePricingPackage['id'];
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['is_checked'] = 1;
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['price'] = $pricingPackage['PricingPackage']['global_price'];
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['participant_commision'] = $pricingPackage['PricingPackage']['participant_commision'];
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = $pricingPackage['PricingPackage']['maximum_entry_allowed'];
								break;
							} else {
								$class = $disabled = 'disabled';
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['participant_commision'] = $pricingPackage['PricingPackage']['participant_commision'];
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['price'] = $pricingPackage['PricingPackage']['global_price'];
								$this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = $pricingPackage['PricingPackage']['maximum_entry_allowed'];
							}
						}
					}
				}
		?>
			<tr>
			<?php echo $this->Form->input('PricingPackage.'.$pricingPackage['PricingPackage']['id'].'.id', array('type' => 'hidden', 'value' => $contestTypesPricingPackageId)); ?>
						<td class="dl">
						<div class="input checkbox mspace"><?php echo $this->Form->input('PricingPackage.'.$pricingPackage['PricingPackage']['id'].'.is_checked', array('type' => 'checkbox', 'class' => "js-pricing-package-checkbox {'pricing_package_id':'".$pricingPackage['PricingPackage']['id']."'}", 'div' => false, 'label' => $this->Html->cText($pricingPackage['PricingPackage']['name'], false))); ?>
                        <div class="pricingpackage-description">
                        <span class="info"><?php echo $pricingPackage['PricingPackage']['description'];
                        ?></span>
                        </div>
						</div>
						</td>
						<td class="dl"><div class="info-block">
						<?php echo $this->Form->input('PricingPackage.'.$pricingPackage['PricingPackage']['id'].'.price', array('type' => 'text', 'class' => $class, 'disabled' => $disabled,'label' =>false,'info' => sprintf('%s %s',__l('Global'), $this->Html->cText($pricingPackage['PricingPackage']['global_price'], false)))); ?>
						</div></td>
						<td class="dl site-amount"><div class="info-block">
						<?php echo $this->Form->input('PricingPackage.'.$pricingPackage['PricingPackage']['id'].'.participant_commision', array('type' => 'text', 'class' => $class, 'disabled' => $disabled, 'label' => false, 'info' => sprintf('%s %s',__l('Global'), $this->Html->cText($pricingPackage['PricingPackage']['participant_commision'], false)))); ?>
						</div></td>
						<td class="dl"><div class="info-block">
							<?php if(empty($this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'])) { $this->request->data['PricingPackage'][$pricingPackage['PricingPackage']['id']]['maximum_entry_allowed'] = ''; } 
							if(!empty($pricingPackage['PricingPackage']['maximum_entry_allowed'])){
								$pricingPackage['PricingPackage']['maximum_entry_allowed'] = $pricingPackage['PricingPackage']['maximum_entry_allowed'];
							} else {
								$pricingPackage['PricingPackage']['maximum_entry_allowed'] = 'unlimited';
							}
							?>
							<?php echo $this->Form->input('PricingPackage.'.$pricingPackage['PricingPackage']['id'].'.maximum_entry_allowed', array('type' => 'text', 'class' => $class,  'disabled' => $disabled,'label' => false, 'info' => sprintf('%s %s',__l('Leave blank for unlimited entries. Global'), $this->Html->cText($pricingPackage['PricingPackage']['maximum_entry_allowed'], false)))); ?>
							</div></td>
					</tr>
				<?php
				endforeach;
						?>
		</table>
          <div class="clearfix">
                <div class="well"><h3 class="contest-price pull-left">
                    <?php echo __l('Contest Days') ?>
        		</h3>
				<span class="pull-right"><?php  echo $this->Html->link('<i class="icon-th-list grayc"></i>'.__('Global List'), array('controller'=> 'pricing_days', 'action' => 'index'), array('class'=>'global-list space pinkc', 'title' => 'Global List', 'escape' => false));?><?php echo $this->Html->link('<i class="icon-plus-sign grayc"></i>'.__('Add'), array('controller'=> 'pricing_days', 'action' => 'add'), array('class'=>'new pinkc','title' => 'Add', 'escape' => false));?></span></div>
				<p class="round-5 grid_right global-configurations"><span class="configurations-arrow"></span><span class="round-5 content"><?php echo __l('To edit or add contest day values and global configurations'); ?></span></p>
    		</div>
		<div class="alert alert-info"><?php echo __l('Here, Site Fee/Price is in flat and levied from').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').''.__l(';  meaning, it\'s not a percentage value');
			echo __l(' Site should pay the gateway fee for payment.');
		?>.</div>
			<table class="table table-striped table-bordered table-condensed table-hover">
			<tr>
				<th class="select"><?php echo __l('Contest Days');?></th>
				<th class="actions"><?php echo __l('Price').' ('.Configure::read('site.currency').')';?></th>
			</tr>
			<?php
			foreach($pricingDays as $pricingDay):
				$contestTypesPricingDayId = '';
				if (empty($contestType['PricingDay']) && empty($this->request->data['PricingDay'][$pricingDay['PricingDay']['id']])) {
					$class = $disabled = 'disabled';
					$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['is_checked'] = 0;
					$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['price'] = $pricingDay['PricingDay']['global_price'];
				} elseif(empty($this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]) && !empty($contestType['PricingDay'])) {
					foreach($contestType['PricingDay'] as $contestTypePricingDay) {
						$class = $disabled = '';
						if ($contestTypePricingDay['id'] == $pricingDay['PricingDay']['id']) {
							$contestTypesPricingDayId = $contestTypePricingDay['ContestTypesPricingDay']['id'];
							$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['is_checked'] = 1;
							$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['price'] = $contestTypePricingDay['ContestTypesPricingDay']['price'];
							break;
						} else {
							$class = $disabled = 'disabled';
							$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['price'] = $pricingDay['PricingDay']['global_price'];
						}
					}
				} elseif (!empty($this->request->data['PricingDay'])) {
					if (empty($this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['id'])) {
						$class = $disabled = '';
						if (empty($this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['is_checked'])) {
							$class = $disabled = 'disabled';
							$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['price'] = $pricingDay['PricingDay']['global_price'];
						}
					} else {
						foreach($this->request->data['PricingDay'] as $contestTypePricingDay) {
							$class = $disabled = '';
							if ($contestTypePricingDay['id'] == $pricingDay['PricingDay']['id']) {
								$contestTypesPricingDayId = $contestTypePricingDay['id'];
								$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['is_checked'] = 1;
								$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['price'] = $pricingDay['PricingDay']['global_price'];
								break;
							} else {
								$class = $disabled = 'disabled';
								$this->request->data['PricingDay'][$pricingDay['PricingDay']['id']]['price'] = $pricingDay['PricingDay']['global_price'];
							}
						}
					}
				}
			?>
			<tr>
			  <?php echo $this->Form->input('PricingDay.'.$pricingDay['PricingDay']['id'].'.id', array('type' => 'hidden', 'value' => $contestTypesPricingDayId)); ?>
						<td class="dl"><?php echo $this->Form->input('PricingDay.'.$pricingDay['PricingDay']['id'].'.is_checked', array('type' => 'checkbox', 'class' => "js-pricing-day-checkbox {'pricing_day_package_id':'".$pricingDay['PricingDay']['id']."'}", 'label' => $this->Html->cText($pricingDay['PricingDay']['no_of_days'], false))); ?>
											</td>
						<td class="site-amount"><div class="info-block">
						<?php echo $this->Form->input('PricingDay.'.$pricingDay['PricingDay']['id'].'.price', array('type' => 'text', 'class' => $class, 'disabled' => $disabled, 'label' =>false, 'info' => sprintf('%s %s',__l('Global'), $this->Html->cText($pricingDay['PricingDay']['global_price'], false)))); ?>
						</div></td>
		</tr>
				<?php
				endforeach;
							?>
		</table>
		<?php if((Configure::read('contest.is_enable_blind_fee') && Configure::read('contest.is_contest_holder_can_choose_blind_fee')) || (Configure::read('contest.is_enable_private_fee') && Configure::read('contest.is_contest_holder_can_choose_private_fee')) || (Configure::read('contest.is_enable_featured_fee') && Configure::read('contest.is_contest_holder_can_choose_featured_fee')) || (Configure::read('contest.is_enable_highlight_fee') && Configure::read('contest.is_contest_holder_can_choose_highlight_fee'))) {?>
          <div class="clearfix">
                 <div class="well"><h3 class="contest-price pull-left">
                    <?php echo __l('Additional Contest Features') ?>
        		</h3>
				<span class="pull-right">
				<?php  echo $this->Html->link('<i class="icon-th-list grayc"></i>'.__('Global List'), array('controller'=> 'settings', 'action' => 'edit',8), array('class'=>'global-list space pinkc', 'title' => __('Global List'), 'escape' => false));?>
				</span>
				</div>
				<p class="round-5 grid_right global-configurations"><span class="configurations-arrow"></span><span class="round-5 content"><?php echo __l('To edit or add contest day values and global configurations'); ?></span></p>
    		</div>
		<div class="alert alert-info"><?php echo __l('Here, Site Fee/Price is in flat and levied from').' '.Configure::read('contest.contest_holder_alt_name_singular_caps').''.__l(';  meaning, it\'s not a percentage value.');
			echo __l(' Site should pay the gateway fee for payment.');
		?>

		</div>
			<table class="table table-striped table-bordered table-condensed table-hover">
			<tr>
				<th class="select"><?php echo __l('Name');?></th>
				<th class="actions"><?php echo __l('Price').' ('.Configure::read('site.currency').')';?></th>
			</tr>
			<?php
			if(Configure::read('contest.is_enable_blind_fee') && Configure::read('contest.is_contest_holder_can_choose_blind_fee'))
			{
			?>
			<?php 
			$class = $disabled = '';
			$value=0; 
			$checked = '';
			if(!empty($contestType['ContestType']['is_blind'])){
				$value = $contestType['ContestType']['blind_fee'];
				$checked = 'checked';
			}else{
				$value = Configure::read('contest.blind_fee');
				$class = $disabled = 'disabled';
			}
			?>
			<tr>
				<td class="dl"><div class="info-block">
					<?php echo $this->Form->input('ContestType.blind_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-checkbox {'other_fee_name':'BlindFee'}", 'label' => $this->Html->cText(__l('Blind Contest'), false),'checked' => $checked, 'info' => sprintf(__l('The %s who posted entries in your contest could see just their entries and can\'t see entries posted by other %s. This increase Creativity and competition between %s.'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small'), Configure::read('contest.participant_alt_name_plural_small')))); ?>
				</div></td>
				<td class="site-amount"><div class="info-block">
					<?php echo $this->Form->input('ContestType.blind_fee.price', array('value'=>$value,'type' => 'text', 'class' => $class, 'disabled' => $disabled, 'label' =>false, 'info' => sprintf('%s %s',__l('Global'), $this->Html->cText(Configure::read('contest.blind_fee'), false)))); ?>
				</div></td>
			</tr>
			<?php
			}
			if(Configure::read('contest.is_enable_private_fee') && Configure::read('contest.is_contest_holder_can_choose_private_fee'))
			{
			?>
			<?php 
			$class = $disabled = '';
			$value=0;
			$checked = '';
			if(!empty($contestType['ContestType']['is_private'])){
				$value = $contestType['ContestType']['private_fee'];
				$checked = 'checked';
			}else{
				$value = Configure::read('contest.private_fee');
				$class = $disabled = 'disabled';
			}
			?>
			<tr>
				<td class="dl"><div class="info-block">
					<?php echo $this->Form->input('ContestType.private_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-checkbox {'other_fee_name':'PrivateFee'}", 'label' => $this->Html->cText(__l('Private Contest'), false),'checked' => $checked, 'info' => sprintf(__l('Your contest will be presented just to registered and logged in %s (designers).'), Configure::read('contest.participant_alt_name_plural_small')))); ?>
				</div></td>
				<td class="site-amount"><div class="info-block">
					<?php echo $this->Form->input('ContestType.private_fee.price', array('value'=>$value,'type' => 'text', 'class' => $class, 'disabled' => $disabled, 'label' =>false, 'info' => sprintf('%s %s',__l('Global'), $this->Html->cText(Configure::read('contest.private_fee'), false)))); ?>
				</div></td>
			</tr>
			<?php
			}
			if(Configure::read('contest.is_enable_featured_fee') && Configure::read('contest.is_contest_holder_can_choose_featured_fee'))
			{
			?>
			<?php 
			$class = $disabled = '';
			$value=0;
			$checked = '';
			if(!empty($contestType['ContestType']['is_featured'])){
				$value = $contestType['ContestType']['featured_fee'];
				$checked = 'checked';
			}else{
				$value = Configure::read('contest.featured_fee');
				$class = $disabled = 'disabled';
			}
			?>
			<tr>
				<td class="dl"><div class="info-block">
					<?php echo $this->Form->input('ContestType.featured_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-checkbox {'other_fee_name':'FeaturedFee'}", 'label' => $this->Html->cText(__l('Featured Contest'), false),'checked' => $checked, 'info' => __l('Your contest will be presented on the contest list before other contest which are not Featured.'))); ?>
				</div></td>
				<td class="site-amount"><div class="info-block">
					<?php echo $this->Form->input('ContestType.featured_fee.price', array('value'=>$value,'type' => 'text', 'class' => $class, 'disabled' => $disabled, 'label' =>false, 'info' => sprintf('%s %s',__l('Global'), $this->Html->cText(Configure::read('contest.featured_fee'), false)))); ?>

				</div>
			</td>
  		  </tr>
  		<?php
  		}
  		if(Configure::read('contest.is_enable_highlight_fee') && Configure::read('contest.is_contest_holder_can_choose_highlight_fee'))
  		{
  		?>
  		<?php
  			$class = $disabled = '';
  			$value=0;
  			$checked = '';
  		if(!empty($contestType['ContestType']['is_highlight'])){
  			$value = $contestType['ContestType']['highlight_fee'];
  			$checked = 'checked';
  		}else{
  			$value = Configure::read('contest.highlight_fee');
  			$class = $disabled = 'disabled';
  		}
  		?>
  		<tr>
  			<td class="dl">
  				<?php echo $this->Form->input('ContestType.highlight_fee.is_checked', array('type' => 'checkbox', 'class' => "js-other-fee-checkbox {'other_fee_name':'HighlightFee'}", 'label' => $this->Html->cText(__l('Highlight Contest'), false),'checked' => $checked, 'info' => __l('Contest will be presented on the contest list with highlighting design.'))); ?>
  			</td>
  			<td class="site-amount">
				<div class="info-block">
  				<?php echo $this->Form->input('ContestType.highlight_fee.price', array('value'=>$value,'type' => 'text', 'class' => $class, 'disabled' => $disabled, 'label' =>false, 'info' => sprintf('%s %s',__l('Global'), $this->Html->cText(Configure::read('contest.highlight_fee'), false)))); ?>
				</div>
			</td>
		</tr>
		<?php
		}
		?>
		</table>
		<?php } ?>
     <div class="form-actions clearfix">
		<?php echo $this->Form->submit(__l('Update'));?>
	</div>
	<?php echo $this->Form->end();?>
	</div>
	
</div>