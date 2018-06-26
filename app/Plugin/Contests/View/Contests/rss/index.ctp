<?php /* SVN: $Id: index.ctp 12757 2010-07-09 15:01:40Z jayashree_028ac09 $ */ ?>
  <?php if(!empty($contests)): ?>
      <?php
        foreach($contests as $contest):
			echo $this->Rss->item(array() , array(
				'title' => $contest['Contest']['name'],
				'link' => array(
					'controller' => 'contests',
					'action' => 'view',
					$contest['Contest']['slug']
				) ,
				'description' => $contest['Contest']['description']
			));
        endforeach;
      ?>
  <?php endif; ?>
