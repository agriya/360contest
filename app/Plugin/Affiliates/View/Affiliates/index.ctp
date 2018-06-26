<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="main-section">
  <div class="affiliates index">
  <?php if(!empty($this->request->params['controller']) && ($this->request->params['controller'] == 'affiliates')){?>
<div class="container"><h2 class="ver-space ver-mspace"><?php echo __l('Affiliates'); ?></h2></div>
  <?php } ?>
  <?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
  <div class="container">
    <?php if ($logged_in_user['User']['is_affiliate_user']): ?>
	<?php if(isPluginEnabled('Withdrawals')) : ?>
      <div class="clearfix">
        <div class="pull-right">
          <?php echo $this->Html->link('<i class="icon-briefcase text-16"></i> '.__l('Affiliate Cash Withdrawal Requests'), array('controller' => 'affiliate_cash_withdrawals', 'action' => 'index'),array('class' => 'js-tooltip blackc', 'escape' => false, 'title' => __l('Affiliate Cash Withdrawal Requests'))); ?>
        </div>
      </div>
	  <?php endif; ?>
      <p><?php echo __l('Share your below unique link for referral purposes'); ?></p>
      <input type="text" readonly="readonly" value="<?php echo Router::url(array('controller' => 'users', 'action' => 'refer',  'r' =>$this->Auth->user('username')), true);?>" onclick="this.select()"/>
      <p><?php echo __l('Share your below unique link by appending to end of site URL for referral'); ?></p>
      <input type="text" readonly="readonly" value="<?php echo  '/r:'.$this->Auth->user('username');?>" onclick="this.select()"/>
      <?php  echo $this->element('affiliate_stat', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
      <h3><?php echo __l('Commission History');?></h3>
      <?php echo $this->element('paging_counter');?>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <tr>
          <th><?php echo $this->Paginator->sort('created', __l('Created'));?></th>
          <th><?php echo sprintf(__l('User/%s'), Configure::read('project.alt_name_for_project_singular_caps'));?></th>
          <th><?php echo $this->Paginator->sort('AffiliateType.name', __l('Type'));?></th>
          <th><?php echo $this->Paginator->sort('AffiliateStatus.name', __l('Status'));?></th>
          <th><?php echo $this->Paginator->sort('commission_amount', __l('Commission') . ' (' . Configure::read('site.currency') . ')');?></th>
        </tr>
        <?php
          if (!empty($affiliates)):
            $i = 0;
            foreach ($affiliates as $affiliate):
              $i++;
        ?>
        <tr>
          <td> <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['created']);?></td>
          <td>
            <?php if ($affiliate['Affiliate']['class'] == 'User' && !empty($affiliate['User']['username'])) { ?>
              <?php echo $this->Html->link($this->Html->cText($affiliate['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['User']['username']), array('escape' => false));?>
            <?php } else if ($affiliate['Affiliate']['class'] == 'Contest'){ ?>
              <?php echo $this->Html->link($this->Html->cText($affiliate['Contest']['name']), array('controller'=> 'projects', 'action' => 'view', $affiliate['Contest']['slug']), array('escape' => false));?>
              (<?php echo $this->Html->link($this->Html->cText($affiliate['Contest']['User']['username']), array('controller'=> 'users', 'action' => 'view', $affiliate['Contest']['User']['username'], 'admin' => false), array('escape' => false));?>)
            <?php } ?>
          </td>
          <td><?php echo $this->Html->cText($affiliate['AffiliateType']['name']);?></td>
          <td>
            <?php echo $this->Html->cText($affiliate['AffiliateStatus']['name']); ?>
            <?php  if($affiliate['AffiliateStatus']['id'] == ConstAffiliateStatus::PipeLine): ?>
              <?php echo $this->Html->cDateTimeHighlight($affiliate['Affiliate']['commission_holding_start_date']);?>
            <?php endif; ?>
          </td>
          <td><?php echo $this->Html->cCurrency($affiliate['Affiliate']['commission_amount']);?></td>
        </tr>
        <?php
            endforeach;
          else:
        ?>
        <tr>
          <td colspan="6"><div class="thumbnail space dc grayc">
        <p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Commission History'));?></p>
        </div></td>
        </tr>
        <?php
          endif;
        ?>
      </table>
      <?php if (!empty($affiliates)) { ?>
        <div class="clearfix">
			<div class="pull-right">
			  <?php echo $this->element('paging_links'); ?>
			</div>
		</div>
      <?php } ?>
    <?php else: ?>
      <?php
        echo $this->element('pages-terms_and_policies', array('cache' => array('config' => 'sec'), 'Plugin' => false, 'slug' => $slug));
        if ($this->Auth->sessionValid()):
          echo $this->element('affiliate_request-add', array('cache' => array('config' => 'sec'), 'Plugin' => 'Affiliates'));
        endif;
      ?>
    <?php endif; ?>
  </div>
</div>
</div>