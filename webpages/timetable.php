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
		setcookie("10am2pm", $times["10am2pm"]);
		setcookie("2pm6pm", $times["2pm6pm"]);
		setcookie("6pm11pm", $times["6pm11pm"]);
		setcookie("11pm10am", $times["11pm10am"]);
	}else{
		setcookie("10am2pm", "1110011");
		setcookie("2pm6pm", "1101100");
		setcookie("6pm11pm", "0110011");
		setcookie("11pm10am", "1001011");
	}
}
function setTimetable($UserID)
{	
	if(isset($_COOKIE["10am2pm"])) {
		$time1 = $_COOKIE["10am2pm"];
		$time2 = $_COOKIE["2pm6pm"];
		$time3 = $_COOKIE["6pm11pm"];
		$time4 = $_COOKIE["11pm10am"];
	}
	$sql = "UPDATE Timetable
			SET 10am2pm = :time1, 2pm6pm = :time3, 6pm11pm = :time3, 11pm10am = :time4
			WHERE TimetableID = :UserID";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(["UserID"=>$UserID, "time1"=>$time1, "time2"=>$time2, "time3"=>$time3, "time4"=>$time4]);
	$times = $stmt->fetch(PDO::FETCH_ASSOC);
}
$UserID = getUserID($_COOKIE["username"]);
getTimetable($UserID);
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['save']))
{
    setTimetable($UserID);
}
?>