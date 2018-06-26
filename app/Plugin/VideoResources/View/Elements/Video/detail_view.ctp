<?php if (!empty($contestUser)): ?>
	<?php if(!empty($contestUser['youtube_video_id'])) { ?>
		<?php $video_id = $contestUser['youtube_video_id']; ?>
		<iframe width="480px" height="360px" src="http://www.youtube-nocookie.com/embed/<?php echo $video_id;?>?rel=0&showinfo=0" frameborder="0" allowfullscreen></iframe>
	<?php } elseif (!empty($contestUser['vimeo_video_id'])) { ?>
		<?php $video_id = $contestUser['vimeo_video_id']; ?>
		<iframe src="http://player.vimeo.com/video/<?php echo $video_id;?>" width="480px" height="360px" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
	<?php } ?>
<?php endif; ?>