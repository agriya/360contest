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
class ContestType extends ContestsAppModel
{
    public $name = 'ContestType';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'Resource' => array(
            'className' => 'Contests.Resource',
            'foreignKey' => 'resource_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasOne = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'ContestType'
            ) ,
            'dependent' => true
        ) ,
    );
    public $hasMany = array(
        'FormField' => array(
            'className' => 'Contests.FormField',
            'foreignKey' => 'contest_type_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'FormField.order',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
            'counterCache' => true
        ) ,
		'FormFieldGroup' => array(
            'className' => 'Contests.FormFieldGroup',
            'foreignKey' => 'contest_type_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
            'counterCache' => true
        ) ,
        'Contest' => array(
            'className' => 'Contests.Contest',
            'foreignKey' => 'contest_type_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => '',
            'counterCache' => true
        ) ,
        'Submission' => array(
            'className' => 'Contests.Submission',
            'foreignKey' => 'contest_type_id',
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
        'ContestTypesPricingPackage' => array(
            'className' => 'Contests.ContestTypesPricingPackage',
            'foreignKey' => 'contest_type_id',
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
        'ContestTypesPricingDay' => array(
            'className' => 'Contests.ContestTypesPricingDay',
            'foreignKey' => 'contest_type_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );
    public $hasAndBelongsToMany = array(
        'PricingPackage' => array(
            'className' => 'Contests.PricingPackage',
            'joinTable' => 'contest_types_pricing_packages',
            'foreignKey' => 'contest_type_id',
            'associationForeignKey' => 'pricing_package_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
        'PricingDay' => array(
            'className' => 'Contests.PricingDay',
            'joinTable' => 'contest_types_pricing_days',
            'foreignKey' => 'contest_type_id',
            'associationForeignKey' => 'pricing_day_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        ) ,
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'resource_id' => array(
                'rule1' => array(
                    'rule' => 'numeric',
                    'message' => __l('Required')
                )
            ) ,
            'name' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'description' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,		
			'maximum_entries_allowed' => array(
					'rule' => 'numeric',
					'message' => __l('Should be a numeric'),
					'allowEmpty' => true,
			) ,
			'maximum_entries_allowed_per_user' => array(
					'rule' => 'numeric',
					'message' => __l('Should be a numeric'),
					'allowEmpty' => true,
			) ,
			'minimum_prize' => array(
					'rule' => 'numeric',
					'message' => __l('Should be a numeric'),
					'allowEmpty' => true,
			) ,
        );
        $this->moreActions = array(
            ConstMoreAction::Inactive => __l('Inactive') ,
            ConstMoreAction::Active => __l('Active') ,
            ConstMoreAction::Delete => __l('Delete')
        );
    }
}
?>