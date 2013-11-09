<?php
/* $Id: e_search.php 11346 2010-02-17 18:56:14Z secretr $ */
if (!defined('e107_INIT')) { exit(); }

include_lan(e_PLUGIN."forum/languages/".e_LANGUAGE."/lan_forum_search.php");

$search_info[] = array(
	'sfile' => e_PLUGIN.'EQLink/search/search_parser.php', 
	'qtype' => "Players", 
	'refpage' => 'players', 
	'advanced' => e_PLUGIN.'EQLink/search/search_advanced.php', 
	'id' => 'players'
	);

?>