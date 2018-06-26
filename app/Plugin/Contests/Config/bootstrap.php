<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360Contest
 * @subpackage Core
 * @author     Agriya <info@agriya.com>
 * @copyright  2018 Agriya Infoway Private Ltd
 * @license    http://www.agriya.com/ Agriya Infoway Licence
 * @link       http://www.agriya.com
 */
require_once 'constants.php';
CmsNav::add('Contests', array(
    'title' => 'Contests',
    'url' => array(
        'controller' => 'contests',
        'action' => 'index',
    ) ,
	'data-bootstro-step' => "4",
    'data-bootstro-content' => __l("To monitor the summary, price point statistics of site and also to manage all contest posted in the site.") ,
    'weight' => 30,
    'icon-class' => 'icon-trophy',
    'children' => array(
        'Contests' => array(
            'title' => __l('Contests') ,
            'url' => array(
                'controller' => 'contests',
                'action' => 'index',
                'filter_id' => ConstContestStatus::Open
            ) ,
            'weight' => 10,
        ) ,
        'Entries' => array(
            'title' => __l('Entries') ,
            'url' => array(
                'controller' => 'contest_users',
                'action' => 'index',
                'filter_id' => ConstContestUserStatus::Active
            ) ,
            'weight' => 20,
        )
    ) ,
));
CmsNav::add('activities', array(
    'title' => 'Activities',
    'weight' => 40,
    'icon-class' => 'icon-time',
    'children' => array(
		'Contest' => array(
            'title' => __l('Contests Activities') ,
            'url' => array(
                'controller' => 'messages',
                'action' => 'activities',
				'type' => 'list',
            ) ,
            'weight' => 70,
        ) ,
        'Entry Downloads' => array(
            'title' => __l('Entry Downloads') ,
            'url' => array(
                'controller' => 'contest_user_downloads',
                'action' => 'index',
            ) ,
            'weight' => 80,
        ) ,
        'Contest Views' => array(
            'title' => __l('Contest Views') ,
            'url' => array(
                'controller' => 'contest_views',
                'action' => 'index',
            ) ,
            'weight' => 55,
        ) ,
        'Entry Views' => array(
            'title' => __l('Entry Views') ,
            'url' => array(
                'controller' => 'contest_user_views',
                'action' => 'index',
            ) ,
            'weight' => 90,
        ) ,
		'Contest Comments' => array(
            'title' => __l('Contest Comments') ,
            'url' => array(
                'controller' => 'messages',
                'action' => 'index',
                'contest_comments'
            ) ,
            'weight' => 50,
        ) ,
    ) ,
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 110,
    'children' => array(
        'Contests' => array(
            'title' => __l('Contests') ,
            'url' => '',
            'weight' => 150,
        ) ,
        'Contest Templates' => array(
            'title' => __l('Contest Templates') ,
            'url' => array(
                'controller' => 'contest_types',
                'action' => 'index',
                'type' => 'templates'
            ) ,
            'weight' => 155,
        ) ,
        'Contest Statuses' => array(
            'title' => __l('Contest Statuses') ,
            'url' => array(
                'controller' => 'contest_statuses',
                'action' => 'index',
            ) ,
            'weight' => 160,
        ) ,
        'Prize Packages' => array(
            'title' => __l('Prize Packages') ,
            'url' => array(
                'controller' => 'pricing_packages',
                'action' => 'index',
            ) ,
            'weight' => 190,
        ) ,
        'Contest Days' => array(
            'title' => __l('Contest Days') ,
            'url' => array(
                'controller' => 'pricing_days',
                'action' => 'index',
            ) ,
            'weight' => 191,
        ) ,
    )
));
CmsHook::setExceptionUrl(array(
    'contests/index',
    'contests/view',
    'contest_types/index',
    'contest_users/index',
    'contest_users/view',
    'contest_comments/index',
    'contest_followers/index_contest_follow',
    'contests/browse',
    'contests/download',
));
CmsHook::setSitemapModel(array(
    'Contest' => array(
        'conditions' => array(
            'Contest.admin_suspend' => 0,
            'Contest.contest_status_id' => array(
                ConstContestStatus::Judging,
                ConstContestStatus::WinnerSelected,
                ConstContestStatus::WinnerSelectedByAdmin,
                ConstContestStatus::ChangeRequested,
                ConstContestStatus::ChangeCompleted,
                ConstContestStatus::Completed,
                ConstContestStatus::PaidToParticipant,
                ConstContestStatus::Open,
            )
        )
    )
));
$defaultModel = array(
    'User' => array(
        'hasMany' => array(
            'ContestUser' => array(
                'className' => 'Contests.ContestUser',
                'foreignKey' => 'user_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQusery' => ''
            ) ,
            'Message' => array(
                'className' => 'Contests.Message',
                'foreignKey' => 'user_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
            'Contest' => array(
                'className' => 'Contests.Contest',
                'foreignKey' => 'user_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            )
        ) ,
    ) ,
    'ContestFlag' => array(
        'belongsTo' => array(
            'Contest' => array(
                'className' => 'Contests.Contest',
                'foreignKey' => 'contest_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'counterCache' => true
            ) ,
        )
    ) ,
	'ContestUser' => array(
        'hasMany' => array(
            'Upload' => array(
                'className' => 'VideoResources.Upload',
                'foreignKey' => 'contest_user_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            ) ,
        )
    ) ,
    'ContestFollower' => array(
        'belongsTo' => array(
            'Contest' => array(
                'className' => 'Contests.Contest',
                'foreignKey' => 'contest_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'counterCache' => true
            ) ,
        )
    ) ,
    'ContestUserFlag' => array(
        'belongsTo' => array(
            'ContestUser' => array(
                'className' => 'Contests.ContestUser',
                'foreignKey' => 'contest_user_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'counterCache' => true
            ) ,
        )
    ) ,
    'ContestUserRating' => array(
        'belongsTo' => array(
            'ContestUser' => array(
                'className' => 'Contests.ContestUser',
                'foreignKey' => 'contest_user_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'counterCache' => true
            ) ,
        ) ,
        'hasMany' => array(
            'Message' => array(
                'className' => 'Contests.Message',
                'foreignKey' => 'contest_user_rating_id',
                'dependent' => true,
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'limit' => '',
                'offset' => '',
                'exclusive' => '',
                'finderQuery' => '',
                'counterQuery' => ''
            ) ,
        )
    ) ,
    'Transaction' => array(
        'belongsTo' => array(
            'Contest' => array(
                'className' => 'Contests.Contest',
                'foreignKey' => 'foreign_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            ) ,
        )
    ) ,
    'AdaptiveTransactionLog' => array(
        'belongsTo' => array(
            'ContestUser' => array(
                'className' => 'Contests.ContestUser',
                'foreignKey' => 'contest_user_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
            )
        )
    )
);
if (isPluginEnabled('Affiliates')) {
    $pluginModel = array(
        'Affiliate' => array(
            'belongsTo' => array(
                'Contest' => array(
                    'className' => 'Contests.Contest',
                    'foreignKey' => 'foreign_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => '',
                ) ,
            ) ,
        ) ,
    );
    $defaultModel = $defaultModel+$pluginModel;
}
CmsHook::bindModel($defaultModel);