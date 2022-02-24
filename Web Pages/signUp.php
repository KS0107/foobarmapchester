<?php

require "account.php";

// Connet to the MySQL
// configuration
$host = 'localhost';
$username = 'root';
$password = 'root';

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
addUser($username, $password);




?>