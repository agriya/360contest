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
class ContestUserViewsController extends AppController
{
    public $name = 'ContestUserViews';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'q'
        ));
        $this->pageTitle = __l('Entry Views');
        $conditions = array();
        if (!empty($this->request->params['named']['entryid'])) {
            $conditions['ContestUserView.contest_user_id'] = $this->request->params['named']['entryid'];
        }
        if (!empty($this->request->params['named']['ContestUser'])) {
            $contestuseruser = $this->{$this->modelClass}->ContestUser->find('first', array(
                'conditions' => array(
                    'Contest.slug' => $this->request->params['named']['ContestUser']
                ) ,
                'fields' => array(
                    'ContestUser.id',
                    'Contest.title',
                    'Contest.slug'
                ) ,
                'recursive' => -1
            ));
            if (empty($contestuser)) {
                throw new NotFoundException(__l('Invalid request'));
            }
            $conditions['Contest.id'] = $contestuser['ContestUser']['id'];
            $this->pageTitle.= sprintf(__l(' - Contest - %s') , $contestuser['ContestUser']['title']);
        }
        if(!empty($this->request->params['named']['q']) &&  strtolower($this->request->params['named']['q']) == 'guest'){
		$conditions  = array( 
		   'OR' => array(			  
			  array('ContestUserView.user_id IS NULL')
		   ));
			$this->request->data['UserView']['q'] = $this->request->params['named']['q'];
		} elseif (isset($this->request->params['named']['q'])) {
			$get_contest_id = $this->ContestUserView->ContestUser->Contest->find('list', array(
                'conditions' => array(
                    'Contest.name LIKE' => '%'. $this->request->params['named']['q']. '%',
                ) ,
                'fields' => array(
                    'Contest.id',
                ) ,
                'recursive' => -1
            ));
            $conditions[] = array(
                'OR' => array(
                    array(
                        'User.username LIKE ' => '%' . $this->params['named']['q'] . '%'
                    )  ,
					array(
						'ContestUser.contest_id' => $get_contest_id
					),
                )
            );          
        }
        if (isset($this->request->params['named']['q'])) {
            $this->request->data['ContestUserView']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
		}
        $this->ContestUserView->recursive = 0;
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
                'User',
                'ContestUser' => array(
                    'Attachment',
                    'ContestUserStatus',
                    'Contest' => array(
                        'ContestStatus',
                        'Resource',
                        'fields' => array(
                            'Contest.id',
                            'Contest.name',
                            'Contest.slug',
                            'Contest.contest_status_id',
                            'Contest.user_id',
                        ) ,
                        'ContestType' => array(
                            'fields' => array(
                                'ContestType.id',
                                'ContestType.resource_id',
                                'ContestType.is_watermarked',
                            )
                        ) ,
                    ) ,
                    'User',
                ) ,
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
                'ContestUserView.id' => 'desc'
            ) ,
            'recursive' => 3
        );
        $this->set('ContestUserViews', $this->paginate());
        $moreActions = $this->ContestUserView->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestUserView->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Entry View')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>