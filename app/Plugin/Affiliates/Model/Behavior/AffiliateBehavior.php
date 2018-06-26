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
class AffiliateBehavior extends ModelBehavior
{
    function afterSave(Model $model, $created) 
    {
		if (isPluginEnabled('Affiliates')) {
            $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
            if (isset($affiliate_model)) {
                if (array_key_exists($model->name, $affiliate_model)) {
                    if ($created) {
                        $this->__createAffiliate($model);
                    } else {
                        $this->__updateAffiliate($model);
                    }
                }
            }
        }
    }
    function __createAffiliate(Model $model) 
    {
		App::import('Core', 'Cookie');
        $collection = new ComponentCollection();
        App::import('Component', 'Email');
        $cookie = new CookieComponent($collection);
        $referred_by_user_id = $cookie->read('referrer');
        $this->User = $this->__getparentClass('User');
        $affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
        if ($model->name == 'User') {
            // referred count update
            if (!empty($referred_by_user_id)) {
                $this->User->updateAll(array(
                    'User.referred_by_user_count' => 'User.referred_by_user_count + ' . '1'
                ) , array(
                    'User.id' => $referred_by_user_id
                ));
            }
            if ($this->__CheckAffiliateUSer($referred_by_user_id)) {
                $this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
                $affiliateType = $this->AffiliateType->find('first', array(
                    'conditions' => array(
                        'AffiliateType.id' => $affiliate_model['User']
                    ) ,
                    'fields' => array(
                        'AffiliateType.id',
                        'AffiliateType.commission',
                        'AffiliateType.affiliate_commission_type_id'
                    ) ,
                    'recursive' => -1
                ));
                $affiliate_commision_amount = 0;
                if (!empty($affiliateType)) {
                    if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                        $affiliate_commision_amount = (Configure::read('user.signup_fee') *$affiliateType['AffiliateType']['commission']) /100;
                    } else {
                        $affiliate_commision_amount = $affiliateType['AffiliateType']['commission'];
                    }
                }
                if (!empty($affiliate_commision_amount)) {
                    $user = $model->find('first', array(
                        'conditions' => array(
                            'User.id' => $model->id
                        ) ,
                        'recursive' => -1
                    ));
                    $affiliate['Affiliate']['class'] = 'User';
                    $affiliate['Affiliate']['foreign_id'] = $model->id;
                    $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['User'];
                    $affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
                    if ($user['User']['is_active']) {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                    } else {
                        $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                    }
                    $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                    $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                    $this->__saveAffiliate($affiliate);
                }
            }
        } else if ($model->name == 'Contest') {
            $this->Contest = $this->__getparentClass('Contests.Contest');
            $contest = $this->Contest->find('first', array(
                'conditions' => array(
                    'Contest.id' => $model->id
                ) ,
                'contain' => array(
                    'User'
                ) ,
                'recursive' => 0
            ));
            if (!empty($contest['User']['referred_by_user_id'])) {
                $referred_by_user_id = $contest['User']['referred_by_user_id'];
            }
            if (!empty($referred_by_user_id) && $this->__CheckAffiliateUSer($referred_by_user_id)) {
                if (Configure::read('affiliate.commission_on_every_contest_listing')) {
                    $is_allow_to_process = 1;
                } else {
                    $contest = $this->Contest->find('count', array(
                        'conditions' => array(
                            'Contest.id <>' => $model->id,
                            'Contest.user_id' => $contest['Contest']['user_id'],
                            'Contest.referred_by_user_id' => $contest['User']['referred_by_user_id'],
                        ) ,
						'recursive' => -1
                    ));
                    if ($contest < 1) {
                        $is_allow_to_process = 1;
                    }
                }
                if (!empty($is_allow_to_process) && $contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval) {
                    $this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
                    $affiliateType = $this->AffiliateType->find('first', array(
                        'conditions' => array(
                            'AffiliateType.id' => $affiliate_model['Contest']
                        ) ,
                        'fields' => array(
                            'AffiliateType.id',
                            'AffiliateType.commission',
                            'AffiliateType.affiliate_commission_type_id'
                        ) ,
                        'recursive' => -1
                    ));
                    $affiliate_commision_amount = $admin_commision_amount = 0;
                    if (!empty($affiliateType)) {
                        if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
                            $affiliate_commision_amount = ($contest['Contest']['creation_cost']*$affiliateType['AffiliateType']['commission']) /100;
                        } else {
                            $affiliate_commision_amount = ($contest['Contest']['creation_cost']-$affiliateType['AffiliateType']['commission']);
                        }
                        $admin_commision_amount = $contest['Contest']['creation_cost']-$affiliate_commision_amount;
                    }
					$this->Contest->updateAll(array(
                        'Contest.referred_by_user_id' => $referred_by_user_id,
                        'Contest.admin_commission_amount' => 'Contest.admin_commission_amount + ' . $admin_commision_amount,
                        'Contest.affiliate_commission_amount' => 'Contest.affiliate_commission_amount + ' . $affiliate_commision_amount,
                    ) , array(
                        'Contest.id' => $model->id
                    ));
                    // set affiliate data
                    $affiliate['Affiliate']['class'] = 'Contest';
                    $affiliate['Affiliate']['foreign_id'] = $model->id;
                    $affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['Contest'];
                    $affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                    $affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
                    $this->__saveAffiliate($affiliate);
                    $this->User->updateAll(array(
                        'User.referred_contest_count' => 'User.referred_contest_count + ' . '1'
                    ) , array(
                        'User.id' => $referred_by_user_id
                    ));
                }
            }
        }
    }
    function __updateAffiliate(&$model) 
    {
		if ($model->name == 'User' && !empty($model->id)) {
            $conditions['Affiliate.class'] = 'User';
            $conditions['Affiliate.foreign_id'] = $model->id;
            $affiliate = $this->__findAffiliate($conditions);
			App::import('Model', 'User');
            $this->User = new User();
            $user = $this->User->find('first', array(
                'conditions' => array(
                    'User.id' => $model->id
                ) ,
                'recursive' => -1
            ));
            if (!empty($user['User']['referred_by_user_id']) && !empty($affiliate)) {
                $affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
                if (!empty($user['User']['is_active'])) {
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
                } else {
                    $affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
                }
                $this->__saveAffiliate($affiliate);
            }
        } elseif ($model->name == 'Contest' && !empty($model->id)) {
            $contest = $model->find('first', array(
                'conditions' => array(
                    'Contest.id' => $model->id
                ) ,
                'contain' => array(
					'User',
                    'Transaction'
                ) ,
                'recursive' => 2
            ));
			if($contest['Contest']['contest_status_id'] == ConstContestStatus::Open || $contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval || $contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending) {
				if($contest['Contest']['contest_status_id'] == ConstContestStatus::Open) {
					$conditions['Affiliate.class'] = 'Contest';
					$conditions['Affiliate.foreign_id'] = $model->id;
					$affiliate = $this->__findAffiliate($conditions);
					if (!empty($contest['Contest']['referred_by_user_id']) && !empty($affiliate)) {
						if (!empty($contest['Transaction'][0]['id']) || ($affiliate['Affiliate']['commission_amount'] == '0.00' && !empty($contest['Contest']['creation_cost']))) {
							if ($affiliate['Affiliate']['commission_amount'] == '0.00' && !empty($contest['Contest']['creation_cost'])) {
								$this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
								$affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
								$affiliateType = $this->AffiliateType->find('first', array(
									'conditions' => array(
										'AffiliateType.id' => $affiliate_model['Contest']
									) ,
									'fields' => array(
										'AffiliateType.id',
										'AffiliateType.commission',
										'AffiliateType.affiliate_commission_type_id'
									) ,
									'recursive' => -1
								));
								$affiliate_commision_amount = $admin_commision_amount = 0;
								if (!empty($affiliateType)) {
									if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
										$affiliate_commision_amount = ($contest['Contest']['creation_cost']*$affiliateType['AffiliateType']['commission']) /100;
									} else {
										$affiliate_commision_amount = ($contest['Contest']['creation_cost']-$affiliateType['AffiliateType']['commission']);
									}
									$admin_commision_amount = $contest['Contest']['creation_cost']-$affiliate_commision_amount;
								}
								$affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
							}
							$affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
							$affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
						}
						$this->__saveAffiliate($affiliate);
					}
				} elseif($contest['Contest']['contest_status_id'] == ConstContestStatus::PendingApproval || $contest['Contest']['contest_status_id'] == ConstContestStatus::PaymentPending) {
					if (!empty($contest['User']['referred_by_user_id'])) {
						$referred_by_user_id = $contest['User']['referred_by_user_id'];
					}
					if (!empty($referred_by_user_id) && $this->__CheckAffiliateUSer($referred_by_user_id)) {
						if (Configure::read('affiliate.commission_on_every_contest_listing')) {
							$is_allow_to_process = 1;
						} else {
							$contest = $this->Contest->find('count', array(
								'conditions' => array(
									'Contest.id <>' => $model->id,
									'Contest.user_id' => $contest['Contest']['user_id'],
									'Contest.referred_by_user_id' => $contest['User']['referred_by_user_id'],
								) ,
								'recursive' => -1
							));
							if ($contest < 1) {
								$is_allow_to_process = 1;
							}
						}
						$this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
						$affiliateType = $this->AffiliateType->find('first', array(
							'conditions' => array(
								'AffiliateType.id' => $affiliate_model['Contest']
							) ,
							'fields' => array(
								'AffiliateType.id',
								'AffiliateType.commission',
								'AffiliateType.affiliate_commission_type_id'
							) ,
							'recursive' => -1
						));
						$affiliate_commision_amount = $admin_commision_amount = 0;
						if (!empty($affiliateType)) {
							if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
								$affiliate_commision_amount = ($contest['Contest']['creation_cost']*$affiliateType['AffiliateType']['commission']) /100;
							} else {
								$affiliate_commision_amount = ($contest['Contest']['creation_cost']-$affiliateType['AffiliateType']['commission']);
							}
							$admin_commision_amount = $contest['Contest']['creation_cost']-$affiliate_commision_amount;
						}
						$this->Contest->updateAll(array(
							'Contest.referred_by_user_id' => $referred_by_user_id,
							'Contest.admin_commission_amount' => 'Contest.admin_commission_amount + ' . $admin_commision_amount,
							'Contest.affiliate_commission_amount' => 'Contest.affiliate_commission_amount + ' . $affiliate_commision_amount,
						) , array(
							'Contest.id' => $model->id
						));
						// set affiliate data
						$affiliate['Affiliate']['class'] = 'Contest';
						$affiliate['Affiliate']['foreign_id'] = $model->id;
						$affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['Contest'];
						$affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
						$affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
						$affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
						$this->__saveAffiliate($affiliate);
						$this->User->updateAll(array(
							'User.referred_contest_count' => 'User.referred_contest_count + ' . '1'
						) , array(
							'User.id' => $referred_by_user_id
						));
					}
				}
			} elseif($contest['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelected || $contest['Contest']['contest_status_id'] == ConstContestStatus::WinnerSelectedByAdmin) {
				if (!empty($contest['User']['referred_by_user_id'])) {
					$referred_by_user_id = $contest['User']['referred_by_user_id'];
				}
				if (!empty($referred_by_user_id) && $this->__CheckAffiliateUSer($referred_by_user_id)) {
					if (Configure::read('affiliate.commission_on_every_contest_price')) {
						$is_allow_to_process = 1;
					} else {
						$contest = $this->Contest->find('count', array(
							'conditions' => array(
								'Contest.id <>' => $model->id,
								'Contest.user_id' => $contest['Contest']['user_id'],
								'Contest.referred_by_user_id' => $contest['User']['referred_by_user_id'],
							) ,
							'recursive' => -1
						));
						if ($contest < 1) {
							$is_allow_to_process = 1;
						}
					}
					$this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
					$affiliateType = $this->AffiliateType->find('first', array(
						'conditions' => array(
							'AffiliateType.id' => $affiliate_model['ContestPrize']
						) ,
						'fields' => array(
							'AffiliateType.id',
							'AffiliateType.commission',
							'AffiliateType.affiliate_commission_type_id'
						) ,
						'recursive' => -1
					));
					$affiliate_commision_amount = $admin_commision_amount = 0;
					if (!empty($affiliateType)) {
						if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
							$affiliate_commision_amount = ($contest['Contest']['prize']*$affiliateType['AffiliateType']['commission']) /100;
						} else {
							$affiliate_commision_amount = ($contest['Contest']['prize']-$affiliateType['AffiliateType']['commission']);
						}
						$admin_commision_amount = $contest['Contest']['prize']-$affiliate_commision_amount;
					}
					$this->Contest->updateAll(array(
                        'Contest.referred_by_user_id' => $referred_by_user_id,
                        'Contest.admin_commission_amount' => 'Contest.admin_commission_amount + ' . $admin_commision_amount,
                        'Contest.affiliate_commission_amount' => 'Contest.affiliate_commission_amount + ' . $affiliate_commision_amount,
                    ) , array(
                        'Contest.id' => $model->id
                    ));
					// set affiliate data
					$affiliate['Affiliate']['class'] = 'ContestPrize';
					$affiliate['Affiliate']['foreign_id'] = $model->id;
					$affiliate['Affiliate']['affiliate_type_id'] = $affiliate_model['Contest'];
					$affiliate['Affiliate']['affliate_user_id'] = $referred_by_user_id;
					$affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Pending;
					$affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
					$this->__saveAffiliate($affiliate);
					$this->User->updateAll(array(
						'User.referred_contest_count' => 'User.referred_contest_count + ' . '1'
					) , array(
						'User.id' => $referred_by_user_id
					));
				}
			} elseif($contest['Contest']['contest_status_id'] == ConstContestStatus::PaidToParticipant) {
				$conditions['Affiliate.class'] = 'ContestPrize';
				$conditions['Affiliate.foreign_id'] = $model->id;
				$affiliate = $this->__findAffiliate($conditions);
				if (!empty($contest['Contest']['referred_by_user_id']) && !empty($affiliate)) {
					if (($affiliate['Affiliate']['commission_amount'] == '0.00' && !empty($contest['Contest']['prize']))) {
						if ($affiliate['Affiliate']['commission_amount'] == '0.00' && !empty($contest['Contest']['prize'])) {
							$this->AffiliateType = $this->__getparentClass('Affiliates.AffiliateType');
							$affiliate_model = Cache::read('affiliate_model', 'affiliatetype');
							$affiliateType = $this->AffiliateType->find('first', array(
								'conditions' => array(
									'AffiliateType.id' => $affiliate_model['ContestPrize']
								) ,
								'fields' => array(
									'AffiliateType.id',
									'AffiliateType.commission',
									'AffiliateType.affiliate_commission_type_id'
								) ,
								'recursive' => -1
							));
							$affiliate_commision_amount = $admin_commision_amount = 0;
							if (!empty($affiliateType)) {
								if (($affiliateType['AffiliateType']['affiliate_commission_type_id'] == ConstAffiliateCommissionType::Percentage)) {
									$affiliate_commision_amount = ($contest['Contest']['prize']*$affiliateType['AffiliateType']['commission']) /100;
								} else {
									$affiliate_commision_amount = ($contest['Contest']['prize']-$affiliateType['AffiliateType']['commission']);
								}
								$admin_commision_amount = $contest['Contest']['prize']-$affiliate_commision_amount;
							}
							$affiliate['Affiliate']['commission_amount'] = $affiliate_commision_amount;
						}
						$affiliate['Affiliate']['commission_holding_start_date'] = date('Y-m-d');
						$affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::PipeLine;
					}
					$this->__saveAffiliate($affiliate);
				}
			} elseif($contest['Contest']['contest_status_id'] == ConstContestStatus::Rejected) {
				$conditions['Affiliate.class'] = 'Contest';
				$conditions['Affiliate.foreign_id'] = $model->id;
				$affiliate = $this->__findAffiliate($conditions);
				if(!empty($affiliate)) {
					$affiliate['Affiliate']['affiliate_status_id'] = ConstAffiliateStatus::Canceled;
					$this->User = $this->__getparentClass('User');
					$this->User->updateAll(array(
						'User.total_commission_canceled_amount' => 'User.total_commission_canceled_amount + ' . $affiliate['Affiliate']['commission_amount']
					) , array(
						'User.id' => $affiliate['Affiliate']['affliate_user_id']
					));
					$this->__saveAffiliate($affiliate);
				}
			}			
        }
    }
    function __saveAffiliate($data) 
    {
        $this->Affiliate = $this->__getparentClass('Affiliates.Affiliate');
        if (!isset($data['Affiliate']['id']) && !empty($data['Affiliate']['affliate_user_id'])) {
            $this->Affiliate->create();
            $this->Affiliate->AffiliateUser->updateAll(array(
                'AffiliateUser.total_commission_pending_amount' => 'AffiliateUser.total_commission_pending_amount + ' . $data['Affiliate']['commission_amount']
            ) , array(
                'AffiliateUser.id' => $data['Affiliate']['affliate_user_id']
            ));
        }
        if (!empty($data['Affiliate']['class']) || !empty($data['Affiliate']['foreign_id']) || !empty($data['Affiliate']['affiliate_status_id']) || !empty($data['Affiliate']['commission_amount']) || !empty($data['Affiliate']['commission_holding_start_date'])) {
            $this->Affiliate->save($data);
        }
    }
    function __findAffiliate($condition) 
    {
        $this->Affiliate = $this->__getparentClass('Affiliates.Affiliate');
        $affiliate = $this->Affiliate->find('first', array(
            'conditions' => $condition,
            'recursive' => -1
        ));
        return $affiliate;
    }
    function __CheckAffiliateUSer($refer_user_id) 
    {
        $this->User = $this->__getparentClass('User');
        $user = $this->User->find('first', array(
            'conditions' => array(
                'User.id' => $refer_user_id
            ) ,
            'recursive' => -1
        ));
        if (!empty($user) && ($user['User']['is_affiliate_user'])) {
            return true;
        }
        return false;
    }
    function __getparentClass($parentClass) 
    {
        App::import('Model', $parentClass);
        $parentClassArr = explode('.', $parentClass);
        if (sizeof($parentClassArr) > 1) {
            $parentClass = $parentClassArr[1];
        }
        return new $parentClass();
    }
}
?>