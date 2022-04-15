<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$pros = [];
$load = 10;
if(isset($_GET["load"])){
    $load = $_GET["load"];
}

if(isset($_GET["catid"])){
    $id = (int) $_GET["catid"];
    $pros = $obj->getProductByCategory($id);
}else if(isset($_GET["subcatid"])){
    $id = (int) $_GET["subcatid"];
    $pros = $obj->getProductBySubCategory($id);
}else if(isset($_GET["catname"]) && $_GET["catname"]!="null"){
    $catname = strtolower($_GET["catname"]);
    if(isset($_GET["subcatname"]) && $_GET["subcatname"]!="null"){
        $subcatname = strtolower($_GET["subcatname"]);
        $pros = $obj->getProductBySubCatName($catname, $subcatname, 0, $load);
    }else{
        $pros = $obj->getProductByCatName($catname, 0, $load);
    }
}else{
    if(isset($_GET["load"])){
        $load = $_GET["load"];
    }
    $pros = $obj->getProducts('', 0, $load);
}

echo json_encode(["result"=>$pros]);


?>