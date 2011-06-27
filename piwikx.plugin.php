<?php 
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage modx_plugin
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6a <17.05.2010>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * @internal    @description: <strong>0.6.6a</strong> integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 * @internal    @plugin code: include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.plugin.php');
 * @internal    @MODx event: OnParseDocument
 */

$piwikURL = (isset($piwikURL)) ? $piwikURL : '';
$piwikSiteId = (isset($piwikSiteId)) ? $piwikSiteId : 0;

if (!isset($modx))
    die();
    
// invoke module
$class_file = MODX_BASE_PATH.'assets/modules/piwikx/piwikx.class.php';
if (!file_exists($class_file))
    $modx->messageQuit(sprintf('Classfile "%s" not found. Did you upload the module files?', $class_file));
require_once ($class_file);

// MODx event handling
$e = &$modx->Event;
switch ($e->name) {
    case "OnParseDocument":
        $piwikx_lang = array();
        $PiwikX = new PiwikX($piwikURL, $piwikSiteId, $piwikx_lang);
        
        $PiwikX->piwikUsername = (isset($piwikUsername)) ? $piwikUsername:
            '';
            $PiwikX->piwikPassword = (isset($piwikPassword)) ? $piwikPassword:
                '';
                $PiwikX->piwikActionName = (isset($piwikActionName)) ? $piwikActionName:
                    '';
                    $PiwikX->piwikJsName = (isset($piwikJsName)) ? $piwikJsName:
                        'piwik.js';
                        $PiwikX->piwikGroupTrack = (isset($piwikGroupTrack)) ? explode(',', $piwikGroupTrack):
                            array();
                            $PiwikX->piwikGroupExclude = (isset($piwikGroupExclude)) ? explode(',', $piwikGroupExclude):
                                array();
                                $PiwikX->piwikUserTrack = (isset($piwikUserTrack)) ? explode(',', $piwikUserTrack):
                                    array();
                                    $PiwikX->piwikUserExclude = (isset($piwikUserExclude)) ? explode(',', $piwikUserExclude):
                                        array();
                                        
                                        $includeChunk = $PiwikX->includeChunk();
                                        $modx->regClientHTMLBlock($includeChunk);
                                        break;
                                        
                                    default:
                                        return; // stop here - this is very important.
                                        break;
                                }
                                
?>
