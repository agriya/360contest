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
CmsNav::add('masters', array(
    'title' => 'Masters',
    'weight' => 110,
    'children' => array(
        'Translation' => array(
            'title' => __l('Translations') ,
            'url' => '',
            'weight' => 60,
        ) ,
        'Translations' => array(
            'title' => __l('Translations') ,
            'url' => array(
                'controller' => 'translations',
                'action' => 'index',
            ) ,
            'weight' => 70,
        ) ,
        'Language' => array(
            'title' => __l('Languages') ,
            'url' => array(
                'admin' => true,
                'controller' => 'languages',
                'action' => 'index',
            ) ,
            'access' => array(
                'admin'
            ) ,
            'weight' => 80,
        ) ,
    )
));
$lang_code = Configure::read('site.language');
if (!empty($_COOKIE['CakeCookie']['user_language'])) {
    $lang_code = $_COOKIE['CakeCookie']['user_language'];
}
Configure::write('lang_code', $lang_code);
$translations = Cache::read($lang_code . '_translations');
if (empty($translations) and $translations === false) {
    App::import('Model', 'Translation.Translation');
    $translationObj = new Translation();
    $translations = $translationObj->find('all', array(
        'conditions' => array(
            'Language.iso2' => $lang_code
        ) ,
        'fields' => array(
            'Translation.name',
            'Translation.lang_text',
        ) ,
        'recursive' => 0
    ));
    Cache::set(array(
        'duration' => '+100 days'
    ));
    Cache::write($lang_code . '_translations', $translations);
}
if (!empty($translations)) {
    foreach($translations as $translation) {
        $GLOBALS['_langs'][$lang_code][$translation['Translation']['name']] = $translation['Translation']['lang_text'];
    }
}
?>