<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Main Page</title>
    <link rel="stylesheet" href="../CSS/mainstyle.css">
    <link rel="stylesheet" href="../CSS/mapstyle.css">
    <script src="../Javascripts/funcs.js"></script>
    <script src="../Javascripts/data.js"></script>
    <script src="../Javascripts/mapScripts.js" defer></script>
    <link href='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.css' rel='stylesheet' />
    <script src='https://api.mapbox.com/mapbox-gl-js/v2.7.0/mapbox-gl.js'></script>
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
            <!-- <button id="slider">Collapse Reviews</button> -->
        </div>
    </div>
    <div id="reviewBar">
        <form>
            
            <p id="locationName">Select A Location</p>
            <div class="lightDark">
                <button id="lightD" type="button">Light Mode</button>
            </div>
            <div id="msg">
                <pre></pre>
            </div>
        </form>

    </div>
    <div id='map'></div>
</body>
</html>

<?php
    //open connection to mysql db
    $connection = mysqli_connect('mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19', 'y02478jh', 'i7JLzgM-z5zv9T') or die("Error " . mysqli_error($connection));

    //fetch table rows from mysql db
    $sql = "SELECT *
            FROM   Location";
    $result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

    //create an array
    $emparray = array();
    while($row =mysqli_fetch_assoc($result))
    {
        $emparray[] = $row;
    }
    
    echo json_encode($emparray);
    //$fp = fopen('empdata.json', 'w');
    //fwrite($fp, json_encode($emparray));
    //fclose($fp);

    //close the db connection
    mysqli_close($connection);
?>