<?php
require_once('../../class2.php');
global $pref;
/***
 *Zone list/display
 */
$from = 0;
$limit = $pref['EQLink']['plyr::maxpage'];

if(e_QUERY){
    $tmp = explode(".",e_QUERY);
    foreach($tmp as $a){
        $tmp1 = explode(":",$a);
        switch($tmp1[0]){
            case 'sort':
                $qsort = $a;
                if($tmp1[1] == 'level'){
                    $levelsort = true;
                    $field = "lowlevel ".$tp->toDB($tmp1[2]).", highlevel";// have to do dual sort for level b/c it's in two seperate fields.
                }else{
                    $field = $tp->toDB($tmp1[1]);
                }
                $sort = $tp->toDB($tmp1[2]);
                break;
            case  'from':
                $from = $tp->toDB($tmp1[1]);
                break;
            case 'id':
                $id = $tp->toDB($tmp1[1]);
                break;
            case 'limit':
                
                $limit = $tp->toDB($tmp1[1]);
                $limit = (in_array($limit,array(10,20,30,40,50)) ? $limit : $pref['EQLink']['plyr::maxpage']); // only allow upto 50 results multiples of 10's ;)
                break;
            case 'ln':
                $qlongname = $tp->toDB($tmp1[1]);
                break;
            case 'sn':
                $qshortname = $tp->toDB($tmp1[1]);
                break;
            case 'filter':
                if($tmp1 != 'all'){
                    $levelfilter = $tp->toDB($tmp1[1]);
                    $filter = "lowlevel >= ".intval($tmp1[1])." AND highlevel <= ".(intval($tmp1[1])+10);
                }else{
                    $levelfilter = 'all';
                }
                break;
            default:
                break;
        }
    }
}

  if(isset($_POST['eqzonefilterlevel'])){
    if($_POST['eqzonefilterlevel'] != 'all'){
    $levelfilter = $tp->toDB($_POST['eqzonefilterlevel']);
    $filter = "lowlevel >= ".intval($_POST['eqzonefilterlevel'])." AND highlevel <= ".(intval($_POST['eqzonefilterlevel'])+10);
    }else{
        $levelfilter  = 'all';
    }
}
if(isset($_POST['limit'])){
    $limit = intval($_POST['limit']);
    $limit = (in_array($limit,array(10,20,30,40,50)) ? $limit : $pref['EQLink']['plyr::maxpage']); // only allow upto 50 results multiples of 10's ;)
}  

require_once(e_PLUGIN."EQLink/includes/EQDb.php");
require_once(e_PLUGIN."EQLink/includes/common.php");

