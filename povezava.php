<?php
/*
Povezava na strežnik
*/
$host = "localhost";
$user = "root";
$password = "";
$database = "pot";
/*samo strežnik*/
$link = mysqli_connect($host, $user, $password) or 
	die("Povezava na strežnik ni uspela.");
/*Izbira baze*/
mysqli_select_db($link, $database) or	
		die("Povezava na bazo ni uspela");
/*Za vključitev šumnikov*/
mysqli_set_charset($link, "utf8");
?>