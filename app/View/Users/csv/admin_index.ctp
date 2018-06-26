<?php
$UserCount = $user->User->find('count', array(
	'conditions' => $conditions,
	'recursive' => -1,
));
$page = ceil($UserCount / 20);
for($i=1;$i<=$page;$i++) {
	$user->request->params['named']['page'] = $i;
    $user->paginate = array(
        'conditions' => $conditions,
		'order' => array(
			'User.id' => 'desc'
		) ,
        'recursive' => -1
    );
	$Users = $user->paginate();
    if (!empty($Users)) {
        $data = array();
        foreach($Users as $key => $User) {
	        $data[]['User'] = array(
            __l('Username') => $User['User']['username'],
            __l('Email') => $User['User']['email'],            
            __l('Login count') => $User['User']['user_login_count']
          	);
			if (isPluginEnabled('Contests')) {
				$contest = array(
					 __l('Created Contests') => $User['User']['contest_count'],					
					 __l('Site Revenue via') . ' ' . Configure::read('contest.contest_holder_alt_name_singular_caps') => $User['User']['total_site_revenue_as_contest_holder'],
					 __l('Entries Posted') => $User['User']['contest_user_count'],
					 __l('Earned Amount') => $User['User']['participant_total_earned_amount'],
					 __l('Site Revenue via') . ' ' . Configure::read('contest.participant_alt_name_plural_caps') => $User['User']['total_site_revenue_as_participant'],
				);
				$data[$key]['User'] = array_merge($data[$key]['User'], $contest);
			}
			if (isPluginEnabled('Wallet')) {
				$wallet= array (
					 __l('Available Balance') => $User['User']['available_wallet_amount']
				);
				$data[$key]['User'] = array_merge($data[$key]['User'], $wallet);
			}
        }
        if ($i == 1) {
            $this->Csv->addGrid($data);
        } else {
            $this->Csv->addGrid($data, false);
        }
    }
}
echo $this->Csv->render(true);
?>