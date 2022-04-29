<?php
require_once("../handler/tokenHandler.php");
$jwtH = new JWTTokenHandler();

// generate new accesstoken
// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);
  if($request->refreshToken){
    if(!$jwtH->isTokenExpired($request->refreshToken)){
        $iat = time();  
        $nbf = $iat + 10; 
        $exp = $iat + (60);
        $newToken = $jwtH->createToken($iat, $nbf, $exp);
        echo json_encode(["result"=>$newToken, "expiry"=>$exp]);
    }else{
        http_response_code(403);
    }
}
}


?>