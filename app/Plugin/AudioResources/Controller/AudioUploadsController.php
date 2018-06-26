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
class AudioUploadsController extends AppController
{
    public $name = 'AudioUploads';
    public function beforeFilter()
    {
        // Disable Security component for XHR
        if ($this->RequestHandler->isAjax()) {
            $this->Security->csrfCheck = false;
            $this->Security->validatePost = false;
        }
        parent::beforeFilter();
    }
	public function _validResponseCode($code)
    {
        return (bool)preg_match('/^20[0-9]{1}$/', $code);
    }
    public function admin_index()
    {
        $this->pageTitle = __l('Audio Uploads');
		$conditions['AudioUpload.upload_service_id'] = ConstUploadService::SoundCloud;
        if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstUploadStatus::Success) {
                $conditions['AudioUpload.upload_status_id'] = ConstUploadStatus::Success;
                $this->pageTitle.= __l(' - Success');
            } else if ($this->request->params['named']['filter_id'] == ConstUploadStatus::Processing) {
                $conditions['AudioUpload.upload_status_id'] = ConstUploadStatus::Processing;
                $this->pageTitle.= __l(' - Processing');
            } else if ($this->request->params['named']['filter_id'] == ConstUploadStatus::Failure) {
                $conditions['AudioUpload.upload_status_id'] = ConstUploadStatus::Failure;
                $this->pageTitle.= __l(' - Failure');
            }
        }
        if (!empty($this->request->params['named']['upload_service_id']) && !empty($this->request->params['named']['upload_service_type_id'])) {
            if (isset($this->request->params['named']['is_error'])) {
                $conditions['AudioUpload.upload_service_id'] = $this->request->params['named']['upload_service_id'];
                $conditions['AudioUpload.upload_service_type_id'] = $this->request->params['named']['upload_service_type_id'];
                $conditions['AudioUpload.upload_status_id'] = ConstUploadStatus::Failure;
                $this->pageTitle.= __l(' - Failure Message');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::Vimeo && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Direct) {
                $conditions['AudioUpload.upload_service_id'] = ConstUploadService::Vimeo;
                $conditions['AudioUpload.upload_service_type_id'] = ConstUploadServiceType::Direct;
                $this->pageTitle.= __l(' - Vimeo Direct');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::Vimeo && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Normal) {
                $conditions['AudioUpload.upload_service_id'] = ConstUploadService::Vimeo;
                $conditions['AudioUpload.upload_service_type_id'] = ConstUploadServiceType::Normal;
                $this->pageTitle.= __l(' - Vimeo Normal');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::YouTube && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Direct) {
                $conditions['AudioUpload.upload_service_id'] = ConstUploadService::YouTube;
                $conditions['AudioUpload.upload_service_type_id'] = ConstUploadServiceType::Direct;
                $this->pageTitle.= __l(' - Youtube Direct');
            } else if ($this->request->params['named']['upload_service_id'] == ConstUploadService::YouTube && $this->request->params['named']['upload_service_type_id'] == ConstUploadServiceType::Normal) {
                $conditions['AudioUpload.upload_service_id'] = ConstUploadService::YouTube;
                $conditions['AudioUpload.upload_service_type_id'] = ConstUploadServiceType::Normal;
                $this->pageTitle.= __l(' - Youtube Normal');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'AudioUploadService',
                'UploadStatus',
                'UploadServiceType',
                'User',
                'ContestUser' => array(
                    'Contest'
                )
            ) ,
            'order' => array(
                'AudioUpload.id' => 'desc'
            ) ,
            'recursive' => 2,
        );
        $this->set('uploads', $this->paginate());
        $this->set('success', $this->AudioUpload->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_status_id' => ConstUploadStatus::Success,
				'AudioUpload.upload_service_id' => ConstUploadService::SoundCloud
            ) ,
            'recursive' => -1
        )));
        $this->set('processing', $this->AudioUpload->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_status_id' => ConstUploadStatus::Processing,
				'AudioUpload.upload_service_id' => ConstUploadService::SoundCloud
            ) ,
            'recursive' => -1
        )));
        $this->set('failure', $this->AudioUpload->find('count', array(
            'conditions' => array(
                'AudioUpload.upload_status_id' => ConstUploadStatus::Failure,
				'AudioUpload.upload_service_id' => ConstUploadService::SoundCloud
            ) ,
            'recursive' => -1
        )));
    }
    private function _check_status($upload)
    {
        $_data = array();
        $return = false;
		if ($upload['AudioUpload']['upload_status_id'] != ConstUploadStatus::Success) {
			if ($upload['AudioUpload']['upload_service_id'] == ConstUploadService::SoundCloud) {
				$soundcloud_id = $upload['AudioUpload']['soundcloud_audio_id'];
				if(!empty($soundcloud_id)){
					try {
						App::import('Vendor', 'AudioResources.Soundcloud/Soundcloud');
						$soundcloud = new Services_Soundcloud(Configure::read('soundcloud_client_id') , Configure::read('soundcloud_client_secret'));
						$soundcloud->setCurlOptions(array(CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST, 0));
						$tokens = $soundcloud->credentialsFlow(Configure::read('soundcloud_username'), Configure::read('soundcloud_password'));
						$soundcloud->setAccessToken($tokens['access_token']); 
						$track = $soundcloud->get('tracks/'.$soundcloud_id, array());
						$track_data = json_decode($track, true);
						switch (json_last_error()) {
							case JSON_ERROR_NONE:
								$return = 'processing';
								if($this->_validResponseCode($track_data['http_code'])){
									$_data['upload_status_id'] = ConstUploadStatus::Processing;
									$_data['soundcloud_audio_id'] = $track_data['id'];
									if(!empty($track_data['secret_uri'])){
										$_data['audio_url'] = $track_data['secret_uri'];
										$_data['upload_status_id'] = ConstUploadStatus::Success;
										$return = 'finished';
									}
									if($track_data['state'] == 'finished'){
										$_data['audio_url '] = $track_data['secret_uri'];
										$_data['upload_status_id'] = ConstUploadStatus::Success;
										$return = 'finished';
									}elseif($track_data['state'] == 'failed'){
										$_data['upload_status_id'] = ConstUploadStatus::Failure;
										$_data['soundcloud_audio_id'] = null;
										 $return = 'failed';
									}
								
								}else{
									$_data['upload_status_id'] = ConstUploadStatus::Failure;
									$_data['soundcloud_audio_id'] = null;
									 $return = 'failed';
								}
								
							break;
							default:
								 $return = 'failed';
							break;
						}
					}
					catch(Exception $e) {
						$_data['upload_status_id'] = ConstUploadStatus::Failure;
						$_data['soundcloud_audio_id'] = null;
						$_data['failure_message'] = $e->getMessage();
						$return = 'failed';
					}
				}else{
					$_data['upload_status_id'] = ConstUploadStatus::Failure;
					$_data['failure_message'] = __l('Audio file did not exist!');
					$return = 'failed';
				}
				
				$_data['id'] = $upload['AudioUpload']['id'];
				$this->AudioUpload->save($_data);
			}
		}
        return $return;
    }
    public function check_status($upload_id)
    {
        if (empty($upload_id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $upload = $this->AudioUpload->find('first', array(
            'conditions' => array(
                'AudioUpload.id' => $upload_id
            ),
			'recursive' => -1
        ));
		$track_status = $this->_check_status($upload);
		switch($track_status){
			case 'processing':
				$this->Session->setFlash(sprintf(__l('%s audio status could not be updated. Please, try again.') , __l('Entry')) , 'default', null, 'error');
			break;
			case 'finished':
				$this->Session->setFlash(__l('Your entry audio status has updated successfully') , 'default', null, 'success');
			break;
			case 'failed':
				$this->Session->setFlash(sprintf(__l('%s audio has been failed.') , __l('Entry')) , 'default', null, 'error');
			break;
		
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
        $upload = $this->AudioUpload->find('first', array(
            'conditions' => array(
                'AudioUpload.id' => $upload_id
            ),
			'recursive' => -1
        ));
        if ($this->_check_status($upload)) {
            $this->Session->setFlash(__l('Your entry audio status has updated successfully') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(sprintf(__l('%s audio status could not be updated. Please, try again.') , __l('Entry')) , 'default', null, 'error');
        }
        $this->redirect(array(
            'controller' => 'audio_uploads',
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
	
	public function getIFrameTrack($audio_id, $height, $width, $contest_slug = '', $entry_no = 1, $page = 1){
		$this->autoRender = false;
		$upload = $this->AudioUpload->find('first', array(
			'conditions' => array(
				'AudioUpload.soundcloud_audio_id' => $audio_id
			)
		));
		if(empty($upload) || empty($upload['AudioUpload']['audio_url'])){
			throw new NotFoundException(__l('Invalid request'));
		}
		App::import('Vendor', 'AudioResources.Soundcloud/Soundcloud');
		$soundcloud = new Services_Soundcloud(Configure::read('soundcloud_client_id') , Configure::read('soundcloud_client_secret'));
		$soundcloud->setCurlOptions(array(CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_SSL_VERIFYHOST, 0, CURLOPT_FOLLOWLOCATION => 1));
		$embed_info = json_decode($soundcloud->get('oembed', array('url' => $upload['AudioUpload']['audio_url'], 'iframe' => true, 'maxheight' =>$height, 'maxwidth' => $width, 'color' => 'ff0066', 'show_user' => 'false', 'show_artwork' => 'false', 'download' => 'false', 'liking' => 'false')), true);
		$embed_code = '';
		if(!empty($embed_info['html'])){
			if(!empty($contest_slug)){
				$entry_view_url = Router::url(array(
                        'controller' => 'contest_users',
                        'action' => 'view',
                        $contest_slug,
						'entry' => $entry_no,
						'page'=>$page
                    ) , true);
				$embed_code = '<div class="pa js-iframe-container"><a href="'.$entry_view_url.'" class="show js-iframe-link pa"></a>'.$embed_info['html'].'</div>';
			}else{
				$embed_code = $embed_info['html'];
			}
			
		}else{
			if(!empty($contest_slug)){
				$embed_code = '<p class="contest-content no-mar dc textb contest-content-message">Track has been removed. It may be due to copyright issue or admin removed your track in SoundCloud site.</p>';
			}else{
				$embed_code = '<p class="dc textb">Track has been removed. It may be due to copyright issue or admin removed your track in SoundCloud site.</p>';
			}
		}
		return $embed_code;
	}
}
?>