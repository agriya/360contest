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
class ContestUserRating extends AppModel
{
    public $name = 'ContestUserRating';
    //The Associations below have been created with all possible keys, those that are not needed can be removed
    public $belongsTo = array(
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'counterCache' => true
        ) ,
        'Ip' => array(
            'className' => 'Ip',
            'foreignKey' => 'ip_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'Attachment' => array(
            'className' => 'Attachment',
            'foreignKey' => 'foreign_id',
            'conditions' => array(
                'Attachment.class =' => 'ContestUser'
            ) ,
            'dependent' => true,
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ) ,
    );
    public function __construct($id = false, $table = null, $ds = null)
    {
        parent::__construct($id, $table, $ds);
        $this->_permanentCacheAssociations = array(
            'Contest',
            'ContestUser',
            'User',
        );
        $this->moreActions = array(
            ConstMoreAction::Delete => __l('Delete')
        );
    }
    public function updatecount($contest_user_id)
    {
        $contestUserrating = $this->find('all', array(
            'conditions' => array(
                'ContestUserRating.contest_user_id' => $contest_user_id
            ) ,
            'fields' => array(
                'SUM(ContestUserRating.rating) as total_ratings',
            ) ,
            'recursive' => -1
        ));
        if (empty($contestUserrating[0][0]['total_ratings'])) {
            $contestUserrating[0][0]['total_ratings'] = 0;
        }
        $this->ContestUser->updateAll(array(
            'ContestUser.contest_user_total_ratings' => $contestUserrating[0][0]['total_ratings'],
        ) , array(
            'ContestUser.id' => $contest_user_id
        ));
        $contest_user = $this->ContestUser->find('first', array(
            'conditions' => array(
                'ContestUser.id' => $contest_user_id
            ) ,
            'fields' => array(
                'ContestUser.user_id',
                'ContestUser.contest_user_rating_count',
                'ContestUser.contest_user_total_ratings',	
            ) ,
            'recursive' => -1
        ));
		$this->ContestUser->updateAll(array(
            'ContestUser.average_rating' => ($contest_user['ContestUser']['contest_user_total_ratings'] / $contest_user['ContestUser']['contest_user_rating_count']),
        ) , array(
            'ContestUser.id' => $contest_user_id
        ));
        $contestUser = $this->ContestUser->find('all', array(
            'conditions' => array(
                'ContestUser.user_id' => $contest_user['ContestUser']['user_id']
            ) ,
            'fields' => array(
                'SUM(ContestUser.contest_user_total_ratings) as total_ratings',
                'SUM(ContestUser.contest_user_rating_count) as rating_count',
            ) ,
            'recursive' => -1
        ));
        if (empty($contestUser[0][0]['total_ratings'])) {
            $contestUser[0][0]['total_ratings'] = 0;
        }
        if (empty($contestUser[0][0]['rating_count'])) {
            $contestUser[0][0]['rating_count'] = 0;
        }
        $this->ContestUser->User->updateAll(array(
            'User.total_ratings' => $contestUser[0][0]['total_ratings'],
            'User.rating_count' => $contestUser[0][0]['rating_count'],
            'User.average_rating' => ($contestUser[0][0]['total_ratings'] / $contestUser[0][0]['rating_count']),
        ) , array(
            'User.id' => $contest_user['ContestUser']['user_id']
        ));
    }
}
?>