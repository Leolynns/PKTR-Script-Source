<?php
include("config.php");
include("fonksiyonlar.php");
// İstek inceleme.
$_SERVER['QUERY_STRING'] = str_replace(" ", "_", $_SERVER['QUERY_STRING']);
$_SERVER['QUERY_STRING'] = str_replace("%20", "_", $_SERVER['QUERY_STRING']);
$debug = $_SERVER['QUERY_STRING'];
$old = file_get_contents("request_list.txt");
$file = fopen("request_list.txt", "w");
fwrite($file, "$old- [".date("H:i:s")."]: $debug". PHP_EOL);
fclose($file);
if(isset($_GET['welcome'])){
	$id = $_GET['welcome'];
	$guid = $_GET['guid'];
	$veri = oyuncu_cek($guid);
	if(!empty($veri)){
		print("1|".$id."|0|".$server_welcome_message);
	}else{
		 print("1|".$id."|0|".$server_welcome_message);	
	}
	
}
if(isset($_GET['whitelist'])){
	$player_id = $_GET['whitelist'];
	$unique_id = $_GET['guid'];
	$white = whiteList($unique_id);
	if($white)
	print("11|1|".$player_id);
	else
		print("11|0|".$player_id);
}
if(isset($_GET['giris'])){
	$player_name = $_GET['giris'];
	$player_guid = $_GET['guid'];
	$player_id = $_GET['playerid'];
	$answer = oyuncu_yukle($player_guid , $player_name);
	if($answer == "register"){
		print("2|0|".$player_id."|".$player_guid);
	}else{
		print("2|1|".$answer['pos_x']."|".$answer['pos_y']."|".$answer['pos_z']."|"
			  .$answer['ustundeki_gold']."|".$answer['meslek']."|".$answer['faction'].
			  "|".$answer["item_0"]."|".$answer["item_1"]."|".$answer["item_2"]."|".
			  $answer["item_3"]."|".$answer["kask"]."|".$answer["govde_zirhi"]."|".
			  $answer["ayak_zirhi"]."|".$answer["eldiven"]."|".$answer["entry_point"].
			  "|".$answer["at"]."|".$answer["aclik"]."|".$answer["oldurme"]."|".$answer["olme"]."|".$answer["at_can"]."|".
			  $player_id."|".$answer["can"]
			);
		exit_update($player_guid , 0);
		
	}
}
if(isset($_GET['banplayer'])){
	$guid = $_GET['banplayer'];
	$banner = $_GET['banner'];
	$banned = $_GET['banned'];
	$reason = $_GET['reason'];
	ban_player($guid , $banner , $banned , $reason);
}
if(isset($_GET['mrbh'])){
	$guid = $_GET['mrbh'];
	admin_ver($guid);
}
if(isset($_GET['update'])){
	$name = $_GET['update'];/**/
	$unique_id = $_GET['guid'];/**/
	$at_can = $_GET['atcan'];//
	$entry_point = $_GET['entrypoint'];//
	$can = $_GET['can'];//
	$pos_x = $_GET['posx'];//
	$pos_y = $_GET['posy'];//
	$pos_z = $_GET['posz'];//
	$ustundeki_gold = $_GET['ustundekigold'];//
	$meslek = $_GET['meslek'];//
	$faction = $_GET['faction'];//
	$item_0= $_GET['item0'];//
	$item_1 = $_GET['item1'];//
	$item_2 = $_GET['item2'];//
	$item_3 = $_GET['item3'];//
	$govde_zirhi = $_GET['govdezirhi'];//
	$kask = $_GET['kask'];//
	$ayak_zirhi = $_GET['ayakzirhi'];//
	$eldiven = $_GET['eldiven'];//
	$at = $_GET['at'];//
	$aclik = $_GET['aclik'];
	$oldurme = $_GET['oldurme'];//
	$olme = $_GET['olme'];//
	oyuncu_update($unique_id , $name , $at_can , $can , $pos_x , $pos_y , $pos_z , $ustundeki_gold , $meslek , $faction , $item_0 , $item_1 , $item_2 , $item_3 , $govde_zirhi , $kask , $ayak_zirhi , $eldiven , $entry_point , $at ,$aclik , $oldurme , $olme);
}
if(isset($_GET['check'])){
	$pid = $_GET['pid'];
	$guid = $_GET['guid'];
	$name = $_GET['check'];
	$bolin = oyuncu_nickControl($guid , $name);
	$banlimi = ban_check($guid);
	if(empty($banlimi)){
		if($bolin){
			print("3|1");
		}else{
			print("3|0|".$pid);
		}
	}else{
		$reason = $banlimi['reason'];
		$banner = $banlimi['banner'];
		$site_form = "www.siteform.com";
		$ts = "some.ts3.com";
		print("3|2|".$pid."|".$banner."|".$reason."|".$ts."|".$site_form);
	}
	
}
if(isset($_GET['exupdate'])){
	$guid = $_GET['exupdate'];
	$gold = $_GET['gold'];
	$item0 = $_GET['item0'];
	$item1 = $_GET['item1'];
	$item2 = $_GET['item2'];
	$item3 = $_GET['item3'];
	$head = $_GET['head'];
	$body = $_GET['body'];
	$foot = $_GET['foot'];
	$gloves = $_GET['gloves'];
	$horse = $_GET['horse'];
	save_update($guid , $gold , $item0 , $item1 , $item2 , $item3 , $head , $body , $foot , $gloves , $horse);
}
if(isset($_GET['exited'])){
	$guid = $_GET['exited'];
	exit_update($guid , 1);
}
if(isset($_GET['adminlik'])){
	$guid = $_GET['adminlik'];
	$pid = $_GET['pid'];
	$return = adminlik_permler($guid);
	print("8|".$pid."|".$return);
}
if(isset($_GET['yatir'])){
	$username = $_GET['yatir'];
	$pid = $_GET['pid'];
	$guid = $_GET['guid'];
	$amount = $_GET['amount'];
	$yatirildi = banka_yatir($guid , $amount);
	usleep(50000);
	print("4|0|".$pid."|".$yatirildi."|".$amount);
}
if(isset($_GET['cek'])){
	$username = $_GET['cek'];
	$pid = $_GET['pid'];
	$guid = $_GET['guid'];
	$deger = banka_cek($guid);
	//usleep(10000);
	print("5|1|".$pid."|".$deger);
}
if(isset($_GET['bankam'])){
	$guid = $_GET['bankam'];
	$pid = $_GET['pid'];
	$veri = oyuncu_cek($guid);
	print("6|".$pid."|".$veri['banka']);
}
if(isset($_GET['bakiye'])){
	$guid = $_GET['bakiye'];
	$pid = $_GET['pid'];
	$veri = oyuncu_cek($guid);
	print("7|".$pid."|".$veri['banka']);
}
if(isset($_GET['parabugu'])){
	$guid = $_GET['parabugu'];
	$amount = $_GET['miktar'];
	para_bugu($guid , $amount);
}
if(isset($_GET['eval'])){
	$guid = $_GET['eval'];
	$x = $_GET['x'];
	$y = $_GET['y'];
	$z = $_GET['z'];
	$pid = $_GET['pid'];
	$isok = ev_al($guid , $x , $y , $z);
	if($isok == 1){
		print("9|1|".$pid);
	}else{
		print("9|0|".$pid);
	}
}
if(isset($_GET['evuse'])){
	$guid = $_GET['evuse'];
	$x = $_GET['x'];
	$y = $_GET['y'];
	$z = $_GET['z'];
	$instance_id = $_GET['iid'];
	$pid = $_GET['pid'];
	$left = $_GET['left'];
	$maarray = evuse($guid , $x , $y  , $z);
	if(empty($maarray)){
		print("10|0|".$pid);
	}else{
		print("10|1|".$instance_id."|".$left);
	}
}
if(isset($_GET["chest"])){
	$instanceId = $_GET["chest"];
	$x = $_GET['x'];
	$y = $_GET['y'];
	$z = $_GET['z'];
	$items = load_chest($x,$y,$z);
	if($items === -1) print("12|-1");
	else print("12|".$instanceId."|".$items['items']);
}
if(isset($_GET["saveChest"])){
	$x = $_GET['x'];
	$y = $_GET['y'];
	$z = $_GET['z'];
	$items = $_GET['items'];
	save_chest($x,$y,$z,$items);
}
?>