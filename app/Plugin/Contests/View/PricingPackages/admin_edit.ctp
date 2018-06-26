<?php /* SVN: $Id: $ */ ?>
<div class="hor-space">
<div class="pricingPackages form thumbnail">
<ul class="breadcrumb">
      <li><?php echo $this->Html->link(__l('Prize Package'), array('action' => 'index'),array('title' => __l('Prize Package')));?><span class="divider">&raquo</span></li>
      <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Prize Package'));?></li>
    </ul>
<?php echo $this->Form->create('PricingPackage', array('class' => 'form-large-fields form-horizontal'));?>
	<fieldset>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label' => __l('Name')));
		echo $this->Form->input('description', array('label' => __l('Description')));
		echo $this->Form->input('global_price', array('type' => 'text', 'label' => sprintf(__l('Global Prize (%s)'), Configure::read('site.currency')), 'info'=> __l('You may override the prize value per contest type, from ').' '.$this->Html->link(Router::Url(array('controller'=> 'contest_types', 'action' => 'index'),true), array('controller'=> 'contest_types', 'action' => 'index'), array('escape' => false))));
	    echo $this->Form->input('participant_commision', array('type' => 'text', 'label' => Configure::read('contest.participant_alt_name_singular_caps') . ' ' . __l('Commission (%)'), 'info'=> __l('Site Fee charged from %s (not %s in percentage of prize value.'), Configure::read('contest.participant_alt_name_singular_caps'), Configure::read('contest.contest_holder_alt_name_singular_caps'))) ;
		echo $this->Form->input('maximum_entry_allowed', array('type' => 'text', 'label' => __l('Maximum Entries Allowed'), 'info' => __l('Leave blank for unlimited entries')));
		echo $this->Form->input('features', array('label' => __l('Features')));
	?>
	</fieldset>
	<div class="submit-block clearfix">
    <?php echo $this->Form->submit(__l('Update'));?>
    </div>
    <?php echo $this->Form->end();?>
</div>
</div>