<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="chatFunc.js"></script>
	<link rel="stylesheet" type="text/css" href="chatFunc.css">
</head>
<body>
	<div class="mainContainer">
	<div class="friendList">
		<div>Friends</div>
		<div id="friends" style="border: solid;">
			
		</div>
	</div>

	<div id="wrapper">
		<button class="deletemsg" id="delete">Delete</button>
        <button class="logout" id="exit">Exit</button>

		<div id="chatbox"></div>
		
		<form name="message" method="post">
			<input type="text" id="usermsg">
			<input type="submit" id="submitmsg" value="Send">
		</form>
		</div>	
	</div>
</body>
</html>