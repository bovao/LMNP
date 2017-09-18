<?php
/**
 * Methods for displaying presentation data in the view.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('HelperCollection', 'View');
App::uses('AppHelper', 'View/Helper');
App::uses('Router', 'Routing');
App::uses('ViewBlock', 'View');
App::uses('CakeEvent', 'Event');
App::uses('CakeEventManager', 'Event');
App::uses('CakeResponse', 'Network');

/**
 * View, the V in the MVC triad. View interacts with Helpers and view variables passed
 * in from the controller to render the results of the controller action. Often this is HTML,
 * but can also take the form of JSON, XML, PDF's or streaming files.
 *
 * CakePHP uses a two-step-view pattern. This means that the view content is rendered first,
 * and then inserted into the selected layout. This also means you can pass data from the view to the
 * layout using `$this->set()`
 *
 * Since 2.1, the base View class also includes support for themes by default. Theme views are regular
 * view files that can provide unique HTML and static assets. If theme views are not found for the
 * current view the default app view files will be used. You can set `$this->theme = 'mytheme'`
 * in your Controller to use the Themes.
 *
 * Example of theme path with `$this->theme = 'SuperHot';` Would be `app/View/Themed/SuperHot/Posts`
 *
 * @package       Cake.View
 * @property      CacheHelper $Cache
 * @property      FormHelper $Form
 * @property      HtmlHelper $Html
 * @property      JsHelper $Js
 * @property      NumberHelper $Number
 * @property      PaginatorHelper $Paginator
 * @property      RssHelper $Rss
 * @property      SessionHelper $Session
 * @property      TextHelper $Text
 * @property      TimeHelper $Time
 * @property      ViewBlock $Blocks
 */
