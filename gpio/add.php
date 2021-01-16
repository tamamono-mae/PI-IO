<?php
include 'config.inc.php';
//Connects to your Database 
$conect = mysqli_connect("$host", "$username", "$password", "$db_name") or die(mysql_error()); 

//This code runs if the form has been submitted
if (isset($_POST['submit'])) { 

//This makes sure they did not leave any fields blank
if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] ) {
	die('You did not complete all of the required fields');
}

// checks if the username is in use
if (!get_magic_quotes_gpc()) {
	$_POST['username'] = addslashes($_POST['username']);
	$_POST['username'] = mysqli_real_escape_string($conect, $_POST['username']);
}

$usercheck = $_POST['username'];
$check = mysqli_query($conect, "SELECT username FROM $tbl_name WHERE username = '$usercheck'") 
or die(mysqli_error());
$check2 = mysqli_num_rows($check);

//if the name exists it gives an error
if ($check2 != 0) {
 	die('Sorry, the username '.$_POST['username'].' is already in use.');
}

// this makes sure both passwords entered match
if ($_POST['pass'] != $_POST['pass2']) {
	die('Your passwords did not match. ');
}

// here we encrypt the password and add slashes if needed
if (!get_magic_quotes_gpc()) {
	$_POST['pass'] = addslashes($_POST['pass']);
	$_POST['username'] = addslashes($_POST['username']);
}

$_POST['pass'] = password_hash($_POST['pass'], PASSWORD_BCRYPT);

// now we insert it into the database
$insert = "INSERT INTO $tbl_name (username, password) VALUES ('".$_POST['username']."', '".$_POST['pass']."')";
$add_member = mysqli_query($conect, $insert);
?>

 <h1>Registered</h1>

 <p>Thank you, you have registered - you may now <a href="login.php">login</a>.</p>

 <?php 
 }

 else 
 {	
 ?>
 
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

 <table border="0">

 <tr><td>Username:</td><td>

 <input type="text" name="username" maxlength="60">

 </td></tr>

 <tr><td>Password:</td><td>

 <input type="password" name="pass" maxlength="10">

 </td></tr>

 <tr><td>Confirm Password:</td><td>

 <input type="password" name="pass2" maxlength="10">

 </td></tr>

 <tr><th colspan=2><input type="submit" name="submit" 
value="Register"></th></tr> </table>

 </form>

 <?php
 }
 ?> 
