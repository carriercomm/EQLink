<?php
require_once('../../class2.php');

require_once(e_PLUGIN.'/EQLink/includes/EQDb.php');
if(!$eqSql){
global $eqSql;
}

require_once(HEADERF);
if (e_QUERY){
 $tmp = explode(".",e_QUERY);
 $action = $tmp[0];
 $id = $tmp[1];
}
if($action = 'delete' && isset($id)){
    //We're  going to delete the specific link
    //Check if the user has permissions to delete.
    if(check_class(250)){
        $where = 'account_id = '.$tp->toDB($id)." LIMIT 1";
    }else{
        $where = 'account_id = '.$tp->toDB($id).' AND forum_userid = '.USERID." LIMIT 1";
    }
    
    if($eqSql->eqdb_Delete("api",$where)){
        $message = "The link has sucessfully been deleted.";
    }else{
        $message = "There was a problem deleting the link, please try again later. If the problem persists contact an administrator.";
    }
}
//see if there is new link in $_Post
if(isset($_POST['eqlinksubmit'])){
    //clean the input ;)
    $account_name = $tp->toDB($_POST['account_name']);
    //get the account info
    $eqSql->eqdb_Select("account" , "`id`" , "`name` LIKE '$account_name' LIMIT 1");
    if($account = $eqSql->eqdb_Fetch()){
        //make sure the account isn't already linked.
        $eqSql->eqdb_Select("api","*","account_id = ".$account['id']);
        if(!$eqSql->eqdb_Fetch()){
            //create the insert args
            $args = array(
                "account_id"=>$account['id'],
                "forum_username"=> USERNAME,
                "forum_userid"=> USERID,
                "accepted" => 0
            );
            if($eqSql->eqdb_Insert("api",$args)){
                $message = "Sucessfully completed the link. You need to login to a character on the account and accept the link (#api for more info)";
            }else{
                $message = "There was an error completing the link, please try again later. If the problem persists contact an administrator.";
            }
        }else{
            //There is already a link
            $message = "There is already a forum account linked to this account. Please login to a character on the account and use #api to review the link.";
        }
        
    }else{
        $message = "Account Not Found!";
    }
    
}

if(isset($message)){
    $ns->tablerender("Message: ","<div style='text-align:center'>$message</span>");
}

//check the api table and see if there is an active link for the current forum user
$eqSql->eqdb_Select("api LEFT JOIN account AS acc on api.account_id = acc.`id`","acc.`name`,api.*","forum_userid = '".USERID."'");
    //Pull the current link (give an option to delete it.)
    while($row = $eqSql->eqdb_Fetch()){
        $links[]  = $row;
    }
    if($links){
        //create a table of the links
        $text = "<table style='width:100%;border-collapse:collapse'>
            <tr><th class='fcaption'>Username</th><th class='fcaption'>Status</th><th class='fcaption'>Delete</th></tr>";
        foreach($links as $link){
            $text .= "<tr style='background-color:".($link['accepted'] == 1 ? "green" : "red")."'>
                        <td class='forumheader3'>".$tp->toHTML($link['name'])."</td>
                        <td class='forumheader3'>".($link['accepted'] == 1 ? "Verified" : "Not Verified")."</td>
                        <td class='forumheader3'><a href='".e_SELF."?delete.".$link['account_id']."'><img src='".e_IMAGE."/admin_images/delete_32.png' alt='Delete' />
                    </tr>";
        }
        $text .= "</table>";
        $ns->tablerender("Current Links", $text);
    }

$text = "To link your characters, type your login server USERNAME into the field below. After that you will need to log in and accept the api request (#api accept)";
$text .="<form action='".e_SELF."' method='post'>
            <table style='width:50%'>
                <tr><td class='forumheader3'>Username</td>
                    <td class='forumheader3'><input type='text' class='tbox' style='width:100px' name='account_name' /></tr>
                <tr colspan=2><td class='forumheader3' style='text-align:center; width:100%'><input class='button' type='submit' name='eqlinksubmit' value='Link!'>
            </table>
            </form>";

$ns->tablerender("Account Link",$text);
require_once(FOOTERF);
$eqSql->eqdb_Close();
    
?>