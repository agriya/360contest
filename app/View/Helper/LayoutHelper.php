<?php
/**
 *
 * @package		360Contest
 * @author 		siva_063at09
 * @copyright 	Copyright (c) 2012 {@link http://www.agriya.com/ Agriya Infoway}
 * @license		http://www.agriya.com/ Agriya Infoway Licence
 * @since 		2012-03-07
 *
 */
class LayoutHelper extends AppHelper
{
    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
	 public $helpers = array(
        'Html',
        'Form',
        'Session',
        'Js',
    );
    /**
     * Current Node
     *
     * @var array
     * @access public
     */
    public $node = null;
    /**
     * Core helpers
     *
     * Extra supported callbacks, like beforeNodeInfo() and afterNodeInfo(),
     * won't be called for these helpers.
     *
     * @var array
     * @access public
     */
    public $coreHelpers = array(
        // CakePHP
        'Form',
        'Html',
        'Javascript',
        'Session',
        'Text',
        'Time',
        'Js',
        'Auth',
        // Cms
        'Filemanager',
        'Image',
        'Layout',
    );
    /**
     * Javascript variables
     *
     * Shows cms.js file along with useful information like the applications's basePath, etc.
     *
     * Also merges Configure::read('Js') with the Cms js variable.
     * So you can set javascript info anywhere like Configure::write('Js.my_var', 'my value'),
     * and you can access it like 'Cms.my_var' in your javascript.
     *
     * @return string
     */
    public function js()
    {
        $cms = array();
        if (isset($this->request->params['locale'])) {
            $cms['basePath'] = Router::url('/' . $this->request->params['locale'] . '/');
        } else {
            $cms['basePath'] = Router::url('/');
        }
		if(!empty($this->request->params)){
        $cms['params'] = array(
            'controller' => $this->request->params['controller'],
            'action' => $this->request->params['action'],
            'named' => $this->request->params['named'],
        );
		}
        if (is_array(Configure::read('Js'))) {
            $cms = Set::merge($cms, Configure::read('Js'));
        }
        $cms['cfg'] = array(
            'path_relative' => Router::url('/') ,
            'path_absolute' => Router::url('/', true) ,
            'site_name' => Configure::read('site.name') ,
            'timezone' => date('Z') /(60*60) ,
            'date_format' => 'M d, Y',
            'today_date' => date('Y-m-d')
        );
        return $this->Html->scriptBlock('var cfg = ' . $this->Js->object($cms) . ';');
    }
    /**
     * Status
     *
     * instead of 0/1, show tick/cross
     *
     * @param integer $value 0 or 1
     * @return string formatted img tag
     */
    public function status($value)
    {
        if ($value == 1) {
            $output = '<i class="icon-ok text-16 top-space blackc"></i>';
        } else {
            $output = '<i class="icon-remove text-16 top-space blackc"></i>';
        }
        return $output;
    }
    /**
     * Show flash message
     *
     * @return string
     */
    public function sessionFlash()
    {
        $messages = $this->Session->read('Message');
        $output = '';
         if (is_array($messages)&& !empty($messages)) {
            $output = '<div class="flash-message-block hor-space top-space mspace pr">';
            foreach(array_keys($messages) AS $key) {
                $output.= $this->Session->flash($key);
            }
            $output.= '</div>';
        }
        return $output;
    }
    /**
     * Meta tags
     *
     * @return string
     */
    public function meta($metaForLayout = array())
    {
        $_metaForLayout = array();
        if (is_array(Configure::read('meta'))) {
            $_metaForLayout = Configure::read('meta');
        }
        if (count($metaForLayout) == 0 && isset($this->_View->viewVars['node']['CustomFields']) && count($this->_View->viewVars['node']['CustomFields']) > 0) {
            $metaForLayout = array();
            foreach($this->_View->viewVars['node']['CustomFields'] AS $key => $value) {
                if (strstr($key, 'meta_')) {
                    $key = str_replace('meta_', '', $key);
                    $metaForLayout[$key] = $value;
                }
            }
        }
        $metaForLayout = array_merge($_metaForLayout, $metaForLayout);
        $output = '';
        foreach($metaForLayout AS $name => $content) {
            $output.= '<meta name="' . $name . '" content="' . $content . '" />';
        }
        return $output;
    }
    /**
     * isLoggedIn
     *
     * if User is logged in
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        if ($this->Session->check('Auth.User.id')) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * Feed
     *
     * RSS feeds
     *
     * @param boolean $returnUrl if true, only the URL will be returned
     * @return string
     */
    public function feed($returnUrl = false)
    {
        if (Configure::read('Site.feed_url')) {
            $url = Configure::read('Site.feed_url');
        } else {
            /*$url = Router::url(array(
            'controller' => 'nodes',
            'action' => 'index',
            'type' => 'blog',
            'ext' => 'rss',
            ));*/
            $url = '/nodes/promoted.rss';
        }
        if ($returnUrl) {
            $output = $url;
        } else {
            $url = Router::url($url);
            $output = '<link href="' . $url . '" type="application/rss+xml" rel="alternate" title="RSS 2.0" />';
            return $output;
        }
        return $output;
    }
    /**
     * Get Role ID
     *
     * @return integer
     */
    public function getRoleId()
    {
        if ($this->isLoggedIn()) {
            $roleId = $this->Session->read('Auth.User.role_id');
        } else {
            // Public
            $roleId = 3;
        }
        return $roleId;
    }
    /**
     * Region is empty
     *
     * returns true if Region has no Blocks.
     *
     * @param string $regionAlias Region alias
     * @return boolean
     */
    public function regionIsEmpty($regionAlias)
    {
        if (isset($this->_View->viewVars['blocks_for_layout'][$regionAlias]) && count($this->_View->viewVars['blocks_for_layout'][$regionAlias]) > 0) {
            return false;
        } else {
            return true;
        }
    }
    /**
     * Show Blocks for a particular Region
     *
     * @param string $regionAlias Region alias
     * @param array $options
     * @return string
     */
    public function blocks($regionAlias, $options = array())
    {
        $output = '';
        if (!$this->regionIsEmpty($regionAlias)) {
            $blocks = $this->_View->viewVars['blocks_for_layout'][$regionAlias];
            foreach($blocks AS $block) {
                $plugin = false;
                if ($block['Block']['element'] != null) {
                    if (strstr($block['Block']['element'], '.')) {
                        $plugin_element = explode('.', $block['Block']['element']);
                        $plugin = $plugin_element[0];
                        $element = $plugin_element[1];
                    } else {
                        $element = $block['Block']['element'];
                    }
                } else {
                    $element = 'block';
                }
                $_options = array(
                    'block' => $block
                );
                $options = array_merge($_options, $options);
                if ($plugin) {
                    $blockOutput = $this->_View->element($element, $options, array(
                        'plugin' => $plugin
                    ));
                } else {
                    $blockOutput = $this->_View->element($element, $options);
                }
                $enclosure = isset($block['Params']['enclosure']) ? $block['Params']['enclosure'] === "true" : true;
                if ($element != 'block' && $enclosure) {
                    $block['Block']['body'] = $blockOutput;
                    $block['Block']['element'] = null;
                    $output.= $this->_View->element('block', array(
                        'block' => $block
                    ));
                } else {
                    $output.= $blockOutput;
                }
            }
        }
        return $output;
    }
    /**
     * Show Menu by Alias
     *
     * @param string $menuAlias Menu alias
     * @param array $options (optional)
     * @return string
     */
    public function menu($menuAlias, $options = array())
    {
        $_options = array(
            'tag' => 'ul',
            'tagAttributes' => array(
                'class' => 'unstyled clearfix'
            ) ,
            'selected' => 'selected',
            'dropdown' => false,
            'dropdownClass' => 'sf-menu',
            'element' => 'menu',
        );
        $options = array_merge($_options, $options);
        if (!isset($this->_View->viewVars['menus_for_layout'][$menuAlias])) {
            return false;
        }
        $menu = $this->_View->viewVars['menus_for_layout'][$menuAlias];
        $output = $this->_View->element($options['element'], array(
            'menu' => $menu,
            'options' => $options,
        ));
        return $output;
    }
    /**
     * Nested Links
     *
     * @param array $links model output (threaded)
     * @param array $options (optional)
     * @param integer $depth depth level
     * @return string
     */
    public function nestedLinks($links, $options = array() , $depth = 1)
    {
        $_options = array();
        $options = array_merge($_options, $options);
        $output = '';
        foreach($links AS $link) {
            $linkAttr = array(
                'id' => 'link-' . $link['Link']['id'],
                'rel' => $link['Link']['rel'],
                'target' => $link['Link']['target'],
                'title' => $link['Link']['title'],
                'class' => 'link-style '.$link['Link']['class'],
            );
            foreach($linkAttr AS $attrKey => $attrValue) {
                if ($attrValue == null) {
                    unset($linkAttr[$attrKey]);
                }
            }
            // if link is in the format: controller:contacts/action:view
            if (strstr($link['Link']['link'], 'controller:')) {
                $link['Link']['link'] = $this->linkStringToArray($link['Link']['link']);
            }
            if (is_array($link['Link']['link']) && !in_array('admin', array_keys($link['Link']['link']))) {
                $link['Link']['link'] = array_merge($link['Link']['link'], array(
                    'admin' => false
                ));
            }
            // Remove locale part before comparing links
            if (!empty($this->request->params['locale'])) {
                $currentUrl = substr($this->_View->request->url, strlen($this->request->params['locale']));
            } else {
                $currentUrl = $this->_View->request->url;
            }
            if (Router::url($link['Link']['link']) == Router::url('/' . $currentUrl)) {
                if (!isset($linkAttr['class'])) {
                    $linkAttr['class'] = '';
                }
                $linkAttr['class'].= ' ' . $options['selected'];
            }
            $linkOutput = $this->Html->link($link['Link']['title'], $link['Link']['link'], $linkAttr);
            if (isset($link['children']) && count($link['children']) > 0) {
                $linkOutput.= $this->nestedLinks($link['children'], $options, $depth+1);
            }
			$liAttr['class']='pull-left hor-space';
            $linkOutput = $this->Html->tag('li', $linkOutput,$liAttr);
            $output.= $linkOutput;
        }
        if ($output != null) {
            $tagAttr = $options['tagAttributes'];
            if ($options['dropdown'] && $depth == 1) {
                $tagAttr['class'] = $options['dropdownClass'];
            }
            $output = $this->Html->tag($options['tag'], $output, $tagAttr);
        }
        return $output;
    }
    /**
     * Converts strings like controller:abc/action:xyz/ to arrays
     *
     * @param string $link link
     * @return array
     */
    public function linkStringToArray($link)
    {
        $link = explode('/', $link);
        $linkArr = array();
        foreach($link AS $linkElement) {
            if ($linkElement != null) {
                $linkElementE = explode(':', $linkElement);
                if (isset($linkElementE['1'])) {
                    $linkArr[$linkElementE['0']] = $linkElementE['1'];
                } else {
                    $linkArr[] = $linkElement;
                }
            }
        }
        if (!isset($linkArr['plugin'])) {
            $linkArr['plugin'] = false;
        }
        return $linkArr;
    }
    /**
     * Show Vocabulary by Alias
     *
     * @param string $vocabularyAlias Vocabulary alias
     * @param array $options (optional)
     * @return string
     */
    public function vocabulary($vocabularyAlias, $options = array())
    {
        $_options = array(
            'tag' => 'ul',
            'tagAttributes' => array() ,
            'type' => null,
            'link' => true,
            'controller' => 'nodes',
            'action' => 'term',
            'element' => 'vocabulary',
        );
        $options = array_merge($_options, $options);
        $output = '';
        if (isset($this->_View->viewVars['vocabularies_for_layout'][$vocabularyAlias]['threaded'])) {
            $vocabulary = $this->_View->viewVars['vocabularies_for_layout'][$vocabularyAlias];
            $output.= $this->_View->element($options['element'], array(
                'vocabulary' => $vocabulary,
                'options' => $options,
            ));
        }
        return $output;
    }
    /**
     * Nested Terms
     *
     * @param array   $terms
     * @param array   $options
     * @param integer $depth
     */
    public function nestedTerms($terms, $options, $depth = 1)
    {
        $_options = array();
        $options = array_merge($_options, $options);
        $output = '';
        foreach($terms AS $term) {
            if ($options['link']) {
                $termAttr = array(
                    'id' => 'term-' . $term['Term']['id'],
                );
                $termOutput = $this->Html->link($term['Term']['title'], array(
                    'controller' => $options['controller'],
                    'action' => $options['action'],
                    'type' => $options['type'],
                    'slug' => $term['Term']['slug'],
                ) , $termAttr);
            } else {
                $termOutput = $term['Term']['title'];
            }
            if (isset($term['children']) && count($term['children']) > 0) {
                $termOutput.= $this->nestedTerms($term['children'], $options, $depth+1);
            }
            $termOutput = $this->Html->tag('li', $termOutput);
            $output.= $termOutput;
        }
        if ($output != null) {
            $output = $this->Html->tag($options['tag'], $output, $options['tagAttributes']);
        }
        return $output;
    }
    /**
     * Show nodes list
     *
     * @param string $alias Node query alias
     * @param array $options (optional)
     * @return string
     */
    public function nodeList($alias, $options = array())
    {
        $_options = array(
            'link' => true,
            'controller' => 'nodes',
            'action' => 'view',
            'element' => 'node_list',
        );
        $options = array_merge($_options, $options);
        $output = '';
        if (isset($this->_View->viewVars['nodes_for_layout'][$alias])) {
            $nodes = $this->_View->viewVars['nodes_for_layout'][$alias];
            $output = $this->_View->element($options['element'], array(
                'alias' => $alias,
                'nodesList' => $this->_View->viewVars['nodes_for_layout'][$alias],
                'options' => $options,
            ));
        }
        return $output;
    }
    /**
     * Filter content
     *
     * Replaces bbcode-like element tags
     *
     * @param string $content content
     * @return string
     */
    public function filter($content)
    {
        $content = $this->filterElements($content);
        $content = $this->filterMenus($content);
        $content = $this->filterVocabularies($content);
        $content = $this->filterNodes($content);
        return $content;
    }
    /**
     * Filter content for elements
     *
     * Original post by Stefan Zollinger: http://bakery.cakephp.org/articles/view/element-helper
     * [element:element_name] or [e:element_name]
     *
     * @param string $content
     * @return string
     */
    public function filterElements($content)
    {
        preg_match_all('/\[(element|e):([A-Za-z0-9_\-\/]*)(.*?)\]/i', $content, $tagMatches);
        $validOptions = array(
            'plugin',
            'cache',
            'callbacks'
        );
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))*.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $element = $tagMatches[2][$i];
            $data = $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                if (in_array($attributes[1][$j], $validOptions)) {
                    $options = Set::merge($options, array(
                        $attributes[1][$j] => $attributes[2][$j]
                    ));
                } else {
                    $data[$attributes[1][$j]] = $attributes[2][$j];
                }
            }
            if (!empty($this->_View->viewVars['block'])) {
                $data['block'] = $this->_View->viewVars['block'];
            }
            $content = str_replace($tagMatches[0][$i], $this->_View->element($element, $data, $options) , $content);
        }
        return $content;
    }
    /**
     * Filter content for Menus
     *
     * Replaces [menu:menu_alias] or [m:menu_alias] with Menu list
     *
     * @param string $content
     * @return string
     */
    public function filterMenus($content)
    {
        preg_match_all('/\[(menu|m):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $menuAlias = $tagMatches[2][$i];
            $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                $options[$attributes[1][$j]] = $attributes[2][$j];
            }
            $content = str_replace($tagMatches[0][$i], $this->menu($menuAlias, $options) , $content);
        }
        return $content;
    }
    /**
     * Filter content for Vocabularies
     *
     * Replaces [vocabulary:vocabulary_alias] or [v:vocabulary_alias] with Terms list
     *
     * @param string $content
     * @return string
     */
    public function filterVocabularies($content)
    {
        preg_match_all('/\[(vocabulary|v):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $vocabularyAlias = $tagMatches[2][$i];
            $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                $options[$attributes[1][$j]] = $attributes[2][$j];
            }
            $content = str_replace($tagMatches[0][$i], $this->vocabulary($vocabularyAlias, $options) , $content);
        }
        return $content;
    }
    /**
     * Filter content for Nodes
     *
     * Replaces [node:unique_name_for_query] or [n:unique_name_for_query] with Nodes list
     *
     * @param string $content
     * @return string
     */
    public function filterNodes($content)
    {
        preg_match_all('/\[(node|n):([A-Za-z0-9_\-]*)(.*?)\]/i', $content, $tagMatches);
        for ($i = 0; $i < count($tagMatches[1]); $i++) {
            $regex = '/(\S+)=[\'"]?((?:.(?![\'"]?\s+(?:\S+)=|[>\'"]))+.)[\'"]?/i';
            preg_match_all($regex, $tagMatches[3][$i], $attributes);
            $alias = $tagMatches[2][$i];
            $options = array();
            for ($j = 0; $j < count($attributes[0]); $j++) {
                $options[$attributes[1][$j]] = $attributes[2][$j];
            }
            $content = str_replace($tagMatches[0][$i], $this->nodeList($alias, $options) , $content);
        }
        return $content;
    }
    /**
     * Meta field: with key/value fields
     *
     * @param string $key (optional) key
     * @param string $value (optional) value
     * @param integer $id (optional) ID of Meta
     * @param array $options (optional) options
     * @return string
     */
    public function metaField($key = '', $value = null, $id = null, $options = array())
    {
        $_options = array(
            'key' => array(
                'label' => __l('Key') ,
                'value' => $key,
            ) ,
            'value' => array(
                'label' => __l('Value') ,
                'value' => $value,
            ) ,
        );
        $options = Set::merge($_options, $options);
        $uuid = String::uuid();
        $fields = '';
        if ($id != null) {
            $fields.= $this->Form->input('Meta.' . $uuid . '.id', array(
                'type' => 'hidden',
                'value' => $id
            ));
        }
        $fields.= $this->Form->input('Meta.' . $uuid . '.key', $options['key']);
        $fields.= $this->Form->input('Meta.' . $uuid . '.value', $options['value']);
        $fields = $this->Html->tag('div', $fields, array(
            'class' => 'fields'
        ));
        $actions = $this->Html->link(__l('Remove') , is_null($id) ? '#' : array(
            'plugin' => null,
            'controller' => 'nodes',
            'action' => 'delete_meta',
            $id
        ) , array(
            'class' => 'remove-meta remove grid_right',
            'rel' => $id
        ));
        $actions = $this->Html->tag('div', $actions, array(
            'class' => 'actions'
        ));
        $output = $this->Html->tag('div', $actions . $fields, array(
            'class' => 'meta'
        ));
        return $output;
    }
    /**
     * Show links under Actions column
     *
     * @param integer $id
     * @param array $options
     * @return string
     */
    public function adminRowActions($id, $options = array())
    {
        $_options = array();
        $options = array_merge($_options, $options);
        $output = '';
        $rowActions = Configure::read('Admin.rowActions.' . Inflector::camelize($this->request->params['controller']) . '/' . $this->request->params['action']);
        if (is_array($rowActions)) {
            foreach($rowActions AS $title => $rowAction) {
                if ($output != '') {
                    $output.= ' ';
                }
				$rowAction['options']['escape']=false;
                $link = $this->linkStringToArray(str_replace(':id', $id, $rowAction['url']));
                $output.= $this->Html->tag('li', $this->Html->link('<i class="icon-link blackc"></i>'.$title, $link, $rowAction['options']));
            }
        }
        return $output;
    }
    /**
     * Show tabs
     *
     * @return string
     */
    public function adminTabs($show = null)
    {
        if (!isset($this->adminTabs)) {
            $this->adminTabs = false;
        }
        $output = '';
        $tabs = Configure::read('Admin.tabs.' . Inflector::camelize($this->request->params['controller']) . '/' . $this->request->params['action']);
        if (is_array($tabs)) {
            foreach($tabs AS $title => $tab) {
                if (!isset($tab['options']['type']) || (isset($tab['options']['type']) && (in_array($this->_View->viewVars['typeAlias'], $tab['options']['type'])))) {
                    $domId = strtolower(Inflector::singularize($this->request->params['controller'])) . '-' . strtolower($title);
                    if ($this->adminTabs) {
                        if (strstr($tab['element'], '.')) {
                            $elementE = explode('.', $tab['element']);
                            $plugin = $elementE['0'];
                            $element = $elementE['1'];
                        } else {
                            $plugin = null;
                        }
                        $output.= '<div id="' . $domId . '">';
                        $output.= $this->_View->element($element, array() , array(
                            'plugin' => $plugin,
                        ));
                        $output.= '</div>';
                    } else {
                        $output.= '<li><a href="#' . $domId . '">' . $title . '</a></li>';
                    }
                }
            }
        }
        $this->adminTabs = true;
        return $output;
    }
    /**
     * Set current Node
     *
     * @param array $node
     * @return void
     */
    public function setNode($node)
    {
        $this->node = $node;
        $this->hook('afterSetNode');
    }
    /**
     * Set value of a field
     *
     * @param string $field
     * @param string $value
     * @return void
     */
    public function setNodeField($field, $value)
    {
        $model = 'Node';
        if (strstr($field, '.')) {
            $fieldE = explode('.', $field);
            $model = $fieldE['0'];
            $field = $fieldE['1'];
        }
        $this->node[$model][$field] = $value;
    }
    /**
     * Get value of a Node field
     *
     * @param string $field
     * @return string
     */
    public function node($field = 'id')
    {
        $model = 'Node';
        if (strstr($field, '.')) {
            $fieldE = explode('.', $field);
            $model = $fieldE['0'];
            $field = $fieldE['1'];
        }
        if (isset($this->node[$model][$field])) {
            return $this->node[$model][$field];
        } else {
            return false;
        }
    }
    /**
     * Node info
     *
     * @param array $options
     * @return string
     */
    public function nodeInfo($options = array())
    {
        $_options = array(
            'element' => 'node_info',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeInfo');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeInfo');
        return $output;
    }
    /**
     * Node excerpt (summary)
     *
     * @param array $options
     * @return string
     */
    public function nodeExcerpt($options = array())
    {
        $_options = array(
            'element' => 'node_excerpt',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeExcerpt');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeExcerpt');
        return $output;
    }
    /**
     * Node body
     *
     * @param array $options
     * @return string
     */
    public function nodeBody($options = array())
    {
        $_options = array(
            'element' => 'node_body',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeBody');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeBody');
        return $output;
    }
    /**
     * Node more info
     *
     * @param array $options
     * @return string
     */
    public function nodeMoreInfo($options = array())
    {
        $_options = array(
            'element' => 'node_more_info',
        );
        $options = array_merge($_options, $options);
        $output = $this->hook('beforeNodeMoreInfo');
        $output.= $this->_View->element($options['element']);
        $output.= $this->hook('afterNodeMoreInfo');
        return $output;
    }
    /**
     * Hook
     *
     * Used for calling hook methods from other HookHelpers
     *
     * @param string $methodName
     * @return string
     */
    public function hook($methodName)
    {
        $output = '';
        foreach($this->_View->helpers AS $helper => $settings) {
            if (!is_string($helper) || in_array($helper, $this->coreHelpers)) {
                continue;
            }
            if (strstr($helper, '.')) {
                $helperE = explode('.', $helper);
                $helper = $helperE['1'];
            }
            if (isset($this->_View->{$helper}) && method_exists($this->_View->{$helper}, $methodName)) {
                $output.= $this->_View->{$helper}->$methodName();
            }
        }
        return $output;
    }
    /** Generate Admin menus added by CmsNav::add()
     *
     * @param array $menus
     * @param array $options
     * @return string menu html tags
     */
    function adminMenus($menus, $options = array())
    {
        $options = Set::merge(array(
            'children' => true,
            'htmlAttributes' => array(
                'class' => 'sf-menu',
            ) ,
        ) , $options);
        $out = null;
        $sorted = Set::sort($menus, '{[a-zA-Z _-]+}.weight', 'ASC');
		$out = '<div class="navbar no-mar">';
		$out .= '<div class="navbar-inner sep-nav-top hor-space no-round clearfix">';
		$out .= '<a class="btn btn-navbar bot-mspace" data-toggle="collapse" data-target=".nav-collapse"> <i class="icon-align-justify icon-24 blackc"></i></a>';
		$out .= '<div class="nav-collapse">';
        $out .= '<ul class="nav mob-c admin-menu row "><li>' . $this->Html->image('logo.png',  array('class' => "top-mspace space")) . '</li>';
        $icon_class = '';
        $intHeader = 0;
        $intSubMenu = 1;
        foreach($sorted as $menu) {
            if ($menu['icon-class'] == 'admin-masters') {
                $menu['children'] = Set::sort($menu['children'], '{[a-zA-Z _-]+}.weight', 'ASC');
                foreach($menu['children'] as $childmenu) {
                    if (empty($childmenu['url'])) {
                        $intHeader++;
                    }
                    $arrFlag[$intHeader] = $intSubMenu;
                    $intSubMenu++;
                }
            }
        }
        $intHalfCount = ceil($intSubMenu/2);
        $intColumn = 9;
		if (!empty($arrFlag)) {
			foreach($arrFlag as $intValue) {
				if ($intValue < $intHalfCount) {
					continue;
				} else {
					$intColumn = $intValue-1;
					break;
				}
			}
		}
        foreach($sorted as $menu) {
			if ($menu['icon-class'] == 'admin-masters') {
                $menu['column_1'] = $intColumn;
            }
            $controller_arr = array();
            $action_arr = array();
			if(is_array($menu['url'])) {
				$controller_arr[] = $menu['url']['controller'];
				$action_arr[] = $menu['url']['action'];
			}
			if (!empty($menu['children'])) {
				$menu['children'] = Set::sort($menu['children'], '{[a-zA-Z _-]+}.weight', 'ASC');
                foreach($menu['children'] as $child) {
                    if (!empty($child['url']['controller'])) {
                        $controller_arr[] = $child['url']['controller'];
                    }
                    if (!empty($child['url']['action'])) {
                        $action_arr[] = $child['url']['action'];
                    }
                }
            }
			$controller_arr = array_unique($controller_arr);
            if (!empty($menu['allowedControllers'])) {
                $controller_arr = array_merge($controller_arr, $menu['allowedControllers']);
            }
            $action_arr = array_unique($action_arr);
            if (empty($menu['htmlAttributes']['class'])) {
                $menuClass = Inflector::slug(strtolower('menu-' . $menu['title']) , '-');
                $menu['htmlAttributes'] = Set::merge(array(
                    'class' => $menuClass
                ) , $menu['htmlAttributes']);
            }
            $link = $this->Html->link($menu['title'], $menu['url'], $menu['htmlAttributes']);
            $active_class = '';
            if (empty($menu['allowedActions'])) {
                $menu['allowedActions'] = array(
                    $this->request->params['action']
                );
            }
            if (empty($menu['notAllowedActions'])) {
                $menu['notAllowedActions'] = array();
            }
			if(empty($menu['notallowedParams']))
			{
			$menu['notallowedParams'] = '';
			}
			if($controller_arr[0] == 'users' && $action_arr[0] == 'stats'){
				$icon="icon-home";
			}else if($controller_arr[0] == 'users' && $action_arr[0] == 'index'){
				$icon="icon-user";
			}else if($controller_arr[0] == 'contests'){
				$icon="icon-trophy";
			}else if($controller_arr[0] == 'activities'){
				$icon="icon-time";
			}else if($controller_arr[0] == 'nodes' || $controller_arr[0] == 'resources'){
				$icon="icon-sitemap";
			}else if($controller_arr[0] == 'settings'){
				$icon="icon-cog";
			}else if($controller_arr[0] == 'transactions'){
				$icon="icon-money";
			}else {
				if(isset($menu['children']['plugins'])){
					$icon="icon-link";
				}else {
					$icon="icon-reorder";
				}
			}
			if($menu['icon-class']=='icon-time'){
				$icon="icon-time";
			}

			if (in_array($this->request->params['controller'] == 'messages' && $menu['icon-class'], array('admin-users', 'admin-contest')) && !empty($this->request->params)) {
				if($menu['icon-class'] == 'admin-users' && empty($this->request->params['pass']['0']) && ($this->request->params['controller'] != 'messages')) {
					$active_class = 'pinkc';
				}if($menu['icon-class'] == 'admin-contest' && !empty($this->request->params['pass']['0'])) {
					$active_class = 'pinkc';
				}	if($menu['icon-class'] == 'icon-time')  {
					$active_class = 'pinkc';
				}
				if($this->request->params['controller'] == 'messages'){
					Configure::write('admin_icon_class', 'icon-time');
				}
			}else if (in_array($menu['icon-class'], array('admin-masters')) && ($this->request->params['controller'] == 'contest_types' && !empty($this->request->params['named']['type']) || $this->request->params['controller'] == 'resources')) {
						$active_class = 'pinkc';
			}else if (in_array($menu['icon-class'], array('admin-masters')) && $this->request->params['controller'] == 'contest_types') {
						$active_class = '';
			}
			else if (!empty($menu['allowedActions']) || !empty($menu['notAllowedActions'])) {
				$active_class = (in_array($this->request->params['controller'], $controller_arr) && in_array($this->request->params['action'], $menu['allowedActions']) && !in_array($this->request->params['action'], $menu['notAllowedActions']) && (!array_key_exists($menu['notallowedParams'],$this->request->params['named'])) ) ? 'pinkc' : null;
                if (empty($icon_class) && !empty($active_class)) {
                    $icon_class = (in_array($this->request->params['controller'], $controller_arr) && in_array($this->request->params['action'], $menu['allowedActions']) && !in_array($this->request->params['action'], $menu['notAllowedActions'])) ? $menu['title'] : null;
                    Configure::write('admin_icon_class', $icon);
                }
				else{
					if($this->request->params['controller'] == 'contest_types'){
						Configure::write('admin_icon_class', 'icon-reorder');
					}
				}
            } else {
                $active_class = (in_array($this->request->params['controller'], $controller_arr)) ? ' pinkc' : '';
                if (empty($icon_class) && !empty($active_class)) {
                    $icon_class = (in_array($this->request->params['controller'], $controller_arr)) ? $menu['title'] : null;
                    Configure::write('admin_icon_class', $icon);
                }
            }
			if(!isset($active_class) || $active_class==null){
				$active_class="";
			}
			if ($menu['icon-class'] == 'dashboard') {
				$out.= '<li class="no-mar dc sep-right sep-left dropdown">';
			} else{
				$out.= '<li class="no-mar dc sep-right dropdown">';
			}
			if($menu['icon-class'] == 'icon-time' && ($icon_class == 'Dashboard' || $icon_class == 'Users')) {
				$active_class="";
			}
			if($this->request->params['controller'] == 'resources') {
				if($menu['icon-class'] == 'admin-masters') {
					$active_class ="";
				} else if($menu['icon-class'] == 'admin-cms') {
					$active_class ="pinkc";
				}
			}
			if($this->request->params['controller'] == 'messages' && $menu['icon-class'] == 'admin-contest') {
				$active_class="";
			}
			if($menu['icon-class'] == "admin-payment"  && $this->request->params['controller'] == 'settings') {
				$active_class="";
			}
			$tour_main_class = $tour_class = '';
            if (($this->request->params['controller'] == 'users') && ($this->request->params['action'] == 'admin_stats')) {
                $tour_main_class = " bootstro";
                $data_bootstro_step = empty($menu['data-bootstro-step']) ? '' : $menu['data-bootstro-step'];
                $data_bootstro_content = empty($menu['data-bootstro-content']) ? '' : $menu['data-bootstro-content'];
                $data_bootstro_title = empty($menu['title']) ? '' : $menu['title'];
                $tour_class = 'data-bootstro-step=' . $data_bootstro_step . ' data-bootstro-content="' . $data_bootstro_content . '" data-bootstro-title="' . $data_bootstro_title . '" data-bootstro-placement="bottom"';
            }
			$out.= '<a class="show dropdown-toggle js-no-pjax ' . $tour_main_class . '"  data-toggle="dropdown" href="#" ' . $tour_class . ' >';
			if($controller_arr[0] != 'transactions'){
				$out.= '<span class="show space">';
            	$out.= '<i class=" text-20 no-mar no-pad over-hide ' . $icon . ' ' . $active_class . '"></i>';
			}else{
				$out.= '<span class="show space">';
				$out.= '<i class=" text-20 no-mar no-pad over-hide icon-money '. $active_class . '"></i>';
			}
			$out.= '</span>';
			if($menu['title'] == "Users" || $menu['title']=="Plugins" || $menu['title']=="Settings" || $menu['title']=="Masters" ){
				$out.= '<span class="show hor-space hor-smpace ' . $active_class . '">' . $menu['title'];
			} else {
				$out.= '<span class="show ' . $active_class . '">' . $menu['title'];
			}
            $out.= '</span>';
            $out.= '</a>';
            if (empty($menu['column'])) {
                // to do instant fix
                if ($menu['icon-class'] == 'admin-cms') {
                    $out.= '<ul class=" dropdown-menu hor-space pull-right dl">';
                } else {
                    $out.= '<ul class="dropdown-menu dl">';
                }
            } else {
                $out.= '<ul class=" dropdown-menu pull-right dl">';
            }
            if ($menu['icon-class'] == 'admin-setting') {
                $out.= '<div>';
                $out.= $this->Html->link('<span class="pull-right space"><i class="icon-cog"></i>' . __l('Settings Overview') . '</span>' , array(
                    'controller' => 'settings',
                    'action' => 'index'
                ),array('title'=>__l('Settings Overview'), 'escape' => false));
				$out.= '</div>';
            }

            if ($menu['icon-class'] == 'admin-cms') {
                if (isPluginEnabled('Contests')) {
					$out.= '<li class="span9">';
					$out.= '<div class="ver-mspace clearfix">';
					$out.= '<div class="sep-bot span8">';
                    $out.= "<h6>";
                    $out.= __l('Contest Builder');
                    $out.= "</h6>";
                    $out.= "<h4>";
                    $out.= $this->Html->link(__l('Contest Form and Pricing for Types') , array(
                        'controller' => 'resources',
                        'action' => 'index'
                    ),array('title'=>__l('Contest Form and Pricing for Types')));
					$out.= '</h4>';
					$out.= '<div class="hor-space sfont textn no-mar">';
                    $out.= '<i class="icon-exclamation-sign hor-smspace"></i>';
                    $out.= __l('e.g., Entry Form for logo contest, Webdesign contest, etc');
                    $out.= "</div>";
                    $out.= "</div>";
                    $out.= "</div>";
					$out.= "</li>";
                }
				$out.= '<li class="span9">';
                $out.= '<div class="ver-mspace clearfix">';
				$out.= '<div class="sep-bot span8">';
                $out.= '<h6>';
                $out.= __l('Theme Manager');
                $out.= "</h6>";
				$out.= '<div class="pull-left space">';
				$out.= $this->Html->link(__l('Themes') , array(
                    'controller' => 'extensions_themes',
                    'action' => 'index'
                ),array('title'=>__l('Themes')));
                $out.= '<span class="show sfont textn no-mar">';
				$out.= '<i class="icon-exclamation-sign hor-smspace"></i>';
                $out.= __l('Manage your site themes');
                $out.= "</span>";
                $out.= "</div>";
                $out.= "</div>";
                $out.= "</div>";
				$out.= "</li>";
				$out.= '<li class="span9">';
                $out.= '<div class="ver-mspace clearfix">';
				$out.= '<div class="sep-bot span8">';
                $out.= '<h6>';
                $out.= __l('CMS Builder');
                $out.= "</h6>";
                $out.= "<div class='pull-left span4 no-mar'>";
                $out.= "<ul class='unstyled'>";
                $out.= "<li>";
                $out.= $this->Html->link(__l('Contents') , array(
                    'controller' => 'nodes',
                    'action' => 'index'
                ),array('title'=>__l('Contents')));
                $out.= "</li>";
                $out.= "<li>";
                $out.= $this->Html->link(__l('Blocks') , array(
                    'controller' => 'blocks',
                    'action' => 'index'
                ),array('title'=>__l('Blocks')));
                $out.= '<span class="span4 hor-space sfont textn no-mar">';
                $out.= '<i class="icon-exclamation-sign hor-smspace"></i>';
                $out.= __l('Blocks are reusable chunks for contents');
                $out.= "</span>";
                $out.= "</li>";
                $out.= "</ul>";
				$out.= "</div>";
				$out.= '<div class="pull-left no-mar span4">';
                $out.= "<ul class='unstyled'>";
                $out.= "<li>";
                $out.= $this->Html->link(__l('Menus') , array(
                    'controller' => 'menus',
                    'action' => 'index'
                ),array('title'=>__l('Menus')));
                $out.= '<span class="span4 hor-space sfont textn no-mar space">';
                $out.= '<i class="icon-exclamation-sign hor-smspace"></i>';
                $out.= __l('Menus for CMS contents');
                $out.= "</span>";
                $out.= "</li>";
                $out.= "</ul>";
				$out.= "</div>";
                $out.= "</div>";
				$out.= "</li>";
            } else {
                if (!empty($menu['children'])) {
                    if (!empty($menu['column']) && $menu['column'] > 1) {
                        $out.= '<li class="span12 no-mar space">';
                        $out.= '<div class="row">';
						$out.= '<ul class="unstyled hor-mspace clearfix">';
                        for ($i = 1; $i <= $menu['column']; $i++) {
                            if ($i == 1) {
                                $from = 0;
                                $to = (!empty($menu['column_1'])) ? $menu['column_1'] : round(count($menu['children']) /$menu['column']);
                                $li_class = 'span6';
                            } else {
                                $from = $to+1;
                                $to = count($menu['children']);
                                $li_class = 'span5';
                            }
                            $out.= '<li class="' . $li_class . ' pull-left">';
                            $out.= '<ul class="unstyled">';
                            $out.= $this->_getLinks($menu, $from, $to);
                            $out.= '</ul>';
                            $out.= '</li>';
                        }
                        $out.= '</ul>';
                        $out.= '</div>';
                        $out.= '</li>';
                    } else {
                        $out.= $this->_getLinks($menu);
                    }
                }
            }
            $out.= '</ul>';
            $out.= '</li>';
        }
        $out.= '</ul>';
		$out .= '</div>';
		$out .= '</div>';
		$out .= '</div>';
		return $out;
    }
    function _getLinks($menu, $from = 0, $to = 0)
    {
        $out = '';
        $i = 0;
        foreach($menu['children'] as $child) {
            if ((empty($from) && empty($to)) || ($i >= $from && $i <= $to)) {
                if (empty($child['htmlAttributes']['title'])) {
                    $child['htmlAttributes']['title'] = $child['title'];
                }
				if (!empty($child['sub_class'])) {
                    $child['htmlAttributes']['class'] = $child['sub_class'];
                }
                $out.= '<li>';
                if (!empty($child['url'])) {
                    $out.= $this->Html->link($child['title'], $child['url'], $child['htmlAttributes']);
                } else {
                    $out.= '<h6><span class = "span">' . $child['title'] . '</span></h6>';
                }
                $out.= '</li>';
            }
            $i++;
        }
        return $out;
    }/**
     * Show flash message
     *
     * @return string
     */
    public function sessionSubscriptionFlash()
    {
        $messages = $this->Session->read('Message');
        $output = '';
        if (is_array($messages) && !empty($messages)) {
            $output = '<div class="space text">';
            foreach($messages AS $key => $message) {
                $output.= '<div class="' . $key . '">' . $message['message'] . '</div>';
            }
            $output.= '</div>';
        }
        return $output;
    }
}
?>