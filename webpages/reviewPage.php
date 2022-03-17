<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Review Page</title>
    <link rel="stylesheet" href="../CSS/mainstyle.css">
    <script src="../Javascripts/funcs.js"></script>
    <script src="../Javascripts/data.js"></script>
</head>
<body>
    <div class="topBar">
        <div id="buttonLinks">
            <button id="btnHP">Home Page</button>
            <button id="btnMP">Map Page</button>
            <button id="btnRP">Review Page</button>
            <button id="btnCP">Chat</button>
            <button id="btnTP">Timetable</button>
            <button id="btnSP">Sign Out</button>
        </div>
    </div>
    <div id="pageBody">
        <h4>Enter your review</h4>
        <form action="reviewPage.php" method="post">
            <div class="formBox">
                <p>Location</p>
                <select id="locations" name="locations">
                </select>
            </div>
            <div class="formBox">
                <p>Rating</p>
                <input type="range" id="rating" max="5" min="1" step="1" name="rating"/>
            </div>
            <div class="formBox">
                <p>Review</p>
                <textarea style="resize:none" type="text" id="review" placeholder="Write your review!" name="review"></textarea>
            </div>
            <div class="formBox">
                <input id="btnRP" type="submit" name="submit" value="Submit" />
            </div>
    		
            
        </form>
    </div>
</body>
</html>

<?php
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
function getLocID($LocationName)
{	
	$sql = "SELECT LocationID
            FROM Location
            WHERE Name = :locationName";
	$pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute(['locationName' => $LocationName]);
	$LocationID = $stmt->fetch(PDO::FETCH_ASSOC);
    if(gettype($LocationID)=="array"){
        return $LocationID['LocationID'];
    }else{
        return NULL;
    }
}
function addReview($UserID, $LocationID)
{	
    $rating = $_POST["rating"];
    $review = $_POST["review"];
    $date = date("Y-m-d");
	$sql = "INSERT INTO Reviews (UserID, LocationID, date, rating, review) 
            VALUES (:UserID, :LocationID, :date, :rating, :review)";
    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
	$stmt = $pdo->prepare($sql);
	$stmt->execute([
        "UserID" => $UserID, 
        "LocationID" => $LocationID, 
        "date" => $date,
        "rating" => $rating, 
        "review" => $review
    ]);
}
$UserID = getUserID($_COOKIE["username"]);
loadLocations();
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['submit']))
{
    $LocationID = getLocID($_POST["location"]);
    addReview($UserID, $LocationID);
}
function loadLocations(){
    $sql = "SELECT *
            FROM  Location";

    $pdo = new pdo('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $stmt = $pdo->prepare($sql);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$row = $stmt->fetch();
    echo '<div id='.$row['LocationID'].' style="display:none">'.$row['Name'].",".$row['Coords'].'</div>';
    foreach ($stmt as $row)
    {
        echo '<div id='.$row['LocationID'].' style="display:none">'.$row['Name'].",".$row['Coords'].'</div>';
    }
}
?>