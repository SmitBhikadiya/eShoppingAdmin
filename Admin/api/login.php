<?php

session_start();
require_once("../handler/customerHandler.php");
$obj = new CustomerHandler();

if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $res = $obj->userLogin($username, $password);
    echo json_encode($res);
}else{
    http_response_code(404);
}


?>