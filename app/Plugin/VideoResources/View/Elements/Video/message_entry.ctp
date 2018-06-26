<?php
	if (!empty($contestUser['ContestUser']['Attachment'][0])) {
		if (!empty($contestUser['ContestUser']['Attachment'][0]['youtube_video_id'])) {
            $video_url = $contestUser['ContestUser']['Attachment'][0]['youtube_thumbnail_url'];
        } else {            
            $video_url = $contestUser['ContestUser']['Attachment'][0]['vimeo_thumbnail_url'];
        }
		if ($type == 'entry') {
            echo $this->Html->link($this->Html->image($video_url, array('width' => Configure::read('thumb_size.slider_thumb.width'), 'height' => Configure::read('thumb_size.slider_thumb.height'), 'title' => '# ' . $contestUser['ContestUser']['entry_no'], 'escape' => false)),array('controller' => 'contest_users', 'action' => 'view', $contestUser['Contest']['slug'],  'entry' => $contestUser['ContestUser']['entry_no']),array('escape' => false));                       
		}
	}
?>