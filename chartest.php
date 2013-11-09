<?php
/**
 * Character test
 */

require_once("../../class2.php");
$eplug_css[] = e_PLUGIN."EQLink/includes/playerprofile.css";
require_once(HEADERF);
 if(!check_class(253)){//Only members have access to this feature
    $text = "Only members have access to this feature";
    $ns->tablerender("Error!",$text);
    require(FOOTERF);
    die();
}
require_once("includes/common_functions.php");
require_once("includes/EQDb.php");
include_once(e_PLUGIN.'/EQLink/includes/common.php');
global $eqSql;
global $EQClasses;
include_once(e_PLUGIN.'/EQLink/includes/profile.php');

if(e_QUERY){
    $tmp = explode(".",e_QUERY);
    foreach($tmp as $a){
        $tmp1 = explode(":",$a);
        switch($tmp1[0]){
            case  'name':
                $name = $tp->toDB($tmp1[1]);
                break;
            case 'id':
                $id = $tp->toDB($tmp1[1]);
                break;
            default:
                break;
        }
    }
}


if(!$id && !$name){
    $text = "No character selected! Please go back and try again!!";
}
$character = new profile($id);

require_once(e_PLUGIN.'EQLink/includes/playerProfile_Shortcodes.php');
require_once (e_PLUGIN.'EQLink/templates/playerProfileTemplate.php');
if((!$character->getvalue('anon') == 1 || $pref['EQLink']['inv::showAnon']) && (!$character->getvalue('anon') == 2 || $pref['EQLink']['inv::showRP']) || check_class($pref['EQLink']['chr::gmclass'])){
    $text = ($character->getvalue("status") >0 ? $tp->parseTemplate($player_inventory_gm_start,true,$playerProfile_shortcodes) : $tp->parseTemplate($player_inventory_start,true,$playerProfile_shortcodes));
    $text .= $tp->parseTemplate($player_inventory_stat2,true,$playerProfile_shortcodes);
    $text .= $tp->parseTemplate($player_inventory_stat,true,$playerProfile_shortcodes);
    $text .= $tp->parseTemplate($player_inventory_main,true,$playerProfile_shortcodes);
    //show the inventory... Check if the char is an admin, or if show admin inventory is on, or if the user is a gm on the forums
    if(!$character->getvalue("status") > 0 || $pref['EQLink']['inv::showAdmin'] || check_class($pref['EQLink']['chr::gmclass'])){
        for($i=0;$i<=29;$i++){
            $text .= $tp->parseTemplate("{INVENTORY=$i}",true,$playerProfile_shortcodes);
        }
    }
    //$text .= $tp->parseTemplate("{INVENTORY=0}",true,$playerProfile_shortcodes);
    $text .= $tp->parseTemplate($player_inventory_end,true,$playerProfile_shortcodes);
}else{
    //not allowed to view
    $text = "Privacy settings are preventing you from viewing this characters profile.";
}
$ns->tablerender($character->getvalue("character_name")."'s Profile","<table><tr>$text</tr></table>");
require_once(FOOTERF);

?>