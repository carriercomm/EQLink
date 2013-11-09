<?php
require_once('../../class2.php');

/****
 * Characters Page
 * View characters, level, zone, etc
 * for the current users account
 */
if(!check_class(253)){//Only members have access to this feature
    $text = "Only members have access to this feature";
    $ns->tablerender("Error!",$text);
    require(FOOTERF);
    die();
}

include_once(e_PLUGIN.'/EQLink/includes/EQDb.php');
include_once(e_PLUGIN.'/EQLink/includes/common.php');
if(!$eqSql){
global $eqSql;
}
global $EQClasses;
if (e_QUERY){
 $tmp = explode(".",e_QUERY);
 $action = $tmp[0];
 $aid = $tp->toDB($tmp[1]);
}

require_once(HEADERF);
if(isset($_POST['finishTransfer'])){
    //The last step to character transfers
    //make sure the user owns the new acct
    $character = $aid;
    $toAcct = $tp->toDB($_POST['newAccount']);
    if($eqSql->eqdb_Select("account AS acc LEFT JOIN api on api.account_id = acc.`id`","*","acc.`id` = $toAcct AND forum_userid = ".USERID)){
        $from = "character_ as chr LEFT JOIN api on api.account_id = chr.account_id";
        $arg = "chr.account_id = '$toAcct' WHERE api.forum_userid = ".USERID." AND chr.`id` = ".$character;
        if($eqSql->eqdb_Update($from,$arg)){
            $caption = "Sucess";
            $message = "Your character has sucessfully been transfered.";
            
        }
    }else{
        //They don't own the new account
        $caption = "Error:";
        $message = "There was an error transfering your character. Please contact an administrator.";
    }
    unset($aid,$action);
}

if(isset($action)){
    switch($action){
        case 'move':
            /**
             * Move the specified character to the designated safe zone
             * a GM can do this for any character. Normal member can only do it on an account they have linked.
             */
            //Set up the update query
            if(check_class($pref['EQLink']['chr::gmclass'])){
                $where = "chr.`id` = $aid";
            }else{
                $where = "chr.`id` = $aid AND api.forum_userid = ".USERID;
            }
            $from = "character_ AS chr LEFT JOIN api as api on chr.account_id = api.account_id";
            
            //get the zone data
            if($eqSql->eqdb_Select("zone","short_name,long_name,zoneidnumber,safe_x,safe_y,safe_z","short_name LIKE '".$pref['EQLink']['chr::safezone']."' OR zoneidnumber = '".$pref['EQLink']['move::safezone']."'")){
                //we got the zone
                $zone = $eqSql->eqdb_Fetch();
                $update =  "x = ".$zone['safe_x'].", ";
                $update .= "y = ".$zone['safe_y'].", ";
                $update .= "z = ".$zone['safe_z'].", ";
                $update .= "zonename = '".$zone['short_name']."', ";
                $update .= "zoneid = ".$zone['zoneidnumber']." ";
                if($eqSql->eqdb_Update($from,$update." WHERE ".$where,'now')){
                    $caption = "Success!";
                    $message = "Your character has sucessfully been moved. Please note that this tool will not work if the character is logged in.";
                }else{
                    $caption = "Error:";
                    $message = "There was an error moving your character, please try again later. If the problem persists, contact an administrator.";
                }
            }else{
                $caption = "Error!";
                $message = "There was an error retrieving the safe zone information. Please contact an administrator.";
            }
            unset($aid);
            break;
        
        case 'delete':
            $caption = "Error:";
            $message = "This feature is not yet implemented.";
            break;
        
        case 'switch':
            if($pref['EQLink']['chr::transfer']){
                $from = "api LEFT JOIN account as acc on api.account_id = acc.`id`";
                $where = "api.forum_userid = ".USERID;
                if(!$eqSql->eqdb_Select($from,"acc.`id`,acc.`Name`",$where)){
                    $caption = "Error:";
                    $message = "There was an error finding your accounts. Have you <a href='link.php'>Linked</a> your account yet?";
                }else{
                    $cnt = 0;
                    while($row = $eqSql->eqdb_Fetch()){
                        $cnt++;
                        $accounts[] = $row;
                    }
                    if($cnt <= 1){//They only have one account... Can't transfer
                        $caption = "Error";
                        $message = "You need to have more than one account <a href='link.php'>Linked</a> to transfer characters.";
                        break;
                    }else{
                        //select the character to be transfered
                        $from = "character_ as chr LEFT JOIN api on api.account_id = chr.account_id";
                        $where = "api.forum_userid = ".USERID." AND chr.`id` = ".$aid." LIMIT 1";
                        if(!$eqSql->eqdb_Select($from,"chr.`Name`,chr.`id`",$where)){
                            $caption = "Error:";
                            $message = "There was an error selecting your character.";
                            break;
                        }else{
                            $character = $eqSql->eqdb_Fetch();
                            $select =  null;
                            foreach($accounts as $acc){
                                $select .= "<option value='".$acc['id']."'".($acc['id'] == $character['account_id'] ? " selected='selected'":"").">".$acc['Name']."</option>";
                            }
                            $select = "<form action='".e_SELF."?".e_QUERY."' method='post'><select name='newAccount'>".$select."<input type='submit' class='button' name='finishTransfer' value='Submit'</select></form>";
                            $caption = "Select New Account";
                            $message = "<div style='text-align:center'>Select the account to transfer ".$character['Name']." to: $select </div>";
                        }
                    }
                }
            }else{
                $caption = "Error:";
                $message = "Character transferring is not enabled on this server.";
            }
            unset($aid);
            break;
    }
}


