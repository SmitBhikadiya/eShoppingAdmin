<?php

session_start();
require_once("../handler/productHandler.php");
$obj = new ProductHandler();

$res = [];
$load = 10;
$subcatids = '';
$colorid = '';
$sizes = '';
$priceStart = 0;
$priceEnd = 12000;
$sortby = 'latest';
$trending = '0,1';

// filtering
if(isset($_GET["subcategories"])){
    $subcatids = $_GET["subcategories"];
}
if(isset($_GET["colors"])){
    $colorid = $_GET["colors"];
}
if(isset($_GET["priceStart"]) && isset($_GET["priceEnd"])){
    $priceStart = (int) $_GET["priceStart"];
    $priceEnd = (int) $_GET["priceEnd"];
}
if(isset($_GET["sizes"])){
    $sizes = $_GET["sizes"];
}
if(isset($_GET["sortby"])){
    $sortby = $_GET["sortby"];
}
if(isset($_GET["trending"])){
    $trending = $_GET["trending"];
}

// load more products
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
        $res = $obj->getProductBySubCatName($catname, $subcatname, 0, $load, $colorid, $sizes, $subcatids, $priceStart, $priceEnd, $sortby);
    }else{
        $res = $obj->getProductByCatName($catname, 0, $load, $colorid, $sizes, $subcatids, $priceStart, $priceEnd, $sortby);
    }
}else if(isset($_GET["id"])){
    $id = (int) $_GET["id"];
    $res = $obj->getProductById($id);
}else{
    if(isset($_GET["load"])){
        $load = $_GET["load"];
    }
    $res = $obj->getProducts('', 0, $load, $colorid, $sizes, $subcatids, $priceStart, $priceEnd, $sortby, $trending);
}

echo json_encode(["result"=>$res]);


?>