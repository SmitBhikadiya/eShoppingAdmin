<?php
    require_once("./handler/dbHandler.php");
    
    class AddressHandler extends DBConnection{
        public $error = '';
        
        function getCities(){}
        function getStates(){}
        function getCountries(){}

        function addCity(){}
        function addState(){}
        function addCountry(){}

        function updateCity(){}
        function updateState(){}
        function updateCountry(){}
    }
?>