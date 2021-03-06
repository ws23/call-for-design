<?php	/* standard function definitions */

/* To get the IP address of client */
function getIP() {
	if(!empty($_SERVER['REMOTE_ADDR']))
		$ip = $_SERVER['REMOTE_ADDR'];
	if(!empty($_SERVER['HTTP_X_FORWADED_FOR'])) {
		$ips = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']); 
		if($ip) {
			array_unshift($ips, $ip); 
			$ip = false; 
		}
		for($i=0; $i<count($ips); $i++) {
			if(!eregi("^(10|172.16|192.168).", $ips[$i])) {
				$ip = $ips[$i]; 
				break;	
			}
		}
	}
	return $ip; 
}


function alert($msg){
	echo "<script>\n"; 
	echo "alert('{$msg}'); \n"; 
	echo "</script>"; 
}

function locate($url){
	echo "<script>\n"; 
	echo "window.location.href = \"{$url}\";\n";
	echo "</script>"; 
}
/* Log, Need Database (MYSQL) */
function setLog($DBlink, $type="info", $content, $user=""){
	$ip = getIP(); 
	$url = $_SERVER['REQUEST_URI'];
	$user = $DBlink->real_escape_string($user); 
	$DBlink->query("INSERT INTO `log`(`type`, `msg`, `user`, `site`, `IP`) VALUES ('{$type}', '{$content}', '{$user}', '{$url}', '{$ip}'); ");
}

/* set Login */
function setLogin($DBlink, $user, $token){
	$ip = getIP(); 
	$result = $DBlink->query("SELECT * FROM `login` WHERE `user` = '{$user}'; "); 
	if($result->num_rows>0){
		$DBlink->query("UPDATE `login` SET `IP`= '{$ip}', `lastLogin` = CURRENT_TIMESTAMP , `token` = '{$token}' WHERE `user` = '{$user}'; "); 
	}
	else{
		$DBlink->query("INSERT INTO `login`(`user`, `IP`, `token`) VALUES('{$user}', '{$ip}', '{$token}'); "); 
	}
}

/* Check user Exist or not */
function checkExist($DBlink, $user, $token){
	$result = $DBlink->query("SELECT * FROM `login` WHERE `user` = '{$user}' && `token` = '{$token}'; "); 
	if($result->num_rows<=0)
		return false; 
	return true; 
}

/* Check user is Admin or not */
function checkAdmin($DBlink, $user){
	$result = $DBlink->query("SELECT * FROM `admin` WHERE `user` = '{$user}'; "); 
	if($result->num_rows<=0)
		return false; 
	return true; 
}

/* Check user has registed or not */
function checkReg($DBlink, $user){
	$result = $DBlink->query("SELECT * FROM `login` WHERE `user` = '{$user}' AND `name` != ''; "); 
	if($result->num_rows<=0)
		return false; 
	return true; 
}

/* Add user */
function updateUser($DBlink, $user, $name, $deptID, $token){
	if(!checkExist($DBlink, $user, $token))
		return false; 
	else{
		$DBlink->query("UPDATE `login` 
							SET `name` = '{$name}', 
								`deptID` = {$deptID}
							WHERE `user` = '{$user}'; ");
		
		return true; 
	}
}

/* FixZero */
function fixZero($val, $amount){
	$zero = $amount - strlen(strval($val)); 
	$str = ""; 
	for($i=0; $i<$zero; $i++)
		$str .= "0"; 
	$str .=  strval($val); 
	return $str; 
}

/* Generate token */
function genToken($DBlink, $user){
	list($usec, $sec) = explode(' ', microtime()); 
	$seed = (float)$sec + ((float)$usec*100000); 
	srand($seed); 
	
	$str = fixZero(rand(0, 99999999), 8); 
	$str .= $user; 
	$str .= getIP(); 
	
	$token = md5($str);
	
	$query = "UPDATE `login` SET `token` = '{$token}' WHERE `user` = '{$user}'"; 
	$DBlink->query($query); 
	return $token; 
}

/* POP3 Auth */
function CheckPOP3($server, $user, $pwd, $port = 110){
    //若任一欄位為空白則無效
    if (empty($server) || empty($user) || empty($pwd))
        return false;
    //連結POP3 Server
    $fs = fsockopen ($server, $port, $errno, $errstr, 5);
    //檢查是否連線
    if (!$fs)
        return false;
    //connected...
    $msg = fgets($fs,256);
    //step 1. 傳送帳號
    fputs($fs, "USER $user\r\n");
    $msg = fgets($fs,256);
    if (strpos($msg,"+OK")===false)
        return false;
    //step 2. 傳送密碼
    fputs($fs, "PASS $pwd\r\n");
    $msg = fgets($fs,256);
    if (strpos($msg,"+OK")===false)
        return false;
    //step 3.通過認證 QUIT
    fputs($fs, "QUIT \r\n");
    fclose($fs);
    return true;
}

/* Judge the time state */
function getActState($DBlink, $id){
	$now = time(); 

	$result = $DBlink->query("SELECT * FROM `main` WHERE `mainID` = {$id}; ");
	if($result->num_rows<1)
		return -1; 
	$row = $result->fetch_array(MYSQLI_BOTH); 

	if($now < strtotime($row['startCallForDesign']))
		return 0; 
	if($now < strtotime($row['endCallForDesign']))
		return 1; 
	if($now < strtotime($row['startVote']))
		return 2; 
	if($now < strtotime($row['endVote']))
		return 3; 
	if($now < strtotime($row['announceTime']))
		return 4; 
	return 5; 

}
