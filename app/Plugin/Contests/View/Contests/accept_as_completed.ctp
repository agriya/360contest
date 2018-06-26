<div class="clearfix contest-view-block">
	<div class = "ver-space">
	<div class="modal-header">
        <button type="button" class="close js-no-pjax" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h2 id="js-modal-heading"><?php echo $contest['Contest']['name']; ?></h2>
	</div> 
		<div class = "thumbnail">
			<div class="ver-space">
				<h3> <?php echo sprintf(__l('%s Uploaded Files'), Configure::read('contest.participant_alt_name_singular_caps')); ?> </h3>
				<div class="space clearfix">
				 <table class="table table-striped table-hover">
				 <tr>
				 	 <th class="dl"><?php echo __l('Filename');?></th>
					 <th class="dl"><?php echo __l('Size');?></th>
				 </tr>
				 <?php
				
					if(!empty($files)) {
				 ?>
				 <?php
						foreach($files as $file) {
						?>
						<tr>
							<td class="dl"><?php echo str_replace($dir_path . DS ,'',$file['name']); ?></td>
							<td class="dl"><?php echo bytes_to_higher($file['size']); ?></td>
						</tr>
						<?php
						}
				 ?>
				 <?php
					} else {
				 ?>
						<td colspan="2">
							<div class="thumbnail space dc grayc">
								<p class="ver-mspace top-space text-16"><?php echo sprintf(__l('No %s available'), __l('Files'));?></p>
							</div>
						</td>
				 <?php
				 	}
				 ?>
				 </table>
				 </div>
				<div class="submit-block clearfix">
				<div class="submit">
					<?php if($contest['Contest']['contest_status_id'] != ConstContestStatus::Completed) { 
						echo $this->Html->link(__l('Accept and Download'), array('controller' => 'contests', 'action'=>'update', 'status_id'=>ConstContestStatus::Completed,$contest['Contest']['id']), array('class' => 'btn btn-success js-accept_download js-no-pjax', 'title' => __l('Download'), 'escape' => false));
					?>
					<?php 
						echo $this->Html->link(__l('Reupload Entry Design'), array('controller' => 'contests', 'action'=>'reupload_entry_design', $contest['Contest']['id'],$contest['Contest']['slug']), array('class' => 'btn btn-success js-no-pjax', 'title' => __l('Reupload Entry Design'), 'escape' => false));
					} else {

						echo $this->Html->link(__l('Download'), array('controller' => 'contests', 'action'=>'download_entry', $contest['Contest']['id'],$contest['EntryAttachment']['id']), array('class' => 'btn btn-success js-accept_download js-no-pjax', 'title' => __l('Download'), 'escape' => false));
					}
					?>
				</div>        
			</div>
			 </div>
			
		</div>
	</div>
</div>