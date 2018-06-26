<?php /* SVN: $Id: $ */ ?>
<div class="admin-center-block clearfix">
	<div class="hor-space">
		<div class="countries form thumbnail"> 
		<ul class="breadcrumb">
			  <li><?php echo $this->Html->link(__l('Countries'), array('action' => 'index'),array('title' => __l('Countries')));?><span class="divider">&raquo</span></li>
			  <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Country'));?></li>
			</ul>
		<?php echo $this->Form->create('Country', array('action' => 'edit', 'class' => 'form-horizontal form-large-fields'));?>
		<?php
					 echo $this->Form->input('id');
					echo $this->Form->input('name');
					echo $this->Form->input('fips_code');
					echo $this->Form->input('iso_alpha2');
					echo $this->Form->input('iso_alpha3');
					echo $this->Form->input('iso_numeric');
					echo $this->Form->input('capital');
					echo $this->Form->input('areainsqkm');
					echo $this->Form->input('continent');
					echo $this->Form->input('tld');
					echo $this->Form->input('currency');
					echo $this->Form->input('currencyname');
					echo $this->Form->input('Phone');
					echo $this->Form->input('population', array('info' => '<i class="icon-info-sign"></i> Ex: 2001600'));
					echo $this->Form->input('postalCodeFormat');
					echo $this->Form->input('postalCodeRegex');
					echo $this->Form->input('languages');
					echo $this->Form->input('geonameId');
					echo $this->Form->input('neighbours');
					echo $this->Form->input('equivalentFipsCode');
					?>
		<div class="submit-block clearfix"> <?php echo $this->Form->end(__l('Update'));?> </div>
		</div>
	</div>
</div>