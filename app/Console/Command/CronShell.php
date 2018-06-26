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
class CronShell extends Shell
{
    function main()
    {
        App::uses('Router', 'Routing');
        // site settings are set in config
        App::import('Vendor', 'Spyc/Spyc');
        if (file_exists(APP . 'Config' . DS . 'settings.yml')) {
            $settings = Spyc::YAMLLoad(file_get_contents(APP . 'Config' . DS . 'settings.yml'));
            foreach($settings AS $settingKey => $settingValue) {
                Configure::write($settingKey, $settingValue);
            }
        }
        // include cron component
        App::uses('ComponentCollection', 'Controller');
        $collection = new ComponentCollection();
        App::import('Component', 'Cron');
        $this->Cron = new CronComponent($collection);
        $option = !empty($this->args[0]) ? $this->args[0] : '';
        $this->log('Cron started without any issue');
        if (!empty($option) && $option == 'main') {
            $this->Cron->main();
        } elseif (!empty($option) && $option == 'daily') {
            $this->Cron->daily();
        } elseif (!empty($option) && $option == 'clear_permanent_cache') {
            $this->Cron->clear_permanent_cache();
        }
    }
}
?>