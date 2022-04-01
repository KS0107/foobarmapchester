<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="../Javascripts/chatFunc.js"></script>
	<script type="text/javascript"src="../Javascripts/generalScripts.js"></script>
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
	<h2 id="title">Chat</h2>
	<div class="flex-container">
		<div class="friendList">
			<div id="friend-bar">
				<div><button id="privateChat">Friends</button></div>
				<div><button id="publicChat">Group</button></div>
				<!-- <div id="friend-tag"><h2>Friends</h2></div> -->
				<div id="add-friend"><a id="ibtn"></a></div>
				<div id="delete-friend"><a id="dbtn"></a></div>
			</div>
			<!-- <button class="deletemsg" id="delete">Delete</button>
			<button class="logout" id="exit">Exit</button> -->
			<div id="friends" style="position: relative;"><img src="../images/Bean.gif" alt="" style="width: 165px; height: 120px; position: absolute; top: 4em; left: 25%;"><h3 style="position: absolute; top: 10em; left: 37%;">Loading . . .</h3></div>
			<div id="groupChat" style="position: relative;"><img src="../images/Bean.gif" alt="" style="width: 165px; height: 120px; position: absolute; top: 4em; left: 25%;"><h3 style="position: absolute; top: 10em; left: 37%;">Loading . . .</h3></div>
		</div>
		<div id="chatbox-wrapper">
		<div id="friend-name"></div>
			<div id="chatbox" style="position: relative;"></div>
			<form autocomplete="off" name="message" method="post" style="display: flex;">
				<span><input autocomplete="false" id="input" type="text"></input></span>
				<div><button id="send">Send</button></div>
				
			</form>
			<button id="request">Make a request</button>
		</div>
		<div id="setting-warapper">
			<div id="setting">1</div>
			<div id="CustonNameField" style="display: none;">
				<form method="post" onsubmit="return false;"> 
					<label for="customName" style="color: white;">Custom Name</label>
					<input type="text" name="CustomName" id="CustomNameInput">
					<input type="submit" id="CustomNamebtn">
				</form>
			</div>		
		</div>
	</div>
	
	<div id="friendbox-container">
		<iframe id="friendbox" src="friend.html"  title=""></iframe>
		<div id="close1"></div>
	</div>

	<div id="requestbox-container">
		<iframe id="requestbox" src="requestForm.html"></iframe>
		<div id="close2"></div>
	</div>
	<script>
		document.getElementById("add-friend").addEventListener("click", function(){
			document.getElementById("friendbox-container").style.display = "block";
		});

		document.getElementById("close1").addEventListener("click", function(){
			document.getElementById("friendbox-container").style.display = "none";
		});

		document.getElementById("request").addEventListener("click", function(){
			document.getElementById("requestbox-container").style.display = "block";
		});

		document.getElementById("close2").addEventListener("click", function(){
			document.getElementById("requestbox-container").style.display = "none";
		});

		document.getElementById("privateChat").addEventListener("click", function(){
			document.getElementById("groupChat").style.display = "none";
			document.getElementById("friends").style.display = "block";
		});

		document.getElementById("publicChat").addEventListener("click", function(){
			document.getElementById("friends").style.display = "none";
			document.getElementById("groupChat").style.display = "block";
		});
	</script>
</body>
</html>