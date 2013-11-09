<?php
require_once('spdat.php');
class itemstats {


	var $myhp;
	var $mymana;
	var $myendurance;
	var $myAC;
	var $mySTR;
	var $mySTRCapMod;
	var $mySTA;
	var $mySTACapMod;
	var $myAGI;
	var $myAGICapMod;
	var $myDEX;
	var $myDEXCapMod;
	var $myWIS;
	var $myWISCapMod;
	var $myINT;
	var $myINTCapMod;
	var $myCHA;
	var $myCHACapMod;
	var $myMR;
	var $myMRCapMod;
	var $myPR;
	var $myPRCapMod;
	var $myCR;
	var $myCRCapMod;
	var $myFR;
	var $myFRCapMod;
	var $myDR;
	var $myDRCapMod;
	var $myCorrup;
	var $myCorrupCapMod;
	var $myFT;
	var $myDS;
	var $myregen;
	var $myattack;
	var $myhaste;
        var $myWT;
	var $myWR;
	var $myHSTR; 
	var $myHSTA;
	var $myHDEX; 
	var $myHAGI; 
	var $myHINT; 
	var $myHWIS; 
	var $myHCHA; 
	var $myHMR; 
	var $myHFR; 
	var $myHCR;
	var $myHPR;
	var $myHDR;
 




