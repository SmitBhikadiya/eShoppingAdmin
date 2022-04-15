<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$pros = [];

if(isset($_GET["catid"])){
    $id = (int) $_GET["catid"];
    $pros = $obj->getProductByCategory($id);
}else if(isset($_GET["subcatid"])){
    $id = (int) $_GET["subcatid"];
    $pros = $obj->getProductBySubCategory($id);
}else{
    $pros = $obj->getAllProduct();
}

if(count($pros) > 0){
    echo json_encode($pros);
}else{
    http_response_code(404);
}

?>