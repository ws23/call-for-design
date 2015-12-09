<?php
	session_start(); 
	require_once(dirname(__FILE__) . "/lib/std.php"); 

	needLogin($DBmain); 

	if($_GET['module'] == 1){ // delete act
		$DBmain->query("UPDATE `main` SET `status` = 3 WHERE `mainID` = {$_GET['act']}; "); 
		locate($URLPv . "index.php"); 	
	}
	
	else if($_GET['module'] == 3) { // vote
		$result = $DBmain->query("SELECT * FROM `draft` WHERE `actID` = {$_GET['act']}; ");
		$rslt = $DBmain->query("SELECT * FROM `main` WHERE `mainID` = {$_GET['act']}; "); 

		$row = $result->fetch_array(MYSQLI_BOTH); 
		$rw = $rslt->fetch_array(MYSQLI_BOTH); 

		if(count($_POST['vote'])>$rw['voteLimit']){
			alert('每人最多 ' . $rw['voteLimit'] . ' 票，投票失敗，請重新選擇。'); 
			locate($URLPv . "vote.php?act={$_GET['act']}"); 
		}
		else{
			$votes = $_POST['vote'][0]; 
			for($i=0; $i<count($_POST['vote']); $i++){
				if($i!=0)
					$votes .= ',' . $_POST['vote'][$i]; 
				$DBmain->query("UPDATE `draft` SET `vote`=`vote`+1  WHERE `draftID` = '{$_POST['vote'][$i]}'; ");  
			}
			$DBmain->query("INSERT INTO `vote` (`user`, `actID`, `votes`, `time`)
								VALUES ('{$_SESSION['loginID']}', {$_GET['act']}, '{$votes}', CURRENT_TIMESTAMP); "); 
			alert('投票成功！'); 
			locate($URLPv . "view.php?act={$_GET['act']}"); 
		}
	
	}
	

?> 
