<?php

class Database{ 

    protected $conn = null;

    public function __construct(){
        try{
            $this->conn = new pdo("mysql:host=" . HOST . "; dbname=" . DBNAME, USERNAME, PASSWORD);    
        }catch(Exception $pe){
            die("Could not connect to localhost :" . $pe->getMessage());
        }
    }

    public function executeQuery($sql = "", $bindParams = []){
        try{
            $stmt = $this->conn->prepare($sql);

            if(!$stmt){
                throw New Exception("Unable to do prepared statement: " . $sql);
            }

            if($bindParams){

                $stmt->execute($bindParams);
            }else{
                $stmt->execute();
            }
            
            return $stmt;
        }catch(Exception $pe){
            throw New Exception($e->getMessage());
        }
    }   

    public function executeFetchQuery($sql = "", $bindParams = []){
        try {
            $stmt = $this->executeQuery($sql, $bindParams);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }catch(Exceptipn $e){
            throw New Exception($e->getMessage());
        }
        return false;
    }
}


?>