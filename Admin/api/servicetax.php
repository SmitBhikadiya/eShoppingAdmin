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
}

echo json_encode(["result"=>$tax]);


?>