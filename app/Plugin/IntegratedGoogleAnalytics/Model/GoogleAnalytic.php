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
class GoogleAnalytic extends AppModel
{
    public $useTable = false;
    public function __construct($id = false, $table = null, $ds = null) 
    {
        parent::__construct($id, $table, $ds);
        $this->filterOptions = array(
            ConstFilterOptions::Loggedin => __l('Loggedin Users') ,
            ConstFilterOptions::Refferred => __l('Refferred Users') ,
            ConstFilterOptions::Followed => __l('Followed Users') ,
            ConstFilterOptions::Voted => __l('Voted Users') ,
            ConstFilterOptions::Commented => __l('Commented Users') ,
            ConstFilterOptions::EntryWinner => __l('Entry Winner Amount Value') ,
            ConstFilterOptions::ContestPosted => __l('Contest Posted Amount Value')
        );
    }
}
?>