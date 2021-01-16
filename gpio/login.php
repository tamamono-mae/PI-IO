<?php 
include 'config.inc.php';
//Connects to your Database 
$conect = mysqli_connect("$host", "$username", "$password" , "$db_name") or die(mysql_error()); 

//Checks if there is a login cookie
if(isset($_COOKIE['sid'])){ //if there is, it logs you in and directes you to the members page
 	$usercheck = $_COOKIE['sid'];
	$check = mysqli_query($conect, "SELECT username FROM $tbl_name WHERE username = '$usercheck'") or die(mysqli_error());
	session_start();
	$login_alive = (mysqli_num_rows($check) == 1) && $_SESSION['is_login'] && ($_SESSION['time_up'] > time());
	
	if($login_alive){
		header("Location: $redirect_url");
	}
 }

 //if the login form is submitted 
 if (isset($_POST['submit'])) {

	// makes sure they filled it in
 	if(!$_POST['username']){
 		die('You did not fill in a username.');
 	}
 	if(!$_POST['pass']){
 		die('You did not fill in a password.');
 	}

 	// checks it against the database
 	if (!get_magic_quotes_gpc()){
 		$_POST['email'] = addslashes($_POST['email']);
 	}

 	$check = mysqli_query($conect, "SELECT * FROM $tbl_name WHERE username = '".$_POST['username']."'")or die(mysql_error());

	//Gives error if user dosen't exist
	$check2 = mysqli_num_rows($check);
	if ($check2 == 0){
	die('That user does not exist in our database.<br /><br />If you think this is wrong <a href="login.php">try again</a>.');
}

while($info = mysqli_fetch_array( $check )){
	$_POST['pass'] = stripslashes($_POST['pass']);
	$_POST['pass'] = mysqli_real_escape_string($conect, $_POST['pass']);
 	$info['password'] = stripslashes($info['password']);
 	//$_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

	//gives error if the password is wrong
 	if (! password_verify($_POST['pass'] , $info['password'])){
 		//then redirect them to the members area 
 		die('Incorrect password, please <a href="login.php">try again</a>.');
 	}
	
	else{ 
		$_POST['username'] = stripslashes($_POST['username']); 
		$_POST['username'] = mysqli_real_escape_string($conect, $_POST['username']);
		$_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);
		echo $_POST['pass'];
		$hour = time() + 3600; 
		setcookie("sid", $_POST['username'], $hour); 
		//setcookie("key", $_POST['pass'], $hour);
		session_start();
		$_SESSION['is_login'] = true;
		$_SESSION['time_up'] = $hour;
		// if login is ok then we add a cookie
		//header("Refresh: 0; URL=main.php");
		header("Location: main.php");
	}
}
}
else{
// if they are not logged in 
?>
<!DOCTYPE html>
<html><meta name="viewport" content="hight=device-hight, width=device-width, initial-scale=1.0">
	<body><center>
 		<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 

 		<table width="100%" border="0"> 

 		<tr><td colspan=2><h1>Login</h1></td></tr> 

		<tr>
		<td>Username:</td><td> 

		<input type="text" name="username" style="width:100%" maxlength="40"> 

		</td></tr> 

		<tr><td>Password:</td><td> 

		<input type="password" name="pass" style="width:100%"maxlength="50"> 

		</td></tr> 

		<tr><td colspan="2" align="right"> 

		<input type="submit" name="submit" style="width:100%" style="width:100%;font-size:12" value="Login"> 

		</td></tr> 

		</table> 

		</form>
	</center></body>

</html>

 <?php 
 }
 ?> 
