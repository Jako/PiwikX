<?php
/*
 * Integrate <a href='http://www.piwik.org'>Piwik</a> statistics into your site
 *
 * @package PiwikX
 * @subpackage german_managerwidgets
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.7.1
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$piwikWidgets['LastVisitsGraph'] = array(
	'position'          => 'left',
	'title'             => 'Grafik der letzten Benutzer',
	'height'            => '240',
	'module'            => 'Widgetize',
	'action'            => 'iframe',
	'columns'           => 'nb_visits',
	'moduleToWidgetize' => 'VisitsSummary',
	'actionToWidgetize' => 'getEvolutionGraph',
	'period'            => 'day',
	'date'              => 'yesterday'
);
$piwikWidgets['Actions'] = array(
	'position'          => 'right',
	'title'             => 'Seitenaufrufe im letzten Monat',
	'height'            => '240',
	'module'            => 'Widgetize',
	'action'            => 'iframe',
	'columns'           => '',
	'moduleToWidgetize' => 'Actions',
	'actionToWidgetize' => 'getPageTitles',
	'period'            => 'month',
	'date'              => 'yesterday'
);
$piwikWidgets['Sparklines'] = array(
	'position'          => 'left',
	'title'             => 'Benutzerübersicht',
	'height'            => '420',
	'module'            => 'Widgetize',
	'action'            => 'iframe',
	'columns'           => '',
	'moduleToWidgetize' => 'VisitsSummary',
	'actionToWidgetize' => 'getSparklines',
	'period'            => 'day',
	'date'              => 'yesterday'
);
$piwikWidgets['Keywords'] = array(
	'position'          => 'right',
	'title'             => 'Suchbegriffe im letzten Monat',
	'height'            => '420',
	'module'            => 'Widgetize',
	'action'            => 'iframe',
	'columns'           => '',
	'moduleToWidgetize' => 'Referers',
	'actionToWidgetize' => 'getKeywords',
	'period'            => 'month',
	'date'              => 'yesterday'
);
?>
