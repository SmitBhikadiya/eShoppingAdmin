<?php

session_start();
require_once("../handler/productHandler.php");
require_once("verifyToken.php");
$obj = new ProductHandler();

$colors = [];
$cat = (isset($_GET["cat"])) ? (($_GET["cat"]=='null') ? '' : $_GET["cat"]) : '';
$subcat = (isset($_GET["subcat"])) ? (($_GET["subcat"]=='null') ? '' : $_GET["subcat"]) : '';

if(isset($_GET["colorids"])){
    $ids = "(".$_GET["colorids"].")";
    $colors = $obj->getColorByIds($ids);
}else{
    $colors = $obj->getAllColor($cat, $subcat);
}
echo json_encode(["result"=>$colors]);

?>