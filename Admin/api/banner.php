<?php
    require_once("../handler/bannerHandler.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $objH =new BannerHandler();
        $request = json_decode($postdata);
        if(isset($request->getBanners)){
            $res = $objH->getAllBanner();
            echo json_encode(["result"=>$res]);
            exit();
        }else{
            http_response_code(404);
        }
    }
?>

