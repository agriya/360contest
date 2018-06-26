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
class FilemanagersController extends AppController
{
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Filemanager';
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array(
        'Setting',
        'User'
    );
    /**
     * Helpers used by the Controller
     *
     * @var array
     * @access public
     */
    public $helpers = array(
        'Filemanager'
    );
    public $deletablePaths = array();
    public function beforeFilter()
    {
        parent::beforeFilter();
        die();
        $this->deletablePaths = array(
            APP . 'View' . DS . 'Themed' . DS,
            WWW_ROOT,
        );
        $this->set('deletablePaths', $this->deletablePaths);
        App::uses('File', 'Utility');
    }
    public function admin_index()
    {
        $this->redirect(array(
            'action' => 'browse'
        ));
        die();
    }
    public function admin_browse()
    {
        $this->pageTitle = __l('File Manager');
        $this->folder = new Folder;
        $path = APP;
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        }
        $this->pageTitle = __l('File Manager');
        $regex = '/^' . preg_quote(APP, '/') . '/';
        if (preg_match($regex, $path) == false) {
            $this->Session->setFlash(__l(sprintf('Path %s is restricted', $path)) , 'default', null, 'error');
            $path = APP;
        }
        $blacklist = array(
            '.git',
            '.svn',
            '.CVS'
        );
        $regex = '/(' . preg_quote(implode('|', $blacklist) , '.') . ')/';
        if (in_array(basename($path) , $blacklist) || preg_match($regex, $path)) {
            $this->Session->setFlash(__l(sprintf('Path %s is restricted', $path)) , 'default', null, 'error');
            $path = dirname($path);
        }
        $this->folder->path = $path;
        $content = $this->folder->read();
        $this->set(compact('content'));
        $this->set('path', $path);
    }
    public function admin_editfile()
    {
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
            $absolutefilepath = $path;
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ));
        }
        $this->pageTitle = sprintf(__l('Edit file: %s') , $path);
        $path_e = explode(DS, $path);
        $n = count($path_e) -1;
        $filename = $path_e[$n];
        unset($path_e[$n]);
        $path = implode(DS, $path_e);
        $this->file = new File($absolutefilepath, true);
        if (!empty($this->request->data)) {
            if ($this->file->write($this->request->data['Filemanager']['content'])) {
                $this->Session->setFlash(__l('File saved successfully') , 'default', null, 'success');
            }
        }
        $content = $this->file->read();
        $this->set(compact('content', 'path', 'absolutefilepath'));
    }
    public function admin_upload()
    {
        $this->pageTitle = __l('Upload');
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        } else {
            $path = APP;
        }
        $this->set(compact('path'));
        if (isset($this->request->data['Filemanager']['file']['tmp_name']) && is_uploaded_file($this->request->data['Filemanager']['file']['tmp_name'])) {
            $destination = $path . $this->request->data['Filemanager']['file']['name'];
            move_uploaded_file($this->request->data['Filemanager']['file']['tmp_name'], $destination);
            $this->Session->setFlash(__l('File uploaded successfully.') , 'default', null, 'success');
            $redirectUrl = Router::url(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ) , true) . '?path=' . urlencode($path);
            $this->redirect($redirectUrl);
        }
    }
    public function admin_delete_file()
    {
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ));
        }
        if (file_exists($path) && unlink($path)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('File')) , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('An error occured') , 'default', null, 'error');
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'index'
            ));
        }
        exit();
    }
    public function admin_delete_directory()
    {
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ));
        }
        if (is_dir($path) && rmdir($path)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Directory')) , 'default', null, 'success');
        } else {
            $this->Session->setFlash(__l('An error occured') , 'default', null, 'error');
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'index'
            ));
        }
        exit();
    }
    public function admin_rename()
    {
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ));
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            $this->redirect($_SERVER['HTTP_REFERER']);
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'index'
            ));
        }
    }
    public function admin_create_directory()
    {
        $this->pageTitle = __l('New Directory');
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ));
        }
        if (!empty($this->request->data)) {
            $this->folder = new Folder;
            if ($this->folder->create($path . $this->request->data['Filemanager']['name'])) {
                $this->Session->setFlash(__l('Directory created successfully.') , 'default', null, 'success');
                $redirectUrl = Router::url(array(
                    'controller' => 'filemanagers',
                    'action' => 'browse'
                ) , true) . '?path=' . urlencode($path);
                $this->redirect($redirectUrl);
            } else {
                $this->Session->setFlash(__l('An error occured') , 'default', null, 'error');
            }
        }
        $this->set(compact('path'));
    }
    public function admin_create_file()
    {
        $this->pageTitle = __l('New File');
        if (isset($this->request->query['path'])) {
            $path = $this->request->query['path'];
        } else {
            $this->redirect(array(
                'controller' => 'filemanagers',
                'action' => 'browse'
            ));
        }
        if (!empty($this->request->data)) {
            if (touch($path . $this->request->data['Filemanager']['name'])) {
                $this->Session->setFlash(__l('File created successfully.') , 'default', null, 'success');
                $redirectUrl = Router::url(array(
                    'controller' => 'filemanagers',
                    'action' => 'browse'
                ) , true) . '?path=' . urlencode($path);
                $this->redirect($redirectUrl);
            } else {
                $this->Session->setFlash(__l('An error occured') , 'default', null, 'error');
            }
        }
        $this->set(compact('path'));
    }
    public function admin_chmod()
    {
    }
}
