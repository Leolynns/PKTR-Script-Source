<?php

date_default_timezone_set('Europe/Istanbul');


$saatler = [4 , 16]; //23 -> 0

$saat_now = intval(date('H'));
$dakika_now = intval(date('i'));

$saat_selected = 0;

$flag = false;

foreach($saatler as $saat){
	if($saat * 60 >= ($saat_now * 60) + $dakika_now){
		$flag = true;
		break;
	}
}
if(!$flag){
	$saat_now = $saat_now % 12;
	$saat = $saatler[0];
	if($saat_now >= $saat) $saat += 12; 
}
$diff = ($saat * 60) - (($saat_now * 60) + $dakika_now);
print("98|$diff");
?>