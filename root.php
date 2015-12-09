<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");
	ini_set('display_errors', 'On');
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

	<h2>Login</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `login`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

	<h2>Main</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `main`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

	<h2>Draft</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `draft`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

	<h2>Vote</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `vote`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

	<h2>Admin</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `admin`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

	<h2>Department</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `department`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

	<h2>Log</h2>
	<table class="table">
<?php
	$result = $DBmain->query("SELECT * FROM `log`; "); 
	while($row = $result->fetch_array(MYSQLI_BOTH)){
		echo "<tr>"; 
		for($i=0; $i<count($row); $i++)
			echo "<td>" . $row[$i] . "</td>"; 
		echo "</tr>"; 
	}
?>
	</table>

</div>
<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
