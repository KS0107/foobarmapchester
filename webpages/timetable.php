<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport">
	<title>Document</title>
	<link rel="stylesheet" href="../CSS/mainstyle.css">
	<link rel="stylesheet" href="../CSS/timetable.css">
    <script src="../Javascripts/funcs.js"></script>
	<script src="../Javascripts/data.js"></script>
</head>
<body>
	<!-- Navigation Bar -->
	<div class="topBar">
        <div id="buttonLinks">
            <button id="btnHP">Home Page</button>
            <button id="btnMP">Map Page</button>
            <button id="btnRP">Review Page</button>
			<button id="btnCP">Chat</button>
            <button id="btnTP">Timetable</button>
            <button id="btnSP">Sign Out</button>
            <!-- <button id="slider">Collapse Reviews</button> -->
        </div>
    </div>
	<!-- Time Table -->
	<div id="pageBody">
		<table id="timetable" >
		  	<tr>
		    	<th>Time</th>
		    	<th>Mon</th> 
		    	<th>Tue</th>
		   		<th>Wed</th>
		  		<th>Thu</th>
		  		<th>Fri</th>
		  		<th>Sat</th>	
		  		<th>Sun</th>
			</tr>
		</table>
		<button id="btnET">Edit</button>
		<!-- <button id="btnST">Save</button> -->
		<form action="timetable.php" method="post">
    		<input id="btnST" type="submit" name="save" value="Save" />
		</form>
	</div>

</body>
</html>
<?php
function getUserID($Username)
{	
	$sql = "SELECT UserID
			FROM   User
			WHERE  Username = :Username";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['Username' => $Username]);
	$UserID = $stmt->fetch(PDO::FETCH_ASSOC);
	return $UserID['UserID'];
}
function getTimetable($UserID)
{	
	$sql = "SELECT 10am2pm, 2pm6pm, 6pm11pm, 11pm10am
			FROM   Timetable
			WHERE  TimetableID = :UserID";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(["UserID"=>$UserID]);
	$times = $stmt->fetch(PDO::FETCH_ASSOC);
	if(gettype($times) == "array"){
		setcookie("time1", $times["10am2pm"]);
		setcookie("time2", $times["2pm6pm"]);
		setcookie("time3", $times["6pm11pm"]);
		setcookie("time4", $times["11pm10am"]);
	}else{
		setcookie("time1", "1110011");
		setcookie("time2", "1101100");
		setcookie("time3", "0110011");
		setcookie("time4", "1001011");
	}
}
function setTimetable($UserID)
{	
	$sql = "SELECT 10am2pm, 2pm6pm, 6pm11pm, 11pm10am
			FROM   Timetable
			WHERE  TimetableID = :UserID";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(["UserID"=>$UserID]);
	$times = $stmt->fetch(PDO::FETCH_ASSOC);
	if(gettype($times) == "array"){
		setcookie("time1", $times["10am2pm"]);
		setcookie("time2", $times["2pm6pm"]);
		setcookie("time3", $times["6pm11pm"]);
		setcookie("time4", $times["11pm10am"]);
	}else{
		setcookie("time1", "1110011");
		setcookie("time2", "1101100");
		setcookie("time3", "0110011");
		setcookie("time4", "1001011");
	}
}
$UserID = getUserID($_COOKIE["username"]);
getTimetable($UserID);
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['save']))
{
    setTimetable($UserID);
}
?>