#!/usr/bin/php -q
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
$ds = DIRECTORY_SEPARATOR;
$dispatcher = 'Cake' . $ds . 'Console' . $ds . 'ShellDispatcher.php';
$found = false;
$paths = explode(PATH_SEPARATOR, ini_get('include_path'));
foreach($paths as $path) {
    if (file_exists($path . $ds . $dispatcher)) {
        $found = $path;
    }
}
if (!$found && function_exists('ini_set')) {
    $root = dirname(dirname(dirname(__FILE__)));
    ini_set('include_path', $root . $ds . 'lib' . PATH_SEPARATOR . ini_get('include_path'));
}
if (!include ($dispatcher)) {
    trigger_error('Could not locate CakePHP core files.', E_USER_ERROR);
}
unset($paths, $path, $found, $dispatcher, $root, $ds);
return ShellDispatcher::run($argv);
