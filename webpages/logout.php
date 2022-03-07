<?php
session_start();
if (!isset($_SESSION['login']))
{
  $_SESSION['login'] = true;
}
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
            <button id="btnSP">Sign Out</button>
        </div>
    </div>
	<div id="pageBody">
		<form class="form" method="post">

            <h1>Are you sure you want to log out?</h1>

			<div class="wrap-login-form-btn">
				<input type="submit" class="login-form-btn" value="Log out">
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
		if (isset($_POST["username"]))
		{
			$_SESSION["login"] = true;
			header("location: index.html");
		}
	?>


</body>
</html>