         public function additem($row,$level){
		if($level >= $row['reclevel']){
			//Stats
			$this->myhp += $row['hp'];
			$this->mymana += $row['mana'];
			$this->myendurance += $row['endur'];
			$this->myAC += $row['ac'];
			$this->mySTR += $row['astr'];
			$this->mySTA += $row['asta'];
			$this->myAGI += $row['aagi'];
			$this->myDEX += $row['adex'];
			$this->myWIS += $row['awis'];
			$this->myINT += $row['aint'];
			$this->myCHA += $row['acha'];
			
			//Resists
			$this->myMR += $row['mr'];
			$this->myPR += $row['pr'];
			$this->myCR += $row['cr'];
			$this->myFR += $row['fr'];
			$this->myDR += $row['dr'];
			$this->myCorrup += $row['svcorruption'];
			
			//Stat Cap Mods
			$this->mySTRCapMod += $row['heroic_str'];
			$this->mySTACapMod += $row['heroic_sta'];
			$this->myDEXCapMod += $row['heroic_dex'];
			$this->myAGICapMod += $row['heroic_agi'];
			$this->myINTCapMod += $row['heroic_int'];
			$this->myWISCapMod += $row['heroic_wis'];
			$this->myCHACapMod += $row['heroic_cha'];
			
			//Resist Cap Mods
			$this->myMRCapMod += $row['heroic_mr'];
			$this->myFRCapMod += $row['heroic_fr'];
			$this->myCRCapMod += $row['heroic_cr'];
			$this->myPRCapMod += $row['heroic_pr'];
			$this->myDRCapMod += $row['heroic_dr'];
			$this->myCorrupCapMod += $row['heroic_svcorrup'];
			
			//Heroic Stats
			$this->myHSTR += $row['heroic_str'];
			$this->myHSTA += $row['heroic_sta'];
			$this->myHDEX += $row['heroic_dex'];
			$this->myHAGI += $row['heroic_agi'];
			$this->myHINT += $row['heroic_int'];
			$this->myHWIS += $row['heroic_wis'];
			$this->myHCHA += $row['heroic_cha'];
			
			//Heroic Resists
			$this->myHMR += $row['heroic_mr'];
			$this->myHFR += $row['heroic_fr'];
			$this->myHCR += $row['heroic_cr'];
			$this->myHPR += $row['heroic_pr'];
			$this->myHDR += $row['heroic_dr'];
			$this->myCorrup += $row['heroic_svcorrup'];
		}else{
			//Stats
			$this->myhp += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['hp']));
			$this->mymana += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['mana']));
			$this->myendurance += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['endur']));
			$this->myAC += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['ac']));
			$this->mySTR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['astr']));
			$this->mySTA += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['asta']));
			$this->myAGI += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['aagi']));
			$this->myDEX += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['adex']));
			$this->myWIS += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['awis']));
			$this->myINT += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['aint']));
			$this->myCHA += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['acha']));
			
			//Resists
			$this->myMR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['mr']));
			$this->myPR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['pr']));
			$this->myCR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['cr']));
			$this->myFR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['fr']));
			$this->myDR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['dr']));
			$this->myFT += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['manaregen']));
			$this->myDS += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['damageshield']));
			$this->myCorrup += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['svcorruption']));
			
			//Stat Cap Mods
			$this->mySTRCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_str']));
			$this->mySTACapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_sta']));
			$this->myDEXCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_dex']));
			$this->myAGICapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_agi']));
			$this->myINTCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_int']));
			$this->myWISCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_wis']));
			$this->myCHACapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_cha']));
			
			//Resist Cap Mods
			$this->myMRCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_mr']));
			$this->myFRCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_fr']));
			$this->myCRCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_cr']));
			$this->myPRCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_pr']));
			$this->myDRCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_dr']));
			$this->myCorrupCapMod += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_svcorrup']));
			
			//Heroic Stats
			$this->myHSTR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_str']));
			$this->myHSTA += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_sta']));
			$this->myHDEX += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_dex']));
			$this->myHAGI += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_agi']));
			$this->myHINT += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_int']));
			$this->myHWIS += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_wis']));
			$this->myHCHA += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_cha']));
			
			//Heroic Resists
			$this->myHMR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_mr']));
			$this->myHFR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_fr']));
			$this->myHCR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_cr']));
			$this->myHPR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_pr']));
			$this->myHDR += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_dr']));
			$this->myCorrup += round($this->calculateRecommendedLevelBonus($level,$row['reclevel'],$row['heroic_svcorrup']));
			}
		
		//Haste/DS don't get penalized for recommended level
		$this->myhaste = max($row['haste'],$this->myhaste); //only save highest haste
		$this->myHPRegen += ($row['regen'] > 0 ? $row['regen'] : 0);
		$this->myManaRegen += ($row['manaregen'] > 0 ? $row['manaregen'] : 0);
		$this->myattack += $row['attack'];
		
		$this->myDS += ($row['damageshield'] > 0 ? $row['damageshield'] : 0);
		
		//***todo process focus/worn effects***
		
		//***todo process augments***
		
		
		
         }

         public function addwt($wt) {
           $this->myWT +=  $wt; 
         }

	 function capMod($stat){
		$var = "my".$stat."CapMod";
		return $this->$var;
	 }
         function hp() {
           return $this->myhp;
         }

         function mana() {
	  return $this->mymana;
         }

         function endurance() {
	  return $this->myendurance;
         }

         function AC() {
	  return $this->myAC;
         }

         function STR() {
	  return $this->mySTR;
         }

         function STA() {
	  return $this->mySTA;
         }

         function AGI() {
	  return $this->myAGI;
         }

         function DEX() {
	  return $this->myDEX;
         }

         function WIS() {
	  return $this->myWIS;
         }

         function INT() {
	  return $this->myINT;
         }

         function CHA() {
	  return $this->myCHA;
         }

         function MR() {
	  return $this->myMR;
         }

         function PR() {
	  return $this->myPR;
         }

         function CR() {
	  return $this->myCR;
         }

         function FR() {
	  return $this->myFR;
         }

         function DR() {
	  return $this->myDR;
         }

         function FT() {
	  return $this->myFT;
         }

         function DS() {
	  return $this->myDS;
         }

         function regen() {
	  return $this->myregen;
         }

         function attack() {
	  return $this->myattack;
         }

         function haste() {
	  return $this->myhaste; 
         }

         function WT() {
           return $this->myWT;
         }
	 function HSTR() {
	  return $this->myHSTR;
         }

         function HSTA() {
	  return $this->myHSTA;
         }

         function HAGI() {
	  return $this->myHAGI;
         }

         function HDEX() {
	  return $this->myHDEX;
         }

         function HWIS() {
	  return $this->myHWIS;
         }

         function HINT() {
	  return $this->myHINT;
         }

         function HCHA() {
	  return $this->myHCHA;
         }

         function HMR() {
	  return $this->myHMR;
         }

         function HPR() {
	  return $this->myHPR;
         }

         function HCR() {
	  return $this->myHCR;
         }

         function HFR() {
	  return $this->myHFR;
         }

         function HDR() {
	  return $this->myHDR;
         }
	 
	 
	
	function calculateRecommendedLevelBonus($level,$reclevel,$basestat){
		 if( ($reclevel > 0) && ($level < $reclevel) ){
			$statmod = ($level * 10000 / $reclevel) * $basestat;
			if( $statmod < 0 )
			{
				$statmod -= 5000;
				return ($statmod/10000);
			}
			else
			{
				$statmod += 5000;
				return ($statmod/10000);
			}
		}
	}

 
}

