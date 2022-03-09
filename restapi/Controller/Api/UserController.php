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
        if(strtoupper($this->requestMethod) == "GET"){
            try{
                $userModel = new UserModel();

                if($userModel->verifyUser($this->arrQueryStringParams["username"])){
                    $redirectBool = $userModel->authentication($this->arrQueryStringParams["username"], $this->arrQueryStringParams["password"]);
                    if($redirectBool){
                        $respondData = "";
                    }else{
                        $respondData = json_decode("Password is wrong!");
                    }
                }else{
                    $respondData = json_decode("Username is not valid!");
                }
 
                $URL = "/manchester/webpages/map.html";
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
                    $URL = "https://web.cs.manchester.ac.uk/y02478jh/manchester/webpages/loginPage.php";
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
                $userModel = new userModel();
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
                $userModel = new userModel();
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
}
?>