<?php

session_start();
require_once("../handler/productHandler.php");
require_once("verifyToken.php");
$obj = new ProductHandler();

$sizes = [];
$cat = (isset($_GET["cat"])) ? (($_GET["cat"]=='null') ? '' : $_GET["cat"]) : '';
$subcat = (isset($_GET["subcat"])) ? (($_GET["subcat"]=='null') ? '' : $_GET["subcat"]) : '';

if(isset($_GET["sizeids"])){
    $ids = "(".$_GET["sizeids"].")";
    $sizes = $obj->getSizeByIds($ids);
}else if(isset($_GET["catName"])){
    $cat = $_GET["catName"];
    $sizes = $obj->getAllSizeByCat($cat);
}else{
    $sizes = $obj->getAllSize($cat, $subcat);
}

echo json_encode(["result"=>$sizes]);
?>