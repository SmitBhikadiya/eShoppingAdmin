<?php

session_start();
require_once("../handler/customerHandler.php");
require_once('../handler/tokenHandler.php');
$obj = new CustomerHandler();
$jwtH = new JWTTokenHandler();

if(isset($_POST["username"]) && isset($_POST["password"])){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $res = $obj->userLogin($username, $password);
    if(count($res) > 0){
        $secret_key = "eShopperAdmin";
        $issuer_claim = "localhost"; 
        $audience_claim = "audience";
        $issuedat_claim = time();  
        $notbefore_claim = $issuedat_claim + 10; 
        $expire_claim = $issuedat_claim + 60; 
        $token = $jwtH->createToken($issuer_claim, $audience_claim, $issuedat_claim, $expire_claim, $res[0]);
        echo json_encode(
            array(
                "error"=>false,
                "message"=>"success",
                "access_token"=>$token,
                "user"=>$res[0],
                "expiry"=>$expire_claim
            ));
    }else{
        echo json_encode(
            array(
                "error"=>true,
                "message"=>"Username or password are incorrect"
            ));
    }
}else{
    http_response_code(404);
}
