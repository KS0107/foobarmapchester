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

   public function getUsersByInput($seg){
       $sql = "SELECT Username
                FROM User
                WHERE Username LIKE :seg";
                $seg .= "%";
        return $this->executeFetchQuery($sql, ["seg"=>$seg]);
   } 

    
}

?>