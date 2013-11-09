<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/forum/search/search_parser.php $
|     $Revision: 11678 $
|     $Id: search_parser.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }
//We have to set up our own search class b/c we use a seperate DB
require_once(e_PLUGIN."EQLink/includes/search_class.php");
require_once(e_PLUGIN."EQLink/includes/common.php");
//echo "Search: ".$_GET['in'];
$eqsch = new eq_search;
// advanced
$advanced_where = "";
if (isset($_GET['players']) && is_numeric($_GET['players'])) {
	$advanced_where .= " chr.`name` LIKE '".$_GET['q']."' AND";
	
}
$where = " chr.`name` LIKE '%".$_GET['q']."%' AND";
$search_fields = array('chr.`name`');
// basic
$return_fields = 'chr.`id`,chr.`name`,chr.`level`,chr.class';
$weights = array('1.2');
$no_results = LAN_198;

$order = array('chr.`name`' => 'ASC');
$table = "character_ as chr";

$ps = $eqsch -> parsesearch($table, $return_fields, $search_fields, $weights, 'search_players', $no_results, $where, $order);
$text .= $ps['text'];
$results = $ps['results'];

function search_players($row) {
	global $con,$EQClasses;
	$name = $row['name'];
	$level = $row['level'];
	$class = $EQClasses[$row['class']];	

	$link_id = $row['id'];

	$res['link'] = e_PLUGIN."EQLink/player.php?".$link_id;
	$res['pre_title'] = "";
	$res['title'] = $name ;
	$res['pre_summary'] = "<div class='smalltext' style='padding: 2px 0px'><a href='".e_PLUGIN."EQLink/characters.php'>Players</a> -> <a href='".e_PLUGIN."character.php?".$row['id']."'>".$row['name']."</a></div>";
	$res['summary'] = "$name Level $level $class";
	$res['detail'] = "";
	return $res;
}

?>