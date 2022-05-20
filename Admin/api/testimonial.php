<?php
    require_once("../handler/testimonialHandler.php");

    $postdata = file_get_contents("php://input");

    if(isset($postdata) && !empty($postdata)){
        $objH =new TestimonialHandler();
        $request = json_decode($postdata);
        if(isset($request->getTestmonials)){
            $res = $objH->getAllTestimonial();
            echo json_encode(["result"=>$res]);
            exit();
        }else{
            http_response_code(404);
        }
    }
?>