if(isset($aid) && check_class(254)){
    $id = $aid;
}else{
    $id = USERID;
}
 //Start by getting the characters
 $from = 'character_ as chr LEFT JOIN api on api.account_id = chr.account_id';
 $where = 'api.forum_userid = '.$id.' AND api.accepted = 1 ORDER BY chr.timelaston DESC';
 if(!$eqSql->eqdb_Select($from,"*",$where)){
    $caption = "Error!";
    $message = "There was an error selecting your characters";
 }else{
    while($character = $eqSql->eqdb_Fetch()){
        $actions =  "<a href = '".e_SELF."?move.".$character['id']."'><img src='".e_IMAGE."/admin_images/main_32.png' alt ='Move' /></a>";
        $actions .= "<a href = '".e_SELF."?delete.".$character['id']."'><img src='".e_IMAGE."/admin_images/delete_32.png' alt ='Delete' /></a>";
        $actions .= "<a href = '".e_SELF."?switch.".$character['id']."'><img src='images/switch.png' alt='Switch Accounts' /></a>";
        
        $text .= "<tr>
                    <td class= 'forumheader3' style= 'width:50%'>".$character['name']."</td>
                    <td class= 'forumheader3' style= 'width:10%'>".$character['level']."</td>
                    <td class= 'forumheader3' style= 'width:20%'>".$EQClasses[$character['class']]."</td>
                    <td class= 'forumheader3' style= 'width:20%'> $actions </td>
                    </tr>";
    }
    $header = "<tr>
                    <th class='fcaption' style= 'width:50%'>Name</th>
                    <th class='fcaption' style= 'width:10%'>Level</th>
                    <th class='fcaption' style= 'width:20%'>Class</th>
                    <th class='fcaption' style= 'width:20%'>Actions</th>
               </tr>";
    $text = "<table class='highlightrow' style='width:80%;border-collapse:collapse'>$header $text </table>";
    
 }
 
 if(isset($message)){
    $ns->tablerender($caption,$message);
 }
 if(!isset($text)){
    $text = "You do not have any characters to display. Have you <a href='link.php'>Linked</a> your account yet?";
 }
 $ns->tablerender("Your Characters",$text);
 require_once(FOOTERF);
?>