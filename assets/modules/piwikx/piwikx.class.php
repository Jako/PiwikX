<?php
/*
 * Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 *
 * @package PiwikX
 * @subpackage class_file
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.7.1
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PiwikX {

	/**
	 * A reference to the modX instance
	 * @var modX $modx
	 */
	public $modx;

	/**
	 * A reference to the newChunkie instance
	 * @var newChunkie $chunkie
	 */
	public $chunkie;

	/**
	 * Global options.
	 * @var array $options
	 * @access private
	 */
	private $options;

	/**
	 * Global language.
	 * @var array $language
	 * @access private
	 */
	private $language;

	/**
	 * manager theme.
	 *
	 * @var string
	 * @access private
	 */
	var $managerTheme;

	/**
	 * PiwikX Class Constructor
	 *
	 * @param modX &$modx A reference to the modX instance.
	 * @param array $config An array of configuration options.
	 */
	function __construct($modx, $config = array()) {
		$this->modx = &$modx;
		$this->options = $config;

		if (!class_exists('newChunkie')) {
			include_once PWK_BASE_PATH . 'includes/newchunkie.class.inc.php';
		}
		$this->language = $config['piwikLang'];
		$this->chunkie = new newChunkie($this->modx, array('basepath' => PWK_PATH));
	}

	/**
	 * Returns true if the minimal configuration is set
	 * @return boolean
	 */
	function configIsSet() {
		return (($this->options['piwikURL'] != '') && ($this->options['piwikSiteId'] != 0) && ($this->options['piwikUsername'] != '') && ($this->options['piwikPassword'] != ''));
	}

	/**
	 * Returns the name of the user logged in
	 * @return string
	 */
	function loggedUserName() {
		$username = isset($_SESSION['webShortname']) ? $_SESSION['webShortname'] : $_SESSION['mgrShortname'];
		$username = isset($username) ? $username : '';
		return $username;
	}

	/**
	 * Returns the (parsed) content of a TV - The piwik tracking title
	 * @return string
	 */
	function actionName() {
		$actionName = $this->modx->getTemplateVarOutput($this->options['piwikActionName']);
		if ($actionName[$this->options['piwikActionName']]) {
			$actionName = new evoChunkie($actionName[$this->options['piwikActionName']]);
			$actionName = $actionName->Render();
		} else {
			$actionName = $this->modx->getTemplateVarOutput('pagetitle');
			$actionName = $actionName['pagetitle'];
		}
		$actionName = str_replace('/', '_', $actionName);
		return $actionName;
	}

	/**
	 * Returns the parsed module template
	 * @return string
	 */
	function displayModule() {
		include 'lang/' . $this->language['languagefile'] . '.managerwidgets.php';

		if ($this->configIsSet()) {
			$theme = $this->modx->db->select('setting_value', $this->modx->getFullTableName('system_settings'), 'setting_name=\'manager_theme\'', '');
			$theme = $this->modx->db->getRow($theme);
			$theme = ($theme['setting_value'] != '') ? '/' . $theme['setting_value'] : '';

			$widgets = array();
			foreach ($piwikWidgets as $piwikWidget) {
				$this->chunkie->setPlaceholder('', $piwikWidget, 'widget');
				$this->chunkie->setPlaceholder('piwikURL', 'http://' . $this->options['piwikURL'], 'widget');
				$this->chunkie->setPlaceholder('piwikSiteId', $this->options['piwikSiteId'], 'widget');
				$this->chunkie->setPlaceholder('piwikTokenAuth', $this->options['piwikTokenAuth'], 'widget');
				$this->chunkie->setTpl($this->chunkie->getTemplateChunk('@FILE templates/widget.template.html'));
				$this->chunkie->prepareTemplate('', array(), 'widget');
				$widgets[] = $this->chunkie->process('widget');
			}

			$this->chunkie->setPlaceholder('widgets', implode("\n", $widgets), 'module');
			$this->chunkie->setPlaceholder('language', $this->language, 'module');
			$this->chunkie->setPlaceholder('piwikURL', 'http://' . $this->options['piwikURL'], 'module');
			$this->chunkie->setPlaceholder('piwikSiteId', $this->options['piwikSiteId'], 'module');
			$this->chunkie->setPlaceholder('piwikTokenAuth', $this->options['piwikTokenAuth'], 'module');
			$this->chunkie->setPlaceholder('managertheme', $theme, 'module');
			$this->chunkie->setTpl($this->chunkie->getTemplateChunk('@FILE templates/module.template.html'));
			$this->chunkie->prepareTemplate('', array(), 'module');

			$template = $this->chunkie->process('module');
		} else {
			$theme = $this->modx->db->select('setting_value', $this->modx->getFullTableName('system_settings'), 'setting_name=\'manager_theme\'', '');
			$theme = $this->modx->db->getRow($theme);
			$theme = ($theme['setting_value'] != '') ? '/' . $theme['setting_value'] : '';

			$this->chunkie->setPlaceholder('language', $this->language, 'module');
			$this->chunkie->setPlaceholder('managertheme', $theme, 'module');
			$this->chunkie->setTpl($this->chunkie->getTemplateChunk('@FILE templates/noconfig.template.html'));
			$this->chunkie->prepareTemplate('', array(), 'module');

			$template = $this->chunkie->process('module');
		}
		return $template;
	}

	/**
	 * Includes the parsed chunk for the html-code
	 */
	function includeChunk() {
		if ($this->configIsSet() && ($this->modx->documentObject['contentType'] == 'text/html')) {
			$username = $this->loggedUserName();

			// Check Webgroup
			if ($this->modx->isMemberOfWebGroup($this->options['piwikGroupTrack']))
				$trackUserName = $username;
			if ($this->modx->isMemberOfWebGroup($this->options['piwikGroupExclude']))
				return '';

			// Check User
			if (in_array($username, $this->options['piwikUserTrack']))
				$trackUserName = $username;
			if (in_array($username, $this->options['piwikUserExclude']))
				return '';

			// generate Chunk for the body
			$params = array();
			if ($this->options['piwikTrackerPause'] != '')
				$params[] = '_paq.push([ "setLinkTrackingTimer", ' . $this->options['piwikTrackerPause'] . ' ]);';
			if (!empty($this->options['piwikHostsAlias']))
				$params[] = '_paq.push([ "setDomains", ["' . implode(', ', $this->options['piwikHostsAlias']) . '"] ]);';
			if (!empty($this->options['piwikDownloadExtensions']))
				$params[] = '_paq.push([ "setDownloadExtensions", "' . implode('|', $this->options['piwikDownloadExtensions']) . '" ]);';
			if ($this->options['piwikInstallTracker'] == '')
				$params[] = '_paq.push(["enableLinkTracking"]);';

			$this->chunkie->setPlaceholder('piwikURL', $this->options['piwikURL']);
			$this->chunkie->setPlaceholder('piwikSiteId', $this->options['piwikSiteId']);
			$this->chunkie->setPlaceholder('piwikJsName', $this->options['piwikJsName']);
			$this->chunkie->setPlaceholder('piwikDocumentTitle', $this->actionName());
			$this->chunkie->setPlaceholder('piwikParams', implode("\r\n", $params));
			$this->chunkie->setTpl($this->chunkie->getTemplateChunk('@FILE templates/chunk.template.html'));
			$this->chunkie->prepareTemplate('');

			$template = $this->chunkie->process();
			return $template;
		} else {
			return 'nix';
		}
		return;
	}

}

?>
