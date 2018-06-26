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
class SubmissionField extends ContestsAppModel
{
    public $name = 'SubmissionField';
    public $belongsTo = array(
        'Submission' => array(
            'className' => 'Contests.Submission',
            'foreignKey' => 'submission_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasOne = array(
        'ContestCloneThumb' => array(
            'className' => 'Contests.ContestCloneThumb',
            'foreignKey' => 'foreign_id',
            'dependent' => false,
            'conditions' => array(
                'ContestCloneThumb.class' => 'ContestCloneThumb',
            ) ,
            'fields' => '',
            'order' => ''
        ) ,
        'SubmissionThumb' => array(
            'className' => 'Contests.SubmissionThumb',
            'foreignKey' => 'foreign_id',
            'dependent' => false,
            'conditions' => array(
                'SubmissionThumb.class' => 'SubmissionThumb',
            ) ,
            'fields' => '',
            'order' => ''
        )
    );
}
?>