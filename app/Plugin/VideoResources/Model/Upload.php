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
class Upload extends AppModel
{
    public $name = 'Upload';
    public $belongsTo = array(
        'UploadService' => array(
            'className' => 'VideoResources.UploadService',
            'foreignKey' => 'upload_service_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UploadServiceType' => array(
            'className' => 'VideoResources.UploadServiceType',
            'foreignKey' => 'upload_service_type_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        ) ,
        'UploadStatus' => array(
            'className' => 'VideoResources.UploadStatus',
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
        if ($created && Configure::read('hoster_service') == 'vimeo') {
			$this->UploadService->updateQuota(ConstUploadService::Vimeo);
        }
        $upload = $this->find('first', array(
            'conditions' => array(
                'Upload.id' => $this->id
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
                'Attachment.foreign_id' => $upload['Upload']['contest_user_id'],
                'Attachment.class' => 'ContestUser'
            ) ,
            'recursive' => -1
        ));
        $_data['Attachment']['foreign_id'] = $upload['Upload']['contest_user_id'];
        if (empty($attachment)) {
            $this->Attachment->create();
            $_data['Attachment']['class'] = 'ContestUser';
        } else {
            $_data['Attachment']['id'] = $attachment['Attachment']['id'];
        }
        if ($upload['Upload']['vimeo_video_id']) {
            $_data['Attachment']['vimeo_video_id'] = $upload['Upload']['vimeo_video_id'];
            $_data['Attachment']['vimeo_thumbnail_url'] = $upload['Upload']['vimeo_thumbnail_url'];
        }
        if ($upload['Upload']['youtube_video_id']) {
            $_data['Attachment']['youtube_video_id'] = $upload['Upload']['youtube_video_id'];
            $_data['Attachment']['youtube_thumbnail_url'] = $upload['Upload']['youtube_thumbnail_url'];
        }
        $this->Attachment->save($_data);
        $contestUserData['ContestUser']['id'] = $upload['Upload']['contest_user_id'];
		$contestUserData['ContestUser']['is_active'] = 1;
		if(!empty($upload['ContestUser']['Contest']['contest_status_id']) && ($upload['ContestUser']['Contest']['contest_status_id'] == 10 || $upload['ContestUser']['Contest']['contest_status_id'] == 11)){
        	$contestUserData['ContestUser']['is_active'] = 1;
		} else {
			$contestUserData['ContestUser']['is_active'] = 0;
		}	
        if ($upload['Upload']['upload_status_id'] == ConstUploadStatus::Success) {
            $contestUserData['ContestUser']['is_active'] = 1;
            //sending message (only after upload success)
            $message_id = $this->ContestUser->saveMessageContent($upload, $upload['ContestUser']['User']['username']);
            $msg = $is_saved = $this->ContestUser->_saveMessage(0, '', $upload['ContestUser']['contest_owner_user_id'], $upload['ContestUser']['User']['id'], $message_id, ConstMessageFolder::Inbox, 0, 0, 0, strlen($upload['ContestUser']['description']) , $upload['ContestUser']['contest_id'], $upload['Upload']['contest_user_id'], ConstContestStatus::Open, 0, 1);
            // To save in sent iteams //
            $is_saved = $this->ContestUser->_saveMessage(0, '', $upload['ContestUser']['User']['id'], $upload['ContestUser']['contest_owner_user_id'], $message_id, ConstMessageFolder::SentMail, 1, 1, 0, strlen($upload['ContestUser']['description']) , $upload['ContestUser']['contest_id'], $upload['Upload']['contest_user_id'], ConstContestStatus::Open, 0, 1);
            // messages ending
            // Adding attachment for new messageContent
            $this->ContestUser->saveAttachment($_data, $upload);
			if($upload['ContestUser']['Contest']['contest_status_id'] == ConstContestStatus::ChangeRequested) {
				 $this->ContestUser->Contest->updateStatus(ConstContestStatus::ChangeCompleted, $upload['ContestUser']['Contest']['id']);
			}
			$this->ContestUser->postEntryActivity($upload['ContestUser'], $upload['Upload']['contest_user_id']);
        }
        $this->ContestUser->save($contestUserData);
        //Getting upload count, error count and filesize for storing services table
        $serviceTotalUploadCount = $this->find('count', array(
            'conditions' => array(
                'Upload.upload_service_id' => $upload['Upload']['upload_service_id']
            ),
			'recursive' => -1
        ));
        $serviceTotalUploadErrorCount = $this->find('count', array(
            'conditions' => array(
                'Upload.upload_service_id' => $upload['Upload']['upload_service_id'],
                'Upload.upload_status_id' => ConstUploadStatus::Failure
            ),
			'recursive' => -1
        ));
        if ($upload['Upload']['upload_service_id'] != ConstUploadService::Vimeo) {
            $serviceTotalUploadFileSize = $this->find('first', array(
                'conditions' => array(
                    'Upload.upload_service_id' => $upload['Upload']['upload_service_id'],
                ) ,
                'fields' => array(
                    'SUM(Upload.filesize) as total_filesize'
                ) ,
                'recursive' => -1
            ));
            $serviceData['UploadService']['total_upload_filesize'] = $serviceTotalUploadFileSize[0]['total_filesize'];
        }
        $serviceData['UploadService']['id'] = $upload['Upload']['upload_service_id'];
        $serviceData['UploadService']['total_upload_count'] = $serviceTotalUploadCount;
        $serviceData['UploadService']['total_upload_error_count'] = $serviceTotalUploadErrorCount;
        $this->UploadService->save($serviceData);
        //Getting upload count, error count and filesize for storing service_hosters table
        $hosterTotalUploadCount = $this->find('count', array(
            'conditions' => array(
                'Upload.upload_service_id' => $upload['Upload']['upload_service_id'],
                'Upload.upload_service_type_id' => $upload['Upload']['upload_service_type_id']
            ),
			'recursive' => -1
        ));
        $hosterTotalUploadErrorCount = $this->find('count', array(
            'conditions' => array(
                'Upload.upload_service_id' => $upload['Upload']['upload_service_id'],
                'Upload.upload_service_type_id' => $upload['Upload']['upload_service_type_id'],
                'Upload.upload_status_id' => ConstUploadStatus::Failure
            ),
			'recursive' => -1
        ));
        $hosterTotalUploadFileSize = $this->find('first', array(
            'conditions' => array(
                'Upload.upload_service_id' => $upload['Upload']['upload_service_id'],
                'Upload.upload_service_type_id' => $upload['Upload']['upload_service_type_id'],
            ) ,
            'fields' => array(
                'SUM(Upload.filesize) as total_filesize'
            ) ,
            'recursive' => -1
        ));
        App::import('Model', 'VideoResources.UploadHoster');
        $this->UploadHoster = new UploadHoster();
        $this->UploadHoster->updateAll(array(
            'UploadHoster.total_upload_count' => $hosterTotalUploadCount,
            'UploadHoster.total_upload_filesize' => $hosterTotalUploadFileSize[0]['total_filesize'],
            'UploadHoster.total_upload_error_count' => $hosterTotalUploadErrorCount,
        ) , array(
            'UploadHoster.upload_service_id' => $upload['Upload']['upload_service_id'],
            'UploadHoster.upload_service_type_id' => $upload['Upload']['upload_service_type_id']
        ));
    }
    public function vimeoCheckQuota($service, $file_size)
    {
		$this->UploadService->updateQuota(ConstUploadService::Vimeo);
        if (!empty($service) && !empty($file_size)) {
            $UploadService = $this->UploadService->find('first', array(
                'conditions' => array(
                    'slug' => $service
                ) ,
                'recursive' => -1
            ));
            $remain_space = $UploadService['UploadService']['total_quota']-$UploadService['UploadService']['total_upload_filesize'];
            if ($file_size > $remain_space) {
                $emailFindReplace = array(
                    '##SERVICE##' => $service,
                );
                // Send e-mail to admin
				App::import('Model', 'EmailTemplate');
				$this->EmailTemplate = new EmailTemplate();
				$template = $this->EmailTemplate->selectTemplate('Account Space Exceeded');
                $this->_sendEmail($template, $emailFindReplace, Configure::read('EmailTemplate.admin_email'));
                return false;
            } else {
                return true;
            }
        }
    }
    public function uploadVideo($contest_user_id, $requestData, $userName, $userId, $reentry = null, $contest = null)
    {
        if (empty($reentry)) {
            $contestUserData['ContestUser']['is_active'] = 0;
            $this->ContestUser->save($contestUserData);
        }
        if (!$reentry) {
            @mkdir(APP . 'media' . DS . 'ContestUser' . DS . $contest_user_id, 0777);
        }
        $target_path = APP . 'media' . DS . 'ContestUser' . DS . $contest_user_id . DS . $requestData['Attachment']['video']['name'];
        $model_path = $target_path;
        $temp_path = substr($target_path, 0, strlen($target_path) -strlen(strrchr($requestData['Attachment']['video']['name'], "."))); //temp path without the ext
        //make sure the file doesn't already exist, if it does, add an itteration to it
        $i = 1;
        while (file_exists($target_path)) {
            $target_path = $temp_path . "-" . $i . strrchr($requestData['Attachment']['video']['name'], ".");
            $i++;
        }
        $uploadData = array();
		$title = Configure::read('site.name').' - '.$contest['Contest']['name'];
        $contenttype = $requestData['Attachment']['video']['type'];
        if (!$requestData['Attachment']['video']['error'] && move_uploaded_file($requestData['Attachment']['video']['tmp_name'], $target_path)) {
            $uploadData['upload_service_type_id'] = ConstUploadServiceType::Normal;
            $uploadData['user_id'] = $userId;
            $uploadData['contest_user_id'] = $contest_user_id;
            $uploadData['upload_status_id'] = ConstUploadStatus::Processing;
            $uploadData['video_url'] = $requestData['Attachment']['video']['name'];
            $uploadData['filesize'] = $requestData['Attachment']['video']['size'];
            $uploadData['video_title'] = $title;
            if (Configure::read('hoster_service') == 'youtube') {
                $uploadData['upload_service_id'] = ConstUploadService::YouTube;
                $this->ContestUser->Upload->save($uploadData);
                $_data = array();
                $_data['id'] = $this->ContestUser->Upload->getLastInsertId();
                App::import('Vendor', 'VideoResources.Youtube/Zend/Loader');
                Zend_Loader::loadClass('Zend_Gdata_YouTube');
                Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
                $yt = new Zend_Gdata_YouTube();
                $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
                $httpClient = Zend_Gdata_ClientLogin::getHttpClient($username = Configure::read('youtube_username') , $password = Configure::read('youtube_password') , $service = 'youtube', $client = null, $source = 'MySource', // a short string identifying your application
                $loginToken = null, $loginCaptcha = null, $authenticationURL);
                $applicationId = '';
                $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, Configure::read('youtube_client_id') , Configure::read('youtube_developer_key'));
                // create a new VideoEntry object
                $myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
                // create a new Zend_Gdata_App_MediaFileSource object
                $filesource = $yt->newMediaFileSource($target_path);
                $filesource->setContentType($contenttype);
                // set slug header
                $filesource->setSlug('IronMan.flv');
                // add the filesource to the video entry
                $myVideoEntry->setMediaSource($filesource);
				$myVideoEntry->setVideoTitle($title);
                if (isset($requestData['Message']['revised']) && $requestData['Message']['revised'] == 1) {
                    $myVideoEntry->setVideoDescription($requestData['Message']['message']);
                } else {
                    $myVideoEntry->setVideoDescription($requestData['ContestUser']['description']);
                }
                $myVideoEntry->setVideoCategory("Autos");
				// unlisted upload
				$accessControlElement = new Zend_Gdata_App_Extension_Element('yt:accessControl', 'yt', 'http://gdata.youtube.com/schemas/2007', '');
				$accessControlElement->extensionAttributes = array(
					array(
						'namespaceUri' => '',
						'name' => 'action',
						'value' => 'list'
					),
					array(
						'namespaceUri' => '',
						'name' => 'permission',
						'value' => 'denied'
					));
				$myVideoEntry->extensionElements = array($accessControlElement);
				// upload URI for the currently authenticated user
                $uploadUrl = 'http://uploads.gdata.youtube.com/feeds/api/users/default/uploads';
                try {
                    $videoEntry = $yt->insertEntry($myVideoEntry, $uploadUrl, 'Zend_Gdata_YouTube_VideoEntry');
                    $state = $videoEntry->getVideoState();
                    if ($state) {
                        $_data['youtube_video_id'] = $videoEntry->getVideoId();
                        $_data['video_url'] = $videoEntry->getVideoWatchPageUrl();
                        $_data['upload_status_id'] = ConstUploadStatus::Processing;
                        if ($state->getName() == 'processing') {
                            $_data['upload_status_id'] = ConstUploadStatus::Processing;
                        } else if ($state->getName() == 'success') {
                            $_data['upload_status_id'] = ConstUploadStatus::Success;
                        } else {
                            $_data['upload_status_id'] = ConstUploadStatus::Failure;
                        }
                        $videoThumbnails = $videoEntry->getVideoThumbnails();
                        foreach($videoThumbnails as $videoThumbnail) {
                            $_data['youtube_thumbnail_url'] = $videoThumbnail['url'];
                            break;
                        }
                        $status_value = 2;
                    } else {
                        $status_value = 3;
                    }
                }
				catch(Zend_Gdata_App_HttpException $httpException) {
					$_data['upload_status_id'] = ConstUploadStatus::Failure;
					$_data['failure_message'] = $httpException->getRawResponseBody();
					$status_value = 4;
				}
				catch(Zend_Gdata_App_Exception $e) {
					$_data['upload_status_id'] = ConstUploadStatus::Failure;
                    $_data['failure_message'] = $e->getMessage();
                    $status_value = 4;
                }
            } elseif (Configure::read('hoster_service') == 'vimeo') {
                $uploadData['upload_service_id'] = ConstUploadService::Vimeo;
                App::import('Vendor', 'VideoResources.Vimeo/vimeo');
                $vimeo = new phpVimeo(Configure::read('vimeo_api_key') , Configure::read('vimeo_secret_key') , Configure::read('vimeo_access_token') , Configure::read('vimeo_access_token_secret'));
                $params = array();
                $rsp = $vimeo->call('vimeo.videos.upload.getTicket', $params, 'GET', 'http://vimeo.com/api/rest/v2', false);
                $uploadData['vimeo_video_id'] = $rsp->ticket->id;
                $this->ContestUser->Upload->save($uploadData);
                $_data = array();
                $_data['id'] = $this->ContestUser->Upload->getLastInsertId();
                try {
                    $video_id = $vimeo->upload($target_path);
                    if ($video_id) {
                        $_data['vimeo_video_id'] = $video_id;
                        $vimeo->call('vimeo.videos.setTitle', array(
                            'title' => $uploadData['video_title'],
                            'video_id' => $video_id
                        ));
						if (isset($requestData['Message']['revised']) && $requestData['Message']['revised'] == 1) {
                            $vimeo->call('vimeo.videos.setDescription', array(
                                'description' => $requestData['Message']['message'],
                                'video_id' => $video_id
                            ));
                        } else {
                            $vimeo->call('vimeo.videos.setDescription', array(
                                'description' => $requestData['ContestUser']['description'],
                                'video_id' => $video_id
                            ));
                        }

                        $complete = $vimeo->call('vimeo.videos.getInfo', array(
                            'video_id' => $video_id
                        ));
						$privacy = $vimeo->call('vimeo.videos.embed.setPrivacy', array('video_id' => $video_id, 'approved_domains' => json_encode(explode(',',Configure::read('vimeo_approved_domains'))), 'privacy' => 'approved'), 'GET', 'http://vimeo.com/api/rest/v2', false);
                        $_data['upload_status_id'] = ConstUploadStatus::Processing;
                        if ($complete->stat == 'ok') {
                            $_data['video_url'] = $complete->video[0]->urls->url[0]->_content;
                            $_data['upload_status_id'] = ConstUploadStatus::Success;
                            $_data['vimeo_thumbnail_url'] = $complete->video[0]->thumbnails->thumbnail[0]->_content;
                            $_data['upload_status_id'] = ConstUploadStatus::Success;
                            $status_value = 2;
                        }
                    } else {
                        $status_value = 5;
                    }
                }
                catch(VimeoAPIException $e) {
                    $_data['upload_status_id'] = ConstUploadStatus::Failure;
                    $_data['failure_message'] = $e->getMessage();
                    $status_value = 4;
                }
            }
            $this->ContestUser->Upload->save($_data);
        } else {
            $status_value = 1;
        }
        return $status_value;
    }
}
