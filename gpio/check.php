<?php
include 'config.inc.php';
//Connects to your Database 
$conect = mysqli_connect("$host", "$username", "$password", "$db_name") or die(mysql_error()); 

 //checks cookies to make sure they are logged in 
if(isset($_COOKIE['sid'])){ 
	$usercheck = $_COOKIE['sid'];
	$check = mysqli_query($conect, "SELECT username FROM $tbl_name WHERE username = '$usercheck'") or die(mysqli_error());
	session_start();
	$login_alive = (mysqli_num_rows($check) == 1) && $_SESSION['is_login'] && ($_SESSION['time_up'] > time());
	if(! $login_alive){
		header("Location: login.php");
	}
	
}

else{ //if the cookie does not exist, they are taken to the login screen 
	header("Location: login.php"); 
}
?>
