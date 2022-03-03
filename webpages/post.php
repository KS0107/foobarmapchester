<?php

	
    $date = date("g:i A");
    $text = $_POST["text"];
    $sender = "unknown";
    record($date, $text, $sender);



    function record($date, $text, $sender){
			$sql = "INSERT INTO ChatRecords (Date, Content, Sender)
					VALUES (:date, :content, :sender)";
			$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
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