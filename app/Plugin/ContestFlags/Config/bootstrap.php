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
        'Contest Flags' => array(
            'title' => __l('Contest Flags') ,
            'url' => array(
                'controller' => 'contest_flags',
                'action' => 'index',
            ) ,
            'weight' => 55,
        ) ,
    ) ,
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 110,
    'children' => array(
        'Contest Flag Categories' => array(
            'title' => __l('Contest Flag Categories') ,
            'url' => array(
                'controller' => 'contest_flag_categories',
                'action' => 'index',
            ) ,
            'weight' => 170,
        ) ,
    )
));
CmsHook::bindModel(array(
    'Contest' => array(
        'hasMany' => array(
            'ContestFlag' => array(
                'className' => 'ContestFlags.ContestFlag',
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
