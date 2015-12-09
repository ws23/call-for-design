<?php
	session_start(); 
	require_once(dirname(__FILE__) . "/lib/std.php"); 

	needLogin($DBmain); 

	if($_GET['module'] == 1){ // delete act
		$DBmain->query("UPDATE `main` SET `status` = 3 WHERE `mainID` = {$_GET['act']}; "); 
		locate($URLPv . "index.php"); 	
	}
	
?> 
