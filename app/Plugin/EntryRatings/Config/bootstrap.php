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
CmsNav::add('activities', array(
    'title' => 'Activities',
    'url' => array(
        'controller' => 'contests',
        'action' => 'index',
    ) ,
    'weight' => 40,
    'icon-class' => 'icon-timetime',
    'children' => array(
        'Entry Ratings' => array(
            'title' => __l('Entry Ratings') ,
            'url' => array(
                'controller' => 'contest_user_ratings',
                'action' => 'index',
            ) ,
            'weight' => 100,
        ) ,
    ) ,
));
CmsHook::bindModel(array(
    'User' => array(
        'hasMany' => array(
            'ContestUserRating' => array(
                'className' => 'EntryRatings.ContestUserRating',
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
        ) ,
    ) ,
    'ContestUser' => array(
        'hasMany' => array(
            'ContestUserRating' => array(
                'className' => 'EntryRatings.ContestUserRating',
                'foreignKey' => 'contest_user_id',
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
        ) ,
    ) ,
    'Message' => array(
        'belongsTo' => array(
            'ContestUserRating' => array(
                'className' => 'EntryRatings.ContestUserRating',
                'foreignKey' => 'contest_user_rating_id',
                'conditions' => '',
                'fields' => '',
                'order' => '',
                'counterCache' => true,
                'counterScope' => array(
                    'Message.is_sender' => 0,
                    'Message.is_activity' => 0,
                    'MessageContent.admin_suspend' => 0
                )
            )
        ) ,
    )
));
