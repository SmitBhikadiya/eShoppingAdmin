<?php

session_start();
require_once("../handler/orderHandler.php");
require_once("verifyToken.php");
$obj = new OrderHandler();

$postdata = file_get_contents("php://input");
$error = '';

if (isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);
    if(isset($request->cartItems)  && isset($request->userId) && isset($request->checkoutData)){
        $cartItems = $request->cartItems;
        $userId = $request->userId;
        $session = ((array)$request->checkoutData);
        $sessionId = $session["id"];
        $couponId = isset($request->discountData) ? ((array)$request->discountData)['id'] : "NULL";
        $subTotal = $session["amount_subtotal"]/100;
        $total = $session["amount_total"]/100;
        $taxId = ((array)$request->taxData)["id"];
        //echo json_encode([$cartItems, $userId, $sessionId, $subTotal, $taxId, $couponId, $total, 0, 0]);
        $res = $obj->createOrder($cartItems, $userId, $sessionId, $subTotal, $taxId, $couponId, $total, 0, 0);
        echo json_encode($res);
        exit();
    }else if(false){
        
    }
    else if (isset($request->getAll)) {
        $userId = (int) $request->getAll;
        $res = $obj->getAllOrdersBy($userId);
        echo json_encode(["result"=>$res]);
        exit();
    }else if(isset($request->getBy) && isset($request->userId)){
        $ordId = (int) $request->getBy;
        $userId = (int) $request->userId;
        $res = $obj->getOrderByIds($userId, $ordId);
        echo json_encode(["result"=>$res]);
        exit();
    }else if(isset($request->setPayment) && isset($request->userId) && isset($request->couponData)){
        $ordId = (int) $request->setPayment;
        $userId = (int) $request->userId;
        $couponData = $request->couponData;
        $error = $obj->setOrderPayment($userId, $ordId, $couponData);
        echo json_encode(["error"=>$error]);
        exit();
    }else if(isset($request->removeOrder) && isset($request->userId) && isset($request->ifpayment)){
        $ordId = (int) $request->removeOrder;
        $userId = (int) $request->userId;
        $ifpayment = (int) $request->ifpayment;
        $error = $obj->removeOrderIf($userId, $ordId, $ifpayment);
        echo json_encode(["error"=>$error]);
        exit();
    }else if(isset($request->getHistory)){
        $userId = (int) $request->getHistory;
        $res = $obj->getOrdersHistoryBy($userId);
        echo json_encode(["result"=>$res]);
        exit();
    }
    else{
        http_response_code(404);
    }
}else{
    http_response_code(202);
}
