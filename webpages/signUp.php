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




?>