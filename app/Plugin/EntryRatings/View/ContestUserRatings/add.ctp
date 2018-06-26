<?php
   $avg_rating = (!empty($contestUser['ContestUser']['contest_user_rating_count'])) ? ($contestUser['ContestUser']['contest_user_total_ratings']/$contestUser['ContestUser']['contest_user_rating_count']) : 0;
    echo  $this->element('_star-rating', array('contest_user_id' => $contestUser['ContestUser']['id'], 'current_rating' => round($avg_rating, 2), 'canRate' => true, 'cache' => array('config' => 'sec')), array('plugin' =>'EntryRatings')); ?>
