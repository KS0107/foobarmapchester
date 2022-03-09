<!-- <?php
session_start();
if (!isset($_SESSION['login']))
{
  $_SESSION['login'] = true;
}
?> -->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="../CSS/mainstyle.css">
	<link rel="stylesheet" href="../CSS/loginPage.css">
	<script src="../Javascripts/funcs.js"></script>
</head>
<body>
	<div class="topBar">
        <div id="buttonLinks">
            <button id="btnIP">Home  Page</button>
            <!-- <button id="btnMP">Map Page</button>
            <button id="btnRP">Review Page</button>
            <button id="btnTP">Timetable</button> -->
            <button id="btnLP">Sign In</button>
        </div>
    </div>
		<div class="mainBody">
			<form class="form" action="../restapi/index.php/user/authen" method="get">
			<span class="label-input">Username</span>
				<div class="wrap-input">
			
					<input class="input" type="text" name="username" placeholder="Input username">
				</div>
				<span class="label-input">Password</span>
				<div class="wrap-input">
					
					<input class="input" type="password" name="password" placeholder="Input password">
				</div>
					
				<div class="forget_password">
					<a href="#">
							Forgot password?
					</a>
				</div>

				<div class="wrap-login-form-btn">
					<input type="submit" class="login-form-btn" value="Log in">
				</div>

				<div class="register">
					<span>
						Don't have an account?
					</span>
					<a href="signUpPage.html">
						Sign up
					</a>
					</div>
			</form>
		</div>


	<!-- <?php
		if (isset($_POST["username"]))
		{
			if ($_SESSION["login"] == true){
				require 'account.php';
				$username = $_POST["username"];
				$password = $_POST["password"];
				// authenticateUser($username, $password);
				header("location: http://localhost:8888/restapi/index.php/user/authen?username=" . $username . "&password=" . $password);
			}else{
				header("location: map.html");
			}
		}
	?> -->


</body>
</html>

