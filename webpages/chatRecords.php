	<?php

		readRecords();
		function readRecords(){
			$sql = "SELECT date, content
					FROM chatRecords";
			$pdo = new pdo("mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19", "y02478jh", "i7JLzgM-z5zv9T");
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			while ($row = $stmt->fetch()){
	        	print("<p>" . $row['date'] . " " . $row['content'] . "</p>");
	    	}
		}
	?>

