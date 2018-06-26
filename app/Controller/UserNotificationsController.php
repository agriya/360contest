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
class UserNotificationsController extends AppController
{
    public $name = 'UserNotifications';
    public $permanentCacheAction = array(
        'user' => array(
            'edit',
        )
    );
    public function edit($id = null)
    {
        $this->pageTitle = __l('Email Settings');
        if (!empty($this->request->data)) {
            if (empty($this->data['User']['id'])) {
                $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
            }
            $user_notifications = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $this->request->data['UserNotification']['user_id']
                ) ,
                'recursive' => -1
            ));
            if (!empty($user_notifications)) {
                $this->request->data['UserNotification']['id'] = $user_notifications['UserNotification']['id'];
            }
            if (empty($this->data['User']['id'])) {
                $this->request->data['UserNotification']['user_id'] = $this->Auth->user('id');
            }
            if ($this->UserNotification->save($this->request->data)) {
                $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Notification Settings')) , 'default', null, 'success');
            } else {
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Notification Settings')) , 'default', null, 'error');
            }
        } else {
            $user_id = $this->Auth->user('id');
            $this->request->data = $this->UserNotification->find('first', array(
                'conditions' => array(
                    'UserNotification.user_id' => $user_id
                ) ,
                'recursive' => -1
            ));
            if (empty($this->request->data['UserNotification'])) {
                $data['UserNotification']['user_id'] = $this->Auth->user('id');
                $this->UserNotification->save($data['UserNotification']);
            }
        }
    }
}
