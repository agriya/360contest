<div class="clearfix">
  <div class="clearfix">
<table class="table table-striped table-bordered table-condensed table-hover">
    <tr>
      <td class="dr"><?php echo __l('Creation Cost');?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($contest_stats['creation_cost']);?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Prize');?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($contest_stats['prize']);?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Entry Count');?></td>
      <td class="dr"><?php echo $contest_stats['contest_user_count'];?></td>
    </tr>
    <tr>
      <td class="dr"><?php echo __l('Site Commission');?></td>
      <td class="dr"><?php echo $this->Html->cCurrency($contest_stats['site_commision']);?></td>
    </tr>
  </table>
</div>
 <?php
    $div_class = "js-load-pie-chart ";
  ?>
  <div class="<?php echo $div_class;?> chart-half-section {'chart_type':'PieChart', 'data_container':'user_pie_fund_data<?php echo $user_type_id; ?>', 'chart_container':'user_pie_fund_chart<?php echo $user_type_id; ?>', 'chart_title':'<?php echo __l('Entry');?>', 'chart_y_title': '<?php echo __l('Entry');?>'}">
  <div class="dashboard-tl">
           <div class="dashboard-tr">
             <div class="dashboard-tc">
             </div>
         </div>
      </div>
     <div class="dashboard-cl">
       <div class="dashboard-cr">
       <div class="dashboard-cc clearfix">
    <div id="user_pie_fund_chart<?php echo $user_type_id; ?>" class="admin-dashboard-fund-chart"></div>
    <div class="hide">
      <table id="user_pie_fund_data<?php echo $user_type_id; ?>" class="list">
        <tbody>
          <tr>
             <th><?php echo __l('Creation Cost') ?></th>
             <td><?php echo $this->Html->cCurrency($contest_stats['creation_cost']);?></td>
          </tr>
          <tr>
             <th><?php echo __l('Prize') ?></th>
             <td><?php echo $this->Html->cCurrency($contest_stats['prize']);?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
    </div>
    </div>
    <div class="dashboard-bl">
       <div class="dashboard-br">
         <div class="dashboard-bc">
         </div>
       </div>
     </div>
  </div>
<?php if($contest_stats['creation_cost'] > 0) { ?>
  <div class="clearfix">
  <?php echo $this->element('chart-user_demographics', array('cache' => array('config' => 'site_element_cache_15_min', 'key' => $this->Auth->user('id')), 'chart_y_title' => __l('Entry'), 'user_type_id' => 1)); ?>
  </div>
<?php } ?>
</div>