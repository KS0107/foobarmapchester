<?php
function addUser($firstname, $lastname, $username, $password)
{	// insert username and password into users table  
	$sql = "INSERT INTO User (First name, Last name, Username, Password) 
			VALUES (:firstname, :lastname, :username, :password)";
	// connect to the database
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	// Set  attributes
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); 
	// Hash password
	$password = password_hash($password, PASSWORD_DEFAULT);
	// Execution Part. This prevents SQL injection; 
	//提供给预处理语句的参数不需要用引号括起来, ，驱动程序会自动处理。
	$stmt = $pdo->prepare($sql);
	// bind parameters with variables
	$stmt->execute([
	                    'firstname' => $firstname,
	                    'lastname' => $lastname,
						'username' => $username,
						'password' => $password
						]);
}

function showDatabases()
{
   $sql = "SHOW DATABASES";
   $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk;',
                 'y02478jh', 'i7JLzgM-z5zv9T');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
   $stmt = $pdo->prepare($sql);
   $stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
   while ($row = $stmt->fetch())
   {
        print("<h3>" . $row['Database'] . "</h3>");
    }
}

function authenticateUser($username, $password) 
{	
	$sql = "SELECT password
			FROM   User
			WHERE  Username = :Username";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
		'Username' => $username
					]);
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();
	if (password_verify($password, $row['password'])){ 
		$_SESSION['login'] = "logined";
		header("location: timetable.php");
	}
	else{
		session_destroy();
		header("location: loginPage.php");
	}
}
?>