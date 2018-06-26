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
CakePlugin::routes();
Router::parseExtensions('rss', 'csv', 'json', 'txt', 'xml', 'js', 'css');
// Basic
CmsRouter::connect('/', array(
    'controller' => 'nodes',
    'action' => 'home'
));
CmsRouter::connect('/how-it-works', array(
    'controller' => 'nodes',
    'action' => 'how_it_works',
));
CmsRouter::connect('/promoted/*', array(
    'controller' => 'nodes',
    'action' => 'promoted'
));
CmsRouter::connect('/search/*', array(
    'controller' => 'nodes',
    'action' => 'search'
));
// Blog
CmsRouter::connect('/blog', array(
    'controller' => 'nodes',
    'action' => 'index',
    'type' => 'blog'
));
CmsRouter::connect('/blog/archives/*', array(
    'controller' => 'nodes',
    'action' => 'index',
    'type' => 'blog'
));
CmsRouter::connect('/blog/:slug', array(
    'controller' => 'nodes',
    'action' => 'view',
    'type' => 'blog'
));
CmsRouter::connect('/blog/term/:slug/*', array(
    'controller' => 'nodes',
    'action' => 'term',
    'type' => 'blog'
));
// Node
CmsRouter::connect('/node', array(
    'controller' => 'nodes',
    'action' => 'index',
    'type' => 'node'
));
CmsRouter::connect('/node/archives/*', array(
    'controller' => 'nodes',
    'action' => 'index',
    'type' => 'node'
));
CmsRouter::connect('/node/:slug', array(
    'controller' => 'nodes',
    'action' => 'view',
    'type' => 'node'
));
CmsRouter::connect('/node/term/:slug/*', array(
    'controller' => 'nodes',
    'action' => 'term',
    'type' => 'node'
));
// Page
CmsRouter::connect('/page/:slug', array(
    'controller' => 'nodes',
    'action' => 'view',
    'type' => 'page'
));
CmsRouter::connect('/css/*', array(
    'controller' => 'devs',
    'action' => 'asset_css'
));
CmsRouter::connect('/js/*', array(
    'controller' => 'devs',
    'action' => 'asset_js'
));
CmsRouter::connect('/img/:size/*', array(
    'controller' => 'images',
    'action' => 'view'
) , array(
    'size' => '(?:[a-zA-Z_]*)*'
));
CmsRouter::connect('/files/*', array(
    'controller' => 'images',
    'action' => 'view',
    'size' => 'original'
));
CmsRouter::connect('/img/*', array(
    'controller' => 'images',
    'action' => 'view',
    'size' => 'original'
));
CmsRouter::connect('/sitemap', array(
    'controller' => 'devs',
    'action' => 'sitemap'
));
CmsRouter::connect('/robots', array(
    'controller' => 'devs',
    'action' => 'robots'
));
CmsRouter::connect('/yadis', array(
    'controller' => 'devs',
    'action' => 'yadis'
));
CmsRouter::connect('/cron/:action/*', array(
    'controller' => 'crons',
));
CmsRouter::connect('/contactus', array(
    'controller' => 'contacts',
    'action' => 'add'
));
CmsRouter::connect('/admin', array(
    'controller' => 'users',
    'action' => 'stats',
    'prefix' => 'admin',
    'admin' => true
));
CmsRouter::connect('/users/twitter/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'twitter'
));
CmsRouter::connect('/users/facebook/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'facebook'
));
CmsRouter::connect('/users/yahoo/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'yahoo'
));
CmsRouter::connect('/users/gmail/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'google'
));
CmsRouter::connect('/users/openid/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'openid'
));
CmsRouter::connect('/users/linkedin/login', array(
    'controller' => 'users',
    'action' => 'login',
    'type' => 'linkedin'
));
CmsRouter::connect('/r::username', array(
    'controller' => 'users',
    'action' => 'refer'
), array(
	'username' => '[^\/]*'
));
CmsRouter::connect('/users/register', array(
    'controller' => 'users',
    'action' => 'register',
    'type' => 'social'
));