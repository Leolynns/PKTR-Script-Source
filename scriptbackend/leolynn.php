<?php
require("config.php");
$db->query("SET NAMES 'utf8'");
// Sorgu inceleme.
$_SERVER['QUERY_STRING'] = str_replace(" ", "_", $_SERVER['QUERY_STRING']);
$_SERVER['QUERY_STRING'] = str_replace("%20", "_", $_SERVER['QUERY_STRING']);
$debug = $_SERVER['QUERY_STRING'];
$old = file_get_contents("debug_leo.txt");
$file = fopen("debug_leo.txt", "w");
fwrite($file, "$old- [".date("H:i:s")."]: $debug". PHP_EOL);
fclose($file);

define("ScriptPFX", "AshFS:");
define("MIN_FACTION", 1);
define("MAX_FACTION", 8);

// Dönüş Tipleri
define("R_ERROR", -1);
define("R_SUCCESS", 150);
define("R_LOADNAME", 151);
define("R_LOADBANNER", 152);
define("R_LOADLORD", 153);
define("R_LOADPLAYER", 154);
define("R_SAVEPLAYER", 155);
define("R_SAVEFACTION", 156);
// -------------
$defaultFactionArray = array(
	array("fac_name" => "Krallık #1", "fac_banner" => 111, "lord_uid" => 123),
	array("fac_name" => "Krallık #2", "fac_banner" => 112, "lord_uid" => 456),
	array("fac_name" => "Krallık #3", "fac_banner" => 113, "lord_uid" => 789),
	array("fac_name" => "Krallık #4", "fac_banner" => 114, "lord_uid" => 987),
	array("fac_name" => "Krallık #5", "fac_banner" => 115, "lord_uid" => 654),
	array("fac_name" => "Krallık #6", "fac_banner" => 116, "lord_uid" => 321),
	array("fac_name" => "Krallık #7", "fac_banner" => 117, "lord_uid" => 963),
	array("fac_name" => "Krallık #8", "fac_banner" => 118, "lord_uid" => 369),
);
function is_between($val, $x, $y){
		if(($val >= $x && $val <= $y) || ($val <= $x && $val >= $y)){
				return true;
		}
		return false;
}
function loadFactions($value = "fac_name", $for_player = null) {
		$wbPrefix = ""; // Eğer modül sisteminde bi prefix alıyorsa.
		switch($value){
				case "fac_name":
						$returnCode = R_LOADNAME;
						break;
				case "fac_banner":
						$returnCode = R_LOADBANNER;
						break;
				case "lord_uid":
						$returnCode = R_LOADLORD;
						break;
				default:
						return R_ERROR . "|Fonksiyona bilinmeyen deger girildi. [loadFactions -> $value]";
						break;
		}
		if($for_player != null){
				$returnCode .= "|". $for_player;
		}
		$fQuery = $GLOBALS['db']->query("SELECT * FROM factions");
		$result = $fQuery->fetchAll(PDO::FETCH_ASSOC);
		foreach($GLOBALS['defaultFactionArray'] as $p => $v){
				if(isset($result[$p]['fac_id'])){
						saveFactionPlayer($result[$p]['lord_uid'], $result[$p]['fac_id'], 0, 1, 1, 1, 1); // Lord yetkileri verme.
						$returnCode .= "|$wbPrefix" . $result[$p][$value];
						continue;
				}
				$returnCode .= "|$wbPrefix" . $v[$value]; 
		}
		return $returnCode;
}
function loadFactionPlayer($pid, $guid) {
	$errorCode = R_ERROR . "|";
	if(is_numeric($guid)){
		$isLord = $GLOBALS['db']->prepare("SELECT * FROM factions WHERE lord_uid = :guid");
		$isLord->execute(array(":guid" => $guid));
		if($isLord->rowCount()){
			$result = $isLord->fetch(PDO::FETCH_ASSOC);
			$fac_id = $result['fac_id'];
			return R_LOADPLAYER . "|" . "$guid|$fac_id|0|1|1|1|1|$pid|[!] Lord izinleriniz ayarlandı!";
		}
		$isThereGUID = $GLOBALS['db']->prepare("SELECT * FROM faction_players WHERE p_guid = :guid");
		$isThereGUID->execute(array(":guid" => $guid));
		if($isThereGUID->rowCount()){
			$result = $isThereGUID->fetch(PDO::FETCH_ASSOC);
			foreach($result as $k => $v){
				$$k = $v;
			}
			return R_LOADPLAYER . "|" . "$guid|$fac_id|$is_marshall|$has_doorkey|$has_chestkey|$has_moneykey|$can_announce|$pid|[!] Oluşum izinleriniz ayarlandı!";
			/*
				s0 = Bilgi mesajı.
				reg0 = R_LOADPLAYER (154)
				reg1 = GUID
				reg2 = FACTION ID
				reg3 = IS_MARSHALL
				reg4 = HAS_DOORKEY
				reg5 = HAS_CHESTKEY
				reg6 = HAS_MONEYKEY
				reg7 = CAN_ANNOUNCE
				reg8 = PLAYER ID

				Şeklinde değerler dönecektir.
			*/
		}
	} else {
		return $errorCode . "[LOAD_FACTION_PLAYER] GUID numerik degil.";
	}
}
function saveFactionPlayer($guid, $faction, $is_marshall, $has_doorkey, $has_moneykey, $has_chestkey, $can_announce) {
	$errorCode = R_ERROR . "|";
	if(is_numeric($guid)){
		$isThereGUID = $GLOBALS['db']->prepare("SELECT id FROM faction_players WHERE p_guid = :guid");
		$isThereGUID->execute(array(":guid" => $guid));
		if($isThereGUID->rowCount()){
			$savePlayer = $GLOBALS['db']->prepare("UPDATE faction_players SET fac_id = :fid, is_marshall = :ismr, has_doorkey = :hdk, has_chestkey = :hck, has_moneykey = :hmk, can_announce = :ca WHERE p_guid = :guid");
			$status = $savePlayer->execute(
				array(
					":fid" => $faction,
					":ismr" => $is_marshall,
					":hdk" => $has_doorkey,
					":hmk" => $has_moneykey,
					":hck" => $has_chestkey,
					":ca" => $can_announce,
					":guid" => $guid
				)
			);
			if($status){
				return R_SAVEPLAYER . "|" . "* [FACTION] Oyuncu kaydedildi: $guid.";
			} else {
				return $errorCode . "* [FACTION] UPDATE faction_players BASARISIZ. ($guid)";
			}
		} else {
			$insertPlayer = $GLOBALS['db']->prepare("INSERT INTO faction_players (p_guid, fac_id, is_marshall, has_doorkey, has_moneykey, has_chestkey, can_announce) VALUES (:guid, :facid, :ismr, :hdk, :hmk, :hck, :ca)");
			$status = $insertPlayer->execute(
				array(
					":guid" => $guid,
					":facid" => $faction,
					":ismr" => $is_marshall,
					":hdk" => $has_doorkey,
					":hmk" => $has_moneykey,
					":hck" => $has_chestkey,
					":ca" => $can_announce
				)
			);
			if($status){
				return R_SAVEPLAYER . "|" . "* [FACTION] Oyuncu kaydedildi: $guid.";
			} else {
				return $errorCode . "* [FACTION] INSERT faction_players BASARISIZ. ($guid)";
			}
		}
	}
}
function saveFactions($fac_id, $fac_name, $fac_banner, $fac_lord) {
		$errorCode = R_ERROR . "|";
		if(is_numeric($fac_id)){
				if(!empty($fac_name)){
						if(is_between($fac_banner, 47, 348)){
								if(is_numeric($fac_lord)){
										$save = $GLOBALS['db']->prepare("UPDATE factions SET fac_name = :fname, fac_banner = :fbanner, lord_uid = :flord WHERE fac_id = :fid");
										$save->execute(array(
												":fid" => $fac_id,
												":fname" => htmlentities(trim($fac_name)),
												":fbanner" => $fac_banner,
												":flord" => $fac_lord
										));
										if($save){
												saveFactionPlayer($fac_lord, $faction, 0, 1, 1, 1, 1);  // Lord yetkileri verme.
												return R_SUCCESS . "|" . ScriptPFX . " Factionlar kaydedildi.";
										}
								} else {
										return $errorCode .= ScriptPFX . " Faction lordu GUID'si rakamsal degil veya girilmemis.";
								}
						} else {
								return $errorCode .= ScriptPFX . " Bayrak degeri 47 ile 348 arasinda degil.";
						}
				} else {
						return $errorCode .= ScriptPFX . " Faction ismi bos.";
				}
		} else {
				return $errorCode .= ScriptPFX . " Faction ID rakamsal olmali.";
		}
		
}
function getBanner() { // Düzenlenecek
		switch($type){
				case "id";
						break;
				case "name";
						break;
				default;
						break;
		}
}
$type = @$_GET['T'];
$pid = @$_GET['PID'];
$value = str_replace(" ", "_", @$_GET['V']);
$fac_id = @$_GET['fid'];
$fac_name = @$_GET['fname'];
$fac_banner = @$_GET['fbanner'];
$fac_lord = @$_GET['flord'];

