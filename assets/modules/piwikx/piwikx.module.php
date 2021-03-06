<?php
/*
 * Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 *
 * @package PiwikX
 * @subpackage modx_module
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.7.1
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @internal    @description: <strong>0.7.1</strong> Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 * @internal    @module code: include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.module.php');
 */

if (IN_MANAGER_MODE != 'true') {
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

// manager language setting
$language = $modx->config['manager_language'];

// individual user language setting (if set)
$query = 'SELECT setting_name, setting_value FROM ' . $modx->getFullTableName('user_settings') . ' WHERE setting_name=\'manager_language\' AND user=' . $modx->getLoginUserID();
$records = $modx->db->query($query);
if ($modx->db->getRecordCount($records) > 0) {
	$record = $modx->db->getRow($records);
	$language = $record['setting_value'];
	$language = ($record['setting_value'] != '') ? $record['setting_value'] : $language;
}

// load classfile
$class_file = PWK_BASE_PATH . 'piwikx.class.php';
if (!file_exists($class_file))
	$modx->messageQuit(sprintf('Classfile "%s" not found. Did you upload the module files?', $class_file));
require_once ($class_file);

// load localization
$piwikx_lang = array();
include_once PWK_BASE_PATH . 'lang/english.inc.php';

if ($language != 'english') {
	$lang_file = PWK_BASE_PATH . 'lang/' . $language . '.inc.php';
	if (file_exists($lang_file)) {
		include_once $lang_file;
	}
}
$options['piwikLang'] = $piwikx_lang;

// run module
$PiwikX = new PiwikX($modx, $options);

$PiwikX->piwikUsername = (isset($piwikUsername)) ? $piwikUsername : '';
$PiwikX->piwikPassword = (isset($piwikPassword)) ? $piwikPassword : '';
$PiwikX->piwikTokenAuth = (isset($piwikTokenAuth)) ? $piwikTokenAuth : '';
$PiwikX->piwikActionName = (isset($piwikActionName)) ? $piwikActionName : '';
$PiwikX->piwikJsName = (isset($piwikJsName)) ? $piwikJsName : 'piwik.js';
$PiwikX->piwikGroupTrack = (isset($piwikGroupTrack)) ? explode(',', $piwikGroupTrack) : array();
$PiwikX->piwikGroupExclude = (isset($piwikGroupExclude)) ? explode(',', $piwikGroupExclude) : array();
$PiwikX->piwikUserTrack = (isset($piwikUserTrack)) ? explode(',', $piwikUserTrack) : array();
$PiwikX->piwikUserExclude = (isset($piwikUserExclude)) ? explode(',', $piwikUserExclude) : array();
echo $PiwikX->displayModule();
return;
?>
