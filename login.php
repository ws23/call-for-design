<?php
	session_start(); 
	require_once(dirname(__FILE__) . "/lib/header.php"); 
		if(isset($_SESSION['loginID']))
			locate($URLPv . "index.php"); 
		else if(isset($_POST['stuID']) && isset($_POST['stuPW'])) {
			if(CheckPOP3($_POST['mailserver'] . ".ndhu.edu.tw", $_POST['stuID'], $_POST['stuPW'])){
				
				$_SESSION['loginID'] = $_POST['stuID']; 
				$_SESSION['loginToken'] = genToken($DBmain, $_SESSION['loginID']);
				setLogin($DBmain, $_SESSION['loginID'], $_SESSION['loginToken']); 
				if(checkAdmin($DBmain, $_SESSION['loginID']))
					setLog($DBmain, "info", "Admin Login", $_SESSION['loginID']);

				if(checkReg($DBmain, $_SESSION['loginID']))
					locate($URLPv . "index.php"); 
				else
					locate($URLPv . "regist.php"); 
			}
			else{ 
				alert("Login Failed! Please try again. "); 
				locate($URLPv . "login.php"); 
			}
		}
		else {  ?>
	<div class="login">
		<form action="login.php" method="post">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="control-label col-sm-2">Email: </label>
					<div class="col-sm-4">
						<input type="text" name="stuID" placeholder="NDHU mail" class="form-control" required> 
					</div>
					<div class="col-sm-6">
						<select class="form-control" name="mailserver">
							<option value="ems">@ems.ndhu.edu.tw</option>
							<option value="mail">@mail.ndhu.edu.tw</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Password: </label>
					<div class="col-sm-10">
						<input type="password" name="stuPW" placeholer="Password" class="form-control" required>
					</div>
				</div>
				<div class="form-group">
					<input type="submit" value="Login" class="form-control btn btn-success" disable>
				</div>
				<div class="form-group has-error">
					<label class="control-label">敬請使用東華大學信箱登入</label>
				</div>
			</div>
		</form>
	</div>

<?php	}	?>
