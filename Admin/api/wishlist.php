<?php
    require_once("../handler/wishlistHandler.php");
    require_once("verifyToken.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $obj = new WishlistHandler();
        $request = (array)json_decode($postdata);
        if(isset($request['getWish']) && isset($request['userId'])){
            $userId = (int) $request['userId'];
            $res = $obj->getAllWishListBy($userId);
            echo json_encode(['result'=>$res]);
            exit();
        }else if(isset($request['addWish']) && isset($request['userId']) && isset($request['productId'])){
            $userId = $request['userId'];
            $productId = $request['productId'];
            $error = $obj->addWish($userId, $productId);
            echo json_encode(['error'=>$error]);
            exit();
        }else if(isset($request['removeWish']) && isset($request['wishId'])){
            $wishId = $request['wishId'];
            $error = $obj->deleteWish($wishId);
            echo json_encode(['error'=>$error]);
            exit();
        }
    }
?>