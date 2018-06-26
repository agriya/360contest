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
class UserProfile extends AppModel
{
    public $name = 'UserProfile';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Gender' => array(
            'className' => 'Gender',
            'foreignKey' => 'gender_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'City' => array(
            'className' => 'City',
            'foreignKey' => 'city_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'State' => array(
            'className' => 'State',
            'foreignKey' => 'state_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Country' => array(
            'className' => 'Country',
            'foreignKey' => 'country_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'Language' => array(
            'className' => 'Language',
            'foreignKey' => 'language_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'User'
        );
        $this->validate = array(
            'dob' => array(
                'rule3' => array(
                    'rule' => '_isValidDob',
                    'message' => __l('Must be a valid date'),
					'allowEmpty' => (!empty($_SESSION['Auth']['User']['role_id']) && $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) ? true : false,
                ) ,
                'rule2' => array(
                    'rule' => 'date',
                    'message' => __l('Must be a valid date'),
					'allowEmpty' => (!empty($_SESSION['Auth']['User']['role_id']) && $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) ? true : false,
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required'),
					'allowEmpty' => (!empty($_SESSION['Auth']['User']['role_id']) && $_SESSION['Auth']['User']['role_id'] == ConstUserTypes::Admin) ? true : false,
                ),
            ) ,
            'gender_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            ) ,
            'country_id' => array(
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            )
        );
    }
    public function _isValidDob()
    { 
        return Date('Y') . '-' . Date('m') . '-' . Date('d') >= $this->data[$this->name]['dob'];
    }
}
?>