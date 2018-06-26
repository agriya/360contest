<?php /* SVN: $Id: $ */ ?>
<div class="js-responses affliates-block">
  <div class="page-header"><h3><?php echo __l('Request Affiliate'); ?></h3></div>
<?php
  if($status == 'pending'):
?>

   <p class="alert alert-info"><?php echo __l('Your request will be confirmed after admin approval.'); ?></p>

<?php
  elseif($status == 'rejected' && empty($this->request->params['named']['status'])):
?>

   <p class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('Sorry, admin declined your request. If you want submit once again please %s'), $this->Html->link(__l('click here'), array('controller' => 'affiliates', 'action' => 'index', 'status' =>'add'), array('title' => __l('click here')))); ?></p>

<?php
  elseif($status == 'add' || (!empty($this->request->params['named']['status']) &&  $this->request->params['named']['status'] == 'add')):
?>
<div class="disk-usage">

  <div class="alert alert-info"><?php echo __l('This request will be confirmed after admin approval.'); ?> </div>

    <?php echo $this->Form->create('AffiliateRequest', array('class' => 'form-horizontal form-large-fields'));?>
      <?php
        echo $this->Form->input('user_id', array('type' => 'hidden'));
        echo $this->Form->input('site_category_id',array('options' => $siteCategories,'empty'=>'Select Category'),null,array('label' => __l('Site Category')));
        echo $this->Form->input('site_name', array('label' => __l('Site Name')));
        echo $this->Form->input('site_description', array('label' => __l('Site Description')));
        echo $this->Form->input('site_url', array('label' => __l('Site URL'), 'info' => __l('URL must be started with "http://"')));
        echo $this->Form->input('why_do_you_want_affiliate', array('label' => __l('Why Do You Want An Affiliate?')));
        echo $this->Form->input('is_web_site_marketing', array('label' => __l('Website Marketing?')));
        echo $this->Form->input('is_search_engine_marketing', array('label' => __l('Search Engine Marketing?')));
        echo $this->Form->input('is_email_marketing', array('label' => __l('Email Marketing?')));
        echo $this->Form->input('special_promotional_method', array('label' => __l('Special Promotional Method')));
        echo $this->Form->input('special_promotional_description', array('label' => __l('Special Promotional Description')));
      ?>

       <div class="form-actions">
        <?php
          echo $this->Form->submit(__l('Request'));
        ?>
      </div>
      <?php echo $this->Form->end();?>
      </div>
<?php
  endif;
?>
</div>