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
class Type extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Type';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Cached' => array(
            'prefix' => array(
                'cms_types_',
                'types_',
                'type_',
            ) ,
        ) ,
        'Params',
    );
    /**
     * Model associations: hasAndBelongsToMany
     *
     * @var array
     * @access public
     */
    public $hasAndBelongsToMany = array(
        'Vocabulary' => array(
            'className' => 'Vocabulary',
            'joinTable' => 'types_vocabularies',
            'foreignKey' => 'type_id',
            'associationForeignKey' => 'vocabulary_id',
            'unique' => true,
            'conditions' => '',
            'fields' => '',
            'order' => 'Vocabulary.weight ASC',
            'limit' => '',
            'offset' => '',
            'finderQuery' => '',
            'deleteQuery' => '',
            'insertQuery' => '',
        ) ,
    );
    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = array(
        'id',
        'title',
        'alias',
        'description',
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->validate = array(
            'title' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'alias' => array(
                'isUnique' => array(
                    'rule' => 'isUnique',
                    'message' => __l('Already exist') ,
                ) ,
                'minLength' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required') ,
                ) ,
            ) ,
        );
    }
}
