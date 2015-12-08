<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");

	needLogin(); 

	if(isset($_POST['name'])){
		if($_POST['name'] != ""){
			updateUser($DBmain, $_SESSION['loginID'], $_POST['name'], $_POST['dept'], $_SESSION['loginToken']);
			locate($URLPv . "index.php"); 
		}
	}
	else{
		$result = $DBmain->query("SELECT `user`, `login`.`name`, `department`.`name` 
									FROM `user`, `department`
										WHERE `user` = '{$_SESSION['loginID']}'; "); 
		$exist = $result->num_rows; 
		if($exist>0)
			$info = $result->fetch_array(MYSQLI_BOTH);
?>

<div class="container">
	<form action="regist.php" method="post">
		<table class="table table-bordered">
			<tr>
				<td>帳號</td>
				<td><?php echo $_SESSION['loginID']; ?></td>
			</tr>
			<tr>
				<td>姓名</td>
				<td>
					<input type="text" class="form-control" name="name" placeholder="姓名" value="<?php echo $exist>0? $info[1] : ''; ?>" maxlength="40" required>
				</td>
			</tr>
			<tr>
				<td>系所</td>
				<td>
					<select class="form-control" name="dept">
						<?php 
							$result = $DBmain->query("SELECT `deptID`, `name` FROM `department`; "); 
							while($depts = $result->fetch_array(MYSQLI_BOTH)){
						?>
						<option value="<?php echo $depts['deptID']; ?>" <?php echo $exist>0? "selected":""?>>
							<?php echo $depts['name']; ?>
						</option>
						<?php
							}
						?>
					</select>
				</td>
		</table>
	</form>
</div>

<?php 
	}
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
