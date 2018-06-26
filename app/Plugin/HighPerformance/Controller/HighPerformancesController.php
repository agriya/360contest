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
class HighPerformancesController extends AppController
{
    public $name = 'HighPerformances';
    public function admin_check_s3_connection() 
    {
        App::import('Vendor', 'HighPerformance.S3');
        $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
		$s3->setEndpoint(Configure::read('s3.end_point'));
		$buckets = $s3->listBuckets();
        if (in_array(Configure::read('s3.bucket_name'), $buckets)) {
            $this->Session->setFlash(__l('Bucket name and configuration is ok') , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('Problem with the configuration') , 'default', null, 'error');
        }
        if (!empty($_GET['f'])) {
            $this->redirect(Router::url('/', true) . $_GET['f']);
        }
    }
    public function admin_copy_static_contents() 
    {
        $this->_copy_content(JS, 'js');
        $this->_copy_content(CSS, 'css');
        $this->_copy_content(IMAGES, 'img');
		$this->_copy_content(WWW_ROOT . DS . 'font', 'font');
        App::import('Modal', 'Settings');
        if (!empty($_GET['f'])) {
            $this->Session->setFlash(__l('Static content successfully copied.') , 'default', null, 'success');
            $this->redirect(Router::url('/', true) . $_GET['f']);
        }
    }
    public function _copy_content($dir, $current_dir) 
    {
		App::import('Vendor', 'HighPerformance.S3');
		$s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
        $handle = opendir($dir);
        while (false !== ($readdir = readdir($handle))) {
            if ($readdir != '.' && $readdir != '..') {
                $path = $dir . '/' . $readdir;
                if (is_dir($path)) {
                    @chmod($path, 0777);
                    if (!strstr($path, "_thumb")) {
                        $this->_copy_content($path, $current_dir . "/" . $readdir);
                    }
                }
                if (is_file($path)) {
                    @chmod($path, 0777);
                    $s3->putObjectFile($path, Configure::read('s3.bucket_name') , $current_dir . '/' . $readdir, S3::ACL_PUBLIC_READ);
                    flush();
                }
            }
        }
        closedir($handle);
        return true;
    }
    public function update_content() 
    {
		$this->disableCache();
		App::import('Model', 'Contests.Contest');
        $this->Contest = new Contest();
        if ($this->Auth->user('id')) {
            $conditions = array();
            $followinguserIds = array();
            $followingcontestIds = array();
            $ratedConntestUserIds = array();
            if (isPluginEnabled('ContestFollowers')) {
                $followingcontestIds = $this->Contest->ContestFollower->find('all', array(
                    'conditions' => array(
                        'ContestFollower.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'ContestFollower.contest_id'
                    ) ,
                    'recursive' => -1
                ));
            }
            if (isPluginEnabled('EntryRatings')) {
                $ratedConntestUserIds = $this->Contest->ContestUser->ContestUserRating->find('all', array(
                    'conditions' => array(
                        'ContestUserRating.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'ContestUserRating.contest_user_id'
                    ) ,
                    'recursive' => -1
                ));
            }
            if (isPluginEnabled('UserFavourites')) {
                $followinguserIds = $this->User->UserFavorite->find('all', array(
                    'conditions' => array(
                        'UserFavorite.user_id' => $this->Auth->user('id')
                    ) ,
                    'fields' => array(
                        'UserFavorite.user_favorite_id'
                    ) ,
                    'recursive' => -1
                ));
            }
            $this->set('followingcontestIds', $followingcontestIds);
            $this->set('ratedConntestUserIds', $ratedConntestUserIds);
            $this->set('followinguserIds', $followinguserIds);
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $this->Auth->user('id') ,
                ) ,
                'recursive' => -1
            ));
            $this->response->modified($user['User']['modified']);
        }
		$cids= '';
		if(!empty($_GET['cids'])){$cids=$_GET['cids']; $cids=explode(',', $cids);}
		$ownContestIds = $this->Contest->find('all', array(
			'conditions' => array(
				'Contest.id' => $cids
			) ,
			'contain' => array(
				'ContestType',
			),
			'recursive' => 1
		));
		$this->set('ownContestIds', $ownContestIds);
		$cuids= '';
		if(!empty($_GET['cuids'])){$cuids=$_GET['cuids']; $cuids=explode(',', $cuids);}
		$ownContestUsers = $this->Contest->ContestUser->find('all', array(
			'conditions' => array(
				'ContestUser.id' => $cuids
			) ,
			'contain' => array(
				'Contest'
			) ,
			'recursive' => 0
		));
		$this->set('ownContestUsers', $ownContestUsers);
    }
    public function remove_s3_file() 
    {
        if (!empty($this->request->data['url'])) {
            App::import('Vendor', 'HighPerformance.S3');
            $s3 = new S3(Configure::read('s3.aws_access_key') , Configure::read('s3.aws_secret_key'));
			$s3->setEndpoint(Configure::read('s3.end_point'));
            $s3->deleteObject(Configure::read('s3.bucket_name') , $this->request->data['url']);
            exit;
        }
    }
	public function show_contest_comments() 
    {
        $this->disableCache();
        if (!empty($this->request->params['named']['id'])) {
            App::import('Model', 'Contests.Contest');
            $this->Contest = new Contest();
            $contest = $this->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $this->request->params['named']['id']
                ) ,
                'recursive' => 0
            ));
            $this->set('contest', $contest);
        }
		if (!empty($this->request->params['named']['contest_user_id'])) {
			App::import('Model', 'Contests.ContestUser');
            $this->ContestUser = new ContestUser();
            $contestUser = $this->ContestUser->find('first', array(
                'conditions' => array(
                    'ContestUser.id' => $this->request->params['named']['contest_user_id']
                ) ,
                'recursive' => 0
            ));
            $this->set('contestUser', $contestUser);
			$this->set('contest_user_id', $this->request->params['named']['contest_user_id']);
			$this->set('entry', $this->request->params['named']['entry']);
			$this->set('page', $this->request->params['named']['page']);
		}
        $this->layout = 'ajax';
    }
}
?>