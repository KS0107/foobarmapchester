<?php 

require_once PROJECT_ROOT_PATH . "/Model/Database.php";

class UserModel extends Database{
    // ########## Message #############
    public function readChatRecord(){
        $sql = "SELECT Date, Content
					FROM ChatRecords";
        return $this->executeFetchQuery($sql);
    }

    public function deleteChatRecord(){
        $sql = "DELETE FROM ChatRecords";
        $this->executeQuery($sql);
        return true;
    }

    public function getMessage($sender, $receiver){
        $sql = "SELECT MessageBody, CreateDate, UserID, RecipientID
                FROM Message
                WHERE UserID = :userid AND RecipientID = :recipientid
                UNION
                SELECT MessageBody, CreateDate, UserID, RecipientID
                FROM Message
                WHERE UserID = :recipientid1 AND RecipientID = :userid1
                ORDER BY CreateDate ASC";

        return $this->executeFetchQuery($sql, ["userid"=>$this->getID($sender), "recipientid"=>$this->getID($receiver),"recipientid1"=>$this->getID($receiver), "userid1"=>$this->getID($sender)]);
    }

    public function storeMessage($message, $userID, $receiverID){
        $sql = "INSERT INTO Message (MessageBody, UserID, RecipientID)
                VALUES (:message, :userid, :receiverid)";
        return $this->executeQuery($sql, ["message"=>$message, "userid"=>$userID, "receiverid"=>$receiverID]);
    }

