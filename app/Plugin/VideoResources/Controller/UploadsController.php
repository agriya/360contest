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
class UploadsController extends AppController
{
    public $name = 'Uploads';
    public function beforeFilter()
    {
        // Disable Security component for XHR
        if ($this->RequestHandler->isAjax()) {
            $this->Security->csrfCheck = false;
            $this->Security->validatePost = false;
        }
        parent::beforeFilter();
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Video Uploads');
       $conditions['OR']['Upload.upload_service_id'] = array(
	   		ConstUploadService::Vimeo,
			ConstUploadService::YouTube
	   );
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstUploadStatus::Success) {
                $conditions['Upload.upload_status_id'] = ConstUploadStatus::Success;
                $this->pageTitle.= __l(' - Success');
            } else if ($this->request->params['named']['filter_id'] == ConstUploadStatus::Processing) {
                $conditions['Upload.upload_status_id'] = ConstUploadStatus::Processing;
                $this->pageTitle.= __l(' - Processing');
            } else if ($this->request->params['named']['filter_id'] == ConstUploadStatus::Failure) {
                $conditions['Upload.upload_status_id'] = ConstUploadStatus::Failure;
                $this->pageTitle.= __l(' - Failure');
            }
        }
        if (!empty($this->request->params['named']['upload_service_id']) && !empty($this->request->params['named']['upload_service_type_id'])) {
            if (isset($this->request->params['named']['is_error'])) {
                $conditions['Upload.upload_service_id'] = $this->request->params['named']['upload_service_id'];
                $conditions['Upload.upload_service_type_id'] = $this->request->params['named']['upload_service_type_id'];
                $conditions['Upload.upload_status_id'] = ConstUploadStatus::Failure;
                $this->pageTitle.= __l(' - Failure Message');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::Vimeo && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Direct) {
                $conditions['Upload.upload_service_id'] = ConstUploadService::Vimeo;
                $conditions['Upload.upload_service_type_id'] = ConstUploadServiceType::Direct;
                $this->pageTitle.= __l(' - Vimeo Direct');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::Vimeo && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Normal) {
                $conditions['Upload.upload_service_id'] = ConstUploadService::Vimeo;
                $conditions['Upload.upload_service_type_id'] = ConstUploadServiceType::Normal;
                $this->pageTitle.= __l(' - Vimeo Normal');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::YouTube && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Direct) {
                $conditions['Upload.upload_service_id'] = ConstUploadService::YouTube;
                $conditions['Upload.upload_service_type_id'] = ConstUploadServiceType::Direct;
                $this->pageTitle.= __l(' - Youtube Direct');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::YouTube && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Normal) {
                $conditions['Upload.upload_service_id'] = ConstUploadService::YouTube;
                $conditions['Upload.upload_service_type_id'] = ConstUploadServiceType::Normal;
                $this->pageTitle.= __l(' - Youtube Normal');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'UploadService',
                'UploadStatus',
                'UploadServiceType',
                'User',
                'ContestUser' => array(
                    'Contest'
                )
            ) ,
            'order' => array(
                'Upload.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        $this->set('uploads', $this->paginate());
        $this->set('success', $this->Upload->find('count', array(
            'conditions' => array(
                'Upload.upload_status_id' => ConstUploadStatus::Success,
            ) ,
            'recursive' => -1
        )));
        $this->set('processing', $this->Upload->find('count', array(
            'conditions' => array(
                'Upload.upload_status_id' => ConstUploadStatus::Processing,
            ) ,
            'recursive' => -1
        )));
        $this->set('failure', $this->Upload->find('count', array(
            'conditions' => array(
                'Upload.upload_status_id' => ConstUploadStatus::Failure,
            ) ,
            'recursive' => -1
        )));
    }
    public function direct_metadata()
    {
        if (empty($this->request->data)) {
            throw new NotFoundException(__l('Invalid request'));
        }
		$return_data = array();
		$return_data['status'] = 'success';
		$contest = $this->Upload->ContestUser->Contest->find('first', array(
			'conditions' => array(
				'Contest.id' => $this->request->data['id']
			) ,
			'recursive' => -1
		));
		$title = Configure::read('site.name').' - '.$contest['Contest']['name'];
			if ($this->request->data['service'] == 'youtube') {
				// Get Token //
				App::import('Vendor', 'VideoResources.Youtube/Zend/Loader');
				Zend_Loader::loadClass('Zend_Gdata_YouTube');
				Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
				$authenticationURL = 'https://www.google.com/accounts/ClientLogin';
				$httpClient = Zend_Gdata_ClientLogin::getHttpClient($username = Configure::read('youtube_username') , $password = Configure::read('youtube_password') , $service = 'youtube', $client = null, $source = 'MySource', // a short string identifying your application
				$loginToken = null, $loginCaptcha = null, $authenticationURL);
				$applicationId = '';
				$yt = new Zend_Gdata_YouTube($httpClient, $applicationId, Configure::read('youtube_client_id') , Configure::read('youtube_developer_key'));
				// create a new VideoEntry object
				$myVideoEntry = new Zend_Gdata_YouTube_VideoEntry();
				$myVideoEntry->setVideoTitle($title);
				$myVideoEntry->setVideoDescription($this->request->data['description']);
				$myVideoEntry->setVideoCategory("Autos");
				// unlisted privacy
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
				$tokenHandlerUrl = 'http://gdata.youtube.com/action/GetUploadToken';
				$tokenArray = $yt->getFormUploadToken($myVideoEntry, $tokenHandlerUrl);
				$tokenValue = $tokenArray['token'];
				$postUrl = $tokenArray['url'];
				$contestUserData = array();
				$contestUserData['video_title'] = $title;
				$contestUserData['user_id'] = $this->Auth->user('id');
				$contestUserData['contest_owner_user_id'] = $contest['Contest']['user_id'];
				$contestUserData['contest_id'] = $this->request->data['id'];
				$contestUserData['description'] = $this->request->data['description'];
				$uploadData = array();
				if(isset($this->request->data['revised'])) {
					$contestUser = $this->Upload->ContestUser->find('first', array(
						'conditions' => array(
							'ContestUser.contest_id' => $this->request->data['id'],
							'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
						) ,
						'recursive' => -1
					));
					$return_data['contest_user_id'] = $uploadData['contest_user_id'] = $contestUser['ContestUser']['id'];
				} else {
					$contestUserData['is_active'] = 0;
					$this->Upload->ContestUser->save($contestUserData);
					$return_data['contest_user_id'] = $uploadData['contest_user_id'] = $this->Upload->ContestUser->getLastInsertId();
				}
				$uploadData['video_title'] = $title;
				$uploadData['upload_service_id'] = ConstUploadService::YouTube;
				$uploadData['upload_service_type_id'] = ConstUploadServiceType::Direct;
				$uploadData['user_id'] = $this->Auth->user('id');
				$uploadData['upload_status_id'] = ConstUploadStatus::Processing;
				$uploadData['video_url'] = $this->request->data['name'];
				$this->Upload->save($uploadData);
				$return_data['upload_token_id'] = $this->Upload->getLastInsertId();
				$return_data['contest_id'] = $this->request->data['id'];
				$return_data['token'] = $tokenValue;
				$return_data['url'] = $postUrl;
				$return_data['title'] = $title;
				$return_data['description'] = $this->request->data['description'];
				$return_data['nexturl'] = Router::url(array(
					'controller' => 'uploads',
					'action' => 'direct_return',
					'youtube',
					$return_data['upload_token_id'],
					$return_data['contest_id'],
					'admin' => false
				) , true);
			} else if ($this->request->data['service'] == 'vimeo') {
				if ($this->Upload->vimeoCheckQuota(Configure::read('hoster_service') , $this->request->data['size']) == false) {
					$this->Session->setFlash(__l('Problem in uploading. Please try again later.') , 'default', null, 'error');
					$return_data['status'] = 'failed';
				} else {
					// Get Token //
					$params = array();
					App::import('Vendor', 'VideoResources.Vimeo/vimeo');
					$vimeo = new phpVimeo(Configure::read('vimeo_api_key') , Configure::read('vimeo_secret_key') , Configure::read('vimeo_access_token') , Configure::read('vimeo_access_token_secret'));
					$rsp = $vimeo->call('vimeo.videos.upload.getTicket', $params, 'GET', 'http://vimeo.com/api/rest/v2', false);
					$ticket = $rsp->ticket->id;
					$endpoint = $rsp->ticket->endpoint;
					$contestUserData = array();
					$contestUserData['video_title'] = $title;
					$contestUserData['user_id'] = $this->Auth->user('id');
					$contestUserData['contest_owner_user_id'] = $contest['Contest']['user_id'];
					$contestUserData['contest_id'] = $this->request->data['id'];
					$contestUserData['description'] = $this->request->data['description'];
					$uploadData = array();
					if(isset($this->request->data['revised'])) {
						$contestUser = $this->Upload->ContestUser->find('first', array(
							'conditions' => array(
								'ContestUser.contest_id' => $this->request->data['id'],
								'ContestUser.contest_user_status_id' => ConstContestUserStatus::Won
							) ,
							'recursive' => -1
						));
						$return_data['contest_user_id'] = $uploadData['contest_user_id'] = $contestUser['ContestUser']['id'];
					} else {
						$contestUserData['is_active'] = 0;
						$this->Upload->ContestUser->save($contestUserData);
						$return_data['contest_user_id'] = $uploadData['contest_user_id'] = $this->Upload->ContestUser->getLastInsertId();
					}
					$uploadData['video_title'] = $title;
					$uploadData['upload_service_id'] = ConstUploadService::Vimeo;
					$uploadData['upload_service_type_id'] = ConstUploadServiceType::Direct;
					$uploadData['user_id'] = $this->Auth->user('id');
					$uploadData['upload_status_id'] = ConstUploadStatus::Processing;
					$uploadData['vimeo_video_id'] = $ticket;
					$uploadData['video_url'] = $this->request->data['name'];
					$this->Upload->save($uploadData);
					$return_data['upload_token_id'] = $this->Upload->getLastInsertId();
					$return_data['contest_id'] = $this->request->data['id'];
					$return_data['ticket_id'] = $ticket;
					$return_data['url'] = $endpoint;
					$return_data['title'] = $title;
					$return_data['description'] = $this->request->data['description'];
				}
			}
        $this->autoRender = false;
        return json_encode($return_data);
    }
    public function direct_return($service, $upload_token_id, $contest_id)
    {
        if (empty($service) || empty($upload_token_id) || empty($contest_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $upload = $this->Upload->find('first', array(
            'conditions' => array(
                'Upload.id' => $upload_token_id
            ),
			'recursive' => -1
        ));
        $contest = $this->Upload->ContestUser->Contest->find('first', array(
            'conditions' => array(
                'Contest.id' => $contest_id
            ) ,
            'recursive' => -1
        ));
        $_data = array();
        $return_data = array();
		$is_success = false;
        if ($service == 'youtube') {
            // Get Token //
            App::import('Vendor', 'VideoResources.Youtube/Zend/Loader');
            Zend_Loader::loadClass('Zend_Gdata_YouTube');
            Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
            $yt = new Zend_Gdata_YouTube();
            $authenticationURL = 'https://www.google.com/accounts/ClientLogin';
            $httpClient = Zend_Gdata_ClientLogin::getHttpClient($username = Configure::read('youtube_username') , $password = Configure::read('youtube_password') , $service = 'youtube', $client = null, $source = 'MySource', // a short string identifying your application
            $loginToken = null, $loginCaptcha = null, $authenticationURL);
            $applicationId = '';
            $yt = new Zend_Gdata_YouTube($httpClient, $applicationId, Configure::read('youtube_client_id') , Configure::read('youtube_developer_key'));
            $videoEntry = $yt->getVideoEntry($this->request->query['id']);
            $_data['youtube_video_id'] = $this->request->query['id'];
            try {
                $state = $videoEntry->getVideoState();
                if ($state) {
                    $_data['video_url'] = $videoEntry->getVideoWatchPageUrl();
                    $videoThumbnails = $videoEntry->getVideoThumbnails();
                    foreach($videoThumbnails as $videoThumbnail) {
                        $_data['youtube_thumbnail_url'] = $videoThumbnail['url'];
                        break;
                    }
                    $_data['upload_status_id'] = ConstUploadStatus::Success;
                    $this->Session->setFlash(__l('Your entry has submitted successfully') , 'default', null, 'success');
					$is_success = true;
                }
            }
            catch(VimeoAPIException $e) {
                $_data['upload_status_id'] = ConstUploadStatus::Processing;
                $_data['failure_message'] = $e->getMessage();
            }
            $_data['id'] = $upload['Upload']['id'];
            $this->Upload->save($_data);
			if($is_success){
				$this->update_maxumum_entry_no($contest['Contest']['id'], $upload['Upload']['contest_user_id']);
			}
            $return_data['redirect_url'] = Router::url(array(
                'controller' => 'contests',
                'action' => $contest['Contest']['slug'],
                'admin' => false
            ) , false);
        } else if ($service == 'vimeo') {
            App::import('Vendor', 'VideoResources.Vimeo/vimeo');
            $vimeo = new phpVimeo(Configure::read('vimeo_api_key') , Configure::read('vimeo_secret_key') , Configure::read('vimeo_access_token') , Configure::read('vimeo_access_token_secret'));
            // Complete the upload
            try {
                $complete = $vimeo->call('vimeo.videos.upload.complete', array(
                    'filename' => $upload['Upload']['video_url'],
                    'ticket_id' => $upload['Upload']['vimeo_video_id'],
                ) , 'POST', 'http://vimeo.com/api/rest/v2', false);
                if ($complete->stat == 'ok') {
					$_data['vimeo_video_id'] =  $complete->ticket->video_id;
					$privacy = $vimeo->call('vimeo.videos.embed.setPrivacy', array('video_id' => $_data['vimeo_video_id'], 'approved_domains' => json_encode(explode(',',Configure::read('vimeo_approved_domains'))), 'privacy' => 'approved'), 'GET', 'http://vimeo.com/api/rest/v2', false);
					$vimeo->call('vimeo.videos.setTitle', array(
						'title' => $contest['Contest']['name'],
						'video_id' => $_data['vimeo_video_id']
					));
					$vimeo->call('vimeo.videos.setDescription', array(
						'description' => $upload['ContestUser']['description'],
						'video_id' => $_data['vimeo_video_id']
					));
					$is_success = true;
                    $this->Session->setFlash(__l('Your entry has submitted successfully') , 'default', null, 'success');
                }
            }
            catch(VimeoAPIException $e) {
                $_data['failure_message'] = $e->getMessage();
                $this->Session->setFlash(sprintf(__l('%s could not be added. Please, try again.') , __l('Entry')) , 'default', null, 'error');
            }
            $_data['id'] = $upload['Upload']['id'];
            $this->Upload->save($_data);
            $contest = $this->Upload->ContestUser->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $contest_id
                ) ,
                'recursive' => -1
            ));
			$this->update_maxumum_entry_no($contest['Contest']['id'], $upload['Upload']['contest_user_id']);
            $return_data['redirect_url'] = Router::url(array(
                'controller' => 'contests',
                'action' => $contest['Contest']['slug'],
                'admin' => false
            ) , false);
        }
        $this->autoRender = false;
        return json_encode($return_data);
    }
    private function _check_status($upload)
    {
        $_data = array();
        $return = false;
		if ($upload['Upload']['upload_status_id'] != ConstUploadStatus::Success) {
			if ($upload['Upload']['upload_service_id'] == ConstUploadService::YouTube) {
				$video_id = $upload['Upload']['youtube_video_id'];
				App::import('Vendor', 'VideoResources.Youtube/Zend/Loader');
				Zend_Loader::loadClass('Zend_Gdata_YouTube');
				Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
				$yt = new Zend_Gdata_YouTube();
				$authenticationURL = 'https://www.google.com/accounts/ClientLogin';
				$httpClient = Zend_Gdata_ClientLogin::getHttpClient($username = Configure::read('youtube_username') , $password = Configure::read('youtube_password') , $service = 'youtube', $client = null, $source = 'MySource', // a short string identifying your application
				$loginToken = null, $loginCaptcha = null, $authenticationURL);
				$applicationId = '';
				$yt = new Zend_Gdata_YouTube($httpClient, $applicationId, Configure::read('youtube_client_id') , Configure::read('youtube_developer_key'));
				$videoEntry = $yt->getVideoEntry($video_id);
				try {
					$state = $videoEntry->getVideoState();
					if ($state) {
						$_data['video_url'] = $videoEntry->getVideoWatchPageUrl();
						$videoThumbnails = $videoEntry->getVideoThumbnails();
						foreach($videoThumbnails as $videoThumbnail) {
							$_data['youtube_thumbnail_url'] = $videoThumbnail['url'];
							break;
						}
						if($state->getName() == 'rejected') {
							$_data['upload_status_id'] = ConstUploadStatus::Failure;
							$return = true;
						} else if ($state->getName() == 'failed') {
							$_data['upload_status_id'] = ConstUploadStatus::Failure;
							$return = true;
						} else if ($state->getName() == 'success') {
							$_data['upload_status_id'] = ConstUploadStatus::Success;
							$return = true;
						} else if($state->getName() == 'processing') {
							$_data['upload_status_id'] = ConstUploadStatus::Processing;
							$return = false;
						}
					} else {
						$_data['video_url'] = $videoEntry->getVideoWatchPageUrl();
						$videoThumbnails = $videoEntry->getVideoThumbnails();
						foreach($videoThumbnails as $videoThumbnail) {
							$_data['youtube_thumbnail_url'] = $videoThumbnail['url'];
							break;
						}
						$_data['upload_status_id'] = ConstUploadStatus::Success;
						$return = true;
					}
				}
				catch(Zend_Gdata_App_HttpException $httpException) {
					$_data['upload_status_id'] = ConstUploadStatus::Failure;
					$_data['failure_message'] = $httpException->getRawResponseBody();
					$return = false;
				}
				catch(Zend_Gdata_App_Exception $e) {
					$_data['upload_status_id'] = ConstUploadStatus::Failure;
                    $_data['failure_message'] = $e->getMessage();
                   $return = false;
                }
				$_data['id'] = $upload['Upload']['id'];
				$this->Upload->save($_data);
			} elseif ($upload['Upload']['upload_service_id'] == ConstUploadService::Vimeo) {
				$video_id = $upload['Upload']['vimeo_video_id'];
				App::import('Vendor', 'VideoResources.Vimeo/vimeo');
				$vimeo = new phpVimeo(Configure::read('vimeo_api_key') , Configure::read('vimeo_secret_key') , Configure::read('vimeo_access_token') , Configure::read('vimeo_access_token_secret'));
				// Complete the upload
				try {
					$complete = $vimeo->call('vimeo.videos.getInfo', array(
						'video_id' => $video_id
					));
					if ($complete->stat == 'ok') {
						$_data['video_url'] = $complete->video[0]->urls->url[0]->_content;
						$_data['vimeo_thumbnail_url'] = $complete->video[0]->thumbnails->thumbnail[0]->_content;
						$_data['upload_status_id'] = ConstUploadStatus::Success;
						$return = true;
					} else {
						$_data['upload_status_id'] = ConstUploadStatus::Processing;
						$return = false;
					}
				}
				catch(VimeoAPIException $e) {
					$_data['upload_status_id'] = ConstUploadStatus::Failure;
					$_data['failure_message'] = $e->getMessage();
					$return = false;
				}
				$_data['id'] = $upload['Upload']['id'];
				$this->Upload->save($_data);
			}
		}
        return $return;
    }
    public function check_status($upload_id)
    {
        if (empty($upload_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $upload = $this->Upload->find('first', array(
            'conditions' => array(
                'Upload.id' => $upload_id
            ),
			'recursive' => -1
        ));
        if ($this->_check_status($upload)) {
            $this->Session->setFlash(__l('Your entry video status has updated successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(sprintf(__l('%s video status could not be updated. Please, try again.') , __l('Entry')) , 'default', null, 'error');
        }
        $this->redirect(array(
			'controller' => 'contest_users',
            'action' => 'index',
            'type' => 'myparticipation'
        ));
    }
    public function admin_check_status($upload_id)
    {
        if (empty($upload_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $upload = $this->Upload->find('first', array(
            'conditions' => array(
                'Upload.id' => $upload_id
            ),
			'recursive' => -1
        ));
        if ($this->_check_status($upload)) {
            $this->Session->setFlash(__l('Your entry video status has updated successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(sprintf(__l('%s video status could not be updated. Please, try again.') , __l('Entry')) , 'default', null, 'error');
        }
        $this->redirect(array(
            'controller' => 'uploads',
            'action' => 'index',
            'admin' => true
        ));
    }
    public function videoFileTypeValidate($file_type, $mime_type)
    {
        if (empty($file_type)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $allowedExt = Configure::read('contestuser.video_file.allowedMime');
        $_data = array();
        $fileType = $file_type . '/' . $mime_type;
        if (in_array($fileType, $allowedExt)) {
            $_data['status'] = true;
        } else {
            $_data['status'] = false;
        }
        $this->autoRender = false;
        return json_encode($_data);
    }
	private function update_maxumum_entry_no($contest_id, $contest_user_id)
    {
        $entry_no = $this->Upload->ContestUser->updateMaxumumEntryNo($contest_id, $contest_user_id);
        return $entry_no;
    }
}
?>