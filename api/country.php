<?php

session_start();
require_once("../handler/addressHandler.php");
$obj = new AddressHandler();

$countries = $obj->getAllCountry();
if(count($countries) > 0){
    echo json_encode($countries);
}else{
    http_response_code(404);
}

?>