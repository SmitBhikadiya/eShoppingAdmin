<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$sizes = $obj->getAllSize();
if(count($sizes) > 0){
    echo json_encode($sizes);
}else{
    http_response_code(404);
}

?>