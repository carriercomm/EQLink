<?php
/**
 * Player search
 */

 require_once("../../class2.php");

 if(!check_class(253)){//Only members have access to this feature
    require_once(HEADERF);
    $text = "Only members have access to this feature";
    $ns->tablerender("Error!",$text);
    require(FOOTERF);
    die();
}
require_once("includes/common_functions.php");
require_once("includes/EQDb.php");
include_once(e_PLUGIN.'/EQLink/includes/common.php');
if(!$eqSql){
global $eqSql;
}
global $EQClasses;
$pref['EQLink']['plyr::maxpage'] = 20;
$start = 0;
$limit = $pref['EQLink']['plyr::maxpage'];

if(e_QUERY){
    $tmp = explode(".",e_QUERY);
    foreach($tmp as $a){
        $tmp1 = explode(":",$a);
        switch($tmp1[0]){
            case 'sort':
                $sort = $tp->toDB($tmp1[2]);
                $field = $tp->toDB($tmp1[1]);
                break;
            case  'from':
                $start = $tp->toDB($tmp1[1]);
                break;
            case 'id':
                $id = $tp->toDB($tmp1[1]);
                break;
            default:
                break;
        }
    }
}



//lets get to business
 require_once(HEADERF);
//start by getting the count of the player table (to make the pages buttons)
if(!$eqSql->eqdb_Select("character_","count(*) as cnt")){
    handle_error("400","Unable to query database!");
}else{
    $row = $eqSql->eqdb_Fetch();
    $char_count = $row['cnt'];
    //we should only show 5 pages in the begingin and 5 in the end
    // ex 1,2,3,4,5...10,11,12,13,14,15
   $parms = "$char_count,$limit,$start,".e_SELF.'?'.(isset($id)? "id:$id":"").(isset($sort) ? ".sort:$field:$sort":"").".from:[FROM]";
    $nextprev = $tp->parseTemplate("{NEXTPREV={$parms}}");
    $pages = "$nextprev";
    
    //okay now we get the page
    $order = "ORDER BY ".(isset($sort) ? "$field $sort": "`id` ASC");
    $where = "chr.`level` > 0 AND chr.`class` > 0";
    $where .= (isset($id) ? " AND api.forum_userid=$id ":"1 ")."$order LIMIT $start,$limit";
    $table = "character_ as chr".(isset($id) ? " LEFT JOIN api on api.account_id = chr.account_id" : "");
    if(!$eqSql->eqdb_Select($table,"*",$where)){
        handle_error(400,(isset($id) ? "This user does not have any characters, or has not linked their account.":"Error Querying the database!"));
    }else{
        $text = '';
        while($row = $eqSql->eqdb_Fetch()){
            $text .= "<tr>
                    <td class= 'forumheader3' style='width:50%;height:23px'>".$row['name']."</th>
                    <td class= 'forumheader3' style='width:10%;height:23px'>".$row['level']."</th>
                    <td class= 'forumheader3' style='width:40%;height:23px'>".$EQClasses[$row['class']]."</th>
                    </tr>";
        }
        $header = "<tr>
                        <th style='text-align:left;width:50%' class='fcaption'><a href='".e_SELF.'?'.(isset($id)? "id:$id":"")."sort:name:".($field == 'name'  && $sort == 'ASC' ? 'DESC' : 'ASC').(isset($start) ? ".from:$start" : "")."'>Name <img src='images/".($field == 'name'  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a></th>
                        <th style='text-align:left;width:10%' class='fcaption'><a href='".e_SELF.'?'.(isset($id)? "id:$id":"")."sort:level:".($field == 'level'  && $sort == 'ASC' ? 'DESC' : 'ASC').(isset($start) ? ".from:$start" : "")."'>Level <img src='images/".($field == 'level'  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a></th>
                        <th style='text-align:left;width:40%' class='fcaption'><a href='".e_SELF.'?'.(isset($id)? "id:$id":"")."sort:class:".($field == 'class'  && $sort == 'ASC' ? 'DESC' : 'ASC').(isset($start) ? ".from:$start" : "")."'>Class <img src='images/".($field == 'class'  && $sort == 'ASC' ? 'sort_asc' : 'sort_desc').".png' /></a>
                        <span style='float:right'><a href='".e_SELF.'?'.(isset($id)? "id:$id":"").(isset($start) ? ".from:$start" : "")."'>Clear Sort</a></th>
                    </tr>
                        ";
        $text = "<table class='highlightrow' style='width:100%'>$header $text</table>".($char_count > $limit ? "<div style='text-align:center'>$pages</div>" : "");
        if(isset($id)){
            //we need to get the users name so we can use it in the caption...
            $sql->db_Select("user","user_name","user_id = $id");
            $res = $sql->db_Fetch();
            $res = $res['user_name'];
            $caption = $res."'s Characters";
        }else{
            $caption = "All Characters";
        }
        $ns->tablerender($caption,$text);
    }
}
 
require_once(FOOTERF);
?>