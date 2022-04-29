<?php

require_once("../handler/tokenHandler.php");
$jwtH = new JWTTokenHandler();

if(isset(apache_request_headers()["access_token"])){
    try{
        $access_token = apache_request_headers()["access_token"];
        if($access_token!=''){
            if($jwtH->isTokenExpired($access_token)){
                http_response_code(401);
            }
        }
        //echo json_encode(["crt_time"=>$current_time, "exp_time"=>$expiry_time]);
    }catch(Throwable $e){
        http_response_code(404);
    }
}

?>