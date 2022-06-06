<?php

session_start();
require_once("../handler/TaxHandler.php");
require_once("verifyToken.php");
$obj = new TaxHandler();

$tax = 0;

if(isset($_GET["stateId"]) && isset($_GET["countryId"])){
    $countryId = $_GET["countryId"];
    $stateId = $_GET["stateId"];
    $tax = $obj->getTaxByState($stateId, $countryId);
    echo json_encode(["result"=>$tax]);
    exit();
}else if(isset($_GET['getcountries'])){
    $records = $obj->getTaxRegistredCountry();
    echo json_encode(["result"=>$records]);
    exit();
}else if(isset($_GET['getstates']) && isset($_GET['countryId'])){
    $id = (int) $_GET["countryId"];
    $records = $obj->getTaxRegistredStateByCoutry($id);
    echo json_encode(["result"=>$records]);
    exit();
}else{
    http_response_code(404);
}


?>