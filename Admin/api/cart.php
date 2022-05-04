<?php

session_start();
require_once("../handler/cartHandler.php");
require_once("verifyToken.php");
$obj = new CartHandler();

$postdata = file_get_contents("php://input");
$error = '';

if (isset($postdata) && !empty($postdata)) {

    $request = json_decode($postdata);

    if (isset($request->removeId)) {
        $cartId = (int) $request->removeId;
        $error = $obj->removeFromCart($cartId);
        echo json_encode(["error"=>$error]);
    }else if (isset($request->cartId) && isset($request->userId)) {
        $cartId = (int) $request->cartId;
        $userId = (int) $request->userId;
        $colorId = (int) $request->color;
        $sizeId = (int) $request->size;
        $qty = (int) $request->qty;
        $subtotal = (int) $request->subtotal;
        $error = $obj->updateCart($cartId, $colorId, $sizeId, $qty, $subtotal);
        echo json_encode(["error"=>$error]);
    }else if (isset($request->product) && isset($request->userId)) {
        $product = $request->product;
        $userId = $request->userId;
        $colorId = $request->color;
        $sizeId = $request->size;
        $qty = $request->qty;
        $subtotal = $request->subtotal;
        $productImg = explode(",",($product->productImages))[0];
        $res = $obj->addToCart($product->id, $userId, $product->productName, $colorId, $sizeId, $productImg, $product->productPrice, $qty, $subtotal);
        echo json_encode($res);
    }else if(isset($request->userId)){
        $userId = (int) $request->userId;
        $res = $obj->getCartItems($userId);
        echo json_encode(["result"=>$res]);
    }else if(isset($request->removeCart)){
        $userId = (int) $request->removeCart;
        $error = $obj->removeCart($userId);
        echo json_encode(["error"=>$error]);
    }else if(isset($request->prdId) && isset($request->userId_)){
        $userId = (int) $request->userId_;
        $prdId = (int) $request->prdId;
        $res = $obj->getCartItemBy($userId, $prdId);
        echo json_encode(["result"=>$res]);
    }else {
        http_response_code(404);
    }
}else{
    http_response_code(202);
}
