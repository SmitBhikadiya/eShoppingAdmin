<?php

session_start();
require_once("../handler/categoryHandler.php");
$obj = new CategoryHandler();

$cats = [];

$cats = $obj->getAllCategory();

echo json_encode(["result"=>$cats]);

?>