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
		$state = getActState($DBmain, $_GET['act']); 
		$max = $row['voteLimit']; 
		$dept = $row['deptID']; 
	
		$canVote = false; 
		$isAdmin = false; 
		if(isset($_SESSION['loginID'])){
			if(checkExist($DBmain, $_SESSION['loginID'], $_SESSION['loginToken'])){
				if($state == 3)
					$canVote = true; 
			}
			if(checkAdmin($DBmain, $_SESSION['loginID']))
				$isAdmin = true; 
		}

?>
	<form method="post" action="process.php?act=<?php echo $_GET['act']; ?>&module=3">
		<table class="table table-bordered table-hover">
			<tr class="text-center">
<?php	if($canVote){	?>
				<th class="col-md-1">投票</th>
<?php	} ?>
				<th class="col-md-1">#</th>
<?php	if($state == 5 || $isAdmin) {	?>
				<th class="col-md-1">作者</th>
				<th class="col-md-1">得票數</th>
<?php	}	?>
				<th class="col-md-2">創作理念</th>
				<th class="col-md-6">設計稿(可點圖放大)</th>
			</tr>
<?php
		$result = $DBmain->query("SELECT * FROM `draft` 
									LEFT JOIN `login` ON `login`.`user` = `draft`.`user`
									WHERE `actID` = {$_GET['act']}; "); 
		if($result->num_rows>0){
			$count = 0; 
			while($row = $result->fetch_array(MYSQLI_BOTH)){
?>
			<tr>
<?php			if($canVote){	?>
				<td> 
					<input type="checkbox" class="form-control <?php echo $count==0? '{required:true,rangelength: [1,' .  $max . ']}"':''; ?>" name="vote[]" value="<?php echo $row['draftID']; ?>" required rangelength=[1,<?php echo $max; ?>]>
				</td> 
<?php			}	?>
				<td><?php echo $row['draftID']; ?></td> 
<?php 			if( $state == 5 || $isAdmin ){	?>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['vote']; ?></td>
<?php			}	?>
				<td><?php echo $row['idea']; ?></td>
				<td>
<?php
				$split = explode(",", $row['picItem']);
				for($i=0; $i<count($split); $i++){
?>
					<img src="https://googledrive.com/host/<?php echo $split[$i]; ?>" class="thumb" />
<?php			}	
				$count++; 
?>
				</td>
			</tr>
<?php
			}
		}
	if($canVote){
?>
			<tr>
				<td class="col-md-12" colspan="6">
					<input type="submit" class="form-control btn-success" value="點我確定投票">
				</td>
			</tr>
<?php }	?>
		</table>
	</form>
	<script>
		$('.container img').zoomify();
	</script>


<?php
	}
?>
</div>

<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
