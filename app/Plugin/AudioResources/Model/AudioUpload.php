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
class AudioUpload extends AppModel
{

    public $name = 'AudioUpload';
	public $useTable = 'uploads';
    public $belongsTo = array(
        'AudioUploadService' => array(
            'className' => 'AudioResources.AudioUploadService',
            'foreignKey' => 'upload_service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UploadServiceType' => array(
            'className' => 'AudioResources.UploadServiceType',
            'foreignKey' => 'upload_service_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UploadStatus' => array(
            'className' => 'AudioResources.UploadStatus',
            'foreignKey' => 'upload_status_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'User' => array(
            'className' => 'User',
            'foreignKey' => 'user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
        'ContestUser' => array(
            'className' => 'Contests.ContestUser',
            'foreignKey' => 'contest_user_id',
            'conditions' => '',
            'fields' => '',
            'order' => '',
        ) ,
    );
    public function afterSave($created)
    {
        $upload = $this->find('first', array(
            'conditions' => array(
                'AudioUpload.id' => $this->id
            ) ,
            'contain' => array(
                'ContestUser' => array(
                    'User',
					'Contest'
                )
            ) ,
            'recursive' => 2
        ));
        App::import('Model', 'Attachment');
        $this->Attachment = new Attachment();
        $attachment = $this->Attachment->find('first', array(
            'conditions' => array(
                'Attachment.foreign_id' => $upload['AudioUpload']['contest_user_id'],
                'Attachment.class' => 'ContestUser'
            ) ,
            'recursive' => -1
        ));
        $_data['Attachment']['foreign_id'] = $upload['AudioUpload']['contest_user_id'];
        if (empty($attachment)) {
            $this->Attachment->create();
            $_data['Attachment']['class'] = 'ContestUser';
        } else {
            $_data['Attachment']['id'] = $attachment['Attachment']['id'];
        }
        if (!empty($upload['AudioUpload']['audio_url']) && $upload['AudioUpload']['upload_status_id'] == ConstUploadStatus::Success) {
            $_data['Attachment']['soundcloud_audio_id'] = $upload['AudioUpload']['soundcloud_audio_id'];
            $_data['Attachment']['soundcloud_audio_url'] = $upload['AudioUpload']['audio_url'];
        }
       $this->Attachment->save($_data);
        $contestUserData['ContestUser']['id'] = $upload['AudioUpload']['contest_user_id'];
		$contestUserData['ContestUser']['is_active'] = 1;
		if(!empty($upload['ContestUser']['Contest']['contest_status_id']) && ($upload['ContestUser']['Contest']['contest_status_id'] == 10 || $upload['ContestUser']['Contest']['contest_status_id'] == 11)){
        	$contestUserData['ContestUser']['is_active'] = 1;
		} else {
			$contestUserData['ContestUser']['is_active'] = 0;
		}	
        if ($upload['AudioUpload']['upload_status_id'] == ConstUploadStatus::Success) {
            $contestUserData['ContestUser']['is_active'] = 1;
            //sending message (only after upload success)
            $message_id = $this->ContestUser->saveMessageContent($upload, $upload['ContestUser']['User']['username']);
            $msg = $is_saved = $this->ContestUser->_saveMessage(0, '', $upload['ContestUser']['contest_owner_user_id'], $upload['ContestUser']['User']['id'], $message_id, ConstMessageFolder::Inbox, 0, 0, 0, strlen($upload['ContestUser']['description']) , $upload['ContestUser']['contest_id'], $upload['AudioUpload']['contest_user_id'], ConstContestStatus::Open, 0, 1);
            // To save in sent iteams //
            $is_saved = $this->ContestUser->_saveMessage(0, '', $upload['ContestUser']['User']['id'], $upload['ContestUser']['contest_owner_user_id'], $message_id, ConstMessageFolder::SentMail, 1, 1, 0, strlen($upload['ContestUser']['description']) , $upload['ContestUser']['contest_id'], $upload['AudioUpload']['contest_user_id'], ConstContestStatus::Open, 0, 1);
            // messages ending
            // Adding attachment for new messageContent
            $this->ContestUser->saveAttachment($_data, $upload);
			if($upload['ContestUser']['Contest']['contest_status_id'] == ConstContestStatus::ChangeRequested) {
				 $this->ContestUser->Contest->updateStatus(ConstContestStatus::ChangeCompleted, $upload['ContestUser']['Contest']['id']);
			}
			$this->ContestUser->postEntryActivity($upload['ContestUser'], $upload['AudioUpload']['contest_user_id']);
        }
        $this->ContestUser->save($contestUserData);
        //Getting upload count, error count and filesize for storing services table
        $serviceTotalUploadCount = $this->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_service_id' => $upload['AudioUpload']['upload_service_id']
            ),
			'recursive' => -1
        ));
        $serviceTotalUploadErrorCount = $this->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_service_id' => $upload['AudioUpload']['upload_service_id'],
                'AudioUpload.upload_status_id' => ConstUploadStatus::Failure
            ),
			'recursive' => -1
        ));
        if ($upload['AudioUpload']['upload_service_id'] != ConstUploadService::Vimeo) {
            $serviceTotalUploadFileSize = $this->find('first', array(
                'conditions' => array(
                    'AudioUpload.upload_service_id' => $upload['AudioUpload']['upload_service_id'],
                ) ,
                'fields' => array(
                    'SUM(AudioUpload.filesize) as total_filesize'
                ) ,
                'recursive' => -1
            ));
            $serviceData['AudioUploadService']['total_upload_filesize'] = $serviceTotalUploadFileSize[0]['total_filesize'];
        }
        $serviceData['AudioUploadService']['id'] = $upload['AudioUpload']['upload_service_id'];
        $serviceData['AudioUploadService']['total_upload_count'] = $serviceTotalUploadCount;
        $serviceData['AudioUploadService']['total_upload_error_count'] = $serviceTotalUploadErrorCount;
        $this->AudioUploadService->save($serviceData);
        //Getting upload count, error count and filesize for storing service_hosters table
        $hosterTotalUploadCount = $this->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_service_id' => $upload['AudioUpload']['upload_service_id'],
                'AudioUpload.upload_service_type_id' => $upload['AudioUpload']['upload_service_type_id']
            ),
			'recursive' => -1
        ));
        $hosterTotalUploadErrorCount = $this->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_service_id' => $upload['AudioUpload']['upload_service_id'],
                'AudioUpload.upload_service_type_id' => $upload['AudioUpload']['upload_service_type_id'],
                'AudioUpload.upload_status_id' => ConstUploadStatus::Failure
            ),
			'recursive' => -1
        ));
        $hosterTotalUploadFileSize = $this->find('first', array(
            'conditions' => array(
                'AudioUpload.upload_service_id' => $upload['AudioUpload']['upload_service_id'],
                'AudioUpload.upload_service_type_id' => $upload['AudioUpload']['upload_service_type_id'],
            ) ,
            'fields' => array(
                'SUM(AudioUpload.filesize) as total_filesize'
            ) ,
            'recursive' => -1
        ));
        App::import('Model', 'AudioResources.AudioUploadHoster');
        $this->AudioUploadHoster = new AudioUploadHoster();
        $this->AudioUploadHoster->updateAll(array(
            'AudioUploadHoster.total_upload_count' => $hosterTotalUploadCount,
            'AudioUploadHoster.total_upload_filesize' => $hosterTotalUploadFileSize[0]['total_filesize'],
            'AudioUploadHoster.total_upload_error_count' => $hosterTotalUploadErrorCount,
        ) , array(
            'AudioUploadHoster.upload_service_id' => $upload['AudioUpload']['upload_service_id'],
            'AudioUploadHoster.upload_service_type_id' => $upload['AudioUpload']['upload_service_type_id']
        ));
    }
	
    public function uploadAudio($contest_user_id, $requestData, $userName, $userId, $reentry = null, $contest = null)
    {
        if (empty($reentry)) {
            $contestUserData['ContestUser']['is_active'] = 0;
            $this->ContestUser->save($contestUserData);
        }
        $is_file_uplaoded = false; 
		$target_path = APP . 'media' . DS . 'ContestUser' . DS . $contest_user_id . DS . $requestData['Attachment']['audio']['name'];
		if(Configure::read('hoster_audio_type')=='direct'){
			$target_path = $requestData['Attachment']['audio']['tmp_name'];
		}else{
			if (!$reentry) {
				@mkdir(APP . 'media' . DS . 'ContestUser' . DS . $contest_user_id, 0777);
			}
			$model_path = $target_path;
			$temp_path = substr($target_path, 0, strlen($target_path) -strlen(strrchr($requestData['Attachment']['audio']['name'], "."))); //temp path without the ext
			//make sure the file doesn't already exist, if it does, add an itteration to it
			$i = 1;
			while (file_exists($target_path)) {
				$target_path = $temp_path . "-" . $i . strrchr($requestData['Attachment']['audio']['name'], ".");
				$i++;
			}
			if(!$requestData['Attachment']['audio']['error']){
				$is_file_uplaoded = move_uploaded_file($requestData['Attachment']['audio']['tmp_name'], $target_path);
			}
		}
		
		$uploadData = array();
		$title = Configure::read('site.name').' - '.$contest['Contest']['name'];
        $contenttype = $requestData['Attachment']['audio']['type'];
        if (!$requestData['Attachment']['audio']['error'] && ((Configure::read('hoster_audio_type')=='normal' && $is_file_uplaoded) || (Configure::read('hoster_audio_type')=='direct')) ) {
            $uploadData['upload_service_type_id'] = ConstUploadServiceType::Normal;
            $uploadData['user_id'] = $userId;
            $uploadData['contest_user_id'] = $contest_user_id;
            $uploadData['upload_status_id'] = ConstUploadStatus::Processing;
            $uploadData['video_url'] = $requestData['Attachment']['audio']['name'];
            $uploadData['filesize'] = $requestData['Attachment']['audio']['size'];
            $uploadData['audio_title'] = $title;
            if (Configure::read('hoster_audio_service') == 'soundcloud') {
                $uploadData['upload_service_id'] = ConstUploadService::SoundCloud;
                $this->save($uploadData);
                $_data = array();
                $_data['id'] = $this->getLastInsertId();
                try {
					App::import('Vendor', 'AudioResources.Soundcloud/Soundcloud');
					$soundcloud = new Services_Soundcloud(Configure::read('soundcloud_client_id') , Configure::read('soundcloud_client_secret'));
					$soundcloud->setCurlOptions(array(CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST, 0));
					$tokens = $soundcloud->credentialsFlow(Configure::read('soundcloud_username'), Configure::read('soundcloud_password'));
					$soundcloud->setAccessToken($tokens['access_token']); 
					// upload audio file
					$track = $soundcloud->post('tracks', array(
							'track[title]' => $title,
							'track[asset_data]' => '@' .$target_path,
							'track[sharing]' => 'private',
							'track[downloadable]' => false,
							'track[streamable]' => true,
							'track[embeddable_by]' => 'me'
						)
					);
					$track_data = json_decode($track, true);
					switch (json_last_error()) {
						case JSON_ERROR_NONE:
							$_data['upload_status_id'] = ConstUploadStatus::Processing;
							 $status_value = $track_data['state'];
							 $_data['soundcloud_audio_id'] = $track_data['id'];
							if(!empty($track_data['secret_uri'])){
								$_data['audio_url'] = $track_data['secret_uri'];
							}
							if($track_data['state'] == 'finished'){
								$_data['audio_url'] = $track_data['secret_uri'];
								$_data['upload_status_id'] = ConstUploadStatus::Success;
							}elseif($track_data['state'] == 'failed'){
								$_data['upload_status_id'] = ConstUploadStatus::Failure;
								$_data['soundcloud_audio_id'] = null;
							}
						break;
						default:
							 $status_value = 'failed';
							 $_data['upload_status_id'] = ConstUploadStatus::Failure;
							 $_data['soundcloud_audio_id'] = null;
						break;
                	}
				}
                catch(VimeoAPIException $e) {
                    $_data['upload_status_id'] = ConstUploadStatus::Failure;
					$_data['soundcloud_audio_id'] = null;
                    $_data['failure_message'] = $e->getMessage();
                    $status_value = 'failed';
                }
            $this->save($_data);
        } else {
            $status_value = 'failed';
        }
        return $status_value;
    }
  }
}
