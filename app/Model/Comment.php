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
class Comment extends AppModel
{
    /**
     * Model name
     *
     * @var string
     * @access public
     */
    public $name = 'Comment';
    /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    public $actsAs = array(
        'Tree',
        'Containable',
        'Cached' => array(
            'prefix' => array(
                'comment_',
                'nodes_',
                'node_',
            ) ,
        ) ,
    );
    /**
     * Model associations: belongsTo
     *
     * @var array
     * @access public
     */
    public $belongsTo = array(
        'Node' => array(
            'counterCache' => true,
            'counterScope' => array(
                'Comment.status' => 1
            ) ,
        ) ,
        'User',
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Node'
        );
        $this->validate = array(
            'body' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'name' => array(
                'rule' => 'notempty',
                'message' => __l('Required') ,
            ) ,
            'email' => array(
                'rule' => 'email',
                'required' => true,
                'message' => 'Please enter a valid email address.',
            ) ,
            'captcha' => array(
                'rule2' => array(
                    'rule' => '_isValidCaptcha',
                    'message' => __l('Please enter valid captcha')
                ) ,
                'rule1' => array(
                    'rule' => 'notempty',
                    'message' => __l('Required')
                )
            )
        );
        $this->moreActions = array(
            ConstMoreAction::Publish => __l('Publish') ,
            ConstMoreAction::Unpublish => __l('Unpublish')
        );
    }
}
