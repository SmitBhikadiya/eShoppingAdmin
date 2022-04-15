<?php

session_start();
require_once("../handler/addressHandler.php");
$obj = new AddressHandler();

$cities = $obj->getAllCity();
if(count($cities) > 0){
    echo json_encode($cities);
}else{
    http_response_code(404);
}

?>