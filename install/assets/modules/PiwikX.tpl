<?php
/**
 * PiwikX
 *
 * Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 *
 * @category  module
 * @version   0.7
 * @license   http://www.gnu.org/copyleft/gpl.html GNU Public License (GPL)
 * @internal  @properties
 * @internal  @guid 3ddb9d55c99a558834f845f8cbb41d9b
 * @internal  @shareparams 1
 * @internal  @dependencies plugin:PiwikX
 * @internal  @properties &piwikURL=URL to your Piwik installation;text;http://your.piwik.installation &piwikSiteId=Piwik Site ID;text;1 &piwikUsername=Username to display the Piwik widgets;text; &piwikPassword=md5 encrypted password to display the Piwik widgets;text; &piwikTokenAuth=authentification token;text; &piwikActionName=TV containing the tracking title;text; &piwikJsName=Name of Javascript;text;piwik.js &piwikDownloadExtensions=List of files extensions to track as downloads (comma separated);text; &piwikHostsAlias=Consider a host an alias host (comma separated);text;			 &piwikTrackerPause=Pause timer for outlinks and downloads;text; &piwikInstallTracker=Disable download and outlink tracking;text; &piwikUserTrack=Webusers to track (comma separated);text; &piwikUserExclude=Webusers not to track (comma separated list);text; &piwikGroupTrack=Webgroups to track (comma separated);text; &piwikGroupExclude=Webgroups not to track (comma separated);text;
 * @internal  @modx_category Statistics
 * @author    Jako
 */

include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.module.php');