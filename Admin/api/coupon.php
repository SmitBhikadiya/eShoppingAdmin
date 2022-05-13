<?php

session_start();
require_once("../handler/couponHandler.php");
require_once("verifyToken.php");
$obj = new CouponHandler();

$error = '';
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $request = json_decode($postdata);
    if(isset($request->couponCode)){
        $code = $request->couponCode;
        $res = $obj->getCouponByCode($code);
        echo json_encode(["result"=>$res]);
        exit();
    }
}
//echo json_encode(["result"=>$colors]);

?>