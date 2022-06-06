<?php
    require_once("../handler/productHandler.php");
    require_once("verifyToken.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $obj = new ProductHandler();
        $request = json_decode($postdata);
        if(isset($request->getReview) && isset($request->productId) && isset($request->userId)){
            $prdId = (int) $request->productId;
            $userId = (int) $request->userId;
            $res = $obj->getReviewByIds($prdId, $userId);
            echo json_encode(["result"=>$res]);
            exit();
        }else if(isset($request->getProReview) && isset($request->productId)){
            $prdId = (int) $request->productId;
            $res = $obj->getReviewsByProduct($prdId);
            echo json_encode(["result"=>$res]);
            exit();
        }else if(isset($request->getReview) && isset($request->reviewId)){
            $id = (int) $request->reviewId;
            $res = $obj->getReviewById($id);
            echo json_encode(["result"=>$res]);
            exit();
        }else if(isset($request->setReview) && isset($request->productId) && isset($request->userId)){
            $prdId = (int) $request->productId;
            $userId = (int) $request->userId;
            $rating = (int) $request->rating;
            $review = $request->review;
            $res = $obj->addReview($userId, $prdId, $rating, $review);
            echo json_encode($res);
            exit();
        }else if(isset($request->updateReview) && isset($request->reviewId)){
            $id = (int) $request->reviewId;
            $rating = (int) $request->rating;
            $review =  $request->review;
            $error = $obj->updateReview($id, $rating, $review);
            echo json_encode(["error"=>$error]);
            exit();
        }else if(isset($request->deleteReview) && isset($request->reviewId)){
            $id = (int) $request->reviewId;
            $error = $obj->deleteReview($id) ? '' : 'Somthing went wrong while deleting!!';
            echo json_encode(["error"=>$error]);
            exit();
        }else{
            http_response_code(404);
        }
    }
?>