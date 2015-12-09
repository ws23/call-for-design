<?php
	ini_set('display_errors', 'On');
	ini_set('date.timezone', 'Asia/Taipei'); 
	
	require_once(dirname(__FILE__) . "/conf.php"); 
	require_once(dirname(__FILE__) . "/lib.php");
	
       
	$DBmain = new mysqli(null, $DBUser, $DBPassword, $DBName, null, $DBCloud);
	if($DBmain->connect_error){
		$DBmain = new mysqli($DBHost, $DBUser, $DBPassword, $DBName); 
		if($DBmain->connect_error)	
			die('Connect Error ( ' . $DBmain->connect_errno . ' ) ' . $DBmain->connect_error); 
	}
	$DBmain->query('SET NAMES "utf8"; '); 
	$DBmain->query('SET CHARACTER SET "utf8"; '); 
	$DBmain->query('SET character_set_result = "utf8"; '); 
	$DBmain->query('SET character_set_client = "utf8"; '); 
	$DBmain->query('SET character_set_connection = "utf8"; '); 
	$DBmain->query('SET character_set_database = "utf8"; '); 
	$DBmain->query('SET character_set_server = "utf8"; '); 

	$throw = array("/regist.php", "/root.php"); 

	// check if login & is login correct or not
	if(isset($_SESSION['loginID']) && isset($_SESSION['loginToken'])){
		if(!checkExist($DBmain, $_SESSION['loginID'], $_SESSION['loginToken'])){
			locate($URLPv . "logout.php"); 
		}
		// check regist or not
		$skip = false; 
		if(!checkReg($DBmain, $_SESSION['loginID'])){
			for($i=0; $i<count($throw); $i++)
				if($throw[$i] == $URI)
					$skip = true; 
			if($skip == false)
				locate($URLPv . "regist.php"); 
		}
	}


	function needLogin($DBlink){
		if(!isset($_SESSION['loginID']) || !isset($_SESSION['loginToken'])){
			alert('Please login first. '); 
			locate($URLPv . "login.php"); 
			return; 
		}
		if(!checkExist($DBlink, $_SESSION['loginID'], $_SESSION['loginToken'])){
			alert('Please login first. '); 
			locate($URLPv . "login.php"); 
			return; 
		}
	}

	function needAdmin($DBlink){
		if(!checkAdmin($DBlink, $_SESSION['loginID'])){
			alert('Permission deny'); 
			locate($URLPv . "index.php"); 
			return; 
		}
	}

?> 
