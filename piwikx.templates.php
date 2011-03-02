<?php
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage templates
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6a <17.05.2010>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$piwikModuleTemplate = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="media/style[+ManagerTheme+]/style.css" />
<title>[+LangModuleName+]</title>
<style type="text/css">
.widgetleft { margin: 0 10px 10px 0 !important; margin-bottom: 0; border: 1px solid #ccc; padding: 5px; width: auto }
.widgetright { margin: 0 0 10px 0 !important; margin-bottom: 0; border: 1px solid #ccc; padding: 5px; width: auto }
.widgetouterleft { width: 50%; float: left}
.widgetouterright { width: 50%; float: right }
.sectionBody { background: #fff; padding-bottom: 0 }
</style>
<script type="text/javascript">function postForm(opcode){document.module.opcode.value=opcode;document.module.submit()}</script>
</head>
<body>
<h1>[+LangModuleName+]</h1>
<div id="actions">
<ul class="actionButtons">
<li id="Button1">
<a href="#" onclick="window.location.reload();return false;"><img src="media/style[+ManagerTheme+]/images/icons/refresh.png" alt="" /> [+LangModuleReload+]</a>
</li>
<li id="Button2">
<a href="[+piwikURL+]/index.php" target="_new"><img src="media/style[+ManagerTheme+]/images/icons/layout_go.png" alt="" /> [+LangModuleShowFullStat+]</a>
</li>
<li id="Button3">
<a href="#" onclick="document.location.href='index.php?a=106';"><img src="media/style[+ManagerTheme+]/images/icons/stop.png" alt="" /> [+LangModuleClose+]</a>
</li>
</ul>
</div>
<div class="sectionHeader">[+LangModuleDesc+]</div>
<div class="sectionBody">
[+piwikManagerWidgets+]	
<div style="clear: both"></div>
</div>
</body>
</html>
HTML;

$piwikNoConfigTemplate = <<<HTML
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="media/style[+ManagerTheme+]/style.css" />
<title>[+LangModuleName+][+LangModuleNoConfigName+]</title>
<style>
.sectionBody { background: #fff; padding-bottom: 0 }
</style>
<script type="text/javascript">function postForm(opcode){document.module.opcode.value=opcode;document.module.submit()}</script>
</head>
<body>
<h1>[+LangModuleName+][+LangModuleNoConfigName+]</h1>
<div id="actions">
<ul class="actionButtons">
<li id="Button3">
<a href="#" onclick="document.location.href='index.php?a=106';"><img src="media/style[+ManagerTheme+]/images/icons/stop.png" alt="" /> [+LangModuleClose+]</a>
</li>
</ul>
</div>
<div class="sectionHeader">[+LangModuleDesc+]</div>
<div class="sectionBody">
[+LangModuleNoConfigText+]
</div>
</body>
</html>
HTML;

$piwikWidgetTemplate = <<<HTML
<div class="widgetouter[+position+]">
<div class="widget[+position+]">
<h3>[+title+]</h3>
<iframe style="width: 100% !important; width: 94%; height: [+height+]px"
  src="[+piwikURL+]/index.php?module=[+module+]&amp;action=[+action+][+columns:ne=``:then=`&amp;columns[]=[+columns+]`+]&amp;moduleToWidgetize=[+moduleToWidgetize+]&amp;actionToWidgetize=[+actionToWidgetize+]&amp;idSite=[+piwikSiteId+]&amp;period=[+period+]&amp;date=[+date+]&amp;disableLink=1"
	scrolling="auto" frameborder="0" marginheight="0" marginwidth="0"></iframe></div>
</div>
HTML;

$piwikChunkTemplate = <<<HTML
<div class="piwik">
<!-- Piwik -->
<script type="text/javascript">
var pkBaseURL = (("https:" == document.location.protocol) ? "https://[+piwikURL+]/" : "http://[+piwikURL+]/");
document.write(unescape("%3Cscript src='" + pkBaseURL + "[+piwikJsName+]' type='text/javascript'%3E%3C/script%3E"));
</script><script type="text/javascript">
try {
var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", [+piwikSiteID+]);
piwikTracker.setDocumentTitle("[+piwikDocumentTitle+]");
[+piwikParams+]piwikTracker.trackPageView();
} catch( err ) {}
</script><noscript><p><img src="http://[+piwikURL+]/piwik.php?idsite=[+piwikSiteID+]" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tag -->
</div>
HTML;
?>
