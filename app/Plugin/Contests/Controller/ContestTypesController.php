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
class ContestTypesController extends AppController
{
    public $name = 'ContestTypes';
    public $helpers = array(
        'Contests.Cakeform'
    );
    public function beforeFilter()
    {
        $this->Security->disabledFields = array(
            'ContestType',
            'FormField',
            'Attachment',
            'PricingDay',
            'PricingPackage'
        );
        parent::beforeFilter();
    }
    public function admin_edit($id = null)
    {
        $contest_type = $this->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $id
            ) ,
            'recursive' => -1
        ));
		if(!empty($contest_type)) {
			$resource = $this->ContestType->Resource->getResourceName($contest_type['ContestType']['resource_id']);	
			if (!isPluginEnabled($resource['Resource']['name'] . "Resources")) { 
				throw new NotFoundException(__l('Invalid contest'));
			}
		}
        if ($this->request->params['named']['type'] == 'overview') {
            $this->pageTitle = __l('Contest Type') . ' - ' . __l('Overview') . ' - ' . $contest_type['ContestType']['name'];
        }
        if ($this->request->params['named']['type'] == 'form_fields') {
            $this->pageTitle = __l('Contest Type') . ' - ' . __l('Form Fields') . ' - ' . $contest_type['ContestType']['name'];
        }
        $this->disableCache();
        if (!$id && empty($this->request->data)) {
            $this->Session->setFlash(__l('Invalid Contest Type id. Please, try again.') , 'default', null, 'error');
            $this->redirect(array(
                'action' => 'index'
            ));
        }
        if (!empty($this->request->data)) {
            if (!empty($this->request->data['FormField'])) {
                foreach($this->request->data['FormField'] as $key => $formField) {
                    if (!isset($formFieldCount[$formField['type']])) {
                        $formFieldCount[$formField['type']] = 1;
                    } else {
                        $formFieldCount[$formField['type']]++;
                    }
                    $this->request->data['FormField'][$key]['name'] = 'contestform' . $id . '_' . $formField['type'] . '_' . $formFieldCount[$formField['type']];
                }
            }
            //for contest type image
            $ini_upload_error = 1;
            if (empty($this->request->data['ContestType']['is_template'])) {
                $contest_types = $this->ContestType->find('first', array(
                    'conditions' => array(
                        'ContestType.id' => $id
                    ) ,
                    'contain' => array(
                        'Attachment',
                    ) ,
                    'recursive' => 1
                ));
				$ini_upload_error = 1;
                if (!empty($contest_types)) {
                    $this->request->data['ContestType']['id'] = $contest_types['ContestType']['id'];
                    if (!empty($contest_types['Attachment']['id'])) {
                        $this->request->data['Attachment']['id'] = $contest_types['Attachment']['id'];
                    }
                }
                if (!empty($this->request->data['Attachment']['filename']['tmp_name'])) {
                    $this->request->data['Attachment']['filename']['type'] = get_mime($this->request->data['Attachment']['filename']['tmp_name']);
                    $this->ContestType->Attachment->set($this->request->data);
                    if (!empty($this->request->data['Attachment']['filename']['error'])) {
                        $ini_upload_error = 0;
                    }
                    $attachment = $this->request->data['Attachment'];
					unset($this->request->data['Attachment']);
                } 
            }
            if ($ini_upload_error) {
                $error = 0;
                if (!empty($this->request->data['FormField'])) {
                    $error_str = '';
                    foreach($this->request->data['FormField'] as $formFields) {
                        $multiSelectArray = $this->ContestType->FormField->multiTypes;
                        if (in_array($formFields['type'], $multiSelectArray)) {
                            if (empty($formFields['options'])) {
                                $error = 1;
                            } else if ($formFields['type'] == 'slider') {
                                $options_val = explode(',', $formFields['options']);
                                if (count($options_val) != 2) {
                                    $error = 1;
                                    $error_str = 'slider';
                                }
                            }
                        }
                    }
                }
                if (!$error) {
                    if (empty($this->request->data['ContestType']['maximum_entries_allowed'])) {
                        $this->request->data['ContestType']['maximum_entries_allowed'] = 0;
                    }
                    if ($this->ContestType->save($this->request->data['ContestType'])) {
                        if (!empty($this->request->data['FormField'])) {
                            foreach($this->request->data['FormField'] as $formField) {
                                $formField['options'] = rtrim($formField['options'], ",");
                                $_data = array();
                                $_data['FormField'] = $formField;
                                $this->ContestType->FormField->save($_data);
                            }
                        }
                        if (!empty($attachment)) {
                            $this->request->data['Attachment'] = $attachment;
                            if (!empty($this->request->data['Attachment']['filename']['tmp_name'])) {
                                $this->ContestType->Attachment->create();
                                $this->request->data['Attachment']['class'] = 'ContestType';
                                $this->request->data['Attachment']['foreign_id'] = $contest_types['ContestType']['id'];
                                $this->ContestType->Attachment->save($this->request->data['Attachment']);
                            }
                        }


                                if ($this->request->params['named']['type'] == 'overview') {
										if( empty($contest_types['ContestType']['is_template'])) {
											$this->redirect(array(
											'action' => 'edit',
											$id,
											'type' => 'form_fields'
											));
										} else {
											 $this->redirect(array(
											'action' => 'edit',
											$contest_types['ContestType']['id'],
											'type' => 'form_fields'
											));
										}
                                } else {
									if( empty($contest_types['ContestType']['is_template'])) {
										$this->redirect(array(
											'action' => 'pricing',
											$contest_types['ContestType']['id']
										));
									} else
									{
										$this->redirect(array(
											'controller'=>'contests',
											'action' => 'add',
											'contest_type_id' =>$contest_types['ContestType']['id'],
											'type' => 'preview'
										));
									}


                        }
                    } else {
                        if (!empty($this->request->data['ContestType']['is_template'])) {
                            $this->Session->setFlash(__l('Contest Template could not be saved. Please, try again.') , 'default', null, 'error');
                        } else {
                            $this->Session->setFlash(__l('Contest Type could not be saved. Please, try again.') , 'default', null, 'error');
                        }
                    }
                } else if (empty($error_str)) {
                    $this->Session->setFlash(__l('Contest Type could not be saved. Please enter all option values needed.') , 'default', null, 'error');
                } else if (!empty($error_str) == 'slider') {
                    $this->Session->setFlash(__l('Contest Type could not be saved. Please enter exactly 2 options for slider control.') , 'default', null, 'error');
                }
            } else {
                if (!empty($this->request->data['Attachment']['filename']['error'])) {
					if($this->request->data['Attachment']['filename']['error'] == "Required") {
						$this->ContestType->Attachment->validationErrors['filename'] = __l($this->request->data['Attachment']['filename']['error']);
					} else {
						$this->ContestType->Attachment->validationErrors['filename'] = sprintf(__l('Uploaded file is too big, only files less than %s permitted') , ini_get('upload_max_filesize'));
					}
                }
                $this->Session->setFlash(sprintf(__l('%s could not be updated. Please, try again.'), __l('Contest Type')) , 'default', null, 'error');
            }
        } else {
            $this->request->data = $this->ContestType->find('first', array(
                'conditions' => array(
                    'ContestType.id' => $id
                ) ,
                'contain' => array(
                    'Attachment',
                    'FormField'
                ) ,
                'recursive' => 2
            ));
        }
        if (empty($this->request->data['ContestType']['maximum_entries_allowed'])) {
            $this->request->data['ContestType']['maximum_entries_allowed'] = '';
        }
        if (empty($this->request->data['ContestType']['maximum_entries_allowed_per_user'])) {
            $this->request->data['ContestType']['maximum_entries_allowed_per_user'] = '';
        }
		$this->loadModel('Contests.FormFieldGroup');
        $FormFieldGroups = $this->FormFieldGroup->find('all', array(
            'conditions' => array(
                'FormFieldGroup.contest_type_id' => $id
            ) ,
            'contain' => array(
				'FormField' => array(
					'order' => array(
						'FormField.order' => 'ASC'
					)
				)
			) ,
            'order' => array(
                'FormFieldGroup.order' => 'ASC'
            ) ,
            'recursive' => 2
        ));
        $multiTypes = $this->ContestType->FormField->multiTypes;
        $types = $this->ContestType->FormField->types;
        $this->set(compact('types', 'multiTypes','FormFieldGroups'));
    }
    public function admin_index($resource_id = null)
    {
		if(!empty($resource_id)) {
			$resource = $this->ContestType->Resource->getResourceName($resource_id);						
			if (!isPluginEnabled($resource['Resource']['name'] . "Resources")) { 
				throw new NotFoundException(__l('Invalid contest'));
			}
		}	
        $this->_redirectGET2Named(array(
            'q',
            'type'
        ));
        $this->loadModel('Contests.PricingPackage');
        $this->loadModel('Contests.PricingDay');
        $conditions = array();
		if(!empty($resource_id)) {
			$conditions['ContestType.resource_id'] = $resource_id;
		}
        $this->pageTitle = __l('Contest Form and Pricing');
        if (isset($this->params['named']['type']) && $this->params['named']['type'] == 'templates') {
            $this->pageTitle = __l('Contest Templates');
            $this->request->data['ContestType']['type'] = $this->params['named']['type'];
            $conditions['ContestType.is_template'] = 1;
        } else {
            $this->pageTitle = __l('Contest Form and Pricing');
            $conditions['ContestType.is_template'] = 0;
        }
        if (!empty($this->request->params['named']['q'])) {
            $conditions[] = array(
                'OR' => array(
                    array(
                        'ContestType.name LIKE ' => '%' . $this->params['named']['q'] . '%'
                    ) ,
                )
            );
            $this->request->data['ContestType']['q'] = $this->request->params['named']['q'];
            $this->pageTitle.= sprintf(__l(' - Search - %s') , $this->request->params['named']['q']);
        }
		if (!empty($this->request->params['named']['filter_id'])) {
            if ($this->request->params['named']['filter_id'] == ConstMoreAction::Active) {
                $conditions['ContestType.is_active'] = 1;
                $this->pageTitle.= __l(' - Active ');
            } else if ($this->request->params['named']['filter_id'] == ConstMoreAction::Inactive) {
                $conditions['ContestType.is_active'] = 0;
                $this->pageTitle.= __l(' - Inactive ');
            }
        }
        $this->paginate = array(
            'conditions' => $conditions,
            'recursive' => 2,
            'contain' => array(
                'Resource',
                'ContestTypesPricingPackage' => array(
                    'order' => 'ContestTypesPricingPackage.pricing_package_id asc'
                ) ,
                'ContestTypesPricingDay' => array(
                    'order' => 'ContestTypesPricingDay.pricing_day_id asc'
                )
            ) ,
            'order' => array(
                'ContestType.id' => 'desc'
            )
        );
        $pricingPackages = $this->PricingPackage->find('list', array(
            'order' => array(
                'PricingPackage.id' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $pricingDays = $this->PricingDay->find('list', array(
            'fields' => array(
                'PricingDay.id',
                'PricingDay.no_of_days'
            ) ,
            'order' => array(
                'PricingDay.id' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $contestTypes = $this->paginate();
        $contestTypesPricingPackageArr = array();
        if (!empty($contestTypes)) {
            foreach($contestTypes as $contestType) {
                if (!empty($pricingPackages)) {
                    foreach($pricingPackages as $key => $pricingPackage) {
                        if (!empty($contestType['ContestTypesPricingPackage'])) {
                            foreach($contestType['ContestTypesPricingPackage'] as $contestTypesPricingPackage) {
                                if ($contestTypesPricingPackage['pricing_package_id'] == $key) {
                                    if (!empty($contestTypesPricingPackage['maximum_entry_allowed'])) {
                                        $contestTypesPricingPackage['maximum_entry_allowed'] = $contestTypesPricingPackage['maximum_entry_allowed'];
                                    } else {
                                        $contestTypesPricingPackage['maximum_entry_allowed'] = '-';
                                    }
                                    $contestTypesPricingPackageArr[$contestTypesPricingPackage['contest_type_id']][$key] = $contestTypesPricingPackage['price'] . ' / ' . $contestTypesPricingPackage['maximum_entry_allowed'];
                                } elseif (!isset($contestTypesPricingPackageArr[$contestTypesPricingPackage['contest_type_id']][$key])) {
                                    $contestTypesPricingPackageArr[$contestTypesPricingPackage['contest_type_id']][$key] = '-';
                                }
                            }
                        } else {
                            $contestTypesPricingPackageArr[$contestType['ContestType']['id']][$key] = '-';
                        }
                    }
                }
            }
        }
        $contestTypesPricingDayArr = array();
        if (!empty($contestTypes)) {
            foreach($contestTypes as $contestType) {
                if (!empty($pricingDays)) {
                    foreach($pricingDays as $key => $pricingDay) {
                        if (!empty($contestType['ContestTypesPricingDay'])) {
                            foreach($contestType['ContestTypesPricingDay'] as $contestTypesPricingDay) {
                                if ($contestTypesPricingDay['pricing_day_id'] == $key) {
                                    $contestTypesPricingDayArr[$contestTypesPricingDay['contest_type_id']][$key] = $contestTypesPricingDay['price'];
                                } elseif (!isset($contestTypesPricingDayArr[$contestTypesPricingDay['contest_type_id']][$key])) {
                                    $contestTypesPricingDayArr[$contestTypesPricingDay['contest_type_id']][$key] = '-';
                                }
                            }
                        } else {
                            $contestTypesPricingDayArr[$contestType['ContestType']['id']][$key] = '-';
                        }
                    }
                }
            }
        }
        $this->set('pricingPackages', $pricingPackages);
        $this->set('pricingDays', $pricingDays);
        $this->set('contestTypesPricingPackageArr', $contestTypesPricingPackageArr);
        $this->set('contestTypesPricingDayArr', $contestTypesPricingDayArr);
        $this->set('contestTypes', $this->paginate());
		$this->set('pending', $this->ContestType->find('count', array(
            'conditions' => array(
                'ContestType.is_active = ' => 0
            ),
			'recursive' => -1
        )));
        $this->set('approved', $this->ContestType->find('count', array(
            'conditions' => array(
                'ContestType.is_active = ' => 1
            ),
			'recursive' => -1
        )));
        $moreActions = $this->ContestType->moreActions;
        $this->set(compact('moreActions'));
    }
    public function admin_add($resource_id = null)
    {
		$resource_condition = array();
		$ini_upload_error = 1;
		if(!empty($resource_id)) {
			$resource = $this->ContestType->Resource->getResourceName($resource_id);						
			if (!isPluginEnabled($resource['Resource']['name'] . "Resources")) { 
				throw new NotFoundException(__l('Invalid contest'));
			}
			$resource_condition['Resource.id'] = $resource['Resource']['id'];
		}	
        $this->ContestType->create();
        if (!empty($this->request->data)) {
            $this->ContestType->create();
			$ini_upload_error = 1;
			if (empty($this->request->data['ContestType']['is_template'])) {
				if (!empty($this->request->data['Attachment']['filename']['name'])) {
					$this->request->data['Attachment']['filename']['type'] = get_mime($this->request->data['Attachment']['filename']['tmp_name']);
				} else {
					$this->request->data['Attachment']['filename']['error'] = __l('Required');
				}
				if (!empty($this->request->data['Attachment']['filename']['name'])) {
					$this->ContestType->Attachment->set($this->request->data);
				}
				if (!empty($this->request->data['Attachment']['filename']['error'])) {
					$ini_upload_error = 0;
				}
			}
            if ($this->ContestType->validates() & $ini_upload_error) {
                if (empty($this->request->data['ContestType']['maximum_entries_allowed'])) {
                    $this->request->data['ContestType']['maximum_entries_allowed'] = 0;
                }
				if (empty($this->request->data['ContestType']['maximum_entries_allowed_per_user'])) {
					$this->request->data['ContestType']['maximum_entries_allowed_per_user'] = 0;
				}
                if ($this->ContestType->save($this->request->data)) {
                    $contest_type_id = $this->ContestType->getLastInsertId();
                    if (!empty($this->request->data['Attachment']['filename']['name'])) {
                        $this->ContestType->Attachment->create();
                        $this->request->data['Attachment']['class'] = 'ContestType';
                        $this->request->data['Attachment']['foreign_id'] = $contest_type_id;
                        $this->ContestType->Attachment->save($this->request->data['Attachment']);
                    }
                    if (!empty($this->request->data['ContestType']['template_id'])) {
                        $contestTemplate = $this->ContestType->find('first', array(
                            'conditions' => array(
                                'ContestType.id' => $this->request->data['ContestType']['template_id']
                            ) ,
                            'contain' => array(
								'FormFieldGroup' => array(
									'FormField' => array(
										'ValidationRule',
									),
								),
                            ) ,
                            'recursive' => 3
                        ));
						if(!empty($contestTemplate['FormFieldGroup'])) {
							foreach($contestTemplate['FormFieldGroup'] As $form_field_group) {
								$formFieldGroupData = array();
								$formFieldGroupData['FormFieldGroup']['name'] = $form_field_group['name'];
								$formFieldGroupData['FormFieldGroup']['contest_type_id'] = $contest_type_id;
								$formFieldGroupData['FormFieldGroup']['info'] = $form_field_group['info'];
								$formFieldGroupData['FormFieldGroup']['order'] = $form_field_group['order'];
								$formFieldGroupData['FormFieldGroup']['is_editable'] = $form_field_group['is_editable'];
								$formFieldGroupData['FormFieldGroup']['is_deletable'] = $form_field_group['is_deletable'];
								$formFieldGroupData['FormFieldGroup']['class'] = $form_field_group['class'];
								$this->ContestType->FormFieldGroup->create();
								$this->ContestType->FormFieldGroup->save($formFieldGroupData);
								$form_field_group_id = $this->ContestType->FormFieldGroup->getLastInsertId();
								foreach($form_field_group['FormField'] as $key => $formField) {
									$formFieldData = array();
									$formFieldData['FormField'] = $formField;
									unset($formFieldData['FormField']['ValidationRule']);
									unset($formFieldData['FormField']['id']);
									if (!isset($formFieldCount[$formField['type']])) {
										$formFieldCount[$formField['type']] = 1;
									} else {
										$formFieldCount[$formField['type']]++;
									}
									$formFieldData['FormField']['name'] = 'contestform' . $contest_type_id . '_' . $formField['type'] . '_' . $formFieldCount[$formField['type']];
									$formFieldData['FormField']['contest_type_id'] = $contest_type_id;
									$formFieldData['FormField']['form_field_group_id'] = $form_field_group_id;
									if (!empty($formField['ValidationRule'])) {
										foreach($formField['ValidationRule'] as $validationRule) {
											$formFieldData['ValidationRule']['ValidationRule'][] = $validationRule['id'];
										}
									}
									$this->ContestType->FormField->create();
									$this->ContestType->FormField->save($formFieldData);
								}
							}
						}
                    }
                    if (!empty($this->request->data['ContestType']['is_template'])) {
                        $this->Session->setFlash(__l('Contest Template has been created') , 'default', null, 'success');
                    } else {
                        $this->Session->setFlash(__l('Contest Type has been created') , 'default', null, 'success');
                    }
                    $this->redirect(array(
                        'action' => 'edit',
                        $this->ContestType->id,
                        'type' => 'form_fields'
                    ));
                } else {
                    if (!empty($this->request->data['ContestType']['is_template'])) {
                        $this->Session->setFlash(__l('Contest Template could not be created. Please, try again.') , 'default', null, 'error');
                    } else {
                        $this->Session->setFlash(__l('Contest Type could not be created. Please, try again.') , 'default', null, 'error');
                    }
                }
            } else {
				if (empty($ini_upload_error)) {
					$this->ContestType->Attachment->validationErrors['filename'] = __l($this->request->data['Attachment']['filename']['error']);
					$this->Session->setFlash(__l('Contest Type could not be created. Please Upload image.') , 'default', null, 'error');
				} else {
					$this->Session->setFlash(__l('Contest Type could not be created.') , 'default', null, 'error');
				}
            }
        } else {
            $this->request->data['ContestType']['is_template'] = 0;
            $this->request->data['ContestType']['maximum_entries_allowed'] = Configure::read('contest.maximum_entry_allowed');
            $this->request->data['ContestType']['maximum_entries_allowed_per_user'] = Configure::read('contest.maximum_entry_allowed_per_user');
        }
        if (isset($this->params['named']['type']) && $this->params['named']['type'] == 'templates') {
            $this->pageTitle = __l('Add New Contest Template');
            $this->request->data['ContestType']['is_template'] = 1;
        } else {
            $this->pageTitle = __l('Add New Contest Type');
        }		
        $resources = $this->ContestType->Resource->find('list',array(
			'conditions' => $resource_condition,
			'recursive' => -1
		));
		$condition = array(
                    'ContestType.is_template' => 1
                );
		if($resources) {
			$condition['ContestType.resource_id'] = array_keys($resources);
		}
        if (empty($this->request->data['ContestType']['is_template'])) {
            $templates = $this->ContestType->find('list', array(
                'conditions' => $condition,
				'recursive' => -1
            ));
            $this->set('templates', $templates);
        }
		$this->set('resource_id', (!empty($resource_id))?$resource_id:0);
        $this->set(compact('resources'));
    }
    public function admin_delete($id = null)
    {
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        if ($this->ContestType->delete($id)) {
            $this->Session->setFlash(sprintf(__l('%s has been deleted'), __l('Contest Type')) , 'default', null, 'success');
            $this->redirect(array(
                'action' => 'index'
            ));
        } else {
            throw new NotFoundException(__l('Invalid request'));
        }
    }
    public function admin_list_cforms()
    {
        $this->set('contestTypes', $this->ContestType->find('list'));
    }
    public function view($id, $is_submited = 0)
    {
        $this->loadModel('Contests.Form');
        $contestType = $this->Form->buildSchema($id);
        $this->set('contestType', $contestType);
    }
    public function admin_pricing($id = null)
    {
        if (!empty($this->request->data['ContestType'])) {
            $id = $this->request->data['ContestType']['id'];
        }
        if (is_null($id)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contestType = $this->ContestType->find('first', array(
            'conditions' => array(
                'ContestType.id' => $id
            ) ,
            'contain' => array(
                'PricingPackage' => array(
                    'conditions' => array(
                        'PricingPackage.is_active' => 1
                    ) ,
                ) ,
                'PricingDay'
            ) ,
            'recursive' => 2
        ));
        if (empty($contestType)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $this->pageTitle = __l('Contest Type - Pricing') . ' - ' . $contestType['ContestType']['name'];
        if (!empty($this->request->data['ContestType'])) {
            $_Data = array();
            $_Data['ContestType']['id'] = $this->request->data['ContestType']['id'];
            if (!empty($this->request->data['ContestType']['blind_fee']['is_checked']) && isset($this->request->data['ContestType']['blind_fee']['price'])) {
                $_Data['ContestType']['blind_fee'] = $this->request->data['ContestType']['blind_fee']['price'];
                $_Data['ContestType']['is_blind'] = 1;
            } else {
                $_Data['ContestType']['blind_fee'] = 0;
                $_Data['ContestType']['is_blind'] = 0;
            }
            if (!empty($this->request->data['ContestType']['private_fee']['is_checked']) && isset($this->request->data['ContestType']['private_fee']['price'])) {
                $_Data['ContestType']['private_fee'] = $this->request->data['ContestType']['private_fee']['price'];
                $_Data['ContestType']['is_private'] = 1;
            } else {
                $_Data['ContestType']['private_fee'] = 0;
                $_Data['ContestType']['is_private'] = 0;
            }
            if (!empty($this->request->data['ContestType']['featured_fee']['is_checked']) && isset($this->request->data['ContestType']['featured_fee']['price'])) {
                $_Data['ContestType']['featured_fee'] = $this->request->data['ContestType']['featured_fee']['price'];
                $_Data['ContestType']['is_featured'] = 1;
            } else {
                $_Data['ContestType']['featured_fee'] = 0;
                $_Data['ContestType']['is_featured'] = 0;
            }
			if (!empty($this->request->data['ContestType']['highlight_fee']['is_checked']) && isset($this->request->data['ContestType']['highlight_fee']['price'])) {
				$_Data['ContestType']['highlight_fee'] = $this->request->data['ContestType']['highlight_fee']['price'];
				$_Data['ContestType']['is_highlight'] = 1;
			} else {
				$_Data['ContestType']['highlight_fee'] = 0;
				$_Data['ContestType']['is_highlight'] = 0;
			}
            $this->ContestType->save($_Data);
            foreach($this->request->data['PricingPackage'] as $pricing_package_id => $pricingPackage) {
                if (!empty($pricingPackage['is_checked'])) {
                    $_data = array();
					if(empty($pricingPackage['maximum_entry_allowed'])) {
						$pricingPackage['maximum_entry_allowed'] = 0;
					}
                    $_data['ContestTypesPricingPackage'] = $pricingPackage;
                    $_data['ContestTypesPricingPackage']['pricing_package_id'] = $pricing_package_id;
                    $_data['ContestTypesPricingPackage']['contest_type_id'] = $id;
                    if(empty($_data['ContestTypesPricingPackage']['id'])){
                    $this->ContestType->PricingPackage->ContestTypesPricingPackage->create();
                    }
                    $this->ContestType->PricingPackage->ContestTypesPricingPackage->save($_data);
                } else {
                    if (!empty($pricingPackage['id'])) {
                        $this->ContestType->PricingPackage->ContestTypesPricingPackage->create();
                        $this->ContestType->PricingPackage->ContestTypesPricingPackage->delete($pricingPackage['id']);
                    }
                }
            }
            foreach($this->request->data['PricingDay'] as $pricing_day_id => $pricingDay) {
                if (!empty($pricingDay['is_checked'])) {
                    $_data = array();
					if(empty($pricingDay['price'])) {
						$pricingDay['price'] = 0;
					}
                    $_data['ContestTypesPricingDay'] = $pricingDay;
                    $_data['ContestTypesPricingDay']['pricing_day_id'] = $pricing_day_id;
                    $_data['ContestTypesPricingDay']['contest_type_id'] = $id;
                     if(empty($_data['ContestTypesPricingDay']['id'])){
                    $this->ContestType->PricingDay->ContestTypesPricingDay->create();
                    }
                    $this->ContestType->PricingDay->ContestTypesPricingDay->save($_data);
                } else {
                    if (!empty($pricingDay['id'])) {
                        $this->ContestType->PricingDay->ContestTypesPricingDay->create();
                        $this->ContestType->PricingDay->ContestTypesPricingDay->delete($pricingDay['id']);
                    }
                }
            }
            $this->Session->setFlash(sprintf(__l('%s has been updated'), __l('Contest Type Pricing')) , 'default', null, 'success');
            $this->redirect(array(
                'controller' => 'contests',
                'action' => 'add',
                'contest_type_id' => $id,
                'type' => 'preview'
            ));
        } else {
            $this->request->data['ContestType']['id'] = $contestType['ContestType']['id'];
        }
        $pricingPackages = $this->ContestType->PricingPackage->find('all', array(
            'conditions' => array(
                'PricingPackage.is_active' => 1
            ) ,
            'fields' => array(
                'PricingPackage.id',
                'PricingPackage.name',
                'PricingPackage.description',
                'PricingPackage.maximum_entry_allowed',
                'PricingPackage.participant_commision',
                'PricingPackage.global_price',
            ) ,
            'order' => array(
                'PricingPackage.id' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $pricingDays = $this->ContestType->PricingDay->find('all', array(
            'conditions' => array(
                'PricingDay.is_active' => 1
            ) ,
            'fields' => array(
                'PricingDay.id',
                'PricingDay.no_of_days',
                'PricingDay.global_price',
            ) ,
            'order' => array(
                'PricingDay.id' => 'asc'
            ) ,
            'recursive' => -1
        ));
        $this->set(compact('contestType', 'pricingPackages', 'pricingDays'));
    }
    public function index()
    {
        $this->pageTitle = __l('Contest Types');
        $conditions = array();
        $conditions['ContestType.is_template'] = 0;
        $conditions['ContestType.is_active'] = 1;
		if (!isPluginEnabled('VideoResources')) { 
			$conditions['Not']['ContestType.resource_id'][] = ConstResourceId::Video;
		}
		if (!isPluginEnabled('ImageResources')) { 
			$conditions['Not']['ContestType.resource_id'][] = ConstResourceId::Image;
		}
		if (!isPluginEnabled('AudioResources')) { 
			$conditions['Not']['ContestType.resource_id'][] = ConstResourceId::Audio;
		}
		if (!isPluginEnabled('TextResources')) { 
			$conditions['Not']['ContestType.resource_id'][] = ConstResourceId::Text;
		}
        $this->paginate = array(
            'conditions' => $conditions,
            'order' => array(
                'ContestType.name' => 'asc'
            ) ,
            'recursive' => -1,
        );
        $this->set('contestTypes', $this->paginate());
        if (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'contest_type') {
            $this->render('contest_type_list');
        } elseif (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'home_contest_type') {
            $this->render('contest_types');
        } elseif (!empty($this->params['named']['type']) && $this->params['named']['type'] == 'contest_type_browse') {
            $contestTypes = $this->paginate();
            $conditions = array();
            if (!empty($this->params['named']['contest_status'])) {
                switch ($this->request->params['named']['contest_status']) {
                    case 'open':
                        $conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
                        break;

                    case 'inprocess':
                        $conditions['Contest.contest_status_id'] = array(
                            ConstContestStatus::Judging,
                            ConstContestStatus::WinnerSelected,
                            ConstContestStatus::WinnerSelectedByAdmin,
                            ConstContestStatus::ChangeRequested,
                            ConstContestStatus::ChangeCompleted
                        );
                        $this->pageTitle.= __l(' - In process ');
                        break;

                    case 'closed':
                        $conditions['Contest.contest_status_id'] = array(
                            ConstContestStatus::Completed,
                            ConstContestStatus::PaidToParticipant
                        );
                        $this->pageTitle.= __l(' - Closed');
                        break;

                    case 'all':
                        $conditions['Contest.contest_status_id'] = array(
                            ConstContestStatus::Judging,
                            ConstContestStatus::WinnerSelected,
                            ConstContestStatus::WinnerSelectedByAdmin,
                            ConstContestStatus::ChangeRequested,
                            ConstContestStatus::ChangeCompleted,
                            ConstContestStatus::Completed,
                            ConstContestStatus::Open,
							ConstContestStatus::PaidToParticipant
                        );
                        break;
                }
            }
			$conditions['Contest.admin_suspend'] = 0;
			$i = 0;
            foreach($contestTypes As $key => $contestType) {
				$contest_count_types = $this->ContestType->Contest->find('count', array(
					'conditions' => array(
						'Contest.contest_type_id' => $contestType['ContestType']['id'],
						$conditions,
					),
					'recursive' => -1
				));
				$contestTypes[$key]['ContestType']['count'] = $contest_count_types;
				$i+=$contest_count_types;
			}
            $this->set('contests_all_count', $i);
            $this->set('contestTypes', $contestTypes);
            $this->render('contest_type_browse');
        }
    }
}
?>