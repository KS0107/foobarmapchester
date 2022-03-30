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
	<title>Logged Out</title>
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
				//update user to offline status
			try{
				$conn = new pdo("mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19", "y02478jh", "i7JLzgM-z5zv9T");
				$sql = "UPDATE User
				SET Status = :status
				WHERE UserID = :userid";
				$sql_getUserID = "SELECT UserID 
									FROM User
									WHERE Username = :username";
				$stmt1 = $conn->prepare($sql_getUserID);
				$stmt1->execute(["username"=>$_COOKIE["username"]]);
				$res = $stmt1->fetchAll(PDO::FETCH_ASSOC);
				$stmt2 = $conn->prepare($sql);
				$stmt2->execute(["status"=>"offline", "userid"=>$res[0]["UserID"]]);
				}catch(Exception $pe){
					throw New Exception($pe->getMessage());
				}
				/////////////

				//unset($_COOKIE['username']); 
				setcookie("username", "", time()-1, "/");
				//setcookie('username',"",time() - 86400); 
			}
			
			header("location: ../index.html");
		}
	?>


</body>
</html>

