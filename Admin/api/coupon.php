<?php

session_start();
require_once("../handler/couponHandler.php");
require_once("verifyToken.php");

$error = '';
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $obj = new CouponHandler();
    $request = json_decode($postdata);
    if(isset($request->couponCode)){
        $code = $request->couponCode;
        $res = $obj->getCouponByCode($code);
        echo json_encode(["result"=>$res]);
        exit();
    }else if(isset($request->availiablity)){
        $availiablity = $request->availiablity;
        $res = $obj->getCouponByAvailiablity($availiablity);
        echo json_encode(["result"=>$res]);
        exit();
    }
}
//echo json_encode(["result"=>$colors]);

?>