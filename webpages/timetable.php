<?php
function ($Username)
{	
	$sql = "SELECT UserID
			FROM   Timetable
			WHERE  Username = :Username";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		'UserID' => $UserID
					]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();
}
{	
	$sql = "SELECT 10am2pm, 2pm6pm, 6pm11pm, 11pm10am
			FROM   Timetable
			WHERE  UserID = :UserID";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		'10am2pm' => $time1
        '2pm6pm' => $time2
        '6pm11pm' => $time3
        '11pm10am' => $time4
					]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();
}
?>