<?php
	session_start();
	$r = $_POST['row'];
	$c = $_POST['col'];
	$_SESSION['gpio_status'][$r][$c] = ! $_SESSION['gpio_status'][$r][$c];
	$shell_string = $_SESSION['py_path'];
	$shell_string .= $r; $shell_string .= " ";
	$shell_string .= $c;
	if($_SESSION['gpio_status'][$r][$c]){
		$shell_string .= " 1";
	} else{
		$shell_string .= " 0";
	}
	$shell_run = shell_exec($shell_string);
	header("Refresh: 0; URL={$_SESSION['run_path']}");
	
?>