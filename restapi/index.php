<?php
require_once __DIR__ . "/inc/bootstrap.php";

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode( '/', $uri );

$userI = 5;
$methodI = $userI + 1;

if ((isset($uri[$methodI]) && $uri[$userI] != 'user') || !isset($uri[$methodI])) {
    header("HTTP/1.1 404 Not Found");
    exit();
}


require PROJECT_ROOT_PATH . "/Controller/Api/UserController.php";

$objFeedController = new UserController();
$strMethodName = $uri[$methodI] . 'Action';
$objFeedController->{$strMethodName}();

?>