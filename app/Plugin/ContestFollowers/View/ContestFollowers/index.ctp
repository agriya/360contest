<?php /* SVN: $Id: admin_index.ctp 801 2009-07-25 13:22:35Z boopathi_026ac09 $ */ ?>
<div class="contestFollowers index js-response">
    <h2><?php echo __l('Followed Contests');?></h2>
    <?php echo $this->element('paging_counter');?>
    <?php echo $this->Form->create('contestFollower' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <table class="list">
        <tr>
            <th class="actions"><?php echo __l('Actions');?></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.slug', __l('Contest Title'));?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('User.username', Configure::read('contest.contest_holder_alt_name_singular_caps'));?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.end_date', __l('Ends'));?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.contest_user_count', __l('Entries'));?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('PricingPackage.name', __l('Package'));?></div></th>
            <th class="dc"><div class="js-pagination"><?php echo $this->Paginator->sort('Contest.winner_user_id', __l('Winner'));?></div></th>
        </tr>
        <?php
        if (!empty($contestFollows)):

            $i = 0;
            foreach ($contestFollows as $contestFollower):
			          $class = null;
                $active_class = '';
                if ($i++ % 2 == 0) :
                   $class = 'altrow';
                endif;
                ?>
             <tr class="<?php echo $class;?>">
                    <td class="actions">
                            <div class="action-block">
                                <span class="action-information-block">
                                    <span class="action-left-block">&nbsp;&nbsp;</span>
                                        <span class="action-center-block">
                                            <span class="action-info">
                                                <?php echo __l('Action');?>
                                             </span>
                                        </span>
                                    </span>
                                    <div class="action-inner-block">
                                    <div class="action-inner-left-block">
                                        <ul class="action-link clearfix">
                                            <li><?php echo $this->Html->link(__l('Following'), array('controller' => 'contest_followers', 'action' => 'delete', 'view'=>'list', $contestFollower['ContestFollower']['id']), array('class' => 'unlike js-confirm js-no-pjax js-unfollow', 'title' => __l('Unfollow')));?></li>
                   					   </ul>
                    				</div>
                    					<div class="action-bottom-block"></div>
                    				  </div>
                          </div>
                    </td>
                    <td class="dc"><?php echo $this->Html->link($this->Html->cText($contestFollower['Contest']['name'], false), array('controller' => 'contests', 'action' => 'view', $contestFollower['Contest']['slug'], 'admin' => false), array('title' => $contestFollower['Contest']['slug'])); ?></td>
					<td class="dl"><?php echo $this->Html->link($this->Html->cText($contestFollower['Contest']['User']['username'], false), array('controller' => 'users', 'action' => 'view', $contestFollower['Contest']['User']['username'], 'admin' => false), array('title' => $contestFollower['Contest']['User']['username'])); ?></td>
                    <td class="dc"><?php echo $contestFollower['Contest']['actual_end_date']; ?></td>
                    <td class="dc"><?php echo $this->Html->cInt($contestFollower['Contest']['contest_user_count']); ?></td>
                    <td class="dc"><?php echo $contestFollower['Contest']['PricingPackage']['name']; ?></td>
                    <td class="dc">
                        <?php if(isset($contestFollower['WinnerUser']['username'])) :
    							echo $contestFollower['WinnerUser']['username'];
    					endif; ?>
                    </td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4"><p class="notice"><?php echo sprintf(__l('No %s available'), __l('followers'));?></p></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    <?php
    if (!empty($contestFollowers)) :
        ?>
        <div class="clearfix select-block-bot">
            	 <div class="admin-select-block grid_left">
                    <div>
                		<?php echo __l('Select:'); ?>
                		<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
                		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
                	</div>
                	<div class="admin-checkbox-button">
                        <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
                    </div>
                </div>
            	<div class="js-pagination">
                    <?php echo $this->element('paging_links'); ?>
                </div>
        </div>
        <div class="hide">
                <?php echo $this->Form->submit('Submit');  ?>
         </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
 
</div>
