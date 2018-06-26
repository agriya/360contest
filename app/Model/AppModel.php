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
App::uses('Model', 'Model');
class AppModel extends Model
{
    public $actsAs = array(
        'Containable'
    );
    /**
     * use Caching
     *
     * @var string
     */
    public $useCache = true;
	public $recursive = -1;
    /**
     * Constructor
     *
     * @param mixed  $id    Set this ID for this model on startup, can also be an array of options, see above.
     * @param string $table Name of database table to use.
     * @param string $ds    DataSource connection name.
     */
    public function __construct($id = false, $table = null, $ds = null)
    {
        Cms::applyHookProperties('Hook.model_properties', $this);
        CmsHook::applyBindModel($this);
        parent::__construct($id, $table, $ds);
    }
    /**
     * Override find function to use caching
     *
     * Caching can be done either by unique names,
     * or prefixes where a hashed value of $options array is appended to the name
     *
     * @param mixed $type
     * @param array $options
     * @return mixed
     * @access public
     */
    public function find($type = 'first', $query = array())
    {
        if (Configure::read('Memcached.is_memcached_enabled')) {
            $cachedQuery = Cms::dispatchEvent('Model.HighPerformance.getCachedQuery', $this, array(
                'type' => $type,
                'params' => $query,
                'version' => '',
                'fullTag' => '',
            ));
            if (!empty($cachedQuery->data['result'])) {
                return $cachedQuery->data['result'];
            }
            $result = array(
                'version' => $cachedQuery->data['version'],
                'data' => parent::find($type, $query)
            );
            Cms::dispatchEvent('Model.HighPerformance.setCachedQuery', $this, array(
                'result' => $result,
                'fullTag' => $cachedQuery->data['fullTag'],
            ));
            return $result['data'];
        } else {
            return parent::find($type, $query);
        }
    }
    /**
     * Check if find() was already cached
     *
     * @param mixed $type
     * @param array $options
     * @return void
     * @access private
     */
    protected function _findCached($type, $options)
    {
        if (isset($options['cache']['name']) && isset($options['cache']['config'])) {
            $cacheName = $options['cache']['name'];
        } elseif (isset($options['cache']['prefix']) && isset($options['cache']['config'])) {
            $cacheName = $options['cache']['prefix'] . md5(serialize($options));
        } else {
            return false;
        }
        $cacheName.= '_' . Configure::read('Config.language');
        $results = Cache::read($cacheName, $options['cache']['config']);
        if ($results) {
            return $results;
        }
        return false;
    }
    /**
     * Updates multiple model records based on a set of conditions.
     *
     * call afterSave() callback after successful update.
     *
     * @param array $fields     Set of fields and values, indexed by fields.
     *                          Fields are treated as SQL snippets, to insert literal values manually escape your data.
     * @param mixed $conditions Conditions to match, true for all records
     * @return boolean True on success, false on failure
     * @access public
     */
    public function updateAll($fields, $conditions = true)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'updateAll'
        ) , $args);
        if ($output) {
            $created = false;
            $options = array();
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[1][$field])) {
				if (is_array($args[1][$field])) {
					foreach($args[1][$field] as $id) {
						$this->id = $id;
						$event = new CakeEvent('Model.afterSave', $this, array(
							$created,
							$options
						));
						$this->getEventManager()->dispatch($event);
					}
				} else {
					$this->id = $args[1][$field];
					$event = new CakeEvent('Model.afterSave', $this, array(
						$created,
						$options
					));
					$this->getEventManager()->dispatch($event);
				}
            }
            $this->_clearCache();
            return true;
        }
        return false;
    }
	public function deleteAll($conditions, $cascade = true, $callbacks = false)
    {
        $args = func_get_args();
        $output = call_user_func_array(array(
            'parent',
            'deleteAll'
        ) , $args);
        if ($output) {
            $field = sprintf('%s.%s', $this->alias, $this->primaryKey);
            if (!empty($args[1][$field])) {
				if (is_array($args[1][$field])) {
					foreach($args[1][$field] as $id) {
						$this->id = $id;
						$event = new CakeEvent('Model.afterDelete', $this, array(
						));
						$this->getEventManager()->dispatch($event);
					}
				} else {
					$this->id = $args[1][$field];
					$event = new CakeEvent('Model.afterDelete', $this, array(
					));
					$this->getEventManager()->dispatch($event);
				}
            }
            $this->_clearCache();
            return true;
        }
        return false;
    }
    /**
     * Fix to the Model::invalidate() method to display localized validate messages
     *
     * @param string $field The name of the field to invalidate
     * @param mixed $value Name of validation rule that was not failed, or validation message to
     *    be returned. If no validation key is provided, defaults to true.
     * @access public
     */
    public function invalidate($field, $value = true)
    {
        return parent::invalidate($field, __l($value));
    }
    /**
     * Return formatted display fields
     *
     * @param array $displayFields
     * @return array
     */
    public function displayFields($displayFields = null)
    {
        if (isset($displayFields)) {
            $this->_displayFields = $displayFields;
        }
        $out = array();
        $defaults = array(
            'sort' => true,
            'type' => 'text',
            'url' => array() ,
            'options' => array()
        );
        foreach($this->_displayFields as $field => $label) {
            if (is_int($field)) {
                $field = $label;
                list(, $label) = pluginSplit($label);
                $out[$field] = Set::merge($defaults, array(
                    'label' => Inflector::humanize($label) ,
                ));
            } elseif (is_array($label)) {
                $out[$field] = Set::merge($defaults, $label);
                if (!isset($out[$field]['label'])) {
                    $out[$field]['label'] = Inflector::humanize($field);
                }
            } else {
                $out[$field] = Set::merge($defaults, array(
                    'label' => $label,
                ));
            }
        }
        return $out;
    }
    /**
     * Return formatted edit fields
     *
     * @param array $editFields
     * @return array
     */
    public function editFields($editFields = null)
    {
        if (isset($editFields)) {
            $this->_editFields = $editFields;
        }
        if (empty($this->_editFields)) {
            $this->_editFields = array_keys($this->schema());
            $id = array_search('id', $this->_editFields);
            if ($id !== false) {
                unset($this->_editFields[$id]);
            }
        }
        $out = array();
        foreach($this->_editFields as $field => $label) {
            if (is_int($field)) {
                $out[$label] = array();
            } elseif (is_array($label)) {
                $out[$field] = $label;
            } else {
                $out[$field] = array(
                    'label' => $label,
                );
            }
        }
        return $out;
    }
    function getGatewayTypes($field = null)
    {
        App::uses('PaymentGateway', 'Model');
        $this->PaymentGateway = new PaymentGateway();
        $paymentGateways = $this->PaymentGateway->find('all', array(
            'conditions' => array(
                'PaymentGateway.is_active' => 1
            ) ,
            'contain' => array(
                'PaymentGatewaySetting' => array(
                    'conditions' => array(
                        'PaymentGatewaySetting.name' => $field,
                        'PaymentGatewaySetting.test_mode_value' => 1
                    ) ,
                ) ,
            ) ,
            'order' => array(
                'PaymentGateway.display_name' => 'asc'
            ) ,
            'recursive' => 1
        ));
        $payment_gateway_types = array();
        foreach($paymentGateways as $paymentGateway) {
            if (!empty($paymentGateway['PaymentGatewaySetting'])) {
                $payment_gateway_types[$paymentGateway['PaymentGateway']['id']] = $paymentGateway['PaymentGateway']['display_name'];
            }
        }
        return $payment_gateway_types;
    }
    public function toSaveIp()
    {
        App::import('Model', 'Ip');
        $this->Ip = new Ip();
        $this->data['Ip']['ip'] = RequestHandlerComponent::getClientIP();
        $this->data['Ip']['host'] = RequestHandlerComponent::getReferer();
        $ip = $this->Ip->find('first', array(
            'conditions' => array(
                'Ip.ip' => $this->data['Ip']['ip']
            ) ,
            'fields' => array(
                'Ip.id'
            ) ,
            'recursive' => -1
        ));
        if (empty($ip)) {
            if (!empty($_COOKIE['_geo'])) {
                $_geo = explode('|', $_COOKIE['_geo']);
                $country = $this->Ip->Country->find('first', array(
                    'conditions' => array(
                        'Country.iso_alpha2' => $_geo[0]
                    ) ,
                    'fields' => array(
                        'Country.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($country)) {
                    $this->data['Ip']['country_id'] = 0;
                } else {
                    $this->data['Ip']['country_id'] = $country['Country']['id'];
                }
                $state = $this->Ip->State->find('first', array(
                    'conditions' => array(
                        'State.name' => $_geo[1]
                    ) ,
                    'fields' => array(
                        'State.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($state)) {
                    $this->data['State']['name'] = $_geo[1];
                    $this->Ip->State->create();
                    $this->Ip->State->save($this->data['State']);
                    $this->data['Ip']['state_id'] = $this->Ip->getLastInsertId();
                } else {
                    $this->data['Ip']['state_id'] = $state['State']['id'];
                }
                $city = $this->Ip->City->find('first', array(
                    'conditions' => array(
                        'City.name' => $_geo[2]
                    ) ,
                    'fields' => array(
                        'City.id'
                    ) ,
                    'recursive' => -1
                ));
                if (empty($city)) {
                    $this->data['City']['name'] = $_geo[2];
                    $this->Ip->City->create();
                    $this->Ip->City->save($this->data['City']);
                    $this->data['Ip']['city_id'] = $this->Ip->City->getLastInsertId();
                } else {
                    $this->data['Ip']['city_id'] = $city['City']['id'];
                }
                $this->data['Ip']['latitude'] = $_geo[3];
                $this->data['Ip']['longitude'] = $_geo[4];
            }
            $this->Ip->create();
            $this->Ip->save($this->data['Ip']);
            return $this->Ip->getLastInsertId();
        } else {
            return $ip['Ip']['id'];
        }
    }
    public function findOrSaveAndGetId($data, $country_id = null, $state_id = null)
    {
        $findExist = $this->find('first', array(
            'conditions' => array(
                'name' => $data
            ) ,
            'fields' => array(
                'id'
            ) ,
            'recursive' => -1
        ));
        if (!empty($findExist)) {
            return $findExist[$this->name]['id'];
        } else {
            $_Data[$this->name]['name'] = $data;
            if (!empty($country_id)) {
                $_Data[$this->name]['country_id'] = $country_id;
            }
            if (!empty($state_id)) {
                $_Data[$this->name]['state_id'] = $state_id;
            }
            $this->create();
            $this->save($_Data[$this->name]);
            return $this->id;
        }
    }
    public function getIdHash($ids = null)
    {
        return md5($ids . Configure::read('Security.salt'));
    }
    function _checkUserNotifications($to_user_id, $field)
    {
        App::import('Model', 'UserNotification');
        $this->UserNotification = new UserNotification();
        $userNotification = $this->UserNotification->find('first', array(
            'conditions' => array(
                'UserNotification.user_id' => $to_user_id,
            ) ,
            'recursive' => -1
        ));
        if (!empty($userNotification)) {
            return $userNotification['UserNotification'][$field];
        }
        return true;
    }
    public function siteCurrencyFormat($amount)
    {
        if (Configure::read('site.currency_symbol_place') == 'left') {
            return Configure::read('site.currency') . $amount;
        } else {
            return $amount . Configure::read('site.currency');
        }
    }
    public function changeFromEmail($from_address = null)
    {
        if (!empty($from_address)) {
            if (preg_match('|<(.*)>|', $from_address, $matches)) {
                return $matches[1];
            } else {
                return $from_address;
            }
        }
    }
    public function formatToAddress($user = null)
    {
        if (!empty($user['UserProfile']['first_name']) && !empty($user['UserProfile']['last_name'])) {
            return $user['UserProfile']['first_name'] . ' ' . $user['UserProfile']['first_name'] . ' <' . $user['User']['email'] . '>';
        } elseif (!empty($user['UserProfile']['first_name'])) {
            return $user['UserProfile']['first_name'] . ' <' . $user['User']['email'] . '>';
        } else {
            return $user['User']['email'];
        }
    }
	 public function _isValidCaptcha()
    {
        include_once VENDORS . DS . 'securimage' . DS . 'securimage.php';
        $img = new Securimage();
        return $img->check($this->data[$this->name]['captcha']);
    }
    public function _isValidCaptchaSolveMedia()
    {
		include_once VENDORS . DS . 'solvemedialib.php';
		$privkey=Configure::read('captcha.verification_key');
		$hashkey=Configure::read('captcha.hash_key');
		$adcopy_challenge = !empty($_POST["adcopy_challenge"])?$_POST["adcopy_challenge"]:'';
		$adcopy_response = !empty($_POST["adcopy_response"])?$_POST["adcopy_response"]:'';
		$solvemedia_response = solvemedia_check_answer($privkey,
		$_SERVER["REMOTE_ADDR"],
		$adcopy_challenge,
		$adcopy_response,
		$hashkey);
		if (!$solvemedia_response->is_valid) {
			//handle incorrect answer
			return false;
		}
		else {
			return true;
		}
    }
	public function _sendEmail($template, $replace_content, $to, $from = null)
    {
        App::uses('CakeEmail', 'Network/Email');
        $this->Email = new CakeEmail();
        if (isPluginEnabled('HighPerformance') && Configure::read('mail.is_smtp_enabled')) {
            $this->Email->config('smtp');
        }
        $from_email = $template['from'];
        if (!empty($from)) {
            $from_email = $from;
        } elseif ($template['from'] == '##FROM_EMAIL##') {
            $from_email = Configure::read('EmailTemplate.from_email');
        }
        $default_content = array(
            '##SITE_NAME##' => Configure::read('site.name') ,
            '##SITE_URL##' => Router::url('/', true) ,
            '##FROM_EMAIL##' => Configure::read('EmailTemplate.from_email') ,
			'##UNSUBSCRIBE_LINK##' => Router::url(array(
				'controller' => 'user_notifications',
				'action' => 'edit',
				'admin' => false
			), true),
			'##CONTACT_URL##' => Router::url(array(
				'controller' => 'contacts',
				'action' => 'add',
				'admin' => false
			), true),
        );
        $emailFindReplace = array_merge($default_content, $replace_content);
        $content['text'] = strtr($template['email_content'], $emailFindReplace);
        $content['html'] = strtr($template['email_html_content'], $emailFindReplace);
        $subject = strtr($template['subject'], $emailFindReplace);
        $from_email = strtr($from_email, $emailFindReplace);
        $this->Email->from($from_email, Configure::read('site.name'));
        $reply_to_email = (!empty($template['reply_to']) && $template['reply_to'] == '##REPLY_TO_EMAIL##') ? Configure::read('EmailTemplate.reply_to_email') : $template['reply_to'];
        if (!empty($reply_to_email)) {
            $this->Email->replyTo($reply_to_email);
        }
        $this->Email->to($to);
        $this->Email->subject($subject);
        $this->Email->emailFormat('both');
        $this->Email->send($content);
    }
    function _convertAmount($amount)
    {
        $converted = array();
        $_paypal_conversion_currency = Cache::read('site_paypal_conversion_currency');
        $is_supported = Configure::read('paypal.is_supported');
        if (isset($is_supported) && empty($is_supported)) {
            $converted['amount'] = $amount*$_paypal_conversion_currency['CurrencyConversion']['rate'];
            $converted['currency_code'] = Configure::read('paypal.conversion_currency_code');
        } else {
            $converted['amount'] = $amount;
            $converted['currency_code'] = Configure::read('paypal.currency_code');
        }
        return $converted;
    }
    function getImageUrl($model, $attachment, $options, $path = 'absolute')
    {
        $default_options = array(
            'dimension' => 'original',
            'class' => '',
            'alt' => 'alt',
            'title' => 'title',
            'type' => 'jpg'
        );
        $options = array_merge($default_options, $options);
        $image_hash = $options['dimension'] . '/' . $model . '/' . $attachment['id'] . '.' . md5(Configure::read('Security.salt') . $model . $attachment['id'] . $options['type'] . $options['dimension'] . Configure::read('site.name')) . '.' . $options['type'];
        return 'img/' . $image_hash;
    }
}
