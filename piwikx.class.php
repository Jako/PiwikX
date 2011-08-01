<?php
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage class_file
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6b <31.07.2011>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

class PiwikX {

    /**
     * URL of the Piwik installation.
     *
     * @var string
     * @access public
     */
    var $piwikURL;
    
    /**
     * Id of the website in Piwik.
     *
     * @var string
     * @access public
     */
    var $piwikSiteId;
    
    /**
     * Authentification token used by Piwik.
     *
     * @var string
     * @access public
     */
    var $piwikTokenAuth;
    
    /**
     * Username for viewing Piwik widgets.
     *
     * @var string
     * @access public
     */
    var $piwikUsername;
    
    /**
     * md5 encrypted Password for viewing Piwik widgets.
     *
     * @var string
     * @access public
     */
    var $piwikPassword;
    
    /**
     * An array of language specific phrases.
     *
     * @var array
     * @access public
     */
    var $piwikLanguage;
    
    /**
     * Filename of the javascript.
     *
     * @var string
     * @access public
     */
    var $piwikJsName;
    
    /**
     * Template variable containing the tracking title (could contain snippets and chunks).
     *
     * @var string
     * @access public
     */
    var $piwikActionName;
    
    /**
     * List of files extensions to track as downloads.
     *
     * @var string
     * @access public
     */
    var $piwikDownloadExtensions;
    
    /**
     * Consider a host an alias host.
     *
     * @var string
     * @access public
     */
    var $piwikHostsAlias;
    
    /**
     * Pause timer for outlinks and downloads.
     *
     * @var string
     * @access public
     */
    var $piwikTrackerPause;
    
    /**
     * Disable download and outlink tracking.
     *
     * @var string
     * @access public
     */
    var $piwikInstallTracker;
    
    /**
     * Users to track (not implemented now).
     *
     * @var array
     * @access public
     */
    var $piwikUserTrack;
    
    /**
     * Users not to track.
     *
     * @var array
     * @access public
     */
    var $piwikUserExclude;
    
    /**
     * Webgroups to track (not implemented now).
     *
     * @var array
     * @access public
     */
    var $piwikGroupTrack;
    
    /**
     * Webgroups to track.
     *
     * @var array
     * @access public
     */
    var $piwikGroupExclude;
    
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
     * @param $piwikURL URL of the Piwik installation
     * @param $piwikTokenAuth Authentification token used by Piwik
     * @author Jako
     */
    function __construct($piwikURL, $piwikSiteId, $piwikLanguage = array()) {
        global $modx;
        
        if (!class_exists('CChunkie'))
            include_once MODX_BASE_PATH.'assets/modules/piwikx/includes/chunkie.class.inc.php';
        
        if (substr($piwikURL, 0, 7) == "http://") {
            $piwikURL = substr($piwikURL, 7);
        } elseif (substr($piwikURL, 0, 8) == "https://") {
            $piwikURL = substr($piwikURL, 8);
        }
        $this->piwikURL = (isset($piwikURL)) ? $piwikURL : '';
        $this->piwikSiteId = (isset($piwikSiteId)) ? $piwikSiteId : 0;
        $this->piwikLanguage = $piwikLanguage;
    }
    
    /**
     * Returns true if the minimal configuration is set
     * @return boolean
     */
    function configIsSet() {
        return (($this->piwikURL != '') && ($this->piwikSiteId != 0) && ($this->piwikUsername != '') && ($this->piwikPassword != ''));
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
        global $modx;
        
        $actionName = $modx->getTemplateVarOutput($this->piwikActionName);
        if ($actionName[$this->piwikActionName]) {
            $actionName = new CChunkie($actionName[$this->piwikActionName]);
            $actionName = $actionName->Render();
        } else {
            $actionName = $modx->getTemplateVarOutput('pagetitle');
            $actionName = $actionName['pagetitle'];
        }
        $actionName = str_replace('/', '_', $actionName);
        return $actionName;
    }
    
    /**
     * Parses a string and replaces Placeholders
     * @param string chunk, array placeholderArr, string prefix, string suffix
     * @return string
     */
    function replacePlaceholder($chunk, $placeholderArr, $prefix = "[+", $suffix = "+]") {
        if (!is_array($placeholderArr)) {
            return false;
        }
        foreach ($placeholderArr as $key=>$value) {
            $chunk = str_replace($prefix.$key.$suffix, $value, $chunk);
        }
        return $chunk;
    }
    
