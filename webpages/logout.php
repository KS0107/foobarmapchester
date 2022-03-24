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
	<script src="../Javascripts/generalScripts.js"></script>
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
		<form method="post">

            <h1>Are you sure you want to log out?</h1>

			<input type="submit" name="LogOut" class="button" value="Log out">

		</form>
	</div>

	<?php
		if(array_key_exists("LogOut", $_POST)){
            LogOut();
        }
        function LogOut(){
			$_SESSION["login"] = true;
			if (isset($_COOKIE['username'])) {
				//unset($_COOKIE['username']); 
				setcookie("username", "", time()-1, "/");
				//setcookie('username',"",time() - 86400); 
			}
			header("location: ../index.html");
		}
	?>


</body>
</html>

