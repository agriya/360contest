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
    'icon-class' => 'icon-time',
    'children' => array(
        'Contest Followers' => array(
            'title' => __l('Contest Followers') ,
            'url' => array(
                'controller' => 'contest_followers',
                'action' => 'index',
            ) ,
            'weight' => 50,
        ) ,
    ) ,
));
CmsHook::setExceptionUrl(array(
    'contest_followers/index_contest_follow',
));
CmsHook::bindModel(array(
    'Contest' => array(
        'hasMany' => array(
            'ContestFollower' => array(
                'className' => 'ContestFollowers.ContestFollower',
                'foreignKey' => 'contest_id',
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
    )
));
