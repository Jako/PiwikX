<?php
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage german_language
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6a <17.05.2010>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$piwikx_lang = array ( );

//PiwikX language strings.
$piwikx_lang ['languagefile'] = 'german';
$piwikx_lang ['modulename'] = 'PiwikX';
$piwikx_lang ['moduledesc'] = 'Seitenstatistik aus Piwik';
$piwikx_lang ['modulereload'] = 'Neu laden';
$piwikx_lang ['moduleclose'] = 'Modul schließen';
$piwikx_lang ['modulenoconfigtitle'] = ' – Unkonfiguriert';
$piwikx_lang ['modulenoconfigtext'] = <<<HTML
<p>Das Modul ist noch nicht konfiguriert. Bitte fügen Sie folgenden Text in die Modul Konfiguration ein und passen Sie anschließend die Parameter an Ihre Piwik Installation an.</p>
<pre style="font-size: 1.2em">
/* Minimale Konfiguration
&piwikURL=URL Ihrer Piwik-Installation;text;http://ihre.piwik.installation
&piwikSiteId=Piwik Site ID;text;1
&piwikUsername=Username für Piwik Widgets;text;
&piwikPassword=md5-verschlüsseltes Passwort für Piwik Widgets;text;
*/

/* Vollständige Konfiguration
&piwikURL=URL Ihrer Piwik-Installation;text;http://ihre.piwik.installation
&piwikSiteId=Piwik Site ID;text;1
&piwikUsername=Username für Piwik Widgets;text;
&piwikPassword=md5-verschlüsseltes Passwort für Piwik Widgets;text;
&piwikTokenAuth=Authentifizierungs Token (ungenutzt);text;
&piwikActionName=Template- oder Dokumentvariable mit dem Tracking-Titel;text;
&piwikJsName=Name des Javascript;text;
&piwikDownloadExtensions=Liste der Dateiendungen welche als Download angesehen werden (kommaseparierte Liste);text;
&piwikHostsAlias=Aliase für diesen Host (kommaseparierte Liste);text;			
&piwikTrackerPause=Pausen-Timer für Outlinks und Downloads;text;
&piwikInstallTracker=Download- und Outlink-Tracking deaktivieren;text;
&piwikUserTrack=Benutzer tracken (kommaseparierte Liste);text;
&piwikUserExclude=Benutzer nicht tracken (kommaseparierte Liste);text;admin
&piwikGroupTrack=Benutzergruppe tracken (kommaseparierte Liste);text;
&piwikGroupExclude=Benutzergruppe nicht tracken (kommaseparierte Liste);text;
*/
</pre>
HTML;
$piwikx_lang ['noclassname'] = 'Bitte laden Sie die Dateien des Moduls auf den Server.';
$piwikx_lang ['moduleshowfullstat'] = 'Gesamtstatistik anzeigen';
?>