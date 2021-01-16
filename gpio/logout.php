<?php 
 $past = time() - 100; 
 //this makes the time in the past to destroy the cookie 
 setcookie("sid", NULL, $past);
 session_start();
 session_unset();
 session_register_shutdown ();
 session_destroy();
 header("Location: login.php"); 
 ?> 
