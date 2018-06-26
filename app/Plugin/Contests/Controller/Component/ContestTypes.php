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
class ContestTypesComponent extends Component
{
    public $components = array(
        'RequestHandler',
        'Email'
    );
    /**
     * Holds the data required to build the form
     *
     * @var array
     * @access public
     */
    public $formData;
    /**
     * Holds the path to the view variable  in $this->Controller->viewVars
     * which contains the {contest_type_ID} tag
     *
     * $this->viewVar = 'page/Page/content'
     * would be the path for a view variable $page['Page']['content']
     *
     * Overridden with the controller beforeFilter() or Component init
     *
     * @var string
     * @access public
     */
    public $viewVar = null;
    /**
     * Which action/views the component will look for
     * the {contest_type_ID} tag and replace it with the form,
     * where ID is the id of the form to show
     *
     * Overridden with the controller beforeFilter() or Component init
     *
     * @var string
     * @access public
     */
    public $actions = array();
    /**
     * Pointer to view variable which contains content to check for
     * {contest_type_ID} tag
     *
     * @var array
     * @access public
     */
    public $content;
    /**
     * Whether or not the form has been successfuly submitted
     *
     * @var boolean
     * @access public
     */
    public $submitted = false;
    /**
     * Sets Controller values, loads ContestType.Form model
     *
     * @param string $content Content to render
     * @return array Email ready to be sent
     * @access public
     */
    function initialize($controller, $settings = array())
    {
        $this->Controller = $controller;
        $this->Form = ClassRegistry::init('ContestTypes.Form');;
        if (empty($settings)) {
            Configure::load('Contests.contest_types');
            $settings = Configure::read('ContestTypes');
        }
        if (!empty($settings['email'])) {
            foreach($settings['email'] as $key => $setting) {
                $this->Email->{$key} = $setting;
            }
        }
        if (!empty($settings['viewVar'])) {
            $this->viewVar = $settings['viewVar'];
        }
        if (!empty($settings['actions'])) {
            if (is_string($settings['actions'])) {
                $settings['actions'] = array(
                    $settings['actions']
                );
            }
            $this->actions = $settings['actions'];
        }
    }
    /**
     * Loads ContestType helper.
     * Checks for form submission, if so, calls $this->submit() to process it
     * Called after the Controller::beforeFilter() and before the controller action
     *
     * @access public
     * @param object $controller Controller with components to startup
     * @return void
     */
    function startup($controller)
    {
        $this->Controller = $controller;
        $this->Controller->set('contestTypesComponent', 'ContestTypesComponent startup');
        $this->Controller->helpers[] = "ContestTypes.Cakeform";
        if (!empty($this->Controller->data['ContestType']['submitHere']) && $this->Controller->data['ContestType']['id']) {
            $this->submit();
        }
    }
    /**
     * If autoParse is set to true, gets view variable content
     * and replaces it with rendered content
     *
     * @access public
     */
    function beforeRender($controller)
    {
        Configure::write('Admin.menus.contest_types', 1);
        $controller->set('contestTypesHookBeforeRender', 'ContestTypesHook beforeRender');
        $this->Controller = $controller;
        if (!empty($this->viewVar) && in_array($this->Controller->action, $this->actions)) {
            if ($this->getContent()) {
                $this->content = $this->insertForm($this->content);
            }
        }
    }
    /**
     * sets $this->content to the content of the view variable
     *
     * @access public
     */
    function getContent()
    {
        $content_to_replace = '';
        $keys = explode('/', $this->viewVar);
        $this->content = &$this->Controller->viewVars;
        foreach($keys as $key) {
            $this->content = &$this->content[$key];
        }
        if (!empty($this->content) && is_string($this->content)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * parses $this->content and replaces {contest_type_ID} with the form
     *
     * @param string $content The content to parse
     *
     * @access public
     */
    function insertForm($content)
    {
        $newcontent = '';
        $start = strpos($content, '{contest_type_');
        $end = strpos($content, '}', $start);
        $replace = substr($content, $start, $end+1-$start);
        if (strlen($replace) > 16) { //make sure it at least the length of {contest_type_1}
            $length = strlen($replace) -2;
            $formId = substr($replace, 1, $length);
            $formId = explode('_', $formId);
            $formId = $formId[count($formId) -1];
            $formData = $this->loadForm($formId);
            if (!empty($formData)) {
                $newcontent = $this->__renderForm($formData);
            }
            if (!empty($newcontent)) {
                $content = str_replace($replace, $newcontent, $content);
            }
        }
        return $content;
    }
    /**
     * Render the form
     *
     * @param string $formData Data used to build form
     *
     * @return string The rendered form
     * @access private
     */
    function __renderForm($formData)
    {
        $content = '';
        $viewClass = $this->Controller->view;
        if ($viewClass != 'View') {
            if (strpos($viewClass, '.') !== false) {
                list($plugin, $viewClass) = explode('.', $viewClass);
            }
            $viewClass = $viewClass . 'View';
            App::import('View', $this->Controller->view);
        }
        $View = new $viewClass($this->Controller);
        $View->plugin = 'contests';
        $content = $View->element('form', array(
            'formData' => $formData
        ) , true);
        ClassRegistry::removeObject('view');
        return $content;
    }
    /**
     * Loads the data to create the form, calls model to build
     * schema and validation
     *
     * @return array Data used to build form
     * @access public
     */
    function loadForm($id)
    {
        if (empty($this->formData) || $this->formData['ContestType']['id'] != $id) {
            $this->formData = $this->Form->buildSchema($id);
        }
        $this->formData['ContestType']['submitted'] = $this->submitted;
        return $this->formData;
    }
    /**
     * Processes form
     *
     * @return bool true if form is successfuly saved to db
     * @access public
     */
    function submit()
    {
        $id = $this->Controller->data['ContestType']['id'];
        $this->loadForm($id);
        $uploadsProcessed = $this->_processUploads();
        $validate = $this->Controller->data;
        foreach($validate['Form'] as &$field) {
            if (is_array($field)) {
                $field = implode("\n", $field);
            }
        }
        $this->Form->set($validate);
        if ($uploadsProcessed && $this->Form->validates()) {
            $this->submitted = true;
            $this->formData['ContestType']['submitted'] = true;
            if (!empty($this->formData['ContestType']['next'])) {
                $this->Session->write('ContestType.form.' . $id, $this->Controller->data['ContestType']);
            } else {
                if (!empty($this->Controller->data['Form']['email'])) {
                    $this->Controller->data['Submission']['email'] = $this->Controller->data['Form']['email'];
                }
                $this->Controller->data['Submission']['contest_type_id'] = $id;
                App::import('Model', 'ContestTypes.Submission');
                $this->Submission = new Submission;
                $this->Submission->ContestType->id = $id;
                $formName = $this->Submission->ContestType->field('name');
                $this->Controller->data['Submission']['name'] = $formName;
                $this->Controller->data['Submission']['ip'] = ip2long($this->RequestHandler->getClientIP());
                $this->Controller->data['Submission']['page'] = $this->Controller->here;
                $controllerMethods = get_class_methods($this->Controller);
                $saveToDb = true;
                if (in_array('beforeContestTypesSave', $controllerMethods)) {
                    $saveToDb = $this->Controller->beforeContestTypesSave($this->Controller->data);
                }
                if ($saveToDb && $this->Submission->submit($this->Controller->data)) {
                    $this->Controller->data['ContestType'] = $this->formData['ContestType'];
                    $this->Controller->Session->setFlash("Thank you! Your form has been submitted.");
                    if (in_array('afterContestTypesSave', $controllerMethods)) {
                        $this->Controller->afterContestTypesSave($this->Controller->data);
                    } else {
                        $this->send($this->Controller->data);
                    }
                    if (!empty($this->formData['ContestType']['redirect'])) {
                        $this->Controller->redirect($this->formData['ContestType']['redirect']);
                    }
                    unset($this->Controller->data);
                    return true;
                } else {
                    $this->Controller->Session->setFlash("There was a problem saving your submission. Please check for errors and try again.");
                    return false;
                }
            }
        } else {
            $this->Controller->Session->setFlash("There was a problem saving your submission. Please check this form for errors or omissions and try again.");
        }
    }
    /**
     * Emails form
     *
     * @todo allow configuration
     *
     * @return bool true if form is successfuly sent
     * @access public
     */
    function send($response)
    {
        if (!empty($response['ContestType']['recipient'])) {
            $this->Email->to = $response['ContestType']['recipient'];
        }
        if (empty($this->Email->from)) {
            $this->Email->from = $this->Email->to;
        }
        $this->Email->subject = "New '{$response['ContestType']['name']}' Submission";
        $this->Email->sendAs = 'both';
        $plugin = $this->Controller->plugin;
        $this->Controller->plugin = 'contests';
        $this->Email->template = 'submission';
        $this->Controller->set('response', $response);
        $success = $this->Email->send();
        $this->Controller->plugin = $plugin;
        return $success;
    }
    /**
     * Processes any uploaded files
     *
     *
     *
     */
    private function _processUploads()
    {
        $files = array();
        foreach($this->Controller->data['Form'] as $key => &$formField) {
            if (is_array($formField) && array_key_exists('tmp_name', $formField) && array_key_exists('name', $formField)) {
                if (empty($formField['tmp_name'])) {
                    $this->Controller->data['Form'][$key] = null;
                } else {
                    $i = null;
                    $duplicate = true;
                    while ($duplicate == true) {
                        $full_path = WWW_ROOT . DS . '..' . DS . $this->settings['uploadPath'] . $i . $formField['name'];
                        $short_path = APP . DS . $this->settings['uploadPath'] . $i . $formField['name'];
                        if (!file_exists($full_path)) {
                            $duplicate = false;
                            if (is_uploaded_file($formField['tmp_name']) && move_uploaded_file($formField['tmp_name'], $full_path)) {
                                $formField = "http://" . $_SERVER['SERVER_NAME'] . Router::url(array(
                                    'controller' => 'submissions',
                                    'action' => 'view_upload',
                                    base64_encode($full_path)
                                ));
                                $files[] = $full_path;
                            } else {
                                foreach($files as $file) {
                                    unlink($file);
                                }
                                return false;
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        return true;
    }
    /**
     * Called after Controller::render() and before the output is printed to the browser.
     *
     * @param object $controller Controller with components to shutdown
     * @return void
     */
    public function shutdown(&$controller)
    {
    }
}
?>