<?php /* SVN: $Id: view.ctp 4973 2010-05-15 13:14:27Z aravindan_111act10 $ */ ?>
<div class="users view clearfix dashboard-vierw-block">
	<div class="container">
		<h2 class="ver-space ver-mspace"> <?php echo __l('Dashboard') ?> </h2>
	</div>
<?php echo $this->element('user-avatar', array('cache' => array('config' => 'sec', 'key' => $this->Auth->user('id')))); ?>
<div class="container">
<div class=" top-space ver-mspace">
		<?php
	$url= array(
		'controller' => 'contests',
		'action' => 'index',
	);
  $url['type'] = 'mycontest';
    ?>
     <div class="clearfix">
     <div class="dashboard-title-block">
         <div class="overview-tl">
               <div class="overview-tr">
                 <div class="overview-tc">
                </div>
             </div>
    		</div>
    		<div class="overview-center clearfix sep-bot ver-space ver-mspace">
        	       <h3 class="contest-title textn"><?php echo Configure::read('contest.contest_holder_alt_name_singular_caps');?></h3>
        	</div>
        	 <div class="overview-bl">
               <div class="overview-br">
                 <div class="overview-bc">
                </div>
             </div>
    		</div>
    	</div>
 
        	<?php echo $this->element('contest-status-chart', array('is_admin' => 0, 'cache' => array('config' => 'sec')));?>
  
    </div>
        <div class="dashboard-title-block">
         <div class="overview-tl">
                       <div class="overview-tr">
                         <div class="overview-tc">
                        </div>
             </div>
    		</div>
    		<div class="overview-center clearfix sep-bot ver-space ver-mspace">
        	       <h3 class="contest-title textn"><?php echo Configure::read('contest.participant_alt_name_singular_caps');?></h3>
        	</div>
        	 <div class="overview-bl">
               <div class="overview-br">
                 <div class="overview-bc">
                </div>
             </div>
    		</div>
    	</div>
    <div class="clearfix span24 no-mar">
 
	  <?php echo $this->element('entry-status-chart', array('is_admin' => 0, 'cache' => array('config' => 'sec')));?>
 	
       <div class="pull-right offset span9 ver-mspace">
       <table class="table table-striped sep">
			<tr>
				<th colspan="1">&nbsp;</th>
				<?php foreach($periods as $key => $period){ ?>
				<th>
					<?php echo $period['display']; ?>
				</th>
				<?php } ?>
			</tr>
			<?php
			foreach($models as $unique_model){ ?>
				<?php foreach($unique_model as $model => $fields){
					$aliasName = isset($fields['alias']) ? $fields['alias'] : $model;
				?>
						<?php $element = isset($fields['colspan']) ? 'rowspan ="'.$fields['colspan'].'"' : ''; ?>

					<?php if(!isset($fields['isSub'])) :?>
							<tr>
							<td class="sub-title">
								<?php echo $fields['display']; ?>
							</td>
						<?php endif;?>

						<?php if(!isset($fields['colspan'])) :?>
							<?php foreach($periods as $key => $period){ ?>
									<td>
										<span class="<?php echo (!empty($fields['class']))? $fields['class'] : ''; ?>">
											<?php
                                           			if($fields['alias']=='Transaction') {
													$fields['type'] = 'cCurrency';
												     }else{
                                                     $fields['type'] = 'cInt';
                                                     }
												if (!empty($fields['link'])):
													$fields['link']['stat'] = $key;
													echo $this->Html->link($this->Html->{$fields['type']}(${$aliasName.$key}), $fields['link'], array('escape' => false, 'title' => __l('Click to View Details')));
												else:
													echo $this->Html->{$fields['type']}(${$aliasName.$key});
												endif;
											?>
										</span>
									</td>
							<?php } ?>
							</tr>
						<?php endif; ?>

				 <?php } ?>
			<?php } ?>
			</table>
       
    </div>
    </div>
</div>
</div>
</div>