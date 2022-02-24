<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport">
	<title>Document</title>
	<style type="text/css">
	/* navigation css */
		.topnav {
			padding: 15px;
		 	background-color: #730C98;
  			overflow: hidden;
		}

		.topnav a
		{	
			color: #121013;
			text-decoration: none;
			padding: 14px 16px;
			font-size: 23px;       
		}

		.topnav a:hover {
 			background-color: #ddd;
  			color: black;
		}

		.active
		{
			background-color: #860AC2;
		}
	/* timetable css */
		.timetable, th, td
		{
			border: 1px solid;
			text-align: center;
		}

		.timetable
		{
			table-layout: fixed;
			margin-left: auto;
			margin-right: auto;
			border-collapse: collapse;
			width: 50%;                  
		}

		th, td
		{
			height: 50px;
			overflow-wrap: break-word;
		}
	</style>
</head>
<body>
	<?php
		
		if ($_SESSION["login"] == "logined"){
			header("location: loginPage.php");
		}
		else{
			session_destroy();
		}
 	?>
	<!-- Navigation Bar -->
	<div class="topnav" style="text-align: center; ">
		<a class="active" href="">Home</a>
  		<a href="">Map</a>
		<a href="">Plans</a>
		<a href="">About</a>
		<a href="">Sign In</a>
	</div>
	<!-- Time Table -->
	<div>
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