    public function verifyRequestmsgP($type, $place, $date){
        $sql = "SELECT RequestmsgID
                FROM Requestmsg
                WHERE 
                Type = :type AND
                Place = :place AND
                Date = :date";
        return $this->executeFetchQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$date]);
    }

    public function pullingEventRequest($userid){
        $sql = "SELECT r.RequestmsgID, r.CreatedDate, r.Type, r.Place, r.Date, User.Username, r.requesterID, r.Status
                FROM Requestmsg as r
                LEFT JOIN User on r.TargetID = User.UserID
                WHERE r.RequesterID = :userid AND r.Type = 'private'
                UNION
                SELECT r.RequestmsgID, r.CreatedDate, r.Type, r.Place, r.Date, User.Username, r.requesterID, r.Status
                FROM Requestmsg as r
                LEFT JOIN User on r.RequesterID = User.UserID
                WHERE r.TargetID = :userid AND r.Type = 'private'
                UNION
                SELECT r.RequestmsgID, r.CreatedDate, r.Type, r.Place, r.Date, User.Username, r.requesterID, r.Status
                FROM Requestmsg as r
                LEFT JOIN User on r.RequesterID = User.UserID
                WHERE r.Type = 'public'
                ORDER BY CreatedDate DESC";
        return $this->executeFetchQuery($sql, ["userid"=>$userid]);
    }

    public function verifyRequestmsg($type, $place, $date, $targetid, $requesterid){
        //verify the request and return its status //for private request
        $sql = "SELECT RequestmsgID
                FROM Requestmsg
                WHERE 
                Type = :type AND
                Place = :place AND
                Date = :date AND
                (TargetID = :targetid AND
                RequesterID = :requesterid) OR
                (TargetID = :requesterid AND
                RequesterID = :targetid)";
        return $this->executeFetchQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$date, 
        "targetid"=>$targetid, "requesterid"=>$requesterid]);
    }

    public function storeRequestmsg($type, $place, $date, $targetid, $requesterid){
        $sql = "INSERT INTO Requestmsg (Type, Place, Date, TargetID, RequesterID)
                VALUES (:type, :place, :date, :targetid, :requesterid)";
        return $this->executeQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$date, 
        "targetid"=>$targetid, "requesterid"=>$requesterid]);
    }

    // ########### Authentication #############
    public function authentication($username, $password){
        $sql = "SELECT Password
                FROM User
                WHERE Username=:Username";
        $result = $this->executeFetchQuery($sql, ["Username"=>$username]);
        
        if(password_verify($password, $result[0]["Password"])){
            $this->setCookie($username, time() + 86400);
            echo "successfully logged in";
            return true;
        }else{
            return false;
        }
    
    }

    public function verifyUser($username){
        $sql = "SELECT Username
                FROM User
                WHERE Username = :username";
        $resultSet = $this->executeFetchQuery($sql, ["username"=>$username]);
        if($resultSet){
            return true;
        }else{
            return false;
        }
    }

    // ################# functionalities #####################
    public function setCookie($cookieValue, $duration){
        // if(!isset($_COOKIE["username"])){
            setcookie("username", $cookieValue, $duration, "/");
            return true;
        // }else{
        //     return false;
        // }
    }

    public function addUser($firstname, $lastname, $username, $password){
        $sql = "INSERT INTO User(Firstname, Lastname, Username, Password)
                VALUES (:firstname, :lastname, :username, :password)";
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->executeQuery($sql, ["firstname"=>$firstname, "lastname"=>$lastname, "username"=>$username, "password"=>$password]);
        return true;

    }

    public function getFriend($username){
        $sql = "SELECT Username
                FROM User
                WHERE UserID IN (             
                SELECT FriendID
                FROM Friendship
                INNER JOIN User ON User.UserID = Friendship.UserID
                WHERE User.Username = :username)";
        return $this->executeFetchQuery($sql, ["username"=>$username]);
    }

    public function getID($username){
        $sql = "SELECT UserID 
                FROM User
                WHERE Username = :username";
        return $this->executeFetchQuery($sql, ["username"=>$username])[0]["UserID"];
    }

    public function getUsernameById($id){
        $sql = "SELECT Username
                FROM User
                Where UserID = :id";
        return $this->executeFetchQuery($sql, ["id"=>$id]);
    } 

   public function getUsersByInput($userID, $seg){
       $sql = "SELECT Username
                FROM User
                WHERE Username LIKE :seg AND UserID NOT IN 
                (SELECT FriendID
                 FROM Friendship
                 WHERE UserID = :userid) AND UserID <> :userid";
                $seg .= "%";
        return $this->executeFetchQuery($sql, ["seg"=>$seg, "userid"=>$userID]);
   } 

   public function sendRequest($requester, $target){
       $sql = "INSERT INTO Request (RequesterID, TargetID)
                VALUES (:requesterid, :targetid)";
        return $this->executeQuery($sql, ["requesterid"=>$requester, "targetid"=>$target]);
   }


   public function retrieveRequest($userid){
       $sql = "SELECT User.Username, Request.CreateDate
               FROM Request
               LEFT JOIN User ON Request.RequesterID = User.UserID
               WHERE Request.TargetID = :userid";
       
        return $this->executeFetchQuery($sql, ["userid"=>$userid]);
   }

   public function requestYes($usernameID, $friendnameID){
        $sql = "INSERT INTO Friendship (FriendID, UserID)
                VALUES 
                (:fid, :uid),
                (:uid, :fid)";
        return $this->executeQuery($sql, ["fid"=>$friendnameID, "uid"=>$usernameID]);
   }

   public function requestDel($usernameID, $friendnameID){
       $sql = "DELETE FROM Request
                WHERE RequesterID = :fid AND TargetID = :uid";
        return $this->executeQuery($sql, ["fid"=>$friendnameID, "uid"=>$usernameID]);
   }

   public function showReviews($locationName){
       $sql = "SELECT date,rating,review
               FROM Reviews
               WHERE LocationID IN 
               (SELECT LocationID
               FROM Location
               WHERE Name = :locationName)";
   
        return $this->executeFetchQuery($sql, ["locationName"=>$locationName]);
   }

   public function showPlaces(){
        $sql = "SELECT Name
               FROM Location";
        return $this->executeFetchQuery($sql);
   }

}
?>