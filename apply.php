<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");

	if(!isset($_GET['act']))
		$_GET['act'] = -1; 
    else if(!is_numeric($_GET['act']))
        $_GET['act'] = -1;

    $result = $DBmain->query("SELECT * FROM `main`
                                LEFT JOIN `department` ON `deptID` = `voteDept`
                                WHERE `mainID` = {$_GET['act']} AND `status` != 3; ");
    $row = $result->fetch_array(MYSQLI_BOTH);

	if(isset($_POST['update'])){
		if($_POST['update'] == 1){
			$DBmain->query("UPDATE `main`
								SET `title` = '{$_POST['title']}', 
									`content` = '{$_POST['content']}', 
									`startCallForDesign` = '{$_POST['startCall']}', 
									`endCallForDesign` = '{$_POST['endCall']}', 
									`startVote` = '{$_POST['startVote']}', 
									`endVote` = '{$_POST['endVote']}', 
									`announceTime` = '{$_POST['announceTime']}', 
									`picNum` = '{$_POST['picNum']}', 
									`picItemName` = '{$_POST['picItemName']}', 
									`voteLimit` = '{$_POST['voteLimit']}', 
									`voteDept` = '{$_POST['deptID']}'
								WHERE `mainID` = '{$_GET['act']}'; "); 
		}
		else if($_POST['update'] == 0){
			$result = $DBmain->query("SELECT `AUTO_INCREMENT`
										FROM  INFORMATION_SCHEMA.TABLES
										WHERE TABLE_SCHEMA = 'call_for_design'
										AND   TABLE_NAME   = 'main';"); 
			$actID = $result->fetch_array(MYSQLI_BOTH); 
			$DBmain->query("INSERT INTO `main` 
								(`title`, `content`, `startCallForDesign`, `endCallForDesign`, 
								`startVote`, `endVote`, `announceTime`, `picNum`, `picItemName`, 
								`voteLimit`, `voteDept`, `status`)
								VALUES
								('{$_POST['title']}', '{$_POST['content']}', '{$_POST['startCall']}', '{$_POST['endCall']}', 
								'{$_POST['startVote']}', '{$_POST['endVote']}', '{$_POST['announceTime']}', 
								'{$_POST['picNum']}', '{$_POST['picItemName']}', '{$_POST['voteLimit']}', 
								'{$_POST['deptID']}', 1);");
			$_GET['act'] = $actID[0]; 
			
		}
		locate($URLPv . "view.php?act=" . $_GET['act']); 
	}
?>

<div class="container">
<?php
    if($result->num_rows<1) 
		$update = false; 
    else 
		$update = true; 
?>

<div class="container">
	<form action="apply.php?act=<?php echo $_GET['act']; ?>" method="post">
	<input type="hidden" name="update" value="<?php echo $update? 1:0; ?>">
    <table class="table table-bordered table-hover">
		<tr>
			<td class="col-md-2">標題</td>
			<td class="col-md-10"><input type="text" class="form-control" name="title" value="<?php echo $update? $row['title'] : ""; ?>" maxlength="30" required></td>
		</tr>
        <tr>
            <td class="col-md-2">徵稿說明</td>
            <td class="col-md-10"><input type="textarea" class="form-control" name="content" value="<?php echo $update? $row['content'] : ""; ?>" rows="6" required></td>
        </tr>
        <tr>
            <td class="col-md-2">徵稿開始時間</td>
            <td class="col-md-10">
				<input type="text" class="form-control" name="startCall" value="<?php echo $update? $row['startCallForDesign'] : ""; ?>" required>
				<label class="label-danger">請以 xxxx-xx-xx xx:xx:xx 方式輸入</label>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">徵稿結束時間</td>
            <td class="col-md-10">
				<input type="text" class="form-control" name="endCall" value="<?php echo $update? $row['endCallForDesign'] : ""; ?>" required>
				<label class="label-danger">請以 xxxx-xx-xx xx:xx:xx 方式輸入</label>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">投票開始時間</td>
            <td class="col-md-10">
				<input type="text" class="form-control" name="startVote" value="<?php echo $update? $row['startVote'] : ""; ?>" required>
				<label class="label-danger">請以 xxxx-xx-xx xx:xx:xx 方式輸入</label>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">投票結束時間</td>
            <td class="col-md-10">
				<input type="text" class="form-control" name="endVote" value="<?php echo $update? $row['endVote'] : ""; ?>" required>
				<label class="label-danger">請以 xxxx-xx-xx xx:xx:xx 方式輸入</label>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">投票結果公佈時間</td>
			<td class="col-md-10">
				<input type="text" class="form-control" name="announceTime" value="<?php echo $update? $row['announceTime'] : ""; ?>" required>
				<label class="label-danger">請以 xxxx-xx-xx xx:xx:xx 方式輸入</label>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">設計圖應繳數量</td>
            <td class="col-md-10">
				<input type="number" class="form-control" name="picNum" value="<?php echo $update? $row['picNum'] : ""; ?>" required>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">設計圖應繳類型</td>
            <td class="col-md-10">
				<input type="text" class="form-control" name="picItemName" value="<?php echo $update? $row['picItemName'] : ""; ?>" required>
				<label class="label-danger">請以 , 分隔每個項目，例如：正面,反面</label>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">每人可投票數</td>
            <td class="col-md-10">
				<input type="number" class="form-control" name="voteLimit" value="<?php echo $update? $row['voteLimit'] : ""; ?>" required>
			</td>
        </tr>
        <tr>
            <td class="col-md-2">擁有投票資格之系所</td>
            <td class="col-md-10">
				<select class="form-control" name="deptID">
					<option value="0" <?php echo $row['voteDept'] == 0? "selected":""; ?>>不限制</option>
				<?php 
					$result = $DBmain->query("SELECT * FROM `department`; ");
					while($depts = $result->fetch_array(MYSQLI_BOTH)){
				?>
					<option value="<?php echo $depts['deptID']; ?>" <?php echo $row['voteDept'] == $depts['deptID']? "selected":""; ?>><?php echo $depts['deptName']; ?></option>
				<?php
					}
				?>
				</select>
			</td>
        </tr>
		<tr>
			<td colspan="2">
				<input type="submit" class="form-control" value="<?php echo $update? '更新':'創建'?>">
			</td>
		</tr>
    </table>
	
	</form>
</div>

<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
