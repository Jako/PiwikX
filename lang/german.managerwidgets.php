<?php
/*
 * PiwikX simply integrates the <a href='http://www.piwik.org'>Piwik</a> statistic on your site.
 *
 * @package PiwikX
 * @subpackage german_managerwidgets
 * @link http://www.partout.info/piwik_modx.html
 *
 * @version 0.6.6b <31.07.2011>
 * @author Thomas Jakobi <thomas.jakobi@partout.info>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

$piwikWidgets ['LastVisitsGraph'] = array (
    'position'          => 'left',
    'title'             => 'Grafik der letzten Benutzer',
    'height'            => '200',
    'module'            => 'Widgetize',
    'action'            => 'iframe',
    'columns'           => 'nb_visits',
    'moduleToWidgetize' => 'VisitsSummary',
    'actionToWidgetize' => 'getEvolutionGraph',
    'period'            => 'day', 
    'date'              => 'today' );
$piwikWidgets ['Actions'] = array (
    'position'          => 'right',
    'title'             => 'Seitenaufrufe im letzten Monat',
    'height'            => '250',
    'module'            => 'Widgetize',
    'action'            => 'iframe',
    'columns'           => '',
    'moduleToWidgetize' => 'Actions',
    'actionToWidgetize' => 'getPageTitles',
    'period'            => 'month', 
    'date'              => 'today' );
$piwikWidgets ['Sparklines'] = array (
    'position'          => 'left',
    'title'             => 'Benutzerübersicht',
    'height'            => '300',
    'module'            => 'Widgetize',
    'action'            => 'iframe',
    'columns'           => '',
    'moduleToWidgetize' => 'VisitsSummary',
    'actionToWidgetize' => 'getSparklines',
    'period'            => 'day', 
    'date'              => 'today' );
$piwikWidgets ['Keywords'] = array (
    'position'          => 'right',
    'title'             => 'Suchbegriffe im letzten Monat',
    'height'            => '250',
    'module'            => 'Widgetize',
    'action'            => 'iframe',
    'columns'           => '',
    'moduleToWidgetize' => 'Referers',
    'actionToWidgetize' => 'getKeywords',
    'period'            => 'month', 
    'date'              => 'today' );
?>
