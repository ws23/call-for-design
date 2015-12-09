<?php 
	session_start(); 
	require(dirname(__FILE__) . "/lib/header.php");
?>

<div class="container">
<?php	echo $_SESSION['loginID']; ?>
</div>


<?php 
	require(dirname(__FILE__) . "/lib/footer.php"); 
?>
