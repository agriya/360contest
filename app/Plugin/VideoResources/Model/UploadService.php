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
class UploadService extends AppModel
{
    public $name = 'UploadService';
    public $hasOne = array(
        'UploadServiceSetting' => array(
            'className' => 'VideoResources.UploadServiceSetting',
            'foreignKey' => 'upload_service_id',
            'dependent' => true,
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
    );
    public $hasMany = array(
        'UploadHoster' => array(
            'className' => 'VideoResources.UploadHoster',
            'foreignKey' => 'upload_service_id',
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
        'Upload' => array(
            'className' => 'VideoResources.Upload',
            'foreignKey' => 'upload_service_id',
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
    );
    public function updateQuota($sevice_id)
    {
        if ($sevice_id == ConstUploadService::Vimeo) {
            App::import('Vendor', 'VideoResources.Vimeo/vimeo');
            $vimeo = new phpVimeo(Configure::read('vimeo_api_key') , Configure::read('vimeo_secret_key') , Configure::read('vimeo_access_token') , Configure::read('vimeo_access_token_secret'));
            $complete = $vimeo->call('vimeo.videos.upload.getQuota');
            $_data = array();
            $_data['id'] = $sevice_id;
            $_data['total_quota'] = $complete->user->upload_space->max;
            $this->save($_data);
        }
    }
}
