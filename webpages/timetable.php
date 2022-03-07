<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport">
	<title>Document</title>
	<link rel="stylesheet" href="../CSS/mainstyle.css">
	<link rel="stylesheet" href="../CSS/timetable.css">
    <script src="../Javascripts/funcs.js"></script>
</head>
<body>
	<!-- Navigation Bar -->
	<div class="topBar">
        <div id="buttonLinks">
            <button id="btnHP">Home Page</button>
            <button id="btnMP">Map Page</button>
            <button id="btnRP">Review Page</button>
            <button id="btnTP">Timetable</button>
            <button id="btnSP">Sign Out</button>
            <!-- <button id="slider">Collapse Reviews</button> -->
        </div>
    </div>
	<!-- Time Table -->
	<div id="pageBody">
		<p>Your Timetable:</p>
		<table class="timetable" >
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
			<tr>
			    <td>Row 1</td>
			    <td>Null</td>
			    <td>Null</td> 
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
		    </tr>
			<tr>
			    <td>Row 2</td>
			    <td>Null</td>
			    <td>Null</td> 
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
		    </tr>
		    <tr>
			    <td>Row 3</td>
			    <td>Null</td>
			    <td>Null</td> 
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
		    </tr>
		    <tr>
			    <td>Row 4</td>
			    <td>Null</td>
			    <td>Null</td> 
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
			    <td>Null</td>
		    </tr>
		</table>
	</div>

</body>
</html>

