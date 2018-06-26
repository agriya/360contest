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
App::import('Model', 'Attachment');
class EntryAttachment extends Attachment
{
    public $name = 'EntryAttachment';
    var $useTable = 'attachments';
    public $actsAs = array(
        'Inheritable' => array(
            'inheritanceField' => 'class',
            'fieldAlias' => 'EntryAttachment'
        )
    );
}
?>