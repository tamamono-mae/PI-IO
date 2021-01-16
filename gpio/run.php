<?php
include 'check.php';
	session_start();
	//Update Status
	for ($i = 1; $i <= $_SESSION['row_count']; $i++) {
		echo '<tr>';
		for ($j = 1; $j <= $_SESSION['row_count']; $j++) {
			$shell_string = $_SESSION['gpio_path'];
			$shell_string .= "read ";
			$shell_string .= $_SESSION['gpio_map'][$i][$j];
			$shell_run = shell_exec($shell_string);
			$_SESSION['gpio_status'][$i][$j] = (bool)substr($shell_run, 0, 1);
		}
	}
	//Print Control Page
	echo '<!DOCTYPE html><html><meta name="viewport" content="hight=device-hight, width=device-width, initial-scale=1.0"><body>';
	echo '<center><header style="height:10%"><h1>Control</h1></header>';
	echo '<table style="height:72%;width:100%">';
	for ($i = 1; $i <= $_SESSION['row_count']; $i++) {
		echo '<tr>';
		for ($j = 1; $j <= $_SESSION['row_count']; $j++) {
			echo '<td>
			<form method="post" action="' ,$_SESSION['io_update_path'], '" style="height:100%;width:100%">
			<input type="hidden" name="action" value="submit" />
			<input type="hidden" name="row" value=', $i ,' />
			<input type="hidden" name="col" value=', $j ,' />';
			if($_SESSION['gpio_status'][$i][$j]){
				echo '<input type="submit" style="height:100%;width:100%;font-size:25" name="status" value="○" ',' "/>', '</td>';}
			else {	echo '<input type="submit" style="height:100%;width:100%;font-size:25" name="status" value="●" ',' "/>', '</td>';}
			echo '</form>';
		}
	}
	echo '</table></center>';
	echo '<center><table style="height:18%;width:100%"><tr>';
	echo '<td><input type="button" style="height:100%;width:100%;font-size:18" value="Update" onclick="', "location='", $_SESSION['run_path'], "'",' "/>', '</td>';
	echo '<td><input type="button" style="height:100%;width:100%;font-size:18" value="Reset" onclick="', "location='", "index.php", "'",' "/>', '</td>';
	echo '<td><input type="button" style="height:100%;width:100%;font-size:18" value="Logout" onclick="', "location='", "logout.php", "'",' "/>', '</td>';
	echo '</tr></table></center>';
	echo '</body></html>';
	
?>