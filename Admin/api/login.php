<?php

session_start();
require_once("../handler/customerHandler.php");
require_once('../handler/tokenHandler.php');
$obj = new CustomerHandler();
$jwtH = new JWTTokenHandler();

if($_SERVER["REQUEST_METHOD"]=='POST' && isset($_POST["username"]) && isset($_POST["password"])){
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $res = $obj->userLogin($username, $password);
    if(count($res) > 0){
        $issuer_claim = "localhost"; 
        $audience_claim = "audience";
        $issuedat_claim = time();  
        $notbefore_claim = $issuedat_claim + 10; 
        $expire_claim = $issuedat_claim + (60*15); 
        $access_token = $jwtH->createToken($issuedat_claim, $notbefore_claim, $expire_claim, $res[0]);
        $refresh_token = $jwtH->createToken($issuedat_claim, $notbefore_claim, $expire_claim + (60*60*24) - (60*15));
        echo json_encode(
            array(
                "error"=>false,
                "message"=>"success",
                "access_token"=>$access_token,
                "refresh_token"=>$refresh_token,
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
    exit();
}else{
    echo json_encode(
        array(
            "error"=>true,
            "message"=>"Invalid Request!!!"
        ));
}