class View extends Object {

/**
 * Helpers collection
 *
 * @var HelperCollection
 */
	public $Helpers;

/**
 * ViewBlock instance.
 *
 * @var ViewBlock
 */
	public $Blocks;

/**
 * Name of the plugin.
 *
 * @link http://manual.cakephp.org/chapter/plugins
 * @var string
 */
	public $plugin = null;

/**
 * Name of the controller.
 *
 * @var string
 */
	public $name = null;

/**
 * Current passed params
 *
 * @var mixed
 */
	public $passedArgs = array();

/**
 * An array of names of built-in helpers to include.
 *
 * @var mixed
 */
	public $helpers = array();

/**
 * Path to View.
 *
 * @var string
 */
	public $viewPath = null;

/**
 * Variables for the view
 *
 * @var array
 */
	public $viewVars = array();

/**
 * Name of view to use with this View.
 *
 * @var string
 */
	public $view = null;

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
	public $layout = 'default';

/**
 * Path to Layout.
 *
 * @var string
 */
	public $layoutPath = null;

/**
 * Turns on or off CakePHP's conventional mode of applying layout files. On by default.
 * Setting to off means that layouts will not be automatically applied to rendered views.
 *
 * @var bool
 */
	public $autoLayout = true;

/**
 * File extension. Defaults to CakePHP's template ".ctp".
 *
 * @var string
 */
	public $ext = '.ctp';

/**
 * Sub-directory for this view file. This is often used for extension based routing.
 * Eg. With an `xml` extension, $subDir would be `xml/`
 *
 * @var string
 */
	public $subDir = null;

/**
 * Theme name.
 *
 * @var string
 */
	public $theme = null;

/**
 * Used to define methods a controller that will be cached.
 *
 * @see Controller::$cacheAction
 * @var mixed
 */
	public $cacheAction = false;

/**
 * Holds current errors for the model validation.
 *
 * @var array
 */
	public $validationErrors = array();

/**
 * True when the view has been rendered.
 *
 * @var bool
 */
	public $hasRendered = false;

/**
 * List of generated DOM UUIDs.
 *
 * @var array
 */
	public $uuids = array();

/**
 * An instance of a CakeRequest object that contains information about the current request.
 * This object contains all the information about a request and several methods for reading
 * additional information about the request.
 *
 * @var CakeRequest
 */
	public $request;

/**
 * Reference to the Response object
 *
 * @var CakeResponse
 */
	public $response;

/**
 * The Cache configuration View will use to store cached elements. Changing this will change
 * the default configuration elements are stored under. You can also choose a cache config
 * per element.
 *
 * @var string
 * @see View::element()
 */
	public $elementCache = 'default';

/**
 * Element cache settings
 *
 * @var array
 * @see View::_elementCache();
 * @see View::_renderElement
 */
	public $elementCacheSettings = array();

/**
 * List of variables to collect from the associated controller.
 *
 * @var array
 */
	protected $_passedVars = array(
		'viewVars', 'autoLayout', 'ext', 'helpers', 'view', 'layout', 'name', 'theme',
		'layoutPath', 'viewPath', 'request', 'plugin', 'passedArgs', 'cacheAction'
	);

/**
 * Scripts (and/or other <head /> tags) for the layout.
 *
 * @var array
 */
	protected $_scripts = array();

/**
 * Holds an array of paths.
 *
 * @var array
 */
	protected $_paths = array();

/**
 * Holds an array of plugin paths.
 *
 * @var array
 */
	protected $_pathsForPlugin = array();

/**
 * The names of views and their parents used with View::extend();
 *
 * @var array
 */
	protected $_parents = array();

/**
 * The currently rendering view file. Used for resolving parent files.
 *
 * @var string
 */
	protected $_current = null;

/**
 * Currently rendering an element. Used for finding parent fragments
 * for elements.
 *
 * @var string
 */
	protected $_currentType = '';

/**
 * Content stack, used for nested templates that all use View::extend();
 *
 * @var array
 */
	protected $_stack = array();

/**
 * Instance of the CakeEventManager this View object is using
 * to dispatch inner events. Usually the manager is shared with
 * the controller, so it it possible to register view events in
 * the controller layer.
 *
 * @var CakeEventManager
 */
	protected $_eventManager = null;

/**
 * Whether the event manager was already configured for this object
 *
 * @var bool
 */
	protected $_eventManagerConfigured = false;

/**
 * Constant for view file type 'view'
 *
 * @var string
 */
	const TYPE_VIEW = 'view';

/**
 * Constant for view file type 'element'
 *
 * @var string
 */
	const TYPE_ELEMENT = 'element';

/**
 * Constant for view file type 'layout'
 *
 * @var string
 */
	const TYPE_LAYOUT = 'layout';

/**
 * Constructor
 *
 * @param Controller $controller A controller object to pull View::_passedVars from.
 */
	public function __construct(Controller $controller = null) {
		if (is_object($controller)) {
			$count = count($this->_passedVars);
			for ($j = 0; $j < $count; $j++) {
				$var = $this->_passedVars[$j];
				$this->{$var} = $controller->{$var};
			}
			$this->_eventManager = $controller->getEventManager();
		}
		if (empty($this->request) && !($this->request = Router::getRequest(true))) {
			$this->request = new CakeRequest(null, false);
			$this->request->base = '';
			$this->request->here = $this->request->webroot = '/';
		}
		if (is_object($controller) && isset($controller->response)) {
			$this->response = $controller->response;
		} else {
			$this->response = new CakeResponse();
		}
		$this->Helpers = new HelperCollection($this);
		$this->Blocks = new ViewBlock();
		$this->loadHelpers();
		parent::__construct();
	}

/**
 * Returns the CakeEventManager manager instance that is handling any callbacks.
 * You can use this instance to register any new listeners or callbacks to the
 * controller events, or create your own events and trigger them at will.
 *
 * @return CakeEventManager
 */
	public function getEventManager() {
		if (empty($this->_eventManager)) {
			$this->_eventManager = new CakeEventManager();
		}
		if (!$this->_eventManagerConfigured) {
			$this->_eventManager->attach($this->Helpers);
			$this->_eventManagerConfigured = true;
		}
		return $this->_eventManager;
	}

/**
 * Renders a piece of PHP with provided parameters and returns HTML, XML, or any other string.
 *
 * This realizes the concept of Elements, (or "partial layouts") and the $params array is used to send
 * data to be used in the element. Elements can be cached improving performance by using the `cache` option.
 *
 * @param string $name Name of template file in the/app/View/Elements/ folder,
 *   or `MyPlugin.template` to use the template element from MyPlugin. If the element
 *   is not found in the plugin, the normal view path cascade will be searched.
 * @param array $data Array of data to be made available to the rendered view (i.e. the Element)
 * @param array $options Array of options. Possible keys are:
 * - `cache` - Can either be `true`, to enable caching using the config in View::$elementCache. Or an array
 *   If an array, the following keys can be used:
 *   - `config` - Used to store the cached element in a custom cache configuration.
 *   - `key` - Used to define the key used in the Cache::write(). It will be prefixed with `element_`
 * - `plugin` - (deprecated!) Load an element from a specific plugin. This option is deprecated, and
 *              will be removed in CakePHP 3.0. Use `Plugin.element_name` instead.
 * - `callbacks` - Set to true to fire beforeRender and afterRender helper callbacks for this element.
 *   Defaults to false.
 * - `ignoreMissing` - Used to allow missing elements. Set to true to not trigger notices.
 * @return string Rendered Element
 */
	public function element($name, $data = array(), $options = array()) {
		$file = $plugin = null;

		if (isset($options['plugin'])) {
			$name = Inflector::camelize($options['plugin']) . '.' . $name;
		}

		if (!isset($options['callbacks'])) {
			$options['callbacks'] = false;
		}

		if (isset($options['cache'])) {
			$contents = $this->_elementCache($name, $data, $options);
			if ($contents !== false) {
				return $contents;
			}
		}

		$file = $this->_getElementFilename($name);
		if ($file) {
			return $this->_renderElement($file, $data, $options);
		}

		if (empty($options['ignoreMissing'])) {
			list ($plugin, $name) = pluginSplit($name, true);
			$name = str_replace('/', DS, $name);
			$file = $plugin . 'Elements' . DS . $name . $this->ext;
			trigger_error(__d('cake_dev', 'Element Not Found: %s', $file), E_USER_NOTICE);
		}
	}

/**
 * Checks if an element exists
 *
 * @param string $name Name of template file in the /app/View/Elements/ folder,
 *   or `MyPlugin.template` to check the template element from MyPlugin. If the element
 *   is not found in the plugin, the normal view path cascade will be searched.
 * @return bool Success
 */
	public function elementExists($name) {
		return (bool)$this->_getElementFilename($name);
	}

/**
 * Renders view for given view file and layout.
 *
 * Render triggers helper callbacks, which are fired before and after the view are rendered,
 * as well as before and after the layout. The helper callbacks are called:
 *
 * - `beforeRender`
 * - `afterRender`
 * - `beforeLayout`
 * - `afterLayout`
 *
 * If View::$autoRender is false and no `$layout` is provided, the view will be returned bare.
 *
 * View and layout names can point to plugin views/layouts. Using the `Plugin.view` syntax
 * a plugin view/layout can be used instead of the app ones. If the chosen plugin is not found
 * the view will be located along the regular view path cascade.
 *
 * @param string $view Name of view file to use
 * @param string $layout Layout to use.
 * @return string|null Rendered content or null if content already rendered and returned earlier.
 * @throws CakeException If there is an error in the view.
 */
	public function render($view = null, $layout = null) {
		if ($this->hasRendered) {
			return;
		}

		if ($view !== false && $viewFileName = $this->_getViewFileName($view)) {
			$this->_currentType = self::TYPE_VIEW;
			$this->getEventManager()->dispatch(new CakeEvent('View.beforeRender', $this, array($viewFileName)));
			$this->Blocks->set('content', $this->_render($viewFileName));
			$this->getEventManager()->dispatch(new CakeEvent('View.afterRender', $this, array($viewFileName)));
		}

		if ($layout === null) {
			$layout = $this->layout;
		}
		if ($layout && $this->autoLayout) {
			$this->Blocks->set('content', $this->renderLayout('', $layout));
		}
		$this->hasRendered = true;
		return $this->Blocks->get('content');
	}

/**
 * Renders a layout. Returns output from _render(). Returns false on error.
 * Several variables are created for use in layout.
 *
 * - `title_for_layout` - A backwards compatible place holder, you should set this value if you want more control.
 * - `content_for_layout` - contains rendered view file
 * - `scripts_for_layout` - Contains content added with addScript() as well as any content in
 *   the 'meta', 'css', and 'script' blocks. They are appended in that order.
 *
 * Deprecated features:
 *
 * - `$scripts_for_layout` is deprecated and will be removed in CakePHP 3.0.
 *   Use the block features instead. `meta`, `css` and `script` will be populated
 *   by the matching methods on HtmlHelper.
 * - `$title_for_layout` is deprecated and will be removed in CakePHP 3.0.
 *   Use the `title` block instead.
 * - `$content_for_layout` is deprecated and will be removed in CakePHP 3.0.
 *   Use the `content` block instead.
 *
 * @param string $content Content to render in a view, wrapped by the surrounding layout.
 * @param string $layout Layout name
 * @return mixed Rendered output, or false on error
 * @throws CakeException if there is an error in the view.
 */
	public function renderLayout($content, $layout = null) {
		$layoutFileName = $this->_getLayoutFileName($layout);
		if (empty($layoutFileName)) {
			return $this->Blocks->get('content');
		}

		if (empty($content)) {
			$content = $this->Blocks->get('content');
		} else {
			$this->Blocks->set('content', $content);
		}
		$this->getEventManager()->dispatch(new CakeEvent('View.beforeLayout', $this, array($layoutFileName)));

		$scripts = implode("\n\t", $this->_scripts);
		$scripts .= $this->Blocks->get('meta') . $this->Blocks->get('css') . $this->Blocks->get('script');

		$this->viewVars = array_merge($this->viewVars, array(
			'content_for_layout' => $content,
			'scripts_for_layout' => $scripts,
		));

		$title = $this->Blocks->get('title');
		if ($title === '') {
			if (isset($this->viewVars['title_for_layout'])) {
				$title = $this->viewVars['title_for_layout'];
			} else {
				$title = Inflector::humanize($this->viewPath);
			}
		}
		$this->viewVars['title_for_layout'] = $title;
		$this->Blocks->set('title', $title);

		$this->_currentType = self::TYPE_LAYOUT;
		$this->Blocks->set('content', $this->_render($layoutFileName));

		$this->getEventManager()->dispatch(new CakeEvent('View.afterLayout', $this, array($layoutFileName)));
		return $this->Blocks->get('content');
	}

/**
 * Render cached view. Works in concert with CacheHelper and Dispatcher to
 * render cached view files.
 *
 * @param string $filename the cache file to include
 * @param string $timeStart the page render start time
 * @return bool Success of rendering the cached file.
 */
	public function renderCache($filename, $timeStart) {
		$response = $this->response;
		ob_start();
		include $filename;

		$type = $response->mapType($response->type());
		if (Configure::read('debug') > 0 && $type === 'html') {
			echo "<!-- Cached Render Time: " . round(microtime(true) - $timeStart, 4) . "s -->";
		}
		$out = ob_get_clean();

		if (preg_match('/^<!--cachetime:(\\d+)-->/', $out, $match)) {
			if (time() >= $match['1']) {
				//@codingStandardsIgnoreStart
				@unlink($filename);
				//@codingStandardsIgnoreEnd
				unset($out);
				return false;
			}
			return substr($out, strlen($match[0]));
		}
	}

/**
 * Returns a list of variables available in the current View context
 *
 * @return array Array of the set view variable names.
 */
	public function getVars() {
		return array_keys($this->viewVars);
	}

/**
 * Returns the contents of the given View variable(s)
 *
 * @param string $var The view var you want the contents of.
 * @return mixed The content of the named var if its set, otherwise null.
 * @deprecated Will be removed in 3.0. Use View::get() instead.
 */
	public function getVar($var) {
		return $this->get($var);
	}

/**
 * Returns the contents of the given View variable.
 *
 * @param string $var The view var you want the contents of.
 * @param mixed $default The default/fallback content of $var.
 * @return mixed The content of the named var if its set, otherwise $default.
 */
	public function get($var, $default = null) {
		if (!isset($this->viewVars[$var])) {
			return $default;
		}
		return $this->viewVars[$var];
	}

/**
 * Get the names of all the existing blocks.
 *
 * @return array An array containing the blocks.
 * @see ViewBlock::keys()
 */
	public function blocks() {
		return $this->Blocks->keys();
	}

/**
 * Start capturing output for a 'block'
 *
 * @param string $name The name of the block to capture for.
 * @return void
 * @see ViewBlock::start()
 */
	public function start($name) {
		$this->Blocks->start($name);
	}

/**
 * Start capturing output for a 'block' if it has no content
 *
 * @param string $name The name of the block to capture for.
 * @return void
 * @see ViewBlock::startIfEmpty()
 */
	public function startIfEmpty($name) {
		$this->Blocks->startIfEmpty($name);
	}

/**
 * Append to an existing or new block. Appending to a new
 * block will create the block.
 *
 * @param string $name Name of the block
 * @param mixed $value The content for the block.
 * @return void
 * @see ViewBlock::concat()
 */
	public function append($name, $value = null) {
		$this->Blocks->concat($name, $value);
	}

/**
 * Prepend to an existing or new block. Prepending to a new
 * block will create the block.
 *
 * @param string $name Name of the block
 * @param mixed $value The content for the block.
 * @return void
 * @see ViewBlock::concat()
 */
	public function prepend($name, $value = null) {
		$this->Blocks->concat($name, $value, ViewBlock::PREPEND);
	}

/**
 * Set the content for a block. This will overwrite any
 * existing content.
 *
 * @param string $name Name of the block
 * @param mixed $value The content for the block.
 * @return void
 * @see ViewBlock::set()
 */
	public function assign($name, $value) {
		$this->Blocks->set($name, $value);
	}

/**
 * Fetch the content for a block. If a block is
 * empty or undefined '' will be returned.
 *
 * @param string $name Name of the block
 * @param string $default Default text
 * @return string default The block content or $default if the block does not exist.
 * @see ViewBlock::get()
 */
	public function fetch($name, $default = '') {
		return $this->Blocks->get($name, $default);
	}

/**
 * End a capturing block. The compliment to View::start()
 *
 * @return void
 * @see ViewBlock::end()
 */
	public function end() {
		$this->Blocks->end();
	}

/**
 * Provides view or element extension/inheritance. Views can extends a
 * parent view and populate blocks in the parent template.
 *
 * @param string $name The view or element to 'extend' the current one with.
 * @return void
 * @throws LogicException when you extend a view with itself or make extend loops.
 * @throws LogicException when you extend an element which doesn't exist
 */
	public function extend($name) {
		if ($name[0] === '/' || $this->_currentType === self::TYPE_VIEW) {
			$parent = $this->_getViewFileName($name);
		} else {
			switch ($this->_currentType) {
				case self::TYPE_ELEMENT:
					$parent = $this->_getElementFileName($name);
					if (!$parent) {
						list($plugin, $name) = $this->pluginSplit($name);
						$paths = $this->_paths($plugin);
						$defaultPath = $paths[0] . 'Elements' . DS;
						throw new LogicException(__d(
							'cake_dev',
							'You cannot extend an element which does not exist (%s).',
							$defaultPath . $name . $this->ext
						));
					}
					break;
				case self::TYPE_LAYOUT:
					$parent = $this->_getLayoutFileName($name);
					break;
				default:
					$parent = $this->_getViewFileName($name);
			}
		}

		if ($parent == $this->_current) {
			throw new LogicException(__d('cake_dev', 'You cannot have views extend themselves.'));
		}
		if (isset($this->_parents[$parent]) && $this->_parents[$parent] == $this->_current) {
			throw new LogicException(__d('cake_dev', 'You cannot have views extend in a loop.'));
		}
		$this->_parents[$this->_current] = $parent;
	}

/**
 * Adds a script block or other element 