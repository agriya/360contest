<?php
	$display_none_arr=array('') ;
	$display_block_arr=array('') ;
	$none_height_style=array('');

	$cids = array('');
	if(!empty($_GET['cids'])){$cids=$_GET['cids']; $cids=explode(',', $cids);}
	
	$cuids = array('');
	if(!empty($_GET['cuids'])){$cuids=$_GET['cuids']; $cuids=explode(',', $cuids);}
	
	$uids = '';
	if(!empty($_GET['uids'])){$uids=$_GET['uids'];}
	
	$from = '';
	if(!empty($_GET['from'])){$from=$_GET['from'];}

	//--Contest follow starts here--//
	if(!empty($_GET['cids'])) {
		if (isPluginEnabled('ContestFollowers')) {
			$fid[] = '';
			if($this->Auth->user('id')) {
				foreach ($followingcontestIds as $followingcontest) {
					$fid[] = $followingcontest['ContestFollower']['contest_id'];
				}
			}
			for($i=0;$i<count($cids); $i++) {
				if(!$this->Auth->user('id')) {
					$display_none_arr[] = 'alc-f-' . $cids[$i];
					$display_none_arr[] = 'aloc-f-'.$cids[$i];
					$display_none_arr[] = 'alc-uf-'.$cids[$i];
					$display_block_arr[] = 'blc-f-'.$cids[$i];
				} else {
					$display_none_arr[] = 'blc-f-' . $cids[$i];
					foreach($ownContestIds as $ownContestId) {
						if ((isPluginEnabled('SocialMarketing')) && ($from=='contest_view') && $ownContestId['Contest']['user_id'] == $this->Auth->user('id')){
							$display_none_arr[] = 'alc-f-' . $cids[$i];
							if (!in_array($cids[$i], $fid)) {
								$display_block_arr[] = 'aloc-f-' . $cids[$i];
								$display_none_arr[] = 'alc-uf-' . $cids[$i];
							} else {
								$display_none_arr[] = 'alc-uf-' . $cids[$i];
								$display_block_arr[] = 'aloc-f-' . $cids[$i];
							}
						} else {
							$display_none_arr[] = 'aloc-f-' . $cids[$i];
							if (!in_array($cids[$i],(array)$fid)) {
								$display_block_arr[] = 'alc-f-' . $cids[$i];
								$display_none_arr[] = 'alc-uf-' . $cids[$i];
							} else {
								$display_block_arr[] = 'alc-uf-' . $cids[$i];
								$display_none_arr[] = 'alc-f-' . $cids[$i];
							}
						}
					}
				}
			}
		}
		for($i=0;$i<count($cids); $i++) {
			foreach($ownContestIds as $ownContestId) {
				if($ownContestId['Contest']['contest_status_id'] == ConstContestStatus::Open && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $ownContestId['Contest']['user_id'] == $this->Auth->user('id'))) {
					if((!empty($ownContestId['ContestType']['is_private']) && empty($ownContestId['Contest']['is_blind'])) || (!empty($ownContestId['ContestType']['is_private']) && empty($ownContestId['Contest']['is_private'])) || (!empty($ownContestId['ContestType']['is_featured']) && empty($ownContestId['Contest']['is_featured'])) || (!empty($ownContestId['ContestType']['is_highlight']) && empty($ownContestId['Contest']['is_highlight']))) {
						$display_block_arr[] = 'alc-ugf-'. $cids[$i];
					}
					$display_block_arr[] = 'alc-et-'. $cids[$i];
				} else {
					$display_none_arr[] = 'alc-ugf-'. $cids[$i];
					$display_none_arr[] = 'alc-et-'. $cids[$i];
				}
			}
		}
	}
	//--Contest follow ends here--//
	
	//--user follow starts here--//
	if(!empty($_GET['uids'])) {
		if($this->Auth->user('id')) {
			$uid[] = '';
			foreach ($followinguserIds as $followinguser) {
				$uid[] = $followinguser['UserFavorite']['user_favorite_id'];
			}
			$uid = implode(',', $uid);
			$uid = explode(',', $uid);
		}
		if(!$this->Auth->user('id')) {
			$display_block_arr[] = 'blu-f-'.$uids;
			$display_none_arr[] = 'alu-f-'.$uids;
			$display_none_arr[] = 'alu-uf-'.$uids;
		} else {
			$display_none_arr[] = 'blu-f-'.$uids;
			if($this->Auth->user('id') == $uids) {
				$display_none_arr[] = 'alu-f-'.$uids;
				$display_none_arr[] = 'alu-uf-'.$uids;
			} else {
				if (!in_array($uids, $uid)) {
					$display_block_arr[] = 'alu-f-'.$uids;
					$display_none_arr[] = 'alu-uf-'.$uids;
				} else {
					$display_none_arr[] = 'alu-f-'.$uids;
					$display_block_arr[] = 'alu-uf-'.$uids;
				}
			}
		}
	}
	//--user follow ends here--//
	
	//--Contest report flag--//
		if(!empty($_GET['cids'])) {
			foreach($ownContestIds as $ownContestId) {
				if($this->Auth->user('id')) {
					if($ownContestId['Contest']['contest_status_id'] < ConstContestStatus::Judging && $ownContestId['Contest']['user_id'] != $this->Auth->user('id') && (strtotime($ownContestId['Contest']['actual_end_date']) -strtotime('now') > 0)) {
						$display_block_arr[] = 'alc-se-'. $ownContestId['Contest']['id'];
					}
					if($ownContestId['Contest']['user_id'] != $this->Auth->user('id')) {
						$display_block_arr[] = 'alc-rf-'. $ownContestId['Contest']['id'];
					}
				} else {
					$display_none_arr[] = 'alc-rf-'. $ownContestId['Contest']['id'];
					$display_block_arr[] = 'alc-se-'. $ownContestId['Contest']['id'];
				}
			}			
		}
	//--Contest report flag--//
	
	//--admin user and contest control panel start here--//
	if ($this->Auth->sessionValid() && $this->Auth->user('role_id') == ConstUserTypes::Admin) {
		$display_block_arr[] = 'alab';
	} else {
		$display_none_arr[] = 'alab';
	}
	//--admin user and contest control panel ends here--//
	
	//ContestUser report, rating and action block start here //
	if(!empty($_GET['cuids'])) {
		if (isPluginEnabled('EntryRatings')) {
			$rid[]=array('');
			if($this->Auth->user('id')) {
				foreach ($ratedConntestUserIds as $ratedConntestUser) {
					$rid[]=$ratedConntestUser['ContestUserRating']['contest_user_id'];
				}
			}
		}
		foreach($ownContestUsers As $contestUser) {
			if($this->Auth->user('id')) {
				if($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')){
					$display_none_arr[] = 'alcu-ra-'. $contestUser['ContestUser']['id'];
					$display_none_arr[] = 'blcu-ra-'. $contestUser['ContestUser']['id'];
				} else { 
					$display_block_arr[] = 'alcu-ra-'. $contestUser['ContestUser']['id'];
					$display_none_arr[] = 'blcu-ra-'. $contestUser['ContestUser']['id'];
				}
				if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) {
					if(($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
						$display_block_arr[] = 'alcu-w-'. $contestUser['ContestUser']['id'];
					} else {
						$display_none_arr[] = 'alcu-w-'. $contestUser['ContestUser']['id'];
					}
					if(($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin){
						$display_block_arr[] = 'alcu-e-'. $contestUser['ContestUser']['id'];
					} else {
						$display_none_arr[] = 'alcu-e-'. $contestUser['ContestUser']['id'];
					}
				} else {
					$display_none_arr[] = 'alcu-w-'. $contestUser['ContestUser']['id'];
					$display_none_arr[] = 'alcu-e-'. $contestUser['ContestUser']['id'];
				}
				if(($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed || ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::PaidToParticipant)) && $contestUser['ContestUser']['contest_user_status_id'] != ConstContestUserStatus::Withdrawn && ($this->Auth->user('role_id') == ConstUserTypes::Admin || $contestUser['Contest']['user_id'] == $this->Auth->user('id')) && $contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Won) {
					$display_block_arr[] = 'alcu-d-'. $contestUser['ContestUser']['id'];
				} else {
					$display_none_arr[] = 'alcu-d-'. $contestUser['ContestUser']['id'];
				}
				if (empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['ContestUser']['user_id'] == $this->Auth->user('id') && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed) {
					$display_block_arr[] = 'alcu-ued-'. $contestUser['ContestUser']['id'];
				} else {
					$display_none_arr[] = 'alcu-ued-'. $contestUser['ContestUser']['id'];
				}
				if (!empty($contestUser['Contest']['is_uploaded_entry_design']) && $contestUser['Contest']['user_id'] == $this->Auth->user('id') && $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Completed) {
					$display_block_arr[] = 'alcu-ded-'. $contestUser['ContestUser']['id'];
					$display_block_arr[] = 'alcu-arued-'. $contestUser['ContestUser']['id'];
				} else {
					$display_none_arr[] = 'alcu-ded-'. $contestUser['ContestUser']['id'];
					$display_none_arr[] = 'alcu-arued-'. $contestUser['ContestUser']['id'];
				}
				if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Active && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging || $contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open) && $contestUser['ContestUser']['contest_user_status_id'] != ConstContestUserStatus::Withdrawn) {
					if(($contestUser['Contest']['user_id'] == $this->Auth->user('id') && ($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Open ||	($contestUser['Contest']['contest_status_id'] == ConstContestStatus::Judging && empty($contestUser['Contest']['is_pending_action_to_admin'])))) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
						$display_block_arr[] = 'alcu-sw-'. $contestUser['ContestUser']['id'];
					} else {
						$display_none_arr[] = 'alcu-sw-'. $contestUser['ContestUser']['id'];
					}
				} else {
					$display_none_arr[] = 'alcu-sw-'. $contestUser['ContestUser']['id'];
				}
				if($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Withdrawn && empty($contestUser['Contest']['winner_user_id'])){
					if(($contestUser['ContestUser']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin){
						$display_block_arr[] = 'alcu-cw-'. $contestUser['ContestUser']['id'];
					} else {
						$display_none_arr[] = 'alcu-cw-'. $contestUser['ContestUser']['id'];
					}
				} else {
					$display_none_arr[] = 'alcu-cw-'. $contestUser['ContestUser']['id'];
				}
				if ($contestUser['ContestUser']['contest_user_status_id'] == ConstContestUserStatus::Eliminated && empty($contestUser['Contest']['winner_user_id'])) {
					if(($contestUser['Contest']['user_id'] == $this->Auth->user('id')) || $this->Auth->user('role_id') == ConstUserTypes::Admin) {
						$display_block_arr[] = 'alcu-ce-'. $contestUser['ContestUser']['id'];
					} else {
						$display_none_arr[] = 'alcu-ce-'. $contestUser['ContestUser']['id'];
					}
				} else {
					$display_none_arr[] = 'alcu-ce-'. $contestUser['ContestUser']['id'];
				}
				if (in_array($contestUser['Contest']['contest_status_id'], array(ConstContestStatus::WinnerSelected, ConstContestStatus::ChangeCompleted)) && empty($contestUser['Contest']['is_pending_action_to_admin']) && $contestUser['ContestUser']['contest_user_status_id']== ConstContestUserStatus::Won) {
					if(($contestUser['Contest']['user_id'] == $this->Auth->user('id') &&  empty($contestUser['Contest']['is_pending_action_to_admin'])) || ($this->Auth->user('role_id') == ConstUserTypes::Admin)) {
						$display_block_arr[] = 'alcu-amc-'. $contestUser['ContestUser']['id'];
					} else {
						$display_none_arr[] = 'alcu-amc-'. $contestUser['ContestUser']['id'];
					}
				} else {
					$display_none_arr[] = 'alcu-amc-'. $contestUser['ContestUser']['id'];
				}
				if (isPluginEnabled('EntryRatings')) {
					$display_none_arr[] = 'blcu-vr-' . $contestUser['ContestUser']['id'];
					if (!in_array($contestUser['ContestUser']['id'], $rid)) {
						$display_block_arr[] = 'alcu-r-' . $contestUser['ContestUser']['id'];
						$display_none_arr[] = 'alcu-vr-' . $contestUser['ContestUser']['id'];
					} else {
						$display_block_arr[] = 'alcu-vr-' . $contestUser['ContestUser']['id'];
						$display_none_arr[] = 'alcu-r-' . $contestUser['ContestUser']['id'];
					}
				}
			} else {
				$display_none_arr[] = 'alcu-ra-'. $contestUser['ContestUser']['id'];
				$display_block_arr[] = 'blcu-ra-'. $contestUser['ContestUser']['id'];
				//rating
				if (isPluginEnabled('EntryRatings')) {
					$display_none_arr[] = 'alcu-vr-'.$contestUser['ContestUser']['id'];
					$display_none_arr[] = 'alcu-r-'.$contestUser['ContestUser']['id'];
					$display_block_arr[] = 'blcu-vr-'.$contestUser['ContestUser']['id'];
				}
			}
		}		
	}
	//ContestUser report, rating and action block end here //
	

	$none_style=implode(', .',$display_none_arr);
	$none_style_height=implode(', .',$display_none_arr);
	$none_style = substr($none_style, 1); //to remove 1st ',' from the array
	$none_style_height = substr($none_style_height, 1); //to remove 1st ',' from the array
	$none_style=$none_style.' { display: none; }';
	$none_height_style=$none_style_height.' { height: 0px; }';

	$block_style=implode(', .',$display_block_arr);
	$block_style = substr($block_style, 1); //to remove 1st ',' from the array
	$block_style=$block_style.' { display: block; }';


	echo preg_replace('/(\>)\s+(<?)/', '$1$2', $block_style);
	echo preg_replace('/(\>)\s+(<?)/', '$1$2', $none_style);
	echo preg_replace('/(\>)\s+(<?)/', '$1$2', $none_height_style);
?>