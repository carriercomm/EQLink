<?php
/**
 * Update Zone_Level list
 */
require_once("../../class2.php");
if(!check_class(250)){die("Must be main admin");}

require_once("includes/EQDb.php");
global $eqSql;
$inserted = 0;
//start by getting a list of zones...
if(!$eqSql->eqdb_Select("zone","short_name,zoneidnumber")){
    die("Couldn't get zone list!");
}
while($zone = $eqSql->eqdb_Fetch()){
    $zones[$zone['zoneidnumber']] = $zone;
}

echo "<pre>";
//now  we loop through the zones
foreach($zones as $zone){
    echo "I'm in ".$zone['short_name']."\r\n";
    // Now we get a count of all the mobs grouped by level in the zone
    $query = "
                SELECT
                        nt.`level`,
                        count(nt.`level`) AS cnt
                FROM
                        spawn2 AS s2
                        JOIN spawnentry AS se ON s2.spawngroupID = se.spawngroupID
                        JOIN spawngroup AS sg ON sg.id = se.spawngroupID
                        JOIN npc_types AS nt ON nt.id = se.npcID
                WHERE
                        s2.zone LIKE '".$zone['short_name']."'
                        AND nt.isquest = 0
                        AND nt.race != 127
                        AND nt.race != 240
                        AND nt.class <= 20
                        AND nt.merchant_id = ''
                        AND nt.`name` NOT LIKE 'Trooper_%'
                        AND nt.`name` NOT LIKE 'Astral_Projection'
                        AND nt.`name` NOT LIKE 'Cursader_%'
                        AND nt.`name` NOT LIKE 'Professon_%'
                GROUP BY
                        `level`
                ORDER BY cnt DESC   
    ";
    if(!$eqSql->eqdb_Query($query,"UpdateZones Script")){
        die("Unable to get level count");
    }
    while($row = $eqSql->eqdb_Fetch()){
        $levels[] = $row;
    }
    
    //okay now we go through and figure out which mobs are the hunting mobs
    //we're gonna take the highest count and subtract 20 from it... if the count for any level is less than that it's not worth being in that zone
    foreach($levels as $level){
        //echo "Level = ".$level['level']." Count = ".$level['cnt'];
        if($level['cnt'] > ($levels[0]['cnt']-($levels[0]['cnt'] / 1.5))){
            //echo "(Meets min count criteria)";
            $actLevel[$level['level']] = $level;
        }
        //echo "\r\n";
    }
    $highLevel = max(array_keys($actLevel));
    $lowLevel = min(array_keys($actLevel));
    $zoneData = json_encode($levels);
    
    $args = array(
        "zoneidnumber"=>$zone['zoneidnumber'],
        "lowlevel" => $lowLevel,
        "highlevel" => $highLevel,
        "zonedata" => $zoneData
    );
    $update = implode(', ', array_map(function ($v, $k) { return "`$k`='$v'"; }, $args, array_keys($args)));
    $update .= " WHERE `zoneidnumber` = ".$zone['zoneidnumber'];
    if(isset($highLevel) && $highLevel != 0){
        $eqSql->eqdb_Update("zone_levels",$update,'now');
            //die("Failed inserting data for:".$zone['short_name']);
        
    }
    echo "Inserted data for ".$zone['short_name']."\r\n";
    $inserted++;
    //echo "(".$zone['short_name'].") $lowLevel - $highLevel Data: \r\n ";
    //echo print_r($levels,true)."\r\n";
    //echo "___________________________________________\r\n";
    //echo print_r($actLevel,true)."";
    
    unset($levels,$zoneData,$level,$actLevel);

}
echo "Updated $inserted Zones";
echo "</pre>";
?>