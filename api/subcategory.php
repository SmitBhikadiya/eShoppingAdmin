<?php

session_start();
require_once("../handler/categoryHandler.php");
$obj = new CategoryHandler();

$cats = $obj->getAllSubCategory();
if(count($cats) > 0){
    echo json_encode($cats);
}else{
    http_response_code(404);
}

?>