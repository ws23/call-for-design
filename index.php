<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");
?>

<div class="container">

    <p class="text-right">
<?php
        if(isset($_SESSION['loginID'])){
            if(checkAdmin($DBmain, $_SESSION['loginID'])){
?>
    <a href="apply.php?"><input type="button" class="btn btn-large btn-info" value="創建活動"></a>
<?php
			}
		}

?>
	<table class="table">
		<tr>
			<th class="col-ms-8">徵稿活動名稱</th>
			<th class="col-ms-2">狀態</th>
			<th class="col-ms-2"></th>
		</tr>
<?php

	$result = $DBmain->query("SELECT * FROM `main` WHERE `status` = 1 ORDER BY `startCallForDesign` DESC; "); 
	$states = array("即將徵稿", "徵稿中", "即將投票", "投票中", "即將公佈", "公佈結果"); 
	$colors = array("",         "info",   "",         "danger", "",         "success"); 
	$events = array("",         "投稿去", "檢視稿件", "投票去", "檢視稿件", "看結果去");


	if($result->num_rows>0){
		while($row = $result->fetch_array(MYSQLI_BOTH)){
			$state = getActState($DBmain, $row['mainID']);
			if($state == -1)
				continue; 
?>
		<tr class="<?php echo $colors[$state]; ?>">
			<td><a href="view.php?act=<?php echo $row['mainID']; ?>"><b><?php echo $row['title']; ?></b></td>
			<td><?php echo $states[$state]; ?></td>
			<td><a href="<?php echo $state==1? "add.php?act=".$row['mainID'] : "vote.php?act=".$row['mainID']; ?>"><?php echo $events[$state]; ?></td>
		</tr>
<?php
		}
	}
?>
	</table>
</div>

<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
