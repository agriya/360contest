<?php /* SVN: $Id: $ */ ?>
<div class="affiliateRequests form">
<?php echo $this->Form->create('AffiliateRequest', array('class' => 'form-horizontal form-large-fields'));?>
  <fieldset>
  <ul class="breadcrumb">
    <li><?php echo $this->Html->link(__l('Affiliate Requests'), array('action' => 'index'),array('title' => __l('Affiliate Requests')));?><span class="divider">&raquo</span></li>
    <li class="active"><?php echo sprintf(__l('Edit %s'), __l('Affiliate Request'));?></li>
  </ul>
  <ul class="nav nav-tabs">
    <li>
    <?php echo $this->Html->link('<i class="icon-th-list blackc"></i>'.__l('List'), array('controller' => 'affiliate_requests', 'action' => 'index'),array('class' => 'blackc', 'title' =>  __l('List'),'data-target'=>'#list_form', 'escape' => false));?>
    </li>
    <li class="active"><a class="blackc" href="#add_form"><i class="icon-edit"></i><?php echo __l('Edit');?></a></li>
  </ul>
  <div>
  <?php
    echo $this->Form->input('id');
    echo $this->Form->input('user_id');
    echo $this->Form->input('site_category_id', array('label' => __l('Site Category')));
    echo $this->Form->input('site_name', array('label' => __l('Site Name')));
    echo $this->Form->input('site_description', array('label' => __l('Site Description')));
    echo $this->Form->input('site_url', array('label' => __l('Site URL'), 'info' => __l('URL must be started with "http://"')));
    echo $this->Form->input('why_do_you_want_affiliate', array('label' => __l('Why Do You Want An Affiliate?')));?>
    <div class ="input checkbox offset2 hor-space">
    <?php echo $this->Form->input('is_web_site_marketing', array('label' => __l('Website Marketing?'),'div'=>false));?>
    <?php echo $this->Form->input('is_search_engine_marketing', array('label' => __l('Search Engine Marketing?'),'div'=>false));?>
    <?php echo $this->Form->input('is_email_marketing', array('label' => __l('Email Marketing?'),'div'=>false));?>
    </div>
    <?php echo $this->Form->input('special_promotional_method', array('label' => __l('Special Promotional Method')));
    echo $this->Form->input('special_promotional_description', array('label' => __l('Special Promotional Description')));?>
       <div class ="input radio offset1 hor-space">
      <span><?php echo __l('Approved?');?></span>
     <?php echo $this->Form->input('is_approved', array('legend' =>false, 'type' => 'radio', 'options' => array(ConstAffiliateRequests::Pending => __l('Waiting for Approval'), ConstAffiliateRequests::Accepted => __l('Approved'), ConstAffiliateRequests::Rejected => __l('Disapproved')),'div'=>false));
     ?></div>
      </div>
  </fieldset>
   <div class="form-actions">
    <?php echo $this->Form->submit(__l('Update'));?>
  </div>
  <?php echo $this->Form->end(); ?>
</div>
