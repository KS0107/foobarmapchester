<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="jQuery.css">
</head>
<body>
	<div id="wrapper">
		<div id="menu">
			<p class="welcome">Welcome, <b></b></p>
            <p class="logout"><a id="exit">Exit Chat</a></p>
		</div>

		<div id="chatbox">
		</div>

		<form name="message" method="post">
			<input type="text" id="usermsg">
			<input type="submit" id="submitmsg">
		</form>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			$("#exit").click(function(){
				var exit = confirm("Are you sure you want to end the session?");
				if(exit == true){
					window.location = 'jQuery.css';
				}
			})

			$("#submitmsg").click(function(){
				var clientmsg = $("#usermsg").val();
				$.post("post.php", {text: clientmsg});
				$("#usermsg").val("");
				return false;
			});
		

			function loadLog(){

				$.ajax({
					url: "chatRecords.php",
					cache: false,
					success: function(html){
						$("#chatbox").html(html);

						var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
		            	if(newscrollHeight > oldscrollHeight){
		                	$("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); 
						}
					}
				});
			}

			setInterval(loadLog, 100);
		});
	</script>
</body>
</html>