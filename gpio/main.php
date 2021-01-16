<?php
include 'check.php';
	session_start();
			
	$session_url = session_name();
	$session_url .= "=";
	$session_url .= session_id();
	
	$_SESSION['gpio_status'] = array();
	$_SESSION['op_url'] = array();
	$_SESSION['gpio_map'] = array();
	$_SESSION['gpio_path'] = "/usr/bin/gpio -g ";
	$_SESSION['row_count'] = 4;
	$_SESSION['col_count'] = 4;
	
	$_SESSION['gpio_map'][1][1] = 4;
	$_SESSION['gpio_map'][1][2] = 17;
	$_SESSION['gpio_map'][1][3] = 27;
	$_SESSION['gpio_map'][1][4] = 22;
	$_SESSION['gpio_map'][2][1] = 5;
	$_SESSION['gpio_map'][2][2] = 6;
	$_SESSION['gpio_map'][2][3] = 13;
	$_SESSION['gpio_map'][2][4] = 19;
	$_SESSION['gpio_map'][3][1] = 18;
	$_SESSION['gpio_map'][3][2] = 23;
	$_SESSION['gpio_map'][3][3] = 24;
	$_SESSION['gpio_map'][3][4] = 25;
	$_SESSION['gpio_map'][4][1] = 12;
	$_SESSION['gpio_map'][4][2] = 16;
	$_SESSION['gpio_map'][4][3] = 20;
	$_SESSION['gpio_map'][4][4] = 21;
	
	/*
	$setmode17 = shell_exec("/usr/bin/gpio -g mode 17 out");
	$gpio_off17 = shell_exec("/usr/bin/gpio -g write 17 0");
	$setmode27 = shell_exec("/usr/bin/gpio -g mode 27 out");
	$gpio_off27 = shell_exec("/usr/bin/gpio -g write 27 0");
	$setmode22 = shell_exec("/usr/bin/gpio -g mode 22 out");
	$gpio_off22 = shell_exec("/usr/bin/gpio -g write 22 0");
	$setmode23 = shell_exec("/usr/bin/gpio -g mode 23 out");
	$gpio_off23 = shell_exec("/usr/bin/gpio -g write 23 0");
	
	$setmode00 = shell_exec("/usr/bin/gpio -g mode 00 out");
	$gpio_off00 = shell_exec("/usr/bin/gpio -g write 00 0");
	*/
	
	
	for ($i = 1; $i <= $_SESSION['row_count']; $i++) {
		for ($j = 1; $j <= $_SESSION['row_count']; $j++) {
			//Parameter
			$_SESSION['gpio_status'][$i][$j] = false;
			$_SESSION['op_url'][$i][$j] = $i;
			$_SESSION['op_url'][$i][$j] .= $j;
			$_SESSION['op_url'][$i][$j] .= ".php?";
			$_SESSION['op_url'][$i][$j] .= $session_url;
			//Set Out
			$shell_string = $_SESSION['gpio_path'];
			$shell_string .= "mode ";
			$shell_string .= $_SESSION['gpio_map'][$i][$j];
			$shell_string .= " out";
			$shell_run = shell_exec($shell_string);
			//Reset
			$shell_string = $_SESSION['gpio_path'];
			$shell_string .= "write ";
			$shell_string .= $_SESSION['gpio_map'][$i][$j];
			$shell_string .= " 0";
			$shell_run = shell_exec($shell_string);	
		}
	}
	$url  = "io_update.php?"; $url .= $session_url;
	$_SESSION['io_update_path'] = $url;
	$url  = "run.php?"; $url .= $session_url;
	$_SESSION['run_path'] = $url;
	
	//print_r($_SESSION['op_url']);
	//echo 'run';
	header("Refresh: 0; URL={$url}");
	
?>