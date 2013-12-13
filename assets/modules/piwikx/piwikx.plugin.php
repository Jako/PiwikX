<?php
/*
 * Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 *
 * @package PiwikX
 * @subpackage modx_plugin
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.7.1
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @internal    @description: <strong>0.7.1</strong> Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 * @internal    @plugin code: include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.plugin.php');
 * @internal    @MODx event: OnLoadWebDocument
 */

if (MODX_BASE_PATH == '') {
	die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}

define('PWK_PATH', str_replace(MODX_BASE_PATH, '', str_replace('\\', '/', realpath(dirname(__FILE__)))) . '/');
define('PWK_BASE_PATH', MODX_BASE_PATH . PWK_PATH);

$options = array();
$options['piwikURL'] = (isset($piwikURL)) ? preg_replace('#^https?://#', '', $piwikURL) : '';
$options['piwikSiteId'] = (isset($piwikSiteId)) ? $piwikSiteId : 0;
$options['piwikUsername'] = (isset($piwikUsername)) ? $piwikUsername : '';
$options['piwikPassword'] = (isset($piwikPassword)) ? $piwikPassword : '';
$options['piwikTokenAuth'] = (isset($piwikTokenAuth)) ? $piwikTokenAuth : '';
$options['piwikActionName'] = (isset($piwikActionName)) ? $piwikActionName : '';
$options['piwikJsName'] = (isset($piwikJsName)) ? $piwikJsName : '';
$options['piwikTrackerPause'] = (isset($piwikTrackerPause)) ? $piwikTrackerPause : '';
$options['piwikHostsAlias'] = (isset($piwikHostsAlias)) ? explode(',' , $piwikHostsAlias) : array();
$options['piwikDownloadExtensions'] = (isset($piwikDownloadExtensions)) ? explode(',' , $piwikDownloadExtensions) : array();
$options['piwikJsName'] = (isset($piwikInstallTracker)) ? $piwikInstallTracker : '';
$options['piwikGroupTrack'] = (isset($piwikGroupTrack)) ? explode(',', $piwikGroupTrack) : array();
$options['piwikGroupExclude'] = (isset($piwikGroupExclude)) ? explode(',', $piwikGroupExclude) : array();
$options['piwikUserTrack'] = (isset($piwikUserTrack)) ? explode(',', $piwikUserTrack) : array();
$options['piwikUserExclude'] = (isset($piwikUserExclude)) ? explode(',', $piwikUserExclude) : array();

// load classfile
$class_file = PWK_BASE_PATH . 'piwikx.class.php';
if (!file_exists($class_file))
	$modx->messageQuit(sprintf('Classfile "%s" not found. Did you upload the module files?', $class_file));
require_once ($class_file);

// MODx event handling
$e = &$modx->Event;
switch ($e->name) {
	case "OnLoadWebDocument" :
		$PiwikX = new PiwikX($modx, $options);
		$modx->regClientHTMLBlock($PiwikX->includeChunk());
		break;

	default :
		return; // a plugin should return to MODx - this is very important.
		break;
}
?>
