<?php
	$ch = curl_init();
	$URI = "https://web.cs.manchester.ac.uk/y02478jh/restapi/index.php/user/read";

	curl_setopt($ch, CURLOPT_URL, $URI);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	
	$responce = curl_exec($ch);
	$responce = json_decode($responce);
	
	foreach($responce as $value){
			echo "<p>" . get_object_vars($value)["Date"] . "<br>" . get_object_vars($value)["Content"] . "</p>";
	}
	?>

