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

    public function getCustomName($id){
        $sql = "SELECT CustomName
                FROM User
                WHERE UserID = :id";
        return $this->executeFetchQuery($sql, ["id"=>$id])[0]["CustomName"];
    }

    public function getMessage($sender, $receiver){
        $sql = "SELECT Message.MessageBody, Message.CreateDate, Message.UserID, Message.RecipientID, User.CustomName, User.Username
                FROM Message
                LEFT JOIN User ON Message.RecipientID = User.UserID
                WHERE Message.UserID = :userid AND Message.RecipientID = :recipientid
                UNION
                SELECT Message.MessageBody, Message.CreateDate, Message.UserID, Message.RecipientID, User.CustomName, User.Username
                FROM Message
                LEFT JOIN User ON Message.UserID = User.UserID
                WHERE Message.UserID = :recipientid1 AND Message.RecipientID = :userid1
                ORDER BY CreateDate ASC";

        return $this->executeFetchQuery($sql, ["userid"=>$this->getID($sender), "recipientid"=>$this->getID($receiver),"recipientid1"=>$this->getID($receiver), "userid1"=>$this->getID($sender)]);
    }

    public function getMessageForGroupChat($receiver){
        $sql = "SELECT m.MessageBody, m.Sender as UserID, m.GroupChatID, m.CreatedDate as CreateDate, User.CustomName, User.Username
                FROM MessageForGC as m
                LEFT JOIN User ON m.Sender = User.UserID
                WHERE m.GroupChatID = :id";
        return $this->executeFetchQuery($sql, ["id"=>$receiver]);
    }

    public function storeMessage($message, $userID, $receiverID){
        $sql = "INSERT INTO Message (MessageBody, UserID, RecipientID)
                VALUES (:message, :userid, :receiverid)";
        return $this->executeQuery($sql, ["message"=>$message, "userid"=>$userID, "receiverid"=>$receiverID]);
    }

    public function storeMessageForGroupChat($message, $userID, $receiverID){
        $sql = "INSERT INTO MessageForGC (MessageBody, Sender, GroupChatID)
                VALUES (:message, :userid, :receiverid)";
        return $this->executeQuery($sql, ["message"=>$message, "userid"=>$userID, "receiverid"=>$receiverID]);
    }

    public function verifyRequestmsgP($type, $place, $date, $day){
        $sql = "SELECT RequestmsgID
                FROM Requestmsg
                WHERE 
                Type = :type AND
                Place = :place AND
                Date = :date AND
                Week = :day";
        return $this->executeFetchQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$date, "day"=>$day]);
    }

    public function pullingEventRequest($userid){
        $sql = "SELECT r.RequestmsgID, r.CreatedDate, r.Type, r.Place, r.Date, r.Week, User.Username, r.TargetID, r.requesterID, r.Status, r.Noti, r.GroupChatID
                FROM Requestmsg as r
                LEFT JOIN User on r.TargetID = User.UserID
                WHERE r.RequesterID = :userid AND r.Type = 'private'
                UNION
                SELECT r.RequestmsgID, r.CreatedDate, r.Type, r.Place, r.Date, r.Week, User.Username, r.TargetID, r.requesterID, r.Status, r.Noti, r.GroupChatID
                FROM Requestmsg as r
                LEFT JOIN User on r.RequesterID = User.UserID
                WHERE r.TargetID = :userid AND r.Type = 'private'
                UNION
                SELECT r.RequestmsgID, r.CreatedDate, r.Type, r.Place, r.Date, r.Week, User.Username, r.TargetID, r.requesterID, r.Status, r.Noti, r.GroupChatID
                FROM Requestmsg as r
                LEFT JOIN User on r.RequesterID = User.UserID
                WHERE r.TargetID = :userid AND r.Type = 'public'
                ORDER BY CreatedDate DESC";
        return $this->executeFetchQuery($sql, ["userid"=>$userid]);
    }

    public function pullingGroupChat($userid){
        $sql = "SELECT r.Place, r.Date, r.Week, r.GroupChatID
                FROM Requestmsg as r
                LEFT JOIN GroupChat as g ON r.GroupChatID = g.GroupChatID
                WHERE r.Type = 'public' AND r.TargetID = :userid AND r.Status = 'accepted' AND g.Status = 'active'";
        return $this->executeFetchQuery($sql, ["userid"=>$userid]);
    }

    public function updatePublicStatus($userid, $groupChatID){
        $sql = "UPDATE Requestmsg
                SET Status = 'accepted'
                WHERE TargetID = :userid AND GroupChatID = :groupid";
        return $this->executeQuery($sql, ["userid"=>$userid, "groupid"=>$groupChatID]);
    }

    public function verifyRequestmsg($type, $place, $date, $day, $targetid, $requesterid){
        //verify the request and return its status //for private request
        $sql = "SELECT RequestmsgID, Status
                FROM Requestmsg
                WHERE 
                Type = :type AND
                Place = :place AND
                Date = :date AND
                Week = :day AND
                ((TargetID = :targetid AND
                RequesterID = :requesterid) OR
                (TargetID = :requesterid AND
                RequesterID = :targetid)) AND
                Status = :status";
                $status = "No Response";
        return $this->executeFetchQuery($sql, ["status"=>$status, "type"=>$type, "place"=>$place, "date"=>$date, "day"=>$day,
        "targetid"=>$targetid, "requesterid"=>$requesterid]);
    }
    public function getRequestmsgIDByDP($type, $place, $time, $day, $userid, $status){
        $sql = "SELECT RequestmsgID
                FROM Requestmsg
                WHERE
                Type = :type AND
                Place <> :place AND
                Date = :date AND
                Week = :day AND
                (TargetID = :userid OR
                RequesterID = :userid) AND
                Status = :status";
        return $this->executeFetchQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$time, "day"=>$day, "userid"=>$userid, "status"=>$status]);
    }

    public function getRequestmsgIDBySP($type,$place, $time, $day, $userid, $status){
        $sql = "SELECT RequestmsgID
                FROM Requestmsg
                WHERE
                Type = :type AND
                Place = :place AND
                Date = :date AND
                Week = :day AND
                (TargetID = :userid OR
                RequesterID = :userid) AND
                Status = :status";
        return $this->executeFetchQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$time, "day"=>$day, "userid"=>$userid, "status"=>$status]);
    }

    public function getRequestmsgIDByType($userid, $type){
        $sql = "SELECT RequestmsgID
                FROM Requestmsg
                WHERE Type = :type AND TargetID = :userid";
        return $this->executeFetchQuery($sql, ["userid"=>$userid, "type"=>$type]);
    }

    public function updateRead($requestmsgid, $val){
        $sql = "UPDATE Requestmsg
                SET Noti = :val
                WHERE RequestmsgID = :requestmsgid";
        return $this->executeQuery($sql, ["val"=>$val, "requestmsgid"=>$requestmsgid]);
    }

    public function storeRequestmsg($type, $place, $date, $day, $targetid, $requesterid, $groupid=''){
        if($groupid){
            $sql = "INSERT INTO Requestmsg (Type, Place, Date, Week, TargetID, RequesterID, GroupChatID)
                VALUES (:type, :place, :date, :day, :targetid, :requesterid, :groupid)";
        return $this->executeQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$date, "day"=>$day,
        "targetid"=>$targetid, "requesterid"=>$requesterid, "groupid"=>$groupid]);
        }else{
            $sql = "INSERT INTO Requestmsg (Type, Place, Date, Week, TargetID, RequesterID)
                VALUES (:type, :place, :date, :day, :targetid, :requesterid)";
        return $this->executeQuery($sql, ["type"=>$type, "place"=>$place, "date"=>$date, "day"=>$day,
        "targetid"=>$targetid, "requesterid"=>$requesterid]);
        }
        
    }

    public function verifyEvent($userID, $time, $day){
        $sql = "SELECT $day
                FROM Timetable
                WHERE 
                UserID = :userid AND
                Time = :time";
                
        return $this->executeFetchQuery($sql, ["userid"=>$userID, "time"=>$time]);
    }

    public function addEvent($userID, $place, $time, $day){
        
        $sql = "UPDATE Timetable
                SET $day = :place
                WHERE UserID = :userid AND Time = :time";

        return $this->executeQuery($sql, ["place"=>$place, "userid"=>$userID, "time"=>$time]);
    }

    public function getInfoByGroupId($groupid){
        $sql ="SELECT Day, Time, Place
                FROM GroupChat
                WHERE GroupChatID = :id";
        return $this->executeFetchQuery($sql, ["id"=>$groupid]);
    }

    public function updateStatus($requestmsgID, $status){
        $sql = "UPDATE Requestmsg
                SET Status = :status
                WHERE RequestmsgID = :requestmsgID";
        $this->executeQuery($sql, ["status"=>$status, "requestmsgID"=>$requestmsgID]);
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

    public function updateUserStatus($userid, $status){
        $sql = "UPDATE User
                SET Status = :status
                WHERE UserID = :userid";
        return $this->executeQuery($sql, ["status"=>$status, "userid"=>$userid]);
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
        $sql = "INSERT INTO User (Firstname, Lastname, Username, Password)
                VALUES (:firstname, :lastname, :username, :password)";
        $password = password_hash($password, PASSWORD_DEFAULT);
        $this->executeQuery($sql, ["firstname"=>$firstname, "lastname"=>$lastname, "username"=>$username, "password"=>$password]);
        return true;
    }

    public function getFriend($username){
        $sql = "SELECT UserID, Username, Status, CustomName
                FROM User
                WHERE UserID IN (             
                SELECT FriendID
                FROM Friendship
                INNER JOIN User ON User.UserID = Friendship.UserID
                WHERE User.Username = :username)";
        return $this->executeFetchQuery($sql, ["username"=>$username]);
    }

    public function getFriendByFree($userid, $day, $time){
        $sql = "SELECT Username
                FROM User
                WHERE UserID in 
               (SELECT f.FriendID 
                FROM Friendship as f
                LEFT JOIN Timetable as t ON f.FriendID = t.UserID
                WHERE f.UserID = :userid AND t.Time = :time AND t.$day IS NULL
                )";
        return $this->executeFetchQuery($sql, ["userid"=>$userid, "time"=>$time]);
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
       $sql = "SELECT User.Username, Request.CreateDate, Request.Noti
               FROM Request
               LEFT JOIN User ON Request.RequesterID = User.UserID
               WHERE Request.TargetID = :userid";
       
        return $this->executeFetchQuery($sql, ["userid"=>$userid]);
   }

   public function getRequestID($userid){
       $sql = "SELECT RequestID
                FROM Request
                WHERE TargetID = :userid";
        return $this->executeFetchQuery($sql, ["userid"=>$userid]);
   }

   public function updateReadForRequest($requestid){
       $sql = "UPDATE Request
                SET Noti = 'read'
                WHERE RequestID = :requestid";
        return $this->executeQuery($sql, ["requestid"=>$requestid]);
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

   public function initTimetable($userID){
       $sql = "INSERT INTO Timetable (UserID, Time)
                VALUES 
                (:userid, 1),
                (:userid, 2),
                (:userid, 3),
                (:userid, 4)";
        return $this->executeQuery($sql, ["userid"=>$userID]);
   }

   public function getTimetable($userID){
        $sql = "SELECT Mon, Tue, Wed, Thu, Fri, Sat, Sun
                FROM   Timetable
                WHERE  UserID = :userID";
        return $this->executeFetchQuery($sql, ["userID"=>$userID]);
   }

   public function getAllUser(){
       $sql = "SELECT UserID
                FROM User";
        return $this->executeFetchQuery($sql);
   }

   public function checkReceiver($requesterid, $place, $time, $day){
        $sql = "SELECT TargetID, GroupChatID 
                FROM Requestmsg 
                WHERE RequesterID = :requesterid
                AND Place = :place
                AND Date = :time
                AND Week = :day
                AND Status = 'accepted'";
        return $this->executeFetchQuery($sql, ["requesterid"=>$requesterid, "place"=>$place, "time"=>$time, "day"=>$day]);
    }

    public function checkRequester($targetid, $place, $time, $day){
        $sql = "SELECT RequesterID, GroupChatID 
                FROM Requestmsg 
                WHERE TargetID = :targetid
                AND Place = :place
                AND Date = :time
                AND Week = :day
                AND Status = 'accepted'";
        return $this->executeFetchQuery($sql, ["targetid"=>$targetid, "place"=>$place, "time"=>$time, "day"=>$day]);
    }

   public function getTimetableIDs($username){
    $sql = "SELECT TimetableID
            FROM   Timetable
            WHERE  UserID IN (SELECT UserID 
            FROM User
            WHERE Username = :username)";
    return $this->executeFetchQuery($sql, ["username"=>$username]);
    }
   
   public function updateTimetable($timetableid, $vals){
    $sql = "UPDATE Timetable 
        SET Mon = :Mon, Tue = :Tue, Wed = :Wed, Thu = :Thu, Fri = :Fri, Sat = :Sat, Sun = :Sun
        WHERE TimetableID = :timetableid";
    return $this->executeFetchQuery($sql, ["timetableid"=>$timetableid, "Mon"=>$vals["Mon"], "Tue"=>$vals["Tue"], "Wed"=>$vals["Wed"], "Thu"=>$vals["Thu"], 
    "Fri"=>$vals["Fri"], "Sat"=>$vals["Sat"], "Sun"=>$vals["Sun"]]);
    }

    public function createGroupChat($userid, $day, $time, $place){
        $sql = "INSERT INTO GroupChat (CreatedBy, GuestID, Day, Time, Place)
                VALUES (:userid, :userid, :day, :time, :place)";
        $this->executeQuery($sql, ["userid"=>$userid, "day"=>$day, "time"=>$time, "place"=>$place]);
        return $this->conn->lastInsertId();

    }

    public function deleteFriend($userid, $targetid){
        $sql = "DELETE FROM Friendship 
                WHERE 
                (UserID = :userid AND FriendID = :friendid) OR
                (UserID = :friendid AND FriendID = :userid)";
        return $this->executeQuery($sql, ["userid"=>$userid, "friendid"=>$targetid]);
    }

    public function removeGroupChat($userid, $targetid){
        $sql = "UPDATE Requestmsg
                SET Status = 'removed'
                WHERE type = 'public' AND TargetID = :userid AND GroupChatID = :groupchatid";
        return $this->executeQuery($sql, ["userid"=>$userid, "groupchatid"=>$targetid]);
    }

    public function updateCustomname($userid, $name){
        $sql = "UPDATE User
                SET CustomName = :name
                WHERE UserID = :userid";
        return $this->executeQuery($sql, ["name"=>$name, "userid"=>$userid]);
    }

}

?>