class aastats{
	
	var $myhp;
	var $mymaxhp;
	var $mymana;
	var $myendurance;
	var $myAC;
	var $mySTR;
	var $mySTA;
	var $myAGI;
	var $myDEX;
	var $myWIS;
	var $myINT;
	var $myCHA;
	var $myMR;
	var $myPR;
	var $myCR;
	var $myFR;
	var $myDR;
	var $myFT;
	var $myDS;
	var $myhpregen;
	var $mymanaregen;
	var $myattack;
	var $myhaste;
        var $myWT;
	var $myWR;
	
	public function addAA($aa){
	require_once("spdat.php");
		if(!is_array($aa) || !array_key_exists("effectid",$aa)){
			return;
		}
		if($aa['effectid'] == 0 && $aa['base1'] == 0){
			return;
		}
		
		switch ($aa['effectid']){
			case SE_CurrentHP: //regens
                                $this->myhpregen += $aa['base1'];
                                break;
			case SE_CurrentMana:
                                $this->mymanaregen += $aa['base1'];
                                break;
                        case SE_STR:
                                $this->mySTR += $aa['base1'];
                                break;
                        case SE_DEX:
                                $this->myDEX += $aa['base1'];
                                break;
                        case SE_AGI:
                                $this->myAGI += $aa['base1'];
                                break;
                        case SE_STA:
                                $this->mySTA += $aa['base1'];
                                break;
                        case SE_INT:
                                $this->myINT += $aa['base1'];
                                break;
                        case SE_WIS:
                                $this->myWIS += $aa['base1'];
                                break;
                        case SE_CHA:
                                $this->myCHA += $aa['base1'];
                                break;
                        case SE_ResistFire:
                                $this->myFR += $aa['base1'];
                                break;
                        case SE_ResistCold:
                                $this->myCR += $aa['base1'];
                                break;
                        case SE_ResistPoison:
                                $this->myPR += $aa['base1'];
                                break;
                        case SE_ResistDisease:
                                $this->myDR += $aa['base1'];
                                break;
                        case SE_ResistMagic:
                                $this->myMR += $aa['base1'];
                                break;
                        case SE_MaxHPChange:
				echo "Name :(".$aa['id'].")".$aa['name']."<br />";
				echo "Case: ".SE_MaxHPChange."<br />";
				echo "value: ".$aa['base1']."<br />";
                                $this->mymaxhp += $aa['base1'];
                                break;
                        case SE_Packrat:
                                $this->myWR += $aa['base1'];
                                break;
                        case SE_TotalHP:
				echo "Name :(".$aa['id'].")".$aa['name']."<br />";
				echo "Case: ".SE_TotalHP."<br />";
				echo "value: ".$aa['base1']."<br />";
                                $this->myhp += $aa['base1'];
                                break;
			 case SE_EndurancePool:
                                $this->endurance += $aa['base1'];
                                break;
		}
	}
	
	function capMod($stat){
		return 0;
	}
	function hp() {
		echo "called";
           return $this->myhp;
         }
	function maxhp() {
		return $this->mymaxhp;
	}

         function mana() {
	  return $this->mymana;
         }

         function endurance() {
	  return $this->myendurance;
         }

         function AC() {
	  return $this->myAC;
         }

         function STR() {
	  return $this->mySTR;
         }

         function STA() {
	  return $this->mySTA;
         }

         function AGI() {
	  return $this->myAGI;
         }

         function DEX() {
	  return $this->myDEX;
         }

         function WIS() {
	  return $this->myWIS;
         }

         function INT() {
	  return $this->myINT;
         }

         function CHA() {
	  return $this->myCHA;
         }

         function MR() {
	  return $this->myMR;
         }

         function PR() {
	  return $this->myPR;
         }

         function CR() {
	  return $this->myCR;
         }

         function FR() {
	  return $this->myFR;
         }

