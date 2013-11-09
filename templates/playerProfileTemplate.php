<?php
/***
 *Player profile template
 */

 $player_inventory_start = '<td width="460px" align="center">
      <div class="IventoryOuter">
        <div class="IventoryTitle">
          <div class="IventoryTitleLeft"></div>
          <div class="IventoryTitleMid">Inventory</div>
          <div class="IventoryTitleRight"></div>
        </div>
        <div class="InventoryInner">';
        
    $player_inventory_gm_start = '<td width="460px" align="center">
      <div class="IventoryOuterGM">
        <div class="IventoryTitle">
          <div class="IventoryTitleLeft"></div>
          <div class="IventoryTitleMid"><span style="color:#9A83D4">**GM**</span> Inventory <span style="color:#9A83D4">**GM**</span></div>
          <div class="IventoryTitleRight"></div>
        </div>
        <div class="InventoryInner">
        ';
  //This is the small box with regen and all that jazz
  $player_inventory_stat2 ='<div class="InventoryStats2">
            <table class="StatTable">
              <tr>
                <td nowrap="">
                  Regen <br>FT<br>DS<br>Haste
                </td>
                <td>
                  {STAT=regen}<br>{STAT=ft}<br>{STAT=ds}<br>{STAT=haste}
                </td>
              </tr>
            </table>
          </div>';
    
    //This is the main player stats      
    $player_inventory_stat = '<div class="InventoryStats">
            <table class="StatTable">
              <tbody><tr><td colspan="2">{CHARACTER=character_name} {CHARACTER=last_name}</td></tr>
              <tr><td colspan="2" style="height: 3px"></td></tr>
              <tr><td colspan="2">{RACE}</td></tr>
              <tr><td colspan="2" style="height: 3px"></td></tr>
              <tr><td colspan="2">{CHARACTER=level} {CLASS}<br>{DEITY}</td></tr>
              <tr><td colspan="2" style="height: 3px"></td></tr>
              <tr>
                <td>HP <br>MANA<br>ENDR<br>AC<br>ATK</td>
                <td width="100%">{STAT=hp}<br>{STAT=mana}<br>{STAT=ENDR}<br>{STAT=ac}<br>{STAT=atk}</td>
              </tr>
              <tr><td class="Divider" colspan="2"></td></tr>
              <tr>
                <td>STR<br>STA<br>AGI<br>DEX</td>
                <td width="100%">{STAT=str}<br>{STAT=sta}<br>{STAT=agi}<br>{STAT=dex}</td>
              </tr>
              <tr><td class="Divider" colspan="2"></td></tr>
              <tr>
                <td>WIS<br>INT<br>CHA</td>
                <td width="100%">{STAT=wis}<br>{STAT=int}<br>{STAT=cha}</td>
              </tr>
              <tr><td class="Divider" colspan="2"></td></tr>
              <tr>
                <td>POISON<br>MAGIC<br>DISEASE  <br>FIRE<br>COLD</td>
                <td>{STAT=pr}<br>{STAT=mr}<br>{STAT=dr}<br>{STAT=fr}<br>{STAT=cr}</td>
              </tr>
              <tr><td class="Divider" colspan="2"></td></tr>
              <tr>
                <td>WEIGHT</td>
                <td nowrap="">{STAT=weight} / {STAT=str}</td>
              </tr>
            </tbody></table>
          </div>';
          
          
    $player_inventory_main = '<div class="InventoryMonogram"><img src="'.e_PLUGIN.'EQLink/images/profile/class/{CHARACTER=class}.gif" /></div>

          <div class="Coin" style="top: 116px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="'.e_PLUGIN.'EQLink/images/profile/pp.gif"></td><td align="center" width="100%">'.($pref['EQLink']['inv::showCash'] || check_class($pref['EQLink']['chr::gmclass']) ? '{CHARACTER=platinum}':'Disabled') .'</td></tr></tbody></table></div>
          <div class="Coin" style="top: 144px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="'.e_PLUGIN.'EQLink/images/profile/gp.gif"></td><td align="center" width="100%">'.($pref['EQLink']['inv::showCash'] || check_class($pref['EQLink']['chr::gmclass']) ? '{CHARACTER=gold}':'Disabled') .'</td></tr></tbody></table></div>
          <div class="Coin" style="top: 172px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="'.e_PLUGIN.'EQLink/images/profile/sp.gif"></td><td align="center" width="100%">'.($pref['EQLink']['inv::showCash'] || check_class($pref['EQLink']['chr::gmclass']) ? '{CHARACTER=silver}':'Disabled') .'</td></tr></tbody></table></div>
          <div class="Coin" style="top: 200px;left: 317px;"><table class="StatTable"><tbody><tr><td align="left"><img src="'.e_PLUGIN.'EQLink/images/profile/cp.gif"></td><td align="center" width="100%">'.($pref['EQLink']['inv::showCash'] || check_class($pref['EQLink']['chr::gmclass']) ? '{CHARACTER=copper}':'Disabled') .'</td></tr></tbody></table></div>

          <div class="Slot slotloc0 slotimage0"></div>
          <div class="Slot slotloc1 slotimage1"></div>
          <div class="Slot slotloc2 slotimage2"></div>
          <div class="Slot slotloc3 slotimage3"></div>
          <div class="Slot slotloc4 slotimage4"></div>
          <div class="Slot slotloc5 slotimage5"></div>
          <div class="Slot slotloc6 slotimage6"></div>
          <div class="Slot slotloc7 slotimage7"></div>
          <div class="Slot slotloc8 slotimage8"></div>
          <div class="Slot slotloc9 slotimage9"></div>
          <div class="Slot slotloc10 slotimage10"></div>
          <div class="Slot slotloc11 slotimage11"></div>
          <div class="Slot slotloc12 slotimage12"></div>
          <div class="Slot slotloc13 slotimage13"></div>
          <div class="Slot slotloc14 slotimage14"></div>
          <div class="Slot slotloc15 slotimage15"></div>
          <div class="Slot slotloc16 slotimage16"></div>
          <div class="Slot slotloc17 slotimage17"></div>
          <div class="Slot slotloc18 slotimage18"></div>
          <div class="Slot slotloc19 slotimage19"></div>
          <div class="Slot slotloc20 slotimage20"></div>
          <div class="Slot slotloc21 slotimage21"></div>
          <div class="Slot slotloc22 slotimage"></div>
          <div class="Slot slotloc23 slotimage"></div>
          <div class="Slot slotloc24 slotimage"></div>
          <div class="Slot slotloc25 slotimage"></div>
          <div class="Slot slotloc26 slotimage"></div>
          <div class="Slot slotloc27 slotimage"></div>
          <div class="Slot slotloc28 slotimage"></div>
          <div class="Slot slotloc29 slotimage"></div>';
          
$player_inventory_end = '</div>
      </div>
    </td>';
        

 
?>