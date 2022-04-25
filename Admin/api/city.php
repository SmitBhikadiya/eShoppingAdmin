<?php

session_start();
require_once("../handler/addressHandler.php");
$obj = new AddressHandler();

$cities = [];

if(isset($_GET["stateid"])){
    $cities = $obj->getCitiesByStateId($_GET["stateid"]);
}else{
    $cities = $obj->getAllCity();
}

echo json_encode(["result"=>$cities]);


?>