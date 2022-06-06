<?php
    require_once("../handler/aboutusHandler.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $objH =new AboutusHandler();
        $request = json_decode($postdata);
        if(isset($request->aboutus)){
            $res = $objH->getContent();
            echo json_encode(["result"=>$res]);
            exit();
        }else{
            http_response_code(404);
        }
    }
?>

