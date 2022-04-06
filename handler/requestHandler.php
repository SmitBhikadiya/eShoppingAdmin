<?php
    require_once("addressHandler.php");

    $address = new AddressHandler();
    if(isset($_POST["countryid"])){
        $records = $address->getStatesByCountryId($_POST["countryid"]);
        echo json_encode(["states"=>$records]);
    }
?>