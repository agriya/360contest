<?php /* SVN: $Id: index_list.ctp 99 2008-07-09 09:33:42Z rajesh_04ag02 $ */ ?>
<div class="aclLinks index js-response">
<div class="clearfix">
    <div class="grid_left">
      <?php echo $this->element('paging_counter');?>
    </div>
    <div class="grid_right">
        <?php 
			echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add New Acl Link'), 'class' => 'add'));
			echo $this->Html->link(__l('Generate Actions'), array('action' => 'generate'), array('title' => __l('It will generate actions from file structure'), 'class' => 'js-generate add'));
		?>
    </div>    		
   </div>
      
        <table class="list">
            <tr>                
				<th class="actions"><?php echo __l('Actions'); ?></th>
				<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('name'); ?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('controller'); ?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('action'); ?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('named_key'); ?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('named_value'); ?></div></th>
				<th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('pass_value'); ?></div></th>
            </tr>
            <?php
                if (!empty($aclLinks)):
                $i = 0;
                    foreach ($aclLinks as $aclLink):
                        $class = null;
                        if ($i++ % 2 == 0) :
                            $class = ' class="altrow"';
                        endif;                        
                        ?>
                        <tr<?php echo $class;?>>                            
							<td class="actions">
                       		<div class="action-block">
        						<span class="action-information-block">
        							<span class="action-left-block">&nbsp;
        							</span>
        							<span class="action-center-block">
        								<span class="action-info">
        									<?php echo __l('Action');?>
        								</span>
        							</span>
        						</span>
        						<div class="action-inner-block">
        							<div class="action-inner-left-block">
        								<ul class="action-link clearfix">
        									<li><?php echo $this->Html->link(__l('Edit'), array('action'=>'edit', $aclLink['AclLink']['id']), array('class' => 'edit js-edit', 'title' => __l('Edit')));?></li>
							             	<li><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $aclLink['AclLink']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></li>
        								</ul>
        							</div>
        							<div class="action-bottom-block"></div>
        						</div>
        					</div>
     						</td>
							<td class="dl"><?php echo $this->Html->cText($aclLink['AclLink']['name']);?></td>
							<td class="dl"><?php echo $this->Html->cText($aclLink['AclLink']['controller']);?></td>
							<td class="dl"><?php echo $this->Html->cText($aclLink['AclLink']['action']);?></td>
							<td class="dl"><?php echo $this->Html->cBool($aclLink['AclLink']['named_key']);?></td>
							<td class="dl"><?php echo $this->Html->cBool($aclLink['AclLink']['named_value']);?></td>
							<td class="dl"><?php echo $this->Html->cBool($aclLink['AclLink']['pass_value']);?></td>
                        </tr>
                        <?php
                    endforeach;
            else:
                ?>
                <tr>
                    <td class="notice" colspan="7"><?php echo sprintf(__l('No %s available'), __l('Acl Links'));?></td>
                </tr>
                <?php
            endif;
            ?>
        </table>
        <?php
         if (!empty($aclLinks)) : ?>
         <div class="clearfix">
			<div class="js-pagination grid_right">
				<?php echo $this->element('paging_links'); ?>
			</div>			
        </div>
            <?php
         endif; ?>
        <?php echo $this->Form->end();?>

</div>
