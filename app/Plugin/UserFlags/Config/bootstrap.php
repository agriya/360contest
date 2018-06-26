<?php
/**
 * 360Contest
 *
 * PHP version 5
 *
 * @category   PHP
 * @package    360contest
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
        'User Flags' => array(
            'title' => __l('User Flags') ,
            'url' => array(
                'controller' => 'user_flags',
                'action' => 'index',
            ) ,
            'weight' => 30,
        ) ,
    ) ,
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 110,
    'children' => array(
        'User Flag Categories' => array(
            'title' => __l('User Flag Categories') ,
            'url' => array(
                'controller' => 'user_flag_categories',
                'action' => 'index',
            ) ,
            'weight' => 170,
        ) ,
    )
));
CmsHook::bindModel(array(
    'User' => array(
        'hasMany' => array(
            'UserFlag' => array(
                'className' => 'UserFlags.UserFlag',
                'foreignKey' => 'other_user_id',
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
