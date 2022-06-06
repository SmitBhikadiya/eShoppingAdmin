<?php

require_once("../handler/newsletterHandler.php");

$error = '';
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
    $obj = new NewsletterHandler();
    $request = (array) json_decode($postdata);
    if(isset($request['email'])){
        $email = $request['email'];
        $error = $obj->newsletterSubscribe($email);
        echo json_encode(["error"=>$error]);
        exit();
    }else{
        http_response_code(404);
    }
}
//echo json_encode(["result"=>$colors]);

?>