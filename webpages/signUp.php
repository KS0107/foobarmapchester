<?php

require "account.php";

// Connet to the MySQL
// configuration
$host = 'dbhost.cs.man.ac.uk';
$username = 'y02478jh';
$password = 'i7JLzgM-z5zv9T';

// Create object of PDO and Catch error
try {
	$conn = new PDO("mysql:host=$host", $username, $password); 
	echo "Connected to $host successfully.";
}
catch (PDOException $pe){
	die("Could not connect to $host :" . $pe->getMessage());
}

$username = $_POST['username'];
$password = $_POST['password'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
addUser($firstname, $lastname, $username, $password);
function getUserID($Username)
{	
	$sql = "SELECT UserID
			FROM   User
			WHERE  Username = :Username";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['Username' => $Username]);
	$UserID = $stmt->fetch(PDO::FETCH_ASSOC);
	return $UserID['UserID'];
}
$newuser = getUserID($username)
public function initTimetable($userID){
	$sql = "INSERT INTO Timetable (UserID, Time)
			 VALUES 
			 (:userid, 1),
			 (:userid, 2),
			 (:userid, 3),
			 (:userid, 4)";
	 return $this->executeQuery($sql, ["userid"=>$userID]);
initTimetable($newuser)


?>