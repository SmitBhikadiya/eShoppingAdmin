<?php

session_start();
require_once("../handler/addressHandler.php");
$obj = new AddressHandler();

$countries = $obj->getAllCountry();
echo json_encode(["result"=>$countries]);

?>