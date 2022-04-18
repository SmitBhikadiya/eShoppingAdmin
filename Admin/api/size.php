<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$sizes = [];
if(isset($_GET["sizeids"])){
    $ids = "(".$_GET["sizeids"].")";
    $sizes = $obj->getSizeByIds($ids);
}else{
    $sizes = $obj->getAllSize();
}

echo json_encode(["result"=>$sizes]);
?>