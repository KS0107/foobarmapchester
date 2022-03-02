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
?>



$filename = "/home/csimage/Documents/Team Project/data.json";


$data = file_get_contents($filename);


$array = json_decode($data,true);


foreach ($array as $value) {

	$query = "INSERT INTO `jsoninsert` (`id`, `location`, `date`, `rating`, `review`) VALUES ('".$value['id']."', '".$value['location']."', '".$value['date']."', '".$value['rating']."', '".$value['review']."')";
	mysqli_query($con,$query);
}

echo "Data Inserted Successfully"
