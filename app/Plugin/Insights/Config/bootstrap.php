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
$content_analytics = '';
if (isPluginEnabled('IntegratedGoogleAnalytics')) {
    $content_analytics = __l('To analyze the site analytic status detail and also it shows the graphical representation of overall bounce rate and traffic');
}
CmsHook::setExceptionUrl(array(
    'insights/public_stats',
));
CmsNav::add('analytics', array(
    'title' => __l('Analytics') ,
    'data-bootstro-step' => '3',
    'data-bootstro-content' => __l('To analyze overall user registration rate, their demographics, user login rate and also the overall project posting/funding rate.') . ' ' . $content_analytics,
    'icon-class' => 'bar-chart',
    'weight' => 11,
    'children' => array(
        'insights' => array(
            'title' => __l('Insights') ,
            'url' => array(
                'admin' => true,
                'controller' => 'insights',
                'action' => 'admin_index',
            ) ,
            'weight' => 20,
        ) ,
    )
));
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 200,
    'children' => array(
        'Demographics' => array(
            'title' => __l('Demographics') ,
            'url' => '',
            'weight' => 900,
        ) ,
        'Educations' => array(
            'title' => __l('Educations') ,
            'url' => array(
                'controller' => 'educations',
                'action' => 'index',
            ) ,
            'weight' => 910,
        ) ,
        'Employments' => array(
            'title' => __l('Employments') ,
            'url' => array(
                'controller' => 'employments',
                'action' => 'index',
            ) ,
            'weight' => 920,
        ) ,
        'IncomeRanges' => array(
            'title' => __l('Income Ranges') ,
            'url' => array(
                'controller' => 'income_ranges',
                'action' => 'index',
            ) ,
            'weight' => 930,
        ) ,
        'Relationships' => array(
            'title' => __l('Relationships') ,
            'url' => array(
                'controller' => 'relationships',
                'action' => 'index',
            ) ,
            'weight' => 940,
        ) ,
    )
));
if (isPluginEnabled('Contests')) {
    CmsNav::add('Contests', array(
        'title' => 'Contests',
        'data-bootstro-step' => "4",
        'data-bootstro-content' => __l("To monitor the summary, price point statistics of site and also to manage all contest posted in the site.") ,
        'url' => array(
            'controller' => 'contests',
            'action' => 'index',
        ) ,
        'weight' => 30,
        'icon-class' => 'file',
        'children' => array(
            'Contest Stats' => array(
                'title' => __l('Snapshot') ,
                'url' => array(
                    'controller' => 'insights',
                    'action' => 'admin_contest_stats',
                ) ,
                'weight' => 10,
            ) ,
        ) ,
    ));
}
$defaultModel = array(
    'UserProfile' => array(
        'belongsTo' => array(
            'Education' => array(
                'className' => 'Insights.Education',
                'foreignKey' => 'education_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'Employment' => array(
                'className' => 'Insights.Employment',
                'foreignKey' => 'employment_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'Relationship' => array(
                'className' => 'Insights.Relationship',
                'foreignKey' => 'relationship_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
            'IncomeRange' => array(
                'className' => 'Insights.IncomeRange',
                'foreignKey' => 'income_range_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            ) ,
        ) ,
    )
);
CmsHook::bindModel($defaultModel);
CmsHook::setJsFile(array(
    APP . 'Plugin' . DS . 'Insights' . DS . 'webroot' . DS . 'js' . DS . 'libs' . DS . 'highcharts.js',
    APP . 'Plugin' . DS . 'Insights' . DS . 'webroot' . DS . 'js' . DS . 'libs' . DS . 'fhighcharts.js',
) , 'default');
?>