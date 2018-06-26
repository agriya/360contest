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
class ContestViewsController extends AppController
{
    public $name = 'ContestViews';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Contest Views');
        $conditions = array();
        if (!empty($this->request->params['named']['contest'])) {
            $contest = $this->{$this->modelClass}->Contest->find('first', array(
                'conditions' => array(
                    'Contest.slug' => $this->request->params['named']['contest']
                ) ,
                'fields' => array(
                    'Contest.id',
                    'Contest.name',
                    'Contest.slug'
                ) ,
                'recursive' => -1
            ));
            if (empty($contest)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Contest.id'] = $contest['Contest']['id'];
            $this->pageTitle.= sprintf(__l(' - Contest - %s') , $contest['Contest']['name']);
        }
        if(!empty($this->request->params['named']['q']) &&  strtolower($this->request->params['named']['q']) == 'guest'){
		$conditions  = array( 
		   'OR' => array(			  
			  array('ContestView.user_id IS NULL')
		   ));
			$this->request->data['UserView']['q'] = $this->request->params['named']['q'];
		} elseif (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                    array(
                        'Contest.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestFollower']['q'] = $this->request->params['named']['q'];
              }
        if (!empty($this->request->params['named']['q'])) {
            $this->request->data['ContestView']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->ContestView->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'Contest' => array(
                    'fields' => array(
                        'Contest.name',
                        'Contest.slug'
                    ) ,
                    'ContestStatus',
                ) ,
                'User',
                'Ip' => array(
                    'City' => array(
                        'fields' => array(
                            'City.name',
                        )
                    ) ,
                    'State' => array(
                        'fields' => array(
                            'State.name',
                        )
                    ) ,
                    'Country' => array(
                        'fields' => array(
                            'Country.name',
                            'Country.iso_alpha2',
                        )
                    ) ,
                    'Timezone' => array(
                        'fields' => array(
                            'Timezone.name',
                        )
                    ) ,
                    'fields' => array(
                        'Ip.ip',
                        'Ip.latitude',
                        'Ip.longitude',
                        'Ip.host'
                    )
                ) ,
            ) ,
            'order' => array(
                'ContestView.id' => 'desc'
            ) ,
            'recursive' => 0
        );
        $this->set('ContestViews', $this->paginate());
        $moreActions = $this->ContestView->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestView->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Contest View')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>