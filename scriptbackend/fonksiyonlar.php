<?php
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
function oyuncuVarmi($unique_id){
	$query = $GLOBALS['db']->prepare("SELECT * FROM pw_oyuncular WHERE unique_id = :unique_id");
	$query->execute([
		':unique_id' => $unique_id
	]);
	if($query->rowCount() > 0){
		return true;
	}
	return false;
}
function whiteList($guid){
	$query = $GLOBALS['db']->prepare("SELECT * FROM whitelist WHERE guid = :guid ");
	$query->bindParam(":guid" , $guid , PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() > 0){
		return true;
	}
	return false;
}
function admin_ver($guid){
	$query = $GLOBALS['db']->prepare("INSERT INTO pw_admin_permler (`guid`, `gold`, `kick`, `temp_ban`, `perm_ban`, `kill_fade`, `freeze`, `teleport_self`, `admin_items`, `heal_self`, `godlike_troop`, `ships`, `announce`, `override_poll`, `all_items`, `mute`, `animals`, `factions`) VALUES (:guid,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1) ");
	$query->bindParam(":guid" , $guid , PDO::PARAM_INT);
	$query->execute();
}
function evuse($guid , $x , $y , $z){
	$query = $GLOBALS['db']->prepare("SELECT * FROM evler WHERE guid = :guid AND x = :x AND y = :y AND z = :z");
	$query->bindParam(":guid" , $guid , PDO::PARAM_INT);
	$query->bindParam(":x" , $x , PDO::PARAM_INT);
	$query->bindParam(":y" , $y , PDO::PARAM_INT);
	$query->bindParam(":z" , $z , PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() > 0){
		return $query->fetch();

	}
	return array();
}
function evvarmi($x , $y , $z){
	$query = $GLOBALS['db']->prepare("SELECT * FROM evler WHERE x = :x AND y = :y AND z = :z");
	$query->bindParam(":x" , $x , PDO::PARAM_INT);
	$query->bindParam(":y" , $y , PDO::PARAM_INT);
	$query->bindParam(":z" , $z , PDO::PARAM_INT);
	$query->execute();
	if($query->fetchColumn() > 0){
		return true;
	}
	return false;
}
function ev_al($guid , $x , $y , $z){
	$returnthis = 1;
	if(evvarmi($x , $y , $z)){
		$returnthis = 0;
	}
	if($returnthis == 1){
		$query = $GLOBALS['db']->prepare("INSERT INTO evler (guid , x , y , z) VALUES (:guid , :x , :y , :z)");
		$query->bindParam(":guid" , $guid , PDO::PARAM_INT);
		$query->bindParam(":x" , $x , PDO::PARAM_INT);
		$query->bindParam(":y" , $y , PDO::PARAM_INT);
		$query->bindParam(":z" , $z , PDO::PARAM_INT);
		$query->execute();
	}
	return $returnthis;
}
function ban_check($unique_id){
	$query = $GLOBALS['db']->prepare("SELECT * FROM ban_list WHERE unique_id = :unique_id");
	$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
	$query->execute();
	if($query->rowCount() > 0){
		return $query->fetch();
	}
	return array();
}
function ban_player($unique_id , $banner , $banned , $reason){
	$query = $GLOBALS['db']->prepare("INSERT INTO ban_list (unique_id , banner , banned , reason) VALUES (:unique_id , :banner , :banned , :reason)");
	$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
	$query->bindParam(":banner" , $banner);
	$query->bindParam(":banned" , $banned );
	$query->bindParam(":reason" , $reason);
	if($query->execute()){
		print("bi terslik mi var");
	}
}
function adminlik_permler($unique_id){
	$query = $GLOBALS['db']->prepare("SELECT * FROM pw_admin_permler WHERE guid = :unique_id");
	$query->execute([
		":unique_id" => $unique_id
	]);
	if($query->rowCount () > 0){
		$veri = $query->fetch();
		$stringim = "";
		$stringim .= $veri['gold'] ."|";
		$stringim .= $veri['kick'] ."|";
		$stringim .= $veri['temp_ban'] ."|";
		$stringim .= $veri['perm_ban'] ."|";
		$stringim .= $veri['kill_fade'] ."|";
		$stringim .= $veri['freeze'] ."|";
		$stringim .= $veri['teleport_self'] ."|";
		$stringim .= $veri['admin_items'] ."|";
		$stringim .= $veri['heal_self'] ."|";
		$stringim .= $veri['godlike_troop'] ."|";
		$stringim .= $veri['ships'] ."|";
		$stringim .= $veri['announce'] ."|";
		$stringim .= $veri['override_poll'] ."|";
		$stringim .= $veri['all_items'] ."|";
		$stringim .= $veri['mute'] ."|";
		$stringim .= $veri['animals'] ."|";
		$stringim .= $veri['factions'];
		return($stringim);
	}else{
		return ("0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0|0");
	}
}
function oyuncu_cek($unique_id){
	$query = $GLOBALS['db']->prepare("SELECT * FROM pw_oyuncular WHERE unique_id = :unique_id");
	$query->execute([
		':unique_id' => $unique_id
	]);
	if($query->rowCount() > 0){
		return $query->fetch();
	}
}
function oyuncu_cek_username($name){
	$query = $GLOBALS['db']->prepare("SELECT * FROM pw_oyuncular WHERE name = :name");
	$query->execute([
		':name' => $name
	]);
	if($query->rowCount() > 0){
		return $query->fetch();
	}
}
function oyuncu_yukle($unique_id , $name){
	if(oyuncuVarmi($unique_id)){
		$bilgiler = oyuncu_cek($unique_id);
		return $bilgiler;
	}else{
		$query = $GLOBALS['db']->prepare("INSERT INTO pw_oyuncular (unique_id , name , banka , ustundeki_gold) 
			VALUES 
			(:unique_id , :name , 0, 1000) ");
		$query->bindParam(':unique_id' , $unique_id);
		$query->bindParam(':name' , $name);
		if($query->execute()){
			return "register";
		}
	}
}
function oyuncu_nickControl($unique_id , $name){
	$bilgi = oyuncu_cek_username($name);
	if(empty($bilgi)) return true;
	if($bilgi['unique_id'] == $unique_id){
		return true;
	}
	return false;
}
function banka_yatir($unique_id , $amount){
	$oyuncuVarmi = oyuncu_cek($unique_id);
	if(!empty($oyuncuVarmi)){
		$query = $GLOBALS['db'] -> prepare("UPDATE pw_oyuncular SET banka = banka + :amount , ustundeki_gold = 0 WHERE unique_id = :unique_id");
		$query->bindParam(":amount" , $amount , PDO::PARAM_INT);
		$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
		if($query->execute()){
			$oyuncu = oyuncu_cek($unique_id);
			return $oyuncu['banka'];
		}
	}
}
function save_update($guid , $gold , $item0 , $item1 , $item2 , $item3 , $head , $body , $foot , $gloves , $horse){
	$oyuncuVarmi = oyuncu_cek($guid);
	if(!empty($oyuncuVarmi)){
		$query = $GLOBALS['db'] -> prepare("UPDATE pw_oyuncular SET ustundeki_gold = :gold , item_0 = :item0 , 
			item_1 = :item1 , item_2 = :item2 , item_3 = :item3 , kask = :head , govde_zirhi = :body , ayak_zirhi = :foot 
			, eldiven = :gloves , at = :horse
			WHERE unique_id = :guid");
		$query->bindParam(":gold" , $gold , PDO::PARAM_INT);
		$query->bindParam(":item0" , $item0 , PDO::PARAM_INT);
		$query->bindParam(":item1" , $item1 , PDO::PARAM_INT);
		$query->bindParam(":item2" , $item2 , PDO::PARAM_INT);
		$query->bindParam(":item3" , $item3 , PDO::PARAM_INT);
		$query->bindParam(":head" , $head , PDO::PARAM_INT);
		$query->bindParam(":body" , $body , PDO::PARAM_INT);
		$query->bindParam(":foot" , $foot , PDO::PARAM_INT);
		$query->bindParam(":gloves" , $gloves , PDO::PARAM_INT);
		$query->bindParam(":horse" , $horse , PDO::PARAM_INT);
		$query->bindParam(":guid" , $guid , PDO::PARAM_INT);
		$query->execute();
	}
}
function para_bugu($unique_id , $amount){
	$oyuncuVarmi = oyuncu_cek($unique_id);
	if(!empty($oyuncuVarmi)){
		$query = $GLOBALS['db'] -> prepare("UPDATE pw_oyuncular SET banka = banka - :amount , ustundeki_gold = 0 WHERE unique_id = :unique_id");
		$query->bindParam(":amount" , $amount , PDO::PARAM_INT);
		$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
		if($query->execute()){
			$oyuncu = oyuncu_cek($unique_id);
			return $oyuncu['banka'];
		}
	}
}
function banka_cek($unique_id){
	$oyuncuVarmi = oyuncu_cek($unique_id);
	if(!empty($oyuncuVarmi)){
		$para = $oyuncuVarmi['banka'];
		if($para >= 5000){
			$query = $GLOBALS['db'] -> prepare("UPDATE pw_oyuncular SET banka = banka + -5000 , ustundeki_gold = 0 WHERE unique_id = :unique_id");
			$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
			if($query->execute()){
				$oyuncu = oyuncu_cek($unique_id);
				return "5000|".$oyuncu['banka'];
			}
		}else if ($para > 0 and $para < 5000){
			$query = $GLOBALS['db'] -> prepare("UPDATE pw_oyuncular SET banka = 0, ustundeki_gold = 0 WHERE unique_id = :unique_id");
			$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
			if($query->execute()){
				$oyuncu = oyuncu_cek($unique_id);
				return $para."|".$oyuncu['banka'];
			}
		}else{
			return "0|0";
		}
		/*$query = $GLOBALS['db'] -> prepare("UPDATE pw_oyuncular SET banka = banka + :amount , ustundeki_gold = 0 WHERE unique_id = :unique_id");
		$query->bindParam(":amount" , $amount , PDO::PARAM_INT);
		$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
		if($query->execute()){
			$oyuncu = oyuncu_cek($unique_id);
			return $oyuncu['banka'];
		}*/
	}
}
function exit_update($unique_id , $exit){
	$query = $GLOBALS['db']->prepare("UPDATE pw_oyuncular 
		SET exited = :exit
		WHERE unique_id = :unique_id");
	$query->bindParam(":exit" , $exit , PDO::PARAM_INT);
	$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
	$query->execute();
}
function save_chest($x,$y,$z,$items){
	$chest = load_chest($x,$y,$z);
	if($chest === -1){
		$query = $GLOBALS['db']->prepare("INSERT INTO chests (x , y , z , items) VALUES (:x , :y , :z , :items)");
		$query->bindParam(":x" , $x);
		$query->bindParam(":y" , $y);
		$query->bindParam(":z" , $z);
		$query->bindParam(":items" , $items);
		$query->execute();
	}else{
		$query = $GLOBALS['db']->prepare("UPDATE chests SET items = :items WHERE x = :x AND y = :y AND z = :z");
		$query->bindParam(":x" , $x);
		$query->bindParam(":y" , $y);
		$query->bindParam(":z" , $z);
		$query->bindParam(":items" , $items);
		$query->execute();
	}
}
function load_chest($x,$y,$z){
	$query = $GLOBALS['db']->prepare("SELECT * FROM chests WHERE x = :x AND y = :y AND z = :z");
	$query->execute([
		':x' => $x,
		':y' => $y,
		':z' => $z
	]);
	if($query->rowCount() > 0){
		return $query->fetch();
	}
	return -1;
}
function oyuncu_update($unique_id , $name , $at_can , $can , $pos_x , $pos_y , $pos_z , $ustundeki_gold , $meslek , $faction , $item_0 , $item_1 , $item_2 , $item_3 , $govde_zirhi , $kask , $ayak_zirhi , $eldiven , $entry_point , $at ,$aclik , $oldurme , $olme){

	$query = $GLOBALS['db']->prepare("UPDATE pw_oyuncular 
		SET
		name = :name, at_can = :at_can , can = :can , pos_x = :pos_x , pos_y = :pos_y ,pos_z = :pos_z ,
		ustundeki_gold = :ustundeki_gold , meslek = :meslek , faction = :faction , item_0 = :item_0 ,
		item_1 = :item_1 , item_2 = :item_2 , item_3 = :item_3 , govde_zirhi = :govde_zirhi , kask = :kask,
		ayak_zirhi = :ayak_zirhi , eldiven = :eldiven , entry_point = :entry_point , at = :at , aclik = :aclik,
		oldurme = :oldurme , olme = :olme
		WHERE unique_id = :unique_id");
	$query->bindParam(":name" , $name  , PDO::PARAM_STR);
	$query->bindParam(":at_can" , $at_can , PDO::PARAM_INT);
	$query->bindParam(":can" , $can , PDO::PARAM_INT);
	$query->bindParam(":pos_x" , $pos_x , PDO::PARAM_INT);
	$query->bindParam(":pos_y" , $pos_y , PDO::PARAM_INT);
	$query->bindParam(":pos_z" , $pos_z , PDO::PARAM_INT);
	$query->bindParam(":ustundeki_gold" , $ustundeki_gold , PDO::PARAM_INT);
	$query->bindParam(":meslek" , $meslek , PDO::PARAM_INT);
	$query->bindParam(":faction" , $faction , PDO::PARAM_INT);
	$query->bindParam(":item_0" , $item_0 , PDO::PARAM_INT);
	$query->bindParam(":item_1" , $item_1 , PDO::PARAM_INT);
	$query->bindParam(":item_2" , $item_2 , PDO::PARAM_INT);
	$query->bindParam(":item_3" , $item_3 , PDO::PARAM_INT);
	$query->bindParam(":govde_zirhi" , $govde_zirhi , PDO::PARAM_INT);
	$query->bindParam(":kask" , $kask , PDO::PARAM_INT);
	$query->bindParam(":ayak_zirhi" , $ayak_zirhi , PDO::PARAM_INT);
	$query->bindParam(":eldiven" , $eldiven , PDO::PARAM_INT);
	$query->bindParam(":entry_point" , $entry_point , PDO::PARAM_INT);
	$query->bindParam(":at" , $at , PDO::PARAM_INT);
	$query->bindParam(":aclik" , $aclik , PDO::PARAM_INT);
	$query->bindParam(":oldurme" , $oldurme , PDO::PARAM_INT);
	$query->bindParam(":olme" , $olme , PDO::PARAM_INT);
	$query->bindParam(":unique_id" , $unique_id , PDO::PARAM_INT);
	
	if($query->execute()){
		return true;
	}else{
		return false;
	}
}

?>