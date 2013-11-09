<?php
require_once('../../class2.php');
require_once(e_PLUGIN."EQLink/includes/statsclass.php");
/**
 * EqEmu Profile Reader
 */
define('LOCATION', 0);
define('BYTES', 1);
define('TYPE', 2);

 $blobValues = array(
    "checksum" => array( 0, 4, "uint32"),
    "last_name" => array( 68, 32, "char"),
    "gender" => array( 100, 4, "uint32"),
    "race" => array( 104, 4, "uint32"),
    "deity" => array( 220, 4, "uint32"),
    "birthday" => array( 228, 4, "uint32"),
    "lastlogin" => array( 232, 4, "uint32"),
    "pvp" => array( 240, 1, "uint8"),
    "anon" => array( 242, 1, "uint8"),
    "gm" => array( 243, 1, "uint8"),
    "guildrank" => array( 244, 1, "uint8"),
    "haircolor" => array( 296, 1, "uint8"),
    "beardcolor" => array( 297, 1, "uint8"),
    "eyecolor1" => array( 298, 1, "uint8"),
    "eyecolor2" => array( 299, 1, "uint8"),
    "hairstyle" => array( 300, 1, "uint8"),
    "beard" => array( 301, 1, "uint8"),
    "platinum" => array( 4720, 4, "sint32"),
    "gold" => array( 4724, 4, "sint32"),
    "silver" => array( 4728, 4, "sint32"),
    "copper" => array( 4732, 4, "sint32"),
    "platinum_bank" => array( 4736, 4, "sint32"),
    "gold_bank" => array( 4740, 4, "sint32"),
    "silver_bank" => array( 4744, 4, "sint32"),
    "copper_bank" => array( 4748, 4, "sint32"),
    "platinum_cursor" => array( 4752, 4, "sint32"),
    "gold_cursor" => array( 4756, 4, "sint32"),
    "silver_cursor" => array( 4760, 4, "sint32"),
    "copper_cursor" => array( 4764, 4, "sint32"),
    "ldon_points_guk" => array( 7060, 4, "sint32"),
    "ldon_points_mir" => array( 7064, 4, "sint32"),
    "ldon_points_mmc" => array( 7068, 4, "sint32"),
    "ldon_points_ruj" => array( 7072, 4, "sint32"),
    "ldon_points_tak" => array( 7076, 4, "sint32"),
    "ldon_points_available" => array( 7080, 4, "sint32"),
    "endurance" => array( 7904, 4, "sint32"),
    "group_leadership_exp" => array( 7908, 4, "uint32"),
    "raid_leadership_exp" => array( 7912, 4, "uint32"),
    "group_leadership_points" => array( 7916, 4, "uint32"),
    "raid_leadership_points" => array( 7920, 4, "uint32"),
    "aapoints_spent" => array( 12796, 4, "uint32"),
    "expaa" => array( 12800, 4, "uint32"),
    "aapoints" => array( 12804, 4, "uint32"),
    "currentRadCrystals" => array( 19540, 4, "uint32"),
    "careerRadCrystals" => array( 19544, 4, "uint32"),
    "currentEbonCrystals" => array( 19548, 4, "uint32"),
    "careerEbonCrystals" => array( 19552, 4, "uint32"),
    "aa" => array( 428, 4, "uint32"),
    "title" => array( 2384, 32, "char"),
    "suffix" => array( 2416, 32, "char"),
    "exp" => array( 2452, 4, "uint32"),
    "points" => array( 2460, 4, "uint32"),
    "mana" => array( 2464, 4, "uint32"),
    "cur_hp" => array( 2468, 4, "uint32"),
    "STR" => array( 2476, 4, "uint32"),
    "STA" => array( 2480, 4, "uint32"),
    "CHA" => array( 2484, 4, "uint32"),
    "DEX" => array( 2488, 4, "uint32"),
    "INT" => array( 2492, 4, "uint32"),
    "AGI" => array( 2496, 4, "uint32"),
    "WIS" => array( 2500, 4, "uint32"),
    "face" => array( 2504, 1, "uint8"),
    "common_tongue" => array( 2552, 1, "uint8"),
    "barbarian" => array( 2553, 1, "uint8"),
    "erudian" => array( 2554, 1, "uint8"),
    "elvish" => array( 2555, 1, "uint8"),
    "dark_elvish" => array( 2556, 1, "uint8"),
    "dwarvish" => array( 2557, 1, "uint8"),
    "troll" => array( 2558, 1, "uint8"),
    "ogre" => array( 2559, 1, "uint8"),
    "gnomish" => array( 2560, 1, "uint8"),
    "halfling" => array( 2561, 1, "uint8"),
    "thieves_cant" => array( 2562, 1, "uint8"),
    "old_erudian" => array( 2563, 1, "uint8"),
    "elder_elvish" => array( 2564, 1, "uint8"),
    "froglok" => array( 2565, 1, "uint8"),
    "goblin" => array( 2566, 1, "uint8"),
    "gnoll" => array( 2567, 1, "uint8"),
    "combine_tongue" => array( 2568, 1, "uint8"),
    "elder_teirdal" => array( 2569, 1, "uint8"),
    "lizardman" => array( 2570, 1, "uint8"),
    "orcish" => array( 2571, 1, "uint8"),
    "faerie" => array( 2572, 1, "uint8"),
    "dragon" => array( 2573, 1, "uint8"),
    "elder_dragon" => array( 2574, 1, "uint8"),
    "dark_speech" => array( 2575, 1, "uint8"),
    "vah_shir" => array( 2576, 1, "uint8"),
    "unknown" => array( 2578, 1, "uint8"),
    "spell_book" => array( 2584, 4, "int32"),
    "mem_spell_1" => array( 4632, 4, "int32"),
    "mem_spell_2" => array( 4636, 4, "int32"),
    "mem_spell_3" => array( 4640, 4, "int32"),
    "mem_spell_4" => array( 4644, 4, "int32"),
    "mem_spell_5" => array( 4648, 4, "int32"),
    "mem_spell_6" => array( 4652, 4, "int32"),
    "mem_spell_7" => array( 4656, 4, "int32"),
    "mem_spell_8" => array( 4660, 4, "int32"),
    "mem_spell_9" => array( 4664, 4, "int32"),
 );
 //INSERT INTO `peqdb`.`account` (`id`, `name`, `charname`, `sharedplat`, `password`, `status`, `lsaccount_id`, `gmspeed`, `revoked`, `karma`, `minilogin_ip`, `hideme`, `rulesflag`, `suspendeduntil`, `time_creation`) VALUES ('20', 'langjoshua4288', 'Secly', '0', '', '250', '88642', '0', '0', '52', '0', '0', '0', '0000-00-00 00:00:00', '1374926216');


 $accountTable = array(
    'account_id' => 'id',
    'account_name' => 'name',
    'last_character' => 'charname',
    'shared_plat' => 'sharedplat',
    'world_password' => 'password',
    'status' => 'status',
    'loginserver_id' => 'lsaccount_id',
    'gmspeed' => 'gmspeed',
    'account_oocmute' => 'revoked',
    'karma' => 'karma',
    'minilogin_ip' => 'minilogin_ip',
    'hideme' => 'hideme',
    'accepted_rules' => 'rulesflag',
    'suspended_until' => 'suspendeduntil',
    'time_creation' => 'time_creation'
 );
 /**
  *INSERT INTO `peqdb`.`character_` (
  *`id`,
  *`account_id`,
  *`name`,
  *`profile`,
  *`timelaston`,
  *`x`,
  *`y`,
  *`z`,
  *`zonename`,
  *`alt_adv`,
  *`zoneid`,
  *`instanceid`,
  *`pktime`,
  *`groupid`,
  *`extprofile`,
  *`class`,
  *`level`,
  *`lfp`,
  *`lfg`,
  *`mailkey`,
  *`xtargets`,
  *`firstlogon`,
  *`inspectmessage`)
  */

 $characterTable = array(
    'character_id'=>'id',
    'character_name'=>'name',
    'profile'=>'profile',
    'timelaston'=>'timelaston',
    'x'=>'x',
    'y'=>'y',
    'z'=>'z',
    'zonename'=>'zonename',
    'alt_adv'=>'alt_adv',
    'instanceid'=>'instanceid',
    'pktime'=>'pktime',
    'groupid'=>'groupid',
    'extprofile'=>'extprofile',
    'class'=>'class',
    'level'=>'level',
    'lfp'=>'lfp',
    'lfg'=>'lfg',
    'mailkey'=>'mailkey',
    'xtargets'=>'xtargets',
    'firstlogon'=>'firstlogon',
    'inspectmessage'=>'inspectmessage'
 );
 // Convert ASCII to a float integer

