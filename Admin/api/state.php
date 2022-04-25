<?php

session_start();
require_once("../handler/addressHandler.php");
$obj = new AddressHandler();

$states = [];

if(isset($_GET["countryid"])){
    $states = $obj->getStatesByCountryId($_GET["countryid"]);
}else{
    $states = $obj->getAllState();
}

echo json_encode(["result"=>$states]);

?>