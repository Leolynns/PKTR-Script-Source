<?php
$server_welcome_message = "hyperion RPG sunucusuna hoş geldiniz, iyi roller!";
$db_username = "root";
$db_password = "xxx";
$db_host = "localhost";
$db_database = "pk_panel";
$db = new PDO("mysql:host=".$db_host.";dbname=".$db_database , $db_username , $db_password);
?>