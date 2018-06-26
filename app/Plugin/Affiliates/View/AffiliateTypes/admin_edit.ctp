<?php /* SVN: $Id: $ */ ?>
<div class="affiliateTypes form space">
  <?php echo $this->Form->create('AffiliateType', array('action' => 'edit'));?>
<table class="table table-striped table-bordered table-condensed table-hover">
      <tr>
        <th><?php echo __l('Name');?></th>
        <th><?php echo __l('Commission');?></th>
        <th><?php echo __l('Commission Type');?></th>
        <th><?php echo __l('Active?');?></th>
      </tr>
      <?php
        $types = count($this->request->data['AffiliateType']);
        for($i=0; $i<$types; $i++) {
      ?>
      <tr>
        <td><?php echo $this->Form->input('AffiliateType.'.$i.'.id', array('label' => false)); ?><?php echo $this->Form->input('AffiliateType.'.$i.'.name', array('label' => false)); ?></td>
        <td>
          <?php
            echo $this->Form->input('AffiliateType.'.$i.'.commission', array('label' => false));
            $options = $affiliateCommissionTypes;
            if ($this->request->data['AffiliateType'][$i]['id'] == 1)
              unset($options[1]);
          ?>
        </td>
        <td><?php echo $this->Form->input('AffiliateType.'.$i.'.affiliate_commission_type_id', array('options' => $options, 'label' => false)); ?></td>
        <td><?php echo $this->Form->input('AffiliateType.'.$i.'.is_active', array('label' =>false)); ?></td>
      </tr>
      <?php
        }
      ?>
      <tr>
        <td colspan="4">
         <div class="form-actions"><?php echo $this->Form->submit(__l('Update'));?></div>
        </td>
      </tr>
    </table>
  <?php echo $this->Form->end(); ?>
</div>