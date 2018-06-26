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
class ContestUserDownloadsController extends AppController
{
    public $name = 'ContestUserDownloads';
    public function admin_index()
    {
        $this->_redirectGET2Named(array(
            'user_id',
            'q'
        ));
        $conditions = array();
        if (!empty($this->request->params['named']['entryid'])) {
            $conditions['ContestUserDownload.contest_user_id'] = $this->request->params['named']['entryid'];
        }
        $this->pageTitle = __l('Entry Downloads');
        if (!empty($this->request->params['named']['q'])) {
			$get_contest_id = $this->ContestUserDownload->ContestUser->Contest->find('list', array(
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
                    ) ,
					array(
						'ContestUser.contest_id' => $get_contest_id
					),
                )
            );
            $this->request->data['ContestUserDownload']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'contain' => array(
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
                'User' => array(
                    'UserAvatar',
                ) ,
                'ContestUser' => array(
                    'Attachment',
                    'User',
                    'ContestUserStatus',
                    'Contest' => array(
                        'Resource',
                        'ContestStatus',
                        'ContestType' => array(
                            'fields' => array(
                                'ContestType.id',
                                'ContestType.resource_id',
                                'ContestType.is_watermarked',
                            )
                        ) ,
                    ) ,
                ) ,
            ) ,
            'recursive' => 3,
            'order' => array(
                'ContestUserDownload.id' => 'desc'
            )
        );
        $this->set('contestUserDownloads', $this->paginate());
        $moreActions = $this->ContestUserDownload->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestUserDownload->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s deleted'), __l('Entry download')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
}
?>