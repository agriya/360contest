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
class ContestStatusesController extends AppController
{
    public $name = 'ContestStatuses';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q',
        ));
        $this->pageTitle = __l('Contest Statuses');
        $this->ContestStatus->recursive = -1;
        $conditions = array();
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'ContestStatus.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'ContestStatus.message LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestStatus']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->paginate = array(
            'conditions' => $conditions,
        );
        $this->set('contestStatuses', $this->paginate());
        $moreActions = $this->ContestStatus->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_edit($id = null)
    {
        $this->pageTitle = __l('Edit Contest Status');
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if (!empty($this->request->data)) {
            if ($this->ContestStatus->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Contest Status')) , 'default', null, 'success');
                $this->redirect(array(
                    'controller' => 'contest_statuses',
                    'action' => 'index',
                ));
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Contest Status')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ContestStatus->read(null, $id);
            if (empty($this->request->data)) {
                throw new NotFoundException(__l('Invalid request'));
            }
        }
        $this->pageTitle.= ' - ' . $this->request->data['ContestStatus']['name'];
    }
}
