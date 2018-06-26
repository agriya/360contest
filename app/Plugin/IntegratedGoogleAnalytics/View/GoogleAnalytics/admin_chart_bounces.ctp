          <?php
            if ($pageviews_percentage > 0) {
              $pageviews_color = '#459D1C';
            } elseif ($pageviews_percentage == 0) {
              $pageviews_color = '#757575';
            } elseif ($pageviews_percentage < 0) {
              $pageviews_color = '#BA1E20';
            }
            if ($visitors_percentage > 0) {
              $visitors_color = '#459D1C';
            } elseif ($visitors_percentage == 0) {
              $visitors_color = '#757575';
            } elseif ($visitors_percentage < 0) {
              $visitors_color = '#BA1E20';
            }
            if ($bounce_rate_percentage < 0) {
              $bounce_rate_color = '#459D1C';
            } elseif ($bounce_rate_percentage == 0) {
              $bounce_rate_color = '#757575';
            } elseif ($bounce_rate_percentage > 0) {
              $bounce_rate_color = '#BA1E20';
            }
          ?>
            <div class="row">
			  <?php  if($this->request->params['named']['from_section']=='bounces') {?>
				<div class="span24 dc space no-mar pr">
					<div class="span6">
						<div class="btn dc show span8" >
						 <div style="display: none; visbility:hidden;">
							<div class="js-line-chart {'colour':'<?php echo $bounce_rate_color; ?>'}"><?php echo $bounces; ?></div>
						</div>
						  <div class="textb" style="color:<?php echo $bounce_rate_color; ?>"><?php echo $bounce_rate_percentage . '%'; ?></div>
						</div>
						<div class="dc show ">
						  <h2><?php echo $total_bounces; ?></h2>
						  <h5><?php echo __l('Bounces'); ?></h5>
						</div>
					</div>
					<div class="alert alert-info span16"> <?php echo __l('Bounce Rate is the percentage of single-page visits (i.e. visits in which the person left your site from the entrance page without interacting with the page).');?></div>
              </div>
			  <?php } else {?>
              <div class="span8 dc space no-mar pr">
                <div class="btn dc show span8">
					<div style="display: none; visbility:hidden;">
                  <div class="js-line-chart {'colour':'<?php echo $pageviews_color; ?>'}"><?php echo $pageviews; ?></div>
				  </div>
                  <div class="textb" style="color:<?php echo $pageviews_color; ?>"><?php echo $pageviews_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_pageviews; ?></h2>
                  <h5><?php echo __l('Page Views'); ?></h5>
                </div>
              </div>
              <div class="span8 dc space no-mar pr">
                <div class="btn dc show span8">
				 <div style="display: none; visbility:hidden;">
                  <div class="js-line-chart {'colour':'<?php echo $visitors_color; ?>'}"><?php echo $visitors; ?></div>
				  </div>
                  <div class="textb" style="color:<?php echo $visitors_color; ?>"><?php echo $visitors_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_visitors; ?></h2>
                  <h5><?php echo __l('Visitors'); ?></h5>
                </div>
              </div>
			  <?php  if($this->request->params['named']['from_section']=='traffic') {?>
			  <span class="alert alert-info span8 dl"> <?php echo __l('Pageviews is the total number of pages viewed. Repeated views of a single page are counted.');?></span>
			  <?php }?>

			  <?php  if($this->request->params['named']['from_section']!='traffic') {?>
              <div class="span8 dc space no-mar pr">
                <div class="btn dc show span8">
				 <div style="display: none; visbility:hidden;">
                  <div class="js-line-chart {'colour':'<?php echo $bounce_rate_color; ?>'}"><?php echo $bounces; ?></div>
				  </div>
                  <div class="textb" style="color:<?php echo $bounce_rate_color; ?>"><?php echo $bounce_rate_percentage . '%'; ?></div>
                </div>
                <div class="dc show span16">
                  <h2><?php echo $total_bounces; ?></h2>
                  <h5><?php echo __l('Bounces'); ?></h5>
                </div>
              </div>
			<?php } }?>
            </div>