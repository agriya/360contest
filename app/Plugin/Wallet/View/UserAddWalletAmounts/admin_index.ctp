<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="userAddWalletAmounts index">
  <h2><?php echo __l('User Add Wallet Amounts');?></h2>
  <?php echo $this->element('paging_counter');?>
  <ol class="list" start="<?php echo $paginator->counter(array('format' => '%start%'));?>">
    <?php
			if (!empty($userAddWalletAmounts)):
				$i = 0;
				foreach ($userAddWalletAmounts as $userAddWalletAmount):
					$class = null;
					if ($i++ % 2 == 0) {
						$class = ' class="altrow"';
					}
		?>
    <li<?php echo $class;?>>
      <p><?php echo $html->cInt($userAddWalletAmount['UserAddWalletAmount']['id']);?></p>
      <p><?php echo $html->cDateTime($userAddWalletAmount['UserAddWalletAmount']['created']);?></p>
      <p><?php echo $html->cDateTime($userAddWalletAmount['UserAddWalletAmount']['modified']);?></p>
      <p><?php echo $html->link($html->cText($userAddWalletAmount['User']['username']), array('controller'=> 'users', 'action' => 'view', $userAddWalletAmount['User']['username']), array('escape' => false));?></p>
      <p><?php echo $html->cCurrency($userAddWalletAmount['UserAddWalletAmount']['amount']);?></p>
      <p><?php echo $html->cText($userAddWalletAmount['UserAddWalletAmount']['pay_key']);?></p>
      <p><?php echo $html->link($html->cText($userAddWalletAmount['PaymentGateway']['display_name']), array('controller'=> 'payment_gateways', 'action' => 'view', $userAddWalletAmount['PaymentGateway']['id']), array('escape' => false));?></p>
      <p><?php echo $html->cBool($userAddWalletAmount['UserAddWalletAmount']['is_success']);?></p>
      <div class="actions"><?php echo $html->link(__l('Edit'), array('action'=>'edit', $userAddWalletAmount['UserAddWalletAmount']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?><?php echo $html->link(__l('Delete'), array('action'=>'delete', $userAddWalletAmount['UserAddWalletAmount']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></div>
    </li>
    <?php
				endforeach;
			else:
		?>
    <li>
      <p class="notice"><?php echo sprintf(__l('No %s available'), __l('User Add Wallet Amounts'));?></p>
    </li>
    <?php
			endif;
		?>
  </ol>
  <?php
		if (!empty($userAddWalletAmounts)) {
			echo $this->element('paging_links');
		}
	?>
</div>