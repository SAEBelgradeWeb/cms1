<?php 
require_once('config.php');
error_reporting(2);

$conn = mysql_connect(HOSTNAME, DBUSER, DBPASS);

if(!$conn) {
	echo "Konekcija na bazu nije uspesna";
	die();
}

$db = mysql_select_db(DBNAME, $conn);

if(!$db) {
	echo "Ova baza ne moze biti otvorena";
	die();
}

 ?>