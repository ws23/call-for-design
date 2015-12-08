<?php
	require_once(dirname(__FILE__) . "/lib/std.php"); 

/* Create the tables in Database*/

	$DBmain->query('SET FOREIGN_KEY_CHECKS=0;');
	$DBmain->query('SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";'); 
	$DBmain->query('SET time_zone = "+08:00";'); 

	$DBmain->query("DROP TABLE `admin`; "); 
	$DBmain->query("DROP TABLE `department`; "); 
	$DBmain->query("DROP TABLE `draft`; "); 
	$DBmain->query("DROP TABLE `log`; "); 
	$DBmain->query("DROP TABLE `login`; "); 
	$DBmain->query("DROP TABLE `main`; "); 
	$DBmain->query("DROP TABLE `vote`; "); 
	
	$DBmain->query("SET FOREIGN_KEY_CHECKS=1;"); 

	echo "DROP TABLE SUCCESS"; 

?>
