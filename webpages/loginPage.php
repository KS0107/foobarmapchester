<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="../CSS/mainstyle.css">
	<script src="../Javascripts/funcs.js"></script>
</head>
<body>
	<div class="topBar">
        <div id="buttonLinks">
            <button id="btnHP">Home Page</button>
            <button id="btnMP">Map Page</button>
            <button id="btnRP">Review Page</button>
            <button id="btnTP">Timetable</button>
            <button id="btnLP">Sign In</button>
        </div>
    </div>
	<div id="pageBody">
		<form class="form" method="post">
			

			<div class="wrap-input">
				<span class="label-input">Username</span>
				<input class="input" type="text" name="username" placeholder="Type your username">
			</div>

			<div class="wrap-input">
				<span class="label-input">Password</span>
				<input class="input" type="password" name="password" placeholder="Type your password">
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
					Don't have an account ?
				</span>
				<a href="signUpPage.html">
					Sign up
				</a>
			</div>

		</form>
	</div>

	<?php
		$_SESSION["login"] = "login";
		if ($_SESSION["login"] == 'login'){
			require 'account.php';
			$username = $_POST["username"];
			$password = $_POST["password"];
			//echo "<div> debugging1 </div>";
			authenticateUser($username, $password);
		}
	?>


</body>
</html>

