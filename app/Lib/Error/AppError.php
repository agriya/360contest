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
class AppError extends ErrorHandler
{
    /**
     * securityError
     *
     * @return void
     */
    public function securityError()
    {
        $this->controller->set(array(
            'referer' => $this->controller->referer() ,
        ));
        $this->_outputMessage('security');
    }
}
