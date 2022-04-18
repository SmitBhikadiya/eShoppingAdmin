<?php

session_start();
require_once("../handler/categoryHandler.php");
$obj = new CategoryHandler();

$cats = [];
if(isset($_GET["catid"])){
    $id = (int) $_GET["catid"];
    $cats = $obj->getSubCategoryByCategoryId($id);
}else if(isset($_GET["catname"])){
    $catname = $_GET["catname"];
    $cats = $obj->getSubCategoryByCatName($catname);
}else{
    $cats = $obj->getAllSubCategory();
}

echo json_encode(["result"=>$cats]);

?>