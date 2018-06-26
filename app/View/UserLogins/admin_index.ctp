<?php /* SVN: $Id: admin_index.ctp 1279 2011-05-26 05:07:26Z siva_063at09 $ */ ?>
<div class="js-response">
<?php if(!$this->request->params['isAjax']) {?>
<div class="sep-bot"></div>
<?php } ?>
<div class="hor-space">
  <?php
	$class = (!$this->request->params['isAjax'])?'sep-bot space':'';
	$class2 = (!$this->request->params['isAjax'])?'top-smspace':'';
  ?>
  <div class="row <?php echo $class; ?> bot-mspace">
    <div class="span  <?php echo $class2; ?> dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
	<?php if(!$this->request->params['isAjax']) {?>
    <div class="span pull-right grayc">
      <div class="span hor-mspace">
            <?php echo $this->Form->create('UserLogin' , array('type' => 'get', 'class' => 'form-search no-mar dc','action' => 'index')); ?>
        	<?php echo $this->Form->input('q', array('label' => __l('Keyword'), 'class' => "input-medium hor-smspace search-query span4")); ?>
            <button type="submit" class="btn btn-success textb">Search</button>
            <?php echo $this->Form->end(); ?>
      </div>
	</div>
	<?php } ?>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
    <?php echo $this->Form->create('UserLogin' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <table class="table table-striped table-hover">
	  <thead class="yellow-bg">
        <tr class="sep-top sep-bot">
			<?php if(!$this->request->params['isAjax']) {?>
            <th class="sep-right dc sep-left"><?php echo __l('Select'); ?></th>
			<?php } ?>
            <th class="sep-right dc"><?php echo __l('Actions');?></th>
            <th class="sep-right dc"><div class="js-pagination"><?php echo $this->Paginator->sort('created', __l('Login Time'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', __l('Username'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('Ip.ip', __l('Login IP'));?></div></th>
            <th class="sep-right"><div class="js-pagination"><?php echo $this->Paginator->sort('user_agent', __l('User Agent'));?></div></th>
        </tr>
	  </thead>
	  <tbody>
        <?php
        if (!empty($userLogins)):
            foreach ($userLogins as $userLogin):
                ?>
                <tr>
					<?php if(!$this->request->params['isAjax']) {?>
                    <td class="dc span1"><?php echo $this->Form->input('UserLogin.'.$userLogin['UserLogin']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userLogin['UserLogin']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
					<?php } ?>
                    <td class="dc span1">
                      <div class="dropdown">
						<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
						<ul class="dropdown-menu dl arrow">
							<li><?php echo $this->Html->link('<i class="icon-remove blackc"></i>'.__l('Delete'), array('action' => 'delete', $userLogin['UserLogin']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete'),'escape' => false));?>
								<?php echo $this->Layout->adminRowActions($userLogin['UserLogin']['id']);?>
							</li>
						</ul>
        			  </div>
					</td>
                    <td class="dc"><?php echo $this->Html->cDateTimeHighlight($userLogin['UserLogin']['created']);?></td>
                    <td><?php 
								echo $this->Html->getUserAvatarLink($userLogin['User'], 'micro_thumb',true); ?>
								<span class="hor-smspace">
						<?php
								echo $this->Html->getUserLink($userLogin['User']); ?> </span>
					</td>
                    <td>
					<?php if(!empty($userLogin['Ip']['ip'])): ?>	
						<span class="show">
                            <?php echo  $this->Html->link($userLogin['Ip']['ip'], array('controller' => 'users', 'action' => 'whois', $userLogin['Ip']['ip'], 'admin' => false), array('class' => 'js-no-pjax', 'target' => '_blank', 'title' => 'whois '.$userLogin['Ip']['ip'], 'escape' => false));								
							?>
						</span>
							<?php 					
                            if(!empty($userLogin['Ip']['Country'])):
                                ?>
                                <span class="flags flag-<?php echo strtolower($userLogin['Ip']['Country']['iso_alpha2']); ?>" title ="<?php echo $userLogin['Ip']['Country']['name']; ?>">
									<?php echo $userLogin['Ip']['Country']['name']; ?>
								</span>
                                <?php
                            endif; 
							 if(!empty($userLogin['Ip']['City'])):
                            ?>             
                            <span> 	<?php echo $userLogin['Ip']['City']['name']; ?>    </span>
                            <?php endif; ?>
                        <?php else: ?>
							<?php echo __l('N/A'); ?>
						<?php endif; ?>    
				</td>

                    <td><?php echo $this->Html->cText($userLogin['UserLogin']['user_agent']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="6" class="notice"><i class="icon-warning-sign grayc"></i> <?php echo sprintf(__l('No %s available'), __l('User Logins'));?></td>
            </tr>
            <?php
        endif;
        ?>
	  </tbody>
    </table>

    <?php
    if (!empty($userLogins)) :?>
		<?php if(!$this->request->params['isAjax']) {?>
		<section class="clearfix">
        <div class="span top-mspace pull-left">
			<span class="grayc"><?php echo __l('Select:'); ?></span>
				<?php echo $this->Html->link(__l('All'), '#', array('class' => 'hor-mspace js-admin-select-all','title' => __l('All'))); ?>
				<?php echo $this->Html->link(__l('None'), '#', array('class' =>'js-admin-select-none', 'title' => __l('None'))); ?>
			
			<span class="hor-mspace"><?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div'=>false, 'empty' => __l('-- More actions --'))); ?></span>
		</div>
		
		<div class="hide">
			<?php echo $this->Form->submit('Submit'); ?>
		</div>
		<?php } ?>
		<div class="span top-mspace pull-right">
			<div class="pull-right">
				<?php echo $this->element('paging_links'); ?>
			</div>
		</div>
		</section>
    <?php endif;
    echo $this->Form->end();
    ?>
  </div>
</div>
</div>