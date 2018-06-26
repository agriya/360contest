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
class InsightsController extends AppController
{
    public $name = 'Insights';
    public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public function initChart() 
    {
        //# last days date settings
        $days = 6;
        $this->lastDaysStartDate = date('Y-m-d', strtotime("-$days days"));
        for ($i = $days; $i > 0; $i--) {
            $this->lastDays[] = array(
                'display' => date('D, M d', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
        $this->lastDays[] = array(
            'display' => date('D, M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-m-d H:i:s', strtotime('now')) ,
            )
        );
        //# last weeks date settings
        $timestamp_end = strtotime('last Saturday');
        $weeks = 3;
        $this->lastWeeksStartDate = date('Y-m-d', $timestamp_end-((($weeks*7) -1) *24*3600));
        for ($i = $weeks; $i > 0; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeks[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', $end) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', $timestamp_end+24*3600) ,
                '#MODEL#.created <=' => date('Y-m-d H:i:s', strtotime('now'))
            )
        );
        //# last months date settings
        $months = 2;
        $this->lastMonthsStartDate = date('Y-m-01', strtotime("-$months months"));
        for ($i = $months; $i > 0; $i--) {
            $this->lastMonths[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-t', strtotime("-$i months")) ,
                )
            );
        }
        $this->lastMonths[] = array(
            'display' => date('M, Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-m-t', strtotime('now')) ,
            )
        );
        //# last years date settings
        $years = 2;
        $this->lastYearsStartDate = date('Y-01-01', strtotime("-$years years"));
        for ($i = $years; $i > 0; $i--) {
            $this->lastYears[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-31', strtotime("-$i years")) ,
                )
            );
        }
        $this->lastYears[] = array(
            'display' => date('Y') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-01-01', strtotime('now')) ,
                '#MODEL#.created <=' => date('Y-12-31', strtotime('now')) ,
            )
        );
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
    }
    function admin_index() 
    {
        $this->pageTitle = __l('Insights');
    }
    public function admin_chart_transactions()
    {
        $this->initChart();
        $this->loadModel('Contests.Contest');
        $this->loadModel('Transaction');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['ContestChart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['ContestChart']['select_range_id'])) {
            $select_var = $this->request->data['ContestChart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['ContestChart']['select_range_id'] = $select_var;
        $conditions = array();
        $transaction_model_datas = array();
        $transaction_model_datas['Total Earned (Site) Amount'] = array(
            'display' => __l('Site Earned Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Contest',
            'conditions' => array_merge(array(
                'Contest.contest_status_id' => array(
                    ConstContestStatus::PaidToParticipant
                )
            ) , $conditions) ,
        );
        if (isPluginEnabled('Wallet')) {
            $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
                'display' => __l('Deposited') . ' (' . Configure::read('site.currency') . ')',
                'model' => 'Transaction',
                'conditions' => array(
                    'Transaction.transaction_type_id' => ConstTransactionTypes::AmountAddedToWallet
                ) ,
            );
            if (isPluginEnabled('Withdrawals')) {
                $this->loadModel('Withdrawals.UserCashWithdrawal');
                $transaction_model_datas['Total Withdrawn Amount'] = array(
                    'display' => __l('Withdrawn Amount') . ' (' . Configure::read('site.currency') . ')',
                    'model' => 'Transaction',
                    'conditions' => array(
                        'Transaction.transaction_type_id' => ConstTransactionTypes::AcceptCashWithdrawRequest
                    ) ,
                );
                $transaction_model_datas['Total Pending Withdraw Request'] = array(
                    'display' => __l('Pending Withdraw Request') ,
                    'model' => 'UserCashWithdrawal',
                    'conditions' => array(
                        'UserCashWithdrawal.withdrawal_status_id' => ConstWithdrawalStatus::Pending
                    ) ,
                );
            }
        }
        $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'Contest') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Contest.creation_cost) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->_setContestOrders($select_var);
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        $this->set('selectRanges', $this->selectRanges);
        //contest and entries
        //# contests
        $this->loadModel('Contests.ContestStatus');
        $contest_statuses = $this->ContestStatus->find('all', array(
            'recursive' => -1
        ));
        foreach($contest_statuses as $contest_status) {
            $contest_model_datas[$contest_status['ContestStatus']['name']] = array(
                'display' => $contest_status['ContestStatus']['name'],
                'conditions' => array(
                    'Contest.contest_status_id' => $contest_status['ContestStatus']['id']
                ) ,
            );
        }
        $contest_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array();
        $chart_contest_status_data = $this->_setLineData($select_var, $contest_model_datas, 'Contest', 'Contest', $common_conditions);
        $this->set('chart_contest_status_data', $chart_contest_status_data);
        $this->set('chart_contest_status_periods', $contest_model_datas);
        //chart entries
        $this->loadModel('Contests.ContestUser');
        $this->loadModel('Contests.ContestUserStatus');
        //# contests entries
        $contest_user_statuses = $this->ContestUserStatus->find('all', array(
            'recursive' => -1
        ));
        foreach($contest_user_statuses as $contest_user_status) {
            $contest_user_model_datas[$contest_user_status['ContestUserStatus']['name']] = array(
                'display' => $contest_user_status['ContestUserStatus']['name'],
                'conditions' => array(
                    'ContestUser.contest_user_status_id' => $contest_user_status['ContestUserStatus']['id'],
                    'ContestUser.is_active' => 1
                ) ,
            );
        }
        $contest_user_model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array(
                'ContestUser.is_active' => 1
            )
        );
        $common_conditions = array();
        $chart_contest_user_status_data = $this->_setLineData($select_var, $contest_user_model_datas, 'ContestUser', 'ContestUser', $common_conditions);
        $this->set('chart_contest_user_status_data', $chart_contest_user_status_data);
        $this->set('chart_contest_user_status_periods', $contest_user_model_datas);
        $is_ajax_load = false;
        if ($this->RequestHandler->isAjax()) {
            $is_ajax_load = true;
        }
        $this->set('is_ajax_load', $is_ajax_load);
    }
    public function _admin_chart_amounts($model_datas, $select_var) 
    {
        $chart_model_data = array();
        $this->loadModel('Transaction');
        $this->loadModel('Contests.Contest');
        $this->loadModel('Contests.ContestUser');
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'Contest' && $model_data['display_field'] == 'RevenueCommission') {
                    $value_count = $this->Contest->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Contest.site_commision) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'Contest' && $model_data['display_field'] == 'ListingFee') {
                    $value_count = $this->Contest->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Contest.creation_cost) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else if ($modelClass == 'ContestUser') {
                    $value_count = $this->ContestUser->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(ContestUser.site_revenue) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_model_data[$val['display']][] = $value_count;
            }
        }
        return $chart_model_data;
    }
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array()) 
    {
        if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
        }
        $_data = array();
        foreach($this->$select_var as $val) {
            foreach($model_datas as $model_data) {
                $new_conditions = array();
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $model, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                $new_conditions = array_merge($new_conditions, $common_conditions);
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = $model;
                }
                $_data[$val['display']][] = $this->{$modelClass}->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
            }
        }
        return $_data;
    }
    public function admin_chart_users() 
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('User');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['GooglePlus'] = array(
            'display' => __l('GooglePlus') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['Linkedin'] = array(
            'display' => __l('Linkedin') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'User', 'User', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d 23:59:59');
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
            ) ,
            'recursive' => -1
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'User.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                    'User.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->User->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => -1
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_chart_user_demographics() 
    {
        $this->loadModel('User');
        $select_var = 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $role_id = ConstUserTypes::User;
        $total_users = $this->User->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'User.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
                'User.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true)
            ) ,
            'recursive' => -1
        ));
        $conditions = array(
            'User.created >=' => _formatDate('Y-m-d H:i:s', $startDate, true) ,
            'User.created <=' => _formatDate('Y-m-d H:i:s', $endDate, true) ,
            'User.role_id' => $role_id
        );
        $_pie_data = $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        $check_user = $this->User->UserProfile->find('count', array(
            'conditions' => $conditions,
            'recursive' => 1
        ));
        $total_users = $check_user;
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = $not_mentioned+$user_educations;
            foreach($user_educations As $edu_key => $user_education) {
                $new_conditions = $conditions;
                if ($edu_key == 0) {
                    $new_conditions['UserProfile.education_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.education_id'] = $edu_key;
                }
                $education_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_education_data[$user_education] = number_format(($education_count/$total_users) *100, 2);
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = $not_mentioned+$user_relationships;
            foreach($user_relationships As $rel_key => $user_relationship) {
                $new_conditions = $conditions;
                if ($rel_key == 0) {
                    $new_conditions['UserProfile.relationship_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.relationship_id'] = $rel_key;
                }
                $relationship_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_relationship_data[$user_relationship] = number_format(($relationship_count/$total_users) *100, 2);
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = $not_mentioned+$user_employments;
            foreach($user_employments As $emp_key => $user_employment) {
                $new_conditions = $conditions;
                if ($emp_key == 0) {
                    $new_conditions['UserProfile.employment_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.employment_id'] = $emp_key;
                }
                $employment_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_employment_data[$user_employment] = number_format(($employment_count/$total_users) *100, 2);
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = $not_mentioned+$user_income_ranges;
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                $new_conditions = $conditions;
                if ($inc_key == 0) {
                    $new_conditions['UserProfile.income_range_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.income_range_id'] = $inc_key;
                }
                $income_range_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_income_data[$user_income_range] = number_format(($income_range_count/$total_users) *100, 2);
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = $not_mentioned+$genders;
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = array(
                        NULL,
                        0
                    );
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = $not_mentioned+$user_ages;
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -18 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -34 years'));
                } elseif ($age_key == 2) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -35 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -44 years'));
                } elseif ($age_key == 3) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -45 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -54 years'));
                } elseif ($age_key == 4) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -55 years'));
                } elseif ($age_key == 0) {
                    $new_conditions['OR']['UserProfile.dob'] = NULL;
                    $new_conditions['UserProfile.dob < '] = date('Y-m-d', strtotime('now -18 years'));
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        } else {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = array_merge($not_mentioned, $user_educations);
            foreach($user_educations As $edu_key => $user_education) {
                if ($edu_key == 0) {
                    $chart_pie_education_data[$user_education] = 100;
                } else {
                    $chart_pie_education_data[$user_education] = 0;
                }
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = array_merge($not_mentioned, $user_relationships);
            foreach($user_relationships As $rel_key => $user_relationship) {
                if ($rel_key == 0) {
                    $chart_pie_relationship_data[$user_relationship] = 100;
                } else {
                    $chart_pie_relationship_data[$user_relationship] = 0;
                }
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = array_merge($not_mentioned, $user_employments);
            foreach($user_employments As $emp_key => $user_employment) {
                if ($emp_key == 0) {
                    $chart_pie_employment_data[$user_employment] = 100;
                } else {
                    $chart_pie_employment_data[$user_employment] = 0;
                }
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = array_merge($not_mentioned, $user_income_ranges);
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                if ($inc_key == 0) {
                    $chart_pie_income_data[$user_income_range] = 100;
                } else {
                    $chart_pie_income_data[$user_income_range] = 0;
                }
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                if ($gen_key == 0) {
                    $chart_pie_gender_data[$gender] = 100;
                } else {
                    $chart_pie_gender_data[$gender] = 0;
                }
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                if ($age_key == 0) {
                    $chart_pie_age_data[$user_ages] = 100;
                } else {
                    $chart_pie_age_data[$user_ages] = 0;
                }
            }
        }
        $this->set('role_id', $role_id);
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }
    public function admin_chart_user_logins() 
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['Gmail'] = array(
            'display' => __l('Google+') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['Linkedin'] = array(
            'display' => __l('Linkedin') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        // overall pie chart
        $select_var.= 'StartDate';
        $startDate = $this->$select_var;
        $endDate = date('Y-m-d H:i:s');
        $total_users = $this->UserLogin->find('count', array(
            'conditions' => array(
                'User.role_id' => $role_id,
                'UserLogin.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                'UserLogin.created <=' => date('Y-m-d H:i:s', strtotime($endDate)) ,
            ) ,
            'recursive' => 0
        ));
        unset($model_datas['All']);
        $_pie_data = array();
        if (!empty($total_users)) {
            foreach($model_datas as $_period) {
                $new_conditions = array();
                $new_conditions = array_merge($_period['conditions'], array(
                    'UserLogin.created >=' => date('Y-m-d H:i:s', strtotime($startDate)) ,
                    'UserLogin.created <=' => date('Y-m-d H:i:s', strtotime($endDate))
                ));
                $new_conditions['User.role_id'] = $role_id;
                $sub_total = $this->UserLogin->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $_pie_data[$_period['display']] = number_format(($sub_total/$total_users) *100, 2);
            }
        }
        $this->set('chart_pie_data', $_pie_data);
    }
    public function admin_user_activities_insights() 
    {
        if (isset($this->request->params['named']['role_id'])) {
            $this->request->data['Chart']['role_id'] = $this->request->params['named']['role_id'];
        }
        if (isset($this->request->data['Chart']['is_ajax_load'])) {
            $this->request->params['named']['is_ajax_load'] = $this->request->data['Chart']['is_ajax_load'];
        }
        $this->initChart();
        $this->loadModel('UserLogin');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $role_id = ConstUserTypes::User;
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $this->request->data['Chart']['role_id'] = $role_id;
        $model_datas['Normal'] = array(
            'display' => __l('Normal') ,
            'conditions' => array(
                'User.is_facebook_register' => 0,
                'User.is_twitter_register' => 0,
                'User.is_openid_register' => 0,
                'User.is_google_register' => 0,
                'User.is_googleplus_register' => 0,
                'User.is_yahoo_register' => 0,
                'User.is_linkedin_register' => 0,
            )
        );
        $model_datas['Twitter'] = array(
            'display' => __l('Twitter') ,
            'conditions' => array(
                'User.is_twitter_register' => 1,
            ) ,
        );
        if (Configure::read('facebook.is_enabled_facebook_connect')) {
            $model_datas['Facebook'] = array(
                'display' => __l('Facebook') ,
                'conditions' => array(
                    'User.is_facebook_register' => 1,
                )
            );
        }
        if (Configure::read('openid.is_enabled_openid_connect') || Configure::read('google.is_enabled_google_connect') || Configure::read('google.is_enabled_googleplus_connect') || Configure::read('yahoo.is_enabled_yahoo_connect')) {
            $model_datas['OpenID'] = array(
                'display' => __l('OpenID') ,
                'conditions' => array(
                    'User.is_openid_register' => 1,
                )
            );
        }
        $model_datas['Gmail'] = array(
            'display' => __l('Gmail') ,
            'conditions' => array(
                'User.is_google_register' => 1,
            )
        );
        $model_datas['Gmail'] = array(
            'display' => __l('Google+') ,
            'conditions' => array(
                'User.is_googleplus_register' => 1,
            )
        );
        $model_datas['Yahoo'] = array(
            'display' => __l('Yahoo!') ,
            'conditions' => array(
                'User.is_yahoo_register' => 1,
            )
        );
        $model_datas['Linkedin'] = array(
            'display' => __l('Linkedin') ,
            'conditions' => array(
                'User.is_linkedin_register' => 1,
            )
        );
        $model_datas['All'] = array(
            'display' => __l('All') ,
            'conditions' => array()
        );
        $common_conditions = array(
            'User.role_id' => $role_id
        );
        $_data = $this->_setLineData($select_var, $model_datas, 'UserLogin', 'UserLogin', $common_conditions);
        $this->set('chart_data', $_data);
        $this->set('chart_periods', $model_datas);
        $this->set('selectRanges', $this->selectRanges);
        if (isPluginEnabled('UserFavourites')) {
			// User Follow
			$model_datas = array();
			$model_datas['user-follow'] = array(
				'display' => __l('User Followers') ,
				'conditions' => array()
			);
			$_user_follow_data = $this->_setLineData($select_var, $model_datas, 'UserFavourites.UserFavorite', 'UserFavorite');
			$this->set('user_follow_data', $_user_follow_data);
		}
		if (isPluginEnabled('Contests')) {
			// Contest Comments
			$model_datas = array();
			$conditions['Message.is_activity'] = 0;
			$conditions['Message.is_sender'] = 1;
			$conditions['NOT'] = array(
				'Message.contest_id' => 0
			);
			$model_datas['contest_comments'] = array(
				'display' => __l('Contest Comments') ,
				'conditions' => array()
			);
			$_contest_comments_data = $this->_setLineData($select_var, $model_datas, 'Contests.Message', 'Message', $conditions);
			$this->set('contest_comments_data', $_contest_comments_data);
		}
		if (isPluginEnabled('EntryRatings')) {
			// Entry Rating
			$model_datas = array();
			$model_datas['entry_rating'] = array(
				'display' => __l('Entry Ratings') ,
				'conditions' => array()
			);
			$_entry_rating_data = $this->_setLineData($select_var, $model_datas, 'EntryRatings.ContestUserRating', 'ContestUserRating');
			$this->set('entry_rating_data', $_entry_rating_data);
		}
		if (isPluginEnabled('ContestFollowers')) {
			// Contest Followers
			$model_datas = array();
			$model_datas['contest_follow'] = array(
				'display' => __l('Contest Followers') ,
				'conditions' => array()
			);
			$_contest_follower_data = $this->_setLineData($select_var, $model_datas, 'ContestFollowers.ContestFollower', 'ContestFollower');
			$this->set('contest_follower_data', $_contest_follower_data);
		}
		if (isPluginEnabled('ContestFlags')) {
			// Contest Flags
			$model_datas = array();
			$model_datas['contest_flag'] = array(
				'display' => __l('Contest Flags') ,
				'conditions' => array()
			);
			$_contest_flag_data = $this->_setLineData($select_var, $model_datas, 'ContestFlags.ContestFlag', 'ContestFlag');
			$this->set('contest_flag_data', $_contest_flag_data);
		}
		if (isPluginEnabled('EntryFlags')) {
			// Entry Flags
			$model_datas = array();
			$model_datas['entry_flag'] = array(
				'display' => __l('Entry Flags') ,
				'conditions' => array()
			);
			$_entry_flag_data = $this->_setLineData($select_var, $model_datas, 'EntryFlags.ContestUserFlag', 'ContestUserFlag');
			$this->set('entry_flag_data', $_entry_flag_data);
		}
		if (isPluginEnabled('UserFlags')) {
			// User Flags
			$model_datas = array();
			$model_datas['user_flag'] = array(
				'display' => __l('User Flags') ,
				'conditions' => array()
			);
			$_user_flag_data = $this->_setLineData($select_var, $model_datas, 'UserFlags.UserFlag', 'UserFlag');
			$this->set('user_flag_data', $_user_flag_data);
		}
    }
    public function admin_chart_price_points() 
    {
        $this->loadModel('Contests.Contest');
        $pricePoints = array(
            array(
                'price_points' => '0 - 499.99',
                'range' => array(
                    0,
                    499.99
                )
            ) ,
            array(
                'price_points' => '500 - 999.99',
                'range' => array(
                    500,
                    999.99
                )
            ) ,
            array(
                'price_points' => '1000 - 2499.99',
                'range' => array(
                    1000,
                    2499.99
                )
            ) ,
            array(
                'price_points' => '2500 - 4999.99',
                'range' => array(
                    2500,
                    4999.99
                )
            ) ,
            array(
                'price_points' => '5000 - 7499.99',
                'range' => array(
                    5000,
                    7499.99
                )
            ) ,
            array(
                'price_points' => '7500 - 9999.99',
                'range' => array(
                    7500,
                    9999.99
                )
            ) ,
            array(
                'price_points' => '10000 - 14999.99',
                'range' => array(
                    10000,
                    14999.99
                )
            ) ,
            array(
                'price_points' => '15000 - 19999.99',
                'range' => array(
                    15000,
                    19999.99
                )
            ) ,
            array(
                'price_points' => '20000 - 24999.99',
                'range' => array(
                    20000,
                    24999.99
                )
            ) ,
            array(
                'price_points' => '25000 +',
                'range' => array(
                    25000
                )
            )
        );
        foreach($pricePoints as $key => $pricePoint) {
            $new_conditions = array();
            $new_conditions['Contest.creation_cost >='] = $pricePoint['range'][0];
            if (isset($pricePoint['range'][1])) {
                $new_conditions['Contest.creation_cost <='] = $pricePoint['range'][1];
            }
            $db = ConnectionManager::getDataSource('default');
            $sum_total_revenue_contest = $this->Contest->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'SUM(' . $db->name('Contest.site_commision') . ' + ' . $db->name('Contest.creation_cost') . ') as revenue',
                ) ,
                'recursive' => -1
            ));
            if (!empty($sum_total_revenue_contest)) {
                $pricePoints[$key]['revenue'] = is_null($sum_total_revenue_contest[0][0]['revenue']) ? 0 : $sum_total_revenue_contest[0][0]['revenue'];
            } else {
                $pricePoints[$key]['revenue'] = 0;
            }
            $pricePoints[$key]['contests_count'] = $this->Contest->find('count', array(
                'conditions' => $new_conditions,
                'recursive' => -1
            ));
            $contest_ids = $this->Contest->find('list', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'Contest.id'
                ) ,
                'recursive' => -1
            ));
            $contest_users = $this->Contest->ContestUser->find('count', array(
                'conditions' => array(
                    'ContestUser.contest_id' => $contest_ids
                ) ,
                'recursive' => -1
            ));
            $pricePoints[$key]['contest_users'] = is_null($contest_users) ? 0 : $contest_users;
            $pricePoints[$key]['average_contest_user_count'] = !empty($pricePoints[$key]['contests_count']) ? ($pricePoints[$key]['contest_users']/$pricePoints[$key]['contests_count']) : 0;
            $pricePoints[$key]['average_revenue_contest_amoumt'] = !empty($pricePoints[$key]['contests_count']) ? ($pricePoints[$key]['revenue']/$pricePoints[$key]['contests_count']) : 0;
        }
        $this->set('pricePoints', $pricePoints);
    }
    public function admin_chart_contests_stats() 
    {
        $this->loadModel('Contests.Contest');
        $contests_stats = array();
        $min_contest_creation_cost = $this->Contest->find('all', array(
            'conditions' => array(
                'Contest.creation_cost != ' => '0.00'
            ) ,
            'fields' => array(
                'MIN(Contest.creation_cost) as min_contest_creation_cost',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['creation_cost']['min'] = is_null($min_contest_creation_cost[0][0]['min_contest_creation_cost']) ? 0 : $min_contest_creation_cost[0][0]['min_contest_creation_cost'];
		$max_contest_creation_cost = $this->Contest->find('all', array(
            'conditions' => array(
                'Contest.creation_cost != ' => '0.00'
            ) ,
            'fields' => array(
                'MAX(Contest.creation_cost) as max_contest_creation_cost',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['creation_cost']['max'] = is_null($max_contest_creation_cost[0][0]['max_contest_creation_cost']) ? 0 : $max_contest_creation_cost[0][0]['max_contest_creation_cost'];
        $min_contest_prize_amount = $this->Contest->find('all', array(
            'fields' => array(
                'MIN(Contest.prize) as min_contest_prize_amount',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['prize']['min'] = is_null($min_contest_prize_amount[0][0]['min_contest_prize_amount']) ? 0 : $min_contest_prize_amount[0][0]['min_contest_prize_amount'];
		$max_contest_prize_amount = $this->Contest->find('all', array(
            'fields' => array(
                'MAX(Contest.prize) as max_contest_prize_amount',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['prize']['max'] = is_null($max_contest_prize_amount[0][0]['max_contest_prize_amount']) ? 0 : $max_contest_prize_amount[0][0]['max_contest_prize_amount'];
        // Site Commission
        $min_site_commision = $this->Contest->find('all', array(
            'conditions' => array(
                'Contest.site_commision != ' => '0'
            ) ,
            'fields' => array(
                'MIN(Contest.site_commision) as min_site_commision',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['site_commision']['min'] = is_null($min_site_commision[0][0]['min_site_commision']) ? 0 : $min_site_commision[0][0]['min_site_commision'];
        $max_site_commision = $this->Contest->find('all', array(
            'fields' => array(
                'MAX(Contest.site_commision) as max_site_commision',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['site_commision']['max'] = is_null($max_site_commision[0][0]['max_site_commision']) ? 0 : $max_site_commision[0][0]['max_site_commision'];
		/// client requirement
		$posted_contest_total_amount = $this->Contest->find('all', array(
            'conditions' => array(
                'Contest.is_paid' => 1,
				'Contest.creation_cost != ' => '0.00'
            ) ,
            'fields' => array(
                'SUM(Contest.creation_cost) as posted_contest_total_amount',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['posted_contest_total_amount']['gross_profit'] = is_null($posted_contest_total_amount[0][0]['posted_contest_total_amount']) ? 0 : $posted_contest_total_amount[0][0]['posted_contest_total_amount'];
		$contests_stats['posted_contest_total_amount']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
                'Contest.is_paid' => 1,
				'Contest.creation_cost != ' => '0.00'
            ) ,
            'recursive' => -1
        ));
		$this->loadModel('Transaction');
		$total_profit = $this->Transaction->find('all', array(
            'conditions' => array(
                'Transaction.transaction_type_id' => array(
					ConstTransactionTypes::SignupFee,
					ConstTransactionTypes::SiteCommisionDeductUsingMarketplace,
				),
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as total_profit',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['total_profit']['gross_profit'] = $contests_stats['posted_contest_total_amount']['gross_profit'] + (is_null($total_profit[0][0]['total_profit']) ? 0 : $total_profit[0][0]['total_profit']);
        $contests_stats['total_profit']['count'] = $contests_stats['posted_contest_total_amount']['count'] + $this->Transaction->find('count', array(
            'conditions' => array(
                'Transaction.transaction_type_id' => array(
					ConstTransactionTypes::SignupFee,
					ConstTransactionTypes::SiteCommisionDeductUsingMarketplace,
				),
            ), 
            'recursive' => -1
        ));
		$waiting_to_be_paid_to_participants = $this->Contest->find('all', array(
            'conditions' => array(
				'Contest.contest_status_id' => array(
					ConstContestStatus::WinnerSelected,
					ConstContestStatus::WinnerSelectedByAdmin,
					ConstContestStatus::ChangeRequested,
					ConstContestStatus::ChangeCompleted,
					ConstContestStatus::Completed,
				)
			),
			'fields' => array(
                'SUM(Contest.prize) as waiting_to_be_paid_to_participants',
            ) ,
            'recursive' => -1
        ));
		$contests_stats['waiting_to_be_paid_to_participants']['gross_profit'] = is_null($waiting_to_be_paid_to_participants[0][0]['waiting_to_be_paid_to_participants']) ? 0 : $waiting_to_be_paid_to_participants[0][0]['waiting_to_be_paid_to_participants'];
		$contests_stats['waiting_to_be_paid_to_participants']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
				'Contest.contest_status_id' => array(
					ConstContestStatus::WinnerSelected,
					ConstContestStatus::WinnerSelectedByAdmin,
					ConstContestStatus::ChangeRequested,
					ConstContestStatus::ChangeCompleted,
					ConstContestStatus::Completed,
				)
			),
            'recursive' => -1
        ));
		$paid_to_participants = $this->Contest->find('all', array(
            'conditions' => array(
				'Contest.contest_status_id' => array(
					ConstContestStatus::PaidToParticipant,
				)
			),
			'fields' => array(
                'SUM(Contest.prize) as paid_to_participants',
            ) ,
            'recursive' => -1
        ));
		$contests_stats['paid_to_participants']['gross_profit'] = is_null($paid_to_participants[0][0]['paid_to_participants']) ? 0 : $paid_to_participants[0][0]['paid_to_participants'];
		$contests_stats['paid_to_participants']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
				'Contest.contest_status_id' => array(
					ConstContestStatus::PaidToParticipant,
				)
			),
            'recursive' => -1
        ));
		$membership_fee = $this->Transaction->find('all', array(
            'conditions' => array(
                'Transaction.transaction_type_id' => array(
					ConstTransactionTypes::SignupFee,
				),
            ) ,
            'fields' => array(
                'SUM(Transaction.amount) as membership_fee',
            ) ,
            'recursive' => -1
        ));
        $contests_stats['membership_fee']['gross_profit'] = is_null($membership_fee[0][0]['membership_fee']) ? 0 : $membership_fee[0][0]['membership_fee'];
		$contests_stats['membership_fee']['count'] = $this->Transaction->find('count', array(
            'conditions' => array(
                'Transaction.transaction_type_id' => array(
					ConstTransactionTypes::SignupFee,
				),
            ),
            'recursive' => -1
        ));
		
		$price_packages = $this->Contest->PricingPackage->find('all', array(
            'conditions' => array(
                'PricingPackage.is_active' => 1,
            ),
            'recursive' => -1
        ));
		$this->set('price_packages', $price_packages);
		foreach($price_packages As $price_package) {
			$total_site_commission = $this->Contest->find('all', array(
				'conditions' => array(
					'Contest.pricing_package_id' => $price_package['PricingPackage']['id'],
				),
				'fields' => array(
					'SUM(Contest.site_commision) as total_site_commission',
				),
				'recursive' => -1
			));
			$contests_stats[$price_package['PricingPackage']['name']]['gross_profit'] = is_null($total_site_commission[0][0]['total_site_commission']) ? 0 : $total_site_commission[0][0]['total_site_commission'];
			$contests_stats[$price_package['PricingPackage']['name']]['count'] = $this->Contest->find('count', array(
				'conditions' => array(
					'Contest.pricing_package_id' => $price_package['PricingPackage']['id'],
				),
				'recursive' => -1
			));
		}
		
		$blind_contest_fee = $this->Contest->find('all', array(
            'conditions' => array(
				'Contest.is_blind' => 1
			),
			'fields' => array(
                'SUM(Contest.blind_contest_fee) as blind_contest_fee',
            ) ,
            'recursive' => -1
        ));
		$contests_stats['blind_contest_fee']['gross_profit'] = is_null($blind_contest_fee[0][0]['blind_contest_fee']) ? 0 : $blind_contest_fee[0][0]['blind_contest_fee'];
		$contests_stats['blind_contest_fee']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
				'Contest.is_blind' => 1
			),
            'recursive' => -1
        ));
		$private_contest_fee = $this->Contest->find('all', array(
            'conditions' => array(
				'Contest.is_private' => 1
			),
			'fields' => array(
                'SUM(Contest.private_contest_fee) as private_contest_fee',
            ) ,
            'recursive' => -1
        ));
		$contests_stats['private_contest_fee']['gross_profit'] = is_null($private_contest_fee[0][0]['private_contest_fee']) ? 0 : $private_contest_fee[0][0]['private_contest_fee'];
		$contests_stats['private_contest_fee']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
				'Contest.is_private' => 1
			),
            'recursive' => -1
        ));
		$featured_contest_fee = $this->Contest->find('all', array(
            'conditions' => array(
				'Contest.is_featured' => 1
			),
			'fields' => array(
                'SUM(Contest.featured_contest_fee) as featured_contest_fee',
            ) ,
            'recursive' => -1
        ));
		$contests_stats['featured_contest_fee']['gross_profit'] = is_null($featured_contest_fee[0][0]['featured_contest_fee']) ? 0 : $featured_contest_fee[0][0]['featured_contest_fee'];
		$contests_stats['featured_contest_fee']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
				'Contest.is_featured' => 1
			),
            'recursive' => -1
        ));
		$highlight_contest_fee = $this->Contest->find('all', array(
            'conditions' => array(
				'Contest.is_highlight' => 1
			),
			'fields' => array(
                'SUM(Contest.highlight_contest_fee) as highlight_contest_fee',
            ) ,
            'recursive' => -1
        ));
		$contests_stats['highlight_contest_fee']['gross_profit'] = is_null($highlight_contest_fee[0][0]['highlight_contest_fee']) ? 0 : $highlight_contest_fee[0][0]['highlight_contest_fee'];
		$contests_stats['highlight_contest_fee']['count'] = $this->Contest->find('count', array(
            'conditions' => array(
				'Contest.is_highlight' => 1
			),
            'recursive' => -1
        ));
		
		$pricing_days = $this->Contest->PricingDay->find('all', array(
            'conditions' => array(
                'PricingDay.is_active' => 1,
            ),
            'recursive' => -1
        ));
		foreach($pricing_days As $pricing_day){
			$total_priceing_day_amount = 0;
			$contests = $this->Contest->find('all', array(
				'conditions' => array(
					'Contest.pricing_day_id' => $pricing_day['PricingDay']['id'],
				),
				'recursive' => -1
			));
			foreach($contests As $contest) {
				$price = $this->Contest->PricingDay->ContestTypesPricingDay->find('first', array(
					'conditions' => array(
						'ContestTypesPricingDay.pricing_day_id' => $contest['Contest']['pricing_day_id'],
						'ContestTypesPricingDay.contest_type_id' => $contest['Contest']['contest_type_id'],
					),
					'recursive' => -1
				));
				if(!empty($price)) {
					$total_priceing_day_amount = $total_priceing_day_amount + $price['ContestTypesPricingDay']['price'];
				} else {
					$total_priceing_day_amount = $total_priceing_day_amount + $pricing_day['PricingDay']['global_price'];
				}
			}
			$contests_stats[$pricing_day['PricingDay']['no_of_days'] . ' Days']['gross_profit'] = $total_priceing_day_amount;
			$contests_stats[$pricing_day['PricingDay']['no_of_days'] . ' Days']['count'] = count($contests);
		}
		$this->set('pricing_days', $pricing_days);
        $this->set('contests_stats', $contests_stats);
    }
    public function chart_demographics() 
    {
        $this->loadModel('Contests.Contest');
        $conditions = array();
        $conditions['Contest.user_id'] = $this->Auth->user('id');
        $contests = $this->Contest->find('list', array(
            'conditions' => $conditions,
            'fields' => array(
                'Contest.id',
            ) ,
            'recursive' => -1
        ));
        $contest_users = $this->Contest->ContestUser->find('list', array(
            'conditions' => array(
                'ContestUser.contest_id' => $contests
            ) ,
            'fields' => array(
                'ContestUser.id',
                'ContestUser.user_id',
            ) ,
            'recursive' => -1
        ));
        $total_users = count($contest_users);
        // demographics
        $conditions = array(
            'UserProfile.user_id' => $contest_users
        );
        $this->_setDemographics($total_users, $conditions);
        $this->set('user_type_id', $this->Auth->user('role_id'));
    }
    public function chart_user_transactions() 
    {
        $this->initChart();
        $this->loadModel('Transaction');
        if (isset($this->request->params['named']['select_range_id'])) {
            $this->request->data['Chart']['select_range_id'] = $this->request->params['named']['select_range_id'];
        }
        if (isset($this->request->data['Chart']['select_range_id'])) {
            $select_var = $this->request->data['Chart']['select_range_id'];
        } else {
            $select_var = 'lastDays';
        }
        $this->request->data['Chart']['select_range_id'] = $select_var;
        $conditions = array();
        $transaction_model_datas = array();
        $transaction_model_datas['Total Contest Amount Received'] = array(
            'display' => __l('Amount Received') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::NewContestAdded,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        $transaction_model_datas['Total Deposited (Add to wallet) Amount'] = array(
            'display' => __l('Deposited Amount') . ' (' . Configure::read('site.currency') . ')',
            'model' => 'Transaction',
            'conditions' => array(
                'Transaction.transaction_type_id' => ConstTransactionTypes::AmountAddedToWallet,
                'Transaction.user_id' => $this->Auth->user('id')
            ) ,
        );
        $chart_transactions_data = array();
        foreach($this->$select_var as $val) {
            foreach($transaction_model_datas as $model_data) {
                $new_conditions = array();
                if (isset($model_data['model'])) {
                    $modelClass = $model_data['model'];
                } else {
                    $modelClass = 'Transaction';
                }
                foreach($val['conditions'] as $key => $v) {
                    $key = str_replace('#MODEL#', $modelClass, $key);
                    $new_conditions[$key] = $v;
                }
                $new_conditions = array_merge($new_conditions, $model_data['conditions']);
                if ($modelClass == 'Transaction') {
                    $value_count = $this->{$modelClass}->find('all', array(
                        'conditions' => $new_conditions,
                        'fields' => array(
                            'SUM(Transaction.amount) as total_amount'
                        ) ,
                        'recursive' => -1
                    ));
                    $value_count = is_null($value_count[0][0]['total_amount']) ? 0 : $value_count[0][0]['total_amount'];
                } else {
                    $value_count = $this->{$modelClass}->find('count', array(
                        'conditions' => $new_conditions,
                        'recursive' => 0
                    ));
                }
                $chart_transactions_data[$val['display']][] = $value_count;
            }
        }
        $this->_setContestUsers($select_var);
        $this->set('chart_transactions_periods', $transaction_model_datas);
        $this->set('chart_transactions_data', $chart_transactions_data);
        $this->set('selectRanges', $this->selectRanges);
    }
    public function admin_contest_detailed_stats($contest_id) 
    {
        $this->setAction('contest_detailed_stats', $contest_id);
    }
    public function contest_detailed_stats($contest_id) 
    {
        $this->pageTitle = __l('Contest Stats');
        $this->loadModel('Contests.Contest');
        $conditions = array();
        $conditions['Contest.id'] = $contest_id;
        $contest = $this->Contest->find('first', array(
            'conditions' => $conditions,
            'contain' => array(
                'ContestUser' => array(
                    'order' => array(
                        'ContestUser.created' => 'ASC'
                    ) ,
                )
            ) ,
            'recursive' => 1
        ));
        if (empty($contest)) {
            throw new NotFoundException(__l('Invalid request'));
        }
        $contest_users = array();
        $contest_stats = array();
        $contest_stats['creation_cost'] = $contest['Contest']['creation_cost'];
        $contest_stats['prize'] = $contest['Contest']['prize'];
        $contest_stats['contest_user_count'] = $contest['Contest']['contest_user_count'];
        $contest_stats['site_commision'] = $contest['Contest']['site_commision'];
        $contestUserIds = array();
        if (!empty($contest['ContestUser'])) {
            $contestUserIds = array();
            foreach($contest['ContestUser'] as $contestUsers) {
                $contestUserIds[$contestUsers['id']] = $contestUsers['user_id'];
            }
        }
        $total_users = count($contest['ContestUser']);
        // demographics
        $conditions = array(
            'UserProfile.user_id' => array_unique($contestUserIds)
        );
        $this->pageTitle.= ' - ' . substr($contest['Contest']['name'], 0, 100);
        $this->pageTitle.= (strlen($contest['Contest']['name']) > 100) ? '...' : '';
        $this->_setDemographics($total_users, $conditions);
        $this->set('contest', $contest);
        $this->set('user_type_id', $this->Auth->user('role_id'));
        $this->set('contest_stats', $contest_stats);
    }
    protected function _setDemographics($total_users, $conditions = array()) 
    {
        $this->loadModel('User');
        $chart_pie_relationship_data = $chart_pie_education_data = $chart_pie_employment_data = $chart_pie_income_data = $chart_pie_gender_data = $chart_pie_age_data = array();
        $check_user = $this->User->UserProfile->find('count', array(
            'conditions' => $conditions,
            'recursive' => -1
        ));
        $total_users = $check_user;
        if (!empty($total_users)) {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = $not_mentioned+$user_educations;
            foreach($user_educations As $edu_key => $user_education) {
                $new_conditions = $conditions;
                if ($edu_key == 0) {
                    $new_conditions['UserProfile.education_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.education_id'] = $edu_key;
                }
                $education_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_education_data[$user_education] = number_format(($education_count/$total_users) *100, 2);
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = $not_mentioned+$user_relationships;
            foreach($user_relationships As $rel_key => $user_relationship) {
                $new_conditions = $conditions;
                if ($rel_key == 0) {
                    $new_conditions['UserProfile.relationship_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.relationship_id'] = $rel_key;
                }
                $relationship_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_relationship_data[$user_relationship] = number_format(($relationship_count/$total_users) *100, 2);
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = $not_mentioned+$user_employments;
            foreach($user_employments As $emp_key => $user_employment) {
                $new_conditions = $conditions;
                if ($emp_key == 0) {
                    $new_conditions['UserProfile.employment_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.employment_id'] = $emp_key;
                }
                $employment_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_employment_data[$user_employment] = number_format(($employment_count/$total_users) *100, 2);
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = $not_mentioned+$user_income_ranges;
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                $new_conditions = $conditions;
                if ($inc_key == 0) {
                    $new_conditions['UserProfile.income_range_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.income_range_id'] = $inc_key;
                }
                $income_range_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_income_data[$user_income_range] = number_format(($income_range_count/$total_users) *100, 2);
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = $not_mentioned+$genders;
            foreach($genders As $gen_key => $gender) {
                $new_conditions = $conditions;
                if ($gen_key == 0) {
                    $new_conditions['UserProfile.gender_id'] = array(
                        0,
                        NULL
                    );
                } else {
                    $new_conditions['UserProfile.gender_id'] = $gen_key;
                }
                $gender_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_gender_data[$gender] = number_format(($gender_count/$total_users) *100, 2);
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = $not_mentioned+$user_ages;
            foreach($user_ages As $age_key => $user_ages) {
                $new_conditions = $conditions;
                if ($age_key == 1) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -18 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -34 years'));
                } elseif ($age_key == 2) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -35 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -44 years'));
                } elseif ($age_key == 3) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -45 years'));
                    $new_conditions['UserProfile.dob <= '] = date('Y-m-d', strtotime('now -54 years'));
                } elseif ($age_key == 4) {
                    $new_conditions['UserProfile.dob >= '] = date('Y-m-d', strtotime('now -55 years'));
                } elseif ($age_key == 0) {
                    $new_conditions['OR']['UserProfile.dob'] = NULL;
                    $new_conditions['UserProfile.dob < '] = date('Y-m-d', strtotime('now -18 years'));
                }
                $age_count = $this->User->UserProfile->find('count', array(
                    'conditions' => $new_conditions,
                    'recursive' => 0
                ));
                $chart_pie_age_data[$user_ages] = number_format(($age_count/$total_users) *100, 2);
            }
        } else {
            $not_mentioned = array(
                '0' => __l('Not Mentioned')
            );
            //# education
            $user_educations = $this->User->UserProfile->Education->find('list', array(
                'conditions' => array(
                    'Education.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'education',
                ) ,
                'recursive' => -1
            ));
            $user_educations = array_merge($not_mentioned, $user_educations);
            foreach($user_educations As $edu_key => $user_education) {
                if ($edu_key == 0) {
                    $chart_pie_education_data[$user_education] = 100;
                } else {
                    $chart_pie_education_data[$user_education] = 0;
                }
            }
            //# relationships
            $user_relationships = $this->User->UserProfile->Relationship->find('list', array(
                'conditions' => array(
                    'Relationship.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'relationship',
                ) ,
                'recursive' => -1
            ));
            $user_relationships = array_merge($not_mentioned, $user_relationships);
            foreach($user_relationships As $rel_key => $user_relationship) {
                if ($rel_key == 0) {
                    $chart_pie_relationship_data[$user_relationship] = 100;
                } else {
                    $chart_pie_relationship_data[$user_relationship] = 0;
                }
            }
            //# employments
            $user_employments = $this->User->UserProfile->Employment->find('list', array(
                'conditions' => array(
                    'Employment.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'employment',
                ) ,
                'recursive' => -1
            ));
            $user_employments = array_merge($not_mentioned, $user_employments);
            foreach($user_employments As $emp_key => $user_employment) {
                if ($emp_key == 0) {
                    $chart_pie_employment_data[$user_employment] = 100;
                } else {
                    $chart_pie_employment_data[$user_employment] = 0;
                }
            }
            //# income
            $user_income_ranges = $this->User->UserProfile->IncomeRange->find('list', array(
                'conditions' => array(
                    'IncomeRange.is_active' => 1,
                ) ,
                'fields' => array(
                    'id',
                    'income',
                ) ,
                'recursive' => -1
            ));
            $user_income_ranges = array_merge($not_mentioned, $user_income_ranges);
            foreach($user_income_ranges As $inc_key => $user_income_range) {
                if ($inc_key == 0) {
                    $chart_pie_income_data[$user_income_range] = 100;
                } else {
                    $chart_pie_income_data[$user_income_range] = 0;
                }
            }
            //# genders
            $genders = $this->User->UserProfile->Gender->find('list');
            $genders = array_merge($not_mentioned, $genders);
            foreach($genders As $gen_key => $gender) {
                if ($gen_key == 0) {
                    $chart_pie_gender_data[$gender] = 100;
                } else {
                    $chart_pie_gender_data[$gender] = 0;
                }
            }
            //# age calculation
            $user_ages = array(
                '1' => '18 - 34' . __l('Yrs') ,
                '2' => '35 - 44' . __l('Yrs') ,
                '3' => '45 - 54' . __l('Yrs') ,
                '4' => '55+' . __l('Yrs')
            );
            $user_ages = array_merge($not_mentioned, $user_ages);
            foreach($user_ages As $age_key => $user_ages) {
                if ($age_key == 0) {
                    $chart_pie_age_data[$user_ages] = 100;
                } else {
                    $chart_pie_age_data[$user_ages] = 0;
                }
            }
        }
        $this->set('chart_pie_education_data', $chart_pie_education_data);
        $this->set('chart_pie_relationship_data', $chart_pie_relationship_data);
        $this->set('chart_pie_employment_data', $chart_pie_employment_data);
        $this->set('chart_pie_income_data', $chart_pie_income_data);
        $this->set('chart_pie_gender_data', $chart_pie_gender_data);
        $this->set('chart_pie_age_data', $chart_pie_age_data);
    }
    protected function _setContestUsers($select_var) 
    {
        $this->loadModel('Contests.Contest');
        $common_conditions = array();
        $owner = $this->Contest->User->find('first', array(
            'conditions' => array(
                'User.id' => $this->Auth->user('id')
            ) ,
            'recursive' => -1
        ));
        $contest_id = $this->Contest->find('list', array(
            'conditions' => array(
                'Contest.user_id' => $owner['User']['id']
            ) ,
            'fields' => array(
                'Contest.id'
            ) ,
            'recursive' => -1
        ));
        $common_conditions['ContestUser.contest_id'] = $contest_id;
        $contest_user_model_datas['Entrys'] = array(
            'display' => __l('Entrys') ,
            'conditions' => array() ,
        );
        $chart_contest_user_data = $this->_setLineData($select_var, $contest_user_model_datas, array(
            'Contests.ContestUser'
        ) , 'ContestUser', $common_conditions);
        $this->set('chart_contest_user_data', $chart_contest_user_data);
    }
    public function admin_contest_stats() 
    {
        $this->pageTitle = __l('Contest Snapshot');
        $this->set('pageTitle', $this->pageTitle);
    }
    public function public_stats() 
    {
        $this->pageTitle = __l('Stats');
        $this->set('pageTitle', $this->pageTitle);
        $this->loadModel('Contests.Contest');
        $new_conditions['Contest.contest_status_id >='] = ConstContestStatus::Open;
        $this->set('launched_contests', $this->Contest->find('count', array(
            'conditions' => $new_conditions,
			'recursive' => -1
        )));
        $this->set('launched_contests_amount', $this->Contest->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Contest.creation_cost) as launched_contests_amount',
            ),
			'recursive' => -1
        )));
        $new_conditions = array();
        $new_conditions['Contest.contest_status_id'] = ConstContestStatus::PaidToParticipant;
        $this->set('successful_contests_amount', $this->Contest->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Contest.creation_cost) as successful_contests_amount',
            ),
			'recursive' => -1
        )));
        $this->set('successful_contests', $this->Contest->find('count', array(
            'conditions' => $new_conditions,
			'recursive' => -1
        )));
        $new_conditions = array();
        $new_conditions['Contest.contest_status_id'] = array(
            ConstContestStatus::Rejected,
            ConstContestStatus::CanceledByAdmin
        );
        $this->set('unsuccessful_contests_amount', $this->Contest->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Contest.creation_cost) as unsuccessful_contests_amount',
            ),
			'recursive' => -1
        )));
        $this->set('unsuccessful_contests', $this->Contest->find('count', array(
            'conditions' => $new_conditions,
			'recursive' => -1
        )));
        $new_conditions = array();
		$new_conditions['Contest.contest_status_id'] = ConstContestStatus::Open;
        $this->set('live_contests', $this->Contest->find('count', array(
            'conditions' => $new_conditions,
			'recursive' => -1
        )));
        $this->set('live_contests_amount', $this->Contest->find('all', array(
            'conditions' => $new_conditions,
            'fields' => array(
                'SUM(Contest.creation_cost) as live_contests_amount',
            ),
			'recursive' => -1
        )));
        //successful contests
        $pricePoints = array(
            array(
                'price_points' => '0 - 499.99',
                'range' => array(
                    0,
                    499.99
                )
            ) ,
            array(
                'price_points' => '500 - 999.99',
                'range' => array(
                    500,
                    999.99
                )
            ) ,
            array(
                'price_points' => '1000 - 2499.99',
                'range' => array(
                    1000,
                    2499.99
                )
            ) ,
            array(
                'price_points' => '2500 - 4999.99',
                'range' => array(
                    2500,
                    4999.99
                )
            ) ,
            array(
                'price_points' => '5000 - 7499.99',
                'range' => array(
                    5000,
                    7499.99
                )
            ) ,
            array(
                'price_points' => '7500 - 9999.99',
                'range' => array(
                    7500,
                    9999.99
                )
            ) ,
            array(
                'price_points' => '10000 - 14999.99',
                'range' => array(
                    10000,
                    14999.99
                )
            ) ,
            array(
                'price_points' => '15000 - 19999.99',
                'range' => array(
                    15000,
                    19999.99
                )
            ) ,
            array(
                'price_points' => '20000 - 24999.99',
                'range' => array(
                    20000,
                    24999.99
                )
            ) ,
            array(
                'price_points' => '25000+',
                'range' => array(
                    25000
                )
            )
        );
        foreach($pricePoints as $key => $pricePoint) {
            $new_conditions = array();
            $new_conditions['Contest.creation_cost >='] = $pricePoint['range'][0];
            $new_conditions['Contest.is_paid'] = 1;
            if (isset($pricePoint['range'][1])) {
                $new_conditions['Contest.creation_cost <='] = $pricePoint['range'][1];
            }
            $sum_total_revenue_contest = $this->Contest->find('all', array(
                'conditions' => $new_conditions,
                'fields' => array(
                    'SUM(Contest.creation_cost) as creation_cost',
                ) ,
                'recursive' => -1
            ));
            if (!empty($sum_total_revenue_contest)) {
                $pricePoints[$key]['creation_cost'] = is_null($sum_total_revenue_contest[0][0]['creation_cost']) ? 0 : $sum_total_revenue_contest[0][0]['creation_cost'];
            } else {
                $pricePoints[$key]['creation_cost'] = 0;
            }
        }
        $this->set('pricePoints', $pricePoints);
    }
	protected function _setContestOrders($select_var)
    {
        $this->loadModel('Contests.Contest');
        $common_conditions = array();
        $contest_order_model_datas['Contests'] = array(
            'display' => __l('Contests') ,
            'conditions' => array() ,
        );
        $chart_contest_orders_data = $this->_setLineData($select_var, $contest_order_model_datas, array(
            'Contest'
        ) , 'Contest', $common_conditions);
        $this->set('chart_contest_orders_data', $chart_contest_orders_data);
    }
}
?>