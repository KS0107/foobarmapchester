<?php
class BaseController{ 
    public function __call($name, $arguments){
        $this->sendOutput("", array("HTTP/1.1 404 Not Found"));
    }

    protected function getUriSegment(){
        $uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $uri = explode("/", $uri);

        return $uri;
    }

    protected function getQueryStringParams(){
        parse_str($_SERVER["QUERY_STRING"], $query);
        return $query;
    }

    protected function sendOutput($data, $httpHeaders, $redirect=false, $redirectValue=""){
        // header_remove("Set-Cookie");

        if(is_array($httpHeaders) && count($httpHeaders)){
            foreach($httpHeaders as $httpHeader){
                header($httpHeader);
            }
        }

        if($redirect){
            header("location:" . $redirectValue);
            exit;
        }

        echo $data;
        exit;
    }

    protected function errorHandler($strErrorDesc, $respondData, $strErrorHeader, $redirect=false, $redirectValue=""){
        if(!$strErrorDesc){
            $this->sendOutput($respondData,
            array('Content-Type: application/json', 'HTTP/1.1 200 OK'), $redirect, $redirectValue);
        }else{
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)),
            array('Content-Type: application/json', $strErrorHeader));
        }
    }
}

?>