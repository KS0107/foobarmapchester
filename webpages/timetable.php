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

