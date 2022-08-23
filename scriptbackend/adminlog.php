<?php 
if(isset($_GET['log'])){
	$log = $_GET['log'];
	$filename = date("d.m.y").".txt";
	$myfile = fopen($filename , 'a');
	fwrite($myfile , date("H:i:s")." ".$log."\n");
	fclose($myfile);
}



?>