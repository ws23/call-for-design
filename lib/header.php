<?php
	require_once(dirname(__FILE__) . "/std.php");
?>
<!Doctype html>
<html>
<head>
	<meta charset="utf8">

	<title>衣物設計徵稿系統</title>
	<link rel="stylesheet" href="<?php echo $URLPv; ?>lib/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo $URLPv; ?>lib/zoomify/zoomify.css">
	<link rel="stylesheet" href="<?php echo $URLPv; ?>stylesheets/index.css">
	<script src="<?php echo $URLPv; ?>lib/jquery/jquery-1.11.2.js"></script>
	<script src="<?php echo $URLPv; ?>lib/bootstrap/js/bootstrap.js"></script>
	<script src="<?php echo $URLPv; ?>lib/zoomify/zoomify.js"></script>
	<script src="<?php echo $URLPv; ?>lib/validator.min.js"></script>
</head>
<body>

	<!-- Fixed navbar -->
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.php">衣物設計徵稿系統</a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right">
							<?php 
								if(isset($_SESSION['loginID'])){ 	
									if(checkAdmin($DBmain, $_SESSION['loginID'])){
							?>
					<!--		<li><a href="<?php echo $URLPv; ?>admin.php">管理使用者</a></li>	-->
							<?php
									}
							?>
							<li><a href="<?php echo $URLPv; ?>regist.php">修改個人資料</a></li>
							<li><a href="<?php echo $URLPv; ?>logout.php">登出</a></li>
							<?php 
								} 
								else { 
							?>
							<li><a href="<?php echo $URLPv; ?>login.php">登入</a></li>
							<?php
								} 
							?>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>

    <!-- Fixed navbar -->
