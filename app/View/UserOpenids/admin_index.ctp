<?php /* SVN: $Id: $ */ ?>
<div class="userOpenids index js-response">
    <h2><?php echo __l('User Openids');?></h2>
   	<div><?php echo $this->Html->link(__l('Add'), array('action' => 'add'), array('title' => __l('Add')));?></div>
    <?php echo $this->Form->create('UserOpenid' , array('type' => 'get', 'class' => 'normal','action' => 'index')); ?>
	<div class="filter-section">
		<div>
			<?php echo $this->Form->input('q', array('label' => __l('Keyword'))); ?>
		</div>
		<div>
			<?php echo $this->Form->submit(__l('Search'));?>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
    <?php echo $this->Form->create('UserOpenid' , array('class' => 'normal','action' => 'update')); ?>
    <?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>
    <?php echo $this->element('paging_counter');?>
    <table class="list">
        <tr>
            <th><?php echo __l('Select'); ?></th>
            <th class="actions"><?php echo __l('Actions');?></th>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort(__l('Username'), 'User.username');?></div></th>
            <th class="dl"><div class="js-pagination"><?php echo $this->Paginator->sort('openid');?></div></th>
        </tr>
        <?php
        if (!empty($userOpenids)):
            $i = 0;
            foreach ($userOpenids as $userOpenid):
                $class = null;
                if ($i++ % 2 == 0) :
                    $class = ' class="altrow"';
                endif;
                ?>
                <tr<?php echo $class;?>>
                    <td><?php echo $this->Form->input('UserOpenid.'.$userOpenid['UserOpenid']['id'].'.id', array('type' => 'checkbox', 'id' => "admin_checkbox_".$userOpenid['UserOpenid']['id'], 'label' => false, 'class' => 'js-checkbox-list')); ?></td>
                    <td class="actions"><span><?php echo $this->Html->link(__l('Delete'), array('action' => 'delete', $userOpenid['UserOpenid']['id']), array('class' => 'delete js-confirm js-no-pjax', 'title' => __l('Delete')));?></span></td>
                    <td class="dl"><?php echo $this->Html->link($this->Html->cText($userOpenid['User']['username']), array('controller'=> 'users', 'action'=>'view', $userOpenid['User']['username'], 'admin' => false), array('escape' => false));?></td>
                    <td class="dl"><?php echo $this->Html->cText($userOpenid['UserOpenid']['openid']);?></td>
                </tr>
                <?php
            endforeach;
        else:
            ?>
            <tr>
                <td colspan="4" class="notice"><?php echo sprintf(__l('No %s available'), __l('User Openids'));?></td>
            </tr>
            <?php
        endif;
        ?>
    </table>
    <?php
    if (!empty($userOpenids)) :
        ?>
        <div>
            <?php echo __l('Select:'); ?>
            <?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all')); ?>
            <?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none')); ?>
        </div>
        <div class="js-pagination">
            <?php echo $this->element('paging_links'); ?>
        </div>
        <div class="admin-checkbox-button">
            <?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'empty' => __l('-- More actions --'))); ?>
        </div>
        <div class=hide>
            <?php echo $this->Form->submit('Submit');  ?>
        </div>
        <?php
    endif;
    echo $this->Form->end();
    ?>
</div>