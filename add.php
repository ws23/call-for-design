<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");

	needLogin($DBmain); 

    if(!is_numeric($_GET['act']))
        $_GET['act'] = -1;

    $now = time();

    $result = $DBmain->query("SELECT * FROM `main`
                                LEFT JOIN `department` ON `deptID` = `voteDept`
                                WHERE `mainID` = {$_GET['act']} AND `status` != 3; ");
	if($result->num_rows<=0)
		locate($URLPv . 'index.php'); 

    $row = $result->fetch_array(MYSQLI_BOTH);

	if(isset($_POST['idea'])){
		
		$str = $_POST['id'][0];
		for($i=1; $i<count($_POST['id']); $i++)
			$str .= ',' . $_POST['id'][$i]; 

		$DBmain->query("INSERT INTO `draft` (`user`, `actID`, `idea`, `picItem`)
							VALUES ('{$_SESSION['loginID']}', '{$_GET['act']}', 
								'{$_POST['idea']}', '{$str}'); "); 
		locate($URLPv . "view.php?act={$_GET['act']}"); 
	}
	else {
?>

<div class="container">
	<form action="add.php?act=<?php echo $_GET['act']; ?>" method="post">
		<h2 class="text-center"><?php echo $row['title']; ?></h2>
		<table class="table table-bordered table-hover">
			<tr>
				<td class="col-md-2">創作理念</td>
				<td class="col-md-10" colspan="2">
					<input type="text" class="form-control" name="idea" required>
				</td>
			</tr>
<?php
		$items = explode(",", $row['picItemName']); 
		for($i=0; $i<count($items); $i++){
?>
			<tr>
				<td class="col-md-2">上傳圖檔ID</td>
				<td class="col-md-2"><?php echo $items[$i]; ?></td>
				<td class="col-md-8">
					<input type="text" class="form-control" name="id[]" required>
					<div class="form-group has-danger">
						<a href="https://script.google.com/macros/s/AKfycbx6I3Ys8UYre3klH35-IelMTCFY2pZIqCcFWeoTHGceA-FMZiws/exec" target="_blank"><label class="label-control">點我上傳圖檔並取得ID</a>
					</div>
				</td>
			</tr>
<?php	}	?>
			<tr>
				<td class="col-md-12" colspan="3">
					<input class="form-control" type="submit" value="送出稿件">
				</td>
			</tr>
		</table>
	</form>
</div>

<?php 
	}
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
