<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="chatFunc.js"></script>
	<link rel="stylesheet" type="text/css" href="//../CSS/mainstyle.css">
	<link rel="stylesheet" type="text/css" href="chatFunc.css">
</head>
<body>
	<div class="mainContainer">
		<div class="friendList">
			<h2>Friends</h2>
			<div id="friends"></div>
		</div>

		<button class="deletemsg" id="delete">Delete</button>
        <button class="logout" id="exit">Exit</button>
		<button id="friendboxbtn">FriendBox</button>

		<div id="chatbox"></div>
		
		<form name="message" method="post">
			<input type="text" id="usermsg"></input>
			<button id="send">Send</button>
		</form>

		<!-- <iframe id="friendbox" src="friend.html"  title=""></iframe> -->
	</div>
</body>
</html>