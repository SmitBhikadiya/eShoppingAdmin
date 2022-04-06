<?php
    require_once("dbHandler.php");
    
    class AddressHandler extends DBConnection{
        
        function getCities(){
            $sql = "SELECT cities.*, states.state, countries.country FROM cities JOIN states ON cities.stateId=states.id JOIN countries ON countries.id=cities.countryId";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }
        function getStates(){
            $sql = "SELECT states.*, countries.country FROM states JOIN countries ON countries.id=states.countryId";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }
        function getCountries(){
            $sql = "SELECT * FROM countries";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }
        function getStatesByCountryId($countryid){
            $sql = "SELECT states.*, countries.country FROM states JOIN countries ON countries.id=states.countryId WHERE states.countryId=$countryid";
            $result = $this->getConnection()->query($sql);
            $records = [];
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    array_push($records, $row);
                }
            }else{
                $records = [];
            }
            return $records;
        }

        function addCity($countryid, $stateid, $city){
            $sql = "INSERT INTO cities (city, stateId, countryId, createdDate) VALUES ('$city', $stateid, $countryid, now())";
            $result = $this->getConnection()->query($sql);
            return ($result) ? true:false;
        }
        function addState(){}
        function addCountry(){}

        function updateCity(){}
        function updateState(){}
        function updateCountry(){}
    }
?>