<?php /* SVN: $Id: $ */ ?>
<div class="js-response">
<div class="container-fluid">
  <div class="row space bot-mspace">
    <div class="span  top-smspace dc grayc">
        <?php echo $this->element('paging_counter'); ?>
    </div>
	<div class="span dc pull-right  top-mspace">
	    <span class="hor-mspace">
			<?php echo $this->Html->link('<span><i class="icon-cog"></i></span> <span class="pinkc">' . __l('Settings') . '</span>', array('controller' => 'settings', 'action' => 'plugin_settings', 'VideoResources'), array('class' => 'grayc','title'=>__l('Settings'),'escape' => false)); ?>
        </span>
	</div>
  </div>
  <div class="tab-pane active in no-mar" id="learning">
<?php
	echo $this->Form->create('ContestFlagCategory' , array('class' => 'normal','action' => 'update'));
?>
<?php echo $this->Form->input('r', array('type' => 'hidden', 'value' => $this->request->url)); ?>

<table class="table table-striped table-hover">
	<thead class="yellow-bg">
		<tr>      
			<th rowspan="2" class="actions"><?php echo __l('Actions');?></th>
			<th rowspan="2" class="actions"><?php echo __l('Hosters');?></th>
			<th rowspan="2" class="actions"><?php echo __l('Hoster Type');?></th>
			<th rowspan="2" class="actions"><?php echo __l('Account');?></th>
			<th rowspan="2" class="actions"><?php echo __l('Available Space');?></th>
			<th colspan="3" class="actions"><?php echo __l('Total Usage');?></th>
		</tr>
		<tr>      
			<th class="actions"><?php echo __l('Files');?></th>
			<th class="actions"><?php echo __l('File Size');?></th>
			<th class="actions"><?php echo __l('Errors');?></th>
		</tr>
	</thead>
<?php
$b =1;
foreach ($uploadHosters as $uploadHoster):
?>
<tr <?php if(empty($uploadHoster['UploadHoster']['is_active'])){ echo 'class="disabled"';} ?>>
		<td  class="actions">

			 <div class="dropdown">
        <a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-cog greenc text-20 blackc"></i></a>
            <ul class="dropdown-menu dl arrow">									
                <li><?php echo $this->Html->link('<i class="icon-cog"></i>' . __l('Configuration'), array('controller' => 'upload_hosters', 'action' => 'edit', $uploadHoster['UploadHoster']['upload_service_id']), array('class' => 'edit js-edit', 'title' => __l('Configuration'), 'escape' => false));
							?>
			 </li>
			  <li>
			<?php echo $this->Html->link(($uploadHoster['UploadHoster']['is_active'] ==1)? '<i class="icon-eye-close"></i>' . __l('Inactive'): '<i class="icon-eye-open"></i>' . __l('Active'), array('controller' => 'upload_hosters', 'action'=>'update_status', $uploadHoster['UploadHoster']['id'],'status'=>($uploadHoster['UploadHoster']['is_active'] ==1)? 'inactive': 'active'), array('class' => ($uploadHoster['UploadHoster']['is_active'] ==1)? 'js-confirm js-no-pjax reject': 'js-confirm js-no-pjax active-link', 'title' => ($uploadHoster['UploadHoster']['is_active'] ==1)? __l('Inactive'): __l('Active'), 'escape' => false));?>
			 </li>      
            </ul>
            </div>
		 </td>
		<td class="dl"><?php echo $this->Html->cText($uploadHoster['UploadService']['name']);?> <span class="label label-default"><?php echo $this->Html->cText($uploadHoster['UploadServiceType']['name']);?></span>
		<?php if($uploadHoster['UploadService']['id'] == ConstUploadService::YouTube): ?>
			<i title="<?php echo __l('Warning: YouTube\'s TOS doesn\'t allow commercial usage. So, please be warned about relying on it.');?>" class="icon-warning-sign js-tooltip"></i>
		<?php endif; ?>

		<?php if($uploadHoster['UploadService']['id'] == ConstUploadService::Vimeo && $uploadHoster['UploadServiceType']['id'] == ConstUploadServiceType::Direct): ?>
			<span class="label label-success"><?php echo __l("Recommended"); ?></span><i class="icon-info-sign js-tooltip" title="<?php echo __l('This may save lot of bandwidth as it avoids sending the whole file to our server.');?>"></i>
		<?php endif; ?>

		<?php if($uploadHoster['UploadService']['id'] == ConstUploadService::YouTube && $uploadHoster['UploadServiceType']['id'] == ConstUploadServiceType::Direct): ?>
			<span class="label label-success"><?php echo __l('Recommended');?></span><i class="icon-info-sign js-tooltip" title="<?php echo __l('As officially supported');?>"></i>			 
		<?php endif; ?>	
		
		<?php if($uploadHoster['UploadService']['id'] != ConstUploadService::YouTube && $uploadHoster['UploadServiceType']['id'] == ConstUploadServiceType::Direct): ?> 
                   <p><i class="icon-warning-sign js-tooltip"></i><?php echo $this->Html->link(__l('Agriya Labs candidate'), array('controller'=> 'nodes', 'action'=>'admin_agriya_labs'), array('class' => 'js-colorbox js-tooltip js-no-pjax',  'data-toggle' => 'modal', 'data-target' => '#js-ajax-modal', 'title' => __l('Agriya Labs candidate')));?></p>
		<?php endif; ?>	
		</td>
		<td class="dl"><?php echo $this->Html->cText($uploadHoster['UploadService']['name']);?></td>	
		<td class="dl">
		<?php if($uploadHoster['UploadService']['id'] == ConstUploadService::Vimeo): ?>
				<?php echo configure::read('vimeo_username');?>
		<?php elseif($uploadHoster['UploadService']['id'] == ConstUploadService::YouTube): ?>
				<?php echo configure::read('youtube_username');?>
		<?php endif; ?>
		</td>
		<?php if($b%2 == 1) { ?>
        <td rowspan="2" class="dc"> 
				<?php if($uploadHoster['UploadService']['id'] == ConstUploadService::Vimeo) { ?>
 					<?php
 						$upload_progress_precentage = 0;
 						$finished_class = '';
 						if ($uploadHoster['UploadService']['total_upload_filesize'] > 0 && $uploadHoster['UploadService']['total_quota'] > 0) {
 							$upload_progress_precentage = round(($uploadHoster['UploadService']['total_upload_filesize'] / $uploadHoster['UploadService']['total_quota']*100), 2);
 						}
 						if($upload_progress_precentage > 100) {
 							$upload_progress_precentage = 100;
 							$finished_class = 'status-finished';
 						}
 					?>
 					<p class="progress-bar <?php echo $finished_class; ?>">
 						<span class="progress-status" style="width:<?php echo $upload_progress_precentage; ?>%" title="<?php echo $upload_progress_precentage.'% used'; ?>">&nbsp;</span>
 					</p>
 					<p class="progress-value clearfix">
 						<div><?php echo $this->Html->cInt(($uploadHoster['UploadService']['total_upload_filesize']/(1024*1024*1024))) . " " . __l("GB");?>  / <?php echo $this->Html->cInt(($uploadHoster['UploadService']['total_quota']/(1024*1024*1024))) . " " . __l("GB");?></div>
 					</p>
 					</div>
 				<?php } else {
 						echo __l('N/A');	
 					  }
 				?>

 				</td>
 				<?php } ?>
		<td class="dl">
        	<?php echo $this->Html->link($this->Html->cInt($uploadHoster['UploadHoster']['total_upload_count'], false), array('controller' => 'uploads', 'action' => 'index', 'upload_service_id' => $uploadHoster['UploadService']['id'], 'upload_service_type_id' => $uploadHoster['UploadServiceType']['id']));?>        
        </td>
		<td class="dl"><?php echo $this->Html->cInt($uploadHoster['UploadHoster']['total_upload_filesize']);?></td>
        <?php $b++; ?>
		<td class="dl">
            <?php echo $this->Html->link($this->Html->cInt($uploadHoster['UploadHoster']['total_upload_error_count'], false), array('controller' => 'uploads', 'action' => 'index', 'upload_service_id' => $uploadHoster['UploadService']['id'], 'upload_service_type_id' => $uploadHoster['UploadServiceType']['id'], 'is_error' => 1));?>                    
        </td>
	</tr>
