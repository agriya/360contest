<div class="clearfix js-responses admin-chart-block js-load-admin-chart-contests">
	<?php
		$class = 'grid_left admin-dashboard-chart';
		$class_pass = 'admin-dashboard-pass-usage-chart';
		$arrow = '<i class="icon-chevron-down pull-right"></i>';
		if (isset($this->request->params['named']['is_ajax_load'])) {
			$arrow = '<i class="pull-right icon-chevron-up"></i>';
		}
	?>
	<div class="page-title-info clearfix">
		<h2 class="chart-dashboard-title ribbon-title clearfix">
			<?php echo __l('Contests / Entries'); ?>
			<span class="js-chart-showhide {'chart_block':'admin-dashboard-contests', 'dataloading':'div.js-load-admin-chart-contests','dataurl':'admin/contest_charts/contest_chart/is_ajax_load:1'}"><?php echo $arrow; ?>&nbsp;</span>
		</h2>
	</div>
    <?php if(isset($this->request->params['named']['is_ajax_load'])){ ?>
		<div class="main-inner clearfix round-3">
			<div class="admin-center-block clearfix dashboard-center-block <?php echo (empty($this->request->params['isAjax']))? 'hide' : ''; ?>" id="admin-dashboard-contests">
				<div class="clearfix">
					<?php
						echo $this->Form->create('Chart' , array('class' => 'grid_right language-form', 'action' => 'admin_chart_contests'));
						echo $this->Form->input('is_ajax_load', array('type' => 'hidden', 'value' => 1));
						echo $this->Form->input('select_range_id', array('class' => 'js-chart-autosubmit', 'label' => __l('Select Range')));
					?>
					<div class="hide"><?php echo $this->Form->submit('Submit'); ?></div>
					<?php echo $this->Form->end(); ?>
				</div>
				
				<div class="js-load-line-graph grid_left chart-half-section {'data_container':'contest_line_data', 'chart_container':'contest_line_chart', 'chart_title':'<?php echo __l('Contests') ;?>', 'chart_y_title': '<?php echo __l('Contests');?>'}">
					<div class="dashboard-tl">
						<div class="dashboard-tr">
							<div class="dashboard-tc"></div>
						</div>
					</div>
					<div class="dashboard-cl">
						<div class="dashboard-cr">
							<div class="dashboard-cc clearfix">
								<div id="contest_line_chart" class="<?php echo $class; ?>"></div>
								<div class="hide">
									<table id="contest_line_data" class="list">
										<thead>
											<tr>
												<th>Period</th>
												<?php foreach($chart_contest_status_periods as $_period): ?>
													<th><?php echo $_period['display']; ?></th>
												<?php endforeach; ?>
											</tr>
										</thead>
										<tbody>
											<?php foreach($chart_contest_status_data as $display_name => $chart_data): ?>
												<tr>
													<th><?php echo $display_name; ?></th>
													<?php foreach($chart_data as $val): ?>
														<td><?php echo $val; ?></td>
													<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-bl">
						<div class="dashboard-br">
							<div class="dashboard-bc"></div>
						</div>
					</div>
				</div>
				<div class="js-load-line-graph grid_left chart-half-section {'data_container':'entries_line_data', 'chart_container':'entries_line_chart', 'chart_title':'<?php echo __l('Entries') ;?>', 'chart_y_title': '<?php echo __l('Entries');?>'}">
					<div class="dashboard-tl">
						<div class="dashboard-tr">
							<div class="dashboard-tc"></div>
						</div>
					</div>
					<div class="dashboard-cl">
						<div class="dashboard-cr">
							<div class="dashboard-cc clearfix">
								<div id="entries_line_chart" class="<?php echo $class; ?>"></div>
								<div class="hide">
									<table id="entries_line_data" class="list">
										<thead>
											<tr>
												<th>Period</th>
												<?php foreach($chart_contest_user_status_periods as $_period): ?>
													<th><?php echo $_period['display']; ?></th>
												<?php endforeach; ?>
											</tr>
										</thead>
										<tbody>
											<?php foreach($chart_contest_user_status_data as $display_name => $chart_data): ?>
												<tr>
													<th><?php echo $display_name; ?></th>
													<?php foreach($chart_data as $val): ?>
														<td><?php echo $val; ?></td>
													<?php endforeach; ?>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<div class="dashboard-bl">
						<div class="dashboard-br">
							<div class="dashboard-bc"></div>
						</div>
					</div>
				</div>
           	</div>
		</div>
		

	<?php   } ?>
</div>