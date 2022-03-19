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
        if(strtoupper($this->requestMethod) == "GET"){
            try{
                $userModel = new userModel();
                $bool = $userModel->addUser($this->arrQueryStringParams["firstname"], $this->arrQueryStringParams["lastname"], $this->arrQueryStringParams["username"], $this->arrQueryStringParams["password"]
            );
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
}
?>