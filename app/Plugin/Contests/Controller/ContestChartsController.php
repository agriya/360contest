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
require_once APP . 'Controller' . DS . 'ChartsController.php';
class ContestChartsController extends ChartsController
{
    public $name = 'ContestCharts';
	public $lastDays;
    public $lastMonths;
    public $lastYears;
    public $lastWeeks;
    public $selectRanges;
    public $lastDaysStartDate;
    public $lastMonthsStartDate;
    public $lastYearsStartDate;
    public $lastWeeksStartDate;
    public $lastDaysPrev;
    public $lastWeeksPrev;
    public $lastMonthsPrev;
    public $lastYearsPrev;
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
                '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("now")) ,
                '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("now"))
            )
        );
        $days = 13;
        for ($i = $days; $i >= 7; $i--) {
            $this->lastDaysPrev[] = array(
                'display' => date('M d, Y', strtotime("-$i days")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d 00:00:00', strtotime("-$i days")) ,
                    '#MODEL#.created <=' => date('Y-m-d 23:59:59', strtotime("-$i days"))
                )
            );
        }
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
                    '#MODEL#.created >=' => date('Y-m-d', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d', $end) ,
                )
            );
        }
        $this->lastWeeks[] = array(
            'display' => date('M d', $timestamp_end+24*3600) . ' - ' . date('M d') ,
            'conditions' => array(
                '#MODEL#.created >=' => date('Y-m-d', $timestamp_end+24*3600) ,
                '#MODEL#.created <=' => date('Y-m-d', strtotime('now'))
            )
        );
        $weeks = 7;
        for ($i = $weeks; $i > 3; $i--) {
            $start = $timestamp_end-((($i*7) -1) *24*3600);
            $end = $start+(6*24*3600);
            $this->lastWeeksPrev[] = array(
                'display' => date('M d', $start) . ' - ' . date('M d', $end) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-d', $start) ,
                    '#MODEL#.created <=' => date('Y-m-d', $end)
                )
            );
        }
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
        $months = 5;
        for ($i = $months; $i > 2; $i--) {
            $this->lastMonthsPrev[] = array(
                'display' => date('M, Y', strtotime("-$i months")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-m-01', strtotime("-$i months")) ,
                    '#MODEL#.created <=' => date('Y-m-' . date('t', strtotime("-$i months")) , strtotime("-$i months"))
                )
            );
        }
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
        $years = 5;
        for ($i = $years; $i > 2; $i--) {
            $this->lastYearsPrev[] = array(
                'display' => date('Y', strtotime("-$i years")) ,
                'conditions' => array(
                    '#MODEL#.created >=' => date('Y-01-01', strtotime("-$i years")) ,
                    '#MODEL#.created <=' => date('Y-12-' . date('t', strtotime("-$i years")) , strtotime("-$i years")) ,
                )
            );
        }
        $this->selectRanges = array(
            'lastDays' => __l('Last 7 days') ,
            'lastWeeks' => __l('Last 4 weeks') ,
            'lastMonths' => __l('Last 3 months') ,
            'lastYears' => __l('Last 3 years')
        );
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
        $chart_contest_status_data = $this->_setLineData($select_var, $contest_model_datas, 'Contest', $common_conditions);
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
        $chart_contest_user_status_data = $this->_setLineData($select_var, $contest_user_model_datas, 'ContestUser', $common_conditions);
        $this->set('chart_contest_user_status_data', $chart_contest_user_status_data);
        $this->set('chart_contest_user_status_periods', $contest_user_model_datas);
        $is_ajax_load = false;
        if ($this->RequestHandler->isAjax()) {
            $is_ajax_load = true;
        }
        $this->set('is_ajax_load', $is_ajax_load);
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
    protected function _setLineData($select_var, $model_datas, $models, $model = '', $common_conditions = array())
    {
        if (is_array($models)) {
            foreach($models as $m) {
                $this->loadModel($m);
            }
        } else {
            $this->loadModel($models);
            $model = $models;
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
}