$fac_id = @$_GET['facid'];
$guid = @$_GET['guid'];
$is_marshall = boolval(@$_GET['ismarshall']);
$has_doorkey = boolval(@$_GET['hasdoorkey']);
$has_moneykey = boolval(@$_GET['hasmoneykey']);
$has_chestkey = boolval(@$_GET['haschestkey']);
$can_announce = boolval(@$_GET['canannounce']);

if($type==="saveFactions"){
    if($fac_lord == ""){
        $fac_lord = -1;
    }
    echo saveFactions($fac_id, $fac_name, $fac_banner, $fac_lord);
}
else if($type==="loadFactions"){
    $condition = (isset($pid) ? $pid : null);
    echo loadFactions($value, $condition);
}
else if($type==="saveFactionPlayer"){
	$isLord = $db->prepare("SELECT * FROM factions WHERE lord_uid = :guid");
	$isLord->execute(array(":guid" => $guid));
	if($isLord->rowCount()){
		echo saveFactionPlayer($guid, $fac_id, 0, 1, 1, 1, 1);
	}
	echo saveFactionPlayer($guid, $fac_id, $is_marshall, $has_doorkey, $has_moneykey, $has_chestkey, $can_announce);
}
else if($type==="loadPlayerFaction"){
	echo loadFactionPlayer($pid, $guid);
}
// _____________
?>