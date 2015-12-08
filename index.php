<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");
?>

<div class="container">
	<table class="table">
		<tr>
			<th>徵稿活動名稱</th>
			<th>狀態</th>
			<th></th>
		</tr>
<?php
	$now = date("Y-m-d H:i:s", time()); 

	$result = $DBmain->query("SELECT * FROM `main` WHERE status = 1; "); 
	$states = array("即將徵稿", "徵稿中", "即將投票", "投票中", "即將公佈", "公佈結果"); 
	$colors = array("",         "info",   "warning",  "danger", "active",   "success"); 
	$events = array("",         "投稿去", "檢視稿件", "投票去", "檢視稿件", "看結果去"); 
	if($result->num_rows>0){
		while($row = $result->fetch_array(MYSQLI_BOTH)){
		if($now < strtotime($row['startCallForDesign']))
			$state = 0; 
		else if($now < strtotime($row['endCallForDesign']))
			$state = 1; 
		else if($now < strtotime($row['startVote']))
			$state = 2; 
		else if($now < strtotime($row['endVote']))
			$state = 3; 
		else if($now < strtotime($row['announce']))
			$state = 4; 
		else
			$state = 5; 
?>
		<tr class="<?php echo $colors[$state]; ?>">
			<td><?php echo $row['title']; ?></td>
			<td><?php echo $states[$state]; ?></td>
			<td><?php echo $events[$state]; ?></td>
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
