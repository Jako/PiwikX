<?php
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage modx_plugin
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6b <31.07.2011>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @internal    @description: <strong>0.6.6a</strong> integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 * @internal    @plugin code: include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.plugin.php');
 * @internal    @MODx event: OnLoadWebDocument
 */

if(MODX_BASE_PATH == '') {
	die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}

$piwikURL = (isset($piwikURL)) ? $piwikURL : '';
$piwikSiteId = (isset($piwikSiteId)) ? $piwikSiteId : 0;

// invoke module
$class_file = MODX_BASE_PATH.'assets/modules/piwikx/piwikx.class.php';
if (!file_exists($class_file))
	$modx->messageQuit(sprintf('Classfile "%s" not found. Did you upload the module files?', $class_file));
require_once ($class_file);

// MODx event handling
$e = &$modx->Event;
switch ($e->name) {
	case "OnLoadWebDocument" :
		$PiwikX = new PiwikX($piwikURL, $piwikSiteId);

		$PiwikX->piwikUsername = (isset($piwikUsername)) ? $piwikUsername : '';
		$PiwikX->piwikPassword = (isset($piwikPassword)) ? $piwikPassword : '';
		$PiwikX->piwikActionName = (isset($piwikActionName)) ? $piwikActionName : '';
		$PiwikX->piwikJsName = (isset($piwikJsName)) ? $piwikJsName : 'piwik.js';
		$PiwikX->piwikGroupTrack = (isset($piwikGroupTrack)) ? explode(',', $piwikGroupTrack) : array();
		$PiwikX->piwikGroupExclude = (isset($piwikGroupExclude)) ? explode(',', $piwikGroupExclude) : array();
		$PiwikX->piwikUserTrack = (isset($piwikUserTrack)) ? explode(',', $piwikUserTrack) : array();
		$PiwikX->piwikUserExclude = (isset($piwikUserExclude)) ? explode(',', $piwikUserExclude) : array();

		$modx->regClientHTMLBlock($PiwikX->includeChunk());
		break;

	default :
		return ; // a plugin should return to MODx - this is very important.
		break;
}
?>
