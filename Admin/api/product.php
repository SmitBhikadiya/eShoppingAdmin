<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$res = [];
$load = 10;
if(isset($_GET["load"])){
    $load = $_GET["load"];
}

if(isset($_GET["catid"])){
    $id = (int) $_GET["catid"];
    $res = $obj->getProductByCategory($id);
}else if(isset($_GET["subcatid"])){
    $id = (int) $_GET["subcatid"];
    $res = $obj->getProductBySubCategory($id);
}else if(isset($_GET["catname"]) && $_GET["catname"]!="null"){
    $catname = strtolower($_GET["catname"]);
    if(isset($_GET["subcatname"]) && $_GET["subcatname"]!="null"){
        $subcatname = strtolower($_GET["subcatname"]);
        $res = $obj->getProductBySubCatName($catname, $subcatname, 0, $load);
    }else{
        $res = $obj->getProductByCatName($catname, 0, $load);
    }
}else if(isset($_GET["id"])){
    $id = (int) $_GET["id"];
    $res = $obj->getProductById($id);
}else if(isset($_GET["sizeids"])){
    $ids = "(".$_GET["sizeids"].")";
    $res = $obj->getSizeByIds($ids);
}else if(isset($_GET["colorids"])){
    $ids = "(".$_GET["colorids"].")";
    $res = $obj->getColorByIds($ids);
}else{
    if(isset($_GET["load"])){
        $load = $_GET["load"];
    }
    $res = $obj->getProducts('', 0, $load);
}

echo json_encode(["result"=>$res]);


?>