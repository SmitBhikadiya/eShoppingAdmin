<?php

session_start();
require_once("../handler/customerHandler.php");
require_once("verifyToken.php");
$obj = new CustomerHandler();

if(isset($_GET["username"])){
    $res = $obj->getUserByUsername(trim(strtolower($_GET["username"])));
    echo json_encode(["result"=>$res]);
    exit();
}

if(isset($_GET["email"])){
    $res = $obj->getUserByEmail(trim(strtolower($_GET["email"])));
    echo json_encode(["result"=>$res]);
    exit();
}

if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $firstname = trim($_POST["firstname"]);
    $lastname = trim($_POST["lastname"]);
    $gender = trim($_POST["gender"]);
    $mobile = trim($_POST["mobile"]);
    $phone = trim($_POST["phone"]);
    $email = trim($_POST["email"]);
    $res = $obj->userRegister($username, $password, $firstname, $lastname, $gender, $mobile, $phone, $email);
    echo json_encode($res);
}else{
    http_response_code(404);
}


?>