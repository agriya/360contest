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
class FormField extends ContestsAppModel
{
    public $name = 'FormField';
    public $validate = array(
        'name' => array(
            'notempty'
        ) ,
        'contest_type_id' => array(
            'numeric'
        ) ,

    );
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'ContestType' => array(
            'className' => 'Contests.ContestType',
            'foreignKey' => 'contest_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'FormFieldGroup' => array(
            'className' => 'Contests.FormFieldGroup',
            'foreignKey' => 'form_field_group_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        )
    );
    public $hasAndBelongsToMany = array(
        'ValidationRule' => array(
            'className' => 'Contests.ValidationRule',
            'joinTable' => 'form_fields_validation_rules',
            'foreignKey' => 'form_field_id',
            'associationForeignKey' => 'validation_rule_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => ''
        )
    );
    public $types = array(
        'text' => 'Single Line of Text',
        'textarea' => 'Multiple Lines of Text',
        'select' => 'Select Box',
        'checkbox' => 'Checkboxes',
        'radio' => 'Radio Buttons',
        'file' => 'File Upload',
        'date' => 'Date Picker',
        'time' => 'Time Picker',
        'datetime' => 'Datetime Picker',
        'multiselect' => 'Multiple Option Select Box',
        'color' => 'Color Picker',
        'slider' => 'Slider'
    );
    public $multiTypes = array(
        'checkbox',
        'radio',
        'select',
        'multiselect',
        'slider'
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
		$this->_memcacheModels = array(
            'FormFieldGroup',
        );
        $this->_permanentCacheAssociations = array(
            'Resource',
			'ContestType'
        );
        $this->validate = array(
            'display_text' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
            'label' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => false
            ) ,
			'options' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
                'allowEmpty' => true
            ) ,
        );
    }
}
?>
