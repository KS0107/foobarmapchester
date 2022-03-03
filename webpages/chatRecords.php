	<?php

		readRecords();
		function readRecords(){
			$sql = "SELECT date, content
					FROM chatRecords";
			$pdo = new pdo("mysql:host=localhost; dbname=myDB", "root", "root");
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			while ($row = $stmt->fetch()){
	        	print("<p>" . $row['date'] . " " . $row['content'] . "</p>");
	    	}
		}
	?>

