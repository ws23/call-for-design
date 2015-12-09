<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");

	if(!is_numeric($_GET['act']))
		$_GET['act'] = -1; 
	
	$now = time(); 

	$result = $DBmain->query("SELECT * FROM `main`
								LEFT JOIN `department` ON `deptID` = `voteDept`
								WHERE `mainID` = {$_GET['act']} AND `status` != 3; "); 
	$row = $result->fetch_array(MYSQLI_BOTH); 
?>

<div class="container">
<?php
	if($result->num_rows<1)
		echo '<table class="table danger"><tr><td><h2 class="text-center">This page is not exist or permission deny. </h2></td></tr></table>';
	else if($row['status'] == 2){
		if(!isset($_SESSION['loginID']))
			echo '<table class="table danger"><tr><td><h2 class="text-center">This page is not exist or permission deny. </h2></td></tr></table>';
		if(!checkAdmin($DBmain, $_SESSIN['loginID']))
			echo '<table class="table danger"><tr><td><h2 class="text-center">This page is not exist or permission deny. </h2></td></tr></table>';
	}
	else {
?>
	<h2 class="text-center"><?php echo $row['title']; ?></h2>
	<p class="text-right">
<?php
		if(isset($_SESSION['loginID'])){
			if(checkAdmin($DBmain, $_SESSION['loginID'])){
?>
	<a href="apply.php?act=<?php echo $_GET['act']; ?>"><input type="button" class="btn btn-large btn-info" value="修改活動"></a>
	&nbsp;
	<input type="button" class="btn btn-large btn-danger" value="刪除活動" onclick="wantDelete(); ">
	&nbsp; 
<?
			}
		}
		$state = getActState($DBmain, $_GET['act']);
		$events = array( "", "我要投稿", "檢視稿件", "我要投票", "檢視稿件", "檢視結果" ); 
		if($state == 1){
?>
	<a href="add.php?act=<?php echo $_GET['act']; ?>"><input type="button" class="btn btn-large btn-success" value="我要投稿"></a>
<?php
		}
		else if($state == -1)
			; 	
		else if($state != 0){
?>
	<a href="vote.php?act=<?php echo $_GET['act']; ?>"><input type="button" class="btn btn-large btn-success" value="<?php echo $events[$state]; ?>"></a>
<?php
		}
?>	
	</p>
	<table class="table">
		<tr>
			<td class="col-md-2">徵稿說明</td>
			<td class="col-md-10"><?php echo $row['content']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">徵稿開始時間</td>
			<td class="col-md-10"><?php echo $row['startCallForDesign']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">徵稿結束時間</td>
			<td class="col-md-10"><?php echo $row['endCallForDesign']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">投票開始時間</td>
			<td class="col-md-10"><?php echo $row['startVote']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">投票結束時間</td>
			<td class="col-md-10"><?php echo $row['endVote']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">投票結果公佈時間</td>
			<td class="col-md-10"><?php echo $row['announceTime']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">設計圖應繳數量</td>
			<td class="col-md-10"><?php echo $row['picNum']; ?> 張</td>
		</tr>
		<tr>
			<td class="col-md-2">設計圖應繳類型</td>
			<td class="col-md-10"><?php echo $row['picItemName']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">每人可投票數</td>
			<td class="col-md-10"><?php echo $row['voteLimit']; ?></td>
		</tr>
		<tr>
			<td class="col-md-2">擁有投票資格之系所</td>
			<td class="col-md-10"><?php echo $row['voteDept']==0? "不限制" : $row['deptName']; ?></td>
		</tr>
	</table>
<?php
	}
?>
</div>

<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
<script>
	function wantDelete(){
		if(window.confirm('確定要刪除此活動嗎？一旦刪除就無法復原囉！') == true)
			window.location.href = "process.php?act=<?php echo $_GET['act']; ?>&module=1";
	}
</script>
