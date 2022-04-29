<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");
require_once('../vendor/autoload.php');
use Firebase\JWT\JWT;

class JWTTokenHandler{

    private $secret_key='eShopperApp';
    private $iss = "localhost";
    private $aud = "audience";

    function createToken($iat, $nbf, $exp, $data=array()){
        $token = array("iss" => $this->iss, "aud" => $this->aud, "iat" => $iat, "nbf" => $nbf, "exp" => $exp, "data" => $data);
        return JWT::encode($token, $this->secret_key, 'HS256');
    }

    function isTokenExpired($token){
        $token_payload = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $token)[1]))));
        $current_time = time();
        $expiry_time = $token_payload->exp;
        if($current_time >= $expiry_time){
            return true;
        }
        return false;
    }

    function decodeToken($token){
        try{
            return JWT::decode($token, $this->secret_key, array('HS256'));
        }catch(Throwable $e){
            return false;
        }
    }
}