<?php
    endforeach;
?>
</table>
<?php
if (!empty($uploadHosters)):
?>
  <section class="clearfix">
	<div class="span top-mspace pull-left space"> 
    	<span class="grayc"><?php echo __l('Select:'); ?></span> 
    	<?php echo $this->Html->link(__l('All'), '#', array('class' => 'js-admin-select-all','title' => __l('All'))); ?>
		<?php echo $this->Html->link(__l('None'), '#', array('class' => 'js-admin-select-none','title' => __l('None'))); ?>
        <?php echo $this->Html->link(__l('Inactive'), '#', array('class' => 'js-admin-select-pending','title' => __l('Inactive'))); ?>
        <?php echo $this->Html->link(__l('Active'), '#', array('class' => 'js-admin-select-approved','title' => __l('Active'))); ?>
        <span class="hor-mspace">
        	<?php echo $this->Form->input('more_action_id', array('class' => 'js-admin-index-autosubmit', 'label' => false, 'div' => false, 'empty' => __l('-- More actions --'))); ?>
        </span>
    </div>
    <div class="span top-mspace pull-right">
      <div class="pull-right">
        <div class="paging js-pagination"><?php echo $this->element('paging_links'); ?></div>
      </div>
    </div>
	</section>
    <div class="hide">
	    <?php echo $this->Form->submit('Submit'); ?>
    </div>
<?php
endif;
echo $this->Form->end();
?>
<div class="modal hide fade" id="js-ajax-modal">
          <div class="modal-body">
			<?php
				echo $this->Html->image('throbber.gif', array('alt' => __l('[Image: Loading]'), 'title' => __l('Loading')));
			    echo __l('Loading...');
			?>
		  </div>
          <div class="modal-footer"> <a href="#" class="btn js-no-pjax" data-dismiss="modal"><?php echo __l('Close'); ?></a> </div>
        </div>
</div>
</div>
</div>