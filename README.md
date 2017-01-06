#THIS PROJECT IS DEPRECATED

PiwikX is not maintained anymore. It maybe does not work in Evolution 1.1 anymore. Please fork it and bring it back to life, if you need it.

PiwikX
================================================================================

Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
for the MODX Evolution content management framework

Features:
--------------------------------------------------------------------------------

The MODx module displays a few configurable Piwik widgets in the MODx backend. The corresponding plugin inserts the suitable code for Piwik at the end of the html code generated by MODx. Base of the module/plugin is a **separate** installation of Piwik. 

Installation:
--------------------------------------------------------------------------------
1. Upload the folder *assets/modules/piwikx* in the corresponding folder in your installation.
2. Create a new plugin called PiwikX with the following plugin code
    `include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.plugin.php');`
3. Create a new module called PiwikX with the following module code
    `include(MODX_BASE_PATH.'assets/modules/piwikx/piwikx.module.php');`


Configuration:
--------------------------------------------------------------------------------

The module can be called after reloading the MODx manager. Since the module is not yet configured, a summary page with the minimal and the complete configuration will be displayed. One of these configurations must be inserted in the module configuration and the settings have to filled according to the corresponding Piwik installation.

Setting           | Description
----------------- | -----------
piwikURL          | The url of the Piwik installation
piwikSiteId       | The ID of the website inside of piwik (Menu -> Settings -> Websites).
piwikUsername     | The name of a new user inside of piwik (Menu -> Settings -> Users). This user has to get viewing access for the website to track. Caution: This user cannot be the piwik super user.
piwikPassword     | The md5 encrypted password of this user (Menu -> Settings -> Users).
piwikActionName   | The name of a template variable. The content of this variable will be parsed (contained snippet calls will be executed and document or template variables will be replaced – snippets have to be called cached und template variables should be called as in page templates) and used as tracking title for Piwik. If this option is not set, the pagetitle will be used as tracking title.
piwikUserExclude  | A comma-separated list of user names. These users will be excluded from piwik tracking if they are logged into the MODx frontend or backend.
piwikGroupExclude | A comma-separated list of web groups. User belonging to these groups will be excluded from piwik tracking if they are logged into the MODx frontend or backend.

#### Module Dependencies:

After that you have to enable parameter sharing in the module configuration and add the PiwikX plugin in the dependencies of the module.

The module should display now a few Piwik widgets in the MODx backend. The configuration of these widgets could be modified in the file 
<language>.managerwidgets.php – a howto for modifications in this file is written in the german documentation on http://www.partout.info/piwik_modx.html.

#### Plugin Dependencies:

If you want to insert the Piwik Tracking code on each page you should activate the Plugin of this package. First you have to select PiwikX in *import module shared parameters* of the PiwikX plugin configuration (if you cannot select PiwikX there you have to enable parameter sharing in the PiwikX module) and activate OnLoadWebDocument as system event for the plugin.

Widget configuration
--------------------------------------------------------------------------------

The PiwikX Module displays a few default widgets in the MODX Backend. You could change these widgets in the file **lang/&lt;language&gt;.managerwidgets.php**. &lt;language&gt; is the language of the MODX backend (defaults to english).

You could get the informations for *moduleToWidgetize* and *actionToWidgetize* easily if you log into the Piwik backend and create a new Widget (Menu -> Widgets). In the generated iframe code the two values could be found. The following example shows a widget for the 'Length of visits in the last month':

```
$piwikWidgets ['Dauer'] = array (
'position' => 'left',
'title' => 'Length of visits in the last month',
'height' => '100',
'module' => 'Widgetize',
'action' => 'iframe',
'columns' => 'nb_visits',
'moduleToWidgetize' => 'VisitorInterest',
'actionToWidgetize' => 'getNumberOfVisitsPerVisitDuration',
'period' => 'month', 
'date' => 'today' );
```

The parameter *period* could be set i.e. to year, month, week oder day. The parameter *date* i.e. to today and yesterday. Other possible values are described in the [Piwik API reference](https://piwik.org/docs/analytics-api/reference/).