    /**
     * Returns the parsed module template
     * @return string
     */
    function displayModule() {
        global $modx;
        include 'piwikx.templates.php';
        include 'lang/'.$this->piwikLanguage['languagefile'].'.managerwidgets.php';
        
        if ($this->configIsSet()) {
            if ($_GET['piwikx'] == "in") {
                $template = $piwikModuleTemplate;
                $theme = $modx->db->select('setting_value', $modx->getFullTableName('system_settings'), 'setting_name=\'manager_theme\'', '');
                $theme = $modx->db->getRow($theme);
                $theme = ($theme['setting_value'] != '') ? '/'.$theme['setting_value'] : '';
                $tpl = new CChunkie($piwikModuleTemplate);
                $tpl->AddVar('LangModuleName', $this->piwikLanguage['modulename']);
                $tpl->AddVar('LangModuleDesc', $this->piwikLanguage['moduledesc']);
                $tpl->AddVar('LangModuleReload', $this->piwikLanguage['modulereload']);
                $tpl->AddVar('LangModuleClose', $this->piwikLanguage['moduleclose']);
                $tpl->AddVar('LangModuleShowFullStat', $this->piwikLanguage['moduleshowfullstat']);
                $tpl->AddVar('piwikURL', 'http://'.$this->piwikURL);
                $tpl->AddVar('piwikSiteId', $this->piwikSiteId);
                $tpl->AddVar('piwikTokenAuth', $this->piwikTokenAuth);
                $tpl->AddVar('ManagerTheme', $theme);
                $widgets = '';
                foreach ($piwikWidgets as $piwikWidget) {
                    $widget = new CChunkie($piwikWidgetTemplate);
                    $widget->CreateVars($piwikWidget);
                    $widget->AddVar('piwikURL', 'http://'.$this->piwikURL);
                    $widget->AddVar('piwikSiteId', $this->piwikSiteId);
                    $widgets .= $widget->Render();
                }
                $tpl->AddVar('piwikManagerWidgets', $widgets);
                $template = $tpl->Render();
            } else {
                header('Location: http://'.$this->piwikURL.'/index.php?module=Login&action=logme&login='.$this->piwikUsername.'&password='.$this->piwikPassword.'&url='.urlencode($modx->config['site_url'].'/manager/index.php?a='.intval($_GET['a']).'&id='.intval($_GET['id']).'&piwikx=in'));
            }
        } else {
            $template = $piwikNoConfigTemplate;
            $theme = $modx->db->select('setting_value', $modx->getFullTableName('system_settings'), 'setting_name=\'manager_theme\'', '');
            $theme = $modx->db->getRow($theme);
            $theme = ($theme['setting_value'] != '') ? '/'.$theme['setting_value'] : '';
            $tpl = new CChunkie($piwikNoConfigTemplate);
            $tpl->AddVar('LangModuleName', $this->piwikLanguage['modulename']);
            $tpl->AddVar('LangModuleNoConfigName', $this->piwikLanguage['modulenoconfigname']);
            $tpl->AddVar('LangModuleDesc', $this->piwikLanguage['moduledesc']);
            $tpl->AddVar('LangModuleClose', $this->piwikLanguage['moduleclose']);
            $tpl->AddVar('LangModuleNoConfigText', $this->piwikLanguage['modulenoconfigtext']);
            $tpl->AddVar('ManagerTheme', $theme);
            $template = $tpl->Render();
        }
        return $template;
    
    }
    
    /**
     * Includes the parsed chunk for the html-code
     */
    function includeChunk() {
        global $modx;
        
        if ($this->configIsSet() && ($modx->documentObject[contentType] == 'text/html')) {
            $username = $this->loggedUserName();
            
            // Check Webgroup
            if ($modx->isMemberOfWebGroup($this->piwikGroupTrack))
                $trackUserName = $username;
            if ($modx->isMemberOfWebGroup($this->piwikGroupExclude))
                return '';
            
            // Check User
            if (in_array($username, $this->piwikUserTrack))
                $trackUserName = $username;
            if (in_array($username, $this->piwikUserExclude))
                return '';
            
            // generate Chunk for the body
            include 'piwikx.templates.php';
            $template = $piwikChunkTemplate;
     
            if ($this->piwikTrackerPause != '')
                $params = 'piwikTracker.setLinkTrackingTimer(' . $this->piwikTrackerPause . ');' . "\r\n";
            if ($this->piwikHostsAlias != '')
                $params .= 'piwikTracker.setDomains(["'. explode('", "', $this->piwikHostsAlias) .'"]);'."\r\n";
            if ($this->piwikDownloadExtensions != '')
                $params = 'piwikTracker.setDownloadExtensions( "'. explode('|', $this->piwikDownloadExtensions) .'" );'."\r\n";
            if ($this->piwikInstallTracker == '')
                $params .= 'piwikTracker.enableLinkTracking();'."\r\n";
                
            $placeholderArr['piwikURL'] = $this->piwikURL;
            $placeholderArr['piwikSiteID'] = $this->piwikSiteId;
            $placeholderArr['piwikJsName'] = $this->piwikJsName;
            $placeholderArr['piwikDocumentTitle'] = $this->actionName();
            
            $placeholderArr['piwikParams'] = $params;
            $template = $this->replacePlaceholder($template, $placeholderArr);
            return $template;
        }
        return;
    }
}
?>
