<?php
/*
 * Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 *
 * @package PiwikX
 * @subpackage english_language
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.7.1
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$piwikx_lang = array();

//PiwikX language strings.
$piwikx_lang ['languagefile'] = 'english';
$piwikx_lang ['modulename'] = 'PiwikX';
$piwikx_lang ['moduledesc'] = 'Web analytics by Piwik';
$piwikx_lang ['modulereload'] = 'Reload';
$piwikx_lang ['moduleclose'] = 'Close';
$piwikx_lang ['modulenoconfigtitle'] = ' – not configured';
$piwikx_lang ['modulenoconfigtext'] = <<<HTML
<p>The module is not yet configured. Please copy the following text to your module configuration and change the parameters according your Piwik installation..</p>
<pre style="font-size: 1.2em">
/* minimal configuration
&piwikURL=URL to your Piwik installation;text;http://your.piwik.installation
&piwikSiteId=Piwik Site ID;text;1
&piwikUsername=Username to display the Piwik widgets;text;
&piwikPassword=md5 encrypted password to display the Piwik widgets;text;
*/

/* complete configuration
&piwikURL=URL to your Piwik installation;text;http://your.piwik.installation
&piwikSiteId=Piwik Site ID;text;1
&piwikUsername=Username to display the Piwik widgets;text;
&piwikPassword=md5 encrypted password to display the Piwik widgets;text;
&piwikTokenAuth=authentification token;text;
&piwikActionName=TV containing the tracking title;text;
&piwikJsName=Name of Javascript;text;piwik.js
&piwikDownloadExtensions=List of files extensions to track as downloads (comma separated);text;
&piwikHostsAlias=Consider a host an alias host (comma separated);text;			
&piwikTrackerPause=Pause timer for outlinks and downloads;text;
&piwikInstallTracker=Disable download and outlink tracking;text;
&piwikUserTrack=Webusers to track (comma separated);text;
&piwikUserExclude=Webusers not to track (comma separated list);text;
&piwikGroupTrack=Webgroups to track (comma separated);text;
&piwikGroupExclude=Webgroups not to track (comma separated);text;
*/
</pre>
HTML;
$piwikx_lang ['noclassname'] = 'Please upload the module files.';
$piwikx_lang ['moduleshowfullstat'] = 'Show full stats';
?>