         function DR() {
	  return $this->myDR;
         }

         function manaregen() {
	  return $this->mymanaregen;
         }

         function DS() {
	  return $this->myDS;
         }

         function hpregen() {
	  return $this->myhpregen;
         }

         function attack() {
	  return $this->myattack;
         }

         function haste() {
	  return $this->myhaste; 
         }

         function WT() {
           return $this->myWT;
         }
}

class basestats{
	function cap($stat,$level){
		switch($stat){
			case "STR":
			case "STA":
			case "DEX":
			case "AGI":
			case "INT":
			case "WIS":
			case "CHA":
				return $this->GetMaxStat($level);
				break;
			case "MR":
			case "PR":
			case "DR":
			case "CR":
			case "FR":
			case "CORRUP":
				return $this->GetMaxResist($level);
				break;
			default:
				return;
				break;
		}
	}
	public function pr($race,$c,$l){
		 //racial bases
        switch($race) {
                case HUMAN:
		case BARBARIAN:
		case ERUDITE:
                case WOOD_ELF:
                case HIGH_ELF:
                case DARK_ELF:
                case HALF_ELF:
		case TROLL:    
                case OGRE:
                case GNOME:    
                case IKSAR:
                case VAHSHIR:
                case DRAKKIN:  
                        $PR = 15;
                        break;
                
                   
                case DWARF:
		case HALFLING:
                        $PR = 20;
                        break;
		case FROGLOK:
                        $PR = 30;
                        break;
                    
                default:
                        $PR = 15;
        }

        if($c == ROGUE) {
                $PR += 8;
                if($l > 49)
                        $PR += $l - 49;

        } else if($c == SHADOWKNIGHT) {
                $PR += 4;
                if($l > 49)
                        $PR += $l - 49;
        }
	}
	public function hp($NormalSTA, $HeroicSTA, $class, $mlevel){
		//echo "I'm being called!!";
		if((($NormalSTA - 255) / 2) > 0)
                        $SoDPost255 = (($NormalSTA - 255) / 2);
                else
                        $SoDPost255 = 0;

                $hp_factor = $this->GetClassHPFactor($class);

                if ($mlevel < 41) {
                        $base_hp = (5 + ($mlevel * $hp_factor / 12) +
                                (($NormalSTA - $SoDPost255) * $mlevel * $hp_factor / 3600));
                }
                else if ($mlevel < 81) {
                        $base_hp = (5 + (40 * $hp_factor / 12) + (($mlevel - 40) * $hp_factor / 6) +
                                (($NormalSTA - $SoDPost255) * $hp_factor / 90) +
                                (($NormalSTA - $SoDPost255) * ($mlevel() - 40) * $hp_factor / 1800));
                }
                else {
                        $base_hp = (5 + (80 * $hp_factor / 8) + (($mlevel - 80) * $hp_factor / 10) +
                                (($NormalSTA - $SoDPost255) * $hp_factor / 90) +
                                (($NormalSTA - $SoDPost255) * $hp_factor / 45));
                }

                $base_hp += ($HeroicSTA * 10);
		return $base_hp;
		
		
	}
	
	function GetClassHPFactor($class){
		require_once("common.php");
		switch($class){
			case DRUID:
			case ENCHANTER:
			case NECROMANCER:
			case MAGICIAN:
			case WIZARD:
				$factor = 240;
				break;
			case BEASTLORD:
			case BERSERKER:
			case MONK:
			case ROGUE:
			case SHAMAN:
				$factor = 255;
				break;
			case BARD:
			case CLERIC:
				$factor = 264;
				break;
			case SHADOWKNIGHT:
			case PALADIN:
				$factor = 288;
				break;
			case RANGER:
				$factor = 276;
				break;
			case WARRIOR:
				$factor = 300;
				break;
			default:
				$factor = 240;
				break;
		}
		return $factor;
	}
	
	function GetMaxStat($level) {

	if((RuleI("Character", "StatCap")) > 0)
		return (RuleI("Character", "StatCap"));


	$base = 0;

	if ($level < 61) {
		$base = 255;
	}
	else{
		$base = 255 + 5 * ($level - 60);
	}

	return $base;
}

	function GetMaxResist($level){

	$base = 500;

	if($level > 60){
		$base += (($level - 60) * 5);
	}

	return $base;
	}
}

?>