<?php
$eplug_admin = true;
require_once("../../class2.php");

if(!getperms("P")) { header("location:".e_BASE."index.php"); exit; }
require_once(e_ADMIN."auth.php");
require_once(e_HANDLER."userclass_class.php");


/***
 *Current Prefs:
 *db::user
 *db::pass
 *db::db
 *db::host
 *gen::gmclass
 *move::safezone
 *inv:showAdmin
 *inv:showRP
 *inv:showAnon
 *inv:showBank
 *inv:showCash
 */

 if(isset($_POST['updateprefs'])){
    $update = array(
        'db::user' => $_POST['db::user'],
        'db::pass'=> $pref['EQLink']['db::pass'],
        'db::db'=> $_POST['db::db'],
        'db::host'=> $_POST['db::host'],
        'chr::gmclass'=> $_POST['chr::gmclass'],
        'chr::safezone'=> $_POST['chr::safezone'],
        'chr::transfer'=> $_POST['chr::transfer'],
        'inv::showAdmin'=> $_POST['inv::showAdmin'],
        'inv::showRP'=> $_POST['inv::showRP'],
        'inv::showAnon'=> $_POST['inv::showAnon'],
        'inv::showBank'=> $_POST['inv::showBank'],
        'inv::showCash'=> $_POST['inv::showCash'],
        'plyr::maxpage'=>$_POST['plyr::maxpage']
    );
    if(!empty($_POST['db::pass'])){
        $update['db::pass'] = $_POST['db::pass'];
    }
    $pref['EQLink'] = $update;
    save_prefs();
    $message = "Configuration Saved.";
 }

 if(isset($message)){
    $ns->tablerender("Message: ",$message);
 }
 
 $EQLink = $pref['EQLink'];
$labels = "<tr>
	<th class='fcaption' style='width:50%'>Name</td>
	<th class='fcaption' style='width:50%'>Value</td>
	</tr>";
$text = "
        <form method='post' action='".e_SELF."' id='upform'>
	<table style='".ADMIN_WIDTH."' class='fborder'>
	";
$text .= "
        <tr>
        <th colspan='2' class='fcaption'>Database</th>
        </tr>";
        
$text .= $labels;

$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>User</td>
        <td class='forumheader3' style='width:50%'><input type='text' name='db::user' value='".$EQLink['db::user']."' /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Password</td>
        <td class='forumheader3' style='width:50%'><input type='password' name='db::pass' /></td>
        </tr>";

$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Use Database</td>
        <td class='forumheader3' style='width:50%'><input type='text' name='db::db' value='".$EQLink['db::db']."' /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Host</td>
        <td class='forumheader3' style='width:50%'><input type='text' name='db::host' value='".$EQLink['db::host']."' /></td>
        </tr>";
        
$text .= "
        <tr>
        <th colspan='2' class='fcaption'>Character</th>
        </tr>";
        
$text .= $labels;

$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>GM Class</td>
        <td class='forumheader3' style='width:50%'>".r_userclass("chr::gmclass", $EQLink['chr::gmclass'], 'off', 'admin,main,classes')."</td>
        </tr>";

$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Safe Zone <br /><span class='smalltext'>Short Name or Zone ID</span></td>
        <td class='forumheader3' style='width:50%'><input type='text' name='chr::safezone' value='".$EQLink['chr::safezone']."' /></td>
        </tr>";

$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Allow Account Transfer</td>
        <td class='forumheader3' style='width:50%'><input type='checkbox' name='chr::transfer' value='1'".($EQLink['chr::transfer'] == 1 ? " checked='checked'": '')." /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Max Characters Per Page</td>
        <td class='forumheader3' style='width:50%'><input type='text' name='plyr::maxpage' value='".$EQLink['plyr::maxpage']."' /></td>
        </tr>";
        
$text .= "
        <tr>
        <th colspan='2' class='fcaption'>Inventory</th>
        </tr>";

$text .= $labels;

$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Show Admin Inventory</td>
        <td class='forumheader3' style='width:50%'><input type='checkbox' name='inv::showAdmin' value='1'".($EQLink['inv::showAdmin'] == 1 ? " checked='checked'": '')." /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Show Roleplayers Inventory</td>
        <td class='forumheader3' style='width:50%'><input type='checkbox' name='inv::showRP' value='1'".($EQLink['inv::showRP'] == 1 ? " checked='checked'": '')." /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Show Anonymous Players Inventory</td>
        <td class='forumheader3' style='width:50%'><input type='checkbox' name='inv::showAnon' value='1'".($EQLink['inv::showAnon'] == 1 ? " checked='checked'": '')." /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Show Bank Slots</td>
        <td class='forumheader3' style='width:50%'><input type='checkbox' name='inv::showBank' value='1'".($EQLink['inv::showBank'] == 1 ? " checked='checked'": '')." /></td>
        </tr>";
        
$text .= "
        <tr>
        <td class='forumheader3' style='width:50%'>Show Cash</td>
        <td class='forumheader3' style='width:50%'><input type='checkbox' name='inv::showCash' value='1'".($EQLink['inv::showAdmin'] == 1 ? " checked='checked'": '')." /></td>
        </tr>";

$text .= "<tr>
            <td colspan='2' class='forumheader3'><input type='submit' name='updateprefs' value='Save Prefs' /></td>
        </tr>";
$text .= "</table></form>";

$ns->tablerender("Configure", $text);
require_once(e_ADMIN."footer.php");
?>