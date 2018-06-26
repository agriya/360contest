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
    'title' => __l('Activities') ,
    'url' => array(
        'admin' => true,
        'controller' => 'users',
        'action' => 'index',
    ) ,
    'icon-class' => 'icon-time',
    'weight' => 30,
    'children' => array(
        'user_favorites' => array(
            'title' => __l('User Followers') ,
            'url' => array(
                'admin' => true,
                'controller' => 'user_favorites',
                'action' => 'index',
            ) ,
            'weight' => 30,
        ) ,
    ) ,
));
CmsHook::bindModel(array(
    'User' => array(
        'hasMany' => array(
            'UserFavorite' => array(
                'className' => 'UserFavourites.UserFavorite',
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
            'FavoriteUser' => array(
                'className' => 'UserFavourites.UserFavorite',
                'foreignKey' => 'user_favorite_id',
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
