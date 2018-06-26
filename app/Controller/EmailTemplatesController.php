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
class EmailTemplatesController extends AppController
{
    public $name = 'EmailTemplates';
    public function admin_index()
    {
        $this->pageTitle = __l('Email Templates');
        $emailTemplates = $this->EmailTemplate->find('all', array(
            'recursive' => -1
        ));
        $this->set('emailTemplates', $emailTemplates);
    }
    public function admin_edit($id = null)
    {
        $this->disableCache();
        $this->pageTitle = __l('Edit Email Template');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->EmailTemplate->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Email Template')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Email Template')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->EmailTemplate->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
		$this->pageTitle.= ' - ' . $this->request->data['EmailTemplate']['name'];
    }
}
?>