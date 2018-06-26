<div class="js-user-activities js-cache-load-admin-charts-user-activities">
  <div class="accordion-group">
    <?php
       $chart_title = __l('User Login');
      $chart_y_title = __l('Users');
      $role_id = $this->request->data['Chart']['role_id'];
      $collapse_class = 'in';
      if ($this->request->params['isAjax']) {
        $collapse_class ="in";
      }
    ?>
    <div class="accordion-heading">
      <div class="no-mar no-bor clearfix box-head">
        <h5>
          <span class="space pull-left">
            <i class="icon-bar-chart pinkc no-bg"></i>
            <?php echo __l('Activities')  ?>
          </span>
		</h5>
		<div class="pull-right space">
          <a class="accordion-toggle js-toggle-icon js-no-pjax grayc no-under clearfix pull-right no-pad span1" href="#userfollower" data-parent="#accordion-admin-dashboard" data-toggle="collapse">
            <i class="icon-chevron-down pull-right"></i>
          </a>
          <div class="dropdown pull-right">
            <a class="dropdown-toggle js-no-pjax js-overview grayc no-under" data-toggle="dropdown" href="#">
              <i class="icon-wrench"></i>
            </a>
            <ul class="dropdown-menu pull-right arrow arrow-right">
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastDays') ? ' class="active"' : ''; ?>><a class='js-link-chart {"data_load":"js-user-activities"}' title="<?php echo __l('Last 7 days'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastDays";?>"><?php echo __l('Last 7 days'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastWeeks') ? ' class="active"' : ''; ?>><a class='js-link-chart {"data_load":"js-user-activities"}' title="<?php echo __l('Last 4 weeks'); ?>" href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastWeeks";?>"><?php echo __l('Last 4 weeks'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastMonths') ? ' class="active"' : ''; ?>><a class='js-link-chart {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 months'); ?>" href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastMonths";?>"><?php echo __l('Last 3 months'); ?></a> </li>
              <li<?php echo (!empty($this->request->params['named']['select_range_id']) && $this->request->params['named']['select_range_id'] == 'lastYears') ? ' class="active"' : ''; ?>><a class='js-link-chart {"data_load":"js-user-activities"}' title="<?php echo __l('Last 3 years'); ?>"  href="<?php echo Router::url('/', true)."admin/insights/user_activities_insights/select_range_id:lastYears";?>"><?php echo __l('Last 3 years'); ?></a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div   id="userfollower" class="accordion-body collapse over-hide <?php echo $collapse_class;?>">
      <div class="accordion-inner">

	   <?php
          $div_class = "js-load-line-graph ";
        ?>
        <div class="row-fluid ver-space" id="login">
          <section class="span11 sep">
            <div class="<?php echo $div_class;?> space dc {'chart_type':'LineChart', 'data_container':'user_login_line_data<?php echo $role_id; ?>', 'chart_container':'user_login_line_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="user_login_line_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                <table id="user_login_line_data<?php echo $role_id; ?>" class="table table-striped table-bordered table-condensed">
                  <thead>
                    <tr>
                      <th><?php echo __l('Period'); ?></th>
                      <?php foreach($chart_periods as $_period): ?>
                        <th><?php echo $_period['display']; ?></th>
                      <?php endforeach; ?>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($chart_data as $display_name => $chart_data): ?>
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
          </section>
		  <?php if (isPluginEnabled('UserFavourites')) { ?>
		   <?php
		$chart_title = __l('User Followers');
		$chart_y_title = __l('Users');
          $div_class = "js-load-column-chart";
        ?>
          <section class="span11 sep pull-right">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'user_activities_chart_data', 'chart_container':'user_activities_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="user_activities_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="user_activities_chart_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($user_follow_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
        </div>

       
        <div class="row-fluid ver-space" id="contestcomments">
           <?php if (isPluginEnabled('Contests')) { ?>
		<?php $chart_title = __l('Contest Comments');
		  $chart_y_title = __l('Contest Comments');?>
		  <section class="span11 sep">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'contest_comment_data', 'chart_container':'contest_comment_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="contest_comment_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="contest_comment_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($contest_comments_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		   <?php if (isPluginEnabled('ContestFollowers')) { ?>
         <?php $chart_title = __l('Contest Followers');
		  $chart_y_title = __l('Contest Followers'); ?>
          <section class="span11 sep pull-right">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'contest_follower_data', 'chart_container':'contest_follower_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="contest_follower_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="contest_follower_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($contest_follower_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
        </div>

		<div class="row-fluid ver-space" id="contestflag">
		 <?php if (isPluginEnabled('EntryRatings')) { ?>
		<?php $chart_title = __l('Entry Rating');
		  $chart_y_title = __l('Entry Rating'); ?>
		  <section class="span11 sep">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'entry_rating_data', 'chart_container':'entry_rating_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="entry_rating_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="entry_rating_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($entry_rating_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		  <?php if (isPluginEnabled('ContestFlags')) { ?>
         <?php $chart_title = __l('Contest Flags');
		  $chart_y_title = __l('Contest Flags'); ?>
          <section class="span11 sep pull-right">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'contest_flag_data', 'chart_container':'contest_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="contest_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="contest_flag_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($contest_flag_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		  </div>
		  <div class="row-fluid ver-space" id="contestflag">
		  <?php if (isPluginEnabled('EntryFlags')) { ?>
		  <?php $chart_title = __l('Entry Flags');
		  $chart_y_title = __l('Entry Flags'); ?>
          <section class="span11 sep">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'entry_flag_data', 'chart_container':'entry_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="entry_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="entry_flag_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($entry_flag_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
		  <?php if (isPluginEnabled('UserFlags')) { ?>
		  <?php $chart_title = __l('User Flags');
		  $chart_y_title = __l('User Flags'); ?>
          <section class="span11 sep pull-right">
		      <div class="<?php echo $div_class;?> space dc { 'chart_width':'500', 'chart_type':'ColumnChart','data_container':'user_flag_data', 'chart_container':'user_flag_chart<?php echo $role_id; ?>', 'chart_title':'<?php echo $chart_title ;?>', 'chart_y_title': '<?php echo $chart_y_title;?>'}">
              <div class="clearfix">
                <div id="user_flag_chart<?php echo $role_id; ?>" class="admin-dashboard-chart"></div>
                <div class="hide">
                 <table id="user_flag_data" class="table table-striped table-bordered table-condensed">
					<tbody>
					  <?php foreach($user_flag_data as $key => $_data): ?>
					  <tr>
						 <th><?php echo $key; ?></th>
						 <td><?php echo $_data[0]; ?></td>
					  </tr>
					  <?php endforeach; ?>
					</tbody>
					</table>
                </div>
              </div>
            </div>
          </section>
		  <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>