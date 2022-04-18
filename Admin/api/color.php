<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$colors = [];
if(isset($_GET["colorids"])){
    $ids = "(".$_GET["colorids"].")";
    $colors = $obj->getColorByIds($ids);
}else{
    $colors = $obj->getAllColor();
}
echo json_encode(["result"=>$colors]);

?>