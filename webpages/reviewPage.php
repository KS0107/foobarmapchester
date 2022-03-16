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
function showReviews(){
    parse_str($_SERVER["QUERY_STRING"], $query);
    echo json_encode($query);
    $servername = "dbhost.cs.man.ac.uk";
    $username = "y02478jh";
    $password = "i7JLzgM-z5zv9T";
    $dbname = "2021_comp10120_z19";
    try {
        $connection = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sqlReview = "SELECT LocationID
        FROM Location
        WHERE Name = :query";
        // $sqlReview = "SELECT date,rating,review
        // FROM Reviews
        // WHERE LocationID = $sqlReview";
        $stmt = $connection->prepare($sqlReview);
        $stmt->execute(["query"=>$query["LocationName"]]);
    } catch(PDOException $error) {
        echo "Connection failed: " . $error->getMessage();
    }
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    while($row= $stmt->fetch()){
        echo ($row["LocationID"]);
}
showReviews();
?>



$filename = "/home/csimage/Documents/Team Project/data.json";


$data = file_get_contents($filename);


$array = json_decode($data,true);


foreach ($array as $value) {

	$query = "INSERT INTO `jsoninsert` (`id`, `location`, `date`, `rating`, `review`) VALUES ('".$value['id']."', '".$value['location']."', '".$value['date']."', '".$value['rating']."', '".$value['review']."')";
	mysqli_query($con,$query);
}

echo "Data Inserted Successfully"
