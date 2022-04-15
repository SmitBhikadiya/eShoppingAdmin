<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$colors = $obj->getAllColor();
if(count($colors) > 0){
    echo json_encode($colors);
}else{
    http_response_code(404);
}

?>