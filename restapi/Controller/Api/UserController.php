<?php
class UserController extends BaseController{ 
    private $strErrorDesc;
    private $strErrorHeader;
    private $requestMethod;
    private $arrQueryStringParams;

    public function __construct(){
        $this->strErrorDesc = "";
        $this->strErrorHeader = "";
        $this->requestMethod = $_SERVER["REQUEST_METHOD"];
        $this->arrQueryStringParams = $this->getQueryStringParams(); 
    }

    public function readAction(){
        if(strtoupper($this->requestMethod) == "GET"){
            try{
                $userModel = new UserModel();
                $data = $userModel->readChatRecord();
                $respondData = json_encode($data);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage(). 'Something went wrong! Please contact support.';
                $this->strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function authenAction(){
        $redirectBool = true;
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $username = $_POST["username"];
                $passwrod = $_POST["password"];
                $userModel = new UserModel();
                if($userModel->verifyUser($username)){
                    $redirectBool = $userModel->authentication($username, $passwrod);
                    if($redirectBool){
                        $URL = "../../../webpages/home.html";
                        $respondData = "";
                    }else{
                        $URL = "../../../webpages/loginPage.php";
                        $respondData = json_decode("Password is wrong!");
                    }
                }else{
                    $URL = "../../../webpages/loginPage.php";
                    $respondData = json_decode("Username is not valid!");
                }
 
                
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }


        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader, $redirectBool, $URL);
        
    }

    public function deleteAction(){
        if(strtoupper($this->requestMethod) == "GET"){
            try{
                $userModel = new UserModel();
                $userModel->deleteChatRecord();
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        $this->errorHandler($this->strErrorDesc, "", $this->strErrorHeader);
    }

    public function addUserAction(){
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $username = $_POST['username'];
                $passwrod = $_POST['password'];
                $userModel = new userModel();
                $bool = $userModel->addUser($firstname, $lastname, $username, $passwrod);
                $userID = $userModel->getID($username);
                $userModel->initTimetable($userID);
                if($bool){
                    $redirectBool = true;
                    $URL = "../../../webpages/loginPage.php";
                    $this->errorHandler($this->strErrorDesc, "", $this->strErrorHeader, $redirectBool, $URL);
                }
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        $this->errorHandler($this->strErrorDesc, "", $this->strErrorHeader);
    }

    public function getFriendAction(){
        try{
            if(strtoupper($this->requestMethod) == "GET"){
                $userModel = new UserModel();
                $respondData = $userModel->getFriend($this->arrQueryStringParams["username"]);
                $respondData = json_encode($respondData);
            }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        }catch(Error $e){
            $this->strErrorDesc = $e->getMessage();
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function getMessageAction(){
        try{
            if(strtoupper($this->requestMethod) == "GET"){
                $userModel = new UserModel();
                $additionalInfo = array("Sender"=>$userModel->getID($_COOKIE['username']), "Reciver"=>$userModel->getID($this->arrQueryStringParams["receiver"]));
                $respondData = $userModel->getMessage($_COOKIE['username'], $this->arrQueryStringParams["receiver"]);
                $respondData = json_encode(array($additionalInfo, $respondData));
            }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        }catch(Error $e){
            $this->strErrorDesc = $e->getMessage();
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }

        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function msgInAction(){
        try{
            if(strtoupper($this->requestMethod) == "POST"){
                    $msg = $_POST["text"];
                    $receiver = $_POST["receiver"];
                    $sender = $_POST["sender"];
                    $userModel = new UserModel();
                    $userModel->storeMessage($msg, $userModel->getID($sender), $userModel->getID($receiver));
            }else{
                $this->strErrorDesc = 'Method not supported';
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }

        }catch(Error $e){
            $this->strErrorDesc = $e->getMessage();
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
    }

    public function getUserByAction(){
        try{
            if(strtoupper($this->requestMethod) == "POST"){
                $segment = $_POST["segment"];
                $userModel = new UserModel();
                $userID = $userModel->getID($_COOKIE["username"]);
                $res = $userModel->getUsersByInput($userID, $segment);
                $respondData = json_encode($res);
            }else{
                $this->strErrorDesc = 'Method not supported';
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }catch(Error $e){
            $this->strErrorDesc = $e->getMessage();
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function friendRequestAction(){
        try{
            if(strtoupper($this->requestMethod) == "POST"){
                $requester = $_POST["requester"];
                $target = $_POST["target"];
                $userModel = new UserModel;
                $requester = $userModel->getID($requester);
                $target = $userModel->getID($target);
                $userModel->sendRequest($requester, $target);
            }else{
                $this->strErrorDesc = 'Method not supported';
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }catch(Erroe $e){
            $this->strErrorDesc = $e->getMessage();
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, "", $this->strErrorHeader);
    }

    public function retrieveRequestAction(){
        try{
            if(strtoupper($this->requestMethod) == "GET"){
                $userModel = new UserModel;
                $res = $userModel->retrieveRequest($userModel->getID($_COOKIE["username"]));
                $respondData = json_encode($res);
            }else{
                $this->strErrorDesc = 'Method not supported';
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }catch(Error $e){
            $this->strErrorDesc = $e->getMessage();
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function requestYesAction(){
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $userModel = new UserModel;
                $usernameID = $userModel->getID($_POST["user"]);
                $friendnameID = $userModel->getID($_POST["friendname"]);
                //friendship process
                $userModel->requestYes($usernameID, $friendnameID);
                //request deletion
                $userModel->requestDel($usernameID, $friendnameID);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, "", $this->strErrorHeader);
    }

    public function requestNoAction(){
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $userModel = new UserModel;
                $usernameID = $userModel->getID($_POST["user"]);
                $friendnameID = $userModel->getID($_POST["friendname"]);
                //request deletion
                $userModel->requestDel($usernameID, $friendnameID);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, "", $this->strErrorHeader);
    }

    public function showReviewsAction(){
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $location = $_POST["LocationName"];
                $userModel = new UserModel;
                $res = $userModel->showReviews($location);
                $respondData = json_encode($res);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function getPlacesAction(){
        if(strtoupper($this->requestMethod) == "GET"){
            try{
                $userModel = new UserModel;
                $res = $userModel->showPlaces();
                $respondData = json_encode($res);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function sendRequestAction(){
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $type = $_POST["type"];
                $place = $_POST["place"];
                $date = $_POST["date"];
                switch($date){
                    case "10am-2pm": $time = 1; break;
                    case "2pm-6pm": $time = 2; break;
                    case "6pm-11pm": $time = 3; break;
                    case "11am-10am": $time = 4; break;
                }
                $day = $_POST["day"];
                $userModel = new UserModel;
                $respondData = "";
                $requesterid = $userModel->getID($_COOKIE["username"]);
                $respondData1 = "";
                $respondData2 = "";
                if($type == "private"){// if public, default $friends to all users
                    $friends = explode(",", $_POST["friends"]);
                    for($i = 0; $i < sizeof($friends); $i++){
                        $targetid = $userModel->getID($friends[$i]);
                        // check if there is such a request
                        if(!empty($userModel->verifyRequestmsg($type, $place, $date, $day, $targetid, $requesterid))){
                            // the request already exists
                            
                            $respondData1 .= $friends[$i] . " ";
                        // check if the target ID free on that date
                        }elseif(is_null($userModel->verifyEvent($requesterid, $time, $day)[0][$day]) && is_null($userModel->verifyEvent($targetid, $time, $day)[0][$day])){
                            $respondData2 .= $friends[$i] . " ";
                            // this stores requestmsg
                            $userModel->storeRequestmsg($type, $place, $date, $day, $targetid, $requesterid);
                        }else{
                            $respondData = "you or your friends are busy on the date";
                            // case there is no such request and targetID are free
                        }
                    }
                }else{ //public request 
                    if(!empty($userModel->verifyRequestmsgP($type, $place, $date, $day))){
                        // the request already exists
                        $respondData = "the public request has been already made by someone, go to public request box to join the group chat!!";
                    }else{
                        $respondData = "the public request has just been created by you!!";
                        $userModel->storeRequestmsg($type, $place, $date, $day, 0, $requesterid);
                    }
                }
                if(!empty($respondData2)){$respondData = "made successfully for " . $respondData2;}
                if(!empty($respondData1)){$respondData = $respondData . " the request already exists for " . $respondData1;}
                $respondData = json_encode($respondData);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function getEventRequestAction(){
        
        if(strtoupper($this->requestMethod) == "GET"){
            try{
                $username = $_COOKIE["username"];
                $userModel = new UserModel;
                $res = $userModel->pullingEventRequest($userModel->getID($username));
                $res = array($userModel->getID($_COOKIE["username"]), $res);
                $respondData = json_encode($res);
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function addEventAction(){
        
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $userModel = new UserModel;
                $requesterID = $_POST["requesterID"];
                $requestmsgID = $_POST["requestmsgID"];
                $userID = $userModel->getID($_COOKIE["username"]);
                $place = $_POST["place"];
                $date = $_POST["time"];
                switch($date){
                    case "10am-2pm": $time = 1; break;
                    case "2pm-6pm": $time = 2; break;
                    case "6pm-11pm": $time = 3; break;
                    case "11am-10am": $time = 4; break;
                }
                $day = $_POST["day"];
                if((!is_null($userModel->verifyEvent($userID, $time, $day)[0][$day]) && !is_null($userModel->verifyEvent($requesterID, $time, $day)[0][$day])) || ($userModel->verifyEvent($userID, $time, $day)[0][$day] != $place && $userModel->verifyEvent($requesterID, $time, $day)[0][$day] != $palce)){
                    //event already hold for the time
                    $respondData = "you or your friends already have an event at the time";
                }else{
                    if(is_null($userModel->verifyEvent($userID, $time, $day)[0][$day])){
                        // add event to it
                        $userModel->addEvent($userID, $place, $time, $day);
                        $userModel->addEvent($requesterID, $place, $time, $day);
                        //update other request with the same as decline response or busy status
                        $userModel->updateStatus($requestmsgID, "accepted");
                        $respondData = "you just made an event to timetable!!";

                        // update other requests' status as busy for those having the same date
                        // get the requestmsgID by userid
                        $status = "No Response"; // get the requestmsg which not responded
                        $requestmsg = $userModel->getRequestmsgIDByDP("private", $place, $date, $day, $userID, $status);
                        for($i = 0; $i < sizeof($requestmsg); $i++){
                            $userModel->updateStatus($requestmsg[$i]["RequestmsgID"], "busy");
                        }
                        $requestmsg = $userModel->getRequestmsgIDByDP("private", $place, $date, $day, $requesterID, $status);
                        for($i = 0; $i < sizeof($requestmsg); $i++){
                            $userModel->updateStatus($requestmsg[$i]["RequestmsgID"], "busy");
                        }
                    }else{
                        $requestmsg = $userModel->getRequestmsgIDBySP("private", $place, $date, $day, $requesterID, $status);
                        for($i = 0; $i < sizeof($requestmsg); $i++){
                            $userModel->updateStatus($requestmsg[$i]["RequestmsgID"], "accepted");
                        }
                    }
                }
                
                
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }

    public function declineRequestAction(){
        
        if(strtoupper($this->requestMethod) == "POST"){
            try{
                $userModel = new UserModel;
                $requestmsgID = $_POST["requestmsgID"];
                $status = "decline";
                $userModel->updateStatus($requestmsgID, $status);
                $respondData = "you have declined the request~~";
            }catch(Error $e){
                $this->strErrorDesc = $e->getMessage();
                $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
            }
        }else{
            $this->strErrorDesc = 'Method not supported';
            $this->strErrorHeader = 'HTTP/1.1 422 Unprocessable Entity';
        }
        $this->errorHandler($this->strErrorDesc, $respondData, $this->strErrorHeader);
    }
}
?>