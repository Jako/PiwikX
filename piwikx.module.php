<?php 
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage modx_module
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6b <31.06.2011>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @internal    @description: <strong>0.6.6a</strong> integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 * @internal    @module code: include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.module.php');
 */

if (IN_MANAGER_MODE != 'true') {
    die('<h1>ERROR:</h1><p>Please use the MODx Content Manager instead of accessing this file directly.</p>');
}
    
$piwikURL = (isset($piwikURL)) ? $piwikURL : '';
$piwikSiteId = (isset($piwikSiteId)) ? $piwikSiteId : 0;

// manager language setting
$language = $modx->config['manager_language'];

// individual user language setting (if set)
$query = 'SELECT setting_name, setting_value FROM '.$modx->getFullTableName('user_settings').' WHERE setting_name=\'manager_language\' AND user='.$modx->getLoginUserID();
$records = $modx->db->query($query);
if ($modx->db->getRecordCount($records) > 0) {
    $record = $modx->db->getRow($records);
    $language = $record['setting_value'];
    $language = ($record['setting_value'] != '') ? $record['setting_value'] : $language;
}

// load classfile
$class_file = MODX_BASE_PATH.'assets/modules/piwikx/piwikx.class.php';
if (!file_exists($class_file))
    $modx->messageQuit(sprintf('Classfile "%s" not found. Did you upload the module files?', $class_file));
require_once ($class_file);

// load localization
$piwikx_lang = array();
include_once MODX_BASE_PATH.'assets/modules/piwikx/lang/english.inc.php';

if ($language != 'english') {
    $lang_file = MODX_BASE_PATH.'assets/modules/piwikx/lang/'.$language.'.inc.php';
    if (file_exists($lang_file)) {
        include_once $lang_file;
    }
}

// invoke module
$PiwikX = new PiwikX($piwikURL, $piwikSiteId, $piwikx_lang);

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
