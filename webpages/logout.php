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
		<form method="post">

            <h1>Are you sure you want to log out?</h1>

			<input type="submit" name="button1" class="button" value="Log out">

		</form>
	</div>

	<?php
		if(array_key_exists("button1", $_POST)){
            button1();
        }
        function button1(){
			$_SESSION["login"] = true;
			header("location: ../index.html");
		}
	?>


</body>
</html>
