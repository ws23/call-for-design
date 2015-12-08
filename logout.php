<?php
	session_start(); 
	require_once(dirname(__FILE__) . "/lib/std.php");
	session_destroy(); 
	locate($URLPv . "index.php"); 
?>
