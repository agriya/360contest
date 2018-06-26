<div class="mspace">
<div class="row-fluid ver-space ver-mspace">
  <article id="accordion2" class="span18 accordion">
						<?php echo $this->element('admin-charts-stats', array('cache' => array('config' => 'sec'))); ?>
  </article>
  <aside class="span6">
		<section class="thumbnail no-pad top-mspace bot-mspace sep">
            <div class="no-mar no-bor  clearfix box-head space sep-bot">
              <h5><i class="icon-time pinkc no-bg"></i><?php echo __l('Timings'); ?></h5>
            </div>
            <section>
              <ul class="unstyled space">
										<li><i class="icon-angle-right blackc"></i><?php $title = ' title="' . strftime(Configure::read('site.datetime.tooltip') , strtotime('now')) . '"'; ?>
										<?php echo __l('Current time: '); ?><span <?php echo $title; ?>><?php echo strftime(Configure::read('site.datetime.format')); ?></span>
										</li>
										<li><i class="icon-angle-right blackc"></i><?php echo __l('Last login: '); ?><?php echo $this->Html->cDateTimeHighlight($this->Auth->user('last_logged_in_time')); ?>
										</li>
									</ul>
            </section>
          </section>
		  <section class="thumbnail no-pad top-mspace bootstro" data-bootstro-step="13" data-bootstro-content="<?php echo __l("It list the actions that admin need to take. Action such as users/contests waiting for approval, cancel the contest/ clear the contest flag of flagged contests, withdraw request waiting for approval and also affiliate withdraw request.");?>" data-bootstro-placement='left' data-bootstro-title="Action to be taken">
						<?php echo $this->element('contest-admin_action_taken', array('cache' => array('config' => 'site_element_cache_5_hours')),array('plugin' => 'Contests')); ?>
			</section>
						
						
						<?php echo $this->element('users-admin_recent_users', array('cache' => array('config' => 'site_element_cache_5_hours'))); ?>
						
			<section class="thumbnail no-pad top-mspace sep">
            <div class="no-mar no-bor clearfix box-head space sep-bot">
              <h5 class="pull-left"><i class="icon-user pinkc no-bg"></i> <?php echo __l('360Contest'); ?></h5>
            </div>
            <section>
              <div class="hor-space top-mspace"><span class="textb blackc">
				<?php echo __l('Version').' ' ?>
				</span><?php echo Configure::read('site.version'); ?></div>
				<ul class="unstyled space">
					<li><i class="icon-angle-right blackc"></i>
										<?php echo $this->Html->link(__l('Product Support'), 'http://customers.agriya.com/', array('target' => '_blank', 'title' => __l('Product Support'))); ?>
										</li>
										<li><i class="icon-angle-right blackc"></i>
										<?php echo $this->Html->link(__l('Product Manual'), 'http://dev1products.dev.agriya.com/doku.php?id=360Contest' ,array('target' => '_blank','title' => __l('Product Manual'))); ?>
										</li>
										<li><i class="icon-angle-right blackc"></i>
										<?php echo $this->Html->link(__l('CSSilize'), 'http://www.cssilize.com/', array('target' => '_blank', 'title' => __l('CSSilize'))); ?>
										<span class="sfont"><?php echo __l('PSD to XHTML Conversion and 360Contest theming');?></span>
										</li>
										<li><i class="icon-angle-right blackc"></i>
										<?php echo $this->Html->link(__l('Agriya Blog'), 'http://blogs.agriya.com/' ,array('target' => '_blank','title' => __l('Agriya Blog'))); ?>
										<span class="sfont"><?php echo __l('Follow Agriya news');?></span>
										</li>
										<li class="grayc"><a href="#" class="btn btn-primary js-live-tour js-no-pjax"><?php echo __l('Live Tour'); ?></a> </li>
									</ul>
            </section>
          </section>
        </aside>
      </div>
      </div>
