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
class SubmissionsController extends ContestsAppController
{
    public $name = 'Submissions';
    public $helpers = array(
        'Contests.Csv'
    );
    public $components = array(
        'Contests.ContestTypes'
    );
    public function admin_export($formId = null)
    {
        if (!$formId) {
            $this->Session->setFlash(__l('Invalid Submission'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        Configure::write('debug', 0);
        $submissions = $this->Submission->getSubmissions($formId);
        $fields = array_keys($submissions[0]);
        $this->set(compact('submissions', 'fields'));
        $this->layout = 'csv/default';
        $this->render('csv/admin_export');
    }
    public function admin_index()
    {
        $this->Submission->recursive = 0;
        $this->pageTitle = __l('Submissions');
        $this->set('submissions', $this->paginate());
    }
    public function admin_view($id = null)
    {
        if (!$id) {
            $this->Session->setFlash(__l('Invalid Submission'));
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        $this->set('submission', $this->Submission->read(null, $id));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->Submission->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Submission')));
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function view_upload($encodedPath = false)
    {
        $file = base64_decode($encodedPath);
        //First, see if the file exists
        if (!is_file($file)) {
            die("<b>404 File not found!</b>");
        }
        //Gather relevent info about file
        $len = filesize($file);
        $filename = basename($file);
        $file_extension = strtolower(substr(strrchr($filename, ".") , 1));
        //This will set the Content-Type to the appropriate setting for the file
        switch ($file_extension) {
            case "pdf":
                $ctype = "application/pdf";
                break;

            case "exe":
                $ctype = "application/octet-stream";
                break;

            case "zip":
                $ctype = "application/zip";
                break;

            case "doc":
                $ctype = "application/msword";
                break;

            case "xls":
                $ctype = "application/vnd.ms-excel";
                break;

            case "ppt":
                $ctype = "application/vnd.ms-powerpoint";
                break;

            case "gif":
                $ctype = "image/gif";
                break;

            case "png":
                $ctype = "image/png";
                break;

            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;

            case "mp3":
                $ctype = "audio/mpeg";
                break;

            case "wav":
                $ctype = "audio/x-wav";
                break;

            case "mpeg":
            case "mpg":
            case "mpe":
                $ctype = "video/mpeg";
                break;

            case "mov":
                $ctype = "video/quicktime";
                break;

            case "avi":
                $ctype = "video/x-msvideo";
                break;
                //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)

            case "php":
            case "htm":
            case "html":
            case "txt":
                die("<b>Cannot be used for " . $file_extension . " files!</b>");
                break;

            default:
                $ctype = "application/force-download";
        }
        //Begin writing headers
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        //Use the switch-generated Content-Type
        header("Content-Type: $ctype");
        //Force the download
        $header = "Content-Disposition: attachment; filename=" . $filename . ";";
        header($header);
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $len);
        @readfile($file);
        exit;
    }
}
?>