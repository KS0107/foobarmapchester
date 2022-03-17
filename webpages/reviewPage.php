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
                <input type="text" id="location" placeholder="Location" />
            </div>
            <div class="formBox">
                <p>Rating</p>
                <input type="range" id="rating" max="5" min="1" step="1" />
            </div>
            <div class="formBox">
                <p>Review</p>
                <textarea style="resize:none" type="text" id="review" placeholder="Write your review!" ></textarea>
            </div>
            <div class="formBox">
                <input id="btnRP" type="submit" name="save" value="Save" />
            </div>
    		
            
        </form>
    </div>
</body>
</html>

<?php
function addReview($id, $location, $date, $rating, $review)
{	 
    $servername = "mysql:host=dbhost.cs.man.ac.uk";
    $username = "y02478jh";
    $password = "i7JLzgM-z5zv9T";
    $dbname = "2021_comp10120_z19";

    $conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "INSERT INTO `Reviews` (`id`, `location`, `date`, `rating`, `review`) VALUES ('".$value['id']."', '".$value['location']."', '".$value['date']."', '".$value['rating']."', '".$value['review']."')";
}
if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['save']))
{
    addR($UserID);
}
?>