function asc2float($asciiInput) {

  		$floatOutput = unpack("f", $asciiInput);

	return $floatOutput[1];

}



// Convert ASCII to Signed Integer

function asc2sint($asciiInput){

	$sintOutput = unpack("l", $asciiInput);

	return $sintOutput[1];

}



// Convert ASCII to unsigned integer (requires asc2bin)

function asc2uint($asciiInput) {

	if ($decimalOutput = bindec(asc2bin($asciiInput))) {

		return $decimalOutput;

	} else {

		return "0";

	}

}



// convert an input string into it's binary equivalent.

function asc2bin($asciiInput, $byteLength=8){



	// Numerical data is reverse ASCII, so we need to turn it around

	$asciiRev = strrev($asciiInput);



	$binaryOutput = '';

	$strSize = strlen($asciiRev);



	for($x=0; $x<$strSize; $x++){

		$charBin = decbin(ord($asciiRev{$x}));

		$charBin = str_pad($charBin, $byteLength, '0', STR_PAD_LEFT);

		$binaryOutput .= $charBin;

	}

	return $binaryOutput;

}
 
 
 class profile{
    
    var $profile;
    var $account_id;
    var $char_id;
    var $character;
    var $account;
    var $inventory;
    var $guild;
    var $aa;
    var $eqSql;
    var $itemstats;
    var $aastats;
    var $basestats;
    
    /**
     * profile($id)
     * @param $id (int) id of the character to retrieve
     * @return (bool) True on success/False on error 
     */
    public function __construct($id){

        $this->eqSql = connect();
        $this->itemstats = new itemstats();
        $this->aastats = new aastats();
        $this->basestats = new basestats();
        global $tp;
        $this->characterid = $tp->toDB($id);        
    }
    function loadCharacter(){
        if(!$this->eqSql->eqdb_Select("character_","*","`id` = ".$this->characterid)){
            handle_error(400,"Unable to find matching character");
            return false;
        }
        $this->character = $this->eqSql->eqdb_Fetch();
        $this->account_id = $this->character['account_id'];
        $this->profile = $this->character['profile'];
        return true;
    }
    function loadAccount(){
        if(!$this->eqSql->eqdb_Select("account",'*',"`id` = ".$this->account_id)){
                handle_error(400,"Unable to find matching character");
                return false;
        }
        $this->account = $this->eqSql->eqdb_Fetch();
        return true;
    }
    function loadGuild(){
        if(!$this->eqSql->eqdb_Select("guilds gu, guild_members gm, guild_ranks gr","*","gu.id = gm.guild_id AND gm.rank = gr.rank AND gr.guild_id = gu.idAND gm.char_id = ".$this->characterid)){
            return false;
        }
        $this->guild = $this->eqSql->eqdb_Fetch();
        return true;
    }
    
    function loadInventory(){
        if(!$this->eqSql->eqdb_Select("inventory as inv  JOIN items as itm on inv.itemid = itm.id","*","charid = ".$this->characterid." ORDER BY inv.slotid ASC")){
            handle_error(400,"Unable to retrieve inventory");
            return false;
        }
        while($row = $this->eqSql->eqdb_Fetch()){
            if($row['slotid'] < 21){
                //add stats for this item...
                $this->itemstats->additem($row,$this->getvalue("level"));
            }
            if($row['slotid'] <=29){
                //add weight...
                $this->itemstats->addwt($row['weight']/10);
            }elseif($row['slotid'] >= 251 && $row['slotid'] <= 330){
                //add reduced weight (bag)
                //lets find the bag to get it's WR
                if($row['slotid'] >= 251 && $row['slotid'] <= 260){
                    $bagslot = 22;
                }elseif ($row['slotid'] >= 261 && $row['slotid'] <= 270){
                    $bagslot = 23;
                }elseif ($row['slotid'] >= 271 && $row['slotid'] <= 280){
                    $bagslot = 24;
                }elseif ($row['slotid'] >= 281 && $row['slotid'] <= 290){
                    $bagslot = 25;
                }elseif ($row['slotid'] >= 291 && $row['slotid'] <= 300){
                    $bagslot = 26;
                }elseif ($row['slotid'] >= 301 && $row['slotid'] <= 310){
                    $bagslot = 27;
                }elseif ($row['slotid'] >= 311 && $row['slotid'] <= 320){
                    $bagslot = 28;
                }elseif ($row['slotid'] >= 321 && $row['slotid'] <= 330){
                    $bagslot = 29;
                }else{
                    $bagslot = -1;
                }
                $bagwr = $this->getvalue("inventory",$bagslot);
                $bagwr = $bagwr['bagwr']/100;
                $weight = ($row['weight']/10)-(($row['weight']/10)*$bagwr);
                $this->itemstats->addwt($weight);
            }
            $this->inventory[$row['slotid']] = $row;
        }
        return true;
        
    }
    
    function loadAA(){
        if(!$this->character){
            $this->loadCharacter();
        }
        for($i=1; $i <= 240; $i++){
            $tmp = $this->getaa($i);
            $this->aa[$tmp['id']] = $tmp;
            //add stats for AA's
            $this->aastats->addAA($tmp);
        }
    }
    
    /**
     * accountid()
     * @return (int) returns the current account id or false if not set
     */
    function accountid(){
        return (isset($this->accountid) ? $this->accountid : false);
    }
    
    /**
     * characterid()
     * @return (int) returns the current character id or false if not set
     */
    function characterid(){
        return (isset($this->char_id) ? $this->char_id : false);
    }
    /**
     * getvalue($name)
     * @param $name (char) returns the requested value from the characters profile
     * @return (mixed) the value
     */
    function getvalue($name,$opt = null){
        global $blobValues,$accountTable,$characterTable,$tp;
        // First lets see if the value is in the blob
        if(isset($blobValues[$tp->toDB($name)])){
            $row = $blobValues[$tp->toDB($name)];
            if(!$this->profile){
                $this->loadCharacter();
            }
            //it's in the blob
            switch($row[TYPE]){
			case 'uint8':
			case 'uint16':
			case 'uint32':
			case 'int':
			case 'int16':
			case 'int32':
				return asc2uint(substr($this->profile, $row[LOCATION], $row[BYTES]));
			break;
			case 'float':
				return asc2float(substr($this->profile, $row[LOCATION], $row[BYTES]));
			break;
			case 'sint8':
			case 'sint16':
			case 'sint32':
				return asc2sint(substr($this->profile, $row[LOCATION], $row[BYTES]));
			break;
			case 'char':
				return rtrim(substr($this->profile, $row[LOCATION], $row[BYTES]));
			break;
			}
        }elseif(isset($accountTable[$tp->toDB($name)])){
            //it's an account field
            if(!$this->account){
                //account relies on the character table
                if(!$this->character){
                    $this->loadCharacter();
                }
                $this->loadAccount();
            }
            return $this->account[$accountTable[$name]];
        }elseif(isset($characterTable[$tp->toDB($name)])){
            //it's a character field
            if(!$this->character){
                $this->loadCharacter();
            }
            return $this->character[$characterTable[$name]];
        }elseif($name == 'guild'){
            //they want the guild info
            if(!$this->guild){
                $this->loadGuild();
            }
            if(!$opt){
                return $this->guild;
            }
            return $this->guild[$tp->toDB($opt)];
        }elseif($name == 'inventory'){
            //they want inventory
            if(!$this->inventory){
                $this->loadInventory();
            }
            return ($opt == 'all' ? $this->inventory : (array_key_exists($opt,$this->inventory) ?  $this->inventory[$tp->toDB($opt)] : null ));
        }
        
        
        
        else{
            //I don't know wtf this is...
            return false;
        }
    }
    
    function getaa($slot){
        global $blobValues;
        /** aa_id_1 = 436 4 bytes uint32 (this is stored in $blobValues['aa'])
         *  aa_value_1 = 440 4 bytes uint32
         *
         *  Each AA is 8 bytes. so slot 2 is 436 +((2-1)*8) = 444
         */
        if(!$this->profile){
            $this->loadCharacter();
        }
        $ret["id"] = asc2uint(substr($this->profile, (($blobValues['aa'][LOCATION])+((intval($slot)-1)*8)), 4));
        $ret["value"] = asc2uint(substr($this->profile, (($blobValues['aa'][LOCATION])+((intval($slot)-1)*8)+4), 4));
        $this->eqSql->eqdb_Select("altadv_vars","`name`","skill_id = ".($ret['id'] - ($ret['value'] -1)));
        $info = $this->eqSql->eqdb_Fetch();
        $ret["name"] = $info["name"];
        for($i = 0;$i < $ret['value'];$i++){
            if($this->eqSql->eqdb_Select("aa_effects","*","aaid = ".($ret['id']-$i))){
                $info = $this->eqSql->eqdb_Fetch();
                $ret["effectid"] = $info['effectid'];
                $ret["base1"] += $info["base1"];
                $ret["base2"] += $info["base2"];
            }
        }
        return $ret;
    }
    
    function calcStat($stat){
        if(!$this->character){
            $this->loadCharacter();
        }
        if(!$this->inventory){
            $this->loadInventory();
        }
        if(!$this->aa){
            $this->loadAA();
        }
        switch($stat){
            case "hp":
                $mlevel = $this->getvalue("level");
                $class = $this->getvalue("class");
                $sta = $this->getvalue("STA")+$this->itemstats->STA();
                $hsta = $this->itemstats->HSTA();
                $nd = 10000;
                $max_hp = ($this->basestats->hp($sta,$hsta,$class,$mlevel) + $this->itemstats->hp());
        
                //The AA desc clearly says it only applies to base hp..
                //but the actual effect sent on live causes the client
                //to apply it to (basehp + itemhp).. I will oblige to the client's whims over
                //the aa description
                $nd += $this->aastats->maxhp();        //Natural Durability, Physical Enhancement, Planar Durability
        
                $max_hp = (float)$max_hp * (float)$nd / (float)10000; //this is to fix the HP-above-495k issue
                $max_hp += $this->aastats->hp();
        
                //$max_hp += $max_hp * ((itembonuses.MaxHPChange) / 10000.0f);
        
        
                return round($max_hp);
                break;
            case "str":
                $mlevel = $this->getvalue("level");
                $val = $this->getvalue("STR") + $this->itemstats->STR() + $this->aastats->STR();
                if($val < 1){
                    $val = 1; #this shouldn't happen here...
                }
                $cap = $this->basestats->cap("STR",$mlevel) + $this->itemstats->capMod("STR") + $this->aastats->capMod("STR");
                if($val > $cap){
                    $val = $cap;
                }
                return $val;
                break;
            case "pr":
                $race = $this->getvalue("race");
                $class = $this->getvalue("class");
                $mlevel = $this->getvalue("level");
                $val = $this->basestats->pr($race,$class,$level) + $this->itemstats->PR() + $this->itemstats->HPR() + $this->aastats->PR();
                $cap = $this->basestats->cap("PR",$mlevel) + $this->itemstats->capMod("PR") + $this->aastats->capMod("PR");
                return ($val < $cap ? $val : $cap);
                break;
            default:
                $return = 0;
                if(method_exists($this->basestats,$stat)){
                    $return += $this->basestats->$stat();
                }
                if(method_exists($this->itemstats,$stat)){
                    $return += $this->itemstats->$stat();
                }
                if(method_exists($this->itemstats,"h".$stat)){
                    $tmp = "h".$stat;
                    $return += $this->itemstats->$tmp();
                }
                if(method_exists($this->aastats,$stat)){
                    $return += $this->aastats->$stat();
                }
                return $return;
                
                break;
        }
    }
 }
?>