<?php

    try{
        $conn = new pdo("mysql:host=dbhost.cs.man.ac.uk; dbname=2021_comp10120_z19", "y02478jh", "i7JLzgM-z5zv9T");
        $sql = "UPDATE User
        SET Status = :status
        WHERE UserID = :userid";
        $sql_getUserID = "SELECT UserID 
                            FROM User
                            WHERE Username = :username";
        $stmt1 = $conn->prepare($sql_getUserID);
        $stmt1->execute(["username"=>$_COOKIE["username"]]);
        $res = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $stmt2 = $conn->prepare($sql);
        $stmt2->execute(["status"=>"offline", "userid"=>$res[0]["UserID"]]);
        }catch(Exception $pe){
            throw New Exception($pe->getMessage());
        }

?>