<?php

	
    $date = date("g:i A");
    $text = $_POST["text"];
    $sender = "unknown";
    record($date, $text, $sender);



    function record($date, $text, $sender){
			$sql = "INSERT INTO chatRecords (date, content, sender)
					VALUES (:date, :content, :sender)";
			$pdo = new pdo('mysql:host=localhost; dbname=myDB', 'root', 'root');
			$stmt = $pdo->prepare($sql);
			$stmt->execute([
							"date" => $date,
							"content" => $text,
							"sender" => $sender
			]);
		}

     
    // $text_message = "<div class='msgln'><span class='chat-time'>". date("g:i A") . "</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
     
    // file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);

?>