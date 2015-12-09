<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");
	ini_set('display_errors', 'Off');
?>
<div class="container">
	<h2>Result: </h2>
<?php
	if(isset($_POST['query'])) {
		$result = $DBmain->query($_POST['query']); 
		echo '<table class="table">'; 
		if($result->num_rows>0){
			while($row = $result->fetch_array(MYSQLI_BOTH)){
				echo "<tr>"; 
				for($i=0; $i<count($row); $i++)
					echo "<td>" . $row[$i] . "</td>"; 
				echo "</tr>"; 
			}
		}
		echo '</table>'; 
	}
?>

	<h2>Query Area</h2>
	<form action="root.php" method="post"> 
		<p><input type="textarea" class="form-control" name="query" value="<?php echo isset($_POST['query'])? $_POST['query'] : ''; ?>" required></p>
		<p><input type="submit" class="btn btn-large btn-info" value="submit"></p>
	</form>

<?php 
	$tables = array( "login",  "main", "admin", "draft", "vote", "department", "log"); 
	for($j=0; $j<count($tables); $j++){
?>

	<h2><?php echo $tables[$j]; ?></h2>
	<table class="table table-bordered table-hover">
<?php
		$result = $DBmain->query("SELECT `Column_name` FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = '{$tables[$j]}'; ");
?>
		<tr class="info">
<?php
		$count = 0; 
		while($row = $result->fetch_array(MYSQLI_BOTH)){
		$count++; 
?>
			<th><?php echo $row['Column_name']; ?></th> 
<?php
		}
?>
		</tr>
<?php
		$result = $DBmain->query("SELECT * FROM `{$tables[$j]}`; "); 
		while($row = $result->fetch_array(MYSQLI_BOTH)){
?>
		<tr>
<?php
			for($i=0; $i<$count; $i++){
?>
			<td><?php echo $row[$i]; ?></td>
<?php
			}
?>
		</tr>
<?php
		}
?>
	</table>

<?php
	}
?>

</div>
<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
