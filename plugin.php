<?

/*
+ ----------------------------------------------------------------------------+
|     profile_search
|
|     ©Joshua Lang 2008
|     http://hyper-server.com
|     admin@hyper-server.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     
|     $Revision: 1.0 $
|     $Date: 05-02-2008  $
|     $Author: Webbe $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }
 
 // Plugin info  
 $eplug_name    = "Everquest Link";
 $eplug_version = "1.0";
 $eplug_author  = "Webbe";
 
 $eplug_description="Links an Everquest Account to the e107 User";
 $eplug_compatible  = "e107 v0.7";
 $eplug_readme      = "";        
 

$eplug_caption = "Configure Everquest Link";
 // Name of the plugin's folder
 $eplug_folder = "EQLink";
 $eplug_icon = $eplug_folder."/images/icon_32.png";
$eplug_icon_small = $eplug_folder."/images/icon_16.png";
 // Mane of menu item for plugin  
 $eplug_menu_name = "";
 
 // Name of the admin configuration file  
 $eplug_conffile = "EQLink_admin.php";
 
 // List of preferences 
 $eplug_prefs  = array(
                       'EQLink'=>array(
                                       'db:user' => 'peq',
                                       'db:pass' => 'peq',
                                       'db:db' => 'peqdb',
                                       'db:host' => 'localhost',
                                       'inv:showAdmin' => false,
                                       'inv:showRP' => false,
                                       'inv:showAnon' => false,
                                       'inv:showBank' => true,
                                       )
                       );
 $eplug_tables = "";
 
 // Create a link in main menu (yes=TRUE, no=FALSE) 
 $eplug_link = true;
 $eplug_link_name  = "Players";
 $eplug_link_perms = "";
 $eplug_link_url = eplug_folder."/players.php";
 
 
 
 // Text to display after plugin successfully installed 
 $eplug_done           = "Installation Successful..";
 $eplug_uninstall_done = "Uninstalled Successfully..";
 
 ?>
