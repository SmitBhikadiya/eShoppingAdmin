<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;

class JWTTokenHandler{

    private $secret_key='eShopperApp';

    function createToken($iss, $aud, $iat, $exp, $data=array()){
        $token = array("iss" => $iss, "aud" => $aud, "iat" => $iat, "exp" => $exp, "data" => $data);
        return JWT::encode($token, $this->secret_key, 'HS256');
    }

    function validateToken($token){
        try{
            JWT::decode($token, $this->secret_key, array('HS256'));
            return true;
        }catch(Throwable $e){
            return false;
        }
    }

    function decodeToken($token){
        try{
            return JWT::decode($token, $this->secret_key, array('HS256'));
        }catch(Throwable $e){
            return false;
        }
    }
}

?>