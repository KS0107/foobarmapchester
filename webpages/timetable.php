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
	</div>

</body>
</html>
<?php
function getUserID($Username)
{	
	$sql = "SELECT UserID
			FROM   Timetable
			WHERE  Username = :Username";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		'UserID' => $UserID
					]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();
}
function getTimetable($UserID)
{	
	$sql = "SELECT 10am2pm, 2pm6pm, 6pm11pm, 11pm10am
			FROM   Timetable
			WHERE  UserID = :UserID";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		'10am2pm' => $time1
        '2pm6pm' => $time2
        '6pm11pm' => $time3
        '11pm10am' => $time4
					]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();
	$_SESSION['10am2pm'] = "test"
	$_SESSION['2pm6pm'] = $time2
	$_SESSION['6pm11pm'] = $time3
	$_SESSION['11pm10am'] = $time4
}
getUserID($_COOKIE["username"])
getTimetable($UserID)
?>