global $eqSql,$EQExpansions;
require_once(HEADERF);
//Get the zone list
    //get the zone count (for pages)
    $eqSql->eqdb_Select("zone as z JOIN zone_levels as zl on zl.zoneidnumber = z.zoneidnumber","count(*) as cnt",(isset($filter) ? $filter : "1"));
    $res = $eqSql->eqdb_Fetch();
    $zone_count = $res['cnt'];
    $table = "zone as z JOIN zone_levels as zl on zl.zoneidnumber = z.zoneidnumber";
    $where = (isset($filter) ? $filter : "1");
    $where .= (isset($sort) ? " ORDER BY $field $sort":"");
    $where .= " LIMIT $from,$limit";
    if(!$eqSql->eqdb_Select($table,"*",$where)){
        $ns->tablerender("Error: ","There was an error selecting zones!");
        require_once(FOOTERF);
        die();
    }
    $text = '';
    $query = e_SELF.'?'.(isset($id)? "id:$id":"").(isset($limit) ? ".limit:$limit":"").(isset($from) ? ".from:$from":"").(isset($filterq) ? ".filter:$filterf:$filterq":"");
     $header = "<tr>
                        <th class='fcaption' style='width:30%;height:20px;'><a href='".$query.".sort:long_name:".($field == 'long_name' && $sort == 'ASC' ? 'DESC':'ASC')."'>Zone  <img src='images/".($field == 'long_name'  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a></th>
                        <th class='fcaption' style='width:10%;height:20px;'><a href='".$query.".sort:short_name:".($field == 'short_name' && $sort == 'ASC' ? 'DESC':'ASC')."'>Short Name  <img src='images/".($field == 'short_name'  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a></th>
                        <th class='fcaption' style='width:30%;height:20px;'><a href='".$query.".sort:level:".($levelsort && $sort == 'ASC' ? 'DESC':'ASC')."'>Levels  <img src='images/".($levelsort  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a></th>
                        <th class='fcaption' style='width:30%;height:20px;'><a href='".$query.".sort:expansion:".($field == 'expansion' && $sort == 'ASC' ? 'DESC':'ASC')."'>Expansion  <img src='images/".($field == 'expansion'  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a>
                        <span style='float:right'><a href='".e_SELF.'?'.(isset($id)? "id:$id":"").(isset($limit)? ".limit:$limit":"").(isset($levelfilter) ? ".filter:$levelfilter":"").".from:$from'>Clear Sort</a></th>
                        
                    </tr>";
    while($row = $eqSql->eqdb_Fetch()){
        $zone_id = $row['zoneidnumber'];
        $long_name = $row['long_name'];
        $short_name = $row['short_name'];
        $levels  = $row['lowlevel']."-".$row['highlevel'];
        $expansion = $EQExpansions[$row['expansion']];
        $hotzone  = ($row['hotzone'] == '1' ? true : false);
       
        
        $text .= "<tr>
                    <td class='forumheader3' style='width:30%;height:20px;'><a href='zone.php?id.$zone_id'>$long_name</a>".($hotzone ? "<img src='".e_PLUGIN."EQLink/images/hotzone.png' alt='Hot Zone' />" : "")."</td>
                    <td class='forumheader3' style='width:10%;height:20px;'>$short_name</td>
                    <td class='forumheader3' style='width:30%;height:20px;'>$levels</td>
                    <td class='forumheader3' style='width:30%;height:20px;'>$expansion</td>
                <tr>";
        
    }
    $limit_field = "
                    Results per page:
                    <label for='limit10'>10</label><input type='radio' id='limit10' value='10' name='limit'".($limit == 10 ? " checked='checked'" : "")." />
                    <label for='limit20'>20</label><input type='radio' id='limit20' value='20' name='limit'".($limit == 20 ? " checked='checked'" : "")." />
                    <label for='limit30'>30</label><input type='radio' id='limit30' value='30' name='limit'".($limit == 30 ? " checked='checked'" : "")." />
                    <label for='limit40'>40</label><input type='radio' id='limit40' value='40' name='limit'".($limit == 40 ? " checked='checked'" : "")." />
                    <label for='limit50'>50</label><input type='radio' id='limit50' value='50' name='limit'".($limit == 50 ? " checked='checked'" : "")." />
                    ";
                    
    $filter = "
                Only Show Levels: <select name='eqzonefilterlevel'>
                    <option value='all'".($levelfilter == 'all' ? " selected='selected'":"").">All</option>";
                
    for($i=0; $i<=90;$i+=10){
        $filter .= "<option value='$i'".($levelfilter != 'all' && $levelfilter == $i ? " selected='selected'":"").">$i-".($i+10)."</option>";
    }
    $filter .= "</select>";
    
    $parms = "$zone_count,$limit,$from,".e_SELF.'?'.(isset($id)? "id:$id":"").(isset($limit)? ".limit:$limit":"").(isset($levelfilter) ? ".filter:$levelfilter":"").(isset($qsort) ? ".".$qsort:"").".from:[FROM]";
    $pages = $tp->parseTemplate("{NEXTPREV={$parms}}");
    $filterlimit_url = e_SELF.'?'.(isset($id)? "id:$id":"").(isset($qsort) ? ".".$qsort:"").".from:0";
    $ns->tablerender("Zones:","<table style='width:90%'>$header $text</table><form action='$filterlimit_url' method='post' onchange='this.submit()'><div style='text-align:center;margin:0 auto;'>$filter</div><div style='text-align:center;margin:0 auto;'>$limit_field</div></form> <div style='text-align:center;margin:0 auto'>$pages</div>");
require_once(FOOTERF);
?>