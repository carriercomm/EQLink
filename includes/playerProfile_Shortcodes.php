<?php
if (!defined('e107_INIT')) { exit; }
include_once(e_HANDLER.'shortcode_handler.php');
$playerProfile_shortcodes = $tp -> e_sc -> parse_scbatch(__FILE__);
/*
SC_BEGIN CHARACTER
global $character;
return $character->getvalue($parm);
SC_END

SC_BEGIN STAT
    global $character;
    return $character->calcStat($parm);
SC_END

SC_BEGIN RACE
global $character,$EQRaceNames;
return $EQRaceNames[$character->getvalue("race")];
SC_END

SC_BEGIN CLASS
global $character,$EQClasses;
return $EQClasses[$character->getvalue("class")];
SC_END

SC_BEGIN DEITY
global $character,$EQDeityNames;
return $EQDeityNames[$character->getvalue("deity")];
SC_END

SC_BEGIN INVENTORY
global $character;
$item = $character->getvalue("inventory",$parm);
if(!$item){
    return;
}
$text = '<div onclick="display(0, '.$parm.', \'slot\');if (false) display(0, '.$parm.', \'bag\');" class="Slot slotloc'.$parm.'" style="background-image: url('.(file_exists(e_PLUGIN.'EQLink/images/profile/items/item_'.$item['icon'].'.png')  ? e_PLUGIN.'EQLink/images/profile/items/item_'.$item['icon'].'.png' : e_PLUGIN.'EQLink/images/profile/items/item_.png').');"></div>';
return $text;
SC_END
*/
?>