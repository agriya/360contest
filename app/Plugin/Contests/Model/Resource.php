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
class Resource extends ContestsAppModel
{
    public $name = 'Resource';
    public $displayField = 'name';
    //$validate set in __construct for multi-language support
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $hasMany = array(
        'ContestType' => array(
            'className' => 'Contests.ContestType',
            'foreignKey' => 'resource_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
        'Contest' => array(
            'className' => 'Contests.Contest',
            'foreignKey' => 'resource_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'name' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'allowEmpty' => false,
                    'message' => __l('Required') ,
                ) ,
            ) ,
        );
    }
    function getResourceName($resource_id)
    {
        $resource = $this->find('first', array(
            'conditions' => array(
                'Resource.id' => $resource_id
            ) ,
            'recursive' => -1
        ));
        return $resource;
    }
	function activeResources()
	{		
		$resources = $this->find('list');
		if (!isPluginEnabled('VideoResources')) { 
			unset($resources[ConstResourceId::Video]);
		}
		if (!isPluginEnabled('ImageResources')) { 
			unset($resources[ConstResourceId::Image]);
		}
		if($resources) {
			return array_keys($resources);
		} else {
			return array();
		}
	}
}
