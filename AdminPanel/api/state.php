<?php

session_start();
require_once("../handler/addressHandler.php");
$obj = new AddressHandler();

$states = $obj->getAllState();
if(count($states) > 0){
    echo json_encode($states);
}else{
    http_response_code(404);
}

?>