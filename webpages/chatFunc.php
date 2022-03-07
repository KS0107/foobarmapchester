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
	<div id="wrapper">
		<div id="menu">
			<p class="welcome">Welcome, <b></b></p>
			<p class="deletemsg"><a id="delete">Delete</a>
            <p class="logout"><a id="exit">Exit Chat</a></p>
		</div>

		<div id="chatbox">
		</div>

		<form name="message" method="post">
			<input type="text" id="usermsg">
			<input type="submit" id="submitmsg" value="Send">
		</form>
	</div>

</body>
</html>