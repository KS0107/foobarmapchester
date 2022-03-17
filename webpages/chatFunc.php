<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="../Javascripts/chatFunc.js"></script>
	<script type="text/javascript"src="../Javascripts/funcs.js"></script>
	<link rel="stylesheet" type="text/css" href="../CSS/chatFunc.css">
</head>
<body>
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
	<h2 id="title">Chatbox</h2>
	<div class="friendList">
		<h2>Friends</h2>
		<div id="friends">
			
		</div>
	</div>

		<button class="deletemsg" id="delete">Delete</button>
        <button class="logout" id="exit">Exit</button>

		<div id="chatbox"></div>
		<!-- <iframe id="friendbox" src="friend.html"  title=""></iframe> -->
		<form autocomplete="off" name="message" method="post">
			<input autocomplete="false" id="input" type="text"></input>
			<button id="send">Send</button>
		</form>

</body>
</html>