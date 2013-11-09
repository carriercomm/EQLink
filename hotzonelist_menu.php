<?php
/**
 * Hot zone list
 */

if (!defined('e107_INIT')) { exit; }
require_once(e_PLUGIN."EQLink/includes/EQDb.php");
if(!$eqSql){
global $eqSql;
}
$text = '';
 if($eqSql->eqdb_Select("zone as zn join zone_levels as zl on zn.zoneidnumber = zl.zoneidnumber ","zn.long_name,zl.lowlevel,zl.highlevel","hotzone  = 1 ORDER BY zl.lowlevel ASC")){
    while($row = $eqSql->eqdb_Fetch()){
        $text .= "<tr><td>".$row['long_name']." <span class='smalltext'>(".$row['lowlevel']."-".$row['highlevel'].")</span></td></tr>";
    }
    $text = "<table> $text </table>";
    $ns->tablerender("Hotzones",$text);
 }

?>