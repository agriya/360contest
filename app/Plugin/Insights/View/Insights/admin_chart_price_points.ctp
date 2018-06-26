<div class="clearfix">
  <table class="table table-striped table-bordered table-condensed">
    <thead>
      <tr>
        <th class="dc" rowspan="2"><?php echo __l('Price Point');?></th>
        <th class="dc" colspan="3"><?php echo __l('Total');?></th>
        <th class="dc" colspan="4"><?php echo __l('Average');?></th>
      </tr>
      <tr>
        <th class="dr"><?php echo __l('Revenue').' ('.Configure::read('site.currency').')';?></th>
        <th class="dc"><?php echo '# ' . __l('Contests');?></th>
        <th class="dc"><?php echo __l('# Entry');?></th>
        <th class="dc"><?php echo __l('%s Entry') . '/' . __l('Contests');?></th>
        <th class="dr"><?php echo __l('Revenue'). '/' . __l('Contests') . ' (' . Configure::read('site.currency') . ')';?></th>
      </tr>
    </thead>
    <tbody>
      <?php
        if (!empty($pricePoints)):
          foreach ($pricePoints as $pricePoint):
      ?>
      <tr>
        <td class="dc"><?php echo $this->Html->cText($pricePoint['price_points']);?></td>
        <td class="dr"><?php echo $this->Html->cCurrency($pricePoint['revenue']);?></td>
        <td class="dc"><?php echo $this->Html->cInt($pricePoint['contests_count']);?></td>
        <td class="dc"><?php echo $this->Html->cInt($pricePoint['contest_users']);?></td>
        <td class="dc"><?php echo $this->Html->cFloat($pricePoint['average_contest_user_count']);?></td>
        <td class="dr"><?php echo $this->Html->cFloat($pricePoint['average_revenue_contest_amoumt']);?></td>
      </tr>
      <?php
          endforeach;
        else:
      ?>
      <tr>
        <td colspan="11" class="errorc space"><i class="icon-warning-sign errorc"></i> <?php echo sprintf(__l('No %s available'), __l('Stats'));?></td>
      </tr>
      <?php
        endif;
      ?>
    </tbody>
  </table>
	<div class="row-fluid">
	  <div class="js-load-column-chart chart-half-section {'data_container':'total_revenue_column_data', 'chart_container':'total_revenue_column_chart', 'chart_title':'<?php echo __l('Total Revenue by Price Point') ;?>', 'chart_y_title': '<?php echo __l('Total Revenue');?>'}">
		<div class="span12 bot-mspace sep-right clearfix">
		  <div id="total_revenue_column_chart" class="admin-dashboard-chart"></div>
		  <div class="hide">
			<table id="total_revenue_column_data" class="list">
			  <tbody>
				<?php foreach($pricePoints as $pricePoint): ?>
				  <tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $pricePoint['revenue']; ?></td>
				  </tr>
				<?php endforeach; ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	  <div class="js-load-column-chart chart-half-section {'data_container':'total_fund_column_data', 'chart_container':'total_fund_column_chart', 'chart_title':'<?php echo __l('Total Entry by Price Point');?>', 'chart_y_title': '<?php echo __l('Total Entry');?>'}">
		<div class="span12 bot-mspace clearfix pull-right">
		  <div id="total_fund_column_chart" class="admin-dashboard-chart"></div>
		  <div class="hide">
			<table id="total_fund_column_data" class="list">
			  <tbody>
				<?php foreach($pricePoints as $pricePoint): ?>
				  <tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $pricePoint['contest_users']; ?></td>
				  </tr>
				<?php endforeach; ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
	<div class="row-fluid">
	  <div class="js-load-column-chart chart-half-section {'data_container':'total_avg_revenue_column_data', 'chart_container':'total_avg_revenue_column_chart', 'chart_title':'<?php echo __l('Avg Revenue per Contest by Price Point'); ?>', 'chart_y_title': '<?php echo __l('Avg Revenue per Contest'); ?>'}">
		<div class="span12 bot-mspace sep-right clearfix">
		  <div id="total_avg_revenue_column_chart" class="contest-price-point-chart admin-dashboard-chart"></div>
		  <div class="hide">
			<table id="total_avg_revenue_column_data" class="list">
			  <tbody>
				<?php foreach($pricePoints as $pricePoint): ?>
				  <tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $pricePoint['average_revenue_contest_amoumt']; ?></td>
				  </tr>
				<?php endforeach; ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	  <div class="js-load-column-chart chart-half-section {'data_container':'total_avg_funds_column_data', 'chart_container':'total_avg_funds_column_chart', 'chart_title':'<?php echo __l('Avg Contests Entry per Contest by Price Point'); ?>', 'chart_y_title': '<?php echo __l('Avg Contest Entry per Contest');?>'}">
		<div class="span12 bot-mspace clearfix pull-right">
		  <div id="total_avg_funds_column_chart" class="admin-dashboard-chart"></div>
		  <div class="hide">
			<table id="total_avg_funds_column_data" class="list">
			  <tbody>
				<?php foreach($pricePoints as $pricePoint): ?>
				  <tr>
					<th><?php echo $pricePoint['price_points']; ?></th>
					<td><?php echo $pricePoint['average_contest_user_count']; ?></td>
				  </tr>
				<?php endforeach; ?>
			  </tbody>
			</table>
		  </div>
		</div>
	  </div>
	</div>
</div>