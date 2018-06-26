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
        'Entry Flags' => array(
            'title' => __l('Entry Flags') ,
            'url' => array(
                'controller' => 'contest_user_flags',
                'action' => 'index',
            ) ,
            'weight' => 70,
        ) ,
    ) ,
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 110,
    'children' => array(
        'Entry Flag Categories' => array(
            'title' => __l('Entry Flag Categories') ,
            'url' => array(
                'controller' => 'contest_user_flag_categories',
                'action' => 'index',
            ) ,
            'weight' => 180,
        ) ,
    )
));
CmsHook::bindModel(array(
    'ContestUser' => array(
        'hasMany' => array(
            'ContestUserFlag' => array(
                'className' => 'EntryFlags.ContestUserFlag',
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
    'ContestUserFlagCategory' => array(
        'hasMany' => array(
            'ContestUserFlag' => array(
                'className' => 'EntryFlags.ContestUserFlag',
                'foreignKey' => 'contest_user_flag_category_id',
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
    )
));
