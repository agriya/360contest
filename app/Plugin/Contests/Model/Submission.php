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
class Submission extends AppModel
{
    public $name = 'Submission';
    public $belongsTo = array(
        'ContestType' => array(
            'className' => 'Contests.ContestType',
            'foreignKey' => 'contest_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );
    public $hasMany = array(
        'SubmissionField' => array(
            'className' => 'Contests.SubmissionField',
            'foreignKey' => 'submission_id',
            'dependent' => true,
        )
    );
    public function submit($data)
    {
        $data['Submission']['contest_type_id'] = $data['Contest']['contest_type_id'];
        App::uses('Contests.Contest', 'Model');
        $this->Contest = new Contest();
        $this->create($data);
        $this->save();
        if (!empty($data['Submission']['id'])) {
            $id = $data['Submission']['id'];
        } else {
            $id = $this->id;
        }
        $contest_id = $data['Submission']['contest_id'];
        $submissionFields = $this->Contest->Submission->SubmissionField->find('list', array(
            'conditions' => array(
                'SubmissionField.submission_id' => $id
            ) ,
            'fields' => array(
                'SubmissionField.form_field',
                'SubmissionField.id',
            ) ,
            'recursive' => -1
        ));
        $formFields = array(
            'Submission' => array(
                'id' => $id
            )
        );
        define('_THUMBALIZR', 1);
        $field_name = array();
        if (!empty($data['Form'])) {
            foreach($data['Form'] as $formField => $response) {
                if (is_array($response)) {
                    $response = implode("\n", $response);
                }
                $fieldtype = explode('_', $formField);
                if ($fieldtype[1] == 'file') {
                    if (!empty($data['Form'][$formField]['name'])) {
                        $field_name[] = $formField;
                    } else {
                        $response = '';
                    }
                } else if ($fieldtype[1] == 'thumbnail') {
                    $field_name[] = $formField;
                }
                if (!empty($response)) {
                    $formFields['SubmissionField'][] = array(
                        'form_field' => $formField,
                        'response' => $response,
                        'type' => $fieldtype[1],
                        'id' => !empty($submissionFields[$formField]) ? $submissionFields[$formField] : ''
                    );
                }
            }
        }
        if ($this->saveAll($formFields, array(
            'validate' => false
        ))) {
            $submissionFormFields = $this->Contest->Submission->SubmissionField->find('all', array(
                'conditions' => array(
                    'AND' => array(
                        array(
                            'SubmissionField.submission_id' => $formFields['Submission']['id']
                        ) ,
                        array(
                            'SubmissionField.form_field' => $field_name
                        )
                    )
                ) ,
                'recursive' => -1
            ));
            if (!empty($submissionFormFields)) {
                foreach($submissionFormFields as $submissionFormField) {
                    $formFieldId = $submissionFormField['SubmissionField']['id'];
                    $formFieldType = $submissionFormField['SubmissionField']['type'];
                    if ($formFieldType == 'file') {
                        App::uses('Attachment', 'Model');
                        $this->Attachment = new Attachment();
                        $Attachment = $this->Attachment->find('first', array(
                            'conditions' => array(
                                'Attachment.foreign_id' => $formFieldId,
                                'Attachment.class' => 'SubmissionThumb'
                            ) ,
                            'recursive' => -1
                        ));
                        $data['SubmissionThumb']['filename'] = $data['Form'][$formField];
                        $this->SubmissionField->SubmissionThumb->Behaviors->attach('ImageUpload');
                        $this->SubmissionField->SubmissionThumb->set($data['SubmissionThumb']['filename']);
                        if (!empty($data['SubmissionThumb']['filename']['name'])) {
                            if (empty($Attachment)) {
                                $this->Attachment->create();
                            } else {
                                $data['SubmissionThumb']['id'] = $Attachment['Attachment']['id'];
                            }
                            $data['SubmissionThumb']['class'] = 'SubmissionThumb';
                            $data['SubmissionThumb']['foreign_id'] = $formFieldId;
                            $this->Attachment->save($data['SubmissionThumb']);
                        }
                        $this->SubmissionField->SubmissionThumb->Behaviors->detach('ImageUpload');
                    }
                    if ($formFieldType == 'thumbnail') {
                        $url = $submissionFormField['SubmissionField']['response'];
                        if (!empty($url)) {
                            // for thumnail creation
                            $this->_fetchSiteThumb($formFieldId, $url);
                        }
                    }
                }
            }
            return true;
        } else {
            return false;
        }
    }
    public function getSubmissions($formId)
    {
        $fields = $this->fields($formId);
        $skel = Set::combine($fields, '{n}');
        $submissions = $this->findAllByContestTypeId($formId);
        foreach($submissions as &$submission) {
            $submission['SubmissionField'] = Set::combine($submission['SubmissionField'], '{n}.form_field', '{n}.response');
            $submission = Set::merge($skel, $submission['Submission'], $submission['SubmissionField']);
        }
        return $submissions;
    }
    public function getSubmission($formId)
    {
        $submission = $this->findByContestTypeId($formId);
        $submission['SubmissionField'] = Set::combine($submission['SubmissionField'], '{n}.form_field', '{n}.response');
        $submission = Set::merge($submission['Submission'], $submission['SubmissionField']);
        return $submission;
    }
    public function fields($formId)
    {
        $submissions = $this->find('list', array(
            'conditions' => array(
                'contest_type_id' => $formId
            ) ,
            'fields' => array(
                'id'
            ),
			'recursive' => -1
        ));
        $data = $this->SubmissionField->find('all', array(
            'conditions' => array(
                'submission_id' => $submissions
            ) ,
            'group' => 'SubmissionField.form_field',
            'contain' => array() ,
            'fields' => array(
                'form_field'
            )
        ));
        $submissionFields = $this->find('first', array(
            'conditions' => array(
                'contest_type_id' => $formId
            ),
			'recursive' => -1
        ));
        $fields = Set::extract('{n}.SubmissionField.form_field', $data);
        $fields2 = array_keys($submissionFields['Submission']);
        $fields = Set::merge($fields2, $fields);
        return $fields;
    }
    function _fetchSiteThumb($formFieldId, $url)
    {
        App::uses('Contests.SubmissionField', 'Model');
        $this->Contest = new Contest();
        App::uses('Attachment', 'Model');
        $this->Attachment = new Attachment();
        $thumbalizr_config = array(
            'api_key' => Configure::read('thumbalizr.api_key') ,
            'service_url' => 'http://api.thumbalizr.com/',
            'use_local_cache' => TRUE,
            'local_cache_dir' => APP . 'media' . DS . 'ContestCloneThumb',
            'local_cache_expire' => 12,
            'local_cache_subdir' => APP . 'media' . DS . 'ContestCloneThumb' . DS . $formFieldId,
        );
        $thumbalizr_defaults = array(
            'width' => '383',
            'delay' => '8',
            'encoding' => 'jpg',
            'quality' => '80',
            'bwidth' => '1280',
            'mode' => 'screen',
            'bheight' => '1024'
        );
        App::import('Vendor', 'thumbalizr/thumbalizr');
        $image = new thumbalizr($thumbalizr_config, $thumbalizr_defaults);
        $image->request($url);
        if ($image->headers['Status'] == 'OK' || $image->headers['Status'] == 'LOCAL') {
            $attachment = $this->Attachment->find('first', array(
                'conditions' => array(
                    'Attachment.foreign_id' => $formFieldId,
                    'Attachment.class' => 'ContestCloneThumb'
                ) ,
                'recursive' => -1
            ));
            if (!empty($attachment)) {
                $_data['Attachment']['id'] = $attachment['Attachment']['id'];
                $list = glob(WWW_ROOT . 'img' . DS . 'big_thumb' . DS . 'ContestCloneThumb' . DS . $attachment['Attachment']['id'] . '.*');
                @unlink($list[0]);
            }
            $_data['Attachment']['dir'] = 'ContestCloneThumb' . DS . $formFieldId;
            $_data['Attachment']['filename'] = $image->local_cache_file;
            $_data['Attachment']['foreign_id'] = $formFieldId;
            $_data['Attachment']['class'] = 'ContestCloneThumb';
            $_data['Attachment']['filesize'] = filesize(APP . 'media' . DS . 'ContestCloneThumb' . DS . $formFieldId . DS . $image->local_cache_file);
            $sizes = getimagesize(APP . 'media' . DS . 'ContestCloneThumb' . DS . $formFieldId . DS . $image->local_cache_file);
            $_data['Attachment']['width'] = $sizes[0];
            $_data['Attachment']['height'] = $sizes[1];
            $_data['Attachment']['mimetype'] = $sizes['mime'];
            $this->Attachment->enableUpload(false);
            $this->Attachment->set($_data);
            $this->Attachment->create();
            $this->Attachment->save($_data);
        }
    }
}
